
@include('user.userheader')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.7.2/css/all.min.css" integrity="sha512-3M00D/rn8n+2ZVXBO9Hib0GKNpkm8MSUU/e2VNthDyBYxKWG+BftNYYcuEjXlyrSO637tidzMBXfE7sQm0INUg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<?php  
    $segment = Request::segment(0);  
    $segment3 = Request::segment(3);

    $mobile_no              = $_GET["mobile_no"] ?? '';
    $booking_no             = $_GET["booking_no"] ?? '';
    $booking_date_filter    = $_GET["booking_date_filter"] ?? '';
    $booking_type           = $_GET["booking_type"] ?? '';
    $booking_status         = $_GET["booking_status"] ?? '';

    $per_page_record = 10;     
    if (isset($_GET["page"]) &&  $_GET["page"] != '' ) {
        $page  = $_GET["page"];
    }else {
        $page=1;
    }

    $start_from = ($page-1) * $per_page_record;

    $last_year  = date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s") . " - 1 year"));
    $today      = date("Y-m-d");
?>

  <section class="bg-space-header">
        <div class="container">         
           <div class="row pt-5">
                <div class="clearfix">
                    <div class="float-left">
                        <h2 class="space-headtitle f1 fw-bold">Booking History</h2>
                    </div>
                    
                    <div class="float-right">
                        <a class="btn btn-success" href="{{ $segment }}/profile-view"> Back</a>
                    </div>
                </div>

               
               
            </div>
        </div>


        <div class="container">
            <div class="row align-items-center mt-3">
                <div class="col-xl-12 col-lg-12 col-md-6 mb-5">
                    <div class="card border-0 rounded shadow overflow-hidden">
                        <div class="card-body">

                            <div class="row pt-2">
                                <div class="col-lg-6 offset-lg-3 text-center">
                                    <div id="calendar" style="width: 100%"></div>
                                </div>
                            </div>

                            <div class="row align-center border-bottom-dashed mt-2" id="list-of-booking" style="display:none;">
                            <div class="offset-2" id="bookingShedule">...Booking List...</div>
                            
                            @if(0)
                            @foreach($booking_details as $booking)

                                @if($booking['profile_picture'] != '' && file_exists("datafiles/uploads/profiles/".$booking['profile_picture'])) 
                                    <?php $src = "datafiles/uploads/profiles/".$booking['profile_picture']; ?> 
                                @else  
                                    <?php $src = "no-image.png"; ?> 
                                @endif

                                <div class="col-xl-1 col-lg-1 col-md-3 text-center">
                                    <img src="{{ $src }}" class="img-fluid doctor-list-img" alt="">
                                </div>
                                
                                @if ($row_user['profession_id'] == 1)
                                    <div class="col-xl-7 col-lg-7 col-md-6 mb-3">
                                        @if($booking['booking_status'] == 0)
                                            <h5 class="d-block mb-0 doc-name">{{ $booking['name'] ?? '' }} <i class="bk_pending">Pending</i></h5>
                                        @elseif($booking['booking_status'] == 1)
                                            <h5 class="d-block mb-0 doc-name">{{ $booking['name'] ?? '' }} <i class="bk_completed">Completed</i></h5>
                                        @else
                                            <h5 class="d-block mb-0 doc-name">{{ $booking['name'] ?? '' }} <i class="bk_cancelled">Cancelled</i></h5>
                                        @endif
                                        <h6 class="title text-dark d-block mb-0">Booking Date: {{ $booking['booking_date'] ?? '' }} </h6>
                                        <h6 class="title text-dark d-block mb-0">Booking Time: {{ $booking['booking_time'] ?? '' }}</small>
                                    </div>
                                @else
                                    <div class="col-xl-7 col-lg-7 col-md-6 mb-3">
                                        @if($booking['booking_status'] == 0)
                                            <h5 class="d-block mb-0 doc-name">Dr.{{ $booking['name'] ?? '' }}<i class="bk_pending">Pending</i></h5>
                                        @elseif($booking['booking_status'] == 1)
                                            <h5 class="d-block mb-0 doc-name">Dr.{{ $booking['name'] ?? '' }} <i class="bk_completed">Completed</i></h5>
                                        @else
                                            <h5 class="d-block mb-0 doc-name">Dr.{{ $booking['name'] ?? '' }} <i class="bk_cancelled">Cancelled</i></h5>
                                        @endif
                                        <small class="text-muted speciality">{{ $booking['education'] ?? '' }} </small>
                                        <?php 
                                        $row_specialty = '';
                                        if($booking['speciality'] != '') {
                                            $sql_specialty = $db_connection->getDbHandler()->query("SELECT name FROM operating_specialty WHERE id = ".$booking['speciality']);
                                            $row_specialty = $sql_specialty->fetch();
                                        }
                                        if($row_specialty !='') {
                                        ?>
                                            <h6 class="text-muted speciality">{{ $row_specialty['name'] ?? '' }}</h6>
                                        <?php } ?>
                                        <h6 class="title text-dark d-block mb-0">Booking Date: {{ $booking['booking_date'] ?? '' }}</h6>
                                        <h6 class="title text-dark d-block mb-0">Booking Time: {{ $booking['booking_time'] ?? '' }}</small>
                                    </div>
                                @endif
                                
                                <div class="col-xl-4 col-lg-4 col-md-6">
                                    <div class="">
                                        <?php  
                                            $current_date = strtotime(date('Y-m-d h:i A'));

                                            preg_match("/([0-9]+)/", $booking['time_duration'], $time_duration);
                                            $duration           = date('h:i A', strtotime('+'.$time_duration[0].'minutes', strtotime($booking['booking_time'])));
                                            $booking_duration   = strtotime($booking['booking_date'].$duration); 
                                            
                                            $booking_time       = date('h:i A', strtotime('-1 minutes', strtotime($booking['booking_time']))); 
                                            $booking_date       = strtotime($booking['booking_date'].$booking_time) ?>

                                        <!-- join Link -->
                                        @if( $current_date >= $booking_date && $current_date < $booking_duration && $booking['booking_status'] == 0 )
                                            <a href="video-call.php?channel=2222&token=006b0f2efac08d548239012af03cd1f5730IABivtcZSkkDXkhRgaTErKsdhs4h05s7HL9iEcvuNVjMCjnbLnkh39v0IgAO4gAAT5bSYgQAAQBXWNFiAwBXWNFiAgBXWNFiBABXWNFi"><button class="bk_his_join_link_btn"><i class="feather-link"></i> Join Link</button></a>
                                        @endif

                                        <!-- View  -->
                                        <a href="{{ $segment.'/booking-details?booking='.$booking['booking_no'] }}"><button class="bk_his_view_btn"><i class="feather-eye"></i> View</button></a>
                                        
                                        <!-- Booking Cancel -->
                                        @if( $current_date < $booking_date  && $booking['booking_status'] == 0)
                                            <a href="javascript:void(0)" data-bs-toggle="modal" data-id="{{ $booking['booking_no'] }}" class="cancel" data-bs-target="#bookingCancel"><button class="bk_his_cancel_btn fs15"><i class="feather-trash-2"></i> Cancel</button></a>
                                        @endif

                                        <!-- Booking Status -->
                                        @if ($row_user['profession_id'] == 1 && $current_date >= $booking_date && $booking['booking_status'] == 0)
                                            <a href="javascript:void(0)" data-bs-toggle="modal" data-id="{{ $booking['booking_no'] }}" class="complete" data-bs-target="#bookingComplete"><button class="btn btn-warning fs15" style="border-radius: 25px;" ><i class="feather-alert-circle"></i> Status</button></a>

                                            <a href="javascript:void(0)" data-id="{{ $booking['booking_no'] }}" class="caseSheet"><button class="btn btn-info  text-light fs15" style="border-radius: 25px;" ><i class="feather-align-justify"></i> Case Sheet</button></a>
                                        @endif

                                     </div>
                                </div>
                                
                                @endforeach
                                @endif
                            </div>

                        </div>
                    </div>
                </div>

                
            </div>
        </div>  
    </section>                                      
    
    
    <script>
    $( document ).ready(function() {
      var bookings = @json($events);
      var base_url = window.location.hostname;
        $('#calendar').fullCalendar({
            events : bookings,
            selectable : true,
            selectHelper : true,
            timeFormat: 'h(:mm)', 
            select: function(start,end,allDays){
                console.log(start)
            },
            eventClick: function eventClick(event) {
                var bookid = event.title;
                $.ajax({
                    url: "{{ route('doctor.get_one_booking') }}",
                    type: "POST",
                    dataType: 'json',
                    data: { booking_id : bookid, _token: '{{csrf_token()}}' },
                    success: function(response){
                        console.log(response);
                        $('#bookingShedule').html(response);
                        $('#list-of-booking').show();
                    },
                    error: function(er){
                        console.log('error');
                        console.log(er);
                    }
                });
            }
        });

        $('.filter').click(function (){
            booking_filter()
        });

        function booking_filter(){
            var mobile_no               = $('#mobile_no').val();
            var booking_no              = $('#booking_no').val();
            var booking_date_filter     = $('#booking_date').val();
            var booking_type            = $('#booking_type').val();
            var booking_status          = $('#booking_status').val();
            var page                    = $('.page').val();

            var url = "23"+'?page='+page+'&booking_no='+booking_no+'&booking_date_filter='+booking_date_filter+'&booking_type='+booking_type+'&booking_status='+booking_status+'&mobile_no='+mobile_no;
            window.location.href = url;
        }
    });

    $('.caseSheet').click(function(){
        
            var booking_no = $(this).data('id');
            var origin   = window.location.origin;   // Returns base URL (https://example.com)
            window.location.href = origin + '/admin/public/doctor/patient-case/'+ booking_no
        });
    </script>

    <style>
        .fc-time{
            display: none;
        }
    </style>