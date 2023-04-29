<?php
namespace App\Http\Controllers;

use App\Booking;
use App\BookingDetail;
use App\Featurelist;
use App\Mail\CancelRefundMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class BookingDetailController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $booking_details = BookingDetail::when($request->date_time, function($query) use ($request) {
                    $query->where('booking_date','like','%'.$request->date_time.'%');
                })->when($request->booking_no, function($query) use ($request) {
                    $query->where('booking_no','like','%'.$request->booking_no.'%');
                })->when($request->doctor, function($query) use ($request) {
                    $query->whereHas('doctor',function ($q) use ($request){
                        $q->where('name','like','%'.$request->doctor.'%')->where('profession_id',1);
                    });
                })->when($request->user, function($query) use ($request) {
                    $query->whereHas('user',function ($q) use ($request){
                        $q->where('name','like','%'.$request->user.'%')->where('profession_id',5);
                    });
                })->when($request->type, function($query) use ($request) {
                    $query->where('booking_type','like','%'.$request->type.'%');
                })->with(['doctor','user'])->orderBy('id','desc')->paginate(10);
            
        return view('admin.booking_history.index', compact('booking_details'));
    }

    public function show($id)
    {
        $booking = BookingDetail::with(['doctor','user','attachments','family_member'])->firstWhere('booking_no', $id);

        return view('admin.booking_history.show', compact('booking'));
    }

    public function indexCancel(Request $request)
    {
        $booking_cancel = BookingDetail::when($request->date_time, function($query) use ($request) {
            $query->where('booking_date','like','%'.$request->date_time.'%');
        })->when($request->booking_no, function($query) use ($request) {
            $query->where('booking_no','like','%'.$request->booking_no.'%');
        })->when($request->doctor, function($query) use ($request) {
            $query->whereHas('doctor',function ($q) use ($request){
                $q->where('name','like','%'.$request->doctor.'%')->where('profession_id',1);
            });
        })->when($request->user, function($query) use ($request) {
            $query->whereHas('user',function ($q) use ($request){
                $q->where('name','like','%'.$request->user.'%')->where('profession_id',5);
            });
        })->when($request->type, function($query) use ($request) {
            $query->where('booking_type','like','%'.$request->type.'%');
        })->with(['doctor','user'])->where('refund_status', 0)->where('booking_status', 2)->where('payment_status', 1)->where('payment_mode','!=', 'cash')->orderBy('id','desc')->paginate(10);

        return view('admin.booking_cancel.index', compact('booking_cancel'));
    }
    
    public function showCancel($id)
    {
        $booking = BookingDetail::with(['doctor','user','attachments','family_member'])->firstWhere('booking_no', $id);

        return view('admin.booking_cancel.show', compact('booking'));
    }

    public function editCancel($id)
    {
        $booking = BookingDetail::firstWhere('booking_no', $id);

        return view('admin.booking_cancel.edit', compact('booking'));
    }

    public function updateCancel(Request $request, $id)
    {
        
        $booking = BookingDetail::with(['user'])->firstWhere('booking_no', $id);

        $mail = $booking->user->email;
        Mail::to($mail)->send(new CancelRefundMail($booking, $request->refund_date));

        $data['refund_date']    =   $request->refund_date;
        $data['refund_remarks'] =   $request->refund_remarks;
        $data['refund_status']  =    $request->refund_status;

        $booking->update($data);

        return redirect()->route('admin.booking_cancel.indexCancel');
    }
    
}