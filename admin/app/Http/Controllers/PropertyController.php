<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;


use App\Property;

class PropertyController extends Controller
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
        $property = DB::table('space_enquiry')->where('is_deleted','=',0)->orderBy('id', 'desc')->paginate(10);
        return view('admin.property.property', compact('property'));
    }

    public function edit($id)
    {
        $property = Property::find($id);
        return view('admin.property.edit', compact('property'));
    }

    public function update(Request $request, $id)
    {
        if(isset($id) && is_numeric($id)) {
        $property = Property::find($id);
        
            $property->space_id = $request->input('space_id');
            $property->first_name = $request->input('first_name');
            $property->last_name = $request->input('last_name');
            $property->mobile = $request->input('mobile');
            $property->email = $request->input('email');
            $property->brief_profile1 = $request->input('brief_profile1');
            $property->start_date = $request->input('start_date');
            $property->p_amount = $request->input('p_amount');
            $property->select_date = $request->input('select_date');
            $property->select_time = $request->input('select_time');
            $property->work_mon = $request->input('work_mon');
            $property->work_tue = $request->input('work_tue');
            $property->work_wed = $request->input('work_wed');
            $property->work_thu = $request->input('work_thu');
            $property->work_fri = $request->input('work_fri');
            $property->work_sat = $request->input('work_sat');
            $property->work_sun = $request->input('work_sun');
            $property->property_documents = $request->input('property_documents');
            
            $property->save();

            
            return Redirect::to('/admin/property')->with('message', 'Property updated successfully');

        } else {

            return Redirect::to('/admin/property')->with('message', 'Invalid Id');
        }
    }

    public function destroy(Request $request, $id)
    {
        
        if(isset($id) && is_numeric($id)) {
        $space_info = Property::find($id);
        
            $space_info->is_deleted = 1;
            
            $space_info->save();

            return Redirect::to('/admin/Property')->with('message', 'Property deleted successfully');

        } else {

            return Redirect::to('/admin/user')->with('message', 'Invalid Id');
        }
    }


        
 
    
}
