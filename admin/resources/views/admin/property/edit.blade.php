@extends('layouts.master')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Property Form</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('admin/home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Property Form</li>
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
                                <h3 class="card-title">Property Edit</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form action="{{ url('admin/property/update/'.$property->id) }}" method="post">
                            @csrf
                            <div class="card-body">
                                    <div class="form-group">
                                        <label for="space_id">Space Id</label>
                                        <input type="space_id" name="space_id" class="form-control" value="{{ count(old())==0 ? $property->space_id : old('space_id') }}" required autocomplete="off" readOnly="true" id="space_id" placeholder="Enter Space Id">
                                    </div>
                                    <div class="form-group">
                                        <label for="first_name">First Name</label>
                                        <input type="first_name" name="first_name" class="form-control" value="{{ count(old())==0 ? $property->first_name : old('first_name') }}" autocomplete="off" id="first_name" placeholder="Enter First Name">
                                    </div>
                                    <div class="form-group">
                                        <label for="last_name">Last Name</label>
                                        <input type="last_name" name="last_name" class="form-control" value="{{ count(old())==0 ? $property->last_name : old('last_name') }}" autocomplete="off" id="last_name" placeholder="Enter Last Name">
                                    </div>
                                    <div class="form-group">
                                        <label for="mobile">Mobile</label>
                                        <input type="mobile" name="mobile" class="form-control" value="{{ count(old())==0 ? $property->mobile : old('mobile') }}" autocomplete="off" id="mobile" placeholder="Enter Mobile">
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="email" name="email" class="form-control" value="{{ count(old())==0 ? $property->email : old('email') }}" autocomplete="off" id="email" placeholder="Enter Email">
                                    </div>
                                    <div class="form-group">
                                        <label for="brief_profile1">Brief Profile</label>
                                        <input type="brief_profile1" name="brief_profile1" class="form-control" value="{{ count(old())==0 ? $property->brief_profile1 : old('brief_profile1') }}" autocomplete="off" id="brief_profile1" placeholder="Enter Brief Profile">
                                    </div>
                                    <div class="form-group">
                                        <label for="start_date">When He want to start</label>
                                        <input type="start_date" name="start_date" class="form-control" value="{{ count(old())==0 ? $property->start_date : old('start_date') }}" autocomplete="off" id="start_date" placeholder="Enter Unique ID">
                                    </div>
                                    <div class="form-group">
                                        <label for="p_amount">P Amount</label>
                                        <input type="p_amount" name="p_amount" class="form-control" value="{{ count(old())==0 ? $property->p_amount : old('p_amount') }}" autocomplete="off" id="p_amount" placeholder="Enter P Amount">
                                    </div>
                                    
                                    <div class="row">
                                        <div class="form-group col-sm-4">
                                            <label for="work_mon">Work MON</label>
                                            <input type="work_mon" name="work_mon" class="form-control" value="{{ count(old())==0 ? $property->work_mon : old('work_mon') }}" autocomplete="off" id="work_mon" placeholder="Enter Work MON">
                                        </div>
                                        <div class="form-group col-sm-4">
                                            <label for="work_tue">Work TUE</label>
                                            <input type="work_tue" name="work_tue" class="form-control" value="{{ count(old())==0 ? $property->work_tue : old('work_tue') }}" autocomplete="off" id="work_tue" placeholder="Enter Work TUE">
                                        </div>
                                        <div class="form-group col-sm-4">
                                            <label for="work_wed">Work WED</label>
                                            <input type="work_wed" name="work_wed" class="form-control" value="{{ count(old())==0 ? $property->work_wed : old('work_wed') }}" autocomplete="off" id="work_wed" placeholder="Enter Work WED">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-sm-4">
                                            <label for="work_thu">Work THU</label>
                                            <input type="work_thu" name="work_thu" class="form-control" value="{{ count(old())==0 ? $property->work_thu : old('work_thu') }}" autocomplete="off" id="work_thu" placeholder="Enter Work THU">
                                        </div>
                                        <div class="form-group col-sm-4">
                                            <label for="work_fri">Work FRI</label>
                                            <input type="work_fri" name="work_fri" class="form-control" value="{{ count(old())==0 ? $property->work_fri : old('work_fri') }}" autocomplete="off" id="work_fri" placeholder="Enter Work WED">
                                        </div>
                                        <div class="form-group col-sm-4">
                                            <label for="work_sat">Work SAT</label>
                                            <input type="work_sat" name="work_sat" class="form-control" value="{{ count(old())==0 ? $property->work_sat : old('work_sat') }}" autocomplete="off" id="work_sat" placeholder="Enter Work WED">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-sm-4">
                                            <label for="work_sun">Work SUN</label>
                                            <input type="work_sun" name="work_sun" class="form-control" value="{{ count(old())==0 ? $property->work_sun : old('work_sun') }}" autocomplete="off" id="work_sun" placeholder="Enter Work SUN">
                                        </div>
                                        <div class="form-group col-sm-4">
                                            
                                        </div>
                                        <div class="form-group col-sm-4">
                                            
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="select_date">Site Visit Date</label>
                                        <input type="select_date" name="select_date" class="form-control" value="{{ count(old())==0 ? $property->select_date : old('select_date') }}" autocomplete="off" id="select_date" placeholder="Enter Select Date">
                                    </div>
                                    <div class="form-group">
                                        <label for="select_time">Site Visit Time</label>
                                        <input type="select_time" name="select_time" class="form-control" value="{{ count(old())==0 ? $property->select_time : old('select_time') }}" autocomplete="off" id="select_time" placeholder="Enter Select Time">
                                    </div>
                                    <div class="form-group col-sm-4">
                                        <label for="noc_name">Property Documents</label>
                                        <?php 
                                        $path = explode('admin', $_SERVER['SCRIPT_URI']);
                                        $property_documents= $path[0].'datafiles/uploads/property_documents'.'/'.$property->property_documents; ?>
                                        <a href="<?php echo $property_documents; ?>" target="_blank"><img src="<?php echo $property_documents; ?>" width="200px" /></a>
                                    </div>
                                    <div class="form-group">
                                        <label for="property_documents">Property Documents</label>
                                        <input type="property_documents" name="property_documents" class="form-control" value="{{ count(old())==0 ? $property->property_documents : old('property_documents') }}" autocomplete="off" id="property_documents" placeholder="Enter Property Documents" readOnly="true">
                                    </div>
                                    
                                </div>
                                <!-- /.card-body -->

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Update Property</button>
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
