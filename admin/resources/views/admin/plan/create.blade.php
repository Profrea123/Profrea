@extends('layouts.master')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Plan</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Plan</li>
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
                            <h3 class="card-title mt-2">Add New Plan</h3>
                            <div class="text-right">
                                <a class="btn btn-success" href="{{ route('admin.plan.index') }}"> Back</a>
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
                            <form action="{{ route('admin.plan.store') }}" method="POST">
                                @csrf                                
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-6">
                                        <div class="form-group">
                                            <strong>Title</strong>
                                            <input type="text" name="title" class="form-control" placeholder="Title">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-6">
                                        <div class="form-group">
                                            <strong>Plan Days</strong>
                                            <input type="text" name="plan_days" class="form-control" placeholder="Plan Days">
                                        </div>
                                    </div>
                                  
          <div class="row">  
          <div class="col-xs-12 col-sm-12 col-md-12">
          <h2>Hours & Costing</h2>                   
                                    </div>
                                
                                    <div class="col-xs-12 col-sm-12 col-md-4">
                                        <div class="form-group">
                                            <strong>Hours per day</strong>
                                            <input type="number" name="hours_per_day" class="form-control" placeholder="hours_per_day">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-4">
                                        <div class="form-group">
                                            <strong>Hours per week</strong>
                                            <input type="number" name="hours_per_week" class="form-control" placeholder="hours_per_week">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-4">
                                        <div class="form-group">
                                            <strong>Hours per month</strong>
                                            <input type="number" name="hours_per_month" class="form-control" placeholder="hours_per_month">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-4">
                                        <div class="form-group">
                                            <strong>Plan Amount</strong>
                                            <input type="number" name="plan_amount" class="form-control" placeholder="plan_amount">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-4">
                                        <div class="form-group">
                                            <strong>Cost per hour</strong>
                                            <input type="number" name="cost_per_hour" class="form-control" placeholder="cost_per_hour">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-4">
                                        <div class="form-group">
                                            <strong>Initial Payment</strong>
                                            <input type="number" name="initial_payment" class="form-control" placeholder="initial_payment">
                                        </div>
                                    </div>
