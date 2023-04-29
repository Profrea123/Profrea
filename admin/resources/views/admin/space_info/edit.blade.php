@extends('layouts.master')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Space Info Form</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('admin/home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Space Info Form</li>
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
                                <h3 class="card-title">Space Info Edit</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form action="{{ url('admin/space_info/update/'.$space_info->id) }}" method="post">
                            @csrf
                            <div class="card-body">
                                    <div class="form-group">
                                        <label for="name">Space Type</label>
                                        <input type="space_type" name="space_type" class="form-control" value="{{ count(old())==0 ? $space_info->space_type : old('space_type') }}" required autocomplete="off" id="space_type" placeholder="Enter Unique ID">

                                        <input type="hidden" name="basic_info_id" value="{{ count(old())==0 ? $space_info->basic_info_id : old('basic_info_id') }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="name">City</label>
                                        <input type="city" name="city" class="form-control" value="{{ count(old())==0 ? $space_info->city : old('city') }}" required autocomplete="off" id="city" placeholder="Enter Unique ID">
                                    </div>
                                    <div class="form-group">
                                        <label for="locality">Locality</label>
                                        <input type="locality" name="locality" class="form-control" value="{{ count(old())==0 ? $space_info->locality : old('locality') }}" required autocomplete="off" id="locality" placeholder="Enter Last Name">
                                    </div>
                                    <div class="form-group">
                                        <label for="landmark">Landmark</label>
                                        <input type="landmark" name="landmark" class="form-control" value="{{ count(old())==0 ? $space_info->landmark : old('landmark') }}" required autocomplete="off" id="landmark" placeholder="Enter Landmark">
                                    </div>
                                    <div class="form-group">
                                        <label for="addresss">Addresss</label>
                                        <input type="addresss" name="addresss" class="form-control" value="{{ count(old())==0 ? $space_info->addresss : old('addresss') }}" required autocomplete="off" id="addresss" placeholder="Enter Addresss">
                                    </div>
                                    <div class="form-group">
                                        <label for="security_deposit">Security Deposit</label>
                                        <input type="security_deposit" name="security_deposit" class="form-control" value="{{ count(old())==0 ? $space_info->security_deposit : old('security_deposit') }}" autocomplete="off" id="security_deposit" placeholder="Enter Security Deposit">
                                    </div>
                                    <div class="form-group">
                                        <label for="setup_rules">Setup Rules</label>
                                        <input type="setup_rules" name="setup_rules" class="form-control" value="{{ count(old())==0 ? $space_info->setup_rules : old('setup_rules') }}" autocomplete="off" id="setup_rules" placeholder="Enter Setup Rules">
                                    </div>
                                    <div class="form-group">
                                        <label for="setup_desc">Setup Desc</label>
                                        <input type="setup_desc" name="setup_desc" class="form-control" value="{{ count(old())==0 ? $space_info->setup_desc : old('setup_desc') }}" required autocomplete="off" id="setup_desc" placeholder="Enter Setup Desc">
                                    </div>
                                    <div class="form-group">
                                        <label for="operating_specialty">Operating Specialty</label>
                                        <input type="operating_specialty" name="operating_specialty" class="form-control" value="{{ count(old())==0 ? $space_info->operating_specialty : old('operating_specialty') }}" autocomplete="off" id="operating_specialty" placeholder="Enter Operating Specialty">
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="utility">Utility</label>
                                        <input type="utility" name="utility" class="form-control" value="{{ count(old())==0 ? $space_info->utility : old('utility') }}" autocomplete="off" id="city" placeholder="Enter Utility">
                                    </div>
                                    <div class="form-group">
                                        <label for="paid_utilities">Paid Utilities</label>
                                        <input type="paid_utilities" name="paid_utilities" class="form-control" value="{{ count(old())==0 ? $space_info->paid_utilities : old('paid_utilities') }}" autocomplete="off" id="paid_utilities" placeholder="Enter Paid Utilities">
                                    </div>
                                    <div class="form-group">
                                        <label for="amenities">Amenities</label>
                                        <input type="amenities" name="amenities" class="form-control" value="{{ count(old())==0 ? $space_info->amenities : old('amenities') }}" autocomplete="off" id="amenities" placeholder="Enter Amenities">
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="map_location">Map Location</label>
                                        <input type="map_location" name="map_location" class="form-control" value="{{ count(old())==0 ? $space_info->map_location : old('map_location') }}" autocomplete="off" id="city" placeholder="Enter Map Location">
                                    </div>
                                    <div class="form-group">
                                        <label for="map_cordinates">Map Cordinates</label>
                                        <input type="map_cordinates" name="map_cordinates" class="form-control" value="{{ count(old())==0 ? $space_info->map_cordinates : old('map_cordinates') }}" autocomplete="off" id="map_cordinates" placeholder="Enter Paid Utilities">
                                    </div>
                                    <div class="form-group">
                                        <label for="ws_name">Work Space Name</label>
                                        <input type="ws_name" name="ws_name" class="form-control" value="{{ count(old())==0 ? $space_info->ws_name : old('ws_name') }}" required autocomplete="off" id="ws_name" placeholder="Enter ws_name">
                                    </div>

                                    <div class="form-group">
                                        <label for="ws_available_from">Work Available From</label>
                                        <input type="ws_available_from" name="ws_available_from" class="form-control" value="{{ count(old())==0 ? $space_info->ws_available_from : old('ws_available_from') }}" required autocomplete="off" id="ws_available_from" placeholder="Enter Work Available From">
                                    </div>
                                    
                                    <div class="row">
                                        <div class="form-group col-sm-4">
                                            <label for="ws_offered_slots_mon">Monday</label>
                                            <input type="ws_offered_slots_mon" name="ws_offered_slots_mon" class="form-control" value="{{ count(old())==0 ? $space_info->ws_offered_slots_mon : old('ws_offered_slots_mon') }}" autocomplete="off" id="ws_offered_slots_mon" placeholder="Enter Monday">
                                        </div>
                                        <div class="form-group col-sm-4">
                                            <label for="ws_offered_slots_tue">Tuesday</label>
                                            <input type="ws_offered_slots_tue" name="ws_offered_slots_tue" class="form-control" value="{{ count(old())==0 ? $space_info->ws_offered_slots_tue : old('ws_offered_slots_tue') }}" autocomplete="off" id="ws_offered_slots_tue" placeholder="Enter Tuesday">
                                        </div>
                                        <div class="form-group col-sm-4">
                                            <label for="ws_offered_slots_wed">Wednesday</label>
                                            <input type="ws_offered_slots_wed" name="ws_offered_slots_wed" class="form-control" value="{{ count(old())==0 ? $space_info->ws_offered_slots_wed : old('ws_offered_slots_wed') }}" autocomplete="off" id="ws_offered_slots_wed" placeholder="Enter Wednesday">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-sm-4">
                                            <label for="ws_offered_slots_thu">Thursday</label>
                                            <input type="ws_offered_slots_thu" name="ws_offered_slots_thu" class="form-control" value="{{ count(old())==0 ? $space_info->ws_offered_slots_thu : old('ws_offered_slots_thu') }}" autocomplete="off" id="ws_offered_slots_thu" placeholder="Enter Thursday">
                                        </div>
                                        <div class="form-group col-sm-4">
                                            <label for="ws_offered_slots_fri">Friday</label>
                                            <input type="ws_offered_slots_fri" name="ws_offered_slots_fri" class="form-control" value="{{ count(old())==0 ? $space_info->ws_offered_slots_fri : old('ws_offered_slots_fri') }}" autocomplete="off" id="ws_offered_slots_fri" placeholder="Enter Friday">
                                        </div>
                                        <div class="form-group col-sm-4">
                                            <label for="ws_offered_slots_sat">Saturday</label>
                                            <input type="ws_offered_slots_sat" name="ws_offered_slots_sat" class="form-control" value="{{ count(old())==0 ? $space_info->ws_offered_slots_sat : old('ws_offered_slots_sat') }}" autocomplete="off" id="ws_offered_slots_sat" placeholder="Enter Saturday">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-sm-4">
                                            <label for="ws_offered_slots_sun">Sunday</label>
                                            <input type="ws_offered_slots_sun" name="ws_offered_slots_sun" class="form-control" value="{{ count(old())==0 ? $space_info->ws_offered_slots_sun : old('ws_offered_slots_sun') }}" autocomplete="off" id="ws_offered_slots_sun" placeholder="Enter Sunday">
                                        </div>
                                        <div class="form-group col-sm-4">
                                            
                                        </div>
                                        <div class="form-group col-sm-4">
                                            
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-sm-4">
                                            <label for="ws_hourly_charges">WS Hourly Charges</label>
                                            <input type="ws_hourly_charges" name="ws_hourly_charges" class="form-control" value="{{ count(old())==0 ? $space_info->ws_hourly_charges : old('ws_hourly_charges') }}" autocomplete="off" id="ws_hourly_charges" placeholder="Enter WS Hourly Charges">
                                        </div>
                                        <div class="form-group col-sm-4">
                                            <label for="ws_capacity">WS Capacity</label>
                                            <input type="ws_capacity" name="ws_capacity" class="form-control" value="{{ count(old())==0 ? $space_info->ws_capacity : old('ws_capacity') }}" autocomplete="off" id="ws_capacity" placeholder="Enter WS Desc">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="ws_desc">WS Desc</label>
                                        <input type="ws_desc" name="ws_desc" class="form-control" value="{{ count(old())==0 ? $space_info->ws_desc : old('ws_desc') }}" autocomplete="off" id="ws_desc" placeholder="Enter WS Desc">
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-sm-4">
                                            <label for="space_image_name">Space Image Name</label>
                                            <?php 
                                            $path = explode('admin', $_SERVER['HTTP_HOST']);
                                            $name = explode(",", $space_info->space_image_name);
                                            foreach($name as $space_image){
                                                $space_images= $path[0].'datafiles/spaces/'.$space_info->id.'/space_images'.'/'.$space_image; ?>
                                                <a href="<?php echo $space_images; ?>" target="_blank"><img src="<?php echo $space_images; ?>" width="200px" /></a>
                                            <?php } ?>
                                        </div>
                                        <div class="form-group col-sm-4">
                                            <label for="identity_proof_name">Identity Proof Name</label>
                                            <?php 
                                            $identity_proof= $path[0].'datafiles/spaces/'.$space_info->id.'/space_docs/identity_proof'.'/'.$space_info->identity_proof_name; ?>
                                            <a href="<?php echo $identity_proof; ?>" target="_blank"><img src="<?php echo $identity_proof; ?>" width="200px" /><a>
                                        </div>
                                        <div class="form-group col-sm-4">
                                            <label for="space_ownership_docs_name">Space Ownership Docs Name</label>
                                            <?php 
                                            $space_ownership_docs= $path[0].'datafiles/spaces/'.$space_info->id.'/space_docs/space_ownership_docs'.'/'.$space_info->space_ownership_docs_name; ?>
                                            <a href="<?php echo $space_ownership_docs; ?>" target="_blank"><img src="<?php echo $space_ownership_docs; ?>" width="200px" /></a>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-sm-4">
                                            <label for="noc_name">Noc Name</label>
                                            <?php 
                                            $noc_name= $path[0].'datafiles/spaces/'.$space_info->id.'/space_docs/noc_name'.'/'.$space_info->noc_name; ?>
                                            <a href="<?php echo $noc_name; ?>" target="_blank"><img src="<?php echo $noc_name; ?>" width="200px" /></a>
                                        </div>
                                        <div class="form-group col-sm-4">
                                            <label for="other_docs">Other Docs</label>
                                            <?php 
                                            $other_docs= $path[0].'datafiles/spaces/'.$space_info->id.'/space_docs/other_docs_name'.'/'.$space_info->other_docs; ?>
                                            <a href="<?php echo $other_docs; ?>" target="_blank"><img src="<?php echo $other_docs; ?>" width="200px" /></a>
                                        </div>
                                        <div class="form-group col-sm-4">
                                            <label for="space_profile_image">Space Profile Image</label>
                                            <?php 
                                            $space_profile_image= $path[0].'datafiles/spaces/'.$space_info->id.'/space_image_profile'.'/'.$space_info->space_profile_image; ?>
                                            <a href="<?php echo $space_profile_image; ?>" target="_blank"><img src="<?php echo $space_profile_image; ?>" width="200px" /></a>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="space_image_name">Space Image Name</label>
                                        <input type="space_image_name" name="space_image_name" class="form-control" value="{{ count(old())==0 ? $space_info->space_image_name : old('space_image_name') }}" autocomplete="off" id="space_image_name" placeholder="Space Image Name"  readOnly="true">
                                    </div>

                                    <div class="form-group">
                                        <label for="identity_proof_name">Identity Proof Name</label>
                                        <input type="identity_proof_name" name="identity_proof_name" class="form-control" value="{{ count(old())==0 ? $space_info->identity_proof_name : old('identity_proof_name') }}" autocomplete="off" id="identity_proof_name" placeholder="Identity Proof Name"  readOnly="true">
                                    </div>
                                    <div class="form-group">
                                        <label for="space_ownership_docs_name">Space Ownership Docs Name</label>
                                        <input type="space_ownership_docs_name" name="space_ownership_docs_name" class="form-control" value="{{ count(old())==0 ? $space_info->space_ownership_docs_name : old('space_ownership_docs_name') }}"  autocomplete="off" id="space_ownership_docs_name" placeholder="Enter WS Desc"  readOnly="true">
                                    </div>
                                    <div class="form-group">
                                        <label for="noc_name">Noc Name</label>
                                        <input type="noc_name" name="noc_name" class="form-control" value="{{ count(old())==0 ? $space_info->noc_name : old('noc_name') }}" autocomplete="off" id="noc_name" placeholder="Enter WS Desc"  readOnly="true">
                                    </div>
                                    <div class="form-group">
                                        <label for="space_profile_image">Space Profile Image</label>
                                        <input type="space_profile_image" name="space_profile_image" class="form-control" value="{{ count(old())==0 ? $space_info->space_profile_image : old('space_profile_image') }}" autocomplete="off" id="space_profile_image" placeholder="Enter Space Profile Image" readOnly="true">
                                    </div>
                                    <div class="form-group">
                                        <label for="other_docs">Other Docs</label>
                                        <input type="other_docs" name="other_docs" class="form-control" value="{{ count(old())==0 ? $space_info->other_docs : old('other_docs') }}" autocomplete="off" id="other_docs" placeholder="Enter WS Desc"  readOnly="true">
                                    </div>
                                    
                                    
                                    <!--<div class="form-group">
                                        <label for="exampleInputFile">File input</label>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="exampleInputFile">
                                                <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                            </div>
                                            <div class="input-group-append">
                                                <span class="input-group-text" id="">Upload</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                        <label class="form-check-label" for="exampleCheck1">Check me out</label>
                                    </div>-->
                                </div>
                                <!-- /.card-body -->

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Approve Space Table For This Spce Info</button>
                                </div>
                            </form>
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
