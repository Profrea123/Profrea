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
                <?php if ($res_user) {
                    foreach($res_user as $users) { ?>
                <div class="col-xl-3 col-lg-3 col-md-6 mb-5">
                    <div class="card team border-0 rounded shadow overflow-hidden">
                        <div class="team-person position-relative overflow-hidden text-center">
                            <img <?php if($users['profile_picture'] != '' && file_exists("datafiles/uploads/profiles/".$users['profile_picture'])) {?> src="datafiles/uploads/profiles/<?php echo $users['profile_picture'];?>" <?php } else { ?> src="images/no-image.png"<?php } ?>class="img-fluid doctor-list-img" alt="">
                            <!-- <ul class="list-unstyled team-like">
                                <li><a href="#" class="btn btn-icon btn-pills btn-soft-danger fa fa-heart-o"></a></li>
                            </ul> -->
                        </div>
                        <div class="card-body">
                            <a <?php  if($users['publish_status'] == 1) { ?> href="website?domain=<?php echo $users['domain']; ?>" target="_blank" <?php }  else { ?>  href="#" <?php } ?>class="title text-dark h5 d-block mb-0 doc-name"><?php echo $users['name'];?></a>
                            <small class="text-muted speciality"><?php  if($users['education'] != '') { echo $users['education']; } else { echo '-'; }?></small>
                            <div class="d-flex justify-content-between align-items-center">
                                <ul class="list-unstyled mb-0">
                                    <li class="list-inline-item star-reviews-icon"><i class="fas fa-star text-warning"></i></li>
                                    <li class="list-inline-item star-reviews-icon"><i class="fas fa-star text-warning"></i></li>
                                    <li class="list-inline-item star-reviews-icon"><i class="fas fa-star text-warning"></i></li>
                                    <li class="list-inline-item star-reviews-icon"><i class="fas fa-star text-warning"></i></li>
                                    <li class="list-inline-item star-reviews-icon"><i class="fas fa-star text-warning"></i></li>
                                </ul>
                                <p class="text-muted mb-0">5 Star</p>
                            </div>
                            <ul class="list-unstyled mb-0">
                                <li class="d-flex">
                                    <i class="ri-map-pin-line text-primary align-middle"></i>
                                    <h6 class="clinic-name-h6"><strong><?php  if($users['clinic_name'] != '') { echo $users['clinic_name']; } else { echo '-'; }?></strong> </h6>
                                </li>
                                <li class="d-flex">
                                    <i class="ri-map-pin-line text-primary align-middle"></i>
                                    <small class="text-muted"><?php  if($users['clinic_address'] != '') { echo $users['clinic_address']; } else { echo '-'; }?></small>
                                </li>
                                <li class="d-flex">
                                    <i class="ri-time-line text-primary align-middle"></i>
                                    <small class="text-muted"></small>
                                </li>
                                <li class="d-flex">
                                    <i class="ri-money-dollar-circle-line text-primary align-middle"></i>
                                    <small class="text-muted"> <?php  if(isset($users['video_amount']) != '') { echo $users['video_amount'].' / Visit'; } else { echo '-'; }?> </small>
                                </li>
                            </ul>
                            <ul class="list-unstyled mb-0">
                            <?php if($users['fb_link'] != ''){ ?> <li class="pr-mr-0 list-inline-item"><a href="<?php echo $users['fb_link']; ?>" target="_blank" class="btn btn-icon btn-pills btn-soft-primary fab fa-facebook sm-fb"></a></li> <?php } ?>
                            <?php if($users['twitter_link'] != ''){ ?> <li class="pr-mr-0 list-inline-item"><a href="<?php echo $users['twitter_link']; ?>" target="_blank" class="btn btn-icon btn-pills btn-soft-primary fab fa-twitter sm-tw"></a></li> <?php } ?>
                            <?php if($users['linkedin_link'] != ''){ ?> <li class="pr-mr-0 list-inline-item"><a href="<?php echo $users['linkedin_link']; ?>" target="_blank" class="btn btn-icon btn-pills btn-soft-primary fab fa-linkedin sm-li"></a></li> <?php } ?>
                            <?php if($users['insta_link'] != ''){ ?> <li class="pr-mr-0 list-inline-item"><a href="<?php echo $users['insta_link']; ?>" target="_blank" class="btn btn-icon btn-pills btn-soft-primary fab fa-instagram sm-in"></a></li> <?php } ?>
                            </ul>
                        </div>
                    </div>
                </div>
                <?php } } else { ?>
                    <p>No doctors found</p>

                <?php } ?>
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
    
