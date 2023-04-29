<?php 
$title = "Profrea";
$description = "";
$keywords = "";
$page = 1;
include_once('header.php');

require_once('vendor/autoload.php');
use App\Classes\RealEstate\Spaces;
$real_estate = new Spaces();
$allData = $real_estate->viewDataWithSpaceFilter('Institute');

?>

<section class="bg-video-layout">
    <div class="container">
        <div class="row pt-5 pb-5 align-items-center">
            <div class="col-md-6">
                <div class="ratio ratio-16x9">
                    <iframe width="560" height="315" src="https://www.youtube.com/embed/6v7Qu4BhVS4" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                </div>
            </div>
            <div class="col-md-6">
                <h2 class="pract-head f1">One-point solution for Educational Professionals</h2>
                <p class="ft-16 pt-4 text-grey">Book Coaching centers directly from Website on hourly basis</p>
                <div class="explore-clinicsbtn mt-5">
                    <a href="spaces">Explore Centers</a>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="bg-how-itworks">
    <div class="container">
        <div class="row pt-5 pb-5">
            <div class="col-md-12">
                <h1 class="benefit-head f1 text-center">How It Works</h1>
                <div class="time-lineevents pt-5">
                    <!-- <div class="d-flex justify-content-center">
                        <div class="timeline-horizontal d-flex w-100">
                            <div class="event current completed">
                                <span class="dot"> </span>
                                <span class="stage-name f1 ft-18 fw-bold pt-4">
                                Select clinic
                                </span>
                            </div>
                            <div class="event completed">
                                <span class="dot"> </span>
                                <span class="stage-name f1 ft-18 fw-bold pt-4">
                                Customize plans
                                </span>
                            </div>
                            <div class="event completed">
                                <span class="dot"> </span>
                                <span class="stage-name f1 ft-18 fw-bold pt-4">
                                Visit/Book clinic
                                </span>
                            </div>
                        
                            <div class="event completed">
                                <span class="dot"> </span>
                                <span class="stage-name f1 ft-18 fw-bold pt-4">
                                Earn 2X
                                </span>
                            </div>                        
                        </div>
                    </div> -->
                    <div class="row pt-3">
                        <div class="col-md-3 col-sm-6 d-flex align-self-stretch pb-4 pb-md-0">
                            <div class="timebox text-center w-100 active">
                                <h5 class="stage-name f1 ft-18 fw-bold pb-4">
                                Select clinic
                                </h5>
                                <img src="images/time1.png" class="img-fluid " alt="" title="" />
                                <p class="timepara text-grey ft-16 pt-3">Select workspace which is convenient or nearby to your location</p>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 d-flex align-self-stretch pb-4 pb-md-0">
                            <div class="timebox text-center w-100 active">
                            <h5 class="stage-name f1 ft-18 fw-bold pb-4">
                            Customize plans
                                </h5>
                                <img src="images/time2.png" class="img-fluid " alt="" title="" />
                                <p class="timepara text-grey ft-16 pt-3">Customize your own plan choose days and hrs in the week you want to use as per your need</p>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 d-flex align-self-stretch pb-4 pb-md-0">
                            <div class="timebox text-center w-100 active">
                            <h5 class="stage-name f1 ft-18 fw-bold pb-4">
                            Visit/Book clinic
                                </h5>
                                <img src="images/time3.png" class="img-fluid " alt="" title="" />
                                <p class="timepara text-grey ft-16 pt-3">Visit selected workspace or book right away</p>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 d-flex align-self-stretch pb-4 pb-md-0">
                            <div class="timebox text-center w-100 active">
                            <h5 class="stage-name f1 ft-18 fw-bold pb-4">
                            Earn 2X
                                </h5>
                                <img src="images/time4.png" class="img-fluid " alt="" title="" />
                                <p class="timepara text-grey ft-16 pt-3">Earn 2X of what you earn by reaching upto 10,000+ students</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="bg-benefits">
    <div class="container">
        <div class="row pt-5">
            <div class="col-md-12 text-center pb-5">
                <h1 class="benefit-head f1">Benefits Of Profrea?</h1>
            </div>
            <div class="col-md-3 mb-5 d-flex align-self-stretch">
                <div class="benefit-box w-100 text-center">
                    <img src="images/b1.png" class="img-fluid" alt="" title="" />
                    <h4 class="ft-16 pt-3 text-grey">Zero investment</h4>
                </div>
            </div>
            <div class="col-md-3 mb-5 d-flex align-self-stretch">
                <div class="benefit-box w-100 text-center">
                    <img src="images/b2.png" class="img-fluid" alt="" title="" />
                    <h4 class="ft-16 pt-3 text-grey">No long term Commitment</h4>
                </div>
            </div>
            <div class="col-md-3 mb-5 d-flex align-self-stretch">
                <div class="benefit-box w-100 text-center">
                    <img src="images/b3.png" class="img-fluid" alt="" title="" />
                    <h4 class="ft-16 pt-3 text-grey">Storage Space</h4>
                </div>
            </div>
           
            <div class="col-md-3 mb-5 d-flex align-self-stretch">
                <div class="benefit-box w-100 text-center">
                    <img src="images/b5.png" class="img-fluid" alt="" title="" />
                    <h4 class="ft-16 pt-3 text-grey">Referral support</h4>
                </div>
            </div>
            <div class="col-md-3 mb-5 d-flex align-self-stretch">
                <div class="benefit-box w-100 text-center">
                    <img src="images/b6.png" class="img-fluid" alt="" title="" />
                    <h4 class="ft-16 pt-3 text-grey">Branding</h4>
                </div>
            </div>
            
            <div class="col-md-3 mb-5 d-flex align-self-stretch">
                <div class="benefit-box w-100 text-center">
                    <img src="images/b8.png" class="img-fluid" alt="" title="" />
                    <h4 class="ft-16 pt-3 text-grey">Attendance management Software</h4>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="similar-spaces">
    <div class="container">
        <div class="row pt-5">
            <div class="col-md-12 text-center">
                <h1 class="similar-spaces f1 fw-bold">Explore Our Spaces</h1>
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
                                <div class="text-center"><img src="<?php echo $image; ?>" class="img-fluid w-75" alt="" title="" /></div>
                                <div class="grid-spacecontbox">
                                    <h2 class="grid-spacetitle fw-bold text-blue f1 mb-0"><?php echo $oneData->ws_name; ?></h2>
                                    <div class="row align-items-center pt-2">
                                        <div class="col-md-6 col-6 p-0 p-lg-2">
                                            <p class="text-grey ft-14 mb-0">Price</p>
                                            <h6 class="rate-title ft-18"><?php echo $oneData->hourly_charges; ?> per hour</h6>
                                        </div>
                                        <div class="col-md-6 col-6 p-0">
                                            <p class="text-grey ft-14 mb-0">Landmark</p>
                                            <h6 class="rate-title ft-18"><?php echo $oneData->landmark; ?></h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                    <!-- <div class="item ms-3">
                        <div class="space-gridbox">
                            <div class="text-center"><img src="images/common1.png" class="img-fluid w-75" alt="" title="" /></div>
                            <div class="grid-spacecontbox">
                                <h2 class="grid-spacetitle fw-bold text-blue f1 mb-0">Sector 30</h2>
                                <div class="row align-items-center pt-2">
                                    <div class="col-md-6 col-6 p-0 p-lg-2">
                                        <p class="text-grey ft-14 mb-0">Price</p>
                                        <h6 class="rate-title ft-18">500 per hour</h6>
                                    </div>
                                    <div class="col-md-6 col-6 p-0">
                                        <p class="text-grey ft-14 mb-0">Landmark</p>
                                        <h6 class="rate-title ft-18">Bakhtawar Chawk</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="item ms-3">
                        <div class="space-gridbox">
                            <div class="text-center"><img src="images/common1.png" class="img-fluid w-75" alt="" title="" /></div>
                            <div class="grid-spacecontbox">
                                <h2 class="grid-spacetitle fw-bold text-blue f1 mb-0">Sector 30</h2>
                                <div class="row align-items-center pt-2">
                                    <div class="col-md-6 col-6 p-0 p-lg-2">
                                        <p class="text-grey ft-14 mb-0">Price</p>
                                        <h6 class="rate-title ft-18">500 per hour</h6>
                                    </div>
                                    <div class="col-md-6 col-6 p-0">
                                        <p class="text-grey ft-14 mb-0">Landmark</p>
                                        <h6 class="rate-title ft-18">Bakhtawar Chawk</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="item ms-3">
                        <div class="space-gridbox">
                            <div class="text-center"><img src="images/common1.png" class="img-fluid w-75" alt="" title="" /></div>
                            <div class="grid-spacecontbox">
                                <h2 class="grid-spacetitle fw-bold text-blue f1 mb-0">Sector 30</h2>
                                <div class="row align-items-center pt-2">
                                    <div class="col-md-6 col-6 p-0 p-lg-2">
                                        <p class="text-grey ft-14 mb-0">Price</p>
                                        <h6 class="rate-title ft-18">500 per hour</h6>
                                    </div>
                                    <div class="col-md-6 col-6 p-0">
                                        <p class="text-grey ft-14 mb-0">Landmark</p>
                                        <h6 class="rate-title ft-18">Bakhtawar Chawk</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="item ms-3">
                        <div class="space-gridbox">
                            <div class="text-center"><img src="images/common1.png" class="img-fluid w-75" alt="" title="" /></div>
                            <div class="grid-spacecontbox">
                                <h2 class="grid-spacetitle fw-bold text-blue f1 mb-0">Sector 30</h2>
                                <div class="row align-items-center pt-2">
                                    <div class="col-md-6 col-6 p-0 p-lg-2">
                                        <p class="text-grey ft-14 mb-0">Price</p>
                                        <h6 class="rate-title ft-18">500 per hour</h6>
                                    </div>
                                    <div class="col-md-6 col-6 p-0">
                                        <p class="text-grey ft-14 mb-0">Landmark</p>
                                        <h6 class="rate-title ft-18">Bakhtawar Chawk</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> -->
                </div>
                <div class="more-spacebtn text-center mt-5 mb-5">
                    <a href="spaces">More Spaces</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- <section class="about-wrap">
    <div class="container">
        <div class="row pt-5">
            <div class="col-md-12 text-center pt-5">
                <h1 class="about-wrap-head f1">
                    We Can Help You To Find <br />
                    Your Workspace
                </h1>
                <div class="text-center about-explorebtn pt-5 pb-5 mb-5">
                    <a href="contact">Request a callback</a>
                </div>
            </div>
        </div>
    </div>
</section> -->

<?php include_once('footer.php');
?>
