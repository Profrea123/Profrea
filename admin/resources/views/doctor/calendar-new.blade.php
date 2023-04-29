
@include('user.userheader')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.7.2/css/all.min.css" integrity="sha512-3M00D/rn8n+2ZVXBO9Hib0GKNpkm8MSUU/e2VNthDyBYxKWG+BftNYYcuEjXlyrSO637tidzMBXfE7sQm0INUg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link href="{{ asset ('css/main.css') }}" rel='stylesheet' />
<script src="{{ asset ('js/main.js') }}"></script>

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
                    
                </div>
            </div>
        </div> 

            <span id="result"></span>

    </div>
</section>
<script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>
<script>
$( document ).ready(function() {
    var url = "<?php echo url('doctor/get-dr-booking/'.$segment3) ?>";
    $.ajax({
        type: "GET",
        url: url,
        dataType:"json",
        success: function(response){
            console.log(response);

        }
    });
});
document.addEventListener('DOMContentLoaded', function() {
var calendarEl = document.getElementById('calendar');

var calendar = new FullCalendar.Calendar(calendarEl, {
  headerToolbar: {
    left: 'prev,next today',
    center: 'title',
    right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
  },
  initialDate: '2022-09-12',
  navLinks: true, // can click day/week names to navigate views
  businessHours: true, // display business hours
  editable: true,
  selectable: true,
  events: [
    {
      title: 'Business Lunch',
      start: '2022-09-03T13:00:00',
      constraint: 'businessHours'
    },
    {
      title: 'Meeting',
      start: '2022-09-13T11:00:00',
      constraint: 'availableForMeeting', // defined below
      color: '#257e4a'
    },
    {
      title: 'Conference',
      start: '2022-09-18',
      end: '2022-09-20'
    },
    {
      title: 'Party',
      start: '2022-09-29T20:00:00'
    },

    // areas where "Meeting" must be dropped
    {
      groupId: 'availableForMeeting',
      start: '2022-09-11T10:00:00',
      end: '2022-09-11T16:00:00',
      display: 'background'
    },
    {
      groupId: 'availableForMeeting',
      start: '2022-09-13T10:00:00',
      end: '2022-09-13T16:00:00',
      display: 'background'
    },

    // red areas where no events can be dropped
    {
      start: '2022-09-24',
      end: '2022-09-28',
      overlap: false,
      display: 'background',
      color: '#ff9f89'
    },
    {
      start: '2022-09-06',
      end: '2022-09-08',
      overlap: false,
      display: 'background',
      color: '#ff9f89'
    }
  ]
});

calendar.render();
});

</script>

<style>
    body {
        margin: 40px 10px;
        padding: 0;
        font-family: Arial, Helvetica Neue, Helvetica, sans-serif;
    font-size: 14px;
    }

    #calendar {
        max-width: 1100px;
        margin: 0 auto;
    }
</style>
