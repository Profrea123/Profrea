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

if (isset($_GET['domain'])) 
{
    // $login_id = base64_decode($_GET['id']);    
    $domain = $_GET['domain'];
    $sql_website_details = "SELECT * FROM website_details as wd  WHERE wd.domain = '$domain'";
    $res_website_details = $db_connection->getDbHandler()->query($sql_website_details);
    if($res_website_details)
    {
        $row_website_details = $res_website_details->fetch();
        $user_id = $row_website_details['user_id'];
        $sql_user = "SELECT users.*,city.name as city,os.name as op_speciality,os.id as op_specialityid FROM users left join operating_specialty as os on os.id = users.speciality left join gender on gender.id=users.gender_id left join city on city.id=users.city WHERE users.id = $user_id";
        $res_user = $db_connection->getDbHandler()->query($sql_user);
        if($res_user)
        {
            $row_user = $res_user->fetch();
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

            $splid = $row_user['op_specialityid'];
        }

          //$sql_profrea_clinic = "SELECT * FROM spaces WHERE owner_id = $login_id AND space_type = 'Clinic'";
            $sql_profrea_clinic = "SELECT sbook.*,sp.* FROM space_bookings as sbook 
            LEFT JOIN spaces AS sp ON sp.id = sbook.space_id
            WHERE sbook.user_id = $user_id and sbook.booking_status > 0";

            $res_profrea_clinic = $db_connection->getDbHandler()->query($sql_profrea_clinic);
        
            if($res_profrea_clinic)
            {
                $row_profrea_clinic = $res_profrea_clinic->fetchAll();
            }
        
        $sql_clinic_details= "SELECT * FROM clinic_details  WHERE user_id = $user_id";
        $res_clinic_details = $db_connection->getDbHandler()->query($sql_clinic_details);
        if($res_clinic_details)
        {     
            $row_clinic_details= $res_clinic_details->fetchAll();
        }


        $sql_video_details = "SELECT * FROM clinic_yt_videos WHERE user_id = $user_id";
        $res_video_details = $db_connection->getDbHandler()->query($sql_video_details);
        if($res_video_details)
        {     
            $row_video_details = $res_video_details->fetchAll();
        }
    
        //clinic gallery
        $sql_gallery_details = "SELECT * FROM clinic_gallery WHERE user_id = $user_id";
        $res_gallery_details = $db_connection->getDbHandler()->query($sql_gallery_details);
        if($res_gallery_details)
        {     
            $row_gallery_details = $res_gallery_details->fetchAll();
        }


        //doctor services
        $sql_service_details = "SELECT * FROM doctor_services WHERE speciality = $splid";
        $res_service_details = $db_connection->getDbHandler()->query($sql_service_details);
        if($res_service_details)
        {     
            $row_service_details = $res_service_details->fetchAll();
        }
    
        if(isset($row_video_details[0]['id'])){
            $ytlink = $row_video_details[0]['ytlink'];
        }else {
            $ytlink = "tuh-atYeaKM";
        }

        // print_r( $row_website_details);
    }
    else{
        header('Location: index');
    }
}
else
{
    header('Location: index');
}

if(count($row_profrea_clinic) > 0){
    $ccity = $row_profrea_clinic[0]['locality'].", ".$row_profrea_clinic[0]['city'];
}else {
    $ccity = "Gurugram";
}

$title = "Dr. ".ucwords($row_user["name"])." top ".$row_user["op_speciality"]." in ".$ccity;
$description = $title;

$keywords = "";
$page = 1;
include_once('header-client.php');
?>

<!-- .video background section started -->
<section class="bg-mainsingle-video mt-5 mt-md-0 position-relative">
    <div class="container pt-5 pb-5 ">
        <div class="row align-items-center">
            <div class="col-lg-5 ">
                <div class="row">
                    <div class="col-md-3 col-3 cir-newimg text-center">
                        <img src="datafiles/uploads/profiles/<?php echo $profile_picture; ?>" title="<?php echo "Dr. ".ucwords($row_user["name"]); ?>" class="img-fluid">
                    </div>
                    <div class="col-md-9 col-9 align-self-stretch">
                        <div><h4 class="herohead pt-3"><?php echo "Dr. ".ucwords($row_user["name"]); ?><i class="fa fa-check-circle"></i></h4></div>
                       <!-- <div><h6 class="subherohead">DMC 8021</h6></div> -->
                      <?php if($row_website_details['google_review_link'] != "") ?>
                       <div class="google-rev"><a target="_blank" href="<?php echo $row_website_details['google_review_link']; ?>" style="color:#222!important";><i class="fab fa-google text-primary"></i> -  Google Reviews</a></div>
                    </div>
                    <div class="col-md-12 pt-4 ">
                        <h6 class="subherohead"><?php echo $row_user["education"]; ?></h6>
                        <h6 class="subherohead"><?php echo $row_user["op_speciality"]; ?></h6>
                    </div>
                    <div class="col-xxl-4 col-lg-5 col-md-3 col-sm-4  col-6 p-3">
                        <div class="bve-box">
                            <div class="bveicon text-end">
                                <i class="fa fa-briefcase"></i>
                            </div>
                            <h6 class="bvebox-head"><?php echo $row_user["experience"]; ?> Years</h6>
                            <p class="bvebox-subhead pb-0">Pratice Experience</p>
                        </div>
                    </div>
                   <!-- <div class="col-xxl-4 col-lg-5 col-md-3 col-sm-4 col-6 p-3">
                        <div class="bve-box">
                            <div class="bveicon text-end">
                                <i class="fa fa-book"></i>
                            </div>
                            <h6 class="bvebox-head">2</h6>
                            <p class="bvebox-subhead pb-0">Patient stories</p>
                        </div>
                    </div> -->
                </div>
            </div>
             <div class="col-lg-7  mt-3 mt-lg-0">
                    <iframe 
                        width="640" height="360"
                        src="https://www.youtube.com/embed/<?php echo  $ytlink;  ?>?autoplay=1&mute=1&enablejsapi=1&loop=1"
                        frameborder="0"
                        
                        ></iframe>
                        <div class="newdirectionbtn text-center pt-4 pb-4">
                            <a href="videos">More Videos</a>
                        </div>
                </div>
                
            </div>

        </div>
    </div>
