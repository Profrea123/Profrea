<?php
session_start();
$title = "Profrea";
$description = "";
$keywords = "";
$page = 1;
if (isset($_SESSION['ap_profrea_login_id'])) 
{
    $login_id = $_SESSION['ap_profrea_login_id'];
}
else{
    header("Location: spaces");
}
include_once('header.php');
require_once('vendor/autoload.php');
use App\Classes\Model\Database;
use App\Classes\RealEstate\Spaces;
$db_conn = new Database;
$real_estate = new Spaces();
    
    
$sql_user = "SELECT users.*, gender.name AS gender, city.name AS city FROM users 
    LEFT JOIN gender ON gender.id = users.gender_id 
    LEFT JOIN city ON city.id = users.city 
    LEFT JOIN operating_specialty AS os ON os.id = users.speciality
    WHERE users.id = $login_id";
$res_user = $db_conn->getDbHandler()->query($sql_user);

$mobileno = "";
$useremail ="";
$username ="";

if($res_user)
{
    $row_user = $res_user->fetch();        
    if($row_user["is_verified"] == 1){
       
        //print_r($row_user);
    }
    else{
        $profrea_verified = 'no';
       
    }

    $profrea_verified = 'yes';
    $mobileno = $row_user["mobileNo"];
    $useremail = $row_user["email"];
    $username = $row_user["name"];
}
$space_id = $_GET['id'];
$oneData = $real_estate->viewSingleData($space_id);
$fileList = glob("datafiles/spaces/".$oneData->id."/space_image_profile/*");
$fileList2 = glob("datafiles/spaces/".$oneData->id."/space_images/*");
$allData = $real_estate->viewFilterData($oneData->city,"",$oneData->space_type,"",0,"false",array($oneData->id));
$amenities = explode(",",$oneData->amenities);
$speciality_exclusive = explode(",",$oneData->speciality_exclusively);
$speciality_operating = explode(",",$oneData->speciality_operating);
//$speciality_exclusive = explode(",",$oneData->speciality_exclusively);
$utility = explode(",",$oneData->utility);
$paidUtility = explode(",",$oneData->paid_utilities);
$sql_slots = "SELECT * FROM space_available_slots WHERE space_info_id=$space_id AND is_available=0";
$res_slots = $db_conn->getDbHandler()->query($sql_slots);
if($res_slots)
{
  $slots = $res_slots->fetchAll();
}
$sql_space_plan = "SELECT * FROM p2_space_plan 
    LEFT JOIN p2_plans ON p2_plans.id = p2_space_plan.plan_id 
    WHERE p2_space_plan.space_id = $space_id AND p2_space_plan.status = 1";
