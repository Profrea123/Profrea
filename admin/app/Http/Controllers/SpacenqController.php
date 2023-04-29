<?php
namespace App\Http\Controllers;

use App\Spacenq;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class SpacenqController extends Controller
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
        $spacenq = DB::table('space_enquiry')->orderBy('id', 'desc')->paginate(10);
        return view('admin.spacenq.index', compact('spacenq'));
    }

    

    /**
     * Display the specified resource.
     *
     * @param  \App\Featurelist $feature_list_id
     * @return \Illuminate\Http\Response
     */
    public function show($spacenq_id)
    {
        $spacenq = Spacenq::find($spacenq_id);        
        return view('admin.spacenq.show', compact('spacenq'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Featurelist $feature_list_id
     * @return \Illuminate\Http\Response
     */
    public function edit($spacenq_id)
    {
        $spacenq = Spacenq::find($spacenq_id);
        return view('admin.spacenq.edit', compact('spacenq'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Featurelist $feature_list_id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $spacenq_id)
    {
        if(isset($spacenq_id) && is_numeric($spacenq_id)) 
        {
            $spacenq = Spacenq::find($spacenq_id);
            $validator = Validator::make($request->all(), [
                'status' => 'required'
            ]);
            if(!$validator->fails()) 
            {
                $spacenq->comment = $request->input('comment');
                $spacenq->status = $request->input('status');
                $spacenq->save();
                //return back()->with('success','spacenq updated successfully!');
                 return Redirect::to('/admin/spacenq')->with('message', 'spacenq updated successfully');
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
    public function destroy(Request $request, $spacenq_id)
    {
        if(isset($spacenq_id) && is_numeric($spacenq_id))
        {
            $spacenq = Spacenq::find($spacenq_id);        
            $spacenq->delete();
            $request->session()->flash('message', 'spacenq deleted successfully');
            return Redirect::to('/admin/spacenq')->with('message', 'spacenq deleted successfully');
        } 
        else 
        {
            return Redirect::back()->with('message', 'Invalid Id');
        }
    }
}
