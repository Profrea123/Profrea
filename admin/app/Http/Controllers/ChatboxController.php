<?php

namespace App\Http\Controllers;

use App\DoctorTimeSlot;
use App\User;
use App\BookingDetail;
use App\Models\Chat_box;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class ChatboxController extends Controller
{
    public function __construct()
    {
        $this->middleware('web');
    }

    private function get_user_session($userid){
        $result = User::select('users.*','website_details.*','gender.name as gender_name','city.name as city_name','operating_specialty.name as speciality_name')
        ->leftJoin('gender', 'gender.id', '=', 'users.gender_id')
        ->leftJoin('city', 'city.id', '=', 'users.city')
        ->leftJoin('website_details', 'website_details.user_id', '=', 'users.id')
        ->leftJoin('operating_specialty', 'operating_specialty.id', '=', 'users.speciality')
        ->where('users.id', $userid)->first();
        return $result;
    }
    
    public function index(Request $request, $booking_no){
        $booking_details = BookingDetail::join('users', 'booking_details.user_id', '=', 'users.id')
        ->where('booking_details.booking_no', $booking_no)->first();
        if($booking_no !='' && $booking_details !=''):
            $login_id       = $booking_details->user_id;
            $row_user = $this->get_user_session($login_id);
            
            $doc = User::where(['id'=> $booking_details->doctor_id ])->first();
            $doctor_name = $doc->name; 

            $chat_list = Chat_box::join('users', 'chat_box.user_id', '=', 'users.id')
                    ->where(['chat_box.user_id'=> $booking_details->user_id, 'chat_box.reply_to' => $booking_details->doctor_id ])
                    ->get(['chat_box.*']);
            return view('user.chat', compact("booking_details","chat_list","row_user","doctor_name"));
        else:
            return view('user.chat')->with('status', 'Wrong Booking number!');
        endif;
    }

    public function insert(Request $request){
        $validator = Validator::make($request->all(), [
            'message' => 'required'
        ]);
        if(!$validator->fails()){
            // $post = new Chat_box;
            $data = [
                'user_id'   => $request->input('user_id'),
                'reply_to'  => $request->input('dr_id'),
                'reply_on'  => 0,
                'status'    => 1,
                'message'   => $request->input('message'),
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
    

    // ************************** Doctor Panel Start ******************************** //

    public function doctor_chat_list(Request $request, $booking_no){
        $booking_details = BookingDetail::join('users', 'booking_details.user_id', '=', 'users.id')
        ->where('booking_details.booking_no', $booking_no)->first();
        if($booking_no !='' && $booking_details !=''):
            $login_id       = $booking_details->user_id;
            $row_user = $this->get_user_session($login_id);
            
            $doc = User::where(['id'=> $booking_details->doctor_id ])->first();
            $doctor_name = $doc->name; 

            $chat_list = Chat_box::join('users', 'chat_box.user_id', '=', 'users.id')
                    ->where(['chat_box.user_id'=> $booking_details->user_id, 'chat_box.reply_to' => $booking_details->doctor_id ])
                    ->get(['chat_box.*']);
            return view('user.doctor_chat', compact("booking_details","chat_list","row_user","doctor_name"));
        else:
            return view('user.doctor_chat')->with('status', 'Wrong Booking number!');
        endif;
    }

    public function doctor_chat_insert(Request $request){
        $validator = Validator::make($request->all(), [
            'message' => 'required'
        ]);
        if(!$validator->fails()){
            // $post = new Chat_box;
            $data = [
                'user_id'   => $request->input('user_id'),
                'reply_to'  => $request->input('dr_id'),
                'reply_on'  => $request->input('reply_on'),
                'status'    => 1,
                'message'   => $request->input('message'),
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
  ?>