</div>        

                                    <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                    <h2>Features</h2>                 
                                    </div>    
                                    <div class="col-xs-4 col-sm-4 col-md-2">
                                        <div class="form-group">
                                            <strong>Branding</strong>
                                            <select name="branding" class="form-control">
                                                <option value="0">No</option>
                                                <option value="1">Yes</option>
                                            </select>    
                                        </div>
                                    </div>
                                    <div class="col-xs-4 col-sm-4 col-md-2">
                                        <div class="form-group">
                                            <strong>Profrea Doctor Kit</strong>
                                            <select name="profrea_doctor_kit" class="form-control">
                                                <option value="0">No</option>
                                                <option value="1">Yes</option>
                                            </select>    
                                        </div>
                                    </div>
                                    <div class="col-xs-4 col-sm-4 col-md-2">
                                        <div class="form-group">
                                            <strong>Receptionist cum Helper</strong>
                                            <select name="receptionist_cum_helper" class="form-control">
                                                <option value="0">No</option>
                                                <option value="1">Yes</option>
                                            </select>    
                                        </div>
                                    </div>
                                    <div class="col-xs-4 col-sm-4 col-md-2">
                                        <div class="form-group">
                                            <strong>Live Receptionist</strong>
                                            <select name="live_receptionist" class="form-control">
                                                <option value="0">No</option>
                                                <option value="1">Yes</option>
                                            </select>    
                                        </div>
                                    </div>
                                    <div class="col-xs-4 col-sm-4 col-md-2">
                                        <div class="form-group">
                                            <strong>Practo Prime</strong>
                                            <select name="practo_prime" class="form-control">
                                                <option value="0">No</option>
                                                <option value="1">Yes</option>
                                            </select>    
                                        </div>
                                    </div>
                                    <div class="col-xs-4 col-sm-4 col-md-2">
                                        <div class="form-group">
                                            <strong>On Call Feature</strong>
                                            <select name="on_call_feature" class="form-control">
                                                <option value="0">No</option>
                                                <option value="1">Yes</option>
                                            </select>    
                                        </div>
                                    </div>
                                    <!--<div class="col-xs-4 col-sm-4 col-md-2">
                                        <div class="form-group">
                                            <strong>GMB</strong>
                                            <select name="gmb" class="form-control">
                                                <option value="0">No</option>
                                                <option value="1">Yes</option>
                                            </select>    
                                        </div>
                                    </div>
                                    <div class="col-xs-4 col-sm-4 col-md-2">
                                        <div class="form-group">
                                            <strong>Social Media Management</strong>
                                            <select name="social_media_management" class="form-control">
                                                <option value="0">No</option>
                                                <option value="1">Yes</option>
                                            </select>    
                                        </div>
                                    </div>-->
                                    <div class="col-xs-4 col-sm-4 col-md-2">
                                        <div class="form-group">
                                            <strong>100 percent OPD</strong>
                                            <select name="opd_percent" class="form-control">
                                                <option value="0">No</option>
                                                <option value="1">Yes</option>
                                            </select>    
                                        </div>
                                    </div>
                                    <div class="col-xs-4 col-sm-4 col-md-2">
                                        <div class="form-group">
                                            <strong>1.5 Feature</strong>
                                            <select name="feature15" class="form-control">
                                                <option value="0">No</option>
                                                <option value="1">Yes</option>
                                            </select>    
                                        </div>
                                    </div>
                                    <div class="col-xs-4 col-sm-4 col-md-2">
                                        <div class="form-group">
                                            <strong>Lab Referrals</strong>
                                            <select name="lab_referrals" class="form-control">
                                                <option value="0">No</option>
                                                <option value="1">Yes</option>
                                            </select>    
                                        </div>
                                    </div>
                                    <div class="col-xs-4 col-sm-4 col-md-2">
                                        <div class="form-group">
                                            <strong>Radiological Referrals</strong>
                                            <select name="radiological_referrals" class="form-control">
                                                <option value="0">No</option>
                                                <option value="1">Yes</option>
                                            </select>    
                                        </div>
                                    </div>
                                    <div class="col-xs-4 col-sm-4 col-md-2">
                                        <div class="form-group">
                                            <strong>Medicine Referrals</strong>
                                            <select name="medicine_referrals" class="form-control">
                                                <option value="0">No</option>
                                                <option value="1">Yes</option>
                                            </select>    
                                        </div>
                                    </div>
                                    <div class="col-xs-4 col-sm-4 col-md-2">
                                        <div class="form-group">
                                            <strong>Personalised Website</strong>
                                            <select name="personalised_website" class="form-control">
                                                <option value="0">No</option>
                                                <option value="1">Yes</option>
                                            </select>    
                                        </div>
                                    </div>
                                    <div class="col-xs-4 col-sm-4 col-md-2">
                                        <div class="form-group">
                                            <strong>OPD Management Software</strong>
                                            <select name="opd_management_software" class="form-control">
                                                <option value="0">No</option>
                                                <option value="1">Yes</option>
                                            </select>    
                                        </div>
                                    </div>
                                    
</div>


<div class="row">
<div class="col-xs-12 col-sm-12 col-md-12">
<h2>Time Slots</h2>                
<div class="alert alert-warning">
    <strong>NOTE...! </strong> Use this type of formats. example: 10-14,3-5,5:30-7:30 Also no spaces in between comma.
</div> 
</div>  
                                    
                                    <div class="col-xs-12 col-sm-12 col-md-4">
                                        <div class="form-group">
                                            <strong>Monday Slots</strong>
                                            <input type="text" name="mon_slots" class="form-control" placeholder="mon_slots">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-4">
                                        <div class="form-group">
                                            <strong>Tuesday Slots</strong>
                                            <input type="text" name="tue_slots" class="form-control" placeholder="tue_slots">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-4">
                                        <div class="form-group">
                                            <strong>Wednesday Slots</strong>
                                            <input type="text" name="wed_slots" class="form-control" placeholder="wed_slots">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-4">
                                        <div class="form-group">
                                            <strong>Thursday Slots</strong>
                                            <input type="text" name="thu_slots" class="form-control" placeholder="thu_slots">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-4">
                                        <div class="form-group">
                                            <strong>Friday Slots</strong>
                                            <input type="text" name="fri_slots" class="form-control" placeholder="fri_slots">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-4">
                                        <div class="form-group">
                                            <strong>Saturday Slots</strong>
                                            <input type="text" name="sat_slots" class="form-control" placeholder="sat_slots">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-4">
                                        <div class="form-group">
                                            <strong>Sunday Slots</strong>
                                            <input type="text" name="sun_slots" class="form-control" placeholder="sun_slots">
                                        </div>
                                    </div>
</div>            
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <strong>Status</strong>
                                            <div class="radio">
                                                <label class="c-radio">
                                                    <input type="radio" name="status" id="status_y" value="1" checked>
                                                    Verified
                                                </label>
                                                <br/>
                                                <label class="c-radio">
                                                    <input type="radio" name="status" id="status_n" value="0">
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