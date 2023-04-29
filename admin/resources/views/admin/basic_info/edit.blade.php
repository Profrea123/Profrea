@extends('layouts.master')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Basic Info Form</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('admin/home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Basic Info Form</li>
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
                                <h3 class="card-title">Basic Info Edit</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form action="{{ url('admin/basic_info/update/'.$basic_info->id) }}" method="post">
                            @csrf
                            <div class="card-body">
                                    <div class="form-group">
                                        <label for="name">Unique ID</label>
                                        <input type="unique_id" name="unique_id" class="form-control" value="{{ count(old())==0 ? $basic_info->unique_id : old('unique_id') }}" required autocomplete="off" id="unique_id" placeholder="Enter Unique ID">
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Space Type</label>
                                        <input type="space_type" name="space_type" class="form-control" value="{{ count(old())==0 ? $basic_info->space_type : old('space_type') }}" required autocomplete="off" id="space_type" placeholder="Enter Unique ID">
                                    </div>
                                    <div class="form-group">
                                        <label for="last_name">Last Name</label>
                                        <input type="last_name" name="last_name" class="form-control" value="{{ count(old())==0 ? $basic_info->last_name : old('last_name') }}" required autocomplete="off" id="last_name" placeholder="Enter Last Name">
                                    </div>
                                    <div class="form-group">
                                        <label for="first_name">First Name</label>
                                        <input type="first_name" name="first_name" class="form-control" value="{{ count(old())==0 ? $basic_info->first_name : old('first_name') }}" required autocomplete="off" id="first_name" placeholder="Enter First Name">
                                    </div>
                                    <div class="form-group">
                                        <label for="phone_no">Phone No</label>
                                        <input type="phone_no" name="phone_no" class="form-control" value="{{ count(old())==0 ? $basic_info->phone_no : old('phone_no') }}" required autocomplete="off" id="phone_no" placeholder="Enter Phone No">
                                    </div>
                                    <div class="form-group">
                                        <label for="phone_no2">Phone No2</label>
                                        <input type="phone_no2" name="phone_no2" class="form-control" value="{{ count(old())==0 ? $basic_info->phone_no2 : old('phone_no2') }}" autocomplete="off" id="phone_no2" placeholder="Enter Phone No2">
                                    </div>
                                    <div class="form-group">
                                        <label for="email_Id">Email</label>
                                        <input type="email_Id" name="email_Id" class="form-control" value="{{ count(old())==0 ? $basic_info->email_Id : old('email_Id') }}" required autocomplete="off" id="email_Id" placeholder="Enter Email">
                                    </div>
                                    <div class="form-group">
                                        <label for="email_Id2">Email2</label>
                                        <input type="email_Id2" name="email_Id2" class="form-control" value="{{ count(old())==0 ? $basic_info->email_Id2 : old('email_Id2') }}" autocomplete="off" id="email_Id2" placeholder="Enter Email2">
                                    </div>
                                    <div class="form-group">
                                        <label for="user_type">User Type</label>
                                        <input type="user_type" name="user_type" class="form-control" value="{{ count(old())==0 ? $basic_info->user_type : old('user_type') }}" required autocomplete="off" id="user_type" placeholder="Enter User Type">
                                    </div>
                                    
                                    <div class="row">
                                        <div class="form-group col-sm-4">
                                            <label for="city">City</label>
                                            <input type="city" name="city" class="form-control" value="{{ count(old())==0 ? $basic_info->city : old('city') }}" required autocomplete="off" id="city" placeholder="Enter City">
                                        </div>
                                        <div class="form-group col-sm-4">
                                            <label for="locality">Locality</label>
                                            <input type="locality" name="locality" class="form-control" value="{{ count(old())==0 ? $basic_info->locality : old('locality') }}" required autocomplete="off" id="locality" placeholder="Enter Locality">
                                        </div>
                                        <div class="form-group col-sm-4">
                                            <label for="landmark">Landmark</label>
                                            <input type="landmark" name="landmark" class="form-control" value="{{ count(old())==0 ? $basic_info->landmark : old('landmark') }}" required autocomplete="off" id="landmark" placeholder="Enter Landmark">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-sm-4">
                                            <label for="locality2">Alternate preference 2</label>
                                        </div>
                                        <div class="form-group col-sm-4">
                                            <label for="locality2">Locality2</label>
                                            <input type="locality2" name="locality2" class="form-control" value="{{ count(old())==0 ? $basic_info->locality2 : old('locality2') }}" autocomplete="off" id="locality2" placeholder="Enter Locality2">
                                        </div>
                                        <div class="form-group col-sm-4">
                                            <label for="landmark2">Landmark2</label>
                                            <input type="landmark2" name="landmark2" class="form-control" value="{{ count(old())==0 ? $basic_info->landmark2 : old('landmark2') }}" autocomplete="off" id="landmark2" placeholder="Enter Landmark2">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-sm-4">
                                            <label for="locality3">Alternate preference 3</label>
                                        </div>
                                        <div class="form-group col-sm-4">
                                            <label for="locality3">Locality3</label>
                                            <input type="locality3" name="locality3" class="form-control" value="{{ count(old())==0 ? $basic_info->locality3 : old('locality3') }}" autocomplete="off" id="locality3" placeholder="Enter Locality3">
                                        </div>
                                        <div class="form-group col-sm-4">
                                            <label for="landmark3">Landmark3</label>
                                            <input type="landmark3" name="landmark3" class="form-control" value="{{ count(old())==0 ? $basic_info->landmark3 : old('landmark3') }}" autocomplete="off" id="landmark3" placeholder="Enter Landmark3">
                                        </div>
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
                                    <button type="submit" class="btn btn-primary">Submit</button>
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
