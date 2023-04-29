<?php
namespace App\Http\Controllers;

use App\Spaceplan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class SpaceplanController extends Controller
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
        $space_plans = Spaceplan::select('p2_space_plan.*','spaces.ws_name as space_name','p2_plans.title as plan_name')
            ->leftJoin('spaces', 'spaces.id', '=', 'p2_space_plan.space_id')
            ->leftJoin('p2_plans', 'p2_plans.id', '=', 'p2_space_plan.plan_id')
            ->orderBy('p2_space_plan.id', 'DESC')
            ->paginate(10);
        return view('admin.space_plan.index', compact('space_plans'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $spaces = DB::table('spaces')->where('is_deleted', 0)->get();
        $plans = DB::table('p2_plans')->get();
        return view('admin.space_plan.create', compact('spaces','plans'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'space_id' => 'required',
            'plan_id' => 'required'
        ]);
        if (!$validator->fails()) 
        {
            $data = [
                'space_id' => $request->input('space_id'),
                'plan_id' => $request->input('plan_id'),
                'status' => $request->input('status')
            ];
            $user = Spaceplan::create($data);
            return Redirect::to('/admin/space_plan')->with('message', 'Spaceplan added successfully');
        } 
        else 
        {
            return Redirect::back()->withErrors($validator->errors())->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Spaceplan $space_plan_id
     * @return \Illuminate\Http\Response
     */
    public function show($space_plan_id)
    {
        $space_plan = Spaceplan::select('p2_space_plan.*','spaces.ws_name as space_name','p2_plans.title as plan_name')
            ->leftJoin('spaces', 'spaces.id', '=', 'p2_space_plan.space_id')
            ->leftJoin('p2_plans', 'p2_plans.id', '=', 'p2_space_plan.plan_id')
            ->find($space_plan_id);
        return view('admin.space_plan.show', compact('space_plan'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Spaceplan $space_plan_id
     * @return \Illuminate\Http\Response
     */
    public function edit($space_plan_id)
    {
        $space_plan = Spaceplan::find($space_plan_id);
        $spaces = DB::table('spaces')->where('is_deleted', 0)->get();
        $plans = DB::table('p2_plans')->get();
        return view('admin.space_plan.edit', compact('space_plan','spaces','plans'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Spaceplan $space_plan_id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $space_plan_id)
    {
        if(isset($space_plan_id) && is_numeric($space_plan_id)) 
        {
            $space_plan = Spaceplan::find($space_plan_id);
            $validator = Validator::make($request->all(), [
                'space_id' => 'required|max:255',
                'plan_id' => 'required'
            ]);
            if(!$validator->fails()) 
            {
                $space_plan->space_id = $request->input('space_id');
                $space_plan->plan_id = $request->input('plan_id');
                $space_plan->status = $request->input('status');
                $space_plan->save();
                return Redirect::to('/admin/space_plan')->with('message', 'Spaceplan updated successfully');
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
     * @param  \App\Spaceplan $space_plan_id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $space_plan_id)
    {
        if(isset($space_plan_id) && is_numeric($space_plan_id))
        {
            $space_plan = Spaceplan::find($space_plan_id);        
            $space_plan->delete();
            $request->session()->flash('message', 'Spaceplan deleted successfully');
            return Redirect::to('/admin/space_plan')->with('message', 'Spaceplan deleted successfully');
        } 
        else 
        {
            return Redirect::back()->with('message', 'Invalid Id');
        }
    }
}
