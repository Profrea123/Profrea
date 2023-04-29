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
                            <h3 class="card-title mt-2">Edit Plan</h3>
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
                            <form action="{{ route('admin.plan.update',$plan->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-6">
                                        <div class="form-group">
                                            <strong>Title</strong>
                                            <input type="text" name="title" class="form-control" placeholder="Title" value="{{ $plan->title }}">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-6">
                                        <div class="form-group">
                                            <strong>Plan Days</strong>
                                            <input type="text" name="plan_days" class="form-control" placeholder="Plan Days" value="{{ $plan->plan_days }}">
                                        </div>
                                    </div>
                                    <div class="row">  
          <div class="col-xs-12 col-sm-12 col-md-12">
          <h2>Hours & Costing</h2>                   
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-4">
                                        <div class="form-group">
                                            <strong>Hours per day</strong>
                                            <input type="number" name="hours_per_day" class="form-control" placeholder="hours_per_day" value="{{ $plan->hours_per_day }}">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-4">
                                        <div class="form-group">
                                            <strong>Hours per week</strong>
                                            <input type="number" name="hours_per_week" class="form-control" placeholder="hours_per_week" value="{{ $plan->hours_per_week }}">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-4">
                                        <div class="form-group">
                                            <strong>Hours per month</strong>
                                            <input type="number" name="hours_per_month" class="form-control" placeholder="hours_per_month" value="{{ $plan->hours_per_month }}">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-4">
                                        <div class="form-group">
                                            <strong>Plan Aamount</strong>
                                            <input type="number" name="plan_amount" class="form-control" placeholder="plan_amount" value="{{ $plan->plan_amount }}">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-4">
                                        <div class="form-group">
                                            <strong>Cost per hour</strong>
                                            <input type="number" name="cost_per_hour" class="form-control" placeholder="cost_per_hour" value="{{ $plan->cost_per_hour }}">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-4">
                                        <div class="form-group">
                                            <strong>Initial Payment</strong>
                                            <input type="number" name="initial_payment" class="form-control" placeholder="initial_payment" value="{{ $plan->initial_payment }}">
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
                                                <option {{$plan->branding==0?"selected":""}} value="0">No</option>
                                                <option  {{$plan->branding==1?"selected":""}} value="1">Yes</option>
                                            </select>    
                                        </div>
                                    </div>
                                    <div class="col-xs-4 col-sm-4 col-md-2">
                                        <div class="form-group">
                                            <strong>Profrea Doctor Kit</strong>
                                            <select name="profrea_doctor_kit" class="form-control">
                                                <option {{$plan->profrea_doctor_kit==0?"selected":""}} value="0">No</option>
                                                <option {{$plan->profrea_doctor_kit==1?"selected":""}} value="1">Yes</option>
                                            </select>    
                                        </div>
                                    </div>
                                    <div class="col-xs-4 col-sm-4 col-md-2">
                                        <div class="form-group">
                                            <strong>Receptionist cum Helper</strong>
                                            <select name="receptionist_cum_helper" class="form-control">
                                                <option {{$plan->receptionist_cum_helper==0?"selected":""}} value="0">No</option>
                                                <option {{$plan->receptionist_cum_helper==1?"selected":""}} value="1">Yes</option>
                                            </select>    
                                        </div>
                                    </div>
                                    <div class="col-xs-4 col-sm-4 col-md-2">
                                        <div class="form-group">
                                            <strong>Live Receptionist</strong>
                                            <select name="live_receptionist" class="form-control">
                                                <option {{$plan->live_receptionist==0?"selected":""}} value="0">No</option>
                                                <option {{$plan->live_receptionist==1?"selected":""}} value="1">Yes</option>
                                            </select>    
                                        </div>
                                    </div>
                                    <div class="col-xs-4 col-sm-4 col-md-2">
                                        <div class="form-group">
                                            <strong>Practo Prime</strong>
                                            <select name="practo_prime" class="form-control">
                                                <option {{$plan->practo_prime==0?"selected":""}} value="0">No</option>
                                                <option {{$plan->practo_prime==1?"selected":""}} value="1">Yes</option>
                                            </select>    
                                        </div>
                                    </div>
                                    <div class="col-xs-4 col-sm-4 col-md-2">
                                        <div class="form-group">
                                            <strong>On Call Feature</strong>
                                            <select name="on_call_feature" class="form-control">
                                                <option {{$plan->on_call_feature==0?"selected":""}} value="0">No</option>
                                                <option {{$plan->on_call_feature==1?"selected":""}} value="1">Yes</option>
                                            </select>    
                                        </div>
                                    </div>
                                    <!--<div class="col-xs-4 col-sm-4 col-md-2">
                                        <div class="form-group">
                                            <strong>GMB</strong>
                                            <select name="gmb" class="form-control">
                                                <option {{$plan->gmb==0?"selected":""}} value="0">No</option>
                                                <option {{$plan->gmb==1?"selected":""}} value="1">Yes</option>
                                            </select>    
                                        </div>
                                    </div>
                                    <div class="col-xs-4 col-sm-4 col-md-2">
                                        <div class="form-group">
                                            <strong>Social Media Management</strong>
                                            <select name="social_media_management" class="form-control">
                                                <option {{$plan->social_media_management==0?"selected":""}} value="0">No</option>
                                                <option {{$plan->social_media_management==1?"selected":""}} value="1">Yes</option>
                                            </select>    
                                        </div>
                                    </div>-->
                                    <div class="col-xs-4 col-sm-4 col-md-2">
                                        <div class="form-group">
                                            <strong>100 percent OPD</strong>
                                            <select name="opd_percent" class="form-control">
                                                <option {{$plan->opd_percent==0?"selected":""}} value="0">No</option>
                                                <option {{$plan->opd_percent==1?"selected":""}} value="1">Yes</option>
                                            </select>    
                                        </div>
                                    </div>
                                    <div class="col-xs-4 col-sm-4 col-md-2">
                                        <div class="form-group">
                                            <strong>1.5 Feature</strong>
                                            <select name="feature15" class="form-control">
                                                <option {{$plan->feature15==0?"selected":""}} value="0">No</option>
                                                <option {{$plan->feature15==1?"selected":""}} value="1">Yes</option>
                                            </select>    
                                        </div>
                                    </div>
                                    <div class="col-xs-4 col-sm-4 col-md-2">
                                        <div class="form-group">
                                            <strong>Lab Referrals</strong>
                                            <select name="lab_referrals" class="form-control">
                                                <option {{$plan->lab_referrals==0?"selected":""}} value="0">No</option>
                                                <option {{$plan->lab_referrals==1?"selected":""}} value="1">Yes</option>
                                            </select>    
                                        </div>
                                    </div>
                                    <div class="col-xs-4 col-sm-4 col-md-2">
                                        <div class="form-group">
                                            <strong>Radiological Referrals</strong>
                                            <select name="radiological_referrals" class="form-control">
                                                <option {{$plan->radiological_referrals==0?"selected":""}} value="0">No</option>
                                                <option {{$plan->radiological_referrals==1?"selected":""}} value="1">Yes</option>
                                            </select>    
                                        </div>
                                    </div>
                                    <div class="col-xs-4 col-sm-4 col-md-2">
                                        <div class="form-group">
                                            <strong>Medicine Referrals</strong>
                                            <select name="medicine_referrals" class="form-control">
                                                <option {{$plan->medicine_referrals==0?"selected":""}} value="0">No</option>
                                                <option {{$plan->medicine_referrals==1?"selected":""}} value="1">Yes</option>
                                            </select>    
                                        </div>
                                    </div>
                                    <div class="col-xs-4 col-sm-4 col-md-2">
                                        <div class="form-group">
                                            <strong>Personalised Website</strong>
                                            <select name="personalised_website" class="form-control">
                                                <option {{$plan->personalised_website==0?"selected":""}} value="0">No</option>
                                                <option {{$plan->personalised_website==1?"selected":""}} value="1">Yes</option>
                                            </select>    
                                        </div>
                                    </div>
                                    <div class="col-xs-4 col-sm-4 col-md-2">
                                        <div class="form-group">
                                            <strong>OPD Management Software</strong>
                                            <select name="opd_management_software" class="form-control">
                                                <option {{$plan->opd_management_software==0?"selected":""}} value="0">No</option>
                                                <option {{$plan->opd_management_software==1?"selected":""}} value="1">Yes</option>
                                            </select>    
                                        </div>
                                    </div>
                                    
