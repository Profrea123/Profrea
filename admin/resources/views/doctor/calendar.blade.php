
@include('user.userheader')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.js"></script>
  
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.7.2/css/all.min.css" integrity="sha512-3M00D/rn8n+2ZVXBO9Hib0GKNpkm8MSUU/e2VNthDyBYxKWG+BftNYYcuEjXlyrSO637tidzMBXfE7sQm0INUg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<!-- <link href="{{ asset ('css/main.css') }}" rel='stylesheet' />
<script src="{{ asset ('js/main.js') }}"></script> -->
  
    <section class="bg-space-header">
        <div class="container">         
            <?php $segment = Request::segment(0); ?>
            <?php $segment3 = Request::segment(3); ?>

            <div class="row pt-5">
                <div class="col-lg-12 mb-4 mb-sm-5">
                    <div class="card bg-gradient-success">
                        <div class="card-header border-0">
                            <div class="col-md-10 clearfix">
                                <h3 class="card-title">
                                <i class="fas fa-calendar-alt"></i>
                                    Calendar
                                </h3>
                                <a class="btn btn-success float-right" href="<?php echo $segment.'/profile-view'; ?>"> Back</a>
                            </div>

                            <!-- tools card -->
                            <!-- <div class="card-tools">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-success btn-sm dropdown-toggle" data-toggle="dropdown">
                                        <i class="fas fa-bars"></i></button>
                                    <div class="dropdown-menu float-right" role="menu">
                                        <a href="#" class="dropdown-item">Add new event</a>
                                        <a href="#" class="dropdown-item">Clear events</a>
                                        <div class="dropdown-divider"></div>
                                        <a href="#" class="dropdown-item">View calendar</a>
                                    </div>
                                </div>
                            </div> -->
                        </div>
                        
                        <div class="card-body pt-2">
                            <div id="calendar" style="width: 100%"></div>
                        </div>
                        
                        <span id="result"></span>
                    </div>
                </div>
            </div>


        </div>
    </section>
    
    <script>
    $( document ).ready(function() {
        var bookings = @json($events);
        
        $('#calendar').fullCalendar({
          events : bookings
        });
    });
    

</script>