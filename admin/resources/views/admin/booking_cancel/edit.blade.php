@extends('layouts.master')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Booking Cancel</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Booking cancel</li>
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
                            <h3 class="card-title mt-2">Edit Booking Cancel</h3>
                            <div class="text-right">
                                <a class="btn btn-success" href="{{ redirect()->getUrlGenerator()->previous() }}"> Back</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.booking_cancel.updateCancel',$booking->booking_no) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-4">
                                        <div class="form-group">
                                            <strong>Refund Date</strong>
                                            <input type="date" name="refund_date" class="form-control" value="{{$booking->refund_date}}">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-4">
                                        <div class="form-group">
                                            <strong>Remarks</strong>
                                            <textarea  name="refund_remarks" class="form-control">{{$booking->refund_remarks}}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <strong>Refund Status</strong>
                                            <div class="radio">
                                                <label class="c-radio">
                                                    <input type="radio" name="refund_status" id="status_y" value="1" <?php echo ($booking['refund_status']==1)?"checked":"" ?> required>
                                                    Paid
                                                </label>
                                                <br/>
                                                <label class="c-radio">
                                                    <input type="radio" name="refund_status" id="status_n" value="0" <?php echo ($booking['refund_status']==0)?"checked":"" ?> required>
                                                    Pending
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