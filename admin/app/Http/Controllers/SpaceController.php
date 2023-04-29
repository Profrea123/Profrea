<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

use Exception;
use App\Space;

class SpaceController extends Controller
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
        $space = DB::table('spaces')->where('is_deleted','=',0)->orderBy('id', 'desc')->paginate(10);
        return view('admin.space.space', compact('space'));
    }

    public function edit($id)
    {
        $space = Space::find($id);
        return view('admin.space.edit', compact('space'));
    }

    public function update(Request $request, $id)
    {
        // dd($request->all());
        $file = $request->file('space_image');
        $filespace_profile_image = $request->file('space_profile_image');
        if(!empty($file)){

            $location= base_path().'/../datafiles/spaces/'.$id.'/space_images';
            /*For Remove File*/
            $filesRemove = glob($location.'/*'); // get all file names
            foreach($filesRemove as $fileRemove){ // iterate files
            if(is_file($fileRemove))
                unlink($fileRemove); // delete file
            }
            /** End */
            $names = '';
            foreach($file as $val){
                $test = explode(".", $val->getClientOriginalName());
                $extension = end($test);
                $space_image_name = rand(100, 999).'.'.$extension;        
                $val->move($location, $space_image_name); 
                $names .= $space_image_name.',';
            }
            $tmp_space_image = trim($names, ','); 
        }

        if(!empty($filespace_profile_image)){

            $location_profile_image= base_path().'/../datafiles/spaces/'.$id.'/space_image_profile';
            /*For Remove File*/
            $filesRemove_profileimage = glob($location_profile_image.'/*'); // get all file names
            foreach($filesRemove_profileimage as $fileRemove_profileimage){ // iterate files
            if(is_file($fileRemove_profileimage))
                unlink($fileRemove_profileimage); // delete file
            }
            /** End */
            $test_profile_image = explode(".", $filespace_profile_image->getClientOriginalName());
            $extension = end($test_profile_image);
            $profile_image_name = rand(10000, 999999).'.'.$extension;        
            $filespace_profile_image->move($location_profile_image, $profile_image_name); 
        }
        
        
        if(isset($id) && is_numeric($id)) {
        $space = Space::find($id);
        //echo"<pre>"; print_r($space); die;

        
            $space->owner_id = $request->input('owner_id');
            $space->phone = $request->input('phone');
            $space->hourly_charges = $request->input('hourly_charges');
            $space->space_type = $request->input('space_type');
            $space->capacity = $request->input('capacity');
            $space->speciality_operating = $request->input('speciality_operating');
            $space->speciality_exclude = $request->input('speciality_exclude');
            $space->setup_rules = $request->input('setup_rules');
            $space->security_deposit = $request->input('security_deposit');
            $space->amenities = $request->input('amenities');
            $space->utility = $request->input('utility');
            $space->paid_utilities = $request->input('paid_utilities');
            $space->available_day_slots = $request->input('available_day_slots');
            $space->available_time_slots = $request->input('available_time_slots');
            $space->address = $request->input('address');
            $space->locality = $request->input('locality');
            $space->landmark = $request->input('landmark');
            $space->city = $request->input('city');
            $space->state = $request->input('state');
            $space->pin_code = $request->input('pin_code');
            $space->gmap_location = $request->input('gmap_location');
            $space->setup_desc = $request->input('setup_desc');
            $space->ws_name = $request->input('ws_name');
            $space->ws_desc = $request->input('ws_desc');
            if(!empty($tmp_space_image)){
                $space->space_image_name = $tmp_space_image;
            }
            if(!empty($profile_image_name)){
                $space->space_profile_image = $profile_image_name;
            }
            
            $space->save();

            
            return Redirect::to('/admin/space')->with('message', 'Space updated successfully');

        } else {

            return Redirect::to('/admin/user')->with('message', 'Invalid Id');
        }
    }

    public function destroy(Request $request, $id)
    {
        
        if(isset($id) && is_numeric($id)) {
        $space = Space::find($id);
        
            $space->is_deleted = 1;
            
            $space->save();

            return Redirect::to('/admin/space')->with('message', 'Space deleted successfully');

        } else {

            return Redirect::to('/admin/user')->with('message', 'Invalid Id');
        }
    }


        
 
    
}
