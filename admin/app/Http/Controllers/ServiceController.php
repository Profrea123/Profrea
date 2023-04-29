<?php
namespace App\Http\Controllers;

use App\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class ServiceController extends Controller
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

        $services = Service::select('doctor_services.*','operating_specialty.name as specname')
            ->leftJoin('operating_specialty', 'operating_specialty.id', '=', 'doctor_services.speciality')
            ->orderBy('doctor_services.id', 'DESC')
            
            ->paginate(10);
        // $plans = DB::table('p2_plans')->orderBy('id', 'desc')->paginate(2);
        return view('admin.service.index', compact('services'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        $ops = DB::table('operating_specialty')->get();
        return view('admin.service.create',compact('ops'));
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
            'name' => 'required|max:255',
            'description' => 'required',            
            'speciality' => 'required',
            'benefits' => 'required'
           
        ]);
        if (!$validator->fails()) 
        {

        $coverpic=$request->file('coverpic');
        $coverpic_name ="";
        if(!empty($coverpic)){

            $location_service_image= base_path().'/../datafiles/uploads/services';
            
            $test_profile_image = explode(".", $coverpic->getClientOriginalName());
            $extension = end($test_profile_image);
            $coverpic_name = rand(100000, 9999999).'.'.$extension;        
            $coverpic->move($location_service_image, $coverpic_name); 
        }



            $data = [
                'name' => $request->input('name'),
                'description' => $request->input('description'),
                'benefits' => $request->input('benefits'),
                'speciality' => $request->input('speciality'),
                'coverpic' => $coverpic_name
            ];
            $user = Service::create($data);
            return Redirect::to('/admin/service')->with('message', 'Service added successfully');
        } 
        else 
        {
            return Redirect::back()->withErrors($validator->errors())->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Service $plan_id
     * @return \Illuminate\Http\Response
     */
    public function show($service_id)
    {
        $service = Service::select('doctor_services.*','operating_specialty.name as specname')
                    ->leftJoin('operating_specialty', 'operating_specialty.id', '=', 'doctor_services.speciality')
                    ->find($service_id);
        // $plan = Plan::find($plan_id);
        return view('admin.service.show', compact('service'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Plan $plan_id
     * @return \Illuminate\Http\Response
     */
    public function edit($service_id)
    {
        $service = Service::find($service_id);
        $ops = DB::table('operating_specialty')->get();
        return view('admin.service.edit', compact('service','ops'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Service $plan_id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $service_id)
    {
        if(isset($service_id) && is_numeric($service_id)) 
        {
            $service = Service::find($service_id);
            $validator = Validator::make($request->all(), [
                'name' => 'required|max:255',
                'description' => 'required',
                'speciality' => 'required',
                'benefits' => 'required'
            ]);
            if(!$validator->fails()) 
            {


                $coverpic=$request->file('coverpic');
                $coverpic_name ="";
                if(!empty($coverpic)){
        
                    $location_service_image= base_path().'/../datafiles/uploads/services';
                    
                    $test_profile_image = explode(".", $coverpic->getClientOriginalName());
                    $extension = end($test_profile_image);
                    $coverpic_name = rand(100000, 9999999).'.'.$extension;        
                    $coverpic->move($location_service_image, $coverpic_name); 
                    $service->coverpic = $coverpic_name;
                   
                    $oldpic = $request->input('coverpicold');
                    if( $oldpic != ""){
                        $old_file = $location_service_image."/".$oldpic;
                        unlink($old_file);
                    }
                    

                }



                $service->name = $request->input('name');
                $service->description = $request->input('description');
                $service->speciality = $request->input('speciality');
                $service->benefits = $request->input('benefits');
               
                $service->save();
                return Redirect::to('/admin/service')->with('message', 'Service updated successfully');
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
     * @param  \App\service $plan_id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $service_id)
    {
        if(isset($service_id) && is_numeric($service_id))
        {
            $service = Service::find($service_id);        
            $service->delete();
            $request->session()->flash('message', 'Service deleted successfully');
            return Redirect::to('/admin/service')->with('message', 'Service deleted successfully');
        } 
        else 
        {
            return Redirect::back()->with('message', 'Invalid Id');
        }
    }
}
