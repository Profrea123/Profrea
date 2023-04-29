<?php 
$title = "Profrea";
$description = "";
$keywords = "";
$page = 1;
include_once('header.php');

require_once('src/Classes/Model/Database.php');
require_once('vendor/autoload.php');
use App\Classes\Model\Database;
$db_connection = new Database;

$sql_user = "SELECT clinic_details.name as clinic_name, clinic_details.address as clinic_address, users.*, website_details.* FROM users 
                LEFT JOIN clinic_details ON clinic_details.user_id = users.id 
                LEFT JOIN website_details ON website_details.user_id = users.id 
            WHERE users.profession_id = 1 AND users.is_verified = 1 AND website_details.publish_status = 1 group BY users.id";
$con_user = $db_connection->getDbHandler()->query($sql_user);
$res_user = [];
if($con_user)
{
    $res_user = $con_user->fetchAll();
}

?>
    <section class="bg-space-header">
        <div class="container">         
           <div class="row pt-5">
               <div class="col-md-12 text-center">
                   <h1 class="space-headtitle f1 fw-bold">Doctor Consultation</h1>
                   <p class="space-para text-grey mb-3">Book your appointments with minimum wait-time</p>
               </div>
           </div>
        </div>
        <div class="container">
            <div class="row align-items-center mt-3">
                <div class="col-xl-9 col-lg-9 col-md-9 mb-5 shadow m_auto">
                    <div class="card team border-0 rounded overflow-hidden">
                        <div class="card-body doc-list-bbottom">
                            <div class="row">
                                <div class="col-xl-2 col-lg-2 col-md-2">
                                    <div class="team-person position-relative overflow-hidden text-center">
                                        <img src="images/avatar.jpg" class="img-fluid doctor-list-img" alt="">
                                        <!-- <ul class="list-unstyled team-like">
                                            <li><a href="#" class="btn btn-icon btn-pills btn-soft-danger fa fa-heart-o"></a></li>
                                        </ul> -->
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6">
                                    <h3><a href="" target="_blank" class="title text-dark h5 d-block mb-0 doc-name">Dr. Deepak Kumar</a></h3>
                                    <div><small>General Physician</small></div>
                                    <div><small>40 years experience overall</small></div>
                                    <div><small><span class="fw-600">Enclave Nagar, Mumbai</span> <span class="clinic-name"> Kausalya Medical Center</span></small></div>
                                    <div><small>₹500 Consultation fee at clinic</small></div>
                                </div>
                                <div class="col-xl-4 col-lg-4 col-md-4">
                                    <div class="booknow-btn mt-5 mb-3 text-end"><a href="">Book Now</a></div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body doc-list-bbottom">
                            <div class="row">
                                <div class="col-xl-2 col-lg-2 col-md-2">
                                    <div class="team-person position-relative overflow-hidden text-center">
                                        <img src="images/avatar.jpg" class="img-fluid doctor-list-img" alt="">
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6">
                                    <h3><a href="" target="_blank" class="title text-dark h5 d-block mb-0 doc-name">Dr. Raja kumaran</a></h3>
                                    <div><small>MBBS, DGO, DNB, FICOG, FMAS</small></div>
                                    <div><small>26 years experience overall</small></div>
                                    <div><small><span class="fw-600">Malviya Nagar, New Delhi</span> <span class="clinic-name">Devashri Dental Clinic</span></small></div>
                                    <div><small>₹300 Consultation fee at clinic</small></div>
                                </div>
                                <div class="col-xl-4 col-lg-4 col-md-4">
                                    <div class="booknow-btn mt-5 mb-3 text-end"><a href="">Book Now</a></div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body doc-list-bbottom">
                            <div class="row">
                                <div class="col-xl-2 col-lg-2 col-md-2">
                                    <div class="team-person position-relative overflow-hidden text-center">
                                        <img src="images/avatar.jpg" class="img-fluid doctor-list-img" alt="">
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6">
                                    <h3><a href="" target="_blank" class="title text-dark h5 d-block mb-0 doc-name">Dr. Sujatha Akilananth</a></h3>
                                    <div><small>MBBS, Pediatric</small></div>
                                    <div><small>15 years experience overall</small></div>
                                    <div><small><span class="fw-600">Bourville Nagar, KA</span> <span class="clinic-name"> Sri Meenu Hospital </span></small></div>
                                    <div><small>₹300 Consultation fee at clinic</small></div>
                                </div>
                                <div class="col-xl-4 col-lg-4 col-md-4">
                                    <div class="booknow-btn mt-5 mb-3 text-end"><a href="">Book Now</a></div>
                                </div>
                            </div>
                        </div>
                    </div>  
                </div>
            </div>
        </div>  
    </section>   


    <section class="about-wrap">
        <div class="container">
            <div class="row pt-5">
                <div class="col-md-12 text-center pt-5">
                    <h1 class="about-wrap-head f1">We Can Help You To Find <br> Your Workspace</h1>
                    <div class="text-center about-explorebtn pt-5 pb-5 mb-5">
                        <a href="contact">Request a callback</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    

<?php include_once('footer.php');?>    
<script>
    

</script>
    
