@extends('layouts.master')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Chat Box Request</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Chat Box Enquiry</li>
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
                            <h3 class="card-title mt-2">Chat box Request Lists</h3>
                           
                        </div>
                        <?php // echo '<pre>'; print_r($booking_details); ?>
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
                                        <th>Booking Number</th>
                                        <th>Patient</th>
                                        <th>Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                @if (count($chat_list) > 0)
                                <tbody>
                                    @foreach ($chat_list as $key => $oenq)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $oenq->booking_no }}</td>
                                        <td>{{ $oenq->user_name }}</td>
                                        <td>{{ $oenq->created_at }}</td>
                                        
                                        <td>
                                            <a class="btn btn-info" href="{{ url('admin/doctor/chat-with-client',$oenq->booking_no) }}">Chat History</a>
                                          
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                @else

                                <tr>
                                    <td colspan="4" align="center">No Records Found</td>
                                </tr>

                                @endif
                            </table>
                            </div>
                        </div>
                                              
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection