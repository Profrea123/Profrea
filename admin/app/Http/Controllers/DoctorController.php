<?php

namespace App\Http\Controllers;

use App\DoctorTimeSlot;
use App\User;
use App\BookingDetail;
use App\Attachment;
use App\Holiday;
use App\Models\Chat_box;
use App\Models\Vital;
use App\Models\Medical_history;
use App\Models\Test;
use App\Models\Dr_notes;
use App\Models\Condition;
use App\Models\Medicine;
use App\Models\Patient_condition; 
use App\Models\Patient_medication;
use App\Models\Patient_test;
use App\Models\Instruction;
use App\Models\Followup;
use App\Models\Followup_logs;
use App\Models\Calender;
use App\Models\Prescription;
use App\Models\Tab_redirection;

use Illuminate\Http\Request; 
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

use App\Classes\Model\Database;
use App\Classes\RealEstate\Spaces;
// require_once ('vendor/autoload.php');

// $this->db_conn = new Database;

class DoctorController extends Controller
{
    public function __construct()
    {
        $this->middleware('web');
        $this->tab_redirection = new Tab_redirection;
    }

    /**
     * User listing
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function testinsert(){
        
        $data = array(
            'user_id' => 25,
            'doctor_id' => 30,
            'active_tab' => 1,
            'complete_tab' => 1,

        );
        $result = $this->tab_redirection->insert_tab_redirection($data);
        if($result){
            echo 'inserted';
        }else{
            echo 'not inserted';
        }
    }

    public function index(Request $request)
    {
        $users = User::select('users.*','gender.name as gender_name','city.name as city_name','operating_specialty.name as speciality_name')
            ->leftJoin('gender', 'gender.id', '=', 'users.gender_id')
            ->leftJoin('city', 'city.id', '=', 'users.city')
            ->leftJoin('operating_specialty', 'operating_specialty.id', '=', 'users.speciality')
            ->where('users.profession_id', 5)
            ->when($request->name, function($query) use ($request) {
                $query->where('users.name','like','%'.$request->name.'%');
            })
            ->when($request->email, function($query) use ($request) {
                $query->where('users.email','like','%'.$request->email.'%');
            })
            ->when($request->phone, function($query) use ($request) {
                $query->where('users.mobileNo','like','%'.$request->phone.'%');
            })
            ->orderBy('users.id', 'DESC')
            ->paginate(10);
        return view('admin.user.user', compact('users'));
    }

    private function get_user_session($userid){
        $result = User::select('users.*','website_details.*','gender.name as gender_name','city.name as city_name','operating_specialty.name as speciality_name')
        ->leftJoin('gender', 'gender.id', '=', 'users.gender_id')
        ->leftJoin('city', 'city.id', '=', 'users.city')
        ->leftJoin('website_details', 'website_details.user_id', '=', 'users.id')
        ->leftJoin('operating_specialty', 'operating_specialty.id', '=', 'users.speciality')
        ->where('users.id', $userid)->first();
        return $result;
    }

    private function tab_redirect($active_tab){
        $booking_no = Session::get('booking_no');
        $redirectionArr = array(
            1 => '/doctor/patient-case/'.$booking_no,
            2 => '/doctor/patient-chief-complaints',
            3 => '/doctor/patient-history-view',
            4 => '/doctor/patient-health-view',
            5 => '/doctor/patient-notes-view',
            6 => '/doctor/patient-condition-view',
            7 => '/doctor/patient-medicine-view',
            8 => '/doctor/patient-diagnosis-view',
            9 => '/doctor/patient-followup-view',
            10 => '/doctor/patient-advice-view',
        ); 
        return redirect()->to($redirectionArr[$active_tab]);
    }

    public function update_redirection($active_tab){
        if($active_tab){
            $booking_no = Session::get('booking_no');
            $data = array('active_tab'=>$active_tab);
            $this->tab_redirection->update_tab_redirection($data, $booking_no);
        }
        $redirectDetails = $this->tab_redirection->get_one_record($booking_no);
        //print_r($redirectDetails);exit;
        return $this->tab_redirect($redirectDetails->active_tab);
    }

    public function patient_case(Request $request, $booking_no)
    {
        $booking_details = BookingDetail::join('users', 'booking_details.user_id', '=', 'users.id')
        ->where('booking_details.booking_no', $booking_no)->first();
        $login_id = $booking_details->user_id;
        $row_user = $this->get_user_session($login_id);
        if(Session::get('user_id')){
            Session::forget('user_id'); 
            Session::forget('doctor_id'); 
            Session::forget('booking_no'); 
        }
        if(!Session::get('user_id')){
            Session::put('user_id',$booking_details->user_id);
            Session::put('doctor_id',$booking_details->doctor_id);
            Session::put('booking_no',$booking_no);
        }

        //fetching redirection
        $redirectDetails = $this->tab_redirection->get_one_record($booking_no);
        if(!empty($redirectDetails) && $redirectDetails->active_tab != 1 && $redirectDetails->complete_tab >= 1){
            // echo '<pre>'; print_r($redirectDetails); die;
            return $this->tab_redirect($redirectDetails->active_tab);
        }

        $vital = Vital::where('booking_no', $booking_no)->first();
        
        $prescription = Prescription::where('status', 1)->get();
        
        
        $title = 'Profrea | Case Sheet-vital ';
        return view('doctor.patient_case', compact('title','booking_no','booking_details','row_user','vital','prescription','redirectDetails'));
    }

    public function addVital(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'booking_no'    => 'required',
            'height'        => 'required',
            'weight'        => 'required',
            'blood_pressure'=> 'required',
            'temperature'   => 'required'
        ]);
        if (!$validator->fails()) {
            
            $data['height']         = strtolower($request->input('height'));
            $data['weight']         = strtolower($request->input('weight'));
            $data['blood_pressure'] = strtolower($request->input('blood_pressure'));
            $data['temperature']    = strtolower($request->input('temperature'));
            
            if($request->input('v_id') == ''){
                $data['user_id']        = $request->input('user_id');
                $data['doctor_id']      = $request->input('doctor_id');
                $data['booking_no']     = $request->input('booking_no');
                $data['created_at']     = date('Y-m-d H:i:s');
                $data['status']         = 1;
                $user = Vital::create($data);
                //Session::put('user_id',$request->input('doctor_id'));
                //Session::put('vital','success');
                ///Session::put('booking_no',$request->input('booking_no'));
                $tab_redirection_data = array(
                    'user_id' => Session::get('user_id'),
                    'doctor_id' => Session::get('user_id'),
                    'booking_no' => Session::get('booking_no'),
                    'active_tab' => 1,
                    'complete_tab' => 1,
                );
                $inserted = $this->tab_redirection->insert_tab_redirection($tab_redirection_data);
                return Redirect::back()->with('message', 'Vital added.');
            }else{
                $data['updated_at']    = date('Y-m-d H:i:s');
                Vital::where('v_id',$request->input('v_id'))->update($data);
                return Redirect::back()->with('message', 'Vital Updated.');
            }

        } else {

            return Redirect::back()->withErrors($validator->errors())->withInput();
        }

    }
    public function chiefComplaint(){
        $title = 'Profrea | Patient\'s & family history';
        $user_id = Session::get('user_id');
        $booking_no = Session::get('booking_no');
        $row_user = $this->get_user_session($user_id);
        $redirectDetails = $this->tab_redirection->get_one_record($booking_no);
        $chiefComplaints = $this->tab_redirection->get_chief_complaints();
        $patientChiefComplaints = $this->tab_redirection->get_patient_chief_complaints($booking_no);
        return view('doctor.patient_chiefComplaints',compact('row_user','booking_no','redirectDetails','chiefComplaints','patientChiefComplaints'));
    }
    public function addPatientChiefComplaint(Request $request){
        if($request->isMethod('POST')){
            $booking_no = Session::get('booking_no');
            $data = array(
                'user_id' => $request->input('user_id'),
                'doctor_id' => $request->input('doctor_id'),
                'booking_no' => $request->input('booking_no'),
                'complaint' => $request->input('complaint'),
                'since' => $request->input('since'),
                'course' => $request->input('course'),
                'severity' => $request->input('severity'),
                'details' => $request->input('details'),
                'status' => 1,
                'created_at' => date('Y-m-d H:i:s'),
            );
            $insert = $this->tab_redirection->insert_patient_chief_complaints($data);
            $redirectDetails = $this->tab_redirection->get_one_record($booking_no);
            $tab_redirection_data = array(
                'active_tab' => 2,
            );
            if($redirectDetails->complete_tab < 2){
                $tab_redirection_data['complete_tab'] = 2;
            }
            $updated = $this->tab_redirection->update_tab_redirection($tab_redirection_data, $booking_no);

            return Redirect::back()->with('message', 'Patient\'s Chief Complaint added.');
        }
    }
    public function patientComplaintDelete(Request $request, $id){
        if(isset($id) && is_numeric($id))
        {
            try{
                $result = $this->tab_redirection->delete_patient_chief_complaints($id);
                return Redirect::back()->with('message', 'Removed');
            }
            catch(Exception $e) {
                $request->session()->flash('message',$e->getMessage());
              }
        }
        else 
        {
            return Redirect::back()->with('message', 'Invalid Id');
        }
    }

    public function patientHistoryView(){
        $title = 'Profrea | Patient\'s & family history';
        $user_id = Session::get('user_id');
        $booking_no = Session::get('booking_no');
        $row_user = $this->get_user_session($user_id);
        $redirectDetails = $this->tab_redirection->get_one_record($booking_no);
        $medical_history = Medical_history::where('booking_no', $booking_no)->first();
        return view('doctor.patient_history',compact('row_user','booking_no','redirectDetails','medical_history'));
   
    }

    public function addFamilyHistory(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'medical'       => 'required',
            'medication'    => 'required',
            'surgical'      => 'required',
            'drug'          => 'required',
            'restrictions'  => 'required',
            'habits'        => 'required',
            'occupation'    => 'required',
            'family_history'=> 'required'
        ]);
        if (!$validator->fails()) {

            $data['medical']    = $request->input('medical');
            $data['medication'] = $request->input('medication');
            $data['surgical']   = $request->input('surgical');
            $data['drug']       = $request->input('drug');
            $data['habits']     = $request->input('habits');
            $data['occupation'] = $request->input('occupation');
            $data['restrictions']   = $request->input('restrictions');
            $data['family_history'] = $request->input('family_history');
            
            if($request->input('id') == ''){
                $data['user_id']        = $request->input('user_id');
                $data['doctor_id']      = $request->input('doctor_id');
                $data['booking_no']     = $request->input('booking_no');
                $data['created_at']     = date('Y-m-d H:i:s');
                $data['status']         = 1;
                
                $medical = Medical_history::create($data);

                //update redirection
                $booking_no = Session::get('booking_no');
                $redirectDetails = $this->tab_redirection->get_one_record($booking_no);
                $tab_redirection_data = array(
                    'active_tab' => 3,
                    'complete_tab' => 3,
                );
                $updated = $this->tab_redirection->update_tab_redirection($tab_redirection_data, $booking_no);

                // Session::put('case_sheet',['show'=>'Notes']);
                Session::put('history','success');
                return Redirect::back()->with('message', 'Patient\'s Medical & Family History added.');
                
            }else{
                $data['updated_at']    = date('Y-m-d H:i:s');
                
                Medical_history::where('m_id',$request->input('id'))->update($data);
                return Redirect::back()->with('message', 'Patient\'s Medical & Family History updated.');
            }
        } else {
            return Redirect::back()->withErrors($validator->errors())->withInput();
        }

    }

    
    public function patientHealthView(){
        $title = 'Profrea | Patient Health View';
        $user_id = Session::get('user_id');
        $booking_no = Session::get('booking_no');
        $row_user = $this->get_user_session($user_id);
        // Session::put('health','success');
        $redirectDetails = $this->tab_redirection->get_one_record($booking_no);
        $tab_redirection_data = array(
            'active_tab' => 4,
        );
        if($redirectDetails->complete_tab < 4){
            $tab_redirection_data['complete_tab'] = 4;
        }
        $updated = $this->tab_redirection->update_tab_redirection($tab_redirection_data, $booking_no);
        $redirectDetails = $this->tab_redirection->get_one_record($booking_no);
        $attachment = Attachment::where('booking_no', $booking_no)->get();
        return view('doctor.patient_health',compact('row_user','booking_no','attachment','redirectDetails'));
    }
    
    public function patientNotesView(){
        $title = 'Profrea | Patient Notes View';
        $user_id = Session::get('user_id');
        $booking_no = Session::get('booking_no');
        $row_user = $this->get_user_session($user_id);
        // Session::put('health','success');
        $redirectDetails = $this->tab_redirection->get_one_record($booking_no);
        $tab_redirection_data = array(
            'active_tab' => 5,
        );
        if($redirectDetails->complete_tab < 5){
            $tab_redirection_data['complete_tab'] = 5;
        }
        $updated = $this->tab_redirection->update_tab_redirection($tab_redirection_data, $booking_no);
        $dr_notes = Dr_notes::where('booking_no', $booking_no)->first();
        $redirectDetails = $this->tab_redirection->get_one_record($booking_no);
        return view('doctor.patient_notes',compact('row_user','booking_no','dr_notes','redirectDetails'));
    }

    
    public function addDrNotes(Request $request)
    {
        $post = $request->input();
        if ($post['jr_dr_note'] !='' || $post['test_result'] !='' ||$post['clinical_note'] !='' || $post['personal_note'] !='') {
            if($request->input('jr_dr_note')){
                $data['jr_dr_note']    = $request->input('jr_dr_note');
            }
            if($request->input('test_result')){
                $data['test_result']   = $request->input('test_result');
            }
            if($request->input('clinical_note')){
                $data['clinical_note'] = $request->input('clinical_note');
            }
            if($request->input('personal_note')){
                $data['personal_note'] = $request->input('personal_note');
            }
            if($request->input('id') == ''){
                $data['user_id']        = $request->input('user_id');
                $data['doctor_id']      = $request->input('doctor_id');
                $data['booking_no']     = $request->input('booking_no');
                $data['created_at']     = date('Y-m-d H:i:s');
                $data['status']         = 1;
            
                $medical = Dr_notes::create($data);
                Session::put('case_sheet',['show'=>'Diagnosis']);
                return Redirect::back()->with('message', 'Patient\'s Medical & Family History added.');
                
            }else{
                $data['updated_at']    = date('Y-m-d H:i:s');
                Dr_notes::where('dn_id',$request->input('id'))->update($data);
                return Redirect::back()->with('message', 'Patient\'s Medical & Family History updated.');
            }
        } else {
            return Redirect::back()->with('message', 'Nothing added.');
        }

    }


    // public function addDiagnosis(Request $request)
    // {
    //     $post = $request->input();
    //     if ($post['jr_dr_note'] !='' || $post['test_result'] !='' ||$post['clinical_note'] !='' || $post['personal_note'] !='') {
    //         if($request->input('jr_dr_note')){
    //             $data['jr_dr_note']    = $request->input('jr_dr_note');
    //         }
    //         if($request->input('test_result')){
    //             $data['test_result']   = $request->input('test_result');
    //         }
    //         if($request->input('clinical_note')){
    //             $data['clinical_note'] = $request->input('clinical_note');
    //         }
    //         if($request->input('personal_note')){
    //             $data['personal_note'] = $request->input('personal_note');
    //         }
    //         if($request->input('id') == ''){
    //             $data['user_id']        = $request->input('user_id');
    //             $data['doctor_id']      = $request->input('doctor_id');
    //             $data['booking_no']     = $request->input('booking_no');
    //             $data['created_at']     = date('Y-m-d H:i:s');
    //             $data['status']         = 1;
            
    //             $medical = Dr_notes::create($data);
    //             // Session::put('case_sheet',['show'=>'Diagnosis']);
    //             $tab_redirection_data = array(
    //                 'active_tab' => 5,
    //                 'complete_tab' => 5,
    //             );
    //             $updated = $this->tab_redirection->update_tab_redirection($tab_redirection_data, $booking_no);
                
    //             return Redirect::back()->with('message', 'Patient\'s Medical & Family History added.');
                
    //         }else{
    //             $data['updated_at']    = date('Y-m-d H:i:s');
    //             Dr_notes::where('dn_id',$request->input('id'))->update($data);
    //             return Redirect::back()->with('message', 'Patient\'s Medical & Family History updated.');
    //         }
    //     } else {
    //         return Redirect::back()->with('message', 'Nothing added.');
    //     }

    // }


    public function patientConditionView(){
        $title = 'Profrea | Patient Diagnosis View';
        $user_id = Session::get('user_id');
        $booking_no = Session::get('booking_no');
        $row_user = $this->get_user_session($user_id);
        // Session::put('health','success'); 
        $condition = Condition::where('status', 1)->get(); 
        $patient_condition = Patient_condition::where('booking_no', $booking_no)->get();
        $redirectDetails = $this->tab_redirection->get_one_record($booking_no);
        return view('doctor.patient_condition',compact('row_user','booking_no','condition','patient_condition','redirectDetails'));
    }

    public function addPatientCondition(Request $request)
    {
        $post = $request->input();
        if ($post['condition'] !='') {
                $data['condition'] = $request->input('condition');
            if($request->input('id') == ''){
                $data['user_id']        = $request->input('user_id');
                $data['doctor_id']      = $request->input('doctor_id');
                $data['booking_no']     = $request->input('booking_no');
                $data['created_at']     = date('Y-m-d H:i:s');
                $data['status']         = 1;
                $medical = Patient_condition::create($data);
                // Session::put('case_sheet',['show'=>'Prescribed']);
                $tab_redirection_data = array(
                    'active_tab' => 6,
                    'complete_tab' => 6,
                );
                $updated = $this->tab_redirection->update_tab_redirection($tab_redirection_data, $request->input('booking_no'));
                return Redirect::back()->with('message', 'Patient\'s condition added.');
                
            }else{
                $data['updated_at']    = date('Y-m-d H:i:s');
                Patient_condition::where('pc_id',$request->input('id'))->update($data);
                return Redirect::back()->with('message', 'Patient\'s condition updated.');
            }
        } else {
            return Redirect::back()->with('message', 'Nothing added.');
        }

    }

    public function patientConditionDelete(Request $request,$id){
        
        if(isset($id) && is_numeric($id))
        {
            try{
                $res = Patient_condition::find($id); 
                $result = $res->delete();
                return Redirect::back()->with('message', 'Removed');
            }
            catch(Exception $e) {
                $request->session()->flash('message',$e->getMessage());
              }
        }
        else 
        {
            return Redirect::back()->with('message', 'Invalid Id');
        }
    }

    public function patientMedicineView(){
        $title = 'Profrea | Patient Medication View';
        $user_id = Session::get('user_id');
        $booking_no = Session::get('booking_no');
        $row_user = $this->get_user_session($user_id);
        // Session::put('health','success'); 
        // $medicine = Medicine::where('status', 1)->get();  
        $prescription = Prescription::where('status', 1)->get();
        $patient_medication = Patient_medication::where('booking_no', $booking_no)->get();
        $redirectDetails = $this->tab_redirection->get_one_record($booking_no);
        return view('doctor.patient_medicine',compact('row_user','booking_no','prescription','patient_medication','redirectDetails'));
    }

    public function addPatientMedication(Request $request)
    {
        $post = $request->input();
        
        if (isset($post['medicine_name']) && $post['medicine_name'] !='') {
              
                if(isset($post['medicine_name'])){ 
                    $data['medicine_name']  = $request->input('medicine_name');
                    $data['how_to']         = $request->input('how_to');
                    // $data['med_type']    = $request->input('med_type');
                    $data['medication']     = $request->input('medication');
                    $data['repetition']     = $request->input('repetition');
                    $data['qty']            = $request->input('qty');
                    $data['in_the']         = implode(',',$request->input('in_the'));
                    $data['when']           = $request->input('when_to_take');
                    $data['course_time']    = $request->input('course_time');
                    $data['course_duration'] = $request->input('course_duration');
                    $data['notes']          = $request->input('instNotes');
                }
                
            if($request->input('id') == ''){
                $data['user_id']        = $request->input('user_id');
                $data['doctor_id']      = $request->input('doctor_id');
                $data['booking_no']     = $request->input('booking_no');
                $data['created_at']     = date('Y-m-d H:i:s');
                $data['status']         = 1;

                //   echo '<pre>'; print_r($data); die;
                $medical = Patient_medication::create($data);
                
                $tab_redirection_data = array(
                    'active_tab' => 7,
                    'complete_tab' => 7,
                );
                $updated = $this->tab_redirection->update_tab_redirection($tab_redirection_data, $request->input('booking_no'));
                return Redirect::back()->with('message', 'Patient\'s Medication added.');
                
            }else{
                $data['updated_at']    = date('Y-m-d H:i:s');
                Patient_medication::where('pm_id',$request->input('id'))->update($data);
                return Redirect::back()->with('message', 'Patient\'s Medication updated.');
            }
        } else {
            return Redirect::back()->with('message', 'Nothing added.');
        }

    }

    public function patientMedicineDelete(Request $request,$id){
        
        if(isset($id) && is_numeric($id))
        {
            try{
                $res = Patient_medication::find($id); 
                $result = $res->delete();
                return Redirect::back()->with('message', 'Removed');
            }
            catch(Exception $e) {
                $request->session()->flash('message',$e->getMessage());
              }
        }
        else 
        {
            return Redirect::back()->with('message', 'Invalid Id');
        }
    }

    public function patientDiagnosisView(){
        $title = 'Profrea | Patient Diagnosis View';
        $user_id = Session::get('user_id');
        $booking_no = Session::get('booking_no');
        $row_user = $this->get_user_session($user_id);
        // Session::put('health','success'); 
        $blood_tests = Test::where('status', 1)->get(); 
        $patient_tests = Patient_test::where('booking_no', $booking_no)->get();
        $redirectDetails = $this->tab_redirection->get_one_record($booking_no);
        return view('doctor.patient_diagnosis',compact('row_user','booking_no','blood_tests','patient_tests','redirectDetails'));
    }

    public function addPatientTest(Request $request)
    {
        $post = $request->input();
        
        if(isset($post['test'])){
            $data['test'] = $request->input('test');
            
            if(isset($post['instrNotes'])){
                $data['instruction'] = $request->input('instrNotes');
            }
            if($request->input('id') == ''){
                $data['user_id']        = $request->input('user_id');
                $data['doctor_id']      = $request->input('doctor_id');
                $data['booking_no']     = $request->input('booking_no');
                $data['created_at']     = date('Y-m-d H:i:s');
                $data['status']         = 1;
                $medical = Patient_test::create($data);
                // Session::put('case_sheet',['show'=>'Follow']);
                $tab_redirection_data = array(
                    'active_tab' => 8,
                    'complete_tab' => 8,
                );
                $updated = $this->tab_redirection->update_tab_redirection($tab_redirection_data, $request->input('booking_no'));
                return Redirect::back()->with('message', 'Patient\'s Test added.');
                
            }else{
                $data['updated_at']    = date('Y-m-d H:i:s');
                Patient_test::where('pt_id',$request->input('id'))->update($data);
                return Redirect::back()->with('message', 'Patient\'s Test updated.');
            }
        } else {
            return Redirect::back()->with('message', 'Nothing added.');
        }

    }

    
    public function patientDiagnosisDelete(Request $request,$id){
        
        if(isset($id) && is_numeric($id))
        {
            try{
                $res = Patient_test::find($id); 
                $result = $res->delete();
                return Redirect::back()->with('message', 'Removed');
            }
            catch(Exception $e) {
                $request->session()->flash('message',$e->getMessage());
              }
        }
        else 
        {
            return Redirect::back()->with('message', 'Invalid Id');
        }
    }

    public function patientFollowupView(){
        $title = 'Profrea | Patient Follow Up View';
        $user_id = Session::get('user_id');
        $booking_no = Session::get('booking_no');
        $row_user = $this->get_user_session($user_id);
        $redirectDetails = $this->tab_redirection->get_one_record($booking_no);       
        $followup = Followup::where('booking_no', $booking_no)->first();
        return view('doctor.patient_followup',compact('row_user','booking_no','followup','redirectDetails'));
    }

    public function addPatientFollowup(Request $request)
    {
        $post = $request->input();
        if($post){
            if(isset($post['follow'])){
                $data['days'] = $request->input('follow');
            }
            if(isset($post['advice'])){
                $data['advice'] = $request->input('advice');
            }
            if($request->input('id') == ''){
                $data['user_id']        = $request->input('user_id');
                $data['doctor_id']      = $request->input('doctor_id');
                $data['booking_no']     = $request->input('booking_no');
                $data['created_at']     = date('Y-m-d H:i:s');
                $data['status']         = 1;
                $followup = Followup::create($data);
                // Session::put('case_sheet',['show'=>'Instructions']); 
                 $tab_redirection_data = array(
                    'active_tab' => 9,
                    'complete_tab' => 9,
                );
                $updated = $this->tab_redirection->update_tab_redirection($tab_redirection_data, $request->input('booking_no'));
                return Redirect::back()->with('message', 'Patient\'s data added.');
                
            }else{
                $data['updated_at']    = date('Y-m-d H:i:s');
                Followup::where('fu_id',$request->input('id'))->update($data);
                return Redirect::back()->with('message', 'Patient\'s data updated.');
            }
        } else {
            return Redirect::back()->with('message', 'Nothing added.');
        }

    }

    public function patientAdviceView(){
        $title = 'Profrea | Advice for Patient';
        $user_id = Session::get('user_id');
        $booking_no = Session::get('booking_no');
        $row_user = $this->get_user_session($user_id);
        $redirectDetails = $this->tab_redirection->get_one_record($booking_no);       
        $followup = Followup::where('booking_no', $booking_no)->first();
        return view('doctor.patient_advice',compact('row_user','booking_no','followup','redirectDetails'));
    }

    public function addPatientAdvice(Request $request)
    {
        $post = $request->input();
        
        if($post['adviceSubmit'] == true){
            if(isset($post['advice'])){
                $data['advice'] = $request->input('advice');
            }
            if($request->input('id') == ''){
                //inthis case condtion never lies in if condtion as we have used followup and advice in a same table. it will never create a new entry//
                $data['user_id']        = $request->input('user_id');
                $data['doctor_id']      = $request->input('doctor_id');
                $data['booking_no']     = $request->input('booking_no');
                $data['created_at']     = date('Y-m-d H:i:s');
                $data['status']         = 1;
                $followup = Followup::create($data);
                // Session::put('case_sheet',['show'=>'success']);
                return Redirect::back()->with('message', 'Patient\'s Casesheet ready.');
                
            }else{
                $data['updated_at']    = date('Y-m-d H:i:s');
                Followup::where('fu_id',$request->input('id'))->update($data);
                $tab_redirection_data = array(
                    'active_tab' => 10,
                    'complete_tab' => 10,
                );
                $updated = $this->tab_redirection->update_tab_redirection($tab_redirection_data, $request->input('booking_no'));
                return Redirect::back()->with('message', 'Patient\'s Casesheet updated.');
            }
        } else {
            return Redirect::back()->with('message', 'Nothing added.');
        }

    }

    /**
     * User edit
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        // $user = User::find($id);
        
        $user = User::select('users.*','website_details.*','gender.name as gender_name','city.name as city_name','operating_specialty.name as speciality_name')
            ->leftJoin('website_details', 'website_details.user_id', '=', 'users.id')
            ->leftJoin('gender', 'gender.id', '=', 'users.gender_id')
            ->leftJoin('city', 'city.id', '=', 'users.city')
            ->leftJoin('operating_specialty', 'operating_specialty.id', '=', 'users.speciality')
            ->find($id);
        $cities = DB::table('city')->get();

        return view('admin.user.edit',compact("user","cities"));
    }

    public function delete(Request $request, $id)
    {
        if(isset($id) && is_numeric($id))
        {
                  
            try{
                $enquiry = User::find($id); 
                $enquiry->delete();

                if($enquiry->password == 5) {
                    return Redirect::to('/admin/user')->with('message', 'User deleted successfully');
                } else {
                    return Redirect::to('/admin/doctor')->with('message', 'Doctor deleted successfully');
                }
            }
            catch(Exception $e) {
                $request->session()->flash('message',$e->getMessage());
              }
        }
        else 
        {
            return Redirect::back()->with('message', 'Invalid Id');
        }
    }

    /**
     * User edit update
     * @param Request $request
     * @param         $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        if(isset($id) && is_numeric($id)) {
            $user = User::find($id);
            
            $oldEmail = $user->email;
            if($oldEmail === $request->get('email')) {
                // no change, validation - exists
                $emailValidation = 'exists';
            } else {
                // change, validation - unique
                $emailValidation = 'unique';
            }
            $validator = Validator::make($request->all(), [
                'name'         => 'required|max:255',
                'email'         => 'required|string|email|max:255|' . $emailValidation . ':users',
                'password' => 'sometimes|nullable|max:50|min:5',
                //'image_delete'  => 'sometimes|nullable|in:1',
            ]);

            if(!$validator->fails()) {
                $user->name = $request->input('name');
                $user->email = $request->input('email');
                $user->mobileNo = $request->input('mobileNo');
                $user->address = $request->input('address');
                $user->landmark = $request->input('landmark');
                $user->city = $request->input('city');
                $user->state = $request->input('state');
                $user->pinCode = $request->input('pinCode');
                $user->is_verified = $request->input('is_verified');
                if($request->input('password'))
                    $user->password = Hash::make($request->input('password'));
                $user->save();

                if($request->prof_id == 5) {
                    return Redirect::to('/admin/user')->with('message', 'User updated successfully');
                } else {
                    return Redirect::to('/admin/doctor')->with('message', 'Doctor updated successfully');
                }

            } else {
                if($request->prof_id == 5) {
                    return Redirect::to('/admin/user')->withErrors($validator->errors())->withInput();
                } else {
                    return Redirect::to('/admin/doctor')->withErrors($validator->errors())->withInput();
                }
            }
        }
        if($request->prof_id == 5) {
            return Redirect::to('/admin/user')->with('message', 'Invalid Id');
        } else {
            return Redirect::to('/admin/doctor')->with('message', 'Invalid Id');
        }
    }

    public function show($id)
    {
        $user = User::select('users.*','website_details.*','gender.name as gender_name','city.name as city_name','operating_specialty.name as speciality_name')
            ->leftJoin('gender', 'gender.id', '=', 'users.gender_id')
            ->leftJoin('city', 'city.id', '=', 'users.city')
            ->leftJoin('website_details', 'website_details.user_id', '=', 'users.id')
            ->leftJoin('operating_specialty', 'operating_specialty.id', '=', 'users.speciality')
            ->where('users.id', $id)->first();

        if($user->profession_id == 1 )
        {
            $audio_slots    = DoctorTimeSlot::with('timeslots')->where('doctor_id', $id)->where('type', 1)->get();
            $video_slots    = DoctorTimeSlot::with('timeslots')->where('doctor_id', $id)->where('type', 2)->get();
            $clinic_slots   = DoctorTimeSlot::with('timeslots')->where('doctor_id', $id)->where('type', 3)->get();
            $holidays       = User::with(['holidays'])->where('id', $id)->first();
            
            return view('admin.user.view', compact('user','audio_slots','video_slots','clinic_slots','holidays'));
        }

        if($user->profession_id == 5 )
        {
            $family = User::with(['family_members'])->where('id', $id)->first();

            return view('admin.user.view', compact('user','family'));
        }
    }

    public function chat(){
        $chat_list = BookingDetail::select(['booking_details.booking_no','chat_box.*', 'users.name as user_name', 'users.id'])
        ->join('users', 'booking_details.user_id', '=', 'users.id')
        ->join('chat_box', 'chat_box.user_id', '=', 'users.id')
        ->orderBy('chat_box.cb_id','desc')
        ->groupBy(['users.id'])
        ->get()->all();

        // $chat_list = Chat_box::select(['chat_box.*', 'users.name as user_name', 'users.id'])
        //         ->join('users', 'chat_box.user_id', '=', 'users.id')
        //         ->orderBy('chat_box.cb_id','desc')
        //         ->groupBy(['users.id'])
        //         ->get()->all();
        return view('admin.chat_box.index', compact('chat_list'));
    }

    public function chatWithClient(Request $request, $booking_no){
        $booking_details = BookingDetail::join('users', 'booking_details.user_id', '=', 'users.id')
        ->where('booking_details.booking_no', $booking_no)->first();
        if($booking_no !='' && $booking_details !=''):
            $login_id       = $booking_details->user_id;
            
            $row_user = User::where(['id'=> $login_id])->first();
            
            $doc = User::where(['id'=> $booking_details->doctor_id ])->first();
            $doctor_name = $doc->name; 

            $chat_list = Chat_box::join('users', 'chat_box.user_id', '=', 'users.id')
                    ->where(['chat_box.user_id'=> $booking_details->user_id, 'chat_box.reply_to' => $booking_details->doctor_id ])
                    ->get(['chat_box.*']);
            return view('admin.chat_box.chat', compact("booking_details","chat_list","row_user","doctor_name"));
        else:
            return view('admin.chat_box.chat')->with('status', 'Wrong Booking number!');
        endif;
    }

    public function admin_chat_insert(Request $request){
        $validator = Validator::make($request->all(), [
            'message' => 'required'
        ]);
        if(!$validator->fails()){
            // $post = new Chat_box;
            $data = [
                'user_id'   => $request->input('user_id'),
                'reply_to'  => $request->input('dr_id'),
                'reply_on'  => $request->input('reply_on'),
                'message'   => $request->input('message'),
                'status'    => 1,
                'admin_reply' => 1,
                'created_at'=> date('Y-m-d H:i:s'),
            ];
            
            $user =  Chat_box::create($data);
        
            return Redirect::back()->with('status', 'Message sent!');
        } 
        else 
        {
            return Redirect::back()->withErrors($validator->errors())->withInput();
        }
    }

    public function calendar($user_id){
        // echo 'doctor.calendar'; die;
        $row_user = User::where(['id'=> $user_id])->first();
        $booking_details = BookingDetail::join('users', 'booking_details.user_id', '=', 'users.id')
        ->where('booking_details.doctor_id', $user_id)->first();
        if($booking_details):
            foreach($booking_details as $event):
                $events[] = [
                    'title' => $booking_details->booking_no,
                    'start' => $booking_details->booking_date.' '.$booking_details->booking_time,
                    'end'   => $booking_details->booking_date.' '.date('h:i A',strtotime($booking_details->booking_time) + 60*60),
                ];  
            endforeach;
        else:
            $events = '';
        endif;
        
        // $events = Calender::where('doctor_id',20)->get(); 
        return view('doctor.calendar', compact('row_user','booking_details','events'));
    }

    public function booking(Request $request, $user_id){
        
        $title = 'Profrea : Booking History';
        $user_id = $user_id;
        $row_user = User::where(['id'=> $user_id])->first();
        $row_holidays = Holiday::where(['doctor_id'=> $user_id])->get();
        $booking_details = BookingDetail::join('users', 'booking_details.user_id', '=', 'users.id')
        ->where('booking_details.doctor_id', $user_id)->get();
        
        // $booking_details = BookingDetail::join('users', 'booking_details.user_id', '=', 'users.id')
        // ->where('booking_details.doctor_id', $user_id)->filter($request)->get();

        if($booking_details):
            foreach($booking_details as $event):
                $events[] = [
                    'bid' => $event->id,
                    'title' => $event->booking_no,
                    'start' => $event->booking_date.' '.$event->booking_time,
                    'end'   => $event->booking_date.' '.date('h:i A',strtotime($event->booking_time) + 60*60),
                ];  
            endforeach;
        else:
            $events = '';
        endif;
        
        return view('doctor.booking', compact('title','row_user','booking_details','events','row_holidays','user_id'));
    }


    public function get_one_booking_details(Request $request){
        $bid = $request->input('booking_id');
        $details = BookingDetail::join('users', 'booking_details.user_id', '=', 'users.id')
        ->where('booking_details.booking_no', $bid)->get();
        if($details):
            foreach($details as $event):
                if($event['profile_picture'] != '' && file_exists("datafiles/uploads/profiles/".$event['profile_picture'])): 
                    $src = "datafiles/uploads/profiles/".$event['profile_picture']; 
                else:  
                    $src = "no-image.png"; 
                endif;

                if($event['booking_status'] == 0):
                    $status = '<h5 class="d-block mb-0 doc-name">'.ucwords($event['name']).'<i class="bk_pending">Pending</i></h5>';
                elseif($event['booking_status'] == 1):
                    $status = '<h5 class="d-block mb-0 doc-name">'.ucwords($event['name']).' <i class="bk_completed">Completed</i></h5>';
                else:
                    $status = '<h5 class="d-block mb-0 doc-name">'.ucwords($event['name']).' <i class="bk_cancelled">Cancelled</i></h5>';
                endif;
                $events = '<div class="col-xl-1 col-lg-1 col-md-3 text-center">
                        <img src="'.$src.'" class="img-fluid doctor-list-img" alt="">
                     </div>';
                $events .= '<div class="col-xl-7 col-lg-7 col-md-6 mb-3">'.$status.'
                            <h6 class="title text-dark d-block mb-0">Booking Date: '.$event['booking_date'].'</h6>
                            <h6 class="title text-dark d-block mb-0">Booking Time: '.$event['booking_time'].'</small>
                        </div>';
                $events .= '<div class="col-xl-4 col-lg-4 col-md-6">
                        <div class="">';
                                $current_date = strtotime(date('Y-m-d h:i A'));
                                preg_match("/([0-9]+)/", $event['time_duration'], $time_duration);
                                $duration  = date('h:i A', strtotime('+'.$time_duration[0].'minutes', strtotime($event['booking_time'])));
                                $booking_duration   = strtotime($event['booking_date'].$duration); 
                                $booking_time = date('h:i A', strtotime('-1 minutes', strtotime($event['booking_time']))); 
                                $booking_date = strtotime($event['booking_date'].$booking_time);
                            
                            if($current_date >= $booking_date && $current_date < $booking_duration && $event['booking_status'] == 0 ):
                                $events .= '<a href="video-call.php?channel=2222&token=006b0f2efac08d548239012af03cd1f5730IABivtcZSkkDXkhRgaTErKsdhs4h05s7HL9iEcvuNVjMCjnbLnkh39v0IgAO4gAAT5bSYgQAAQBXWNFiAwBXWNFiAgBXWNFiBABXWNFi"><button class="bk_his_join_link_btn"><i class="feather-link"></i> Join Link</button></a>';
                            endif;
                                $events .= '<a href="'.request()->segment(0).'/booking-details?booking='.$event['booking_no'].'"><button class="bk_his_view_btn"><i class="feather-eye"></i> View</button></a>';
                                
                                $events .= '<a href="'.request()->segment(0).'/admin/public/doctor/patient-case/'.$event['booking_no'].'"><button class="btn btn-info  text-light fs15" style="border-radius: 25px;"><i class="feather-align-justify"></i> Case Sheet</button></a>';

                            if( $current_date < $booking_date  && $event['booking_status'] == 0):
                                $events .= '<a href="javascript:void(0)" data-bs-toggle="modal" data-id="'.$event['booking_no'].'" class="cancel" data-bs-target="#bookingCancel"><button class="bk_his_cancel_btn fs15"><i class="feather-trash-2"></i> Cancel</button></a>';
                            endif;


                            $events .= '</div>
                    </div>';

            endforeach;
        else:
            $events = '';
        endif;
        return response()->json($events);
    }

    
    public function digitalPrescription($booking_no){
        $booking_details = BookingDetail::join('users', 'booking_details.user_id', '=', 'users.id')
        ->where('booking_details.booking_no', $booking_no)->first();
        $vital = Vital::where('booking_no', $booking_no)->first();
        $medical_history = Medical_history::where('booking_no', $booking_no)->first();
        $dr_notes = Dr_notes::where('booking_no', $booking_no)->first();
        $patient_condition = Patient_condition::where('booking_no', $booking_no)->first();
        $patient_medication = Patient_medication::where('booking_no', $booking_no)->get();
        $patient_tests = Patient_test::where('booking_no', $booking_no)->first();
        $followup = Followup::where('booking_no', $booking_no)->first();
        
        $attachment = Attachment::where('booking_no', $booking_no)->get();
        $login_id       = $booking_details->doctor_id;
        $row_user = $this->get_user_session($login_id);
        $patientChiefComplaints = $this->tab_redirection->get_patient_chief_complaints($booking_no);
        //echo '<pre>'; print_r($booking_details); exit;
        return view('doctor.digital_prescription',compact('row_user','booking_no','booking_details','vital','medical_history','dr_notes','patient_condition','patient_medication','patient_tests','followup','patientChiefComplaints'));
   
    }
    
    public function followUp($user_id){
        $title = 'Profrea | Follow up';
        $row_user = $this->get_user_session($user_id);
        $all_patients = Followup::select('followup.*','users.name','users.id as user_id, users.profile_picture')->join('users', 'followup.user_id', '=', 'users.id')->where('followup.doctor_id', $user_id)->get();
        return view('doctor.follow_up',compact('row_user','title','all_patients'));
    }

    public function followUp_old($user_id){
        $row_user = $this->get_user_session($user_id);
        $all_patients = Followup::select('followup.*','users.name','users.id as user_id, users.profile_picture')->join('users', 'followup.user_id', '=', 'users.id')->where('followup.doctor_id', $user_id)->get();
        if($all_patients):
            foreach($all_patients as $all):
                $logs = Followup_logs :: select('followup_logs.*')->where('followup_logs.fu_id', $all->fu_id)->get();
                $allp[] = (object)[
                    'fu_id' => $all->fu_id,
                    'profile_picture' => $all->profile_picture,
                    'booking_no' => $all->booking_no,
                    'user_id' => $all->user_id,
                    'doctor_id' => $all->doctor_id,
                    'name' => $all->name,
                    'days' => $all->days,
                    'created_at' => $all->created_at,
                    'start' => $all->start,
                    'logcount' => count($logs),
                    'logs' => $logs,
                ];  
            endforeach;
        else:
            $allp = '';
        endif;
        
        $follow_up = Followup::select('followup.*','users.name','users.id as user_id, users.profile_picture')->join('users', 'followup.user_id', '=', 'users.id')->where('followup.doctor_id', $user_id)->where('followup.days','>',1)->get();
        if($follow_up):
            foreach($follow_up as $follow):
                $logs = Followup_logs :: select('followup_logs.*')->where('followup_logs.fu_id', $follow->fu_id)->get();
                $followp[] = (object)[
                    'fu_id' => $follow->fu_id,
                    'profile_picture' => $follow->profile_picture,
                    'booking_no' => $follow->booking_no,
                    'user_id' => $follow->user_id,
                    'doctor_id' => $follow->doctor_id,
                    'name' => $follow->name,
                    'days' => $follow->days,
                    'created_at' => $follow->created_at,
                    'start' => $follow->start,
                    'logcount' => count($logs),
                    'logs' => $logs,
                ];  
            endforeach;
        else:
            $followp = '';
        endif;
        
        $regular = Followup::select('followup.*','users.name','users.id as user_id, users.profile_picture')->join('users', 'followup.user_id', '=', 'users.id')->where(['followup.doctor_id'=> $user_id,'followup.days'=>1])->get();
        if($regular):
            foreach($regular as $rfollow):
                $logs = Followup_logs :: select('followup_logs.*')->where('followup_logs.fu_id', $rfollow->fu_id)->get();
                $regularp[] = (object)[
                    'fu_id' => $rfollow->fu_id,
                    'profile_picture' => $rfollow->profile_picture,
                    'booking_no' => $rfollow->booking_no,
                    'user_id' => $rfollow->user_id,
                    'doctor_id' => $rfollow->doctor_id,
                    'name' => $rfollow->name,
                    'days' => $rfollow->days,
                    'created_at' => $rfollow->created_at,
                    'start' => $rfollow->start,
                    'logcount' => count($logs),
                    'logs' => $logs,
                ];  
            endforeach;
        else:
            $regularp = '';
        endif;
        return view('doctor.follow_up',compact('row_user','allp','followp','regularp'));
    }
    
    
    public function prescription($user_id){
        $title = 'Profrea | Smart Prescription';
        $row_user = $this->get_user_session($user_id);
        // $prescription = Prescription::where('status', 1)->where('doctor_id', $user_id)->get();
        // $frequently_instruction = Instruction::where('status', 1)->where('doctor_id', $user_id)->get();
        // $condition = Condition::where('status', 1)->where('doctor_id', $user_id)->get();
        // $blood_tests = Test::where('status', 1)->where('doctor_id', $user_id)->get(); 
        $prescription = Prescription::where('status', 1)->get();
        $frequently_instruction = Instruction::where('status', 1)->get();
        $condition = Condition::where('status', 1)->get();
        $blood_tests = Test::where('status', 1)->get();
        $complaints = $this->tab_redirection->get_chief_complaints(); 
        return view('doctor.prescription',compact('row_user','title','prescription','frequently_instruction','blood_tests','condition','complaints'));
    }

    public function addPrescription(Request $request){
        
        if($request->input() != ''){

            if($request->input('medicine') != ''){
                $data['medicine_name'] = $request->input('medicine');
            }else{
                $data['medicine_name'] = $request->input('new_medicine');
            }

            $data['how_to']     = $request->input('how_to');
            $data['medication'] = $request->input('medication');
            $data['qty']        = $request->input('qty');
            $data['is_take']    = $request->input('is_take');
            $data['in_the']     = implode(',',$request->input('inthe'));
            $data['when']       = $request->input('when_to_take');
            $data['course_time']  = $request->input('for');
            $data['course_duration']   = $request->input('duration');
            $data['notes']      = $request->input('instNotes');
            $data['created_at']     = date('Y-m-d H:i:s');
            $data['status']         = 1;

            if($request->input('idprescription')){
                Prescription::where('idprescription',$request->input('idprescription'))->update($data);
                $message = 'Medicine updated.';
            }else{
                $medical = Prescription::create($data);
                $message = 'Medicine added.';
            }
            // Session::put('response','Medicine added successfully.');
        }
        return Redirect::back()->with('message',$message);
    }

    public function prescriptionDelete(Request $request,$id){
        
        if(isset($id) && is_numeric($id))
        {
            try{
                $res = Prescription::find($id); 
                $result = $res->delete();
                return Redirect::back()->with('message', 'Data Deleted');
            }
            catch(Exception $e) {
                $request->session()->flash('message',$e->getMessage());
              }
        }
        else 
        {
            return Redirect::back()->with('message', 'Invalid Id');
        }
    }

    public function addInstruction(Request $request){
        
        if($request->input() != ''){
            $data['title']      = $request->input('fuinstruction');
            $data['doctor_id']  = $request->input('doctor_id');
            $data['status']     = 1;

            if($request->input('fui_id')){
                Instruction::where('fui_id',$request->input('fui_id'))->update($data);
                $message = 'Instrution updated.';
            }else{
                $medical = Instruction::create($data);
                $message = 'Instrution added.';
            }
            // Session::put('response','Medicine added successfully.');
        }
        return Redirect::back()->with('message',$message);
    }
  

    public function instructionDelete(Request $request,$id){
        
        if(isset($id) && is_numeric($id))
        {
            try{
                $res = Instruction::find($id); 
                $result = $res->delete();
                return Redirect::back()->with('message', 'Data Deleted');
            }
            catch(Exception $e) {
                $request->session()->flash('message',$e->getMessage());
              }
        }
        else 
        {
            return Redirect::back()->with('message', 'Invalid Id');
        }
    }

    public function addTest(Request $request){
        
        if($request->input() != ''){
            $data['title']  = $request->input('title');
            $data['desc']   = $request->input('desc');
            $data['doctor_id']   = $request->input('doctor_id');
            $data['status']         = 1;

            if($request->input('bt_id')){
                Test::where('bt_id',$request->input('bt_id'))->update($data);
                $message = 'Test updated.';
            }else{
                $medical = Test::create($data);
                $message = 'Test added.';
            }
        }
        return Redirect::back()->with('message',$message);
    }
  

    public function TestDelete(Request $request,$id){
        
        if(isset($id) && is_numeric($id))
        {
            try{
                $res = Test::find($id); 
                $result = $res->delete();
                return Redirect::back()->with('message', 'Data Deleted');
            }
            catch(Exception $e) {
                $request->session()->flash('message',$e->getMessage());
              }
        }
        else 
        {
            return Redirect::back()->with('message', 'Invalid Id');
        }
    }

    public function addDiagnosisTest(Request $request){
        
        if($request->input() != ''){
            $data['title']      = $request->input('title');
            $data['desc']       = $request->input('desc');
            $data['doctor_id']  = $request->input('doctor_id');
            $data['status']     = 1;
            // print_r($data);die; 
            if($request->input('hc_id') !=''){
                $data['updated_at'] = date('Y-m-d :H:i:s');
                Condition::where('hc_id',$request->input('hc_id'))->update($data);
                $message = 'Diagnosis Condition updated.';
            }else{
                $data['created_at'] = date('Y-m-d :H:i:s');
                $medical = Condition::create($data);
                $message = 'Diagnosis Condition added.';
            }
        }
        return Redirect::back()->with('message',$message);
    }
  

    public function diagnosisDelete(Request $request,$id){
        
        if(isset($id) && is_numeric($id))
        {
            try{
                $res = Condition::find($id); 
                $result = $res->delete();
                return Redirect::back()->with('message', 'Data Deleted');
            }
            catch(Exception $e) {
                $request->session()->flash('message',$e->getMessage());
              }
        }
        else 
        {
            return Redirect::back()->with('message', 'Invalid Id');
        }
    }

    public function addEditComplaints(Request $request){
        
        if($request->input() != ''){
            $data['complaint']      = $request->input('complaint');
            $data['since']          = $request->input('since');
            $data['course']         = $request->input('course');
            $data['severity']       = $request->input('severity');
            $data['details']        = $request->input('details');
            $data['status']         = 1;
            // print_r($data);die; 
            if($request->input('comp_id') !=''){
                $data['updated_at'] = date('Y-m-d :H:i:s');
                $this->tab_redirection->update_chief_complaints($data, $request->input('comp_id'));
                $message = 'Chief Complaint updated.';
            }else{
                $data['created_at'] = date('Y-m-d :H:i:s');
                $this->tab_redirection->insert_chief_complaints($data);
                $message = 'Chief Complaint added.';
            }
        }
        return Redirect::back()->with('message',$message);
    }

    public function deleteComplaints(Request $request,$id){
        
        if(isset($id) && is_numeric($id))
        {
            try{
                $result = $this->tab_redirection->delete_complaints($id);
                return Redirect::back()->with('message', 'Data Deleted');
            }
            catch(Exception $e) {
                $request->session()->flash('message',$e->getMessage());
              }
        }
        else 
        {
            return Redirect::back()->with('message', 'Invalid Id');
        }
    }
    
    public function updateFollowup(Request $request,$fu_id){
        $id = $fu_id;
        $details = Followup::where('fu_id',$id)->first();

        // $startdate = date('Y-m-d', strtorime($details->start));
        // if($startdate = date('Y-m-d')){
        //     $data['log_count']  = $details->log_count + 1;
        //     $data['start']      = date('Y-m-d H:i:s');
        //     $data['updated_at'] = date('Y-m-d H:i:s');
        //     Followup::where('fu_id',$id)->update($data);
        //     $result['success'] = true;
        // }else{ $result['success'] = false; }
        
        return response()->json($details);
        // Followup_logs::where('v_id',$request->input('v_id'))->update($data);
    }

}
