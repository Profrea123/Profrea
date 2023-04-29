@extends('layouts.master')

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Live Space List</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/home">Home</a></li>
              <li class="breadcrumb-item active">Live Space List</li>
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
                <h3 class="card-title">Live Space List</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th style="width: 10px">#</th>
                      <th style="width: 10px">Owner Info</th>
                      <th>Space Type</th>
                      <th>City</th>
                      <th>Locality</th>
                      <th>Created Dt</th>
                      <th>Action</th> 
                    </tr>
                  </thead>
                  @if (count($space) > 0)
                      
                  <tbody>
                  <?php foreach($space as $val){ //echo"<pre>"; print_r($val); die; ?>
                    <tr>
                      <td><?php echo $val->id ?></td>
                      <td><a href="{{ URL::to('admin/user/' . $val->owner_id . '/edit') }}"><?php echo $val->owner_id; ?></a></td>
                      <td><?php echo $val->space_type ?></td>
                      <td><?php echo $val->city ?></td>
                      <td><?php echo $val->locality ?></td>
                      <td><?php echo $val->insert ?></td>
                      <td>
                          <a href="{{ URL::to('admin/space/' . $val->id . '/edit') }}" class="btn btn__primary edit"><span class="badge bg-success"></span>&nbsp;Edit</a>
                          <a href="{{ URL::to('admin/space/' . $val->id . '/destroy') }}" class="btn btn__primary edit"><span class="badge bg-danger"></span>&nbsp;Delete</a>
                        
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
              {{$space->links('pagination::bootstrap-4')}}
            </div>
            <!-- /.card -->
          </div></div></div></section>


  </div>
@endsection
