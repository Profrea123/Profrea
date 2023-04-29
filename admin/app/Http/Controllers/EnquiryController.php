<?php
namespace App\Http\Controllers;

use App\Enquiry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class EnquiryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $enquiry = DB::table('website_enquiry')->orderBy('id', 'desc')->paginate(10);
        return view('admin.enquiry.index', compact('enquiry'));
    }

    

    /**
     * Display the specified resource.
     *
     * @param  \App\Featurelist $feature_list_id
     * @return \Illuminate\Http\Response
     */
    public function show($enquiry_id)
    {
        $enquiry = Enquiry::find($enquiry_id);        
        return view('admin.enquiry.show', compact('enquiry'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Featurelist $feature_list_id
     * @return \Illuminate\Http\Response
     */
    public function edit($enquiry_id)
    {
        $enquiry = Enquiry::find($enquiry_id);
        return view('admin.enquiry.edit', compact('enquiry'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Featurelist $feature_list_id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $enquiry_id)
    {
        if(isset($enquiry_id) && is_numeric($enquiry_id)) 
        {
            $enquiry = Enquiry::find($enquiry_id);
            $validator = Validator::make($request->all(), [
                'status' => 'required'
            ]);
            if(!$validator->fails()) 
            {
                $enquiry->comment = $request->input('comment');
                $enquiry->status = $request->input('status');
                $enquiry->save();
                //return back()->with('success','Enquiry updated successfully!');
                 return Redirect::to('/admin/enquiry')->with('message', 'Enquiry updated successfully');
            } 
            else 
            {
                return Redirect::back()->withErrors($validator->errors())->withInput();
            }
        }
        return Redirect::back()->with('message', 'Invalid Id');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Featurelist $feature_list_id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $enquiry_id)
    {
        if(isset($enquiry_id) && is_numeric($enquiry_id))
        {
            $enquiry = Enquiry::find($enquiry_id);        
            $enquiry->delete();
            $request->session()->flash('message', 'Enquiry deleted successfully');
            return Redirect::to('/admin/enquiry')->with('message', 'Enquiry deleted successfully');
        } 
        else 
        {
            return Redirect::back()->with('message', 'Invalid Id');
        }
    }
}
