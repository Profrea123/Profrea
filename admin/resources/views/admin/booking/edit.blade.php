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
                            <h3 class="card-title mt-2">Edit Booking</h3>
                            <div class="text-right">
                                <a class="btn btn-success" href="{{ route('admin.booking.index') }}"> Back</a>
                            </div>
                        </div>
                        <div class="card-body">
                            @if ($errors->any())
                            <div class="alert alert-danger">
                                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif
                            <form action="{{ route('admin.booking.update',$booking->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-6">
                                        <div class="form-group">
                                            <strong>Title</strong>
                                            <input type="text" name="title" class="form-control" placeholder="Title" value="{{ $booking->title }}">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-6">
                                        <div class="form-group">
                                            <strong>Feature List</strong>
                                            <select name="feature_list_id" class="form-control">
                                                <option value="">--Select Feature List--</option>
                                                <?php
                                                foreach ($feature_list as $key => $feature) 
                                                {
                                                    $feature_id = $feature->id;
                                                    $feature_name = $feature->name;
                                                    ?>
                                                    <option value="<?php echo $feature_id; ?>" <?php echo ($feature_id==$booking->feature_list_id)?'selected':''; ?>><?php echo $feature_name; ?></option>;
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-4">
                                        <div class="form-group">
                                            <strong>Hours per day</strong>
                                            <input type="number" name="hours_per_day" class="form-control" placeholder="hours_per_day" value="{{ $booking->hours_per_day }}">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-4">
                                        <div class="form-group">
                                            <strong>Hours per week</strong>
                                            <input type="number" name="hours_per_week" class="form-control" placeholder="hours_per_week" value="{{ $booking->hours_per_week }}">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-4">
                                        <div class="form-group">
                                            <strong>Hours per month</strong>
                                            <input type="number" name="hours_per_month" class="form-control" placeholder="hours_per_month" value="{{ $booking->hours_per_month }}">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-4">
                                        <div class="form-group">
                                            <strong>Booking Aamount</strong>
                                            <input type="number" name="booking_amount" class="form-control" placeholder="booking_amount" value="{{ $booking->booking_amount }}">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-4">
                                        <div class="form-group">
                                            <strong>Cost per hour</strong>
                                            <input type="number" name="cost_per_hour" class="form-control" placeholder="cost_per_hour" value="{{ $booking->cost_per_hour }}">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-4">
                                        <div class="form-group">
                                            <strong>Initial Payment</strong>
                                            <input type="number" name="initial_payment" class="form-control" placeholder="initial_payment" value="{{ $booking->initial_payment }}">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-4">
                                        <div class="form-group">
                                            <strong>Monday Slots</strong>
                                            <input type="text" name="mon_slots" class="form-control" placeholder="mon_slots" value="{{ $booking->mon_slots }}">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-4">
                                        <div class="form-group">
                                            <strong>Tuesday Slots</strong>
                                            <input type="text" name="tue_slots" class="form-control" placeholder="tue_slots" value="{{ $booking->tue_slots }}">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-4">
                                        <div class="form-group">
                                            <strong>Wednesday Slots</strong>
                                            <input type="text" name="wed_slots" class="form-control" placeholder="wed_slots" value="{{ $booking->wed_slots }}">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-4">
                                        <div class="form-group">
                                            <strong>Thursday Slots</strong>
                                            <input type="text" name="thu_slots" class="form-control" placeholder="thu_slots" value="{{ $booking->thu_slots }}">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-4">
                                        <div class="form-group">
                                            <strong>Friday Slots</strong>
                                            <input type="text" name="fri_slots" class="form-control" placeholder="fri_slots" value="{{ $booking->fri_slots }}">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-4">
                                        <div class="form-group">
                                            <strong>Saturday Slots</strong>
                                            <input type="text" name="sat_slots" class="form-control" placeholder="sat_slots" value="{{ $booking->sat_slots }}">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-4">
                                        <div class="form-group">
                                            <strong>Sunday Slots</strong>
                                            <input type="text" name="sun_slots" class="form-control" placeholder="sun_slots" value="{{ $booking->sun_slots }}">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <strong>Status</strong>
                                            <div class="radio">
                                                <label class="c-radio">
                                                    <input type="radio" name="status" id="status_y" value="1" <?php echo ($booking['status']==1)?"checked":"" ?>>
                                                    Verified
                                                </label>
                                                <br/>
                                                <label class="c-radio">
                                                    <input type="radio" name="status" id="status_n" value="0" <?php echo ($booking['status']==0)?"checked":"" ?>>
                                                    Unverified
                                                </label>
                                            </div>
                                        </div>
                                    </div>                                    
                                    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection