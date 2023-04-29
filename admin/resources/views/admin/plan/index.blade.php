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
                            <h3 class="card-title mt-2">List Plans</h3>
                            <div class="text-right">
                                <a class="btn btn-success" href="{{ route('admin.plan.create') }}"> Add New</a>
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
                                            <th>Title</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    @if(count($plans) > 0)
                                    <tbody>
                                        @foreach ($plans as $key => $plan)
                                        <tr>
                                            <td>{{ $plans->firstItem() + $key }}</td>
                                            <td>{{ $plan->title }}</td>
                                            <td>{{ $plan->status }}</td>
                                            <td>
                                                <form action="{{ route('admin.plan.destroy',$plan->id) }}" method="POST">
                                                    <a class="btn btn-info" href="{{ route('admin.plan.show',$plan->id) }}">Show</a>
                                                    <a class="btn btn-primary" href="{{ route('admin.plan.edit',$plan->id) }}">Edit</a>
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    @else
                                    <tbody>
                                        <tr>
                                            <td>NO Records</td>
                                           
                                        </tr>
                                    </tbody>
                                    @endif
                                </table>
                            </div>
                        </div>
                        <div class="card-footer">
                            {{ $plans->total('pagination::bootstrap-4') }}
                            {{ $plans->links('pagination::bootstrap-4') }}
                        </div>                        
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection