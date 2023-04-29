@extends('layouts.master')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Sapce Visit Edit</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Space Visit List</li>
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
                            <h3 class="card-title mt-2">Edit Entry</h3>
                            <div class="text-right">
                                <a class="btn btn-success" href="{{ route('admin.spacenq.index') }}"> Back</a>
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
                            <form action="{{ route('admin.spacenq.update',$spacenq->id) }}" method="POST">
                                @csrf
                                @method('PUT')
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
                                                <th>spacenq from page</th>
                                                <td><a href="{{ URL::to('admin/space/' .  $spacenq->space_id . '/edit') }}">{{ $spacenq->space_id }}</a></td>
                                            </tr>
                                            <tr>
                                                <th>Visit Schedule</th>
                                                <td>{{ $spacenq->select_date }}</td>
                                            </tr>
                                           
                                        </tbody>
                                    </table>
                                </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <strong>Status</strong>
                                            <select name="status" class="form-control">
                                                <option value="0"  <?php echo ($spacenq->status==0)?'selected':''; ?> >New</option>
                                                <option value="1"  <?php echo ($spacenq->status==1)?'selected':''; ?>  >In Progress</option>;
                                                <option value="2"  <?php echo ($spacenq->status==2)?'selected':''; ?>  >Won</option>;
                                                <option value="3"  <?php echo ($spacenq->status==3)?'selected':''; ?>  >Lost</option>;
                                            
                                            </select></div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <strong>Comment</strong>
                                            <textarea class="form-control" style="height:150px" name="comment" placeholder="Your Comments">{{ $spacenq->comment }}</textarea>
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