@extends('layouts.master')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Enquiry Details</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Enquiry</li>
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
                                <a class="btn btn-success" href="{{ route('admin.enquiry.index') }}"> Back</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="table-responsive">
                                    <table class="table table-bordered ">
                                        <tbody>
                                            <tr>
                                                <th>Name</th>
                                                <td>{{ $enquiry->name }}</td>
                                            </tr>
                                            <tr>
                                                <th>E-Mail</th>
                                                <td>{{ $enquiry->mail }}</td>
                                            </tr>
                                            <tr>
                                                <th>Phone</th>
                                                <td>{{ $enquiry->phone }}</td>
                                            </tr>
                                            <tr>
                                                <th>Enquiry from page</th>
                                                <td>{{ $enquiry->enquiry_from_page }}</td>
                                            </tr>
                                            <tr>
                                                <th>Description</th>
                                                <td>{{ $enquiry->enquiry_details }}</td>
                                            </tr>
                                            <tr>
                                                <th>Status</th>
                                                <td>@if($enquiry->status =='0')         
                                               New             
                                        @elseif($enquiry->status =='1')
                                        In Progress
                                        @elseif($enquiry->status =='2')
                                        Won
                                        @elseif($enquiry->status =='3')
                                        Lost
       
@endif</td>
                                            </tr>
                                            <tr>
                                                <th>Comment</th>
                                                <td>{{ $enquiry->comment }}</td>
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