<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;


use App\Basicinfo;

class BasicinfoController extends Controller
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
        $basic_info = DB::table('basic_info')->where('is_deleted','=',0)->orderBy('id', 'desc')->paginate(10);
        return view('admin.basic_info.basic_info', compact('basic_info'));
    }

    public function edit($id)
    {
        $basic_info = Basicinfo::find($id);
        return view('admin.basic_info.edit', compact('basic_info'));
    }

    public function update(Request $request, $id)
    {
        if(isset($id) && is_numeric($id)) {
        $basic_info = Basicinfo::find($id);
        
            $basic_info->unique_id = $request->input('unique_id');
            $basic_info->first_name = $request->input('first_name');
            $basic_info->last_name = $request->input('last_name');
            $basic_info->phone_no = $request->input('phone_no');
            $basic_info->phone_no2 = $request->input('phone_no2');
            $basic_info->email_Id = $request->input('email_Id');
            $basic_info->email_Id2 = $request->input('email_Id2');
            $basic_info->user_type = $request->input('user_type');
            $basic_info->locality = $request->input('locality');
            $basic_info->landmark = $request->input('landmark');
            $basic_info->city = $request->input('city');
            $basic_info->locality2 = $request->input('locality2');
            $basic_info->locality3 = $request->input('locality3');
            $basic_info->landmark2 = $request->input('landmark2');
            $basic_info->landmark3 = $request->input('landmark3');
            
            $basic_info->save();

            return Redirect::to('/admin/basic_info')->with('message', 'Basic Info updated successfully');

        } else {

            return Redirect::to('/admin/user')->with('message', 'Invalid Id');
        }
    }

    public function destroy(Request $request, $id)
    {
        
        if(isset($id) && is_numeric($id)) {
        $basic_info = Basicinfo::find($id);
        
            $basic_info->is_deleted = 1;
            
            $basic_info->save();

            return Redirect::to('/admin/basic_info')->with('message', 'Basic Info deleted successfully');

        } else {

            return Redirect::to('/admin/user')->with('message', 'Invalid Id');
        }
    }


        
 
    
}
