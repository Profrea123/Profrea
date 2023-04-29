<?php

namespace App\Http\Controllers;

use App\DoctorTimeSlot;
use App\User;
use App\BookingDetail;
use App\Models\Chat_box;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * User listing
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        // $users = User::orderBy('id', 'DESC')->paginate(5);
        $users = User::select('users.*','gender.name as gender_name','city.name as city_name','operating_specialty.name as speciality_name')
            ->leftJoin('gender', 'gender.id', '=', 'users.gender_id')
            ->leftJoin('city', 'city.id', '=', 'users.city')
            ->leftJoin('operating_specialty', 'operating_specialty.id', '=', 'users.speciality')
            ->where('users.profession_id', 5)
            ->when($request->name, function($query) use ($request) {
                $query->where('users.name','like','%'.$request->name.'%');
            })
            ->when($request->email, function($query) use ($request) {
                $query->where('users.email','like','%'.$request->email.'%');
            })
            ->when($request->phone, function($query) use ($request) {
                $query->where('users.mobileNo','like','%'.$request->phone.'%');
            })
            ->orderBy('users.id', 'DESC')
            ->paginate(10);
        return view('admin.user.user', compact('users'));
    }

    public function doctor_index(Request $request)
    {
        //dd($request->all());
        // $users = User::orderBy('id', 'DESC')->paginate(5);
        $users = User::select('users.*','gender.name as gender_name','city.name as city_name','operating_specialty.name as speciality_name')
            ->leftJoin('gender', 'gender.id', '=', 'users.gender_id')
            ->leftJoin('city', 'city.id', '=', 'users.city')
            ->leftJoin('operating_specialty', 'operating_specialty.id', '=', 'users.speciality')
            ->where('users.profession_id', 1)
            ->when($request->name, function($query) use ($request) {
                $query->where('users.name','like','%'.$request->name.'%');
            })
            ->when($request->email, function($query) use ($request) {
                $query->where('users.email','like','%'.$request->email.'%');
            })
            ->when($request->phone, function($query) use ($request) {
                $query->where('users.mobileNo','like','%'.$request->phone.'%');
            })
            ->when($request->speciality, function($query) use ($request) {
                $query->where('operating_specialty.name','like','%'.$request->speciality.'%');
            })
            ->orderBy('users.id', 'DESC')
            ->paginate(10);
        return view('admin.user.doctor', compact('users'));
    }

    /**
     * Create user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        //$restaurantData = Restaurant::select('id','restaurant_name')->orderBy('id','DESC')->get();
        //return view('user.create', compact('restaurantData'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'restaurant_id' => 'required|exists:restaurants,id',
            'fname'         => 'required|max:255',
            'lname'         => 'required|max:255',
            'email'         => 'required|string|email|max:255|unique:users',
            'password'      => 'required|min:8|max:64|confirmed',
            'status'        => 'required|in:0,1',
        ]);
        if (!$validator->fails()) {
            $data = [
                'restaurant_id' => $request->input('restaurant_id'),
                'fname'         => strtolower($request->input('fname')),
                'lname'         => strtolower($request->input('lname')),
                'email'         => $request->input('email'),
                'password'      => Hash::make($request->input('password')),
                'status'        => $request->input('status'),
            ];
            //dd($data);
            $user = User::create($data);
            return Redirect::back()->with('message', 'User added successfully');
        } else {

            return Redirect::back()->withErrors($validator->errors())->withInput();
        }

    }

    /**
     * User edit
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        // $user = User::find($id);
        
        $user = User::select('users.*','website_details.*','gender.name as gender_name','city.name as city_name','operating_specialty.name as speciality_name')
            ->leftJoin('website_details', 'website_details.user_id', '=', 'users.id')
            ->leftJoin('gender', 'gender.id', '=', 'users.gender_id')
            ->leftJoin('city', 'city.id', '=', 'users.city')
            ->leftJoin('operating_specialty', 'operating_specialty.id', '=', 'users.speciality')
            ->find($id);
        $cities = DB::table('city')->get();

        return view('admin.user.edit',compact("user","cities"));
    }

    public function delete(Request $request, $id)
    {
        if(isset($id) && is_numeric($id))
        {
                  
            try{
                $enquiry = User::find($id); 
                $enquiry->delete();

                if($enquiry->password == 5) {
                    return Redirect::to('/admin/user')->with('message', 'User deleted successfully');
                } else {
                    return Redirect::to('/admin/doctor')->with('message', 'Doctor deleted successfully');
                }
            }
            catch(Exception $e) {
                $request->session()->flash('message',$e->getMessage());
              }
        }
        else 
        {
            return Redirect::back()->with('message', 'Invalid Id');
        }
    }

    /**
     * User edit update
     * @param Request $request
     * @param         $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        if(isset($id) && is_numeric($id)) {
            $user = User::find($id);
            
            $oldEmail = $user->email;
            if($oldEmail === $request->get('email')) {
                // no change, validation - exists
                $emailValidation = 'exists';
            } else {
                // change, validation - unique
                $emailValidation = 'unique';
            }
            $validator = Validator::make($request->all(), [
                'name'         => 'required|max:255',
                'email'         => 'required|string|email|max:255|' . $emailValidation . ':users',
                'password' => 'sometimes|nullable|max:50|min:5',
                //'image_delete'  => 'sometimes|nullable|in:1',
            ]);

            if(!$validator->fails()) {
                $user->name = $request->input('name');
                $user->email = $request->input('email');
                $user->mobileNo = $request->input('mobileNo');
                $user->address = $request->input('address');
                $user->landmark = $request->input('landmark');
                $user->city = $request->input('city');
                $user->state = $request->input('state');
                $user->pinCode = $request->input('pinCode');
                $user->is_verified = $request->input('is_verified');
                if($request->input('password'))
                    $user->password = Hash::make($request->input('password'));
                $user->save();

                if($request->prof_id == 5) {
                    return Redirect::to('/admin/user')->with('message', 'User updated successfully');
                } else {
                    return Redirect::to('/admin/doctor')->with('message', 'Doctor updated successfully');
                }

            } else {
                if($request->prof_id == 5) {
                    return Redirect::to('/admin/user')->withErrors($validator->errors())->withInput();
                } else {
                    return Redirect::to('/admin/doctor')->withErrors($validator->errors())->withInput();
                }
            }
        }
        if($request->prof_id == 5) {
            return Redirect::to('/admin/user')->with('message', 'Invalid Id');
        } else {
            return Redirect::to('/admin/doctor')->with('message', 'Invalid Id');
        }
    }

    public function show($id)
    {
        $user = User::select('users.*','website_details.*','gender.name as gender_name','city.name as city_name','operating_specialty.name as speciality_name')
            ->leftJoin('gender', 'gender.id', '=', 'users.gender_id')
            ->leftJoin('city', 'city.id', '=', 'users.city')
            ->leftJoin('website_details', 'website_details.user_id', '=', 'users.id')
            ->leftJoin('operating_specialty', 'operating_specialty.id', '=', 'users.speciality')
            ->where('users.id', $id)->first();

        if($user->profession_id == 1 )
        {
            $audio_slots    = DoctorTimeSlot::with('timeslots')->where('doctor_id', $id)->where('type', 1)->get();
            $video_slots    = DoctorTimeSlot::with('timeslots')->where('doctor_id', $id)->where('type', 2)->get();
            $clinic_slots   = DoctorTimeSlot::with('timeslots')->where('doctor_id', $id)->where('type', 3)->get();
            $holidays       = User::with(['holidays'])->where('id', $id)->first();
            
            return view('admin.user.view', compact('user','audio_slots','video_slots','clinic_slots','holidays'));
        }

        if($user->profession_id == 5 )
        {
            $family = User::with(['family_members'])->where('id', $id)->first();

            return view('admin.user.view', compact('user','family'));
        }
    }

    public function chat(){
        $chat_list = BookingDetail::select(['booking_details.booking_no','chat_box.*', 'users.name as user_name', 'users.id'])
        ->join('users', 'booking_details.user_id', '=', 'users.id')
        ->join('chat_box', 'chat_box.user_id', '=', 'users.id')
        ->orderBy('chat_box.cb_id','desc')
        ->groupBy(['users.id'])
        ->get()->all();

        // $chat_list = Chat_box::select(['chat_box.*', 'users.name as user_name', 'users.id'])
        //         ->join('users', 'chat_box.user_id', '=', 'users.id')
        //         ->orderBy('chat_box.cb_id','desc')
        //         ->groupBy(['users.id'])
        //         ->get()->all();
        return view('admin.chat_box.index', compact('chat_list'));
    }

    public function chatWithClient(Request $request, $booking_no){
        $follow_up = Followup::select('followup.*','users.name','users.id as user_id, users.profile_picture')->join('users', 'followup.user_id', '=', 'users.id')->where('followup.booking_no', $booking_no)->get();
        $booking_details = BookingDetail::join('users', 'booking_details.user_id', '=', 'users.id')
        ->where('booking_details.booking_no', $booking_no)->first();
        if($booking_no !='' && $booking_details !=''):
        if($follow_up->days !='' && $follow_up !=''):
            $date    = $follow_up->created_at; 
            $expdate =  date('Y-m-d', strtotime($date. ' + '.$follow_up->days.' days'));
            if($expdate >= date('Y-m-d')):
                    $login_id       = $booking_details->user_id;           
                    $row_user = User::where(['id'=> $login_id])->first();
                    
                    $doc = User::where(['id'=> $booking_details->doctor_id ])->first();
                    $doctor_name = $doc->name; 

                    $chat_list = Chat_box::join('users', 'chat_box.user_id', '=', 'users.id')
                            ->where(['chat_box.user_id'=> $booking_details->user_id, 'chat_box.reply_to' => $booking_details->doctor_id ])
                            ->get(['chat_box.*']);
                    return view('admin.chat_box.chat', compact("booking_details","chat_list","row_user","doctor_name"));
                else:
                    return view('admin.chat_box.chat')->with('status', 'Appointment has been Expired, Please take a new booking!');
                endif;
            else:
                return view('admin.chat_box.chat')->with('status', 'Please consult with doctor first!');
            endif;
        else:
            return view('admin.chat_box.chat')->with('status', 'Wrong Booking number!');
        endif;
    }

    public function admin_chat_insert(Request $request){
        $validator = Validator::make($request->all(), [
            'message' => 'required'
        ]);
        if(!$validator->fails()){
            // $post = new Chat_box;
            $data = [
                'user_id'   => $request->input('user_id'),
                'reply_to'  => $request->input('dr_id'),
                'reply_on'  => $request->input('reply_on'),
                'message'   => $request->input('message'),
                'status'    => 1,
                'admin_reply' => 1,
                'created_at'=> date('Y-m-d H:i:s'),
            ];
            
            $user =  Chat_box::create($data);
        
            return Redirect::back()->with('status', 'Message sent!');
        } 
        else 
        {
            return Redirect::back()->withErrors($validator->errors())->withInput();
        }
    }

}