</section>
<!-- .video background section ended -->


<!-- 2nd section started -->
<section class="bg-appt">
    <div class="container">
        <div class="row pt-2 pb-2">
            <div class="col-lg-8">
                <div class="bg-white shadow br-sp p-3">
                    <div class="row">
                        <div class="col-md-6 pt-2">
                            <h5 class="bookhead">Book Appointment</h5>
                            <h6 class="booksub">Select Your Consultation Type<h6>
                            <p class="green-para">Fees ₹ 
                                <span class="audio-amount" ><?php echo $row_website_details['audio_amount']; ?> </span>
                                <span class="video-amount" style="display: none;"><?php echo $row_website_details['video_amount']; ?> </span>
                                <span class="clinic-amount" style="display: none;"><?php echo $row_website_details['clinic_amount']; ?> </span>
                            </p>
                        </div>                        
                        <div class="col-md-6 contacttabviews">
                            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="pills-audio-tab" data-bs-toggle="pill" data-bs-target="#pills-audio" type="button" role="tab" aria-controls="pills-audio" aria-selected="false">
                                    <div class="text-center">
                                        <i class="fa fa-phone-alt"></i>
                                    </div>
                                    <h6 class="contacticonlabel mb-0 pt-2">Audio</h6>
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="pills-video-tab" data-bs-toggle="pill" data-bs-target="#pills-video" type="button" role="tab" aria-controls="pills-video" aria-selected="true">
                                    <div class="text-center">
                                        <i class="fa fa-video-camera"></i>
                                    </div>
                                    <h6 class="contacticonlabel mb-0 pt-2">video</h6>
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="pills-clinic-tab" data-bs-toggle="pill" data-bs-target="#pills-clinic" type="button" role="tab" aria-controls="pills-clinic" aria-selected="false">
                                    <div class="text-center">
                                        <i class="fa fa-home"></i>
                                    </div>
                                    <h6 class="contacticonlabel mb-0 pt-2">In-Clinic</h6>
                                    </button>
                                </li>
                            </ul>
                            
                        </div>
                        <div class="col-md-12">
                            <div class="tab-content" id="pills-tabContent">
                                <div class="tab-pane fade show active" id="pills-audio" role="tabpanel" aria-labelledby="pills-audio-tab">
                                    <!-- <div class="tabs_styled_2">
                                        <div class="tab-content">
                                            <div class="tab-pane fade show active" id="book" role="tabpanel" aria-labelledby="book-tab">
                                                
                                            </div>
                                        </div>
                                    </div> -->
                                    <?php if ($row_website_details['audio_booking_slot_status']) { ?>
                                    <form id="checkout-selection" action="booking_appointment.php" method="POST">	
                                        <input type="hidden" name="bookingpage" id="bookingpage" value="<?php echo $user_id;?>">
                                        <input type="hidden" name="chosendate" id="chosendate_1" value="<?php echo date('d-m-Y'); ?>">
                                        <input type="hidden" name="booking_type" id="booking_type" value="1">
                                        <div class="row add_bottom_15" id="content_2">
                                            <div id="" class="caldates owl-carousel owl-theme">
                                            <?php 
                                            for ($bou=0; $bou < $row_website_details['audio_booking_open_upto']; $bou++) {
                                                    $current_date   = date('d-m-Y');
                                                    $booking_date   = date('d-m-Y', strtotime($current_date . ' +'.$bou.' day'));
                                                    $current_day    = '';
                                                    if (date('d-m-Y') == $booking_date) {
                                                        $current_day = 'Today';
                                                    }
                                                    if (date('d-m-Y', strtotime($current_date . ' +1 day')) == $booking_date) {
                                                        $current_day = 'Tomorrow';
                                                    }
                                                ?>
                                                <div class="item">
                                                    <div id="calendar_dates" data-timeslot="audio_" data-bookingpage="<?php echo $user_id;?>" data-booking_type="1" data-booking_date="<?php echo $booking_date;?>" data-booking_day="<?php echo date('l', strtotime($booking_date));?>" class="link clicked" <?php if($bou==0) { ?>style="color:#fff;background:#0176c4" <?php } ?>> <small><?php echo $current_day; ?></small>
                                                        <br>
                                                        <input type="hidden" value="<?php echo $booking_date;?>"> <strong><?php echo date('d M', strtotime($booking_date));?></strong>
                                                        <br> <small><?php echo date('l', strtotime($booking_date));?></small>
                                                    </div>
                                                </div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <div class="row add_bottom_15" id="content_3">
                                            <ul class="audio_time_slots time_select">
                                                <?php
                                                $current_date               = date('d-m-Y');
                                                $result_day                 = strtolower(date('l', strtotime($current_date)));
                                                $sql_holiday       = "SELECT * FROM holidays as h WHERE h.from_date >= '".date('Y-m-d', strtotime($current_date))."' AND h.to_date <= '".date('Y-m-d', strtotime($current_date))."' AND h.doctor_id = ".$user_id ." ";
                                                $check_holiday     = $db_connection->getDbHandler()->query($sql_holiday);
                                                $row_holiday  	   = $check_holiday->fetchAll();
                                                if(count($row_holiday) > 0){
                                                    echo '<li style="display: contents;">
                                                        <div class="row text-center">
                                                            <h6>Doctor Not Available</h6>
                                                        </div>
                                                    </li>';
                                                } else {
                                                $sql_doctor_time_slot       = "SELECT id,is_available FROM doctor_time_slots as a WHERE a.doctor_id = ".$user_id . " AND a.day = '$result_day' AND a.type = 1";
                                                $check_doctor_time_slot     = $db_connection->getDbHandler()->query($sql_doctor_time_slot);
                                                $existing_doctor_time_slot  = $check_doctor_time_slot->fetch();
                                                if($existing_doctor_time_slot != '' && isset($existing_doctor_time_slot['is_available']) && $existing_doctor_time_slot['is_available'] == 1) {
                                                    $doctor_time_slot_id            = $existing_doctor_time_slot['id'];
                                                    $sql_time_slot_audio            = "SELECT * FROM  doctor_day_time_slots WHERE doctor_time_slot_id = $doctor_time_slot_id";
                                                    $res_time_slot_audio            = $db_connection->getDbHandler()->query($sql_time_slot_audio);
                                                    $list_of_available_time_slots   = $res_time_slot_audio->fetchAll();

                                                    $sql_booking_slot   = "SELECT id,booking_time FROM booking_details WHERE doctor_id = $user_id AND booking_date = '".date('Y-m-d')."' AND booking_status !=2";
                                                    $res_booking_slot   = $db_connection->getDbHandler()->query($sql_booking_slot);
                                                    $today_booking_slots = $res_booking_slot->fetchAll();
                                                    $selected_booking_slots = array_map(function ($value) { return $value['booking_time']; }, $today_booking_slots);
                                                    
                                                    if ($list_of_available_time_slots) {
                                                        $booked_count = 0;
                                                        foreach ($list_of_available_time_slots as $loopKey=>$list_time_slot) {
                                                            if(!in_array($list_time_slot['slot_time'], $selected_booking_slots) && strtotime($list_time_slot['slot_time']) > strtotime(date('g:i A'))) {
                                                                $booked_count = $booked_count + 1;
                                                ?>
                                                <li>
                                                    <input type="radio" id="radio<?php echo $list_time_slot['id']; ?>" class="chosen_slot_time_audio" name="chosen_slot_time" value="<?php echo $list_time_slot['slot_time']; ?>">
                                                    <label id="lblradio<?php echo $list_time_slot['id']; ?>" for="radio<?php echo $list_time_slot['id']; ?>"><?php echo $list_time_slot['slot_time']; ?></label>
                                                </li>
                                                
                                                <?php 
                                                            }
                                                        }
                                                        if ($booked_count == 0) {
                                                            echo '<li style="display: contents;">
                                                                <div class="row text-center">
                                                                    <h6>No Slots Available</h6>
                                                                </div>
                                                            </li>';
                                                        }
                                                ?>
                                            
                                            <?php } else { ?>
                                                    <li style="display: contents;">
                                                        <div class="row text-center">
                                                            <h6>No Slots Available</h6>
                                                        </div>
                                                    </li>
                                                <?php } } else { ?>
                                                    <li style="display: contents;">
                                                        <div class="row text-center">
                                                            <h6>No Slots Available</h6>
                                                        </div>
                                                    </li>
                                                <?php } }?>
                                                
                                            </ul>
                                        </div>
                                        <hr>
                                        <p class="text-center">
                                            <button type="submit" id="btnbooknowaudio" style="display:none;" class="btn_1 medium">Book Now</button>
                                        </p>
                                    </form>
                                    <?php } else { ?>
                                        <p class="text-center">
                                            Booking slot not Available.
                                        </p>
                                    <?php } ?>
                                </div>
                                <div class="tab-pane fade" id="pills-video" role="tabpanel" aria-labelledby="pills-video-tab">
                                    <!-- <div class="tabs_styled_2">
                                        <div class="tab-content">
                                            <div class="tab-pane fade" id="book" role="tabpanel" aria-labelledby="book-tab">
                                                
                                            </div>
                                        </div>
                                    </div> -->
                                    <?php if ($row_website_details['booking_slot_status']) { ?>
                                    <form id="checkout-selection" action="booking_appointment.php" method="POST">	
                                        <input type="hidden" name="bookingpage" id="bookingpage" value="<?php echo $user_id;?>">
                                        <input type="hidden" name="chosendate" id="chosendate_2" value="<?php echo date('d-m-Y'); ?>">
                                        <input type="hidden" name="booking_type" id="booking_type" value="2">
                                        <div class="row add_bottom_15" id="content_2">
                                            <div id="" class="caldates owl-carousel owl-theme">
                                            <?php 
                                            for ($bou=0; $bou < $row_website_details['booking_open_upto']; $bou++) {
                                                    $current_date   = date('d-m-Y');
                                                    $booking_date   = date('d-m-Y', strtotime($current_date . ' +'.$bou.' day'));
                                                    $current_day    = '';
                                                    if (date('d-m-Y') == $booking_date) {
                                                        $current_day = 'Today';
                                                    }
                                                    if (date('d-m-Y', strtotime($current_date . ' +1 day')) == $booking_date) {
                                                        $current_day = 'Tomorrow';
                                                    }
                                                ?>
                                                <div class="item">
                                                    <div id="calendar_dates" data-timeslot="video_" data-bookingpage="<?php echo $user_id;?>" data-booking_type="2" data-booking_date="<?php echo $booking_date;?>" data-booking_day="<?php echo date('l', strtotime($booking_date));?>" class="link clicked" <?php if($bou==0) { ?>style="color:#fff;background:#0176c4" <?php } ?>> <small><?php echo $current_day; ?></small>
                                                        <br>
                                                        <input type="hidden" value="<?php echo $booking_date;?>"> <strong><?php echo date('d M', strtotime($booking_date));?></strong>
                                                        <br> <small><?php echo date('l', strtotime($booking_date));?></small>
                                                    </div>
                                                </div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <div class="row add_bottom_15" id="content_3">
                                            <ul class="video_time_slots time_select">
                                                <?php
                                                $current_date               = date('d-m-Y');
                                                $result_day                 = strtolower(date('l', strtotime($current_date)));
                                                $sql_holiday       = "SELECT * FROM holidays as h WHERE h.from_date >= '".date('Y-m-d', strtotime($current_date))."' AND h.to_date <= '".date('Y-m-d', strtotime($current_date))."' AND h.doctor_id = ".$user_id ." ";
                                                $check_holiday     = $db_connection->getDbHandler()->query($sql_holiday);
                                                $row_holiday  	   = $check_holiday->fetchAll();
                                                if(count($row_holiday) > 0){
                                                    echo '<li style="display: contents;">
                                                        <div class="row text-center">
                                                            <h6>Doctor Not Available</h6>
                                                        </div>
                                                    </li>';
                                                } else {
                                                $sql_doctor_time_slot       = "SELECT id,is_available FROM doctor_time_slots as a WHERE a.doctor_id = ".$user_id . " AND a.day = '$result_day' AND a.type = 2";
                                                $check_doctor_time_slot     = $db_connection->getDbHandler()->query($sql_doctor_time_slot);
                                                $existing_doctor_time_slot  = $check_doctor_time_slot->fetch();
                                                if($existing_doctor_time_slot != '' && isset($existing_doctor_time_slot['is_available']) && $existing_doctor_time_slot['is_available'] == 1) {
                                                    $doctor_time_slot_id            = $existing_doctor_time_slot['id'];
                                                    $sql_time_slot_video            = "SELECT * FROM  doctor_day_time_slots WHERE doctor_time_slot_id = $doctor_time_slot_id";
                                                    $res_time_slot_video            = $db_connection->getDbHandler()->query($sql_time_slot_video);
                                                    $list_of_available_time_slots   = $res_time_slot_video->fetchAll();

                                                    $sql_booking_slot   = "SELECT id,booking_time FROM booking_details WHERE doctor_id = $user_id AND booking_date = '".date('Y-m-d')."' AND booking_status !=2";
                                                    $res_booking_slot   = $db_connection->getDbHandler()->query($sql_booking_slot);
                                                    $today_booking_slots = $res_booking_slot->fetchAll();
                                                    $selected_booking_slots = array_map(function ($value) { return $value['booking_time']; }, $today_booking_slots);
                                                    
                                                    if ($list_of_available_time_slots) {
                                                        $booked_count = 0;
                                                        foreach ($list_of_available_time_slots as $loopKey=>$list_time_slot) {
                                                            if(!in_array($list_time_slot['slot_time'], $selected_booking_slots) && strtotime($list_time_slot['slot_time']) > strtotime(date('g:i A'))) {
                                                                $booked_count = $booked_count + 1;
                                                ?>
                                                <li>
                                                    <input type="radio" id="radio<?php echo $list_time_slot['id']; ?>" class="chosen_slot_time_video" name="chosen_slot_time" value="<?php echo $list_time_slot['slot_time']; ?>">
                                                    <label id="lblradio<?php echo $list_time_slot['id']; ?>" for="radio<?php echo $list_time_slot['id']; ?>"><?php echo $list_time_slot['slot_time']; ?></label>
                                                </li>
                                                
                                                <?php 
                                                            }
                                                        } 
                                                        if ($booked_count == 0) {
                                                            echo '<li style="display: contents;">
                                                                <div class="row text-center">
                                                                    <h6>No Slots Available</h6>
                                                                </div>
                                                            </li>';
                                                        }
                                                ?>
                                            
                                            <?php } else { ?>
                                                    <li style="display: contents;">
                                                        <div class="row text-center">
                                                            <h6>No Slots Available</h6>
                                                        </div>
                                                    </li>
                                                <?php } } else { ?>
                                                    <li style="display: contents;">
                                                        <div class="row text-center">
                                                            <h6>No Slots Available</h6>
                                                        </div>
                                                    </li>
                                                <?php } }?>
                                                
                                            </ul>
                                        </div>
                                        <hr>
                                        <p class="text-center">
                                            <button type="submit" id="btnbooknowvideo" style="display:none;" class="btn_1 medium">Book Now</button>
                                        </p>
                                    </form>
                                    <?php } else { ?>
                                        <p class="text-center">
                                            Booking slot not Available.
                                        </p>
                                    <?php } ?>
                                </div>
                                <div class="tab-pane fade" id="pills-clinic" role="tabpanel" aria-labelledby="pills-clinic-tab">
                                    <?php if ($row_website_details['clinic_booking_slot_status']) { ?>
                                    <form id="checkout-selection" action="booking_appointment.php" method="POST">	
                                        <input type="hidden" name="bookingpage" id="bookingpage" value="<?php echo $user_id;?>">
                                        <input type="hidden" name="chosendate" id="chosendate_3" value="<?php echo date('d-m-Y'); ?>">
                                        <input type="hidden" name="booking_type" id="booking_type" value="3">
                                        <div class="row add_bottom_15" id="content_2">
                                            <div id="" class="caldates owl-carousel owl-theme">
                                            <?php 
                                            for ($bou=0; $bou < $row_website_details['clinic_booking_open_upto']; $bou++) {
                                                    $current_date   = date('d-m-Y');
                                                    $booking_date   = date('d-m-Y', strtotime($current_date . ' +'.$bou.' day'));
                                                    $current_day    = '';
                                                    if (date('d-m-Y') == $booking_date) {
                                                        $current_day = 'Today';
                                                    }
                                                    if (date('d-m-Y', strtotime($current_date . ' +1 day')) == $booking_date) {
                                                        $current_day = 'Tomorrow';
                                                    }
                                                ?>
                                                <div class="item">
                                                    <div id="calendar_dates" data-timeslot="clinic_" data-bookingpage="<?php echo $user_id;?>" data-booking_type="3" data-booking_date="<?php echo $booking_date;?>" data-booking_day="<?php echo date('l', strtotime($booking_date));?>" class="link clicked" <?php if($bou==0) { ?>style="color:#fff;background:#0176c4" <?php } ?>> <small><?php echo $current_day; ?></small>
                                                        <br>
                                                        <input type="hidden" value="<?php echo $booking_date;?>"> <strong><?php echo date('d M', strtotime($booking_date));?></strong>
                                                        <br> <small><?php echo date('l', strtotime($booking_date));?></small>
                                                    </div>
                                                </div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <div class="row add_bottom_15" id="content_3">
                                            <ul class="clinic_time_slots time_select">
                                                <?php
                                                $current_date               = date('d-m-Y');
                                                $result_day                 = strtolower(date('l', strtotime($current_date)));
                                                $sql_holiday       = "SELECT * FROM holidays as h WHERE h.from_date >= '".date('Y-m-d', strtotime($current_date))."' AND h.to_date <= '".date('Y-m-d', strtotime($current_date))."' AND h.doctor_id = ".$user_id ." ";
                                                $check_holiday     = $db_connection->getDbHandler()->query($sql_holiday);
                                                $row_holiday  	   = $check_holiday->fetchAll();
                                                if(count($row_holiday) > 0){
                                                    echo '<li style="display: contents;">
                                                        <div class="row text-center">
                                                            <h6>Doctor Not Available</h6>
                                                        </div>
                                                    </li>';
                                                } else {
                                                $sql_doctor_time_slot       = "SELECT id,is_available FROM doctor_time_slots as a WHERE a.doctor_id = ".$user_id . " AND a.day = '$result_day' AND a.type = 3";
                                                $check_doctor_time_slot     = $db_connection->getDbHandler()->query($sql_doctor_time_slot);
                                                $existing_doctor_time_slot  = $check_doctor_time_slot->fetch();
                                                if($existing_doctor_time_slot != '' && isset($existing_doctor_time_slot['is_available']) && $existing_doctor_time_slot['is_available'] == 1) {
                                                    $doctor_time_slot_id            = $existing_doctor_time_slot['id'];
                                                    $sql_time_slot_clinic            = "SELECT * FROM  doctor_day_time_slots WHERE doctor_time_slot_id = $doctor_time_slot_id";
                                                    $res_time_slot_clinic            = $db_connection->getDbHandler()->query($sql_time_slot_clinic);
                                                    $list_of_available_time_slots   = $res_time_slot_clinic->fetchAll();

                                                    $sql_booking_slot   = "SELECT id,booking_time FROM booking_details WHERE doctor_id = $user_id AND booking_date = '".date('Y-m-d')."' AND booking_status !=2";
                                                    $res_booking_slot   = $db_connection->getDbHandler()->query($sql_booking_slot);
                                                    $today_booking_slots = $res_booking_slot->fetchAll();
                                                    $selected_booking_slots = array_map(function ($value) { return $value['booking_time']; }, $today_booking_slots);
                                                    
                                                    if ($list_of_available_time_slots) {
                                                        $booked_count = 0;
                                                        foreach ($list_of_available_time_slots as $loopKey=>$list_time_slot) {
                                                            if(!in_array($list_time_slot['slot_time'], $selected_booking_slots) && strtotime($list_time_slot['slot_time']) > strtotime(date('g:i A'))) {
                                                                $booked_count = $booked_count + 1;
                                                ?>
                                                <li>
                                                    <input type="radio" id="radio<?php echo $list_time_slot['id']; ?>" class="chosen_slot_time_clinic" name="chosen_slot_time" value="<?php echo $list_time_slot['slot_time']; ?>">
                                                    <label id="lblradio<?php echo $loopKey; ?>" for="radio<?php echo $list_time_slot['id']; ?>"><?php echo $list_time_slot['slot_time']; ?></label>
                                                </li>
                                                
                                                <?php 
                                                            }
                                                        }
                                                        if ($booked_count == 0) {
                                                            echo '<li style="display: contents;">
                                                                <div class="row text-center">
                                                                    <h6>No Slots Available</h6>
                                                                </div>
                                                            </li>';
                                                        }
                                                ?>
                                            
                                            <?php } else { ?>
                                                    <li style="display: contents;">
                                                        <div class="row text-center">
                                                            <h6>No Slots Available</h6>
                                                        </div>
                                                    </li>
                                                <?php } } else { ?>
                                                    <li style="display: contents;">
                                                        <div class="row text-center">
                                                            <h6>No Slots Available</h6>
                                                        </div>
                                                    </li>
                                                <?php } }?>
                                                
                                            </ul>
                                        </div>
                                        <hr>
                                        <p class="text-center">
                                            <button type="submit" id="btnbooknowclinic" style="display:none;" class="btn_1 medium">Book Now</button>
                                        </p>
                                    </form>
                                    <?php } else { ?>
                                        <p class="text-center">
                                            Booking slot not Available.
                                        </p>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-white shadow br-sp p-3 mt-2">                    
                    <h5 class="bookhead pb-3">Doctor Services</h5>
                    <div id="owl-drservices" class="owl-carousel owl-theme">
                        
                    
                    <?php foreach($row_service_details as $service)
                            { 
                                if($service['coverpic'] !="")
                                $imgurl = "datafiles/uploads/services/".$service['coverpic'];
                                else 
                                $imgurl = "images/blog-long.png";
                                
                                ?>
                    
                        <div class="item d-flex flex-wrap align-self-stretch">
                            <div class="drservicebox">
                                <img src='<?php echo file_exists($imgurl)?$imgurl:"images/blog-long.png"; ?>' class="img-fluid" alt="">
                                <div class="drservicecont p-3">
                                <h6 class="drservicehead"><?php echo $service['name']; ?></h6>
                                <p class="dr-servicecpara"><?php echo $service['description']; ?></p>
                                <?php echo $service['benefits']; ?>
                                <div class="kmre"><a href="indpg?domain=<?php echo $domain; ?>&service=<?php echo $service['id'];  ?>">Know More</a></div>
                                </div>
                            </div>
                        </div>

                        <?php } ?>

                    </div>                        
                </div>
                <div class="bg-white shadow br-sp p-3 mt-2">
                    <h5 class="bookhead pb-3">Blogs</h5> 
                    <div class="row mb-3">
                        <div class="col-md-4 mb-4">
                            <div class="blog-postgrid drservicebox">
                                <img src="images/common1.png" class="img-fluid" alt="" title="">
                                <h5 class="drservicehead p-2">Profession Based Coworking Space:Is It…</h5>
                                <div class="row align-items-center p-2">
                                    <div class="col-md-5">
                                    <h6 class="dr-servicecpara mb-0">Blog</h6>
                                    </div>
                                    <div class="col-md-7">
                                    <time class="dr-servicecpara">January 27, 2022</time>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-4">
                            <div class="blog-postgrid drservicebox">
                                <img src="images/common1.png" class="img-fluid" alt="" title="">
                                <h5 class="drservicehead p-2">Profession Based Coworking Space:Is It…</h5>
                                <div class="row align-items-center p-2">
                                    <div class="col-md-5">
                                    <h6 class="dr-servicecpara mb-0">Blog</h6>
                                    </div>
                                    <div class="col-md-7">
                                    <time class="dr-servicecpara">January 27, 2022</time>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-4">
                            <div class="blog-postgrid drservicebox">
                                <img src="images/common1.png" class="img-fluid" alt="" title="">
                                <h5 class="drservicehead p-2">Profession Based Coworking Space:Is It…</h5>
                                <div class="row align-items-center p-2">
                                    <div class="col-md-5">
                                    <h6 class="dr-servicecpara mb-0">Blog</h6>
                                    </div>
                                    <div class="col-md-7">
                                    <time class="dr-servicecpara">January 27, 2022</time>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-4">
                            <div class="blog-postgrid drservicebox">
                                <img src="images/common1.png" class="img-fluid" alt="" title="">
                                <h5 class="drservicehead p-2">Profession Based Coworking Space:Is It…</h5>
                                <div class="row align-items-center p-2">
                                    <div class="col-md-5">
                                    <h6 class="dr-servicecpara mb-0">Blog</h6>
                                    </div>
                                    <div class="col-md-7">
                                    <time class="dr-servicecpara">January 27, 2022</time>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-4">
                            <div class="blog-postgrid drservicebox">
                                <img src="images/common1.png" class="img-fluid" alt="" title="">
                                <h5 class="drservicehead p-2">Profession Based Coworking Space:Is It…</h5>
                                <div class="row align-items-center p-2">
                                    <div class="col-md-5">
                                    <h6 class="dr-servicecpara mb-0">Blog</h6>
                                    </div>
                                    <div class="col-md-7">
                                    <time class="dr-servicecpara">January 27, 2022</time>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-4">
                            <div class="blog-postgrid drservicebox">
                                <img src="images/common1.png" class="img-fluid" alt="" title="">
                                <h5 class="drservicehead p-2">Profession Based Coworking Space:Is It…</h5>
                                <div class="row align-items-center p-2">
                                    <div class="col-md-5">
                                    <h6 class="dr-servicecpara mb-0">Blog</h6>
                                    </div>
                                    <div class="col-md-7">
                                    <time class="dr-servicecpara">January 27, 2022</time>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 text-center mt-3">
                            <div class="newcallclibtn">
                                <a href="">View More</a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- <div class="bg-white shadow br-sp p-3 mt-2">                    
                    <h5 class="bookhead pb-3">Patient Stories (2)</h5> 
                    <div class="row mb-3">
                        <div class="col-md-9 col-9">
                            <div class="row align-items-center">
                                <div class="col-md-2 col-4">
                                    <div class="round-cirimg">
                                        <img src="images/t1.png" class="img-fluid">
                                    </div>
                                </div>
                                <div class="col-md-10 col-8">
                                    <h5 class="storyheadtitle mb-0">Sweety Rajput</h5>
                                    <h6 class="storyhead-subtitle mb-0">Feb 15, 2022, 12.00 AM</h6>
                                </div>
                                <div class="col-md-12">
                                    <h3 class="comments-story">Good Doctor</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-3 rating-stars text-end">
                        <i class="fa fa-star" aria-hidden="true"></i>
                        <i class="fa fa-star" aria-hidden="true"></i>
                        <i class="fa fa-star" aria-hidden="true"></i>
                        <i class="fa fa-star" aria-hidden="true"></i>
                        <i class="fa fa-star" aria-hidden="true"></i>
                        </div>
                    </div>
                    <div class="long-str-line mb-3"></div>    
                    <div class="row mb-3">
                        <div class="col-md-9 col-9">
                            <div class="row align-items-center">
                                <div class="col-md-2 col-4">
                                    <div class="round-cirimg">
                                        <img src="images/t1.png" class="img-fluid">
                                    </div>
                                </div>
                                <div class="col-md-10 col-8">
                                    <h5 class="storyheadtitle mb-0">Sweety Rajput</h5>
                                    <h6 class="storyhead-subtitle mb-0">Feb 15, 2022, 12.00 AM</h6>
                                </div>
                                <div class="col-md-12">
                                    <h3 class="comments-story">Good Doctor</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-3 rating-stars text-end">
                        <i class="fa fa-star" aria-hidden="true"></i>
                        <i class="fa fa-star" aria-hidden="true"></i>
                        <i class="fa fa-star" aria-hidden="true"></i>
                        <i class="fa fa-star" aria-hidden="true"></i>
                        <i class="fa fa-star" aria-hidden="true"></i>
                        </div>
                    </div>                                      
                </div>                 -->
            </div>
            <div class="col-lg-4 mt-3 mt-lg-0">
                    <?php 
                        if(count($row_profrea_clinic) != 0)
                        {
                        
                ?>
            
                <div class="bg-white shadow br-sp p-3">
                   <!-- <h6 class="bookhead pt-3">Profrea Clinic Info</h6> -->

                    <?php foreach($row_profrea_clinic as $profrea_clinic)
                            { ?>

                    <h6 class="bookhead-2"><?php echo $profrea_clinic['ws_name']; ?></h6>
                    <p class="bookparanew"><?php echo $profrea_clinic['address']; ?></p>
                    <p class="bookparanew">
                        <?php 
                                if($profrea_clinic['mon_slots']!==""){
                                    echo "<b>Monday</b> - ".print_slot($profrea_clinic['mon_slots'])."<br/>";
                                }
                                if($profrea_clinic['tue_slots']!==""){
                                    echo "<b>Tuesday</b> - ".print_slot($profrea_clinic['tue_slots'])."<br/>";
                                }
                                if($profrea_clinic['wed_slots']!==""){
                                    echo "<b>Wednesday</b> - ".print_slot($profrea_clinic['wed_slots'])."<br/>";
                                }
                                if($profrea_clinic['thu_slots']!==""){
                                    echo "<b>Thrusday</b> - ".print_slot($profrea_clinic['thu_slots'])."<br/>";
                                }
                                if($profrea_clinic['fri_slots']!==""){
                                    echo "<b>Friday</b> - ".print_slot($profrea_clinic['fri_slots'])."<br/>";
                                }
                                if($profrea_clinic['sat_slots']!==""){
                                    echo "<b>Saturday</b> - ".print_slot($profrea_clinic['sat_slots'])."<br/>";
                                }
                                if($profrea_clinic['sun_slots']!==""){
                                    echo "<b>Sunday</b> - ".print_slot($profrea_clinic['sun_slots'])."<br/>";
                                }
                        ?>
                    </p>
                    <div class="row pb-4 pt-4">
                        <div class="col-md-6 col-sm-6 col-12">
                            <div class="newcallclibtn text-center">
                                <a href="">Call Clinic</a>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-12 mt-4 mt-sm-0">
                            <div class="newdirectionbtn text-center">
                                <a href="">Get Direction</a>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
                <?php } ?>


                <?php if(count($row_clinic_details) > 0){ ?>
                <div class="bg-white shadow br-sp mt-3  p-3">
                    <h6 class="bookhead pt-3">Other Clinics</h6>
                    <?php
                    foreach($row_clinic_details as $clinic){
                    ?>
                    <h6 class="bookhead-2"><?php echo $clinic["name"]; ?></h6>
                    <p class="bookparanew"><?php echo $clinic["address"]; ?></p>
                    <p class="bookparanew"><?php echo $clinic["time_slot"]; ?></p>
                    
                    <div class="row pb-4 pt-4">
                        <div class="col-md-6 col-sm-6 col-12">
                            <div class="newcallclibtn text-center">
                                <a href="tel:<?php  echo $clinic["contact_number"];  ?>">Call Clinic</a>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-12 mt-4 mt-sm-0">
                            <div class="newdirectionbtn text-center">
                                <a target="_blank" href="<?php  echo $clinic["google_map_link"];  ?>">Get Direction</a>
                            </div>
                        </div>
                    </div>
                  <?php } ?>  
                </div>
                <?php } ?>
                <div class="bg-white shadow br-sp p-3 mt-2">
                    <h6 class="bookhead pt-3">Education</h6>
                    <!--<ul class="ps-3 edu-list">
                        <li>MBBS</li>
                        <li>DGO</li>
                        <li>DNB</li>
                        <li>FICOG</li>
                        <li>FMAS</li>
                    </ul> -->
                    <?php echo $row_user["education"]; ?>
                    <div class="long-str-line"></div>
                    <h6 class="bookhead pt-3">Experience</h6>
                    <ul class="ps-3 edu-list">
                        <li><?php echo $row_user["experience"]; ?> Years</li>
                    </ul>
                    <div class="long-str-line"></div>
                    <h6 class="bookhead pt-3">About <?php echo "Dr. ".ucwords($row_user["name"]); ?></h6>
                    <!--<ul class="ps-3 edu-list">
                        <li>MNAMS - Dec 2015</li>
                        <li>APJ Abdul Kalam Appreciation Award-2018</li>
                        <li>World Association of Laparoscopic Surgeons (WALS) </li>
                        <li>Delhi Gynae Forum South (DGFS)</li>
                        <li>Indian Medical Association (IMA) </li>
                    </ul> -->
                    <p><?php echo $row_website_details['story']; ?></p>
                    <div class="long-str-line"></div>
                    <h6 class="bookhead pt-3">Other Services</h6>
                    <!--<ul class="ps-3 edu-list">
                        <li>MNAMS - Dec 2015</li>
                        <li>APJ Abdul Kalam Appreciation Award-2018</li>
                        <li>World Association of Laparoscopic Surgeons (WALS) </li>
                        <li>Delhi Gynae Forum South (DGFS)</li>
                        <li>Indian Medical Association (IMA) </li>
                    </ul> -->
                    <p><?php echo $row_website_details['rowservice']; ?></p>
                </div>
                <div class="bg-white shadow br-sp p-3 mt-2">
                    <h6 class="bookhead pt-3">Gallery</h6>
                    <div class="row pt-2">
                        <?php foreach($row_profrea_clinic as $profrea_clinic)
                        {                  
                            $images = $profrea_clinic["images"]!=""?explode(",",$profrea_clinic["images"]):null;                                
                            if($images !== null)
                            {
                                $i=0;
                                foreach($images as $image)
                                {
                                    $i++;
                                    if($image!="" && file_exists("datafiles/spaces/".$profrea_clinic['space_id']."/space_images/".$image)){ ?>
                                            <div class="col-md-3 col-4 mb-4 smallgal-part">
                                                <a data-lightbox="img" href="datafiles/spaces/<?php echo $profrea_clinic['space_id'] ?>/space_images/<?php echo $image; ?>" alt="">
                                                    <img class="img-fluid" src="datafiles/spaces/<?php echo $profrea_clinic['space_id'] ?>/space_images/<?php echo $image; ?>" alt="">
                                                </a>
                                            </div>
                                    <?php }
                                }
                            }
                        } 
                        
                        foreach($row_gallery_details as $image)
                        {
                            $i++;
                            if($image['imgpath']!="" && file_exists("datafiles/uploads/clinicImg/".$image['imgpath'])){ ?>
                                    <div class="col-md-3 col-4 mb-4 smallgal-part">
                                        <a data-lightbox="img" href="datafiles/uploads/clinicImg/<?php echo $image['imgpath']; ?>" alt="">
                                            <img class="img-fluid" src="datafiles/uploads/clinicImg/<?php echo $image['imgpath']; ?>" alt="">
                                        </a>
                                    </div>
                            <?php }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- 2nd section ended -->


<?php 

include_once('footer-client.php');
?>    
    
<script src="js/book-slot.js"></script>
<script type="text/javascript">
	$(".caldates").owlCarousel({
		items: 3,
		loop: !1,
		mouseDrag: !1,
		nav: !0,
		dots: !1,
		navText: ["<i class='fa fa-chevron-left'></i>", "<i class='fa fa-chevron-right'></i>"],
		responsive: { 0: { items: 3 }, 600: { items: 2 }, 1000: { items: 3 } },
	});
	$(document).ready(function() {
        
		$('body').on('click', '.link', function(e) {
            $("#btnbooknowvideo,#btnbooknowaudio,#btnbooknowclinic").hide();
			var $this = $(this);
			var bookingpage = $("#bookingpage").val();
			
			$this.parent().parent().parent().find('.clicked').removeAttr('style').removeClass('clicked');
			if($this.hasClass('clicked')) {
				$this.removeAttr('style').removeClass('clicked');
			} else {
				$this.css('color', '#fff');
				$this.css('background', '#0176c4').addClass('clicked');
			}
			var booking_type    = $this.attr('data-booking_type');
			var booking_date    = $this.attr('data-booking_date');
			var booking_day     = $this.attr('data-booking_day');
			var booking_slot    = $this.attr('data-timeslot');
            $("."+booking_slot+"time_slots").html('');
            $("#chosendate_"+booking_type).val($this.find(':hidden').val());
            console.log($this.find(':hidden').val());
            $.ajax({
				type: 'POST',
                url: './includes/functions.php?action=get_booking_slots',
				data: {
					bookingpage: bookingpage,
					type: booking_type,
					booking_date: booking_date,
					booking_day: booking_day,
					chosendate: $("#chosendate_"+booking_type).val()
				},
				success: function(responsedata) {
					$("."+booking_slot+"time_slots").html(responsedata);
				}
			});
		});

        $('.audio_time_slots').on("click", '.chosen_slot_time_audio', function (e) {
            var chosen_slot_time = $('input[type=radio][name=chosen_slot_time]:checked').val();
            if (chosen_slot_time !='') {
                $("#btnbooknowaudio").show();
            } else {
                $("#btnbooknowaudio").hide();
            }
        });
        $('.video_time_slots').on("click", '.chosen_slot_time_video', function (e) {
            var chosen_slot_time = $('input[type=radio][name=chosen_slot_time]:checked').val();
            if (chosen_slot_time !='') {
                $("#btnbooknowvideo").show();
            } else {
                $("#btnbooknowvideo").hide();
            }
        });
        $('#pills-clinic').on("click", '.chosen_slot_time_clinic', function (e) {
            var chosen_slot_time = $('input[type=radio][name=chosen_slot_time]:checked').val();
            if (chosen_slot_time !='') {
                $("#btnbooknowclinic").show();
            } else {
                $("#btnbooknowclinic").hide();
            }
        });

        $('.nav-link').on("click", function () {
            $("#btnbooknowvideo,#btnbooknowaudio,#btnbooknowclinic").hide();
            $('.chosen_slot_time_audio,.chosen_slot_time_video,.chosen_slot_time_clinic').prop('checked', false);
            $('.audio-amount,.video-amount,.clinic-amount').hide();
            var $this = $(this);
            if($this.attr('id') == "pills-audio-tab"){
                $('.audio-amount').show();
            } else if($this.attr('id') == "pills-video-tab"){
                $('.video-amount').show();
            } else {
                $('.clinic-amount').show();
            }
        });
	});
    
</script>