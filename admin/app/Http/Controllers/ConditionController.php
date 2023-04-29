<?php
namespace App\Http\Controllers;

use App\Plan;
use App\Featurelist;
use App\Models\Test;
use App\Models\Condition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class ConditionController extends Controller
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
        // echo 'test controller'; die;
        $tests = Condition::get();
        return view('admin.condition.index', compact('tests'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.condition.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $gmb = isset($request->gmb) ? $request->gmb : 0;
        $social_media_management = isset($request->social_media_management) ? $request->social_media_management : 0;

        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'desc' => 'required',
            'status' => 'required'
        ]);
        if (!$validator->fails())
        {
            
            $data = [
                'title' => $request->input('title'),
                'desc' => $request->input('desc'),
                'status' => $request->input('status'),
                'created_at' => date('Y-m-d H:i:s')
            ];
            $user = Condition::create($data);
            return Redirect::to('/admin/condition')->with('message', 'Condition added successfully');
        } 
        else 
        {
            return Redirect::back()->withErrors($validator->errors())->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Plan $hc_id
     * @return \Illuminate\Http\Response
     */
    public function show($hc_id)
    {
        $test  = Condition::find($hc_id);
        return view('admin.condition.show', compact('test'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Plan $plan_id
     * @return \Illuminate\Http\Response
     */
    public function edit($hc_id)
    {
        $test = Condition::where('hc_id',$hc_id)->first();
        
        return view('admin.condition.edit', compact('test'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Plan $plan_id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $hc_id)
    {
        if(isset($hc_id) && is_numeric($hc_id)) 
        {
            // $plan = Condition::find($hc_id);
            $test = Condition::where('hc_id',$hc_id)->first();
            $validator = Validator::make($request->all(), [
                'title' => 'required',
                'desc'  => 'required',
                'status' => 'required'
            ]);
            if(!$validator->fails())
            {
                $test->title    = $request->input('title');
                $test->desc      = $request->input('desc');
                $test->status    = $request->input('status');
                $test->updated_at= date('Y-m-d H:i:s');
                $test->save();
                return Redirect::to('/admin/condition')->with('message', 'Condition updated successfully');
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
     * @param  \App\Models\Condition $hc_id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $hc_id)
    {
        if(isset($hc_id) && is_numeric($hc_id))
        {      
            $test = Condition::where('hc_id',$hc_id)->first();        
            $test->delete();
            $request->session()->flash('message', 'Condition deleted successfully');
            return Redirect::to('/admin/condition')->with('message', 'Condition deleted successfully');
        } 
        else 
        {
            return Redirect::back()->with('message', 'Invalid Id');
        }
    }
}
