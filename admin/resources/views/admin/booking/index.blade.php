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
                            <div class="table-responsive">
                                <table class="table table-bordered ">
                                    <thead>
                                        <tr>
                                            <th>S.No</th>
                                            <th>Booking Code</th>
                                            <th>User Name</th>
                                            <th>Space Name</th>
                                            <th>Plan Name</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    @if (count($bookings) > 0)
                                    
                                    <tbody>
                                        @foreach ($bookings as $key => $booking)
                                        <tr>
                                            <td>{{ $bookings->firstItem() + $key }}</td>
                                            <td>{{ $booking->booking_code }}</td>
                                            <td>{{ $booking->user_name }}</td>
                                            <td>{{ $booking->space_name }}</td>
                                            <td>{{ $booking->plan_name }}</td>
                                            <td>
                                                <form action="{{ route('admin.booking.destroy',$booking->id) }}" method="POST">
                                                    <a class="btn btn-info" href="{{ route('admin.booking.show',$booking->id) }}">Show</a>
                                                    <!-- <a class="btn btn-primary" href="{{ route('admin.booking.edit',$booking->id) }}">Edit</a> -->
                                                    @csrf
                                                    @method('DELETE')
                                                    <!-- <button type="submit" class="btn btn-danger">Delete</button> -->
                                                </form>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    @else

                                    <tr>
                                        <td colspan="7" align="center">No Records Found</td>
                                    </tr>

                                    @endif
                                </table>
                            </div>
                        </div>
                        <div class="card-footer">
                            {{ $bookings->links('pagination::bootstrap-4') }}
                        </div>                        
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection