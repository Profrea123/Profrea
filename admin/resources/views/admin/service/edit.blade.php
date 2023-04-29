@extends('layouts.master')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Service</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Service</li>
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
                            <h3 class="card-title mt-2">Edit Service</h3>
                            <div class="text-right">
                                <a class="btn btn-success" href="{{ route('admin.service.index') }}"> Back</a>
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
                            <form action="{{ route('admin.service.update',$service->id) }}" method="POST"  enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-6">
                                        <div class="form-group">
                                            <strong>Name</strong>
                                            <input type="text" name="name" class="form-control" placeholder="Name" value="{{ $service->name }}">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-6">
                                        <div class="form-group">
                                            <strong>Speciality</strong>
                                            <select name="speciality" class="form-control">
                                                <option value="">--Select Speciality--</option>
                                                <?php
                                                foreach ($ops as $key => $space) 
                                                {
                                                    $space_id = $space->id;
                                                    $space_name = $space->name;
                                                    ?>
                                                    <option value="<?php echo $space_id; ?>"  <?php echo ($space_id==$service->speciality)?'selected':''; ?>  ><?php echo $space_name; ?></option>;
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-6">
                                        <div class="form-group">
                                            <strong>Description</strong>
                                            <input type="text" name="description" class="form-control" placeholder="Description" value="{{ $service->description }}">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-6">
                                        <div class="form-group">
                                            <strong>Benefits</strong>
                                            <textarea name="benefits" class="form-control" placeholder="Benefits" >{{ $service->benefits }}</textarea>
                                           
                                        </div>
                                    </div>
                                    <?php if($service->coverpic !=""){ ?>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                       <?php
                                       $protocol = stripos($_SERVER['SERVER_PROTOCOL'],'https') === 0 ? 'https://' : 'http://';
                                       $path = explode('admin', $_SERVER['REQUEST_URI']); 
                                       $host = $_SERVER['HTTP_HOST'];
                                       $fpath = $protocol.$host.$path[0]."datafiles/uploads/services/".$service->coverpic;
                                            ?>
                                        <img height="200px" src="{{$fpath}}" />
                                    </div>
                                    <?php } ?>
                                    <div class="col-xs-12 col-sm-12 col-md-4">
                                        <div class="form-group">
                                            <label for="space_profile_image">Service Cover Image</label>
                                            <input type="file" name="coverpic" class="form-control">
                                            <input type="hidden" name="coverpicold" value="{{$service->coverpic}}">
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