@extends('layouts.master')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Live Space Form</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('admin/home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Live Space Form</li>
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
                                <h3 class="card-title">Live Space Edit</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form action="{{ url('admin/space/update/'.$space->id) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                    <div class="form-group">
                                        <label for="name">Phone</label>
                                        <input type="phone" name="phone" class="form-control" value="{{ count(old())==0 ? $space->phone : old('phone') }}" required autocomplete="off" id="phone" placeholder="Enter Phone">

                                        <input type="hidden" name="owner_id" value="{{ count(old())==0 ? $space->owner_id : old('owner_id') }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Hourly Charges</label>
                                        <input type="hourly_charges" name="hourly_charges" class="form-control" value="{{ count(old())==0 ? $space->hourly_charges : old('hourly_charges') }}" autocomplete="off" id="hourly_charges" placeholder="Enter Unique ID">
                                    </div>
                                    <div class="form-group">
                                        <label for="space_type">Space Type</label>
                                        <input type="space_type" name="space_type" class="form-control" value="{{ count(old())==0 ? $space->space_type : old('space_type') }}" autocomplete="off" id="space_type" placeholder="Enter Space Type">
                                    </div>
                                    <div class="form-group">
                                        <label for="capacity">Capacity</label>
                                        <input type="capacity" name="capacity" class="form-control" value="{{ count(old())==0 ? $space->capacity : old('capacity') }}" autocomplete="off" id="capacity" placeholder="Enter capacity">
                                    </div>
                                    <div class="form-group">
                                        <label for="speciality_operating">Operating Specialty</label>
                                        <input type="speciality_operating" name="speciality_operating" class="form-control" value="{{ count(old())==0 ? $space->speciality_operating : old('operating_specialty') }}" autocomplete="off" id="speciality_operating" placeholder="Enter Operating Specialty">
                                    </div>
                                    <div class="form-group">
                                        <label for="amenities">Amenities</label>
                                        <input type="amenities" name="amenities" class="form-control" value="{{ count(old())==0 ? $space->amenities : old('amenities') }}" autocomplete="off" id="amenities" placeholder="Enter Amenities">
                                    </div>
                                    <div class="form-group">
                                        <label for="utility">Utility</label>
                                        <input type="utility" name="utility" class="form-control" value="{{ count(old())==0 ? $space->utility : old('utility') }}" autocomplete="off" id="utility" placeholder="Enter Utility">
                                    </div>
                                    <div class="form-group">
                                        <label for="paid_utilities">Paid Utilities</label>
                                        <input type="paid_utilities" name="paid_utilities" class="form-control" value="{{ count(old())==0 ? $space->paid_utilities : old('paid_utilities') }}" autocomplete="off" id="paid_utilities" placeholder="Enter Paid Utilities">
                                    </div>
                                  
                                    <div class="form-group">
                                        <label for="available_day_slots">Available Day Slots</label>
                                        <input type="available_day_slots" name="available_day_slots" class="form-control" value="{{ count(old())==0 ? $space->available_day_slots : old('available_day_slots') }}" autocomplete="off" id="Available Day Slots" placeholder="Enter available_day_slots">
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="available_time_slots">Available Time Slots</label>
                                        <input type="available_time_slots" name="available_time_slots" class="form-control" value="{{ count(old())==0 ? $space->available_time_slots : old('available_time_slots') }}" autocomplete="off" id="city" placeholder="Enter Available Time Slots">
                                    </div>
                                    <div class="form-group">
                                        <label for="address">Address</label>
                                        <input type="address" name="address" class="form-control" value="{{ count(old())==0 ? $space->address : old('address') }}" autocomplete="off" id="address" placeholder="Enter Address">
                                    </div>
                                    <div class="form-group">
                                        <label for="locality">Locality</label>
                                        <input type="locality" name="locality" class="form-control" value="{{ count(old())==0 ? $space->locality : old('locality') }}" autocomplete="off" id="locality" placeholder="Enter locality">
                                    </div>

                                    <div class="form-group">
                                        <label for="landmark">Landmark</label>
                                        <input type="landmark" name="landmark" class="form-control" value="{{ count(old())==0 ? $space->landmark : old('landmark') }}" autocomplete="off" id="landmark" placeholder="Enter Landmark">
                                    </div>
                                    
                                    <div class="row">
                                        <div class="form-group col-sm-4">
                                            <label for="city">City</label>
                                            <input type="city" name="city" class="form-control" value="{{ count(old())==0 ? $space->city : old('city') }}" autocomplete="off" id="city" placeholder="Enter city">
                                        </div>
                                        <div class="form-group col-sm-4">
                                            <label for="state">State</label>
                                            <input type="state" name="state" class="form-control" value="{{ count(old())==0 ? $space->state : old('state') }}" autocomplete="off" id="state" placeholder="Enter state">
                                        </div>
                                        <div class="form-group col-sm-4">
                                            <label for="pin_code">Pin Code</label>
                                            <input type="pin_code" name="pin_code" class="form-control" value="{{ count(old())==0 ? $space->pin_code : old('pin_code') }}" autocomplete="off" id="pin_code" placeholder="Enter pin code">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-sm-4">
                                            <label for="gmap_location">Gmap Location</label>
                                            <input type="gmap_location" name="gmap_location" class="form-control" value="{{ count(old())==0 ? $space->gmap_location : old('gmap_location') }}" autocomplete="off" id="gmap_location" placeholder="Enter gmap location">
                                        </div>
                                        <div class="form-group col-sm-4">
                                            <label for="setup_desc">Setup Desc</label>
                                            <input type="setup_desc" name="setup_desc" class="form-control" value="{{ count(old())==0 ? $space->setup_desc : old('setup_desc') }}" autocomplete="off" id="setup_desc" placeholder="Enter Security Deposit">
                                        </div>
                                        <div class="form-group col-sm-4">
                                            <label for="ws_name">WS Name</label>
                                            <input type="ws_name" name="ws_name" class="form-control" value="{{ count(old())==0 ? $space->ws_name : old('ws_name') }}" autocomplete="off" id="ws_name" placeholder="Enter Saturday">
                                        </div>
                                    </div>
                                     <div class="form-group">
                                            <label for="security_deposit">Security Deposit</label>
                                            <input type="security_deposit" name="security_deposit" class="form-control" value="{{ count(old())==0 ? $space->security_deposit : old('security_deposit') }}" autocomplete="off" id="security_deposit" placeholder="Enter Security Deposit">
                                        </div>
                                        <div class="form-group">
                                            <label for="setup_rules">Setup Rule</label>
                                            <input type="setup_rules" name="setup_rules" class="form-control" value="{{ count(old())==0 ? $space->setup_rules : old('setup_rules') }}" autocomplete="off" id="setup_rules" placeholder="Enter Setup Rule">
                                        </div>
                                    <div class="form-group">
                                            <label for="ws_desc">WS Desc</label>
                                            <input type="ws_desc" name="ws_desc" class="form-control" value="{{ count(old())==0 ? $space->ws_desc : old('ws_desc') }}" autocomplete="off" id="ws_desc" placeholder="Enter WS Desc">
                                        </div>
                                    <div class="row">
                                        <div class="form-group col-sm-4">
                                            <label for="space_image_name">Space Image Name</label>
                                            <?php
                                            $name = explode(",", $space->space_image_name);
                                            foreach($name as $space_image){
                                                $space_images= $websiteBaseUrl.'datafiles/spaces/'.$space->id.'/space_images'.'/'.$space_image; ?>
                                                <a href="<?php echo $space_images; ?>" target="_blank">
                                                    <img src="<?php echo $space_images; ?>" width="200px" />
                                                </a>
                                            <?php } ?>
                                        </div>
                                        @if ($space->identity_proof_name)
                                        <div class="form-group col-sm-4">
                                            <label for="identity_proof_name">Identity Proof Name</label>
                                            <?php 
                                            $identity_proof= $websiteBaseUrl.'datafiles/spaces/'.$space->id.'/space_docs/identity_proof'.'/'.$space->identity_proof_name; ?>
                                            <a href="<?php echo $identity_proof; ?>" target="_blank"><img src="<?php echo $identity_proof; ?>" width="200px" /><a>
                                        </div>
                                        @endif

                                        @if ($space->space_ownership_docs_name)
                                        <div class="form-group col-sm-4">
                                            <label for="space_ownership_docs_name">Space Ownership Docs Name</label>
                                            <?php 
                                            $space_ownership_docs= $websiteBaseUrl.'datafiles/spaces/'.$space->id.'/space_docs/space_ownership_docs'.'/'.$space->space_ownership_docs_name; ?>
                                            <a href="<?php echo $space_ownership_docs; ?>" target="_blank"><img src="<?php echo $space_ownership_docs; ?>" width="200px" /></a>
                                        </div>
                                        @endif
                                    </div>
                                    <div class="row">
                                        @if ($space->noc_name)
                                        <div class="form-group col-sm-4">
                                            <label for="noc_name">Noc Name</label>
                                            <?php 
                                            $noc_name= $websiteBaseUrl.'datafiles/spaces/'.$space->id.'/space_docs/noc_name'.'/'.$space->noc_name; ?>
                                            <a href="<?php echo $noc_name; ?>" target="_blank"><img src="<?php echo $noc_name; ?>" width="200px" /></a>
                                        </div>
                                        @endif
                                        @if ($space->other_docs)
                                        <div class="form-group col-sm-4">
                                            <label for="other_docs">Other Docs</label>
                                            <?php 
                                            $other_docs= $websiteBaseUrl.'datafiles/spaces/'.$space->id.'/space_docs/other_docs_name'.'/'.$space->other_docs; ?>
                                            
                                            <a href="<?php echo $other_docs; ?>" target="_blank"><img src="<?php echo $other_docs; ?>" width="200px" /></a>
                                        </div>
                                        @endif
                                        @if ($space->space_profile_image)
                                        <div class="form-group col-sm-4">
                                            <label for="space_profile_image">Space Profile Image</label>
                                            <?php 
                                            $space_profile_image= $websiteBaseUrl.'datafiles/spaces/'.$space->id.'/space_image_profile'.'/'.$space->space_profile_image; ?>
                                            <a href="<?php echo $space_profile_image; ?>" target="_blank"><img src="<?php echo $space_profile_image; ?>" width="200px" /></a>
                                        </div>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="space_image_name">Space Image Name(You have to upload multiple images at a time)</label>
                                        <input type="file" name="space_image[]" class="form-control" multiple>
                                    </div>
                                    <div class="form-group">
                                        <label for="identity_proof_name">Identity Proof Name</label>
                                        <input type="identity_proof_name" name="identity_proof_name" class="form-control" value="{{ count(old())==0 ? $space->identity_proof_name : old('identity_proof_name') }}" autocomplete="off" id="identity_proof_name" placeholder="Identity Proof Name"  readOnly="true">
                                    </div>
                                    <div class="form-group">
                                        <label for="space_ownership_docs_name">Space Ownership Docs Name</label>
                                        <input type="space_ownership_docs_name" name="space_ownership_docs_name" class="form-control" value="{{ count(old())==0 ? $space->space_ownership_docs_name : old('space_ownership_docs_name') }}"  autocomplete="off" id="space_ownership_docs_name" placeholder="Enter Space Ownership Docs Nam"  readOnly="true">
                                    </div>
                                    <div class="form-group">
                                        <label for="noc_name">Noc Name</label>
                                        <input type="noc_name" name="noc_name" class="form-control" value="{{ count(old())==0 ? $space->noc_name : old('noc_name') }}" autocomplete="off" id="noc_name" placeholder="Enter Noc Name"  readOnly="true">
                                    </div>
                                    <div class="form-group">
                                        <label for="space_profile_image">Space Profile Image</label>
                                        <input type="file" name="space_profile_image" class="form-control" multiple>
                                    </div>
                                    <div class="form-group">
                                        <label for="other_docs">Other Docs</label>
                                        <input type="other_docs" name="other_docs" class="form-control" value="{{ count(old())==0 ? $space->other_docs : old('other_docs') }}" autocomplete="off" id="other_docs" placeholder="Enter Other Docs"  readOnly="true">
                                    </div>

                                    
                                </div>
                                <!-- /.card-body -->

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Update Space</button>
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
