<?php 
date_default_timezone_set("Asia/Calcutta");
$title = "Booking Postpone";
$description = "";
$keywords = "";
$page = 1;

require_once('src/Classes/Model/Database.php');
require_once('vendor/autoload.php');
use App\Classes\Model\Database;
$db_connection = new Database;
if (version_compare(phpversion(), '5.4.0', '<')) {
    if(session_id() == '') {
        session_start();
    }
}
else
{
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
}
if (isset($_SESSION['ap_profrea_login_id'])) 
{
    $login_id       = $_SESSION['ap_profrea_login_id'];
    $sql_log_user   = $db_connection->getDbHandler()->query("SELECT id,name,profession_id,is_verified FROM users WHERE users.id = $login_id");
    $row_user       = $sql_log_user->fetch();

    if($row_user !='' && isset($_GET['booking']))
    {
        
        $booking_no = $_GET['booking'];

        $sql_files = $db_connection->getDbHandler()->query("SELECT * FROM attachments WHERE booking_no = '$booking_no'");
        $files     = $sql_files->fetchAll();

        if ($row_user['profession_id'] == 1) {
            $sql_booking = $db_connection->getDbHandler()->query("SELECT booking_details.*,users.* FROM booking_details LEFT JOIN users ON booking_details.user_id = users.id  WHERE booking_details.doctor_id=".$login_id." AND booking_details.booking_no = '$booking_no'");
        }

        $booking = $sql_booking->fetch();
    } else {
        header('Location: login');
    }

    $row_city ='';
    if($booking['city'] != ''){
        $sql_city = $db_connection->getDbHandler()->query("SELECT name FROM city WHERE id = ".$booking['city']);
        $row_city = $sql_city->fetch();
    }

}else{
    header('Location: login');
}

include_once('header-client.php');
?>
<section class="bg-space-header">
        <div class="container">
            <div class="row align-items-center mt-5">
                <div class="col-xl-12 col-lg-12 col-md-6 mb-5">
                    <div class="team border-0 rounded overflow-hidden">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-xl-8 col-lg-8 col-md-8 text-left">
                                    <div class="bk_det_doc_section shadow bk_det_doc_section_p20">
                                        <div class="check-mark-div">
                                            <img src="images/check.png" alt="" class="check-mark-gif"> 
                                            <span>Booking Postpone</span>
                                            <a href="booking-details?booking=<?php echo $booking['booking_no'];?>"><div class="float-right"><i class="fa fa-angle-double-left"></i> Back</div></a>
                                        </div> 
                                        <hr>
                                        <div class="pro-widget-content pl0">
                                            <div class="profile-info-widget">
                                                <img <?php if($booking['profile_picture'] != '' && file_exists("datafiles/uploads/profiles/".$booking['profile_picture'])) {?> src="datafiles/uploads/profiles/<?php echo $booking['profile_picture'];?>" <?php } else { ?> src="images/no-image.png"<?php } ?> class="img-fluid doctor-list-img" alt="">
                                                <div class="col-md-12">
                                                    <div class="row">
                                                        <?php if ($row_user['profession_id'] == 1) { ?>
                                                        <div class="col-md-8">
                                                            <div class="profile-det-info">
                                                                <div class="patient-details">
                                                                    <h3 class="d-block mb-0"><?php echo $booking['name'] ?? '';?></h3>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12 mt-1">
                                                            <div class="row">
                                                                <div class="col-lg-6">
                                                                    <small class="text-muted speciality">Address</small>
                                                                    <h6 href="#" class="d-block mb-0 doc-name"><span><?php echo $booking['address'] .' '.($row_city ? $row_city['name'] : '-' ).''.$booking['pinCode'] .' '.$booking['state']; ?></h6>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <?php } else { ?>
                                                        <div class="col-md-8">
                                                            <div class="profile-det-info">
                                                                <div class="patient-details">
                                                                <h3 class="d-block mb-0">Dr.<?php echo $booking['name'] ?? '';?></h3>
                                                                    <div class="text-muted speciality"><?php echo $booking['education'] ?? '';?></div>
                                                                    <?php 
                                                                    $row_specialty = '';
                                                                    if($booking['speciality'] != ''){
                                                                        $sql_specialty = $db_connection->getDbHandler()->query("SELECT name FROM operating_specialty WHERE id = ".$booking['speciality']);
                                                                        $row_specialty = $sql_specialty->fetch();
                                                                    }
                                                                    if($row_specialty !='') {
                                                                    ?>
                                                                        <div class="text-muted speciality"><?php echo $row_specialty['name'] ?? '';?></div>
                                                                    <?php } ?>
                                                                    <div class="text-muted speciality">Experience <?php echo $booking['experience'];?></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <?php } ?>
                                                        <div class="col-md-3">
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                            <small class="text-muted speciality">Reason for Visit</small>
                                            <h6 href="#" class="d-block mb-0 doc-name"><?php echo $booking['visiting_reason'] ?? '';?></h6>
                                            <!-- <h6 class="text-muted speciality">Plaza Park Lane, Bangalore - 98</h6> -->
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="row">
                                                <div class="col-lg-4">
                                                    <small class="text-muted speciality">Consulting Date & Time</small>
                                                    <h6 href="#" class="d-block mb-0 doc-name"><?php echo date('d-M-Y',strtotime($booking['booking_date'])) ?? '';?> <?php echo $booking['booking_time'] ?? '';?></h6>
                                                </div>
                                                <div class="col-lg-4">
                                                    <small class="text-muted speciality">Consulting Duration Time</small>
                                                    <h6 href="#" class="d-block mb-0 doc-name"><?php echo $booking['time_duration'] ?? '';?></h6>
                                                </div>
                                                <div class="col-lg-4">
                                                    <small class="text-muted speciality">Booking Type</small>
                                                    <h6 href="#" class="d-block mb-0 doc-name"><?php if($booking['booking_type'] == 1) { echo 'Audio'; }elseif($booking['booking_type'] == 2) { echo 'Video'; } else{ echo 'In-Clinic'; }?></h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> 
                                <div class="col-xl-4 col-lg-4 col-md-4 text-left">
                                    <div class="card p-3 shadow">
                                        <form id="booking-postpone" method="POST" novalidate>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="full-input p-2 col-md-12 me-4">
                                                        <label for="" class="form-label text-grey ft-14 mb-0">Choose Date*</label>
                                                        <input type="text" name="datepick" id="datepick" required class="form-control datepick">
                                                        <input type="hidden" name="booking_type" value="<?php echo $booking['booking_type']; ?>" id="booking_type" class="form-control" placeholder="">
                                                        <input type="hidden" name="booking_page" value="<?php echo $booking['doctor_id']; ?>" id="booking_page" class="form-control" placeholder="">
                                                        <input type="hidden" name="booking_no" value="<?php echo $booking['booking_no']; ?>" class="form-control">
                                                        <input type="hidden" name="time_duration" value="<?php echo $booking['time_duration']; ?>" class="form-control">
                                                        <input type="hidden" name="user_id" value="<?php echo $booking['user_id']; ?>" class="form-control">
                                                        <input type="hidden" name="payment_id" value="<?php echo $booking['payment_id']; ?>" class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row add_bottom_15 mt-3" id="content_3">
                                                <ul class="time_slots time_select ml-2">
                                                    
                                                </ul>
                                            </div>
                                            
                                            <p class="text-center">
                                                <button type="submit" id="btnbooknow" style="display:none;" class="btn_1 medium">PostPone</button>
                                            </p>
                                        </form>
                                    </div>
                                    <div id="booking_postpone"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>  
    </section> 
