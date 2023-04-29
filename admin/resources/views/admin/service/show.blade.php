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
                            <h3 class="card-title mt-2">Show Service</h3>
                            <div class="text-right">
                                <a class="btn btn-success" href="{{ route('admin.service.index') }}"> Back</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="table-responsive">
                                    <table class="table table-bordered ">
                                        <tbody>
                                            <tr>
                                                <th>Name</th>
                                                <td>{{ $service->name }}</td>
                                            </tr>
                                            <tr>
                                                <th>Description</th>
                                                <td>{{ $service->description }}</td>
                                            </tr>
                                            
                                            <tr>
                                                <th>Speciality</th>
                                                <td>{{ $service->specname }}</td>
                                            </tr>
                                            <tr>
                                                <th>Benefits</th>
                                                <td>{{ $service->benefits }}</td>
                                            </tr>
                                            <tr>
                                                <th>Cover Image</th>
                                                <td><?php if($service->coverpic !=""){
                                       $protocol = stripos($_SERVER['SERVER_PROTOCOL'],'https') === 0 ? 'https://' : 'http://';
                                       $path = explode('admin', $_SERVER['REQUEST_URI']); 
                                       $host = $_SERVER['HTTP_HOST'];
                                       $fpath = $protocol.$host.$path[0]."datafiles/uploads/services/".$service->coverpic;
                                            ?>
                                        <img height="200px" src="{{$fpath}}" />
                                        <?php } ?> 
                                        </td>
                                            </tr>
                                           
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection