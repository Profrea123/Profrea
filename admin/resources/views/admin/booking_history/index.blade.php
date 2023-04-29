@extends('layouts.master')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Booking History</h1>
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
                            <h3 class="card-title mt-2">List Bookings</h3>
                            <div class="text-right">
                                <!-- <a class="btn btn-success" href="{{ route('admin.booking.create') }}"> Add New</a> -->
                            </div>
                        </div>
                        <div class="card-body">
                            @if ($message = Session::get('success'))
                            <div class="alert alert-success alert-block">
                                <button type="button" class="close" data-dismiss="alert">×</button>    
                                <strong>{{ $message }}</strong>
                            </div>
                            @endif
                            <div class="row">
                                <input type="text" value="{{request()->booking_no ?? ''}}" id="booking_no" placeholder="Booking No" autocomplete="off" class="form-control col-md-2 mb-2 ml-2">
                                <input type="text" value="{{request()->date_time ?? ''}}" id="date_time" placeholder="Date Time" autocomplete="off" class="form-control col-md-2 mb-2 ml-2">
                                <input type="text" value="{{request()->doctor ?? ''}}" id="doctor" placeholder="Doctor" autocomplete="off" class="form-control col-md-2 mb-2 ml-2">
                                <input type="text" value="{{request()->user ?? ''}}" id="user" placeholder="User" autocomplete="off" class="form-control col-md-2 mb-2 ml-2">
                                <select id="type" class="form-control col-md-2 mb-2 ml-2">
                                    <option value="">-- Select --</option>
                                    <option value="1" @selected(request()->type == 1)>Audio</option>
                                    <option value="2" @selected(request()->type == 2)>Video</option>
                                    <option value="3" @selected(request()->type == 3)>In-Clinic</option>
                                </select>
                                {{-- <input type="text" value="{{request()->type ?? ''}}" id="type" placeholder="Type" autocomplete="off" class="form-control col-md-2 mb-2 ml-2"> --}}
                                  <a href="javascript:void(0)"><button type="button" class="ml-2 btn btn-rounded btn-success filter"><i class="fa fa-filter"></i></button></a>
                                @if (!empty(request()->booking_no) || !empty(request()->date_time) || !empty(request()->doctor) || !empty(request()->user) || !empty(request()->type))
                                  <a href="{{route('admin.booking_detail.index')}}"><button type="button" class="ml-2 btn btn-rounded btn-danger filter"><i class="fa fa-redo"></i></button> </a>
                                @endif
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered ">
                                    <thead>
                                        <tr>
                                            <th>S.No</th>
                                            <th>Booking No</th>
                                            <th>Date & time</th>
                                            <th>Doctor</th>
                                            <th>User</th>
                                            <th>Booking Type</th>
                                            <th>Booking Status</th>
                                            <th>Payment Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    @if (count($booking_details) > 0)
                                        
                                    <tbody>
                                        @foreach ($booking_details as $booking)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $booking->booking_no ?? ''}}</td>
                                            <td>{{ $booking->booking_date ?? '' }} <br> {{ $booking->booking_time ?? ''}}</td>
                                            <td>{{ $booking->doctor->name ?? ''}}</td>
                                            <td>{{ $booking->user->name ?? ''}}</td>
                                            <td>
                                                <?php   if($booking['booking_type'] == 1) { echo 'Audio'; }
                                                        elseif($booking['booking_type'] == 2) { echo 'Video'; } 
                                                        else{ echo 'In-Clinic'; }
                                                ?>
                                            </td>
                                            <td> 
                                                @if ($booking->booking_status == 0)
                                                    <span class="badge badge-warning">Pending</span> 
                                                @elseif($booking->booking_status == 1)
                                                    <span class="badge badge-success">Completed</span> 
                                                @else
                                                    <span class="badge badge-danger">Cancelled</span> 
                                                @endif 
                                            </td>
                                            <td> 
                                                @if ($booking->payment_status == 0)
                                                    <span class="badge badge-danger">Un-Settled</span> 
                                                @else
                                                    <span class="badge badge-success">Settled</span> 
                                                @endif
                                            </td>
                                            <td>
                                                @if ($booking->booking_status == 2 && $booking->refund_status == 0 && $booking->payment_status == 1)
                                                    <a class="btn btn-danger" href="{{ route('admin.booking_cancel.editCancel',$booking->booking_no) }}">Edit</a>
                                                @endif
                                                <a class="btn btn-info" href="{{ route('admin.booking_detail.show',$booking->booking_no) }}">Show</a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    @else

                                    <tr>
                                        <td colspan="9" align="center">No Records Found</td>
                                    </tr>

                                    @endif
                                </table>
                            </div>
                        </div>
                        {{$booking_details->links('pagination::bootstrap-4')}}                     
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
        var booking_no = $('#booking_no').val();
        var date_time = $('#date_time').val();
        var doctor = $('#doctor').val();
        var user = $('#user').val();
        var type = $('#type').val();
        var url = "{{route('admin.booking_detail.index')}}"+'?booking_no='+booking_no+'&date_time='+date_time+'&doctor='+doctor+'&user='+user+'&type='+type;
        window.location.href = url;
      });
    });
  </script>
@endsection