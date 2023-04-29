<link rel="stylesheet" href="css/bootstrap-glyphicons.css">

<?php 
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

$title = 'Video Timeslot';
$keywords = 'Profrea';
$description = 'Profrea';
$page="Video-timeslot";
function print_slot($dslot){

    $slot_array = explode("-",$dslot);
    $return_string ="";
    if($slot_array[0]>12){
        $return_string .= ($slot_array[0]-12).":00 PM to";
    }else{
        $return_string .= $slot_array[0].":00 AM to";
    }

    if($slot_array[1]>12){
        $return_string .= ($slot_array[1]-12).":00 PM";
    }else{
        $return_string .= $slot_array[1].":00 AM";
    }

    return $return_string;

}

if (isset($_SESSION['ap_profrea_login_id'])) 
{
    $login_id = $_SESSION['ap_profrea_login_id'];    
    
    $sql_user = "SELECT users.*, os.name as opspeciality, gender.name AS gender, city.name AS city FROM users 
        LEFT JOIN gender ON gender.id = users.gender_id 
        LEFT JOIN city ON city.id = users.city 
        LEFT JOIN operating_specialty AS os ON os.id = users.speciality
        WHERE users.id = $login_id";
    $res_user = $db_connection->getDbHandler()->query($sql_user);
    if($res_user)
    {
        $row_user = $res_user->fetch();        
       // print_r($row_user);
        if($row_user["profession_id"] == 1 && $row_user["rowstate"] == 0){
           // header('Location: profile-update');
        }
        if($row_user['profile_picture']!=''){
            $profile_picture = $row_user['profile_picture'];
        }
        else{
            if($row_user['gender_id']==1){
                $profile_picture = "male.png";
            }
            else{
                $profile_picture = "female.png";
            }
        }
    }

    $sql_website_details = "SELECT * FROM website_details as wd WHERE wd.user_id = $login_id";
    $res_website_details = $db_connection->getDbHandler()->query($sql_website_details);
    if($res_website_details)
    {     
        $row_website_details = $res_website_details->fetch();
    }

    $sql_time_slot_audio = "SELECT * FROM  doctor_time_slots WHERE doctor_id = $login_id AND type = 1";
    $res_time_slot_audio = $db_connection->getDbHandler()->query($sql_time_slot_audio);
    if($res_time_slot_audio)
    {
        $row_time_slots_audio = $res_time_slot_audio->fetchAll();
    }

    $sql_time_slot_video = "SELECT * FROM  doctor_time_slots WHERE doctor_id = $login_id AND type = 2";
    $res_time_slot_video = $db_connection->getDbHandler()->query($sql_time_slot_video);
    $row_time_slots_video = $res_time_slot_video->fetchAll();
}
else
{
    header('Location: login');
}
function getslug($string){
    $slug = trim($string); // trim the string
    $slug = preg_replace('/[^a-zA-Z0-9 -]/','',$slug ); // only take alphanumerical characters, but keep the spaces and dashes too...
    $slug = str_replace(' ','-', $slug); // replace spaces by dashes
    $slug = strtolower($slug);  // make it lowercase
    return $slug;
}


include_once("user_profile_header.php");

