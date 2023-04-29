@extends('layouts.master')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Services</h1>
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
                            <h3 class="card-title mt-2">List Services</h3>
                            <div class="text-right">
                                <a class="btn btn-success" href="{{ route('admin.service.create') }}"> Add New</a>
                            </div>
                        </div>
                        <div class="card-body">
                            @if ($message = Session::get('success'))
                            <div class="alert alert-success alert-block">
                                <button type="button" class="close" data-dismiss="alert">×</button>    
                                <strong>{{ $message }}</strong>
                            </div>
                            @endif
                            <div class="table-responsive">
                                <table class="table table-bordered ">
                                    <thead>
                                        <tr>
                                            <th>S.No</th>
                                            <th>Name</th>
                                            <th>Speciality</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    @if (count($services) > 0)
                                    <tbody>
                                        @foreach ($services as $key => $service)
                                        <tr>
                                            <td>{{ $key+1 }}</td>
                                            <td>{{ $service->name }}</td>
                                            <td>{{ $service->specname }}</td>
                                            <td>
                                                <form action="{{ route('admin.service.destroy',$service->id) }}" method="POST">
                                                    <a class="btn btn-info" href="{{ route('admin.service.show',$service->id) }}">Show</a>
                                                    <a class="btn btn-primary" href="{{ route('admin.service.edit',$service->id) }}">Edit</a>
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    @else

                                    <tr>
                                        <td colspan="7" align="center">No Records Found</td>
                                    </tr>

                                    @endif
                                </table>
                            </div>
                        </div>
                        <div class="card-footer">
                            {{ $services->links('pagination::bootstrap-4') }}
                        </div>                        
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection