<?php
namespace App\Http\Controllers;

use App\Plan;
use App\Featurelist;
use App\Models\Test;
use App\Models\Instruction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class InstructionController extends Controller
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
        $tests = Instruction::get();
        return view('admin.instruction.index', compact('tests'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.instruction.create');
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
            $user = Instruction::create($data);
            return Redirect::to('/admin/instruction')->with('message', 'Instruction added successfully');
        } 
        else 
        {
            return Redirect::back()->withErrors($validator->errors())->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Plan $fui_id
     * @return \Illuminate\Http\Response
     */
    public function show($fui_id)
    {
        $test  = Instruction::find($fui_id);
        return view('admin.instruction.show', compact('test'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Plan $plan_id
     * @return \Illuminate\Http\Response
     */
    public function edit($fui_id)
    {
        $test = Instruction::where('fui_id',$fui_id)->first();
        
        return view('admin.instruction.edit', compact('test'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Plan $plan_id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $fui_id)
    {
        if(isset($fui_id) && is_numeric($fui_id)) 
        {
            // $plan = Instruction::find($fui_id);
            $test = Instruction::where('fui_id',$fui_id)->first();
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
                return Redirect::to('/admin/instruction')->with('message', 'Instruction updated successfully');
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
     * @param  \App\Models\Test $fui_id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $fui_id)
    {
        if(isset($fui_id) && is_numeric($fui_id))
        {      
            $test = Instruction::where('fui_id',$fui_id)->first();        
            $test->delete();
            // $request->session()->flash('message', 'Instruction deleted successfully');
            return Redirect::to('/admin/instruction')->with('message', 'Instruction deleted successfully');
        } 
        else 
        {
            return Redirect::back()->with('message', 'Invalid Id');
        }
    }
}