?>
    <!-- website section started -->
    <section class="bg-website">
        <div class="container">

                <div class="col-md-12"> 

                <div class="row pt-5 pb-5 align-items-center">
                    <div class="col-md-8 col-7 ">
                        <h1 class="website-detailhead f1 ft-32 fw-bold">Video TimeSlot</h1>
                    </div>
                    <div class="col-md-4 col-5">
                        <div class="edit-web text-blue "> 
                            <a href="Profile-view#video-timeslot">Back</a>
                        </div>
                    </div>

                    <div class="row pb-5">                        
                        <div class="col-md-12">

                            <div class="row pt-5 bg-white mt-5 pb-3">
                            

                                <form id="timeSlot" method="POST" novalidate>   
                                    <div class="col-lg-12 col-12">
                                        <?php 
                                            $slot = $slot_status = '';
                                            if(isset($row_website_details["slot_interval"])) {
                                                $slot = $row_website_details["slot_interval"];
                                            }
                                            if(isset($row_website_details["booking_slot_status"])) {
                                                $slot_status = $row_website_details["booking_slot_status"];
                                            }
                                        ?>
                                        
                                        <div class="row pt-2 pb-4 p-4">
                                            <div class="col-lg-12 col-12 ml-auto websiteformfield d-md-flex">
                                                <div class="col-lg-3 col-3 display_grid">
                                                    <label>Slot Interval</label>
                                                    <select class="p-2 col-lg-6 col-6" name="slot_interval" id="time_slot_interval" required>
                                                        <?php for($i=1; $i <= 12; $i++) {
                                                            $time_increment         = $i * 5;
                                                            $slot_time_generation   = $time_increment .' MIN';
                                                             ?>
                                                        <option value="<?php echo $slot_time_generation;?>" <?php if($slot == $slot_time_generation){ ?> selected <?php } ?>><?php echo $slot_time_generation;?></option>
                                                        <?php } ?>
                                                    </select>
                                                    <span class="ml-5 text-danger" id="slot_interval_error"></span>
                                                </div>
                                               
                                                <div class="col-lg-3 col-3 display_grid" >
                                                    <label>Booking Open Upto (In Days)</label>
                                                    <input type="number" name="booking_open_upto" min="1" required class="p-2 col-lg-6 col-6" <?php if(isset($row_website_details["booking_open_upto"])) { ?> value="<?php echo $row_website_details["booking_open_upto"]; ?>" <?php } ?>>
                                                    <span class="ml-5 text-danger" id="booking_open_upto_error"></span>
                                                </div>

                                                <div class="col-lg-3 col-3 display_grid" >
                                                    <label>Booking Slot Status</label>
                                                    <select class="p-2 col-lg-6 col-6" name="booking_slot_status" required>
                                                        <option value="1" <?php if($slot_status == 1){ ?> selected <?php } ?>>Open</option>
                                                        <option value="0" <?php if($slot_status == 0){ ?> selected <?php } ?>>Close</option>
                                                    </select>
                                                    <span class="ml-5 text-danger" id="booking_slot_status_error"></span>
                                                </div>

                                                <div class="col-lg-3 col-3 display_grid" >
                                                    <label>Video Amount Per Slot</label>
                                                    <input type="number" step="any" min="1" name="video_amount" required class="p-2 col-lg-6 col-6" <?php if(isset($row_website_details["video_amount"])) { ?> value="<?php echo $row_website_details["video_amount"]; ?>" <?php } ?>>
                                                    <span class="ml-5 text-danger" id="video_amount_error"></span>
                                                </div>

                                            </div>
                                            
                                        </div>
                                        
                                        <div class="container">
                                            <div class="col-lg-12">
                                                <div class="row col-12 p-2">
                                                    <?php
                                                    if (count($row_time_slots_video) > 0) {
                                                        $list_of_week_days = ['sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'];
                                                        foreach($row_time_slots_video as $video_slot) {
                                                            $required = false; $div_hide = true;
                                                            if ($video_slot['is_available']) {
                                                                $required = true; $div_hide = false;
                                                            }
                                                        ?>
                                                    <div class="col-lg-12 col-12 mt-4 ml-10 websiteformfield d-md-flex">
                                                        <div class="col-lg-2 col-2">
                                                        <input type="hidden" name="doctor_id" id="doctor_id" value="<?php echo $login_id ?>" readonly>
                                                        <input type="hidden" name="day[<?php echo $video_slot['day']; ?>]" id="<?php echo $video_slot['day']; ?>" value="<?php echo $video_slot['day'] ?>" readonly>
                                                            <label><?php echo ucfirst($video_slot['day']); ?> </label>
                                                        </div>
                                                        <div class="col-lg-1 col-1">
                                                            <label class="switch">
                                                                <input type="checkbox" class="check_time_list_validate video_slot_enable" data-index="<?php echo $video_slot['day']; ?>" data-day="<?php echo $video_slot['day'];?>" id="<?php echo $video_slot['day'];?>_video_is_available" name="video_is_available[<?php echo $video_slot['day'];?>]" value="1" <?php if ($video_slot['is_available']) { echo "checked"; }?>> <span class="slider round"></span> </label>
                                                        </div>
                                                        <div class="col-lg-9" <?php if($div_hide) { ?>style="display:none;"<?php } ?> id="<?php echo $video_slot['day'];?>_day_time_slot_div">
                                                            <div class="col-lg-12">
                                                                <div class="row mb-3">
                                                                    <div class="col-lg-3 col-3 mb-12">
                                                                        <label>Start Time</label>
                                                                        <input type="text" class="check_time_list_validate timepicker form-control" data-index="<?php echo $video_slot['day']; ?>" id="<?php echo $video_slot['day'];?>_video_start_time" name="video_start_time[<?php echo $video_slot['day'];?>]" value="<?php echo $video_slot['start_time']; ?>" <?php if($required) { ?>required<?php } ?>>
                                                                        <span class="ml-5 text-danger" id="<?php echo $video_slot['day']; ?>_video_start_time_error"></span>
                                                                    </div>
                                                                    <div class="col-lg-3 col-3 ml-2 mb-12">
                                                                        <label>End Time</label>
                                                                        <input type="text" class="check_time_list_validate timepicker form-control" data-index="<?php echo $video_slot['day']; ?>" id="<?php echo $video_slot['day'];?>_video_end_time" name="video_end_time[<?php echo $video_slot['day'];?>]" value="<?php echo $video_slot['end_time']; ?>" <?php if($required) { ?>required<?php } ?>>
                                                                        <span class="ml-5 text-danger" id="<?php echo $video_slot['day']; ?>_video_end_time_error"></span>
                                                                    </div>
                                                                </div> 
                                                            </div>
                                                            <div class="col-xl-12" id="<?php echo $video_slot['day'];?>_times_list_div"></div> 
                                                        </div> 
                                                    </div> 
                                                    <?php } 
                                                    } else {
                                                        $list_of_week_days = ['sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'];
                                                        foreach($list_of_week_days as $result_day) {
                                                        ?>
                                                    <div class="col-lg-12 col-12 mt-4 ml-10 websiteformfield d-md-flex">
                                                        <div class="col-lg-2 col-2">
                                                        <input type="hidden" name="doctor_id" id="doctor_id" value="<?php echo $login_id ?>" readonly>
                                                        <input type="hidden" name="day[<?php echo $result_day ?>]" id="<?php echo $result_day ?>" value="<?php echo $result_day ?>" readonly>
                                                            <label><?php echo ucfirst($result_day); ?> </label>
                                                        </div>
                                                        <div class="col-lg-1 col-1">
                                                            <label class="switch">
                                                                <input type="checkbox" class="check_time_list_validate video_slot_enable" data-index="<?php echo $result_day; ?>" data-day="<?php echo $result_day;?>" id="<?php echo $result_day;?>_video_is_available" name="video_is_available[<?php echo $result_day;?>]" value="1"> <span class="slider round"></span> </label>
                                                        </div>
                                                        <div class="col-lg-9" style="display:none;" id="<?php echo $result_day;?>_day_time_slot_div">
                                                            <div class="col-lg-12">
                                                                <div class="row mb-3">
                                                                    <div class="col-lg-3 col-3 mb-12">
                                                                        <label>Start Time</label>
                                                                        <input type="text" class="check_time_list_validate timepicker form-control" data-index="<?php echo $result_day; ?>" id="<?php echo $result_day;?>_video_start_time" name="video_start_time[<?php echo $result_day;?>]"> 
                                                                        <span class="ml-5 text-danger" id="<?php echo $video_slot['day']; ?>_video_start_time_error"></span>
                                                                    </div>
                                                                    <div class="col-lg-3 col-3 ml-2 mb-12">
                                                                        <label>End Time</label>
                                                                        <input type="text" class="check_time_list_validate timepicker form-control" data-index="<?php echo $result_day; ?>" id="<?php echo $result_day;?>_video_end_time" name="video_end_time[<?php echo $result_day;?>]">
                                                                        <span class="ml-5 text-danger" id="<?php echo $video_slot['day']; ?>_video_end_time_error"></span>
                                                                    </div>
                                                                </div> 
                                                            </div>
                                                            <div class="col-xl-12" id="<?php echo $result_day;?>_times_list_div"></div> 
                                                        </div> 
                                                    </div> 
                                                    <?php } } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                        
                                    <div class="col-lg-12 col-12 pb-5 mt-5 mt-md-0 text-center">                                        
                                        <div class="vi-sub mt-5">
                                            <input type="hidden" name="id" value="<?php echo $login_id; ?>" />
                                            <button class="submit-btn" type="submit">Submit</button>                                            
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                            
                    </div>
                </div>
        </div>
    </section>

    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.js"></script>
    <script src="js/bootstrap.popper.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/font-awesome.js"></script>
    
    
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
    <script src="js/parsley.min.js"></script>
    <script src="js/moment-with-locales.min.js"></script> 
    <script src="js/bootstrap-datetimepicker.min.js"></script> 

    <script type="text/javascript">
    $(function () {
        $(document).ready(function(){
            $(".video_slot_enable").on('click',function(){
                var day = $(this).attr('data-day');
                if($(this).is(':checked')) {
                    $('#'+day+'_day_time_slot_div').show();
                    $('#'+day+'_video_start_time, #'+day+'_video_end_time').prop('required',true);
                    $('#'+day+'_video_start_time, #'+day+'_video_end_time').val('');
                    $(this).val(1);
                } else {
                    $('#'+day+'_day_time_slot_div').hide();
                    $('#'+day+'_video_start_time, #'+day+'_video_end_time').prop('required',false);
                    $('#'+day+'_video_start_time, #'+day+'_video_end_time').val('');
                    $(this).val(0);
                }
            });
        });

        //Timeslot
        $("#timeSlot").submit(function(e){
            e.preventDefault();
            if ( $(this).parsley().isValid() )
            {
                var formData = new FormData(this);
                $.ajax({
                    type: 'POST',
                    url: './includes/functions.php?action=timeSlot',
                    data: formData,
                    cache: false,
                    processData: false,
                    contentType: false,
                    beforeSend: function(){},
                    success : function(res){
                        var resObj = jQuery.parseJSON(res);

                        if(resObj.status){
                            let resObj = JSON.parse(res);
                            Swal.fire({
                            icon: resObj.icon,
                            title: resObj.title,
                            text: resObj.msg,
                            }).then((result) => {
                                window.location = "profile-view#video-timeslot"
                            });
                        } else {
                            Swal.fire({
                                icon: resObj.icon,
                                title: resObj.title,
                                text: resObj.msg,
                            });
                            $('#slot_interval_slot').html(resObj.errors.slot_interval ?? '');
                            $('#booking_open_upto_error').html(resObj.errors.booking_open_upto ?? '');
                            $('#booking_slot_status_error').html(resObj.errors.booking_slot_status ?? '');
                            $('#video_amount_error').html(resObj.errors.video_amount ?? '');
                            $('#sunday_video_start_time_error').html(resObj.errors.sunday_video_start_time ?? '');
                            $('#sunday_video_end_time_error').html(resObj.errors.sunday_video_end_time ?? '');
                            $('#monday_video_start_time_error').html(resObj.errors.monday_video_start_time ?? '');
                            $('#monday_video_end_time_error').html(resObj.errors.monday_video_end_time ?? '');
                            $('#tuesday_video_start_time_error').html(resObj.errors.tuesday_video_start_time ?? '');
                            $('#tuesday_video_end_time_error').html(resObj.errors.tuesday_video_end_time ?? '');
                            $('#wednesday_video_start_time_error').html(resObj.errors.wednesday_video_start_time ?? '');
                            $('#wednesday_video_end_time_error').html(resObj.errors.wednesday_video_end_time ?? '');
                            $('#thursday_video_start_time_error').html(resObj.errors.thursday_video_start_time ?? '');
                            $('#thursday_video_end_time_error').html(resObj.errors.thursday_video_end_time ?? '');
                            $('#friday_video_start_time_error').html(resObj.errors.friday_video_start_time ?? '');
                            $('#friday_video_end_time_error').html(resObj.errors.friday_video_end_time ?? '');
                            $('#saturday_video_start_time_error').html(resObj.errors.saturday_video_start_time ?? '');
                            $('#saturday_video_end_time_error').html(resObj.errors.saturday_video_end_time ?? '');
                        }
                    },
                    error : function (error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Validation error',
                            text: 'Unable to Process Check missing fields',
                            }).then((result) => {
                                window.location = "video-timeslot"
                        });
                    }
                });
            }
            return false;
        });

        function time_slot(index) {
            var doctor_id           = $('#doctor_id').val();
            var time_slot_interval  = $('#time_slot_interval').val();
            var booking_start_time  = $('#'+index+'_video_start_time').val();
            var booking_end_time    = $('#'+index+'_video_end_time').val();
            var video_is_available  = $('#'+index+'_video_is_available:checked').val();
            var start_time          = moment(booking_start_time, 'hh:mm A').format('HH:mm');
            var end_time            = moment(booking_end_time, 'hh:mm A').format('HH:mm');

            if ((start_time != 'Invalid date') && (end_time != 'Invalid date') && (time_slot_interval != '') && (video_is_available == 1) ) {
                if (start_time <= end_time) {
                    $.ajax({
                        type: 'POST',
                        url: './includes/functions.php?action=getVideoTimeSlotList',
                        data : {time_slot_interval:time_slot_interval,booking_start_time:booking_start_time,booking_end_time:booking_end_time, index:index,doctor_id:doctor_id},
                        success : function (response) {
                            $('#'+index+'_times_list_div').html(response);
                        }
                    });
                    $('#'+index+'_times_list_div').removeClass('d-none');

                } else {
                    $('#'+index+'_times_list_div').addClass('d-none');
                    $('#'+index+'_times_list_div').html('');
                }   
            } else {
                $('#'+index+'_times_list_div').html('');
            }
        }

        $('.check_time_list_validate').on('change', function (e) {
            var index   = $(this).attr("data-index");
            time_slot(index);
        });

        $('.timepicker').datetimepicker({ 
            format: 'hh:mm A',
            
        });

        $(".timepicker").on("dp.change", function (e) {
            var index   = $(this).attr("data-index");
            time_slot(index);
        });

        $(':checkbox:checked').each(function() {
            var index   = $(this).attr("data-index");
            time_slot(index);
        });
        
        $("#time_slot_interval").on("change", function(e) {
            $(':checkbox:checked').each(function() {
                var index   = $(this).attr("data-index");
                time_slot(index);
            });
        });
    });
</script>

</body>
</html> 