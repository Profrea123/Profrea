@extends('layouts.master')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Booking Details</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Booking details</li>
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
                                <a class="btn btn-success" href="{{ route('admin.booking_detail.index') }}"> Back</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped">
                                            <thead style="background-color: #c7dcfd">
                                                <tr>
                                                    <th colspan="2">Booking Slot information</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <th>Booking no</th>
                                                    <td>{{ $booking->booking_no }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Booking Date</th>
                                                    <td>{{ $booking->booking_date }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Booking Time</th>
                                                    <td>{{ $booking->booking_time }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Booking Type</th>
                                                    @if($booking->booking_type == 1)
                                                        <td>Audio</td>
                                                    @elseif($booking->booking_type == 2)
                                                        <td>Video</td>
                                                    @else
                                                        <td>In-Clinic</td>
                                                    @endif
                                                </tr>
                                                <tr>
                                                    <th>Booking Status</th>
                                                    <td> 
                                                        @if ($booking->booking_status == 0)
                                                            <span class="badge badge-warning">Pending</span> 
                                                        @elseif($booking->booking_status == 1)
                                                            <span class="badge badge-success">Completed</span> 
                                                        @else
                                                            <span class="badge badge-danger">Cancelled</span> 
                                                        @endif 
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped">
                                            <thead style="background-color: #c7dcfd">
                                                <tr>
                                                    <th colspan="2">Payment details</th>
                                                </tr>
                                            </thead>
                                            <tbody>     
                                                <tr>
                                                    <th>created at</th>
                                                    <td>{{ $booking->transaction_date }}</td>
                                                </tr> 
                                                <tr>
                                                    <th>Payment Mode</th>
                                                    <td>{{ $booking->payment_mode }}</td>
                                                </tr> 
                                                <tr>
                                                    <th>Payment Status</th>
                                                    <td>
                                                        @if ($booking->payment_status == 0)
                                                            <span class="badge badge-danger">Un-Settled</span> 
                                                        @else
                                                            <span class="badge badge-success">Settled</span> 
                                                        @endif
                                                    </td>
                                                </tr> 
                                                <tr>
                                                    <th>Sub Total</th>
                                                    <td>{{ $booking->sub_total }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Taxes & Charges</th>
                                                    <td>{{ $booking->tax_amount }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Total Amount</th>
                                                    <td>{{ $booking->amount }}</td>
                                                </tr>
                                                @if ($booking->booking_status == 2)
                                                    <tr>
                                                        <th>Refund Status</th>
                                                        <td>
                                                            @if ($booking->refund_status == 0)
                                                                <span class="badge badge-danger">Pending</span>
                                                            @else
                                                                <span class="badge badge-Success">Paid</span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Refund Date</th>
                                                        <td>{{ $booking->refund_date }}</td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped">
                                            <thead style="background-color: #c7dcfd">
                                                <tr>
                                                    <th colspan="2">Doctor Details</th>
                                                </tr>
                                            </thead>
                                            <tbody>     
                                                <tr>
                                                    <th>Name</th>
                                                    <td>{{ $booking->doctor->name ?? '' }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Education</th>
                                                    <td>{{ $booking->doctor->education }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Mobile</th>
                                                    <td>{{ $booking->doctor->mobileNo ?? '' }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Address</th>
                                                    <td>{{ $booking->doctor->address ?? ''}}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped">
                                            <thead style="background-color: #c7dcfd">
                                                <tr>
                                                    <th colspan="2">User Details</th>
                                                </tr>
                                            </thead>
                                            <tbody>     
                                                <tr>
                                                    <th>Name</th>
                                                    <td>{{ $booking->user->name ?? '' }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Mobile</th>
                                                    <td>{{ $booking->user->mobileNo ?? '' }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Address</th>
                                                    <td>{{ $booking->user->address ?? ''}}</td>
                                                </tr>
                                                <tr>
                                                    <th>Booking For</th>
                                                    <td>{{ $booking->booking_for?ucFirst($booking->booking_for) :  '-'}}</td>
                                                </tr>
                                                @if ($booking->booking_for == 'family')
                                                <tr>
                                                    <th>Family Member</th>
                                                    <td>{{ $booking->family_member?ucFirst($booking->family_member->name) : '-'}}</td>
                                                </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <?php if(count($booking->attachments) > 0) { ?>
                                <div class="col-md-12">
                                    <table class="table table-bordered table-striped">
                                        <thead style="background-color: #c7dcfd">
                                            <tr>
                                                <th colspan="2">Attachments</th>
                                            </tr>
                                        </thead>
                                    </table>
                                    <div class="row">
                                        <?php foreach($booking->attachments as $file){ $ext = pathinfo($file['attachment'], PATHINFO_EXTENSION);?>
                                            <div class="col-md-2">

                                                <?php if($ext == 'pdf') {?>
                                                    <iframe <?php if($file['attachment'] != '') {?> src="../../../../datafiles/uploads/patient_attachments/<?php echo $file['attachment'];?>" <?php } else { ?> src="images/no-image.png"<?php } ?> class="img-rounded" style="width:100%; height:100px;" alt=""></iframe>
                                                <?php } else {?>
                                                    <img <?php if($file['attachment'] != '') {?> src="../../../../datafiles/uploads/patient_attachments/<?php echo $file['attachment'];?>" <?php } else { ?> src="../../../../images/no-image.png"<?php } ?> class="img-rounded" style="width:100%; height:100px;" alt="">
                                                <?php } ?>
                                                <!-- View -->
                                                <a target="_blank" <?php if($file['attachment'] != '') {?> href="../../../../datafiles/uploads/patient_attachments/<?php echo $file['attachment'];?>" <?php } ?> ><button type="button" class="btn btn-sm btn-info mt-2"><i class="fa fa-eye"></i></button></a>
                                            
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection