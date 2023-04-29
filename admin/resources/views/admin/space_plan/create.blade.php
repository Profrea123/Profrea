@extends('layouts.master')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Space Plan</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Space Plan</li>
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
                            <h3 class="card-title mt-2">Add New Space Plan</h3>
                            <div class="text-right">
                                <a class="btn btn-success" href="{{ route('admin.space_plan.index') }}"> Back</a>
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
                            <form action="{{ route('admin.space_plan.store') }}" method="POST">
                                @csrf                                
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-6">
                                        <div class="form-group">
                                            <strong>Space</strong>
                                            <select name="space_id" class="form-control">
                                                <option value="">--Select Space--</option>
                                                <?php
                                                foreach ($spaces as $key => $space) 
                                                {
                                                    $space_id = $space->id;
                                                    $space_name = $space->ws_name;
                                                    ?>
                                                    <option value="<?php echo $space_id; ?>"><?php echo $space_name; ?></option>;
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-6">
                                        <div class="form-group">
                                            <strong>Plan</strong>
                                            <select name="plan_id" class="form-control">
                                                <option value="">--Select Plan--</option>
                                                <?php
                                                foreach ($plans as $key => $plan) 
                                                {
                                                    $plan_id = $plan->id;
                                                    $plan_name = $plan->title;
                                                    ?>
                                                    <option value="<?php echo $plan_id; ?>"><?php echo $plan_name; ?></option>;
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <strong>Status</strong>
                                            <div class="radio">
                                                <label class="c-radio">
                                                    <input type="radio" name="status" id="status_y" value="1" checked>
                                                    Enabled
                                                </label>
                                                <br/>
                                                <label class="c-radio">
                                                    <input type="radio" name="status" id="status_n" value="0">
                                                    Disabled
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