@extends('layouts.master')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Space Enquiry Details</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Space Enquiry</li>
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
                            <h3 class="card-title mt-2">Show Enquiry List</h3>
                            <div class="text-right">
                                <a class="btn btn-success" href="{{ route('admin.spacenq.index') }}"> Back</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="table-responsive">
                                    <table class="table table-bordered ">
                                        <tbody>
                                            <tr>
                                                <th>Name</th>
                                                <td>{{ $spacenq->first_name }}</td>
                                            </tr>
                                            <tr>
                                                <th>E-Mail</th>
                                                <td>{{ $spacenq->email }}</td>
                                            </tr>
                                            <tr>
                                                <th>Phone</th>
                                                <td>{{ $spacenq->mobile }}</td>
                                            </tr>
                                            <tr>
                                                <th>Visit Schedule</th>
                                                <td>{{ $spacenq->select_date }}</td>
                                            </tr>
                                            <tr>
                                                <th>Enquiry for space</th>
                                                <td><a href="{{ URL::to('admin/space/' .  $spacenq->space_id . '/edit') }}">{{ $spacenq->space_id }}</a></td>
                                            </tr>
                                            
                                            <tr>
                                                <th>Status</th>
                                                <td>@if($spacenq->status =='0')         
                                               New             
                                        @elseif($spacenq->status =='1')
                                        In Progress
                                        @elseif($spacenq->status =='2')
                                        Won
                                        @elseif($spacenq->status =='3')
                                        Lost
       
@endif</td>
                                            </tr>
                                            <tr>
                                                <th>Comment</th>
                                                <td>{{ $spacenq->comment }}</td>
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