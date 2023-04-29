<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use App\Spaceinfo;
use App\Spaceslot;
use App\Basicinfo;
use App\Space;
use App\User;
use App\Provider;

class SpaceinfoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * User listing
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {   
        $space_info = DB::table('space_info')->where('is_deleted','=',0)->orderBy('id', 'desc')->where('update_space','=',0)->paginate(10);
        return view('admin.space_info.space_info', compact('space_info'));
    }

    public function edit($id)
    {
        $space_info = Spaceinfo::find($id);
        return view('admin.space_info.edit', compact('space_info'));
    }

    public function update(Request $request, $id)
    {
        if(isset($id) && is_numeric($id)) {
            $space_info = Spaceinfo::find($id);        
            $basic_info = Basicinfo::find($request->input('basic_info_id'));        
            $getUserDetail = DB::table('space_provider')->where('mobileNo', $basic_info->phone_no)->first();
            if($getUserDetail){
                $user_id = $getUserDetail->id;
            }
            else{
                $user = new Provider;
                $user->name = $basic_info->first_name.' '.$basic_info->last_name;
                $user->email = $basic_info->email_Id;
                $user->mobileNo = $basic_info->phone_no;
                $user->landmark = $basic_info->landmark;
                $user->locality = $basic_info->locality;
                $user->city = $basic_info->city;
                $user->save();
                $user_id = $user->id;
            }
            $space_info->basic_info_id = $request->input('basic_info_id');
            $space_info->space_type = $request->input('space_type');
            $space_info->city = $request->input('city');
            $space_info->locality = $request->input('locality');
            $space_info->landmark = $request->input('landmark');
            $space_info->addresss = $request->input('addresss');
            $space_info->security_deposit = $request->input('security_deposit');
            $space_info->setup_rules = $request->input('setup_rules');
            $space_info->setup_desc = $request->input('setup_desc');
            $space_info->operating_specialty = $request->input('operating_specialty');
            $space_info->utility = $request->input('utility');
            $space_info->paid_utilities = $request->input('paid_utilities');
            $space_info->amenities = $request->input('amenities');
            $space_info->map_location = $request->input('map_location');
            $space_info->map_cordinates = $request->input('map_cordinates');
            $space_info->ws_name = $request->input('ws_name');
            $space_info->ws_available_from = $request->input('ws_available_from');
            $space_info->ws_offered_slots_mon = $request->input('ws_offered_slots_mon');
            $space_info->ws_offered_slots_tue = $request->input('ws_offered_slots_tue');
            $space_info->ws_offered_slots_wed = $request->input('ws_offered_slots_wed');
            $space_info->ws_offered_slots_thu = $request->input('ws_offered_slots_thu');
            $space_info->ws_offered_slots_fri = $request->input('ws_offered_slots_fri');
            $space_info->ws_offered_slots_sat = $request->input('ws_offered_slots_sat');
            $space_info->ws_offered_slots_sun = $request->input('ws_offered_slots_sun');
            $space_info->ws_hourly_charges = $request->input('ws_hourly_charges');
            $space_info->ws_desc = $request->input('ws_desc');
            $space_info->ws_capacity = $request->input('ws_capacity');
            $space_info->update_space = 1;            
            $space_info->save();
            
            $space = new Space;
            $space->id = $id;
            $space->owner_id = $user_id;
            $space->phone = $basic_info->phone_no;
            $space->hourly_charges = $request->input('ws_hourly_charges');
            $space->space_type = $request->input('space_type');
            $space->capacity = $request->input('ws_capacity');
            $space->images = $request->input('space_image_name').','.$request->input('identity_proof_name').','.$request->input('space_ownership_docs_name').','.$request->input('noc_name').','.$request->input('space_profile_image').','.$request->input('other_docs');
            $space->amenities = $request->input('amenities');
            $space->utility = $request->input('utility');
            $space->paid_utilities = $request->input('paid_utilities');
            $space->speciality_operating = $request->input('operating_specialty');
            $space->speciality_exclude = $request->input('amenities');
            $space->speciality_exclusively = $request->input('amenities');
            $space->description = $request->input('amenities');
            $space->available_day_slots = 'Morning,Afternoon,Evening';
            $space->available_time_slots = 'MON~'.$request->input('ws_offered_slots_mon').'|'.'TUE~'.$request->input('ws_offered_slots_tue').'|'.'WED~'.$request->input('ws_offered_slots_wed').'|'.'THU~'.$request->input('ws_offered_slots_thu').'|'.'FRI~'.$request->input('ws_offered_slots_fri').'|'.'SAT~'.$request->input('ws_offered_slots_sat');
            $space->address =  $request->input('addresss');
            $space->locality = $request->input('locality');
            $space->landmark = $request->input('landmark');
            $space->city = $request->input('city');
            $space->state = '';
            $space->pin_code = '';
            $space->gmap_location = $request->input('map_location');
            $space->security_deposit = $request->input('security_deposit');
            $space->setup_rules = $request->input('setup_rules');
            $space->setup_desc = $request->input('ws_desc');
            $space->ws_name = $request->input('ws_name');
            $space->ws_desc = $request->input('ws_desc');

            $space->space_image_name = $request->input('space_image_name');
            $space->identity_proof_name = $request->input('identity_proof_name');
            $space->space_ownership_docs_name = $request->input('space_ownership_docs_name');
            $space->noc_name = $request->input('noc_name');
            $space->other_docs = $request->input('other_docs');
            $space->space_profile_image = $request->input('space_profile_image');
            date_default_timezone_set('Asia/Kolkata');
            $space->insert = date("Y-m-d h:i:s");            
            $space->save();
            
            // $space_info_id = $id;
            // $space_id = $space->id;
            // DB::table('space_available_slots')
            //     ->where('space_info_id', $space_info_id)
            //     ->update(array('space_id' => $space_id));                
                
            return Redirect::to('/admin/space_info')->with('message', 'Space Info updated successfully');
        } 
        else {
            return Redirect::to('/admin/user')->with('message', 'Invalid Id');
        }
    }

    public function destroy(Request $request, $id)
    {        
        if(isset($id) && is_numeric($id)) {
            $space_info = Spaceinfo::find($id);        
            $space_info->is_deleted = 1;            
            $space_info->save();
            return Redirect::to('/admin/space_info')->with('message', 'Space Info deleted successfully');
        } 
        else {
            return Redirect::to('/admin/user')->with('message', 'Invalid Id');
        }
    }
    
}
