<?php
namespace App\Http\Controllers;

use App\Featurelist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class FeaturelistController extends Controller
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
        $feature_list = DB::table('p2_feature_list')->orderBy('id', 'desc')->paginate(10);
        return view('admin.feature_list.index', compact('feature_list'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.feature_list.create');
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
            'content' => 'required'
        ]);
        if (!$validator->fails()) 
        {
            $data = [
                'name' => $request->input('name'),
                'content' => $request->input('content')
            ];
            $user = Featurelist::create($data);
            return Redirect::to('/admin/feature_list')->with('message', 'Featurelist added successfully');
        } 
        else 
        {
            return Redirect::back()->withErrors($validator->errors())->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Featurelist $feature_list_id
     * @return \Illuminate\Http\Response
     */
    public function show($feature_list_id)
    {
        $feature_list = Featurelist::find($feature_list_id);        
        return view('admin.feature_list.show', compact('feature_list'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Featurelist $feature_list_id
     * @return \Illuminate\Http\Response
     */
    public function edit($feature_list_id)
    {
        $feature_list = Featurelist::find($feature_list_id);
        return view('admin.feature_list.edit', compact('feature_list'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Featurelist $feature_list_id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $feature_list_id)
    {
        if(isset($feature_list_id) && is_numeric($feature_list_id)) 
        {
            $feature_list = Featurelist::find($feature_list_id);
            $validator = Validator::make($request->all(), [
                'name' => 'required|max:255',
                'content' => 'required'
            ]);
            if(!$validator->fails()) 
            {
                $feature_list->name = $request->input('name');
                $feature_list->content = $request->input('content');
                $feature_list->save();
                return back()->with('success','Featurelist updated successfully!');
                // return Redirect::to('/admin/feature_list')->with('message', 'Featurelist updated successfully');
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
    public function destroy(Request $request, $feature_list_id)
    {
        if(isset($feature_list_id) && is_numeric($feature_list_id))
        {
            $feature_list = Featurelist::find($feature_list_id);        
            $feature_list->delete();
            $request->session()->flash('message', 'Featurelist deleted successfully');
            return Redirect::to('/admin/feature_list')->with('message', 'Featurelist deleted successfully');
        } 
        else 
        {
            return Redirect::back()->with('message', 'Invalid Id');
        }
    }
}
