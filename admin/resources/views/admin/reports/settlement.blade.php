@extends('layouts.master')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Report</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="/home">Home</a></li>
            <li class="breadcrumb-item active">Settlement</li>
          </ol>
        </div>
      </div>
    </div>
    <!-- /.container-fluid -->
  </section>
  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Settlement </h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">

              <div class="row">
                <select id="doctor" class="form-control col-md-3 mb-2 ml-2">
                    <option value="">-- Select Doctor --</option>
                    @foreach ($doctors as $doctor)
                        <option value="{{$doctor->id}}" @isset(request()->doctor) @selected(request()->doctor == $doctor->id) @endisset>{{$doctor->name}}</option>
                    @endforeach
                </select>
                <input type="date" value="{{request()->from_date ?? ''}}" id="from_date" placeholder="From Date" autocomplete="off" class="form-control col-md-2 mb-2 ml-2">
                <input type="date" value="{{request()->to_date ?? ''}}" id="to_date" placeholder="To Date" autocomplete="off" class="form-control col-md-2 mb-2 ml-2">
                     <a href="javascript:void(0)"><button type="button" class="ml-2 btn btn-rounded btn-success filter"><i class="fa fa-filter"></i></button></a>
                @if (!empty(request()->doctor) || !empty(request()->from_date) || !empty(request()->to_date))
                    <a href="{{route('admin.report.indexSettle')}}"><button type="button" class="ml-2 btn btn-rounded btn-danger filter"><i class="fa fa-redo"></i></button> </a>
                @endif
              </div>
                
            </div>

          </div>
          <!-- /.card -->
        </div>
      </div>

      <div class="row">
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-secondary">
                <div class="inner">
                    <p>Total Bookings</p>
                    
                    <h4><b>{{ $booking ? $booking->count() : 0}}</b></h4>
                </div>
                <div class="icon">
                    <i class="fa fa-newspaper"></i>
                </div>
                {{-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> --}}
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-secondary">
                <div class="inner">
                    <p>No Of Completed Bookings</p>
                    <h4><b>{{ $booking ? $booking->where('booking_status', "1")->count() : 0 }}</b></h4>
                </div>
                <div class="icon">
                    <i class="fa fa-check"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-secondary">
                <div class="inner">
                    <p>No Of Pending Bookings</p>
                    <h4><b>{{ $booking ? $booking->where('booking_status', "0")->count() : 0 }}</b></h4>
                </div>
                <div class="icon">
                    <i class="fa fa-history"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-secondary">
                <div class="inner">
                    <p>No Of Cancelled Bookings</p>
                    <h4><b>{{ $booking ? $booking->where('booking_status', "2")->count() : 0 }}</b></h4>
                </div>
                <div class="icon">
                    <i class="fa fa-ban"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-secondary">
                <div class="inner">
                    <p>Time Duration</p>
                    @php
                        if(isset($booking)){
                            $duration = 0;
                            foreach ($booking as $value) {
                                preg_match("/([0-9]+)/", $value['time_duration'], $time_duration);
                                $duration           += $time_duration[0];
                            }
                            $time = intdiv($duration, 60).' Hour '. ($duration % 60). ' Minutes';
                        }
                    @endphp
                    <h4><b>{{ $booking ? $time : 0}}</b></h4>
                </div>
                <div class="icon">
                    <i class="fas fa-hourglass-half"></i>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-secondary">
                <div class="inner">
                    <p>No Of Audio Bookings</p>
                    <h4><b>{{ $booking ? $booking->where('booking_type', "1")->count() : 0 }}</b></h4>
                </div>
                <div class="icon">
                    <i class="fa fa-phone"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-secondary">
                <div class="inner">
                    <p>No Of Video Bookings</p>
                    <h4><b>{{ $booking ? $booking->where('booking_type', "2")->count() : 0 }}</b></h4>
                </div>
                <div class="icon">
                    <i class="fa fa-video"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-secondary">
                <div class="inner">
                    <p>No Of In-Clinic Bookings</p>
                    <h4><b>{{ $booking ? $booking->where('booking_type', "3")->count() : 0 }}</b></h4>
                </div>
                <div class="icon">
                    <i class="fa fa-hospital"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-secondary">
                <div class="inner">
                    <p>No Of Payment Via Online</p>
                    <h4><b>{{ $booking ? $booking->where('payment_mode','!=', "cash")->count() : 0 }}</b></h4>
                </div>
                <div class="icon">
                    <i class="fab fa-cc-visa"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-secondary">
                <div class="inner">
                    <p>Total Amount Via Online</p>
                    <h4><b>&#8377; {{ $booking ? $booking->where('payment_mode','!=', "cash")->sum('amount') : 0 }}</b></h4>
                </div>
                <div class="icon">
                    <i class="fas fa-hand-holding-usd"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-secondary">
                <div class="inner">
                    <p>No Of Payment Via Cash</p>
                    <h4><b>{{ $booking ? $booking->where('payment_mode', "cash")->count() : 0 }}</b></h4>
                </div>
                <div class="icon">
                    <i class="fas fa-cash-register"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-secondary">
                <div class="inner">
                    <p>Total Amount Via Cash</p>
                    <h4><b>&#8377; {{ $booking ? $booking->where('payment_mode', "cash")->sum('amount') : 0 }}</b></h4>
                </div>
                <div class="icon">
                    <i class="fas fa-money-bill-wave"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-secondary">
                <div class="inner">
                    <p>OverAll Total Amount</p>
                    <h4><b>&#8377; {{ $booking ? $booking->sum('amount') : 0 }}</b></h4>
                </div>
                <div class="icon">
                    <i class="fa fa-coins"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-secondary">
                <div class="inner">
                    <p>Return Refund Amount</p>
                    <h4><b>&#8377; {{ $booking ? $booking->where('refund_status', "1")->sum('amount') : 0 }}</b></h4>
                </div>
                <div class="icon">
                    <i class="fas fa-exchange-alt"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-secondary">
                <div class="inner">
                    <p>Cancel Booking Amount</p>
                    <h4><b>&#8377; {{ $booking ? $booking->where('booking_status', "2")->sum('amount') : 0 }}</b></h4>
                </div>
                <div class="icon">
                    <i class="fa fa-coins"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-secondary">
                <div class="inner">
                    <p>OverAll Profit Amount</p>
                    <h4><b>&#8377; {{ $booking ? $booking->sum('amount') -  ( $booking->where('booking_status', "2")->sum('amount') + $booking->where('refund_status', "1")->sum('amount')) : 0 }}</b></h4>
                </div>
                <div class="icon">
                    <i class="fas fa-balance-scale"></i>
                </div>
            </div>
        </div>
      </div>

    </div>
  </section>
</div>
@endsection

@section('scripts')
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script>
    $(document).ready(function(){
      $('.filter').click(function (){
        var doctor = $('#doctor').val();
        var from_date = $('#from_date').val();
        var to_date = $('#to_date').val();
        var url = "{{route('admin.report.indexSettle')}}"+'?doctor='+doctor+'&from_date='+from_date+'&to_date='+to_date;
        window.location.href = url;
      });
    });
  </script>
@endsection