</div>


<div class="row">
<div class="col-xs-12 col-sm-12 col-md-12">
<h2>Time Slots</h2>  
<div class="alert alert-warning">
    <strong>NOTE...! </strong> Use this type of formats. example: 10-14,3-5,5:30-7:30. Also no spaces in between comma.
</div>  
</div>      
             
                                    <div class="col-xs-12 col-sm-12 col-md-4">
                                        <div class="form-group">
                                            <strong>Monday Slots</strong>
                                            <input type="text" name="mon_slots" class="form-control" placeholder="mon_slots" value="{{ $plan->mon_slots }}">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-4">
                                        <div class="form-group">
                                            <strong>Tuesday Slots</strong>
                                            <input type="text" name="tue_slots" class="form-control" placeholder="tue_slots" value="{{ $plan->tue_slots }}">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-4">
                                        <div class="form-group">
                                            <strong>Wednesday Slots</strong>
                                            <input type="text" name="wed_slots" class="form-control" placeholder="wed_slots" value="{{ $plan->wed_slots }}">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-4">
                                        <div class="form-group">
                                            <strong>Thursday Slots</strong>
                                            <input type="text" name="thu_slots" class="form-control" placeholder="thu_slots" value="{{ $plan->thu_slots }}">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-4">
                                        <div class="form-group">
                                            <strong>Friday Slots</strong>
                                            <input type="text" name="fri_slots" class="form-control" placeholder="fri_slots" value="{{ $plan->fri_slots }}">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-4">
                                        <div class="form-group">
                                            <strong>Saturday Slots</strong>
                                            <input type="text" name="sat_slots" class="form-control" placeholder="sat_slots" value="{{ $plan->sat_slots }}">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-4">
                                        <div class="form-group">
                                            <strong>Sunday Slots</strong>
                                            <input type="text" name="sun_slots" class="form-control" placeholder="sun_slots" value="{{ $plan->sun_slots }}">
                                        </div>
                                    </div>
</div>     
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <strong>Status</strong>
                                            <div class="radio">
                                                <label class="c-radio">
                                                    <input type="radio" name="status" id="status_y" value="1" <?php echo ($plan['status']==1)?"checked":"" ?>>
                                                    Verified
                                                </label>
                                                <br/>
                                                <label class="c-radio">
                                                    <input type="radio" name="status" id="status_n" value="0" <?php echo ($plan['status']==0)?"checked":"" ?>>
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