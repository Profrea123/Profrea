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
$title = 'Website View';
$description = 'Profrea';
// if (isset($_GET['id'])) 
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
        $sql_user = "SELECT users.name,users.mobileNo,users.email,users.profile_picture,users.gender_id,gender.name as gender,city.name as city,users.profession_id as profession_id FROM users left join gender on gender.id=users.gender_id left join city on city.id=users.city WHERE users.id = $user_id";
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

        $sql_user_detail = "SELECT * FROM user_details as ud left join operating_specialty as os on os.id = ud.speciality WHERE ud.user_id = $user_id";
        $res_user_detail = $db_connection->getDbHandler()->query($sql_user_detail);
        print_r($sql_user_detail);
        if($res_user_detail)
        {
            $row_user_detail = $res_user_detail->fetch();
            
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
        header('Location: login');
    }
}
else
{
    header('Location: login');
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="keywords" itemprop="keywords" content="<?php echo $keywords; ?>" />
    <meta name="description" itemprop="description" content="<?php echo $description; ?>">
    <meta name="robots" content="index, follow">
    <title><?php echo $title; ?></title>
    <link rel="icon" type="image/png" href="images/favicon.png">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/custom.css">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/owl.carousel.css">
    <link rel="stylesheet" type="text/css" href="css/owl.theme.default.min.css">
</head>
<body>
    <!-- header -->
    <header class="personal-profile shadow-sm">
        <div class="container">
            <div class="row pt-4 pb-4 align-items-center">
                <div class="col-lg-3 col-md-4 col-7 text-md-start text-center ">
                    <a href="index"><h1 class="logo mb-0">Profrea</h1></a>
                </div>
                <div class="col-lg-6 col-md-6  text-end pt-2 pb-2 pt-md-0 pb-md-0 d-none d-md-block">
                    <ul class="list-group list-group-horizontal list-unstyled top-socialheader">
                        <li><a href="<?php echo $row_website_details["fb_link"]; ?>"><i class="text-grey ft-18 fab fa-facebook-f"></i></a></li>
                        <li><a href="<?php echo $row_website_details["twitter_link"]; ?>"><i class="text-grey ft-18 fab fa-instagram"></i></a></li>
                        <li><a href="<?php echo $row_website_details["insta_link"]; ?>"><i class="text-grey ft-18 fab fa-twitter"></i></a></li>
                        <li><a href="#"><i class="text-grey ft-18 fab fa-google-plus-g"></i></a></li>
                        <li><a href="<?php echo $row_website_details["linkedin_link"]; ?>"><i class="text-grey ft-18 fab fa-linkedin-in"></i></a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-2 col-5 text-center mt-2 mt-md-0">
                    <div class="clinic-b">
                        <a href="#bg-proclinic">Clinics</a>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- self page section started -->
    <section class="bg-selfprofile">
        <div class="container">
            <div class="row pt-5 pb-5">
                <div class="col-lg-7 col-md-12">
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-4">
                            <img src="datafiles/uploads/profiles/<?php echo $profile_picture; ?>" class="img-fluid" alt="" title="">
                        </div>
                        <div class="col-lg-8 col-md-8 col-sm-8">
                            <h1 class="f1 ft-32 fw-bold"><?php echo $row_user["name"]; ?>,<span class="text-grey ft-14">Verified By <a href="" class="text-blue ft-14">Profrea</a></span></h1>
                            <h3 class="degree-studies ft-16 pb-2 pt-2"><?php echo ($row_user_detail !== false?$row_user_detail["education"]:""); ?></h3>
                            <h6 class="ft-16 pb-2"><span class="text-grey">Specialist:</span> <?php echo ($row_user_detail !== false?$row_user_detail["name"]:""); ?></h6>
                            <h6 class="ft-16 pb-2"><span class="text-grey">Experience:</span> <?php echo ($row_user_detail !== false?$row_user_detail["experience"]:"0"); ?> Years Experience Overall</h6>
                            <!-- <div>
                                <span><i class="text-blue ft-16 fas fa-star pe-2"></i></span>
                                <span><i class="text-blue ft-16 fas fa-star pe-2"></i></span>
                                <span><i class="text-blue ft-16 fas fa-star pe-2"></i></span>
                                <span><i class="text-blue ft-16 fas fa-star pe-2"></i></span>
                                <span><i class="text-blue ft-16 fas fa-star pe-2"></i></span>
                                <span class="ft-16 text-grey">400 Ratings</span>
                            </div> -->
                        </div>
                        <div class="col-lg-12 pt-5 pb-md-5 ownprofile-tab">
                            <ul class="nav nav-tabs  df" id="myTab" role="tablist">
                                <li class="nav-item me-2" role="presentation">
                                    <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Story</button>
                                </li>
                                <li class="nav-item me-2" role="presentation">
                                    <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Services</button>
                                </li>
                                <li class="nav-item me-2" role="presentation">
                                    <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button" role="tab" aria-controls="contact" aria-selected="false">Reviews</button>
                                </li>
                                <li class="nav-item me-2" role="presentation">
                                    <button class="nav-link" id="quali-tab" data-bs-toggle="tab" data-bs-target="#quali" type="button" role="tab" aria-controls="quali" aria-selected="false">Qualification</button>
                                </li>
                                <li class="nav-item me-2" role="presentation">
                                    <button class="nav-link" id="exp-tab" data-bs-toggle="tab" data-bs-target="#exp" type="button" role="tab" aria-controls="exp" aria-selected="false">Experience</button>
                                </li>
                            </ul>
                            <div class="tab-content  df" id="myTabContent">
                                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                <p class="ft-16 text-grey p-3"><?php 
                                    echo $row_website_details["story"] ; 
                                    ?></p>
                                </div>
                                <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                <p class="ft-16 text-grey p-3"><?php 
                                    echo $row_website_details["rowservice"] ; 
                                    ?></p>
                                </div>
                                <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                                <p class="ft-16 text-grey p-3"></p>
                                </div>
                                <div class="tab-pane fade" id="quali" role="tabpanel" aria-labelledby="quali-tab">
                                <p class="ft-16 text-grey p-3"></p>
                                </div>
                                <div class="tab-pane fade" id="exp" role="tabpanel" aria-labelledby="exp-tab">
                                <p class="ft-16 text-grey p-3"></p>
                                </div>
                            </div>
                            <!-- only on mobile view -->
                            <div class="accordion d-block d-md-none" id="accordionExample">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingOne">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                       Story
                                    </button>
                                    </h2>
                                    <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                    <p class="ft-16 text-grey p-3"><?php 
                                    echo $row_website_details["story"] ; 
                                    ?></p>
                                    </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingTwo">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                       Services
                                    </button>
                                    </h2>
                                    <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                    <p class="ft-16 text-grey p-3"><?php 
                                    echo $row_website_details["rowservice"] ; 
                                    ?></p>
                                    </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingThree">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                        Reviews
                                    </button>
                                    </h2>
                                    <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <strong>This is the third item's accordion body.</strong> It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
                                    </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingFour">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                        Qualification
                                    </button>
                                    </h2>
                                    <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <strong>This is the third item's accordion body.</strong> It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
                                    </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingFive">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                        Experience
                                    </button>
                                    </h2>
                                    <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <strong>This is the third item's accordion body.</strong> It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 col-md-12">
                    <!-- <div class="book-appt">
                        <div class="book-appt-slider p-3 pb-0">
                            <h2 class="f1 ft-24 fw-bold">Book An Appointment</h2>
                            <div id="owl-book" class="owl-carousel owl-theme pt-4">
                                <div class="item text-center">
                                   <h2 class="ft-16">Today</h2>
                                   <p class="ft-14 active-class pb-1 mb-0">9 Slots Available</h2>
                                </div>
                                <div class="item text-center">
                                   <h2 class="ft-16">Tomorrow</h2>
                                   <p class="ft-14 mb-0">9 Slots Available</h2>
                                </div>   
                                <div class="item text-center">
                                   <h2 class="ft-16">Fri 29th,Oct</h2>
                                   <p class="ft-14 mb-0">9 Slots Available</h2>
                                </div>
                            </div>
                        </div>
                        <div class="select-timebox pt-4 p-3">
                            <h2 class="ft-16">Morning <span class="text-grey">(5 Slots)</span></h2>
                            <div class="row pt-3 align-items-center">
                                <div class="col-lg-3 col-md-3 col-4 pb-3 text-center">
                                    <div class="timebox-selctive p-2 active">
                                        <p class="mb-0 pb-0">9 AM</p>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3 col-4 pb-3 text-center">
                                    <div class="timebox-selctive p-2">
                                        <p class="mb-0 pb-0">9 AM</p>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3 col-4 pb-3 text-center">
                                    <div class="timebox-selctive p-2">
                                        <p class="mb-0 pb-0">9 AM</p>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3 col-4 pb-3 text-center">
                                    <div class="timebox-selctive p-2">
                                        <p class="mb-0 pb-0">9 AM</p>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3 col-4 pb-3 text-center">
                                    <div class="timebox-selctive p-2">
                                        <p class="mb-0 pb-0">9 AM</p>
                                    </div>
                                </div>
                            </div>
                            <h2 class="ft-16 pt-3">Evening <span class="text-grey">(4 Slots)</span></h2>
                            <div class="row pt-3 align-items-center">
                                <div class="col-lg-3 col-md-3 col-4 pb-3 text-center">
                                    <div class="timebox-selctive p-2 active">
                                        <p class="mb-0 pb-0">9 AM</p>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3 col-4 pb-3 text-center">
                                    <div class="timebox-selctive p-2">
                                        <p class="mb-0 pb-0">9 AM</p>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3 col-4 pb-3 text-center">
                                    <div class="timebox-selctive p-2">
                                        <p class="mb-0 pb-0">9 AM</p>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3 col-4 pb-3 text-center">
                                    <div class="timebox-selctive p-2">
                                        <p class="mb-0 pb-0">9 AM</p>
                                    </div>
                                </div>
                            </div>
                            <div class="appoint-timebox text-center pt-4 pb-4">
                                <a href="mail">Book An Appointment</a>
                            </div>
                        </siv>
                    </div> -->
                </div>
            </div>
        </div>
    </section>
    <!-- self page section ended -->

    <!-- profrea clinic -->
    <!-- <section class="bg-proclinic" id="bg-proclinic">
        <div class="container">
            <div class="row pt-5 pb-5">
                <div class="col-md-12 text-center pb-5">
                    <h1 class="ft-32 f1 fw-bold">Profrea Clinic</h1>
                </div>
                <div class="col-md-6">
                    <h1 class="ft-24">Profession Based Coworking Space</h1>
                    <div class="clinic-dir ft-14 pt-2">
                        <i class="fa fa-map-marker text-blue pe-2"></i> 317GF Sector 8, Panchkula, Haryana (134109)
                    </div>
                    <div class="row pt-4">
                        <div class="col-md-4 col-6 mb-3 mb-md-0">
                            <img src="images/common1.png" class="img-fluid" alt="" title="">
                        </div>
                        <div class="col-md-4 col-6 mb-3 mb-md-0">
                            <img src="images/common1.png" class="img-fluid" alt="" title="">
                        </div>
                        <div class="col-md-4 col-6 mb-3 mb-md-0">
                            <img src="images/common1.png" class="img-fluid" alt="" title="">
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d250646.68136289966!2d76.8271453355799!3d11.012014524273273!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3ba859af2f971cb5%3A0x2fc1c81e183ed282!2sCoimbatore%2C%20Tamil%20Nadu!5e0!3m2!1sen!2sin!4v1635058631669!5m2!1sen!2sin" width="100%" height="280" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                </div>
            </div>
        </div>
    </section> -->
    <!-- profrea clinic -->

    <!-- own clinic -->
    <section class="bg-ownclinic">
        <div class="container">
            <div class="row pt-md-5 pb-5">
                <div class="col-md-12 text-center pb-5">
                    <h1 class="ft-32 f1 fw-bold">Own Clinic</h1>
                </div>
                <?php
                    foreach($row_clinic_details as $clinic){
                        $images = json_decode($clinic["images"]);
                ?>
                    <div class="col-md-6">
                        <h1 class="ft-24"><?php echo $clinic["name"]; ?></h1>
                        <div class="clinic-dir ft-14 pt-2">
                            <i class="fa fa-map-marker text-blue pe-2"></i> <?php echo $clinic["address"]; ?>
                        </div>
                        <div class="row pt-4">
                            <?php
                                if($images !== null){
                                    foreach($images as $image){
                            ?>
                            <div class="col-md-4 col-6 mb-3 mb-md-0">
                                <img src="images/common1.png" class="img-fluid" alt="" title="">
                            </div>
                            <?php }} ?>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d250646.68136289966!2d76.8271453355799!3d11.012014524273273!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3ba859af2f971cb5%3A0x2fc1c81e183ed282!2sCoimbatore%2C%20Tamil%20Nadu!5e0!3m2!1sen!2sin!4v1635058631669!5m2!1sen!2sin" width="400" height="280" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                    </div>
                <?php } ?>
            </div>
        </div>
    </section>
    <!-- own clinic -->
<?php 
include_once('footer-client.php');
///include_once('footer.php');
?>