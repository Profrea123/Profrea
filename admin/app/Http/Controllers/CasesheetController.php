<?php

namespace App\Http\Controllers;

use App\DoctorTimeSlot;
use App\User;
use App\BookingDetail;
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
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class CasesheetController extends Controller
{
    public function __construct()
    {
        $this->middleware('web');
    }

    // private function get_user_session($userid){
    //     $result = User::select('users.*','website_details.*','gender.name as gender_name','city.name as city_name','operating_specialty.name as speciality_name')
    //     ->leftJoin('gender', 'gender.id', '=', 'users.gender_id')
    //     ->leftJoin('city', 'city.id', '=', 'users.city')
    //     ->leftJoin('website_details', 'website_details.user_id', '=', 'users.id')
    //     ->leftJoin('operating_specialty', 'operating_specialty.id', '=', 'users.speciality')
    //     ->where('users.id', $userid)->first();
    //     return $result;
    // }
    
    public function index(){
        // echo 'casesheet'; die;
        $casesheet = BookingDetail::join('users', 'booking_details.user_id', '=', 'users.id')
                            ->join('vital1', 'booking_details.booking_no', '=', 'vital1.booking_no')
                            ->join('medical_history', 'booking_details.booking_no', '=', 'medical_history.booking_no')
                            ->join('dr_notes', 'booking_details.booking_no', '=', 'dr_notes.booking_no')
                            ->join('patient_condition', 'booking_details.booking_no', '=', 'patient_condition.booking_no')
                            ->join('patient_medication', 'booking_details.booking_no', '=', 'patient_medication.booking_no')
                            ->join('patient_test', 'booking_details.booking_no', '=', 'patient_test.booking_no')
                            ->orderBy('booking_details.id','DESC')->get();
        $booking = false;
        return view('admin.casesheet.index',compact('booking','casesheet'));
    }

    // public function insert(Request $request){
    //     $validator = Validator::make($request->all(), [
    //         'message' => 'required'
    //     ]);
    //     if(!$validator->fails()){
    //         // $post = new Chat_box;
    //         $data = [
    //             'user_id'   => $request->input('user_id'),
    //             'reply_to'  => $request->input('dr_id'),
    //             'reply_on'  => 0,
    //             'status'    => 1,
    //             'message'   => $request->input('message'),
    //             'created_at'=> date('Y-m-d H:i:s'),
    //         ];
            
    //         $user =  Chat_box::create($data);
        
    //         return Redirect::back()->with('status', 'Message sent!');
    //     } 
    //     else 
    //     {
    //         return Redirect::back()->withErrors($validator->errors())->withInput();
    //     }
    // }

//     public function doctor_chat_list(Request $request, $booking_no){
//         $booking_details = BookingDetail::join('users', 'booking_details.user_id', '=', 'users.id')
//         ->where('booking_details.booking_no', $booking_no)->first();
//         if($booking_no !='' && $booking_details !=''):
//             $login_id       = $booking_details->user_id;
//             $row_user = $this->get_user_session($login_id);
            
//             $doc = User::where(['id'=> $booking_details->doctor_id ])->first();
//             $doctor_name = $doc->name; 

//             $chat_list = Chat_box::join('users', 'chat_box.user_id', '=', 'users.id')
//                     ->where(['chat_box.user_id'=> $booking_details->user_id, 'chat_box.reply_to' => $booking_details->doctor_id ])
//                     ->get(['chat_box.*']);
//             return view('user.doctor_chat', compact("booking_details","chat_list","row_user","doctor_name"));
//         else:
//             return view('user.doctor_chat')->with('status', 'Wrong Booking number!');
//         endif;
//     }

//     public function doctor_chat_insert(Request $request){
//         $validator = Validator::make($request->all(), [
//             'message' => 'required'
//         ]);
//         if(!$validator->fails()){
//             // $post = new Chat_box;
//             $data = [
//                 'user_id'   => $request->input('user_id'),
//                 'reply_to'  => $request->input('dr_id'),
//                 'reply_on'  => $request->input('reply_on'),
//                 'status'    => 1,
//                 'message'   => $request->input('message'),
//                 'created_at'=> date('Y-m-d H:i:s'),
//             ];
            
//             $user =  Chat_box::create($data);
        
//             return Redirect::back()->with('status', 'Message sent!');
//         } 
//         else 
//         {
//             return Redirect::back()->withErrors($validator->errors())->withInput();
//         }
//     }
}
  ?>