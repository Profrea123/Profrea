@extends('layouts.master')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Space Visit</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Space Visit Enquiry</li>
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
                            <h3 class="card-title mt-2">Space Visit Lists</h3>
                           
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
                                        <th>Space Id</th>
                                        <th>Name</th>
                                        <th>E-Mail</th>
                                        <th>Phone</th>
                                        <th>Visit Date</th>                                        
                                        <th>Requested On</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                @if (count($spacenq) > 0)
                                    
                                <tbody>
                                    @foreach ($spacenq as $key => $oenq)
                                    <tr>
                                        <td>{{ $spacenq->firstItem() + $key }}</td>
                                       
                                        <td><a href="{{ URL::to('admin/space/' . $oenq->space_id . '/edit') }}"><?php echo $oenq->space_id; ?></a></td>

                                        <td>{{ $oenq->first_name }}</td>
                                        <td>{{ $oenq->email }}</td>
                                        <td>{{ $oenq->mobile }}</td>
                                        <td>{{ $oenq->select_date }}</td>
                                        <td>{{ $oenq->created_at }}</td>
                                        
                                        <td>@if($oenq->status =='0')         
                                           <div class="badge badge-primary">New</div>                 
                                        @elseif($oenq->status =='1')
                                       
                                        <div class="badge badge-warning"> In Progress</div>                 

                                        @elseif($oenq->status =='2')
                                        
                                        <div class="badge badge-success">Won</div>                 

                                        @elseif($oenq->status =='3')
                                        
                                        <div class="badge badge-danger">Lost</div>                 
       
                                    @endif</td>
                                        <td>
                                            <form action="{{ route('admin.spacenq.destroy',$oenq->id) }}" method="POST">
                                                <a class="btn btn-info" href="{{ route('admin.spacenq.show',$oenq->id) }}">Show</a>
                                                <a class="btn btn-primary" href="{{ route('admin.spacenq.edit',$oenq->id) }}">Edit</a>
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
                            {{ $spacenq->links('pagination::bootstrap-4') }}
                        </div>                        
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection