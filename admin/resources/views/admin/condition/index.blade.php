@extends('layouts.master')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Health Condition</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Health Condition</li>
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
                            <h3 class="card-title mt-2">List of Health Conditions</h3>
                            <div class="text-right">
                                <a class="btn btn-success" href="{{ route('admin.condition.create') }}"> Add New</a>
                            </div>
                        </div>
                        <div class="card-body">
                            @if ($message = Session::get('message'))
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
                                            <th>Description</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    @if(count($tests) > 0)
                                    <tbody>
                                        @foreach ($tests as $key => $list)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $list->title }}</td>
                                            <td>{{ $list->desc }}</td>
                                            <td>{{ ($list->status == 1)?'Verified':'Unverified' }}</td>
                                            <td>
                                                <form action="{{ route('admin.condition.destroy',$list->hc_id) }}" method="POST">
                                                    <!-- <a class="btn btn-info" href="{{ route('admin.condition.show',$list->hc_id) }}">Show</a> -->
                                                    <a class="btn btn-primary" href="{{ route('admin.condition.edit',$list->hc_id) }}"><i class="fas fa-edit"></i></a>
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger show_confirm"><i class="fas fa-trash-alt"></i></button>
                                                </form>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    @else
                                    <tbody>
                                        <tr>
                                            <td colspan="5"><span class="text-center">No Records Found!</span></td>
                                        </tr>
                                    </tbody>
                                    @endif
                                </table>
                            </div>
                        </div>
                                              
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<script type="text/javascript">
    
    $(document).on('click','.show_confirm',function() {
        var url = $(this).attr('rel');
        if(confirm("Are you sure you want to delete this?")){
           window.location.href = url
        }
        else{
            return false;
        }
    })
</script>

@endsection