$res_space_plan = $db_conn->getDbHandler()->query($sql_space_plan);
if($res_space_plan)
{
  $space_plans = $res_space_plan->fetchAll();
}
?>
<section class="bg-spaces-ind">
    <div class="container">
        <div class="row pt-5">
            <div class="col-lg-8 col-12">
                <div class="breadcrumb">
                    <p class="breadcrumb-title "><?php echo $oneData->ws_name  ?></p>
                </div>
                <div>
                    <div id="carouselExampleControls" class="carousel slide " data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <?php foreach ($fileList as $key => $value) { ?>
                            <div class="carousel-item ind-spimg active">
                                <img src="<?php echo $value; ?>" class="d-block w-100" alt="...">
                            </div>
                            <?php } ?>
                            <?php foreach ($fileList2 as $key => $value) { ?>
                            <div class="carousel-item ind-spimg">
                                <img src="<?php echo $value; ?>" class="d-block w-100" alt="...">
                            </div>
                            <?php } ?>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>
                <h1 class="space-desc f1 pt-5 fw-bold">Space Description</h1>
                
                <p class="space-para ft-16 pt-3 text-grey mb-0"><?php echo $oneData->ws_desc; ?></p>
            </div>
            <div class="col-lg-4 col-12">
                <div class="ind-booking-box">
                    <h4><?php echo $oneData->locality; ?></h4>
                    <div class="ft-14"><i class="fa fa-map-marker pe-2 text-blue ft-14"></i> <?php echo $oneData->landmark; ?></div>
                    <div class="pricing-choosebox mb-3 mt-4 text-center pt-3 pb-3">
                        <h6 class="head-pricetag ft-16 mb-0">Pricing starts from</h6>
                        <h1 class="f1 rate-price mb-0">Rs <?php echo $oneData->hourly_charges; ?></h1>
                    </div>
                    <div class="schedule-vistbtn mt-3 mb-3">
                        <a href="#" data-bs-toggle="modal" data-bs-target="#scheduleModal">Schedule Visit </a>
                    </div>
                    <div class="booknow-spacebtn mb-3">
                        <a href="spaces-ind?id=<?php echo $oneData->id; ?>#plans">Book Now</a>
                    </div>
                    <!-- <?php if (isset($_SESSION['ap_profrea_login_id'])) { ?>
                        <?php if ($profrea_verified === 'yes') { ?>
                            <div class="booknow-spacebtn mb-3">
                                <a href="#" data-bs-toggle="modal" data-bs-target="#booknowModal">Book Now</a>
                            </div>
                        <?php } else { ?>
                            <div class="booknow-spacebtn mb-3">
                                <a href="#">Book Now</a>
                            </div>
                        <?php } ?>
                    <?php } else { ?>
                    <div class="booknow-spacebtn mb-3">
                        <a href="login">Book Now</a>
                    </div>
                    <?php } ?> -->
                </div>
            </div>
        </div>
        <div class="row pt-5">
            <div class="col-lg-12 col-12">
                <h1 class="space-desc f1 pt-5 fw-bold">Amenities</h1>
                <div class="row pt-3 align-items-center">
                    <?php foreach($amenities as $amenitie){ ?>
                    <div class="col-md-3 mt-2 col-6 mb-3 mb-md-0  d-flex align-self-stretch">
                        <div class="amenities-box text-center w-100">
                            <img src="images/yes.png" class="img-fluid am-icon" alt="" title="">
                            <h3 class="amen-title pt-2 ft-16"><?php echo $amenitie; ?></h3>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
        <div class="row pt-5">
            <div class="col-lg-12 col-12">
                <h1 class="space-desc f1 pt-5 fw-bold">Speciality</h1>
                <div class="row pt-3 align-items-center">
                    
                     <?php
                    foreach($speciality_operating as $speciality)
                    {
                        if($speciality !== "")
                        {
                            ?>
                            <div class="col-md-3 col-6 mt-2 mb-3 mb-md-0 d-flex align-self-stretch">
                                <div class="amenities-box w-100 text-center">
                                    <h3 class="amen-title ft-16 mb-0"><?php echo $speciality; ?></h3>
                                </div>
                            </div>
                            <?php 
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
        <div class="row pt-5" id="plans">
            <div class="col-lg-12 col-12">
                <h1 class="space-desc f1 pt-5 fw-bold">Plans</h1>
                <div class="row pt-3">

                <div class="ind-booking-box col-md-3">
                            <div style="height:40px;">
                            <h4>Features</h4>
                            </div>
                            <div class="pricing-choosebox mb-3 mt-4 text-center">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <td>Plan Days</td>
                                        </tr>
                                        <tr>
                                            <td>Plan Amount</td>
                                        </tr>
                                        <tr>
                                            <td>Hours/Day</td>
                                        </tr>
                                       
                                        <tr>
                                            <td>Hours/Month</td>
                                        </tr>

                                        <tr>
                                                <td>100 percent OPD</td>
                                                
                                            </tr>


                                            <tr>
                                                <td>Practo Prime</td>
                                                
                                            </tr>
                                            <tr>
                                                <td>Receptionist cum Helper</td>
                                                
                                            </tr>


                                        <tr>
                                                <td>Branding</td>
                                               
                                            </tr>

                                            <tr>
                                                <td>Live Receptionist</td>
                                                
                                            </tr>    
                                            <tr>
                                                <td>OPD Management Software</td>
                                                
                                            </tr>



                                            <tr>
                                                <td>On Call Feature</td>
                                                
                                            </tr>
                                            


                                            <tr>
                                                <td>Profrea Doctor Kit</td>
                                                
                                            </tr>

                                            
                                        
                                            <tr>
                                                <td>Online Listing</td>
                                                
                                            </tr>

                                            
                                            <tr>
                                                <td>1.5 Feature</td>
                                                
                                            </tr>

                                            
                                            <tr>
                                                <td>Lab Referrals</td>
                                                
                                            </tr>

                                            <tr>
                                                <td>Medicine Referrals</td>
                                                
                                            </tr>


                                            <tr>
                                                <td>SMM / Video Marketing</td>
                                                
                                            </tr>

                                            <tr>
                                                <td>Price Per Hour</td>
                                                
                                            </tr>
                                            <tr>
                                                <td>Pay 10% to hold your slot</td>
                                                
                                            </tr>

                                         
                                        
                                       
                                    </tbody>
                                </table>
                            </div>
                            
                        </div>






                    <?php
                    foreach ($space_plans as $key => $plan) 
                    {
                        ?>
                        <div class="ind-booking-box col-md-2" style="width:12%">
                            <div style="height:40px;">
                            <h4><?php echo $plan['title']; ?></h4>
                            </div>
                            <div class="pricing-choosebox mb-3 mt-4 text-center">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <td><?php echo $plan['plan_days'];  ?></td>
                                        </tr>
                                        <tr>
                                            <td><?php echo "Rs ".number_format($plan['plan_amount'], 0, '.', ','); ?></td>
                                        </tr>
                                        <tr>
                                            <td><?php echo $plan['hours_per_day'];  ?></td>
                                        </tr>
                                       
                                        <tr>
                                            <td><?php echo $plan['hours_per_month']; ?></td>
                                        </tr>
                                        <tr>
                                                
                                                <td><?php echo $plan['opd_percent']?"<img src='images/yes.png'/>":"<img src='images/no.png'/>";  ?></td>
                                            </tr>
                                            <tr>
                                                
                                                <td><?php echo $plan['practo_prime']?"<img src='images/yes.png'/>":"<img src='images/no.png'/>";  ?></td>
                                            </tr>

                                            <tr>
                                                
                                                <td><?php echo $plan['receptionist_cum_helper']?"<img src='images/yes.png'/>":"<img src='images/no.png'/>";  ?></td>
                                            </tr>


                                        <tr>
                                                
                                                <td><?php echo $plan['branding']?"<img src='images/yes.png'/>":"<img src='images/no.png'/>";  ?></td>
                                            </tr>

                                          

                                            <tr>
                                                
                                                <td><?php echo $plan['live_receptionist']?"<img src='images/yes.png'/>":"<img src='images/no.png'/>";  ?></td>
                                            </tr>

                                            <tr>
                                                
                                                <td><?php echo $plan['opd_management_software']?"<img src='images/yes.png'/>":"<img src='images/no.png'/>";  ?></td>
                                            </tr>

                                        
                                          
                                            <tr>
                                                
                                                <td><?php echo $plan['on_call_feature']?"<img src='images/yes.png'/>":"<img src='images/no.png'/>";  ?></td>
                                            </tr>
                                                
                                            <tr>
                                                
                                                <td><?php echo $plan['profrea_doctor_kit']?"<img src='images/yes.png'/>":"<img src='images/no.png'/>";  ?></td>
                                            </tr>

                                            <tr>
                                                
                                                <td><?php echo $plan['gmb']?"<img src='images/yes.png'/>":"<img src='images/no.png'/>";  ?></td>
                                            </tr>


                                            <tr>
                                                
                                                <td><?php echo $plan['feature15']?"<img src='images/yes.png'/>":"<img src='images/no.png'/>";  ?></td>
                                            </tr>

                                            <tr>
                                                
                                                <td><?php echo $plan['lab_referrals']?"<img src='images/yes.png'/>":"<img src='images/no.png'/>";  ?></td>
                                            </tr>

                                         
                                            <tr>
                                                
                                                <td><?php echo $plan['medicine_referrals']?"<img src='images/yes.png'/>":"<img src='images/no.png'/>";  ?></td>
                                            </tr>

                                            <tr>
                                                
                                                <td><?php echo $plan['social_media_management']?"<img src='images/yes.png'/>":"<img src='images/no.png'/>";  ?></td>
                                            </tr>

                                           
                                            <tr>
                                                
                                                <td><?php echo "Rs ".number_format($plan['cost_per_hour'], 0, '.', ','); ?></td>
                                            </tr>
                                            <tr>
                                                
                                                <td><?php echo "Rs ".number_format($plan['initial_payment'], 0, '.', ','); ?></td>
                                            </tr>

                                           
                                    </tbody>
                                </table>
                            </div>
                            <?php if (isset($_SESSION['ap_profrea_login_id'])) { ?>
                                <?php if ($profrea_verified === 'yes') { ?>
                                    <div class="booknow-spacebtn mb-3 text-center">
                                        <button class="booknow log-inbtn" data-plan_id="<?php echo $plan['plan_id']; ?>" data-space_id="<?php echo $space_id; ?>">Book at <br/> Rs <?php echo $plan['initial_payment']; ?></button>
                                        <!-- <a href="booking?plan=<?php echo $plan['plan_id']; ?>">Book Now</a> -->
                                    </div>
                                <?php } else { ?>
                                    <div class="booknow-spacebtn mb-3">
                                        <!-- <a href="#">Book Now</a> -->
                                    </div>
                                <?php } ?>
                            <?php } else { ?>
                            <div class="booknow-spacebtn mb-3">
                                <a href="login">Book Now<br/>at just Rs <?php $plan['initial_amount'] ?></a>
                            </div>
                            <?php } ?>
                        </div>
                        <?php 
                    }
                    ?>
                </div>
            </div>
        </div>
        <div class="row pt-5">
            <!-- <div class="col-lg-4 col-12">
                <h1 class="space-desc f1 pb-3 fw-bold">Availability</h1>
                <table class="table border">
                    <thead>
                        <tr>
                            <th scope="col" class="text-grey fw-bold">Days</th>
                            <th scope="col" class="text-grey fw-bold">Available windows</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th class="text-grey ft-16" style="font-weight: 400;">Monday</th>
                            <td>
                                <?php 
                                $duration = '';
                                foreach ($slots as $key => $slot) {
                                    $time_slot = explode('-', $slot['time_slot']);
                                    $day = $time_slot[0];
                                    if ($day=='mon') {
                                        $duration = $duration.$time_slot[1].'-'.$time_slot[2].', ';
                                    }
                                }
                                if ($duration == '') {
                                    echo 'No Slots';
                                }
                                else{
                                    echo rtrim($duration,', ');
                                }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <th class="text-grey ft-16" style="font-weight: 400;">Tuesday</th>
                            <td>
                                <?php 
                                $duration = '';
                                foreach ($slots as $key => $slot) {
                                    $time_slot = explode('-', $slot['time_slot']);
                                    $day = $time_slot[0];
                                    if ($day=='tue') {
                                        $duration = $duration.$time_slot[1].'-'.$time_slot[2].', ';
                                    }
                                }
                                if ($duration == '') {
                                    echo 'No Slots';
                                }
                                else{
                                    echo rtrim($duration,', ');
                                }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <th class="text-grey ft-16" style="font-weight: 400;">Wednesday</th>
                            <td>
                                <?php 
                                $duration = '';
                                foreach ($slots as $key => $slot) {
                                    $time_slot = explode('-', $slot['time_slot']);
                                    $day = $time_slot[0];
                                    if ($day=='wed') {
                                        $duration = $duration.$time_slot[1].'-'.$time_slot[2].', ';
                                    }
                                }
                                if ($duration == '') {
                                    echo 'No Slots';
                                }
                                else{
                                    echo rtrim($duration,', ');
                                }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <th class="text-grey ft-16" style="font-weight: 400;">Thursday</th>
                            <td>
                                <?php 
                                $duration = '';
                                foreach ($slots as $key => $slot) {
                                    $time_slot = explode('-', $slot['time_slot']);
                                    $day = $time_slot[0];
                                    if ($day=='thu') {
                                        $duration = $duration.$time_slot[1].'-'.$time_slot[2].', ';
                                    }
                                }
                                if ($duration == '') {
                                    echo 'No Slots';
                                }
                                else{
                                    echo rtrim($duration,', ');
                                }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <th class="text-grey ft-16" style="font-weight: 400;">Friday</th>
                            <td>
                                <?php 
                                $duration = '';
                                foreach ($slots as $key => $slot) {
                                    $time_slot = explode('-', $slot['time_slot']);
                                    $day = $time_slot[0];
                                    if ($day=='fri') {
                                        $duration = $duration.$time_slot[1].'-'.$time_slot[2].', ';
                                    }
                                }
                                if ($duration == '') {
                                    echo 'No Slots';
                                }
                                else{
                                    echo rtrim($duration,', ');
                                }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <th class="text-grey ft-16" style="font-weight: 400;">Saturday</th>
                            <td>
                                <?php 
                                $duration = '';
                                foreach ($slots as $key => $slot) {
                                    $time_slot = explode('-', $slot['time_slot']);
                                    $day = $time_slot[0];
                                    if ($day=='sat') {
                                        $duration = $duration.$time_slot[1].'-'.$time_slot[2].', ';
                                    }
                                }
                                if ($duration == '') {
                                    echo 'No Slots';
                                }
                                else{
                                    echo rtrim($duration,', ');
                                }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <th class="text-grey ft-16" style="font-weight: 400;">Sunday</th>
                            <td>
                                <?php 
                                $duration = '';
                                foreach ($slots as $key => $slot) {
                                    $time_slot = explode('-', $slot['time_slot']);
                                    $day = $time_slot[0];
                                    if ($day=='sun') {
                                        $duration = $duration.$time_slot[1].'-'.$time_slot[2].', ';
                                    }
                                }
                                if ($duration == '') {
                                    echo 'No Slots';
                                }
                                else{
                                    echo rtrim($duration,', ');
                                }
                                ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div> -->
            <div class="col-lg-4 col-12">
                <h1 class="space-desc f1 pb-3 fw-bold mb-0">Utilities</h1>
                <ul class="list-unstyled">
                    <?php foreach ($utility as $uti){ ?>
                    <li class="mb-2 ft-14 text-grey"><i class="fa fa-angle-right ft-14 text-blue pe-2"></i><?php echo $uti; ?></li>
                    <?php } ?>
                </ul>
            </div>
            <div class="col-lg-4 col-12">
                <h1 class="space-desc f1 pb-3 fw-bold mb-0">Paid Utilities</h1>
                <ul class="list-unstyled">
                    <?php foreach($paidUtility as $value){ ?>
                    <li class="mb-2 ft-14 text-grey"><i class="fa fa-angle-right ft-14 text-blue pe-2"></i><?php echo $value; ?></li>
                    <?php } ?>
                </ul>
            </div>
        </div>
        <div class="row pt-5 pb-5">
            <div class="col-lg-12 col-12">      
                <h1 class="space-desc f1 pt-5 fw-bold pb-3">Location</h1>
                <iframe src="<?php echo $oneData->gmap_location; ?>" width="100%" height="350" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
            </div>
        </div>
    </div>
</section>
<section class="similar-spaces">
    <div class="container">
        <div class="row pt-5">
            <div class="col-md-12 text-center">
                <h1 class="similar-spaces f1 fw-bold">Similar <?php echo $oneData->space_type; ?></h1>
            </div>
            <div class="col-md-12 pt-5">
                <div id="owl-demo" class="owl-carousel owl-theme">
                    <?php
                    foreach ($allData as $oneData)
                    {
                        $image ="";
                        $fileList = glob("datafiles/spaces/".$oneData->id."/space_image_profile/*");
                        if(sizeof($fileList)>0)
                            $image = $fileList[0];
                        ?>
                        <div class="item ms-3">
                            <div class="space-gridbox">
                                <div class="text-center"><img src="<?php echo $image; ?>" class="img-fluid w-100" alt="" title="" /></div>
                                <div class="grid-spacecontbox">
                                    <h2 class="grid-spacetitle fw-bold text-blue f1 mb-0"><?php echo $oneData->ws_name; ?></h2>
                                    <div class="row align-items-center pt-2">
                                        <div class="col-md-6 col-6 p-0 p-lg-2">
                                            <p class="text-grey ft-14 mb-0">Pricing starts from</p>
                                            <h6 class="rate-title ft-18"><?php echo $oneData->hourly_charges; ?> per hour</h6>
                                            <div class="seedetail-btn text-center mt-5 mb-3">
                                                    <?php if (isset($_SESSION['ap_profrea_login_id'])) { ?>
                                                    <a href="spaces-ind?id=<?php echo $oneData->id; ?>">See Details</a>
                                                    <?php } else { ?>
                                                    <a href="login">See Details</a>
                                                    <?php } ?>
                                                </div>
                                        </div>
                                        <div class="col-md-6 col-6 p-0">
                                            <p class="text-grey ft-14 mb-0">Locality</p>
                                            <h6 class="rate-title ft-18"><?php echo $oneData->landmark; ?></h6>
                                            <div class="booknow-btn mt-5 mb-3 text-end">
                                                <?php if (isset($_SESSION['ap_profrea_login_id'])) { ?>
                                                    <a href="spaces-ind?id=<?php echo $oneData->id; ?>#plans">Book Now</a>
                                                    <?php } else { ?>
                                                    <a href="login">Book Now</a>
                                                    <?php } ?>
                                                </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                </div>
                <div class="text-center col-12 mt-5 mb-5">
                    <form method="post" action="spaces">
                        <input type='hidden' name='city_id' value='<?php echo $oneData->city; ?>'></input>
                        <input type='hidden' name='industry_id' value='<?php echo $oneData->space_type; ?>'></input>
                        <button type="submit" class="log-inbtn">More Clinics</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="about-wrap">
    <div class="container">
        <div class="row pt-5">
            <div class="col-md-12 text-center pt-5">
                <h1 class="about-wrap-head f1">We Can Help You To Find <br> Right <?php echo $oneData->space_type; ?></h1>
                <div class="text-center about-explorebtn pt-5 pb-5 mb-5">
                    <a href="contact">Request a callback</a>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Modal -->
<div class="modal fade" id="scheduleModal" tabindex="-1" aria-labelledby="scheduleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title f1 fw-bold ft-32 text-start" id="exampleModalLabel">Schedule Visit </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?php include_once("schedulevisit.php"); ?>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="booknowModal" tabindex="-1" aria-labelledby="booknowModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content p-3">
            <div class="modal-header">
                <h5 class="modal-title ft-32 f1 fw-bold" id="exampleModalLabel">Add your time Slots</h5>
                <button type="button" class="btn-close text-blue" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="pt-3" id="booknowForm" role="form" action="#" method="post" data-parsley-validate="">
                    <div class="row">
                        <div class="full-input p-2 col-xl col-lg me-2 mb-3">
                            <label for="date_from" class="form-label text-grey ft-14 mb-0">Booking Start From</label>
                            <input type="text" class="form-control" name="date_from" id="date_from" required="" />
                        </div>
                        <!-- <div class="full-input p-2 col-xl col-lg me-2 mb-3">
                            <label for="date_to" class="form-label text-grey ft-14 mb-0">Booking End Date</label>
                            <input type="text" style="border:none;" class="form-control" name="date_to" id="date_to" required="" />
                        </div> -->
                    </div>
                    <div id="plan_slots">
                        <div class="row">
                            <div class="full-input p-2 col-xl col-lg me-2 mb-3">
                                <label for="phone" class="form-label text-grey ft-14 mb-0">Monday</label>
                                <p>
                                    <?php 
                                    $duration = '';
                                    foreach ($slots as $key => $slot) {
                                        $time_slot = explode('-', $slot['time_slot']);
                                        $day = $time_slot[0];
                                        if ($day=='mon') {
                                            $duration .= '<div class="ck-button">
                                                <label>
                                                    <input id="'.$slot['id'].'" name="slots[mon]['.$time_slot[1].'-'.$time_slot[2].']" type="checkbox" value="'.$slot['id'].'"><span>'.$time_slot[1].' to '.$time_slot[2].'</span>
                                                </label>
                                            </div> ';
                                        }
                                    }
                                    if ($duration == '') {
                                        echo 'No Slots';
                                    }
                                    else{
                                        echo $duration;
                                    }
                                    ?>
                                </p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="full-input p-2 col-xl col-lg me-2 mb-3">
                                <label for="phone" class="form-label text-grey ft-14 mb-0">Tuesday</label>
                                <p>
                                    <?php 
                                    $duration = '';
                                    foreach ($slots as $key => $slot) {
                                        $time_slot = explode('-', $slot['time_slot']);
                                        $day = $time_slot[0];
                                        if ($day=='tue') {
                                            $duration .= '<div class="ck-button">
                                                <label>
                                                    <input id="'.$slot['id'].'" name="slots[tue]['.$time_slot[1].'-'.$time_slot[2].']" type="checkbox" value="'.$slot['id'].'"><span>'.$time_slot[1].' to '.$time_slot[2].'</span>
                                                </label>
                                            </div> ';
                                        }
                                    }
                                    if ($duration == '') {
                                        echo 'No Slots';
                                    }
                                    else{
                                        echo $duration;
                                    }
                                    ?>
                                </p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="full-input p-2 col-xl col-lg me-2 mb-3">
                                <label for="phone" class="form-label text-grey ft-14 mb-0">Wednesday</label>
                                <p>                                
                                    <?php 
                                    $duration = '';
                                    foreach ($slots as $key => $slot) {
                                        $time_slot = explode('-', $slot['time_slot']);
                                        $day = $time_slot[0];
                                        if ($day=='wed') {
                                            $duration .= '<div class="ck-button">
                                                <label>
                                                    <input id="'.$slot['id'].'" name="slots[wed]['.$time_slot[1].'-'.$time_slot[2].']" type="checkbox" value="'.$slot['id'].'"><span>'.$time_slot[1].' to '.$time_slot[2].'</span>
                                                </label>
                                            </div> ';
                                        }
                                    }
                                    if ($duration == '') {
                                        echo 'No Slots';
                                    }
                                    else{
                                        echo $duration;
                                    }
                                    ?>
                                </p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="full-input p-2 col-xl col-lg me-2 mb-3">
                                <label for="phone" class="form-label text-grey ft-14 mb-0">Thursday</label>
                                <p>
                                    <?php 
                                    $duration = '';
                                    foreach ($slots as $key => $slot) {
                                        $time_slot = explode('-', $slot['time_slot']);
                                        $day = $time_slot[0];
                                        if ($day=='thu') {
                                            $duration .= '<div class="ck-button">
                                                <label>
                                                    <input id="'.$slot['id'].'" name="slots[thu]['.$time_slot[1].'-'.$time_slot[2].']" type="checkbox" value="'.$slot['id'].'"><span>'.$time_slot[1].' to '.$time_slot[2].'</span>
                                                </label>
                                            </div> ';
                                        }
                                    }
                                    if ($duration == '') {
                                        echo 'No Slots';
                                    }
                                    else{
                                        echo $duration;
                                    }
                                    ?>
                                </p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="full-input p-2 col-xl col-lg me-2 mb-3">
                                <label for="phone" class="form-label text-grey ft-14 mb-0">Friday</label>
                                <p>                                
                                    <?php 
                                    $duration = '';
                                    foreach ($slots as $key => $slot) {
                                        $time_slot = explode('-', $slot['time_slot']);
                                        $day = $time_slot[0];
                                        if ($day=='fri') {
                                            $duration .= '<div class="ck-button">
                                                <label>
                                                    <input id="'.$slot['id'].'" name="slots[fri]['.$time_slot[1].'-'.$time_slot[2].']" type="checkbox" value="'.$slot['id'].'"><span>'.$time_slot[1].' to '.$time_slot[2].'</span>
                                                </label>
                                            </div> ';
                                        }
                                    }
                                    if ($duration == '') {
                                        echo 'No Slots';
                                    }
                                    else{
                                        echo $duration;
                                    }
                                    ?>
                                </p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="full-input p-2 col-xl col-lg me-2 mb-3">
                                <label for="phone" class="form-label text-grey ft-14 mb-0">Saturday</label>
                                <p>
                                    <?php 
                                    $duration = '';
                                    foreach ($slots as $key => $slot) {
                                        $time_slot = explode('-', $slot['time_slot']);
                                        $day = $time_slot[0];
                                        if ($day=='sat') {
                                            $duration .= '<div class="ck-button">
                                                <label>
                                                    <input id="'.$slot['id'].'" name="slots[sat]['.$time_slot[1].'-'.$time_slot[2].']" type="checkbox" value="'.$slot['id'].'"><span>'.$time_slot[1].' to '.$time_slot[2].'</span>
                                                </label>
                                            </div> ';
                                        }
                                    }
                                    if ($duration == '') {
                                        echo 'No Slots';
                                    }
                                    else{
                                        echo $duration;
                                    }
                                    ?>
                                </p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="full-input p-2 col-xl col-lg me-2 mb-3">
                                <label for="phone" class="form-label text-grey ft-14 mb-0">Sunday</label>
                                <p>
                                    <?php 
                                    $duration = '';
                                    foreach ($slots as $key => $slot) {
                                        $time_slot = explode('-', $slot['time_slot']);
                                        $day = $time_slot[0];
                                        if ($day=='sun') {
                                            $duration .= '<div class="ck-button">
                                                <label>
                                                    <input id="'.$slot['id'].'" name="slots[sun]['.$time_slot[1].'-'.$time_slot[2].']" type="checkbox" value="'.$slot['id'].'"><span>'.$time_slot[1].' to '.$time_slot[2].'</span>
                                                </label>
                                            </div> ';
                                        }
                                    }
                                    if ($duration == '') {
                                        echo 'No Slots';
                                    }
                                    else{
                                        echo $duration;
                                    }
                                    ?>
                                </p>
                            </div>
                        </div>
                    </div>    
                    <div class="row">
                        <div class="col-md-12 text-center pb-4">
                            <input type="hidden" name="user_id" id="user_id" value="<?php echo $_SESSION['ap_profrea_login_id']; ?>">
                            <input type="hidden" name="space_id" id="space_id" value="<?php echo $space_id; ?>">
                            <input type="hidden" name="plan_id" id="plan_id" value="">
                            <input type="hidden" name="charges_per_hour" id="charges_per_hour" value="<?php echo $oneData->hourly_charges; ?>">
                            <button type="submit" class="log-inbtn">Save And Update</button>
                        </div>
                    </div>                    
                </form>
                <div id="booknowForm_status"></div>
            </div>
        </div>
    </div>
</div>
<?php include_once('footer.php'); ?>


<script type="text/javascript">
$(function () {

   //  var datestring = new Date().toISOString().split(".")[0];
    // console.log(datestring);

   // $('#scheduledate').datetimepicker();

   // document.getElementById("scheduledate").min = new Date().toISOString().split("T")[0];
    
   // console.log(new Date().toISOString().split("T")[0]);


    // document.getElementById("date_from").min = new Date().toISOString().split("T")[0];

    $(".booknow").click(function(e){
        var plan_id = $(this).data('plan_id');
        var space_id = $(this).data('space_id');
        $('#plan_id').val(plan_id);
        $.ajax({
            type: 'POST',
            url: './includes/functions.php?action=getslots',
            data: {plan_id:plan_id,space_id:space_id},
            success : function(res){
                $('#plan_slots').html(res);
                $('#booknowModal').modal('show');
            }
        });
    });
});
</script>