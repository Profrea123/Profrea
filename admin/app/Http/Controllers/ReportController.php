<?php

namespace App\Http\Controllers;

use App\BookingDetail;
use App\User;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function indexSettle(Request $request){
        $doctors = User::where('profession_id', 1)->get();
        // $booking = [];
        // if(!empty($request->all())) {
            $booking =  BookingDetail::when($request, function($query) use ($request) {
                $from_date = $request->from_date ? date('Y-m-d', strtotime($request->from_date)) : '';
                $to_date = $request->to_date ? date('Y-m-d', strtotime($request->to_date)) : '';
                if (($from_date < $to_date) && $from_date && $to_date) {
                    $query->whereBetween('booking_date', [$from_date, $to_date]);
                } else{
                    if ($from_date) {
                        $query->where('booking_date', $from_date);
                    }
                }
            })->when($request->doctor, function($query) use ($request) {
                $query->where('doctor_id', $request->doctor);
            })->get();
        // }
        return view('admin.reports.settlement',compact('doctors','booking'));
    }
}