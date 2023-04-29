@extends('layouts.master')

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Basic Info List</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/home">Home</a></li>
              <li class="breadcrumb-item active">Basic Info List</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>


    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Basic Info List</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th style="width: 10px">#</th>
                      <th>Unique ID</th>
                      <th>Name</th>
                      <th>Phone</th>
                      <th>Created Dt</th>
                      <th>Action</th> 
                    </tr>
                  </thead>
                  @if (count($basic_info) > 0)
                  <tbody>
                  <?php foreach($basic_info as $val){ //echo"<pre>"; print_r($val); die; ?>
                    <tr>
                      <td><?php echo $val->id ?></td>
                      <td><?php echo $val->unique_id ?></td>
                      <td><?php echo $val->first_name.' '.$val->last_name ?></td>
                      <td><?php echo $val->phone_no ?></td>
                      <td><?php echo $val->insert ?></td>
                      <td>
                          <a href="{{ URL::to('admin/basic_info/' . $val->id . '/edit') }}" class="btn btn__primary edit"><span class="badge bg-success"></span>&nbsp;Edit</a>
                          <a href="{{ URL::to('admin/basic_info/' . $val->id . '/destroy') }}" class="btn btn__primary edit"><span class="badge bg-danger"></span>&nbsp;Delete</a>
                        
                      </td>
                    </tr>
                  <?php } ?>

                  </tbody>
                  
                  @else

                  <tr>
                    <td colspan="7" align="center">No Records Found</td>
                  </tr>

                  @endif
                </table>
              </div>
              {{$basic_info->links('pagination::bootstrap-4')}}
            </div>
            <!-- /.card -->
          </div></div></div></section>


  </div>
@endsection
