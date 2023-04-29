<?php
namespace App\Http\Controllers;

use App\Plan;
use App\Featurelist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class PlanController extends Controller
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
        $plans = Plan::select('p2_plans.*')
            ->orderBy('p2_plans.id', 'DESC')
            ->paginate(10);
        // $plans = DB::table('p2_plans')->orderBy('id', 'desc')->paginate(2);
        return view('admin.plan.index', compact('plans'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.plan.create');
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
            'title' => 'required|max:255',
            'hours_per_day' => 'required',
            'hours_per_week' => 'required',
            'hours_per_month' => 'required',
            'plan_amount' => 'required',
            'cost_per_hour' => 'required',
            'initial_payment' => 'required',
            'status' => 'required'
        ]);
        if (!$validator->fails())
        {
            
            $data = [
                'title' => $request->input('title'),
                'plan_days' => $request->input('plan_days'),
                'hours_per_day' => $request->input('hours_per_day'),
                'hours_per_week' => $request->input('hours_per_week'),
                'hours_per_month' => $request->input('hours_per_month'),
                'plan_amount' => $request->input('plan_amount'),
                'cost_per_hour' => $request->input('cost_per_hour'),
                'initial_payment' => $request->input('initial_payment'),
                'branding'=> $request->input('branding'),
                'profrea_doctor_kit'=> $request->input('profrea_doctor_kit'),
                'receptionist_cum_helper'=> $request->input('receptionist_cum_helper'),
                'live_receptionist'=> $request->input('live_receptionist'), 
                'practo_prime'=> $request->input('practo_prime'),
                'on_call_feature'=> $request->input('on_call_feature'),
                'gmb'=> $gmb, 
                'social_media_management'=> $social_media_management,
                'opd_percent'=> $request->input('opd_percent'), 
                'feature15'=> $request->input('feature15'),
                'lab_referrals'=> $request->input('lab_referrals'), 
                'radiological_referrals'=> $request->input('radiological_referrals'),
                'medicine_referrals'=> $request->input('medicine_referrals'),
                'personalised_website'=> $request->input('personalised_website'), 
                'opd_management_software'=> $request->input('opd_management_software'),
                'mon_slots' => $request->input('mon_slots'),
                'tue_slots' => $request->input('tue_slots'),
                'wed_slots' => $request->input('wed_slots'),
                'thu_slots' => $request->input('thu_slots'),
                'fri_slots' => $request->input('fri_slots'),
                'sat_slots' => $request->input('sat_slots'),
                'sun_slots' => $request->input('sun_slots'),
                'status' => $request->input('status')
            ];
            $user = Plan::create($data);
            return Redirect::to('/admin/plan')->with('message', 'Plan added successfully');
        } 
        else 
        {
            return Redirect::back()->withErrors($validator->errors())->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Plan $plan_id
     * @return \Illuminate\Http\Response
     */
    public function show($plan_id)
    {
        $plan = Plan::select('p2_plans.*')
            ->find($plan_id);
        // $plan = Plan::find($plan_id);
        return view('admin.plan.show', compact('plan'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Plan $plan_id
     * @return \Illuminate\Http\Response
     */
    public function edit($plan_id)
    {
        $plan = Plan::find($plan_id);
        
        return view('admin.plan.edit', compact('plan'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Plan $plan_id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $plan_id)
    {
        $gmb = isset($request->gmb) ? $request->gmb : 0;
        $social_media_management = isset($request->social_media_management) ? $request->social_media_management : 0;
        if(isset($plan_id) && is_numeric($plan_id)) 
        {
            $plan = Plan::find($plan_id);
            $validator = Validator::make($request->all(), [
                'title' => 'required|max:255',
                'hours_per_day' => 'required',
                'hours_per_week' => 'required',
                'hours_per_month' => 'required',
                'plan_amount' => 'required',
                'cost_per_hour' => 'required',
                'initial_payment' => 'required',
                'status' => 'required'
            ]);
            if(!$validator->fails())
            {
                $plan->title = $request->input('title');
                $plan->plan_days = $request->input('plan_days');
                $plan->hours_per_day = $request->input('hours_per_day');
                $plan->hours_per_week = $request->input('hours_per_week');
                $plan->hours_per_month = $request->input('hours_per_month');
                $plan->plan_amount = $request->input('plan_amount');
                $plan->cost_per_hour = $request->input('cost_per_hour');
                $plan->initial_payment = $request->input('initial_payment');

                $plan->branding = $request->input('branding');
                $plan->profrea_doctor_kit = $request->input('profrea_doctor_kit');
                $plan->receptionist_cum_helper = $request->input('receptionist_cum_helper');
                $plan->live_receptionist = $request->input('live_receptionist');
                $plan->practo_prime = $request->input('practo_prime');
                $plan->on_call_feature = $request->input('on_call_feature');
                $plan->gmb = $gmb;
                $plan->social_media_management = $social_media_management;
                $plan->opd_percent = $request->input('opd_percent');
                $plan->feature15 = $request->input('feature15');
                $plan->lab_referrals = $request->input('lab_referrals');
                $plan->radiological_referrals = $request->input('radiological_referrals');
                $plan->medicine_referrals = $request->input('medicine_referrals');
                $plan->personalised_website = $request->input('personalised_website');
                $plan->opd_management_software = $request->input('opd_management_software');
                
                $plan->mon_slots = $request->input('mon_slots');
                $plan->tue_slots = $request->input('tue_slots');
                $plan->wed_slots = $request->input('wed_slots');
                $plan->thu_slots = $request->input('thu_slots');
                $plan->fri_slots = $request->input('fri_slots');
                $plan->sat_slots = $request->input('sat_slots');
                $plan->sun_slots = $request->input('sun_slots');
                $plan->status = $request->input('status');
                $plan->save();
                return Redirect::to('/admin/plan')->with('message', 'Plan updated successfully');
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
     * @param  \App\Plan $plan_id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $plan_id)
    {
        if(isset($plan_id) && is_numeric($plan_id))
        {
            $plan = Plan::find($plan_id);        
            $plan->delete();
            $request->session()->flash('message', 'Plan deleted successfully');
            return Redirect::to('/admin/plan')->with('message', 'Plan deleted successfully');
        } 
        else 
        {
            return Redirect::back()->with('message', 'Invalid Id');
        }
    }
}
