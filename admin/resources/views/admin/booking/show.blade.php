@extends('layouts.master')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Booking</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Booking</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title mt-2">Show Booking</h3>
                            <div class="text-right">
                                <a class="btn btn-success" href="{{ route('admin.booking.index') }}"> Back</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="table-responsive">
                                    <table class="table table-bordered ">
                                        <tbody>
                                            <tr>
                                                <th>Booking Code</th>
                                                <td>{{ $booking->booking_code }}</td>
                                            </tr>                                            
                                            <tr>
                                                <th>User Name</th>
                                                <td>{{ $booking->user_name }}</td>
                                            </tr>
                                            <tr>
                                                <th>Space Name</th>
                                                <td>{{ $booking->space_name }}</td>
                                            </tr>
                                            <tr>
                                                <th>Plan Name</th>
                                                <td>{{ $booking->plan_name }}</td>
                                            </tr>
                                            <tr>
                                                <th>Booking From</th>
                                                <td>{{ $booking->booking_start_date }}</td>
                                            </tr> 
                                            <tr>
                                                <th>Booking To</th>
                                                <td>{{ $booking->booking_end_date }}</td>
                                            </tr> 
                                            <tr>
                                                <th>Monday Slots</th>
                                                <td>{{ $booking->mon_slots }}</td>
                                            </tr>
                                            <tr>
                                                <th>Tuesday Slots</th>
                                                <td>{{ $booking->tue_slots }}</td>
                                            </tr>
                                            <tr>
                                                <th>Wednesday Slots</th>
                                                <td>{{ $booking->wed_slots }}</td>
                                            </tr>
                                            <tr>
                                                <th>Thursday Slots</th>
                                                <td>{{ $booking->thu_slots }}</td>
                                            </tr>
                                            <tr>
                                                <th>Friday Slots</th>
                                                <td>{{ $booking->fri_slots }}</td>
                                            </tr>
                                            <tr>
                                                <th>Saturday Slots</th>
                                                <td>{{ $booking->sat_slots }}</td>
                                            </tr>
                                            <tr>
                                                <th>Sunday Slots</th>
                                                <td>{{ $booking->sun_slots }}</td>
                                            </tr>
                                            <tr>
                                                <th>Status</th>
                                                <td>{{ $booking->booking_status }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection