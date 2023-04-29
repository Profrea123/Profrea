<?php 
error_reporting(1);
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
        $sql_user = "SELECT users.*,city.name as city,os.name as op_speciality FROM users left join operating_specialty as os on os.id = users.speciality left join gender on gender.id=users.gender_id left join city on city.id=users.city WHERE users.id = $user_id";
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


include_once('header-client.php');


?>

<!-- 1st row wrap  -->
<section class="bg-spdr  mt-5">
    <div class="container">
        <div class="row p-3 bg-white shadow">
            <div class="col-md-2">
                <img src="datafiles/uploads/profiles/<?php echo $profile_picture; ?>" class="img-fluid">
            </div>
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-8 pt-3 pt-md-0">
                        <h3 class="sp-head f1 "><?php echo "Dr. ".ucwords($row_user["name"]); ?></h3>
                        <h6 class="deg-name pt-2"><?php echo $row_user["education"]; ?></h6>
                        <h6 class="sub-degname pt-2"><?php echo $row_user["op_speciality"]; ?></h6>
                    </div>
                    <div class="col-md-4 pt-3 pt-md-0 p-md-0">
                        <div class="badgediconsec">
                        <img src="images/star.png" class="img-fluid">
                        <span class="badgesecheadtop">Profrea Verified</span>
                        </div>
                    </div>
                  <?php   
                    if(count($profrea_clinic) > 0){
                    $images = $profrea_clinic[0]["images"]!=""?explode(",",$profrea_clinic[0]["images"]):null;                                
                    if($images !== null)
                    {
                    ?>    
                    <div class="col-md-12 pt-3 pt-md-0 pt-xxl-4 pt-lg-0">
                        <h6 class="shotouthead pt-3">Gallery</h6>
                        <div class="row thumbnailed-img">
                        <?php    
                        $i=0;
                        foreach($images as $image)
                        {
                            $i++;
                            if($image!=""){
                        ?>        
                            <div class="col-md col-3 mb-3 mb-md-0">
                                <div class="gallery-wrapper">
                                    <a href="#lightbox-image-<?php echo $i; ?>">
                                        <div class="image-wrapper">                                    
                                            <img src="datafiles/spaces/<?php $profrea_clinic['space_id'] ?>/space_images/<?php echo $image; ?>" class="img-fluid" alt="<?php echo $profrea_clinic[0]['name'] ?>">                                    
                                        </div>
                                    </a>
                                </div>
                                <div class="gallery-lightboxes">    
                                    <div class="image-lightbox" id="lightbox-image-<?php echo $i; ?>">
                                        <div class="image-lightbox-wrapper">
                                            <a href="#" class="close"></a>
                                            <a href="#lightbox-image-7" class="arrow-left"></a>
                                            <a href="#lightbox-image-2" class="arrow-right"></a>
                                            <img src="datafiles/uploads/clinicImg/<?php echo $image; ?>" class="img-fluid" alt="<?php echo $profrea_clinic[0]['name'] ?>">                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php }
                            } ?>
                        </div>
                    </div>
                    <?php }
                    }
                    ?>

                </div>                
            </div>
            <div class="col-md-4 pt-3 pt-md-0">
                <div class="row">
                    <!-- experience box -->
                    <div class="col-md-6 col-6">
                        <div class="splitedclinicrows">
                            <div class="row p-3">
                                <div class="col-md-2 col-12 text-center text-md-start">
                                    <i class="fa fa-briefcase"></i>
                                </div>
                                <div class="col-md-10 col-12 ps-md-4 text-center text-md-start">
                                <h5 class="box-detclinic">Experience</h5>
                                <h4 class="box-detpara mb-0"><?php echo $row_user["experience"]; ?> Years</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- total clinics box -->
                    <div class="col-md-6 col-6">
                        <div class="splitedclinicrows">
                            <div class="row p-3">
                                <div class="col-md-2 col-12 text-center text-md-start">
                                    <i class="fa fa-home"></i>
                                </div>
                                <div class="col-md-10 col-12 ps-md-4 text-center text-md-start">
                                <h5 class="box-detclinic">Total Clinics</h5>
                                <h4 class="box-detpara mb-0">5 Clinics</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- mail box -->
                    <div class="col-md-12 pt-4 text-md-end text-center">
                        <h5 class="mailbox-sp"><i class="fa fa-envelope pe-2"></i> <?php echo $row_user['email']; ?></h5>
                        <div class="calldrbtn  mt-3">
                            <a href=""><i class="fa fa-phone-alt pe-3"></i> Call the Doctor</a>
                        </div>
                        <div class="whtsappdrbtn  mt-3">
                            <a href=""><i class="fa fa-whatsapp pe-3"></i> Message on Whatsapp</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- tab section  -->
        <div class="row mt-4 pb-5">
            <div class="col-md-8 d-flex align-self-stretch ps-md-0">
                <div class="tab-sectionnewpg bg-white shadow p-3">
                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="pills-about-tab" data-bs-toggle="pill" data-bs-target="#pills-about" type="button" role="tab" aria-controls="pills-about" aria-selected="true">About</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-services-tab" data-bs-toggle="pill" data-bs-target="#pills-services" type="button" role="tab" aria-controls="pills-services" aria-selected="false">Services</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-reviews-tab" data-bs-toggle="pill" data-bs-target="#pills-reviews" type="button" role="tab" aria-controls="pills-reviews" aria-selected="false">Reviews</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-booking-tab" data-bs-toggle="pill" data-bs-target="#pills-booking" type="button" role="tab" aria-controls="pills-booking" aria-selected="false">Booking</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-experience-tab" data-bs-toggle="pill" data-bs-target="#pills-experience" type="button" role="tab" aria-controls="pills-experience" aria-selected="false">Experience</button>
                        </li>
                    </ul>
                    <div class="tab-content pt-md-4 pt-3" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-about" role="tabpanel" aria-labelledby="pills-about-tab">
                            <p><?php 
                                    echo $row_website_details["story"] ; 
                                    ?></p>
                        </div>
                        <div class="tab-pane fade" id="pills-services" role="tabpanel" aria-labelledby="pills-services-tab">
                            <p><?php 
                                    echo $row_website_details["rowservice"] ; 
                                    ?></p>
                        </div>
                        <div class="tab-pane fade" id="pills-reviews" role="tabpanel" aria-labelledby="pills-reviews-tab">
                            <p></p>
                        </div>
                        <div class="tab-pane fade" id="pills-booking" role="tabpanel" aria-labelledby="pills-booking-tab">
                            <p></p>
                        </div>
                        <div class="tab-pane fade" id="pills-experience" role="tabpanel" aria-labelledby="pills-experience-tab">
                            <p></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4  align-self-stretch p-md-0 mt-4 mt-md-0">
           <?php 
                if(count($row_profrea_clinic) != 0)
                {
                  
           ?>
            <div class="col-md-12  align-self-stretch bg-white shadow p-md-0 mt-md-0 mb-4">
                <div class="headbar-secgrey">
                    <h3 class="headbarsechead f1 ps-3 mb-0">Profrea Clinic</h3>
                </div>

                <?php foreach($row_profrea_clinic as $profrea_clinic)
                            { ?>
                <div class="p-3">
                    <h5 class="sub-headbarhead"><?php echo $profrea_clinic['ws_name']; ?></h5>
                    <p class="sub-headbarpara"><?php echo $profrea_clinic['address']; ?></p>
                    <h5 class="sub-headbarhead">Timings</h5>

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
                                    
                    <div class="row pt-3 pb-5">
                        <div class="col-md-6 col-6">
                            <div class="callclinicbtn">
                                <a href="">Call the Clinic</a>
                            </div>
                        </div>
                        <div class="col-md-6 col-6">
                            <div class="ddclinicbtn">
                                <a target="_blank" href="">Get Directions</a>
                            </div>
                        </div>
                    </div>
                   
                </div>
                <?php } ?> 

            </div>
            <?php } ?>
            <?php if(count($row_clinic_details) > 0){ ?>
            <div class="col-md-12  align-self-stretch bg-white shadow p-md-0 mt-4 mt-md-0">
                <div class="headbar-secgrey">
                    <h3 class="headbarsechead f1 ps-3 mb-0">Other Clinic</h3>
                </div>
            <?php
                foreach($row_clinic_details as $clinic){
                        $images = json_decode($clinic["images"]);
            ?>
                <div class="p-3">
                    <h5 class="sub-headbarhead"><?php echo $clinic["name"]; ?></h5>
                    <p class="sub-headbarpara"><?php echo $clinic["address"]; ?></p>
                    <h5 class="sub-headbarhead">Timings</h5>
                    <p"><?php echo $clinic["time_slot"]; ?></p>
                    <div class="row pt-3 pb-5">
                        <div class="col-md-6 col-6">
                            <div class="callclinicbtn">
                                <a href="">Call the Clinic</a>
                            </div>
                        </div>
                        <div class="col-md-6 col-6">
                            <div class="ddclinicbtn">
                                <a target="_blank" href="">Get Directions</a>
                            </div>
                        </div>
                    </div>
                   
                </div>
              <?php } ?>  
          
            </div>
        </div>   
        <?php } ?>
           

        </div>
    </div>
</section>

    
<?php include_once('footer-client.php');