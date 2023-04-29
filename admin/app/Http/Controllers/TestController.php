<?php
namespace App\Http\Controllers;

use App\Plan;
use App\Featurelist;
use App\Models\Test;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class TestController extends Controller
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
        $tests = Test::get();
        return view('admin.test.index', compact('tests'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.test.create');
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
            $user = Test::create($data);
            return Redirect::to('/admin/test')->with('message', 'Test added successfully');
        } 
        else 
        {
            return Redirect::back()->withErrors($validator->errors())->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Plan $bt_id
     * @return \Illuminate\Http\Response
     */
    public function show($bt_id)
    {
        $test  = Test::find($bt_id);
        return view('admin.test.show', compact('test'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Plan $plan_id
     * @return \Illuminate\Http\Response
     */
    public function edit($bt_id)
    {
        $test = Test::where('bt_id',$bt_id)->first();
        
        return view('admin.test.edit', compact('test'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Plan $plan_id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $bt_id)
    {
        if(isset($bt_id) && is_numeric($bt_id)) 
        {
            // $plan = Test::find($bt_id);
            $test = Test::where('bt_id',$bt_id)->first();
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
                return Redirect::to('/admin/test')->with('message', 'Test updated successfully');
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
     * @param  \App\Models\Test $bt_id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $bt_id)
    {
        if(isset($bt_id) && is_numeric($bt_id))
        {
            // $test = Test::find($bt_id);        
            $test = Test::where('bt_id',$bt_id)->first();        
            $test->delete();
            $request->session()->flash('message', 'Test deleted successfully');
            return Redirect::to('/admin/test')->with('message', 'Test deleted successfully');
        } 
        else 
        {
            return Redirect::back()->with('message', 'Invalid Id');
        }
    }
}
