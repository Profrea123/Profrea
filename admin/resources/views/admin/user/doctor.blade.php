@extends('layouts.master')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Doctors List</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="/home">Home</a></li>
            <li class="breadcrumb-item active">Doctors List</li>
          </ol>
        </div>
      </div>
    </div>
    <!-- /.container-fluid -->
  </section>
  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">User List</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <div class="row">
                <input type="text" value="{{request()->name ?? ''}}" id="name" placeholder="Name" autocomplete="off" class="form-control col-md-2 mb-2 ml-2">
                <input type="text" value="{{request()->email ?? ''}}" id="email" placeholder="Email" autocomplete="off" class="form-control col-md-2 mb-2 ml-2">
                <input type="text" value="{{request()->phone ?? ''}}" id="phone" placeholder="Phone" autocomplete="off" class="form-control col-md-2 mb-2 ml-2">
                <input type="text" value="{{request()->speciality ?? ''}}" id="speciality" placeholder="Speciality" autocomplete="off" class="form-control col-md-2 mb-2 ml-2">
                  <a href="javascript:void(0)"><button type="button" class="ml-2 btn btn-rounded btn-success filter"><i class="fa fa-filter"></i></button></a>
                @if (!empty(request()->name) || !empty(request()->email) || !empty(request()->phone) || !empty(request()->speciality))
                  <a href="{{route('admin.doctor')}}"><button type="button" class="ml-2 btn btn-rounded btn-danger filter"><i class="fa fa-redo"></i></button> </a>
                @endif
              </div>
              <div class="table-responsive">
              <table class="table table-bordered" style="width: 100%">
                <thead>
                  <tr>
                    <th>S.No</th>
                    <th>Verfied ?</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Speciality</th>
                    <th>Created On</th>
                    <th>Action</th>
                  </tr>
                </thead>
                @if (count($users) > 0)
                    
                <tbody>
                  <?php
                  $s =1;
                  foreach ($users as $key => $user) 
                  {
                    ?>
                    <tr>
                      <td><?php echo $s; ?></td>
                      <td><?php echo $user->is_verified?"Yes":"No"; ?></td>
                      <td><?php echo $user->name; ?></td>
                      <td><?php echo $user->email; ?></td>
                      <td><?php echo $user->mobileNo; ?></td>
                      <td><?php echo $user->speciality_name ?? ''; ?></td>
                      <td><?php echo date('d-M-Y h:i A', strtotime($user->insert)); ?></td>

                      <td>
                            <a href="{{ URL::to('admin/doctor/' . $user->id . '/show') }}" class="btn btn-primary">View</a>
                            <a href="{{ URL::to('admin/user/' . $user->id . '/edit') }}" class="btn btn-warning">Edit</a>
                            <a href="{{ URL::to('admin/user/' . $user->id . '/delete') }}" class="btn btn-danger">Delete</a>
                      </td>
                    </tr>
                    <?php
                  $s++;}
                  ?>
                </tbody>
                @else

                <tr>
                    <td colspan="20" align="center">No Records Found</td>
                </tr>

                @endif
              </table>
            </div>
            </div>
            <div class="card-footer">
              {{$users->links('pagination::bootstrap-4')}}
            </div>
          </div>
          <!-- /.card -->
        </div>
      </div>
    </div>
  </section>
</div>
@endsection

@section('scripts')
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script>
    $(document).ready(function(){
      $('.filter').click(function (){
        var name = $('#name').val();
        var email = $('#email').val();
        var phone = $('#phone').val();
        var speciality = $('#speciality').val();
        var url = "{{route('admin.doctor')}}"+'?name='+name+'&email='+email+'&phone='+phone+'&speciality='+speciality;
        window.location.href = url;
      });
    });
  </script>
@endsection