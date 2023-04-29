@extends('layouts.master')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Test</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Test</li>
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
                            <h3 class="card-title mt-2">Edit Test</h3>
                            <div class="text-right">
                                <a class="btn btn-success" href="{{ route('admin.test.index') }}"> Back</a>
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
                            <form action="{{ route('admin.test.update',$test->bt_id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-6">
                                        <div class="form-group">
                                            <strong>Title</strong>
                                            <input type="text" name="title" class="form-control" placeholder="Title" value="{{ $test->title }}">
                                        </div>
                                    </div>
                                </div>
                                    
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-6">
                                        <div class="form-group">
                                            <strong>Description</strong>
                                            <textarea name="desc" cols="30" rows="10" class="form-control" placeholder="Description...">{{ $test->desc }}</textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Status</strong>
                                        <div class="radio">
                                            <label class="c-radio">
                                                <input type="radio" name="status" id="status_y" value="1" <?php echo ($test['status']==1)?"checked":"" ?>>
                                                Verified
                                            </label>
                                            <br/>
                                            <label class="c-radio">
                                                <input type="radio" name="status" id="status_n" value="0" <?php echo ($test['status']==0)?"checked":"" ?>>
                                                Unverified
                                            </label>
                                        </div>
                                    </div>
                                </div>                                    
                                <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                                    <button type="submit" class="btn btn-primary">Submit</button>
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