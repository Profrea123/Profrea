@extends('layouts.master')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>User Form</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('admin/home') }}">Home</a></li>
                            <li class="breadcrumb-item active">User Form</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <!-- left column -->
                    <div class="col-md-12">
                        <!-- general form elements -->
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">User Edit</h3>
                            </div>
                            <div class="row p-3">
                            <div class="col-md-6">
                                <form action="{{ url('admin/user/update/'.$user->user_id) }}" method="post">
                                @csrf
                                <div class="card-body">
                                        <div class="form-group">
                                            <label for="name">Name</label>
                                            <input type="name" name="name" class="form-control" value="{{ count(old())==0 ? $user->name : old('name') }}" required autocomplete="off" id="name" placeholder="Enter name">
                                        </div>
                                        <div class="form-group">
                                            <label for="email">Email address</label>
                                            <input type="email" name="email" class="form-control" value="{{ count(old())==0 ? $user->email : old('email') }}" required autocomplete="off" id="email" placeholder="Enter email">
                                        </div>
                                        <div class="form-group">
                                            <label for="mobileNo">Mobile</label>
                                            <input type="mobileNo" name="mobileNo" class="form-control" value="{{ count(old())==0 ? $user->mobileNo : old('mobileNo') }}" required autocomplete="off" id="mobileNo" placeholder="Enter mobileNo">
                                        </div>
                                        <div class="form-group">
                                            <label for="address">Address</label>
                                            <input type="address" name="address" class="form-control" value="{{ count(old())==0 ? $user->address : old('address') }}" autocomplete="off" id="address" placeholder="Enter Address">
                                        </div>
                                        <div class="form-group">
                                            <label for="landmark">Landmark</label>
                                            <input type="landmark" name="landmark" class="form-control" value="{{ count(old())==0 ? $user->landmark : old('landmark') }}" autocomplete="off" id="landmark" placeholder="Enter landmark">
                                        </div>
                                        <div class="form-group">
                                            <label for="city">City</label>
                                            <!-- <input type="city" name="city" class="form-control" value="{{ count(old())==0 ? $user->city : old('city') }}" autocomplete="off" id="city" placeholder="Enter City"> -->
                                            <select name="city" id="city" class="form-control">
                                                <option value="">--Select City--</option>
                                                <?php
                                                foreach ($cities as $key => $city) {
                                                    $city_id = $city->id;
                                                    $city_name = $city->name;
                                                    ?>
                                                    <option value="<?php echo $city_id; ?>" <?php echo ($city_id==$user->city)?'selected':''; ?>><?php echo $city_name; ?></option>';
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="state">State</label>
                                            <input type="state" name="state" class="form-control" value="{{ count(old())==0 ? $user->state : old('state') }}" autocomplete="off" id="state" placeholder="Enter state">
                                        </div>
                                        <input type="hidden" name="prof_id" value="{{$user->profession_id}}" class="form-control">
                                        <div class="form-group">
                                            <label for="pinCode">PinCode</label>
                                            <input type="pinCode" name="pinCode" class="form-control" value="{{ count(old())==0 ? $user->pinCode : old('pinCode') }}" autocomplete="off" id="pinCode" placeholder="Enter pinCode">
                                        </div>
                                        <div class="form-group">
                                            <label for="is_verified">Status</label>
                                            <div class="radio">
                                                <label class="c-radio">
                                                    <input type="radio" name="is_verified" id="is_verified_y" value="1" <?php echo ($user['is_verified']==1)?"checked":"" ?>>
                                                    Verified
                                                </label>
                                                <br/>
                                                <label class="c-radio">
                                                    <input type="radio" name="is_verified" id="is_verified_n" value="0" <?php echo ($user['is_verified']==0)?"checked":"" ?>>
                                                    Unverified
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.card-body -->
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </form>
                            </div>
                            @if ($user->profession_id ==1)
                                
                            <div class="col-md-6 mt-5">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr class="text-center">
                                                <th colspan="2">Website Details</th>    
                                            </tr>
                                        </thead>
                                        <tbody >
                                            <tr>
                                                <th>Domain</th>    
                                                <td>{{ $user->domain ?? '' }}</td>
                                            </tr> 
                                            <tr>  
                                                <th>
                                                    Slot Interval <br>
                                                    Video Booking Open Upto <br>
                                                    Video Booking Slot Status <br>
                                                    Video Amount
                                                </th> 
                                                <td>{{ $user->slot_interval ?? '' }} <br> 
                                                    {{ $user->booking_open_upto ? $user->booking_open_upto.' Days' :  '' }} <br> 
                                                    {{ $user->booking_slot_status ? 'Open' : 'Close' }} <br> 
                                                    {{ $user->video_amount ?? '' }}
                                                </td>
                                            </tr>   
                                            <tr>  
                                                <th>Audio Slot Interval <br>
                                                    Audio Booking Open Upto <br>
                                                    Audio Booking Slot Status <br>
                                                    Audio Amount </th> 
                                                <td>{{ $user->audio_slot_interval ?? '-' }} <br>
                                                    {{ $user->audio_booking_open_upto ? $user->audio_booking_open_upto.' Days' : '' }} <br>
                                                    {{ $user->audio_booking_slot_status ? 'Open' : 'Close' }} <br>
                                                    {{ $user->audio_amount ?? '' }}</td>
                                            </tr>   
                                            <tr>  
                                                <th>Clinic Slot Interval <br>
                                                    Clinic Booking Open Upto <br>
                                                    Clinic Booking Slot Status <br>
                                                    Clinic Amount</th> 
                                                <td>{{ $user->clinic_slot_interval ?? '-' }} <br>
                                                    {{ $user->clinic_booking_open_upto ? $user->clinic_booking_open_upto.' Days' : '' }} <br>
                                                    {{ $user->clinic_booking_slot_status ? 'open' : '' }} <br>
                                                    {{ $user->clinic_amount ?? '' }}</td> 
                                            </tr>  

                                            <tr>  
                                                <th>Facebook <br>
                                                    Twitter <br>
                                                    Linked-In <br>
                                                    Instagram <br>
                                                    Google Review</th> 
                                                <td>{{ $user->fb_link ?? '-' }} <br>
                                                    {{ $user->twitter_link ?? '-' }} <br> 
                                                    {{ $user->linkedin_link ?? '-' }} <br>
                                                    {{ $user->insta_link ?? '-' }} <br>
                                                    {{ $user->google_review_link ?? '-' }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            @endif
                        </div>
                        </div>
                        <!-- /.card -->

                    </div>
                    <!--/.col (right) -->
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
@endsection
