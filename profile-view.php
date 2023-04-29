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

$title = 'Profile View';
$keywords = 'Profrea';
$description = 'Profrea';
$page="profile";
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

    $sql_clinic_details = "SELECT * FROM clinic_details WHERE user_id = $login_id";
    $res_clinic_details = $db_connection->getDbHandler()->query($sql_clinic_details);
    if($res_clinic_details)
    {     
        $row_clinic_details = $res_clinic_details->fetchAll();
    }

    $sql_speciality = "SELECT * FROM operating_specialty  WHERE space_type_id = ".$row_user["profession_id"];
    $res_speciality = $db_connection->getDbHandler()->query($sql_speciality);
    if($res_speciality)
    {
        $row_speciality = $res_speciality->fetchAll();
    }
    
    $sql_user_speciality = "SELECT u.id as spl_id, o.id as opr_id,o.name FROM user_speciality as u LEFT JOIN operating_specialty as o ON o.id = u.speciality_name WHERE space_type_id = ".$row_user["profession_id"];
    $res_user_speciality = $db_connection->getDbHandler()->query($sql_user_speciality);
    if($res_user_speciality)
    {
        $row_user_speciality = $res_user_speciality->fetchAll();
    }

    // family members
    $sql_family_members = "SELECT * FROM family_members WHERE user_id = $login_id";
    $res_family_members = $db_connection->getDbHandler()->query($sql_family_members);
    if($res_family_members)
    {     
        $row_family_members = $res_family_members->fetchAll();
    }

    // Holidays
    $sql_holidays = "SELECT * FROM holidays WHERE doctor_id = $login_id";
    $res_holidays = $db_connection->getDbHandler()->query($sql_holidays);
    if($res_holidays)
    {     
        $row_holidays = $res_holidays->fetchAll();
    }

    // Audio
    $sql_time_slot_audio = "SELECT * FROM  doctor_time_slots WHERE doctor_id = $login_id AND type = 1";
    $res_time_slot_audio = $db_connection->getDbHandler()->query($sql_time_slot_audio);
    $row_time_slots_audio = $res_time_slot_audio->fetchAll();

    $existing_time_slot_audio 	    = "SELECT doctor_day_time_slots.slot_time, doctor_day_time_slots.doctor_time_slot_id FROM doctor_time_slots LEFT JOIN doctor_day_time_slots ON doctor_time_slots.id = doctor_day_time_slots.doctor_time_slot_id WHERE doctor_time_slots.doctor_id = ".$login_id . " AND doctor_time_slots.type = 1";
    $con_details_audio			    = $db_connection->getDbHandler()->query($existing_time_slot_audio);
	$res_existing_time_slot_audio	= $con_details_audio->fetchAll();

    // Video
    $sql_time_slot_video = "SELECT * FROM  doctor_time_slots WHERE doctor_id = $login_id AND type = 2";
    $res_time_slot_video = $db_connection->getDbHandler()->query($sql_time_slot_video);
    $row_time_slots_video = $res_time_slot_video->fetchAll();
    
    $existing_time_slot 	= "SELECT doctor_day_time_slots.slot_time, doctor_day_time_slots.doctor_time_slot_id FROM doctor_time_slots LEFT JOIN doctor_day_time_slots ON doctor_time_slots.id = doctor_day_time_slots.doctor_time_slot_id WHERE doctor_time_slots.doctor_id = ".$login_id . " AND doctor_time_slots.type = 2";
    $con_details			= $db_connection->getDbHandler()->query($existing_time_slot);
	$res_existing_time_slot	= $con_details->fetchAll();

    //Clinic
    $sql_time_slot_clinic = "SELECT * FROM  doctor_time_slots WHERE doctor_id = $login_id AND type = 3";
    $res_time_slot_clinic = $db_connection->getDbHandler()->query($sql_time_slot_clinic);
    $row_time_slots_clinic = $res_time_slot_clinic->fetchAll();

    $existing_time_slot_clinic 	    = "SELECT doctor_day_time_slots.slot_time, doctor_day_time_slots.doctor_time_slot_id FROM doctor_time_slots LEFT JOIN doctor_day_time_slots ON doctor_time_slots.id = doctor_day_time_slots.doctor_time_slot_id WHERE doctor_time_slots.doctor_id = ".$login_id . " AND doctor_time_slots.type = 3";
    $con_details_clinic			    = $db_connection->getDbHandler()->query($existing_time_slot_clinic);
	$res_existing_time_slot_clinic	= $con_details_clinic->fetchAll();

    $sql_video_details = "SELECT * FROM clinic_yt_videos WHERE user_id = $login_id";
    $res_video_details = $db_connection->getDbHandler()->query($sql_video_details);
    if($res_video_details)
    {
        $row_video_details = $res_video_details->fetchAll();
    }

    //clinic gallery
    $sql_gallery_details = "SELECT * FROM clinic_gallery WHERE user_id = $login_id";
    $res_gallery_details = $db_connection->getDbHandler()->query($sql_gallery_details);
    if($res_gallery_details)
    {     
        $row_gallery_details = $res_gallery_details->fetchAll();
    }

    //$sql_profrea_clinic = "SELECT * FROM spaces WHERE owner_id = $login_id AND space_type = 'Clinic'";
    $sql_profrea_clinic = "SELECT sbook.*,sp.*,sp.id as sp_id FROM space_bookings as sbook 
    LEFT JOIN spaces AS sp ON sp.id = sbook.space_id
    WHERE sbook.user_id = $login_id and sbook.booking_status > 0";

    
    $res_profrea_clinic = $db_connection->getDbHandler()->query($sql_profrea_clinic);
 
    if($res_profrea_clinic)
    {
        $row_profrea_clinic = $res_profrea_clinic->fetchAll();
    }
    
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


    <?php if($row_user["profession_id"] == 1){ ?>
    <!-- detail section started -->
    <section class="bg-updation">
        <div class="container">
            <div class="row align-items-start pt-5 pb-5">
                <div class="col-lg-2 col-md-3 col-5 profile-membername">
                    <img src="datafiles/uploads/profiles/<?php echo $profile_picture; ?>" class="img-fluid" alt="" title="">
                </div>
                <div class="col-lg-10 col-md-9 col-7 p-0">
                    <h2 class="top-namehead fw-bold f1"><?php echo $row_user['name']; ?>,</h2>
                    <div class="row pt-3">
                        <div class="col-lg-3 col-md-4">
                            <h6 class="top-stitle ft-14 text-grey">Phone</h6>
                            <p class="top-sdetails ft-16"><?php echo $row_user['mobileNo']; ?></p>
                        </div>
                        <div class="col-lg-3 col-md-4">
                            <h6 class="top-stitle ft-14 text-grey">Email</h6>
                            <p class="top-sdetails ft-16"><?php echo $row_user['email']; ?></p>
                        </div>
                        <div class="col-lg-2 col-md-3">
                            <h6 class="top-stitle ft-14 text-grey">Gender</h6>
                            <p class="top-sdetails ft-16"><?php echo $row_user['gender']; ?></p>
                        </div>
                        <div class="col-lg-2 col-md-3">
                            <h6 class="top-stitle ft-14 text-grey">Location</h6>
                            <p class="top-sdetails ft-16"><?php echo $row_user['city']; ?></p>
                        </div>
                        <div class="col-lg-2 col-md-3 pt-3">
                            <div class="edit-sec text-blue"> 
                                <a href="profile-update">Edit Profile</a>
                            </div>
                        </div>
                    </div>
                </div>                
                <div class="col-md-12 pt-5">
                    <div class="education-box p-4">
                        <h2 class="education-titlehead text-center ft-18 f1 fw-bold">Education And Experience Information</h2>
                        <div class="row pt-2 pt-md-4">
                            <div class="col-md-4">
                                
                                <div class="b-th p-2 ">
                                    <h6 class="top-stitle ft-14 text-grey">Education Qualification</h6>
                                    <p class="top-sdetails ft-16 mb-0"><?php echo ($row_user !== false?$row_user["education"]:""); ?></p>
                                    
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class='b-th p-2'>
                                    <h6 class="top-stitle ft-14 text-grey">Speciality</h6>
                                    <p class="top-sdetails ft-16 mb-0"><?php echo ($row_user !== false?$row_user["opspeciality"]:""); ?></p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class='b-th p-2'>
                                    <h6 class="top-stitle ft-14 text-grey">Years of experience</h6>
                                    <p class="top-sdetails ft-16 mb-0"><?php echo ($row_user !== false?$row_user["experience"]:""); ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 pt-5 pb-5">
                    <h2 class="education-titlehead ft-18 f1 fw-bold">Registration Information</h2>
                    <div class="row pt-3">
                        <?php
                        $photo_doc = $row_user["photo_doc"];
                        $reg_doc = $row_user["reg_doc"];
                        $indemnity_doc = $row_user["indemnity_doc"];
                        $extArray = array('gif', 'jpg', 'jpeg', 'png');
                        $photo_doc_extension = substr($photo_doc, strrpos($photo_doc, ".")+1);
                        $reg_doc_extension = substr($reg_doc, strrpos($reg_doc, ".")+1);
                        $indemnity_doc_extension = substr($indemnity_doc, strrpos($indemnity_doc, ".")+1);
                        if (in_array($photo_doc_extension, $extArray)) 
                        {
                            ?>
                            <div class="col-md-3 col-6 mb-3 mb-md-0">
                                <h6 class="file-uploadlabel text-grey ft-14">Photo ID</h6>                            
                                <!-- <img src="<?php echo ($photo_doc != ""?"datafiles/uploads/photoId/".$photo_doc:"images/id.png"); ?>" class="img-fluid" alt="" title=""> -->
                                <a href="datafiles/uploads/photoId/<?php echo $photo_doc; ?>" download><i class="fas fa-file-download pe-2 text-blue"></i> Download</a>
                            </div> 
                            <?php
                        }
                        else
                        {
                            ?>
                            <div class="col-md-3 col-6 mb-3 mb-md-0">
                                <h6 class="file-uploadlabel text-grey ft-14">Photo ID</h6>
                                <h6 class="text-grey ft-16">
                                    <?php if($photo_doc != ""){ ?>
                                        <a href="datafiles/uploads/photoId/<?php echo $photo_doc; ?>" download><i class="fas fa-file-download pe-2 text-blue"></i> Download</a>
                                    <?php } else { ?>
                                        Not uploaded
                                    <?php } ?>
                                </h6>
                            </div>
                            <?php
                        }
                        if (in_array($reg_doc_extension, $extArray)) 
                        {
                            ?>
                            <div class="col-md-3 col-6 mb-3 mb-md-0">
                                <h6 class="file-uploadlabel text-grey ft-14">Registration Document</h6>                            
                                <!-- <img src="<?php echo ($reg_doc != ""?"datafiles/uploads/photoId/".$reg_doc:"images/id.png"); ?>" class="img-fluid" alt="" title=""> -->
                                <a href="datafiles/uploads/regDoc/<?php echo $reg_doc; ?>" download><i class="fas fa-file-download pe-2 text-blue"></i> Download</a>
                            </div> 
                            <?php
                        }
                        else
                        {
                            ?>
                            <div class="col-md-3 col-6 mb-3 mb-md-0">
                                <h6 class="file-uploadlabel text-grey ft-14">Registration Document</h6>
                                <h6 class="text-grey ft-16">
                                    <?php if($reg_doc != ""){ ?>
                                        <a href="datafiles/uploads/regDoc/<?php echo $reg_doc; ?>" download><i class="fas fa-file-download pe-2 text-blue"></i> Download</a>
                                    <?php } else { ?>
                                        Not uploaded
                                    <?php } ?>
                                </h6>
                            </div>
                            <?php
                        }
                        if (in_array($indemnity_doc_extension, $extArray)) 
                        {
                            ?>
                            <div class="col-md-3 col-6 mb-3 mb-md-0">
                                <h6 class="file-uploadlabel text-grey ft-14">Indemnity bond</h6>                            
                                <!-- <img src="<?php echo ($indemnity_doc != ""?"datafiles/uploads/photoId/".$indemnity_doc:"images/id.png"); ?>" class="img-fluid" alt="" title=""> -->
                                <a href="datafiles/uploads/IndemnityDoc/<?php echo $indemnity_doc; ?>" download><i class="fas fa-file-download pe-2 text-blue"></i> Download</a>
                            </div> 
                            <?php
                        }
                        else
                        {
                            ?>
                            <div class="col-md-3 col-6 mb-3 mb-md-0">
                                <h6 class="file-uploadlabel text-grey ft-14">Indemnity bond</h6>
                                <h6 class="text-grey ft-16">
                                    <?php if($indemnity_doc != ""){ ?>
                                        <a href="datafiles/uploads/IndemnityDoc/<?php echo $indemnity_doc; ?>" download><i class="fas fa-file-download pe-2 text-blue"></i> Download</a>
                                    <?php } else { ?>
                                        Not uploaded
                                    <?php } ?>
                                </h6>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>                
            </div>
        </div>
    </section>
    <!-- detail section ended -->
    <!-- website section started -->
    <section class="bg-website" id="website">
        <div class="container">
            <div class="row pt-5 pb-5 align-items-center">
                <div class="col-md-8 col-7 ">
                    <h1 class="website-detailhead f1 ft-32 fw-bold">Website Details</h1>
                </div>
                <div class="col-md-4 col-5">
                    <div class="edit-web text-blue"> 
                        <a href="website-update">Edit Website</a>
                    </div>
                </div>
                <div class="col-md-12 pt-5">                    
                    <div class="row pt-3 align-items-center">                   
                        <div class="col-md-4">
                            <h6 class="website-edithead ft-16 mb-0 pb-3 fw-bold">Domain Name</h6>
                            <div class="row align-items-center bg-white me-3">
                                <div class="col-md-6 col-8 websiteformfield">
                                    <lable class="inp">
                                        <?php
                                        if(isset($row_website_details["domain"]) != '')
                                        {
                                            echo $row_website_details["domain"] ?? '';
                                        }
                                        else
                                        {
                                            echo getslug($row_user['name'] ?? '');
                                        }
                                        ?>
                                    </lable>
                                    <!-- <input type="text" name='email' class="p-2" required data-parsley-minlength="4" placeholder="Anamika.dr"> -->
                                </div>
                                <div class="col-md-6 col-4">
                                    <h6 class="ft-16 mb-0">.profrea.com</h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="row socialmedia-formfield">
                                <div class="col-md-12 pb-3 pt-3 pt-md-0">
                                    <h6 class="website-edithead ft-16 mb-0 fw-bold">Social Media</h6>
                                </div>
                                <div class="col-md-1 col text-center mb-3 mb-lg-0">
                                <a href="<?php echo $row_website_details["fb_link"] ?? "#"; ?>" target="_blank"><i class="ft-16 fab fa-facebook-f text-blue text-center"></i></a>
                                </div>
                                <div class="col-md-1 col text-center mb-3 mb-lg-0">
                                <a href="<?php echo $row_website_details["twitter_link"] ?? "#"; ?>" target="_blank"><i class="ft-16 fab fa-twitter text-blue text-center"></i></a> 
                                </div>
                                <div class="col-md-1 col text-center mb-3 mb-lg-0">
                                <a href="<?php echo $row_website_details["linkedin_link"] ?? "#"; ?>" target="_blank"><i class="ft-16 fab fa-linkedin-in text-blue text-center"></i></a>
                                </div>
                                <div class="col-md-1 col text-center mb-3 mb-lg-0">
                                <a href="<?php echo $row_website_details["insta_link"] ?? "#"; ?>" target="_blank"><i class="ft-16 fab fa-instagram text-blue text-center"></i></a>
                                </div>
                                <div class="col-md-1 col text-center mb-3  mb-lg-0">
                                <a href="<?php echo $row_website_details["google_review_link"] ?? "#"; ?>" target="_blank"><i class="ft-16 fab fa-google text-blue text-center"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row pt-5 socialmedia-formfield">
                        <div class="col-md-6 pb-3">
                            <h6 class="website-edithead ft-16 mb-0 fw-bold">Services</h6>
                            <lable class="inp mt-4 bg-white p-3">
                            <?php 
                            echo $row_website_details["rowservice"] ?? "-"; 
                            ?>
                            </lable>
                            <!-- <textarea class="form-control mt-3" placeholder="Enter Services what you can offer" id="floatingTextarea2" style="height: 200px"></textarea> -->
                        </div>
                        <div class="col-md-6 pb-3">
                            <h6 class="website-edithead ft-16 mb-0 fw-bold">About Me</h6>
                            <lable class="inp mt-4 bg-white p-3">
                            <?php 
                            echo $row_website_details["story"] ?? "-"; 
                            ?>
                            </lable>
                            <!-- <textarea class="form-control mt-3" placeholder="Tell Us About Yourself (Upto 300 words)" id="floatingTextarea2" style="height: 200px"></textarea> -->
                        </div>
                    </div>
                    <!-- Speciality -->
                    <div class="row pt-5 bg-white mt-5 pb-3" id="spl_names">
                        <div class="col-lg-2 col-12 pb-4">
                            <h1 class="website-detailhead f1 ft-32 fw-bold">Speciality</h1>
                        </div>
                        <div class="col-lg-10 col-12 col-4">
                            <form id="addSpecialist" method="POST" novalidate>
                                <div class="row pt-2">
                                    <div class="col-lg-5 col-6 p-md-0">
                                        <select  name="speciality[]" class="" id="choices-multiple" multiple>
                                            <?php foreach($row_speciality as $speciality){ ?>
                                                <option value="<?php echo $speciality["id"]; ?>"><?php echo $speciality["name"]; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-lg-3 col-6 pb-5">                                        
                                        <div class="vi-sub">
                                            <input type="hidden" name="userid" value="<?php echo $login_id; ?>" />
                                                <button class="submit-btn" type="submit">Add</button>
                                            <div class="addSpecialiststatus"></div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="row">
                            <?php foreach($row_user_speciality as $spl_user) { ?>
                                <div class="col-auto  pb-4">    
                                    <span style="background:#b4d2ff;" class="rounded-pill p-2 ms-1 ">
                                        <?php echo $spl_user['name']; ?>
                                        <a data-speciality = "<?php echo $spl_user['spl_id']; ?>" class="delSpeciality  text-danger" href="#"> <i class="fa fa-times-circle-o  pe-1 text-danger ps-2 "></i></a> 
                                    </span>
                                </div>
                            <?php } ?>
                        </div>
                        
                    </div>
                    <div class="row pt-5 bg-white mt-5">
                        <div class="col-md-12 pb-4">
                        <h1 class="website-detailhead f1 ft-32 fw-bold">Profrea Clinic</h1>                        
                        </div>
                        <?php
                    

                        if(count($row_profrea_clinic) != 0)
                        {
                            foreach($row_profrea_clinic as $profrea_clinic)
                            {
                                ?>                        
                                <div class="col-md-6">
                                    <h6 class="website-edithead ft-16 mb-0">Name</h6>
                                    <p class="text-grey ft-16 pt-3"><?php echo $profrea_clinic["ws_name"]; ?></p>

                                    <h6 class="website-edithead ft-16 mb-0 pt-3">Address</h6>
                                    <p class="text-grey ft-16 pt-3 pe-5"><?php echo $profrea_clinic["address"]; ?></p>
                               
                                    <h6 class="website-edithead ft-16 mb-0 pt-3">Your Slots</h6>
                                    <p class="text-grey ft-16 pt-3">
                                    <?php 
                                            if($profrea_clinic['mon_slots']!==""){
                                                echo "Monday ".print_slot($profrea_clinic['mon_slots'])."<br/>";
                                            }
                                            if($profrea_clinic['tue_slots']!==""){
                                                echo "Tuesday ".print_slot($profrea_clinic['tue_slots'])."<br/>";
                                            }
                                            if($profrea_clinic['wed_slots']!==""){
                                                echo "Wednesday ".print_slot($profrea_clinic['wed_slots'])."<br/>";
                                            }
                                            if($profrea_clinic['thu_slots']!==""){
                                                echo "Thrusday ".print_slot($profrea_clinic['thu_slots'])."<br/>";
                                            }
                                            if($profrea_clinic['fri_slots']!==""){
                                                echo "Friday ".print_slot($profrea_clinic['fri_slots'])."<br/>";
                                            }
                                            if($profrea_clinic['sat_slots']!==""){
                                                echo "Saturday ".print_slot($profrea_clinic['sat_slots'])."<br/>";
                                            }
                                            if($profrea_clinic['sun_slots']!==""){
                                                echo "Sunday ".print_slot($profrea_clinic['sun_slots'])."<br/>";
                                            }
                                    ?>
                                    </p>
                               
                                </div>
                                <div class="col-md-6">
                                    <h6 class="website-edithead ft-16 mb-0">Photos</h6>
                                    <div class="row pt-3">
                                        <?php
                                        $images = $profrea_clinic["images"]!=""?explode(",",$profrea_clinic["images"]):null;                                
                                        if($images !== null)
                                        {
                                            foreach($images as $image)
                                            {
                                                if($image!="" && file_exists("datafiles/spaces/".$profrea_clinic['id']."/space_images/".$image)){
                                                ?>
                                                <div class="col-md-2 col-4 mb-3 mb-md-0">
                                                    <img src="datafiles/spaces/<?php echo $profrea_clinic['id']; ?>/space_images/<?php echo $image; ?>" class="img-fluid" alt="Clinic Image" title="">
                                                </div>
                                                <?php 
                                                }
                                            }
                                        }
                                        ?>
                                    </div>
                                </div>
                                <?php 
                            }
                        }
                        else{
                            ?>
                            <h2 class="education-titlehead ft-18 f1">No Subscribed to Clinics in Profrea</h2>
                            <?php
                        }
                        ?>
                      
                    </div>
                    <div class="row pb-5">                        
                        <div class="col-md-12">

                            <div class="row pt-5 bg-white mt-5 pb-3">
                                <div class="col-lg-2 col-12 pb-4">
                                    <h1 class="website-detailhead f1 ft-32 fw-bold">Gallery</h1>
                                </div>
                                <div class="col-lg-10 col-12 col-4">
                                <form id="galleryAdd" method="POST" novalidate>
                                    <div class="row pt-2">
                                        <div class="col-lg-2 col-6 p-md-0">
                                            <button class="file-upload">
                                                <input id="gallerynew" name="gallerynew" type="file" required class="file-input ft-16" accept="image/png, image/jpeg">Choose Image
                                            </button>
                                        </div>                                    
                                        <div class="col-lg-3 col-6 pb-5">                                        
                                            <div class="vi-sub">
                                                <input type="hidden" name="userid" value="<?php echo $login_id; ?>" />
                                                <button class="submit-btn" type="submit">Add</button>
                                                <div class="gallerystatus"></div>
                                            </div>                                            
                                        </div>
                                    </div>
                                 </form>    
                                </div>
                                <div class="row">
                                    <?php foreach($row_gallery_details as $gallery) {
                                        if($gallery['imgpath']!="" && file_exists("datafiles/uploads/clinicImg/".$gallery['imgpath'])){ ?>
                                            <div class="col-md-2 col-6 mb-3 mb-md-0 frmaeimg d-flex align-self-stretch flex-wrap text-center">
                                                <img src="datafiles/uploads/clinicImg/<?php echo $gallery['imgpath']; ?>" class="img-fluid" alt="Clinic Image <?php echo $gallery['id'] ?>" title="">
                                                <div class="mt-4 mb-5 text-center align-self-end m-auto"><a data-galleryid="<?php echo $gallery["id"]; ?>"   data-galleryname="<?php echo $gallery["imgpath"]; ?>"   class="delGallery" href="#">Delete</a></div>
                                            </div>
                                    <?php } } ?>
                                </div>
                            </div>

                            <div class="row pt-5 bg-white mt-5 pb-3">
                                <div class="col-md-12 pb-4">
                                    <h1 class="website-detailhead f1 ft-32 fw-bold">Youtube Videos</h1>                        
                                </div>

                                <div class="col-lg-12 col-12">
                                <form id="youtubeAdd" method="POST" novalidate>   
                                    <div class="row pt-2">
                                        <div class="col-lg-9 col-12 websiteformfield d-md-flex">
                                        <input type="text" name='ytlink' class="p-2 h-50 w-100 " required  placeholder="Enter Only the video ID here">
                                        </div>
                                        <div class="col-lg-3 col-12 pb-5 mt-3 mt-md-0">                                        
                                            <div class="vi-sub">
                                                <input type="hidden" name="userid" value="<?php echo $login_id; ?>" />
                                                <button class="submit-btn" type="submit">Add</button>                                            
                                            </div>
                                        </div>
                                    </div>
                                 </form>    
                                </div>
                                <div class="row mb-5 justify-content-center">
                                <?php
                                foreach($row_video_details as $video)
                                {
                                    if($video['ytlink']!=""){
                                        ?>
                                        <div class="col-md-3 col-5 mb-5 mt-5 frmaevideo d-flex align-self-stretch flex-wrap text-center ms-3">
                                            
                                        <iframe width="100%" height="150" src="https://www.youtube.com/embed/<?php echo $video['ytlink']; ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                            <div class="mt-5 mb-5 text-center align-self-end m-auto"><a data-videoid="<?php echo $video["id"]; ?>"  class="delVideo" href="#">Delete</a></div>                                                    
                                        </div>
                                        <?php 
                                    }
                                }
                                ?>
                                </div>
                            </div>
                            <!-- Video View -->
                            <div class="row pt-5 pb-5 align-items-center bg-white mt-5" id="video-timeslot">
                                <div class="col-md-6 col-6">
                                    <h1 class="website-detailhead f1 ft-32 fw-bold">Video TimeSlot</h1>
                                </div>
                                <div class="col-md-3 col-3 text-right">
                                    <div class="edit-web text-blue"> 
                                        <a href="custom-timeslot-video">Custom TimeSlot Video</a>
                                    </div>
                                </div>
                                <div class="col-md-3 col-3 text-right">
                                    <div class="edit-web text-blue">
                                        <a href="video-timeslot">Edit Video TimeSlot</a>
                                    </div>
                                </div>
                            <?php if (count($row_time_slots_video) > 0) { ?>
                                <div class="col-lg-12 col-12 mt-4">
                                    <?php 
                                        $slot = $slot_status = '';
                                        if(isset($row_website_details["slot_interval"])) {
                                            $slot = $row_website_details["slot_interval"];
                                        }
                                        if(isset($row_website_details["booking_slot_status"])) {
                                            $slot_status = $row_website_details["booking_slot_status"];
                                        }
                                    ?>

                                    <div class="row pt-2 pb-4 p-4 ">

                                        <div class="col-lg-12 col-12 ml-auto websiteformfield d-md-flex">
                                            <div class="col-lg-3 col-3 display_grid">
                                                <label>Slot Interval</label>
                                                <span class="ml-5 text-danger"><?php echo $slot; ?></span>
                                            </div>
                                            <div class="col-lg-3 col-3 display_grid">
                                                <label>Booking Open Upto (In Days)</label>
                                                <span class="ml-5 text-danger"><?php echo $row_website_details["booking_open_upto"] ?? ''; ?></span>
                                            </div>
                                            <div class="col-lg-3 col-3 display_grid">
                                                <label>Booking Slot Status</label>
                                                <span class="ml-5 text-danger"><?php echo $slot_status ? "Open": "Close"; ?></span>
                                            </div>
                                            <div class="col-lg-3 col-3 display_grid">
                                                <label>Video Amount Per Slot</label>
                                                <span class="ml-5 text-danger"><?php echo $row_website_details["video_amount"] ?? ''; ?></span>
                                            </div>
                                        </div>

                                        <div class="container">
                                            <div class="col-lg-12">
                                                <div class="row col-12 p-2">
                                                    <div class="col-lg-12 col-12 mt-4  websiteformfield d-md-flex">
                                                        <div class="col-lg-2">
                                                            <label><b>Day</b></label>
                                                        </div>
                                                        <div class="col-lg-1">
                                                            <label><b>Status</b></label>
                                                        </div>
                                                        <div class="col-lg-3">
                                                            <div class="col-lg-12">
                                                                <div class="row">
                                                                    <div class="col-lg-6">
                                                                        <label><b>Start Time</b></label>
                                                                    </div>
                                                                    <div class="col-lg-6">
                                                                        <label><b>End Time</b></label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <label><b>Available Slots</b></label>
                                                        </div>
                                                    </div>
                                                    <?php
                                                        $list_of_week_days = ['sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'];
                                                        foreach($row_time_slots_video as $key => $video_slot) {
                                                            $required = false; $div_hide = true;
                                                            if ($video_slot['is_available']) {
                                                                $required = true; $div_hide = false;
                                                            }
                                                        ?>
                                                        <div class="col-lg-12 col-12 mt-5  websiteformfield d-md-flex">
                                                            <div class="col-lg-2">
                                                               <label><?php echo ucfirst($video_slot['day']); ?> </label>
                                                            </div>
                                                            <div class="col-lg-1">
                                                                <?php if ($video_slot['is_available']) { ?>
                                                                    <label class="text-success"> Open </label>
                                                                <?php } else { ?>
                                                                    <label class="text-danger"> Close </label>
                                                                <?php }  ?>
                                                            </div>

                                                            <div class="col-lg-3" <?php if($div_hide) { ?>style="display:none;"<?php } ?>>
                                                                <div class="col-lg-12">
                                                                    <div class="row ">
                                                                        <div class="col-lg-6 ">
                                                                            <label><?php echo $video_slot['start_time']; ?></label>
                                                                        </div>
                                                                        <div class="col-lg-6 ">
                                                                            <label><?php echo $video_slot['end_time']; ?></label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-6">
                                                                <?php $alvailable_slots = array(); foreach($res_existing_time_slot as $available) {
                                                                    if($available['doctor_time_slot_id'] == $video_slot['id']) { 
                                                                        $alvailable_slots[] = $available['slot_time']; ?>
                                                                <?php } } ?>
                                                                <label><?php echo implode(', ', $alvailable_slots); ?></label>
                                                            </div>

                                                        </div>
                                                    <?php } ?>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                            </div>
                            <!-- Audio View -->
                            <div class="row pt-5 pb-5 align-items-center bg-white mt-5" id="audio-timeslot">
                                <div class="col-md-6 col-6">
                                    <h1 class="website-detailhead f1 ft-32 fw-bold">Audio TimeSlot</h1>
                                </div>
                                <div class="col-md-3 col-3 text-right">
                                    <div class="edit-web text-blue"> 
                                        <a href="custom-timeslot-audio">Custom TimeSlot Audio</a>
                                    </div>
                                </div>
                                <div class="col-md-3 col-3 text-right">
                                    <div class="edit-web text-blue">
                                        <a href="audio-timeslot">Edit Audio TimeSlot</a>
                                    </div>
                                </div>
                            <?php if (count($row_time_slots_audio) > 0) { ?>
                                <div class="col-lg-12 col-12 mt-4">
                                    <?php
                                        $audio_slot = $audio_slot_status = '';
                                        if(isset($row_website_details["audio_slot_interval"])) {
                                            $audio_slot = $row_website_details["audio_slot_interval"];
                                        }
                                        if(isset($row_website_details["audio_booking_slot_status"])) {
                                            $audio_slot_status = $row_website_details["audio_booking_slot_status"];
                                        }
                                    ?>

                                    <div class="row pt-2 pb-4 p-4 ">

                                        <div class="col-lg-12 col-12 ml-auto websiteformfield d-md-flex">
                                            <div class="col-lg-3 col-3 display_grid">
                                                <label>Slot Interval</label>
                                                <span class="ml-5 text-danger"><?php echo $audio_slot; ?></span>
                                            </div>
                                            <div class="col-lg-3 col-3 display_grid">
                                                <label>Booking Open Upto (In Days)</label>
                                                <span class="ml-5 text-danger"><?php echo $row_website_details["audio_booking_open_upto"] ?? ''; ?></span>
                                            </div>
                                            <div class="col-lg-3 col-3 display_grid">
                                                <label>Booking Slot Status</label>
                                                <span class="ml-5 text-danger"><?php echo $audio_slot_status ? "Open": "Close"; ?></span>
                                            </div>
                                            <div class="col-lg-3 col-3 display_grid">
                                                <label>Audio Amount Per Slot</label>
                                                <span class="ml-5 text-danger"><?php echo $row_website_details["audio_amount"] ?? ''; ?></span>
                                            </div>
                                        </div>

                                        <div class="container">
                                            <div class="col-lg-12">
                                                <div class="row col-12 p-2">
                                                    <div class="col-lg-12 col-12 mt-4  websiteformfield d-md-flex">
                                                        <div class="col-lg-2">
                                                            <label><b>Day</b></label>
                                                        </div>
                                                        <div class="col-lg-1">
                                                            <label><b>Status</b></label>
                                                        </div>
                                                        <div class="col-lg-3">
                                                            <div class="col-lg-12">
                                                                <div class="row">
                                                                    <div class="col-lg-6">
                                                                        <label><b>Start Time</b></label>
                                                                    </div>
                                                                    <div class="col-lg-6">
                                                                        <label><b>End Time</b></label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <label><b>Available Slots</b></label>
                                                        </div>
                                                    </div>
                                                    <?php
                                                        $list_of_week_days = ['sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'];
                                                        foreach($row_time_slots_audio as $key => $audio_slot) {
                                                            $required = false; $div_hide = true;
                                                            if ($audio_slot['is_available']) {
                                                                $required = true; $div_hide = false;
                                                            }
                                                        ?>
                                                        <div class="col-lg-12 col-12 mt-5  websiteformfield d-md-flex">
                                                            <div class="col-lg-2">
                                                               <label><?php echo ucfirst($audio_slot['day']); ?> </label>
                                                            </div>
                                                            <div class="col-lg-1">
                                                                <?php if ($audio_slot['is_available']) { ?>
                                                                    <label class="text-success"> Open </label>
                                                                <?php } else { ?>
                                                                    <label class="text-danger"> Close </label>
                                                                <?php }  ?>
                                                            </div>

                                                            <div class="col-lg-3" <?php if($div_hide) { ?>style="display:none;"<?php } ?>>
                                                                <div class="col-lg-12">
                                                                    <div class="row ">
                                                                        <div class="col-lg-6 ">
                                                                            <label><?php echo $audio_slot['start_time']; ?></label>
                                                                        </div>
                                                                        <div class="col-lg-6 ">
                                                                            <label><?php echo $audio_slot['end_time']; ?></label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-6">
                                                                <?php $alvailable_audio = array(); foreach($res_existing_time_slot_audio as $available_slot) {
                                                                    if($available_slot['doctor_time_slot_id'] == $audio_slot['id']) { 
                                                                        $alvailable_audio[] = $available_slot['slot_time']; ?>
                                                                <?php } } ?>
                                                                <label><?php echo implode(', ', $alvailable_audio); ?></label>
                                                            </div>

                                                        </div>
                                                    <?php } ?>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                            </div>

                            <div class="row pt-5 pb-5 align-items-center bg-white mt-5" id="clinic-timeslot">
                                <div class="col-md-6 col-6">
                                    <h1 class="website-detailhead f1 ft-32 fw-bold">Clinic TimeSlot</h1>
                                </div>
                                <div class="col-md-3 col-3 text-right">
                                    <div class="edit-web text-blue"> 
                                        <a href="custom-timeslot-clinic">Custom TimeSlot Clinic</a>
                                    </div>
                                </div>
                                <div class="col-md-3 col-3 text-right">
                                    <div class="edit-web text-blue"> 
                                        <a href="clinic-timeslot">Edit Clinic TimeSlot</a>
                                    </div>
                                </div>
                                
                                <?php if (count($row_time_slots_clinic) > 0) { ?>
                                    <div class="col-lg-12 col-12 mt-4">
                                        <?php
                                            $clinic_slot = $clinic_slot_status = '';
                                            if(isset($row_website_details["clinic_slot_interval"])) {
                                                $clinic_slot = $row_website_details["clinic_slot_interval"];
                                            }
                                            if(isset($row_website_details["clinic_booking_slot_status"])) {
                                                $clinic_slot_status = $row_website_details["clinic_booking_slot_status"];
                                            }
                                        ?>

                                        <div class="row pt-2 pb-4 p-4 ">

                                            <div class="col-lg-12 col-12 ml-auto websiteformfield d-md-flex">
                                                <div class="col-lg-3 col-3 display_grid">
                                                    <label>Slot Interval</label>
                                                    <span class="ml-5 text-danger"><?php echo $clinic_slot; ?></span>
                                                </div>
                                                <div class="col-lg-3 col-3 display_grid">
                                                    <label>Booking Open Upto (In Days)</label>
                                                    <span class="ml-5 text-danger"><?php echo $row_website_details["clinic_booking_open_upto"] ?? ''; ?></span>
                                                </div>
                                                <div class="col-lg-3 col-3 display_grid">
                                                    <label>Booking Slot Status</label>
                                                    <span class="ml-5 text-danger"><?php echo $clinic_slot_status ? "Open": "Close"; ?></span>
                                                </div>
                                                <div class="col-lg-3 col-3 display_grid">
                                                    <label>Clinic Amount Per Slot</label>
                                                    <span class="ml-5 text-danger"><?php echo $row_website_details["clinic_amount"] ?? ''; ?></span>
                                                </div>
                                            </div>

                                            <div class="container">
                                                <div class="col-lg-12">
                                                    <div class="row col-12 p-2">
                                                        <div class="col-lg-12 col-12 mt-4  websiteformfield d-md-flex">
                                                            <div class="col-lg-2">
                                                                <label><b>Day</b></label>
                                                            </div>
                                                            <div class="col-lg-1">
                                                                <label><b>Status</b></label>
                                                            </div>
                                                            <div class="col-lg-3">
                                                                <div class="col-lg-12">
                                                                    <div class="row">
                                                                        <div class="col-lg-6">
                                                                            <label><b>Start Time</b></label>
                                                                        </div>
                                                                        <div class="col-lg-6">
                                                                            <label><b>End Time</b></label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <label><b>Available Slots</b></label>
                                                            </div>
                                                        </div>
                                                        <?php
                                                            $list_of_week_days = ['sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'];
                                                            foreach($row_time_slots_clinic as $key => $clinic_slot) {
                                                                $required = false; $div_hide = true;
                                                                if ($clinic_slot['is_available']) {
                                                                    $required = true; $div_hide = false;
                                                                }
                                                            ?>
                                                            <div class="col-lg-12 col-12 mt-5  websiteformfield d-md-flex">
                                                                <div class="col-lg-2">
                                                                    <label><?php echo ucfirst($clinic_slot['day']); ?> </label>
                                                                </div>
                                                                <div class="col-lg-1">
                                                                    <?php if ($clinic_slot['is_available']) { ?>
                                                                        <label class="text-success"> Open </label>
                                                                    <?php } else { ?>
                                                                        <label class="text-danger"> Close </label>
                                                                    <?php }  ?>
                                                                </div>

                                                                <div class="col-lg-3" <?php if($div_hide) { ?>style="display:none;"<?php } ?>>
                                                                    <div class="col-lg-12">
                                                                        <div class="row ">
                                                                            <div class="col-lg-6 ">
                                                                                <label><?php echo $clinic_slot['start_time']; ?></label>
                                                                            </div>
                                                                            <div class="col-lg-6 ">
                                                                                <label><?php echo $clinic_slot['end_time']; ?></label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-lg-6">
                                                                    <?php $alvailable_clinic = array(); foreach($res_existing_time_slot_clinic as $available_slot) {
                                                                        if($available_slot['doctor_time_slot_id'] == $clinic_slot['id']) { 
                                                                            $alvailable_clinic[] = $available_slot['slot_time']; ?>
                                                                    <?php } } ?>
                                                                    <label><?php echo implode(', ', $alvailable_clinic); ?></label>
                                                                </div>
                                                            </div>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>

                        <!-- Holidays -->

                        <div class="row pt-5 bg-white mt-5 pb-5 align-items-center ">
                            <div class="col-md-9 col-5 pb-4">
                                <h1 class="website-detailhead f1 ft-32 fw-bold">Holidays</h1> 
                            </div>
                            <div class="col-md-3 col-7 pb-4 edit-web">    
                                <a href="" data-bs-toggle="modal" data-bs-target="#holiday">Add Holidays</a>                  
                            </div>

                            <div class="col-md-12 col-12 row"> 
                                <?php foreach($row_holidays as $holiday) {
                                    $encid = base64_encode($holiday["id"]); ?>
                                    <div class="col-md-3 border border-blue mt-3 p-3 ms-3 me-3">
                                        <a data-holidayid="<?php echo $holiday["id"]; ?>" href="holiday-update?cid=<?php echo $encid; ?>"><i class="fa fa-edit pe-1"></i> edit</a>  
                                        <a data-holidayid="<?php echo $holiday["id"]; ?>" class="delHoliday text-danger" href="#"> <i class="fa fa-trash pe-1 text-danger ps-3"></i>Delete</a>  
                                        
                                        <p class="text-grey ft-16 pt-0">
                                            <div class="pt-2"><i class="far fa-calendar-plus text-primary pe-3"></i><?php echo $holiday["from_date"]!=""?date('d-M-Y',strtotime($holiday["from_date"]))."<br/>":""; ?></div>
                                            <div class="pt-2"><i class="far fa-calendar-minus text-primary pe-3"></i><?php echo $holiday["to_date"]!=""?date('d-M-Y',strtotime($holiday["to_date"]))."<br/>":""; ?></div>
                                            <div class="pt-2"><i class="fa fa-bars text-primary pe-3"></i><?php echo $holiday["schedule_type"]!=""?ucfirst(str_replace('_',' ',$holiday["schedule_type"]))."<br/>":""; ?></div>
                                            <div class="pt-2"><i class="fa fa-receipt text-primary pe-3"></i><?php echo $holiday["reason"]!=""?ucfirst($holiday["reason"])."<br/>":"-"; ?></div>
                                        </p>

                                    </div>
                                <?php } ?>
                            </div>
                        </div>

                        <!-- Own Clinic -->
                            
                        <div class="row pt-5 bg-white mt-5 pb-5 align-items-center">
                            <div class="col-md-9 col-5 pb-4">
                                
                                <h1 class="website-detailhead f1 ft-32 fw-bold">Own Clinic</h1>
                            </div> 
                            <div class="col-md-3 col-7 pb-4 edit-web">    
                                <a href="" data-bs-toggle="modal" data-bs-target="#exampleModal">Add Own Clinic</a>                  
                            </div>
                            
                            <div class="col-md-12 col-12 row"> 
                                <?php foreach($row_clinic_details as $clinic) {
                                    //Encryption
                                    $encid = base64_encode($clinic["id"]);
                                    //Decryption
                                    //$decrypt_result = mcrypt_ecb (MCRYPT_3DES, 'surendar', $result, MCRYPT_DECRYPT);
                                    $images = json_decode($clinic["images"]);
                                    ?>
                                    <div class="col-md-3 border border-blue ms-3 me-3 mt-3 p-3">
                                        <a data-clinicid="<?php echo $clinic["id"]; ?>" href="clinic-update?cid=<?php echo $encid; ?>"><i class="fa fa-edit pe-1"></i> edit</a>  <a data-clinicid="<?php echo $clinic["id"]; ?>" class="delClinic text-danger" href="#"> <i class="fa fa-trash pe-1 text-danger ps-3"></i>Delete</a>  
                                        <p class="text-grey ft-22 pt-3"><?php echo $clinic["name"]; ?></p>
                                        <h6 class="website-edithead ft-16 mb-0 pt-1 fw-bold">Address</h6>
                                        <p class="text-grey ft-16 pt-3">
                                        <div class="pt-2"><i class="fas fa-map-marker-alt text-primary pe-2"></i><?php echo $clinic["address"]!=""?$clinic["address"]."<br/>":""; ?></div>
                                        <div class="pt-2"><i class="far fa-clock text-primary pe-2"></i><?php echo $clinic["time_slot"]!=""?$clinic["time_slot"]."<br/>":""; ?></div>
                                        <div class="pt-2"><i class="far fa-address-book text-primary pe-2"></i><?php echo $clinic["contact_number"]!=""?"Ph: ".$clinic["contact_number"]."<br/>":""; ?></div>
                                        <div class="pt-2"><i class="fas fa-directions text-primary pe-2"></i><?php echo $clinic["google_map_link"]!="" ?  "<a href='".$clinic["google_map_link"]."' target='_blank'>Direction</a>"."<br/>":""; ?></div>
                                        </p>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>

                        <div class="col-md-12 pt-5 mt-5 pb-5">
                            <div class="pubwebsite-btn text-center">
                                <?php if(isset($row_website_details['id'])){ ?>
                                <?php if($row_website_details['publish_status'] == 0){ ?>
                                    <a><span style="cursor:pointer;" class="text-white" data-wdid="<?php echo $row_website_details['id']; ?>" id="publish_website">Publish A Website</span></a>
                                <?php } else { ?>
                                    <h2 class="text-center">Published</h2>
                                    <div class="row align-items-center">
                                        <div class="col-md-6 text-start tbs-btn">
                                            <a target="_blank" href="website?domain=<?php echo $row_website_details["domain"]; ?>">preview</a>
                                        </div>
                                        <div class="col-md-6 text-end pubwebsite-btn">
                                            <a ><span  style="cursor:pointer;" class="text-white" data-wdid="<?php echo $row_website_details['id']; ?>" id="unpublish_website">Unpublish A Website</span></a>
                                        </div>
                                    </div>
                                    <!-- <a href="website?id=<?php echo base64_encode($login_id); ?>">View Website</a><br/><br/> -->
                                <?php } }?>
                            </div>
                        </div>
                            
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- website section ended -->
    <?php } else { ?>
    <section class="bg-updation">
        <div class="container">
            <div class="row align-items-start pt-5 pb-5">
                <div class="col-lg-4 col-md-3 col-5 profile-membername">
                    <img src="datafiles/uploads/profiles/<?php echo $profile_picture; ?>" class="img-fluid" alt="" title="">
                </div>
                <div class="col-lg-8 col-md-9 col-7 p-0">
                    <h2 class="top-namehead fw-bold f1"><?php echo $row_user['name']; ?>,</h2>
                    <div class="row pt-3">
                        <div class="col-lg-3 col-md-4">
                            <h6 class="top-stitle ft-14 text-grey">Phone</h6>
                            <p class="top-sdetails ft-16"><?php echo $row_user['mobileNo']; ?></p>
                        </div>
                        <div class="col-lg-3 col-md-4">
                            <h6 class="top-stitle ft-14 text-grey">Email</h6>
                            <p class="top-sdetails ft-16"><?php echo $row_user['email']; ?></p>
                        </div>
                        <div class="col-lg-2 col-md-3">
                            <h6 class="top-stitle ft-14 text-grey">Gender</h6>
                            <p class="top-sdetails ft-16"><?php echo $row_user['gender']; ?></p>
                        </div>
                        <div class="col-lg-2 col-md-3">
                            <h6 class="top-stitle ft-14 text-grey">Location</h6>
                            <p class="top-sdetails ft-16"><?php echo $row_user['city']; ?></p>
                        </div>
                        <div class="col-lg-2 col-md-3 pt-3">
                            <div class="edit-sec text-blue"> 
                                <a href="profile-update">Edit Profile</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 pt-5">
                    <div class="education-box p-4">
                        <h2 class="education-titlehead text-center ft-18 f1 fw-bold">Personal Information</h2>
                        <div class="row pt-2">
                            <div class="col-md-12">
                                <div class='p-2 col-md-12 me-4'>
                                    <h6 class="top-stitle ft-14 text-grey">About</h6>
                                    <p class="top-sdetails ft-16"><?php echo ($row_user !== false?$row_user["about"]:""); ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row pt-5 bg-white mt-5 pb-5 align-items-center ">
                    <div class="col-md-9 col-5 pb-4">
                        <h1 class="website-detailhead f1 ft-32 fw-bold">Family Members</h1> 
                    </div>
                    <div class="col-md-3 col-7 pb-4 edit-sec text-blue">    
                        <a href="" data-bs-toggle="modal" data-bs-target="#family-members">Add Family members</a>                  
                    </div>

                    <div class="col-md-12 col-12 row"> 
                        <?php foreach($row_family_members as $member) {
                            $encid = base64_encode($member["id"]); ?>
                            <div class="col-md-2 border border-blue mt-3 p-3 ms-3 me-3">
                                <a data-memberid="<?php echo $member["id"]; ?>" href="family-member-update?cid=<?php echo $encid; ?>"><i class="fa fa-edit pe-1"></i> edit</a>  
                                <a data-memberid="<?php echo $member["id"]; ?>" class="delMember text-danger" href="#"> <i class="fa fa-trash pe-1 text-danger ps-3"></i>Delete</a>  
                                
                                <!-- <p class="text-grey ft-22 pt-3"><?php echo $member["name"]; ?></p> -->
                                <!--<p class="text-grey ft-16 pt-1"><?php echo date('d-M-Y', strtotime($member["dob"])); ?></p>
                                <p class="text-grey ft-16 pt-1"><?php echo ucfirst($member["relation"]); ?></p>
                                <p class="text-grey ft-16 pt-1"><?php echo ucfirst($member["gender"]); ?></p> -->

                                <!-- <h6 class="website-edithead ft-16 mb-0 pt-1 fw-bold">Address</h6> -->
                                <p class="text-grey ft-16 pt-0">
                                    <div class="pt-2"><i class="fas fa-user text-primary pe-3"></i><?php echo $member["name"]!=""?$member["name"]."<br/>":""; ?></div>
                                    <div class="pt-2"><i class="fa fa-birthday-cake text-primary pe-3"></i><?php echo $member["dob"]!=""?date('d-M-Y', strtotime($member["dob"]))."<br/>":""; ?></div>
                                    <div class="pt-2"><i class="fa fa-link text-primary pe-3"></i><?php echo $member["relation"]!=""?ucfirst($member["relation"])."<br/>":""; ?></div>
                                    <div class="pt-2"><i class="fa fa-venus-double text-primary pe-3"></i><?php echo $member["gender"]!=""?ucfirst($member["gender"])."<br/>":""; ?></div>
                                </p>
                            </div>
                        <?php } ?>
                    </div>

                </div>

            </div>
        </div>

    </section>
    <?php } ?>    

    <!-- Modal -->
    <div class="modal fade clinic-popup" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content p-3">
                <div class="modal-header">
                    <h5 class="modal-title ft-32 f1 fw-bold" id="exampleModalLabel">Add your Own Clinic</h5>
                    <button type="button" class="btn-close text-blue" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="clinicAdd" method="POST" novalidate>
                        <div class="row">
                            <div class="col-md-4">
                                    <div class="full-input p-2 col-md-12 me-4">
                                        <label for="exampleInputPassword1" class="form-label text-grey ft-14 mb-0">Clinic name*</label>
                                        <input type="text" name="name" required data-parsley-minlength="2" placeholder="Enter Clinic Name">
                                    </div>
                            </div>
                            <div class="col-md-4">
                                    <div class="full-input p-2 col-md-12 me-4">
                                        <label for="exampleInputPassword1" class="form-label text-grey ft-14 mb-0">Address</label>
                                        <input type="text" name="address" required data-parsley-minlength="4" placeholder="Enter Clinic Address">
                                    </div>
                            </div>
                            <div class="col-md-4">
                                    <div class="full-input p-2 col-md-12 me-4">
                                        <label for="exampleInputPassword1" class="form-label text-grey ft-14 mb-0">Clinic Contact Number*</label>
                                        <input type="text" name="clinic_phone" required data-parsley-minlength="2" placeholder="Enter Clinic Contact Number">
                                    </div>
                            </div>
                            <div class="col-md-4  pt-3 ">
                                    <div class="full-input p-2 col-md-12 me-4">
                                        <label for="exampleInputPassword1" class="form-label text-grey ft-14 mb-0">Google Map Link</label>
                                        <input type="text" name="map_link" required data-parsley-minlength="4" placeholder="Enter Google Map Link">
                                    </div>
                            </div>
                            
                            <div class="col-md-12 pb-4 pt-5 pt-md-4">
                                <h1 class="website-detailhead f1 ft-24 fw-bold">Time Slots</h1>
                                <div class="col-md-12">
                                    <div class="p-2 col-md-12 me-4">
                                        <textarea name="time_slot" required placeholder="Enter time slot"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 text-center pt-5 pb-5">
                                <div id="clinicStatus">
                                    <button class="submit-btn" type="submit">Save And Update</button>
                                </div>
                            </div>                                                
                        </div>
                    </form>
                </div>                                    
            </div>
        </div>
    </div>
                        <!-- Family Members Model -->
    <div class="modal fade clinic-popup" id="family-members" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content p-3">
                <div class="modal-header">
                    <h5 class="modal-title ft-32 f1 fw-bold" id="exampleModalLabel">Add Family Members</h5>
                    <button type="button" class="btn-close text-blue" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="familyMembers" method="POST" novalidate>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="full-input p-2 col-md-12 me-4">
                                    <label for="exampleInputPassword1" class="form-label text-grey ft-14 mb-0">Full name*</label>
                                    <input type="text" name="name" required data-parsley-minlength="2" autocomplete="off" class="form-control" placeholder="Enter Full Name">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="full-input p-2 col-md-12 me-4">
                                    <label for="exampleInputPassword1" class="form-label text-grey ft-14 mb-0">Date Of Birth*</label>
                                    <input type="text" name="dob" required data-parsley-minlength="4" id="date_from" class="form-control" placeholder="">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="full-input p-2 col-md-12 me-4">
                                    <label for="exampleInputPassword1" class="form-label text-grey ft-14 mb-0">Relation*</label>
                                    <select name="relation" class="form-control" id="" required>
                                        <option value="">-- Select --</option>
                                        <option value="father">Father</option>
                                        <option value="mother">Mother</option>
                                        <option value="son">Son</option>
                                        <option value="daughter">Daughter</option>
                                        <option value="husband">Husband</option>
                                        <option value="wife">Wife</option>
                                        <option value="spouse">Spouse</option>
                                        <option value="brother">Brother</option>
                                        <option value="sister">Sister</option>
                                        <option value="grandfather">Grandfather</option>
                                        <option value="grandmother">Grandmother</option>
                                        <option value="uncle">Uncle</option>
                                        <option value="cousin">Cousin</option>
                                    </select> 	
                                    <!-- <input type="text" name="clinic_phone" required data-parsley-minlength="2" placeholder="Enter Clinic Contact Number"> -->
                                </div>
                            </div>
                            <div class="col-md-4  pt-3 ">
                                <div class="full-input p-2 col-md-12 me-4">
                                    <label for="exampleInputPassword1" class="form-label text-grey ft-14 mb-0">Gender*</label>
                                    <select name="gender" class="form-control" id="" required>
                                        <option value="">-- Select -- </option>
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                        <option value="other">Other</option>
                                    </select>
                                    <!-- <input type="text" name="map_link" required data-parsley-minlength="4" placeholder="Enter Google Map Link"> -->
                                </div>
                            </div>

                            <div class="col-md-12 text-center pt-5 pb-5">
                                <div id="clinicStatus">
                                    <button class="submit-btn" type="submit">Save</button>
                                </div>
                            </div>                                                
                        </div>
                    </form>
                </div>                                    
            </div>
        </div>
    </div>
                        <!-- Holiday Model -->
    <div class="modal fade clinic-popup" id="holiday" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content p-3">
                <div class="modal-header">
                    <h5 class="modal-title ft-32 f1 fw-bold" id="exampleModalLabel">Add Holidays</h5>
                    <button type="button" class="btn-close text-blue" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="holidays" method="POST" novalidate>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="full-input p-2 col-md-12 me-4">
                                    <label for="" class="form-label text-grey ft-14 mb-0">From Date*</label>
                                    <input type="text" name="from_date" required class="form-control date_from" placeholder="">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="full-input p-2 col-md-12 me-4">
                                    <label for="" class="form-label text-grey ft-14 mb-0">To Date*</label>
                                    <input type="text" name="to_date" required class="form-control date_to" placeholder="">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="full-input p-2 col-md-12 me-4">
                                    <label for="" class="form-label text-grey ft-14 mb-0">Schedule Type*</label>
                                    <select name="schedule_type" class="form-control" id="" required>
                                        <option value="">-- Select --</option>
                                        <option value="emergency">Emergency</option>
                                        <option value="out_of_station">Out Of Station</option>
                                        <option value="holiday">Holiday</option>
                                        <option value="personal_leave">Personal Leave</option>
                                        <option value="other">Other</option>
                                    </select> 	
                                </div>
                            </div>
                            <div class="col-md-4  pt-3 ">
                                <div class="full-input p-2 col-md-12 me-4">
                                    <label for="" class="form-label text-grey ft-14 mb-0">Reason</label>
                                    <textarea name="reason" class="form-control" id=""> </textarea>
                                 </div>
                            </div>

                            <div class="col-md-12 text-center pt-5 pb-5">
                                <div id="holidayStatus">
                                    <button class="submit-btn" type="submit">Save</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>                                    
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.css">
      
    <script src="js/bootstrap.popper.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/font-awesome.js"></script>
    

    
    
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
    
    <script src="js/parsley.min.js"></script>
    <script src="js/moment-with-locales.min.js"></script> 
    <script src="js/bootstrap-datetimepicker.min.js"></script> 

    <script type="text/javascript">
    $('#date_from').datetimepicker({
        format: 'DD-MM-YYYY',
    });
    $('.date_from').datetimepicker({
        format: 'DD-MM-YYYY',
        minDate:new Date()
    });
    $('.date_to').datetimepicker({
        format: 'DD-MM-YYYY',
        minDate:new Date()
    });
    $(function () {
        var multipleCancelButton = new Choices('#choices-multiple', {
            removeItemButton: true,
            maxItemCount:5,
            searchResultLimit:65,
            renderChoiceLimit:10
        });
         //Holiday
        $("#holidays").submit(function(e){
            e.preventDefault();
            if ( $(this).parsley().isValid() )
            {
            var formData = new FormData(this);
            $.ajax({
                type: 'POST',
                url: './includes/functions.php?action=holiday',
                data: formData,
                cache: false,
                processData: false,
                contentType: false,
                beforeSend: function(){
              //  $('#clinicStatus').html('<p class="text-center"><i class="fa fa-spinner fa-spin"></i> Please wait as we process..</p>').fadeIn();
                },
                success : function(res){
                    let resObj = JSON.parse(res);
                    Swal.fire({
                    icon: resObj.icon,
                    title: resObj.title,
                    text: resObj.msg,
                    // footer: '<a href="">Why do I have this issue?</a>'
                    }).then((result) => {
                        window.location = "profile-view"
                    })
                   // $('#clinicStatus').html("").fadeIn();
                    // window.location = "profile-view"
                }
            });
            }
            return false;
        });

        $(".delHoliday").on("click",function(){
            var holidayid = $(this).data("holidayid");
            $.ajax({
                type: 'POST',
                url: './includes/functions.php?action=deleteHoliday',
                data: {holidayid:holidayid},
                success : function(res){
                    let resObj = JSON.parse(res);
                    Swal.fire({
                        icon: resObj.icon,
                        title: resObj.title,
                        text: resObj.msg,
                    }).then((result) => {
                        window.location = "profile-view"
                    });
                }
            });
        return false;
        });
        

        //Family members
        $("#familyMembers").submit(function(e){
            e.preventDefault();
            if ( $(this).parsley().isValid() )
            {
            var formData = new FormData(this);
            $.ajax({
                type: 'POST',
                url: './includes/functions.php?action=familyMembers',
                data: formData,
                cache: false,
                processData: false,
                contentType: false,
                beforeSend: function(){
              //  $('#clinicStatus').html('<p class="text-center"><i class="fa fa-spinner fa-spin"></i> Please wait as we process..</p>').fadeIn();
                },
                success : function(res){
                    let resObj = JSON.parse(res);
                    Swal.fire({
                    icon: resObj.icon,
                    title: resObj.title,
                    text: resObj.msg,
                    // footer: '<a href="">Why do I have this issue?</a>'
                    }).then((result) => {
                        window.location = "profile-view"
                    })
                   // $('#clinicStatus').html("").fadeIn();
                    // window.location = "profile-view"
                }
            });
            }
            return false;
        });


        $(".delMember").on("click",function(){

            var memberid = $(this).data("memberid");
            $.ajax({
                type: 'POST',
                url: './includes/functions.php?action=deleteFamilyMember',
                data: {memberid:memberid},
                success : function(res){
                    let resObj = JSON.parse(res);
                    Swal.fire({
                        icon: resObj.icon,
                        title: resObj.title,
                        text: resObj.msg,
                    }).then((result) => {
                        window.location = "profile-view"
                    });
                }
            });  
            return false;
        });

        // Clinic Add
        $("#clinicAdd").submit(function(e){
            e.preventDefault();
            if ( $(this).parsley().isValid() )
            {
            var formData = new FormData(this);
            $.ajax({
                type: 'POST',
                url: './includes/functions.php?action=clinicAdd',
                data: formData,
                cache: false,
                processData: false,
                contentType: false,
                beforeSend: function(){
              //  $('#clinicStatus').html('<p class="text-center"><i class="fa fa-spinner fa-spin"></i> Please wait as we process..</p>').fadeIn();
                },
                success : function(res){
              
                    let resObj = JSON.parse(res);
                    Swal.fire({
                    icon: resObj.icon,
                    title: resObj.title,
                    text: resObj.msg,
                    // footer: '<a href="">Why do I have this issue?</a>'
                    }).then((result) => {
                        window.location = "profile-view"
                    })
                   // $('#clinicStatus').html("").fadeIn();
                    // window.location = "profile-view"
                
                }
            });
            }
            return false;
        });

        // Youtube Add
         $("#youtubeAdd").submit(function(e){
            e.preventDefault();
            if ( $(this).parsley().isValid() )
            {
            var formData = new FormData(this);
            $.ajax({
                type: 'POST',
                url: './includes/functions.php?action=youtubeAdd',
                data: formData,
                cache: false,
                processData: false,
                contentType: false,
                beforeSend: function(){
              //  $('#clinicStatus').html('<p class="text-center"><i class="fa fa-spinner fa-spin"></i> Please wait as we process..</p>').fadeIn();
                },
                success : function(res){
                   
                    
                    let resObj = JSON.parse(res);
                    Swal.fire({
                    icon: resObj.icon,
                    title: resObj.title,
                    text: resObj.msg,
                    }).then((result) => {
                        window.location = "profile-view"
                    })
                }
            });
            }
            return false;
        });

        // $(document).ready(function(){
        //     $(".video_slot_enable").on('click',function(){
        //         var day = $(this).attr('data-day');
        //         if($(this).is(':checked')) {
        //             $('#'+day+'_day_time_slot_div').show();
        //             $('#'+day+'_video_start_time, #'+day+'_video_end_time').prop('required',true);
        //             $('#'+day+'_video_start_time, #'+day+'_video_end_time').val('');
        //             $(this).val(1);
        //         } else {
        //             $('#'+day+'_day_time_slot_div').hide();
        //             $('#'+day+'_video_start_time, #'+day+'_video_end_time').prop('required',false);
        //             $('#'+day+'_video_start_time, #'+day+'_video_end_time').val('');
        //             $(this).val(0);
        //         }
        //     });

        // });
        //Timeslot
        // $("#timeSlot").submit(function(e){
        //     e.preventDefault();
        //     if ( $(this).parsley().isValid() )
        //     {
        //         var formData = new FormData(this);
        //         $.ajax({
        //             type: 'POST',
        //             url: './includes/functions.php?action=timeSlot',
        //             data: formData,
        //             cache: false,
        //             processData: false,
        //             contentType: false,
        //             beforeSend: function(){},
        //             success : function(res){
        //                 var resObj = jQuery.parseJSON(res);

        //                 if(resObj.status){
        //                     let resObj = JSON.parse(res);
        //                     Swal.fire({
        //                     icon: resObj.icon,
        //                     title: resObj.title,
        //                     text: resObj.msg,
        //                     }).then((result) => {
        //                         window.location = "profile-view"
        //                     });
        //                 } else {
        //                     Swal.fire({
        //                         icon: resObj.icon,
        //                         title: resObj.title,
        //                         text: resObj.msg,
        //                     });
        //                     $('#slot_interval_slot').html(resObj.errors.slot_interval ?? '');
        //                     $('#booking_open_upto_error').html(resObj.errors.booking_open_upto ?? '');
        //                     $('#booking_slot_status_error').html(resObj.errors.booking_slot_status ?? '');
        //                     $('#video_amount_error').html(resObj.errors.video_amount ?? '');
        //                     $('#sunday_video_start_time_error').html(resObj.errors.sunday_video_start_time ?? '');
        //                     $('#sunday_video_end_time_error').html(resObj.errors.sunday_video_end_time ?? '');
        //                     $('#monday_video_start_time_error').html(resObj.errors.monday_video_start_time ?? '');
        //                     $('#monday_video_end_time_error').html(resObj.errors.monday_video_end_time ?? '');
        //                     $('#tuesday_video_start_time_error').html(resObj.errors.tuesday_video_start_time ?? '');
        //                     $('#tuesday_video_end_time_error').html(resObj.errors.tuesday_video_end_time ?? '');
        //                     $('#wednesday_video_start_time_error').html(resObj.errors.wednesday_video_start_time ?? '');
        //                     $('#wednesday_video_end_time_error').html(resObj.errors.wednesday_video_end_time ?? '');
        //                     $('#thursday_video_start_time_error').html(resObj.errors.thursday_video_start_time ?? '');
        //                     $('#thursday_video_end_time_error').html(resObj.errors.thursday_video_end_time ?? '');
        //                     $('#friday_video_start_time_error').html(resObj.errors.friday_video_start_time ?? '');
        //                     $('#friday_video_end_time_error').html(resObj.errors.friday_video_end_time ?? '');
        //                     $('#saturday_video_start_time_error').html(resObj.errors.saturday_video_start_time ?? '');
        //                     $('#saturday_video_end_time_error').html(resObj.errors.saturday_video_end_time ?? '');
        //                 }
        //             },
        //             error : function (error) {
        //                 Swal.fire({
        //                     icon: 'error',
        //                     title: 'Validation error',
        //                     text: 'Unable to Process Check missing fields',
        //                     }).then((result) => {
        //                         window.location = "profile-view"
        //                 });
        //             }
        //         });
        //     }
        //     return false;
        // });

        // function time_slot(index) {
        //     var doctor_id           = $('#doctor_id').val();
        //     var time_slot_interval  = $('#time_slot_interval').val();
        //     var booking_start_time  = $('#'+index+'_video_start_time').val();
        //     var booking_end_time    = $('#'+index+'_video_end_time').val();
        //     var video_is_available  = $('#'+index+'_video_is_available:checked').val();
        //     var start_time          = moment(booking_start_time, 'hh:mm A').format('HH:mm');
        //     var end_time            = moment(booking_end_time, 'hh:mm A').format('HH:mm');

        //     if ((start_time != 'Invalid date') && (end_time != 'Invalid date') && (time_slot_interval != '') && (video_is_available == 1) ) {
        //         if (start_time <= end_time) {
        //             $.ajax({
        //                 type: 'POST',
        //                 url: './includes/functions.php?action=getVideoTimeSlotList',
        //                 data : {time_slot_interval:time_slot_interval,booking_start_time:booking_start_time,booking_end_time:booking_end_time, index:index,doctor_id:doctor_id},
        //                 success : function (response) {
        //                     $('#'+index+'_times_list_div').html(response);
        //                 }
        //             });
        //             $('#'+index+'_times_list_div').removeClass('d-none');

        //         } else {
        //             $('#'+index+'_times_list_div').addClass('d-none');
        //             $('#'+index+'_times_list_div').html('');
        //         }   
        //     } else {
        //         $('#'+index+'_times_list_div').html('');
        //     }
        // }

        // $('.check_time_list_validate').on('change', function (e) {
        //     var index   = $(this).attr("data-index");
        //     time_slot(index);
        // });

        // $('.timepicker').datetimepicker({ 
        //     format: 'hh:mm A',
        // });

        

        // $(".timepicker").on("dp.change", function (e) {
        //     var index   = $(this).attr("data-index");
        //     time_slot(index);
        // });

        // $(':checkbox:checked').each(function() {
        //     var index   = $(this).attr("data-index");
        //     time_slot(index);
        // });
        
        // $("#time_slot_interval").on("change", function(e) {
        //     $(':checkbox:checked').each(function() {
        //         var index   = $(this).attr("data-index");
        //         time_slot(index);
        //     });
        // });

        $("#addSpecialist").submit(function(e){
            e.preventDefault();
            if ( $(this).parsley().isValid() )
            {
            var formData = new FormData(this);
            $.ajax({
                type: 'POST',
                url: './includes/functions.php?action=add_specialist',
                data: formData,
                cache: false,
                processData: false,
                contentType: false,
                beforeSend: function(){
                $('#addSpecialiststatus').html('<p class="text-center"><i class="fa fa-spinner fa-spin"></i> Please wait as we process..</p>').fadeIn();
                },
                success : function(res){
              
                    let resObj = JSON.parse(res);
                    Swal.fire({
                    icon: resObj.icon,
                    title: resObj.title,
                    text: resObj.msg,
                    // footer: '<a href="">Why do I have this issue?</a>'
                    }).then((result) => {
                        window.location = "profile-view"
                    })
                   // $('#clinicStatus').html("").fadeIn();
                    // window.location = "profile-view"
                
                }
            });
            }
            return false;
        });

        $(".delSpeciality").on("click",function(){
            var speciality = $(this).data("speciality");
            $.ajax({
                type: 'POST',
                url: './includes/functions.php?action=deleteSpeciality',
                data: {speciality:speciality},
                success : function(res){
                    let resObj = JSON.parse(res);
                    Swal.fire({
                        icon: resObj.icon,
                        title: resObj.title,
                        text: resObj.msg,
                    }).then((result) => {
                        window.location = "profile-view"
                    });
                }
            });
        return false;
        });

        $("#galleryAdd").submit(function(e){
            e.preventDefault();
            if ( $(this).parsley().isValid() )
            {
            var formData = new FormData(this);
            $.ajax({
                type: 'POST',
                url: './includes/functions.php?action=galleryAdd',
                data: formData,
                cache: false,
                processData: false,
                contentType: false,
                beforeSend: function(){
                $('#gallerystatus').html('<p class="text-center"><i class="fa fa-spinner fa-spin"></i> Please wait as we process..</p>').fadeIn();
                },
                success : function(res){
              
                    let resObj = JSON.parse(res);
                    Swal.fire({
                    icon: resObj.icon,
                    title: resObj.title,
                    text: resObj.msg,
                    // footer: '<a href="">Why do I have this issue?</a>'
                    }).then((result) => {
                        window.location = "profile-view"
                    })
                   // $('#clinicStatus').html("").fadeIn();
                    // window.location = "profile-view"
                
                }
            });
            }
            return false;
        });

        $("#publish_website").click(function(e){
            var wdid = $(this).data('wdid');
            $.ajax({
                type: 'POST',
                url: './includes/functions.php?action=publish',
                data: {wdid:wdid},
                success : function(res){
                    let resObj = JSON.parse(res);
                    if (resObj.icon=='success')
                    {
                        Swal.fire({
                            icon: resObj.icon,
                            title: resObj.title,
                            text: resObj.msg,
                        }).then((result) => {
                            window.location = "profile-view"
                        });
                    }
                    else
                    {
                        Swal.fire({
                            icon: resObj.icon,
                            title: resObj.title,
                            text: resObj.msg,
                        }).then((result) => {
                            window.location = "profile-view"
                        });
                    }
                }
            });        
        });
        $("#unpublish_website").click(function(e){
            var wdid = $(this).data('wdid');
            $.ajax({
                type: 'POST',
                url: './includes/functions.php?action=unpublish',
                data: {wdid:wdid},
                success : function(res){
                    let resObj = JSON.parse(res);
                    if (resObj.icon=='success')
                    {
                        Swal.fire({
                            icon: resObj.icon,
                            title: resObj.title,
                            text: resObj.msg,
                        }).then((result) => {
                            window.location = "profile-view"
                        });
                    }
                    else
                    {
                        Swal.fire({
                            icon: resObj.icon,
                            title: resObj.title,
                            text: resObj.msg,
                        }).then((result) => {
                            window.location = "profile-view"
                        });
                    }
                }
            });        
        });

       $(".delClinic").on("click",function(){

            var clinicid = $(this).data("clinicid");
            $.ajax({
                type: 'POST',
                url: './includes/functions.php?action=deleteclinic',
                data: {clinicid:clinicid},
                success : function(res){
                    let resObj = JSON.parse(res);
                   
                        Swal.fire({
                            icon: resObj.icon,
                            title: resObj.title,
                            text: resObj.msg,
                        }).then((result) => {
                            window.location = "profile-view"
                        });
                    
                }
            });  
            return false;

       }); 

        $(".delGallery").on("click",function(){

            var galleryid = $(this).data("galleryid");
            var galleryname = $(this).data("galleryname");
            $.ajax({
                type: 'POST',
                url: './includes/functions.php?action=deletegallery',
                data: {galleryid:galleryid,galleryname:galleryname},
                success : function(res){
                    let resObj = JSON.parse(res);
                
                        Swal.fire({
                            icon: resObj.icon,
                            title: resObj.title,
                            text: resObj.msg,
                        }).then((result) => {
                            window.location = "profile-view"
                        });
                    
                }
            });  
            return false;

        }); 


        $(".delVideo").on("click",function(){

            var videoid = $(this).data("videoid");
            $.ajax({
                type: 'POST',
                url: './includes/functions.php?action=deletevideo',
                data: {videoid:videoid},
                success : function(res){
                    let resObj = JSON.parse(res);
                
                        Swal.fire({
                            icon: resObj.icon,
                            title: resObj.title,
                            text: resObj.msg,
                        }).then((result) => {
                            window.location = "profile-view"
                        });
                    
                }
            });  
            return false;

        }); 
    });
    </script>

</body>
</html> 