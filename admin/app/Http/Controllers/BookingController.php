<?php
namespace App\Http\Controllers;

use App\Booking;
use App\Featurelist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class BookingController extends Controller
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
        $bookings = Booking::select('space_bookings.*','users.name AS user_name','spaces.ws_name AS space_name','p2_plans.title AS plan_name')
            ->leftJoin('users', 'users.id', '=', 'space_bookings.user_id')
            ->leftJoin('spaces', 'spaces.id', '=', 'space_bookings.space_id')
            ->leftJoin('p2_plans', 'p2_plans.id', '=', 'space_bookings.plan_id')
            ->orderBy('space_bookings.id', 'DESC')
            ->paginate(10);
        return view('admin.booking.index', compact('bookings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $plan = DB::table('p2_plans')->get();
        return view('admin.booking.create', compact('plan'));
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
            'title' => 'required|max:255',
            'plan_id' => 'required',
            'hours_per_day' => 'required',
            'hours_per_week' => 'required',
            'hours_per_month' => 'required',
            'booking_amount' => 'required',
            'cost_per_hour' => 'required',
            'initial_payment' => 'required',
            'status' => 'required'
        ]);
        if (!$validator->fails()) 
        {
            $data = [
                'title' => $request->input('title'),
                'plan_id' => $request->input('plan_id'),
                'hours_per_day' => $request->input('hours_per_day'),
                'hours_per_week' => $request->input('hours_per_week'),
                'hours_per_month' => $request->input('hours_per_month'),
                'booking_amount' => $request->input('booking_amount'),
                'cost_per_hour' => $request->input('cost_per_hour'),
                'initial_payment' => $request->input('initial_payment'),
                'mon_slots' => $request->input('mon_slots'),
                'tue_slots' => $request->input('tue_slots'),
                'wed_slots' => $request->input('wed_slots'),
                'thu_slots' => $request->input('thu_slots'),
                'fri_slots' => $request->input('fri_slots'),
                'sat_slots' => $request->input('sat_slots'),
                'sun_slots' => $request->input('sun_slots'),
                'status' => $request->input('status')
            ];
            $user = Booking::create($data);
            return Redirect::to('/admin/booking')->with('message', 'Booking added successfully');
        } 
        else 
        {
            return Redirect::back()->withErrors($validator->errors())->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Booking $booking_id
     * @return \Illuminate\Http\Response
     */
    public function show($booking_id)
    {
        $booking = Booking::select('space_bookings.*','users.name AS user_name','spaces.ws_name AS space_name','p2_plans.title AS plan_name')
            ->leftJoin('users', 'users.id', '=', 'space_bookings.user_id')
            ->leftJoin('spaces', 'spaces.id', '=', 'space_bookings.space_id')
            ->leftJoin('p2_plans', 'p2_plans.id', '=', 'space_bookings.plan_id')
            ->find($booking_id);
        return view('admin.booking.show', compact('booking'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Booking $booking_id
     * @return \Illuminate\Http\Response
     */
    public function edit($booking_id)
    {
        $booking = Booking::find($booking_id);
        $plan = DB::table('p2_plans')->get();
        return view('admin.booking.edit', compact('booking','plan'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Booking $booking_id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $booking_id)
    {
        if(isset($booking_id) && is_numeric($booking_id)) 
        {
            $booking = Booking::find($booking_id);
            $validator = Validator::make($request->all(), [
                'title' => 'required|max:255',
                'plan_id' => 'required',
                'hours_per_day' => 'required',
                'hours_per_week' => 'required',
                'hours_per_month' => 'required',
                'booking_amount' => 'required',
                'cost_per_hour' => 'required',
                'initial_payment' => 'required',
                'status' => 'required'
            ]);
            if(!$validator->fails()) 
            {
                $booking->title = $request->input('title');
                $booking->plan_id = $request->input('plan_id');
                $booking->hours_per_day = $request->input('hours_per_day');
                $booking->hours_per_week = $request->input('hours_per_week');
                $booking->hours_per_month = $request->input('hours_per_month');
                $booking->booking_amount = $request->input('booking_amount');
                $booking->cost_per_hour = $request->input('cost_per_hour');
                $booking->initial_payment = $request->input('initial_payment');
                $booking->mon_slots = $request->input('mon_slots');
                $booking->tue_slots = $request->input('tue_slots');
                $booking->wed_slots = $request->input('wed_slots');
                $booking->thu_slots = $request->input('thu_slots');
                $booking->fri_slots = $request->input('fri_slots');
                $booking->sat_slots = $request->input('sat_slots');
                $booking->sun_slots = $request->input('sun_slots');
                $booking->status = $request->input('status');
                $booking->save();
                return Redirect::to('/admin/booking')->with('message', 'Booking updated successfully');
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
     * @param  \App\Booking $booking_id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $booking_id)
    {
        if(isset($booking_id) && is_numeric($booking_id))
        {
            $booking = Booking::find($booking_id);        
            $booking->delete();
            $request->session()->flash('message', 'Booking deleted successfully');
            return Redirect::to('/admin/booking')->with('message', 'Booking deleted successfully');
        } 
        else 
        {
            return Redirect::back()->with('message', 'Invalid Id');
        }
    }
}