<?php include_once('footer.php');?>
<script src="js/moment-with-locales.min.js"></script> 
<script src="js/bootstrap-datetimepicker.min.js"></script> 

<script>
    $('.datepick').datetimepicker({
        format: 'YYYY-MM-DD',
        minDate:new Date()
    });

    $(document).ready(function() {
        
		$('.datepick').focusout(function() {
            $("#btnbooknow").hide();
			var bookingpage = $("#booking_page").val();

			const weekday = ["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"];

			var booking_date    =  $("#datepick").val();
            var date = booking_date.replaceAll('-', '/');
            var day             =  new Date(date);
            var booking_day     = weekday[day.getDay()];

			var booking_type    = $("#booking_type").val();
            // alert(bookingpage + '<br>' + booking_date + '<br>' + booking_day + '<br>' + booking_type)
            $(".time_slots").html('');
            $.ajax({
				type: 'POST',
                url: './includes/functions.php?action=get_booking_slots',
				data: {
					bookingpage: bookingpage,
					type: booking_type,
					booking_date: booking_date,
					booking_day: booking_day,
					chosendate: booking_date
				},
				success: function(responsedata) {
					$(".time_slots").html(responsedata);
				}
			});
		});

        $('#booking-postpone').on("click", '.chosen_slot_time_clinic, .chosen_slot_time_video, .chosen_slot_time_audio', function (e) {
            var chosen_slot_time = $('input[type=radio][name=chosen_slot_time]:checked').val();
            if (chosen_slot_time !='') {
                $("#btnbooknow").show();
            } else {
                $("#btnbooknow").hide();
            }
        });

        // Booking Postpone
  $("#booking-postpone").submit(function(e){
    e.preventDefault();
    if ( $(this).parsley().isValid() )
    {
      var formData = new FormData(this);
      $.ajax({
        type: 'POST',
        url: './includes/functions.php?action=booking-postpone',
        data: formData,
        cache: false,
        processData: false,
        contentType: false,
        beforeSend: function(){
          $('#booking_postpone').html('<p class="text-center"><i class="fa fa-spinner fa-spin"></i> Please wait as we process..</p>').fadeIn();
        },
        success : function(res){
          let resObj = JSON.parse(res);
          Swal.fire({
            icon: resObj.icon,
            title: resObj.title,
            text: resObj.msg,
          }).then(function() {
            $('#booking_postpone').html("").fadeIn();
            window.location = "booking-history"
        })
        }
      });
    }
    return false;
  });
	});
</script>