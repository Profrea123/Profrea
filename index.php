
<?php 
echo __DIR__ . '/composer' . '/autoload_real.php'; die;
$title = "Profrea";
$description = "";
$keywords = "";
$page = 1;

include_once('header.php');

require_once('vendor/autoload.php');
use App\Classes\RealEstate\Spaces;
$real_estate = new Spaces();
$allData = $real_estate->viewDataWithSpaceFilter('Clinic'); ?>

<section class="bg-video-layout">
    <div class="container">
        <div class="row pt-5 pb-5 align-items-center">
            <div class="col-md-6">
                <div class="ratio ratio-16x9">
                    <iframe
                        width="560"
                        height="315"
                        src="https://www.youtube.com/embed/tuh-atYeaKM"
                        title="YouTube video player"
                        frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen
                    ></iframe>
                </div>
            </div>
            <div class="col-md-6">
                <h2 class="pract-head f1">One-point solution for Independent Practitioner</h2>
                <p class="ft-16 pt-4 text-grey">Book clinical spaces near you & start or expand your independent practice.</p>
                <div class="explore-clinicsbtn mt-5">
                    <a href="spaces">Explore Clinics</a>
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
                        <div class="col-md-3 col-sm-6 pb-4 pb-md-0 d-flex">
                            <div class="timebox text-center w-100 active d-flex align-self-stretch flex-wrap justify-content-center">
                                <h5 class="stage-name f1 ft-18 fw-bold pb-4 w-100">
                                    Select clinic
                                </h5>
                                <img src="images/time1.png" class="img-fluid" alt="" title="" />
                                <p class="timepara text-grey ft-16 pt-3">Select clinic which is convenient or nearby to your location</p>
                                <div class="explore-clinicsbtn mt-5 mb-4 align-self-end ">
                                    <a href="spaces">Select Clinic </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 pb-4 pb-md-0 d-flex">
                            <div class="timebox text-center w-100 active d-flex align-self-stretch flex-wrap justify-content-center">
                                <h5 class="stage-name f1 ft-18 fw-bold pb-4 w-100">
                                    Customize plans
                                </h5>
                                <img src="images/time2.png" class="img-fluid" alt="" title="" />
                                <p class="timepara text-grey ft-16 pt-3">Customize your own plan choose days and hrs in the week you want to practice as per your need</p>
                                <div class="explore-clinicsbtn mt-5 mb-4 align-self-end ">
                                    <a href="faq?id=faq-3">Learn More</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 pb-4 pb-md-0 d-flex">
                            <div class="timebox text-center w-100 active d-flex align-self-stretch flex-wrap justify-content-center">
                                <h5 class="stage-name f1 ft-18 fw-bold pb-4 w-100">
                                    Visit/Book clinic
                                </h5>
                                <img src="images/time3.png" class="img-fluid" alt="" title="" />
                                <p class="timepara text-grey ft-16 pt-3">Visit selected clinic or book right away</p>
                                <div class="explore-clinicsbtn mt-5 mb-4 align-self-end ">
                                    <a href="spaces">Browse Locations </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 pb-4 pb-md-0 d-flex">
                            <div class="timebox text-center w-100 active d-flex align-self-stretch flex-wrap justify-content-center">
                                <h5 class="stage-name f1 ft-18 fw-bold pb-4 w-100">
                                    Earn 2X
                                </h5>
                                <img src="images/time4.png" class="img-fluid" alt="" title="" />
                                <p class="timepara text-grey ft-16 pt-3">Earn 2X of what you earn by reaching upto 10,000+ patients</p>
                                <div class="explore-clinicsbtn mt-5 mb-4 align-self-end ">
                                    <a href="#mostcommon">Know More</a>
                                </div>
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
                <h1 class="benefit-head f1">Benefits Of Profrea</h1>
            </div>
            <div class="col-md-4 col-6 mb-md-5 mb-3 d-flex align-self-stretch">
                <div class="benefit-box w-100 text-center">
                    <img src="images/b1.png" class="img-fluid" alt="" title="" />
                    <h4 class="ft-16 pt-3 stage-name fw-bold">Zero Investment</h4>
                    <p class="timepara text-grey">You invest ZERO money as capital amount</p>
                </div>
            </div>
            <div class="col-md-4 col-6 mb-md-5 mb-3 d-flex align-self-stretch">
                <div class="benefit-box w-100 text-center">
                    <img src="images/b2.png" class="img-fluid" alt="" title="" />
                    <h4 class="ft-16 pt-3 stage-name fw-bold">No Long Term Commitment  </h4>
                    <p class="timepara text-grey">It’s totally up to you either increase or decrease the number of hours you want to practice. </p>
                </div>
            </div>
            <div class="col-md-4 col-6 mb-md-5 mb-3 d-flex align-self-stretch">
                <div class="benefit-box w-100 text-center">
                    <img src="images/b3.png" class="img-fluid" alt="" title="" />
                    <h4 class="ft-16 pt-3 stage-name fw-bold">Storage Space </h4>
                    <p class="timepara text-grey">Get a dedicated space in your name where you can store your consumables, equipment’s or instruments.</p>
                </div>
            </div>
            <div class="col-md-4 col-6 mb-md-5 mb-3 d-flex align-self-stretch">
                <div class="benefit-box w-100 text-center">
                    <img src="images/b4.png" class="img-fluid" alt="" title="" />
                    <h4 class="ft-16 pt-3 stage-name fw-bold">Customized Website</h4>
                    <p class="timepara text-grey">Build your own website with your own name and clinic brand</p>
                </div>
            </div>
            <div class="col-md-4 col-6 mb-md-5 mb-3 d-flex align-self-stretch">
                <div class="benefit-box w-100 text-center">
                    <img src="images/b5.png" class="img-fluid" alt="" title="" />
                    <h4 class="ft-16 pt-3 stage-name fw-bold">Referral Support </h4>
                    <p class="timepara text-grey">Get multiple referrals from existing Profrea’s doctors panel</p>
                </div>
            </div>
            <!-- <div class="col-md-4 col-6 mb-md-5 mb-3 d-flex align-self-stretch">
                <div class="benefit-box w-100 text-center">
                    <img src="images/b6.png" class="img-fluid" alt="" title="" />
                    <h4 class="ft-16 pt-3 stage-name fw-bold">Branding</h4>
                    <p class="timepara text-grey">You invest ZERO money as capital amount</p>
                </div>
            </div>
            <div class="col-md-4 col-6 mb-md-5 mb-3 d-flex align-self-stretch">
                <div class="benefit-box w-100 text-center">
                    <img src="images/b7.png" class="img-fluid" alt="" title="" />
                    <h4 class="ft-16 pt-3 stage-name fw-bold">24/7 booking Support</h4>
                    <p class="timepara text-grey">You invest ZERO money as capital amount</p>
                </div>
            </div> -->
            <div class="col-md-4 col-6 mb-md-5 mb-3 d-flex align-self-stretch">
                <div class="benefit-box w-100 text-center">
                    <img src="images/b8.png" class="img-fluid" alt="" title="" />
                    <h4 class="ft-16 pt-3 stage-name fw-bold">Clinic Management Software </h4>
                    <p class="timepara text-grey">Go paperless with our software for clinic management</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="bg-commonbenefits" id="mostcommon">
    <div class="container">
        <!-- <div class="row pt-5">
            <div class="col-md-12 text-center">
                <h1 class="benefit-head f1">Most Common Benefits</h1>
            </div>
        </div> -->
        <div class="row bg-greybg mt-5 pt-5 pb-5 p-md-3 justify-content-center">
            <div class="col-lg-4 col-md-6 d-flex align-self-stretch">
                <div class="row align-items-center p-md-4 text-center text-md-start">
                    <div class="col-md-4">
                        <img src="images/j1.png" class="img-fluid" alt="" title="" />
                    </div>
                    <div class="col-md-8">
                        <h3 class="ben-head">Earn 100% OPD Fees </h3>
                    </div>
                    <div class="col-md-12 pt-3">
                        <p class="ft-16 text-grey">Decide your own consultation fee & say bye bye to traditional consultation fee sharing with clinic.</p>
                    </div>
                </div>
                
            </div>
            <div class="col-lg-4 col-md-6 d-flex align-self-stretch">
                <div class="row align-items-center p-md-4 text-center text-md-start">
                    <div class="col-md-4">
                        <img src="images/j2.png" class="img-fluid" alt="" title="" />
                    </div>
                    <div class="col-md-8">
                        <h3 class="ben-head">Clinic listed online with your name </h3>
                    </div>
                    <div class="col-md-12 pt-3">
                        <p class="ft-16 text-grey">Get listed yourself online by your own name or use your own clinic brand name</p>
                    </div>
                </div>
                
            </div>
            <div class="col-lg-4 col-md-6 d-flex align-self-stretch">
                <div class="row align-items-center p-md-4 text-center text-md-start">
                    <div class="col-md-4">
                        <img src="images/j3.png" class="img-fluid" alt="" title="" />
                    </div>
                    <div class="col-md-8">
                        <h3 class="ben-head">Branding in façade </h3>
                    </div>
                    <div class="col-md-12 pt-3">
                        <p class="ft-16 text-grey">Your name gets reflected on façade area of clinic.</p>
                    </div>
                </div>
                
            </div>
            <div class="more-spacebtn text-center mt-5 mb-5">
                <a href="spaces">See details</a>
            </div>
        </div>
    </div>
</section>

<section class="bg-proben">
    <div class="container pt-md-5">
        <!-- <div class="row pt-5">
            <div class="col-md-12 text-center">
                <h1 class="benefit-head f1">Profrea Benefits</h1>
            </div>
        </div> -->
        <div class="row bg-greybg mt-5  justify-content-center">
            <div class="col-md-4 p-0 d-flex align-self-stretch">
                <div class="bg-skyblueglass p-5 text-white text-md-start text-center w-100">
                    <!-- <h5 class="paytitle f1">Pay</h5>
                    <h3 class="rate-o-price f1">
                        <span class="sup-highhead"><sup>₹</sup></span><span class=" rate-o-price-1"> 0</span>
                    </h3>
                    <h5 class="paytitle f1">And Get</h5> -->
                    <img src="images/noticebg-1.png" class="img-fluid d-block d-md-none" alt="">
                </div>
            </div>
            <div class="col-md-8 pt-5 pb-5 ps-md-5 d-flex align-self-stretch">
                <div class="row pt-3">
                    <div class="col-md-6">
                        <div class="row pb-5 pt-md-5 pt-2 align-items-center text-center text-md-start">
                            <div class="col-md-4 col-4">
                                <img src="images/j4.png" class="img-fluid" alt="" title="" />
                            </div>
                            <div class="col-md-8 col-8">
                                <h4 class="ben-head">Headache of bills</h4>
                            </div>
                        </div>
                        <div class="row pb-5 pt-md-5 pt-2 align-items-center text-center text-md-start">
                            <div class="col-md-4 col-4">
                                <img src="images/j6.png" class="img-fluid" alt="" title="" />
                            </div>
                            <div class="col-md-8 col-8">
                                <h4 class="ben-head">Equipment Cost</h4>
                            </div>
                        </div>
                        <div class="row pb-5 pt-md-5 pt-2 align-items-center text-center text-md-start">
                            <div class="col-md-4 col-4">
                                <img src="images/j8.png" class="img-fluid" alt="" title="" />
                            </div>
                            <div class="col-md-8 col-8">
                                <h4 class="ben-head">Initial Brokerage</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row pb-5 pt-md-5 pt-2 align-items-center text-center text-md-start">
                            <div class="col-md-4 col-4">
                                <img src="images/j5.png" class="img-fluid" alt="" title="" />
                            </div>
                            <div class="col-md-8 col-8">
                                <h4 class="ben-head">Capital Investment </h4>
                            </div>
                        </div>
                        <div class="row pb-5 pt-md-5 pt-2 align-items-center text-center text-md-start">
                            <div class="col-md-4 col-4">
                                <img src="images/j7.png" class="img-fluid" alt="" title="" />
                            </div>
                            <div class="col-md-8 col-8">
                                <h4 class="ben-head">Initial Interior Cost</h4>
                            </div>
                        </div>
                        <div class="row pb-5 pt-md-5 pt-2 align-items-center text-center text-md-start">
                            <div class="col-md-4 col-4">
                                <img src="images/j9.png" class="img-fluid" alt="" title="" />
                            </div>
                            <div class="col-md-8 col-8">
                                <h4 class="ben-head">Paying developer for website</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="similar-spaces pt-md-5">
    <div class="container">
        <div class="row pt-5">
            <div class="col-md-12 text-center">
                <h1 class="similar-spaces f1 fw-bold">Explore Our Clinics</h1>
            </div>
            <div class="col-md-12 pt-5">
                <div id="owl-demo" class="owl-carousel owl-theme">
                    <?php
                    foreach ($allData as $oneData) 
                    {
                        $image ="";
                        $fileList = glob("datafiles/spaces/".$oneData->id."/space_image_profile/*"); if(sizeof($fileList)>0) $image = $fileList[0]; ?>
                    <div class="item ms-3">                       
                        <div class="space-gridbox">                            
                            <div class="text-center">
                                <a href="spaces-ind?id=<?php echo $oneData->id; ?>">
                                    <img src="<?php echo $image; ?>" class="img-fluid w-100" alt="" title="" />
                                </a>
                            </div>
                            <div class="grid-spacecontbox">
                                <a href="spaces-ind?id=<?php echo $oneData->id; ?>"><h2 class="grid-spacetitle fw-bold text-blue f1 mb-0"><?php echo $oneData->ws_name; ?></h2></a>
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
                                        <h6 class="rate-title ft-18"><?php echo $oneData->locality; ?></h6>
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
                    <a href="spaces">More Clinics</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- <section class="bg-sliderslick">
    <div class="container pt-md-5">
        <div class="row pt-5">
            <div class="col-md-12 text-center">
                <h1 class="benefit-head f1">Own Clinic Vs Profrea Clinic</h1>
            </div>
            <div class="col-md-12 pt-5">                
                <div class="myslider">
                    
                    <div class="item">                        
                        <div class="row pt-5">
                            <div class="col-md  tp-space d-none d-md-block">
                                <img src="images/thumbs-down.png" class="img-fluid w-100" alt="">
                            </div>
                            <div class="col-md-2 col-4 tp-space">
                                <h6 class="smalltit-grey">Own Clinic</h6>
                                <h1 class="maintit-grey pt-3">Recurring Monthly rents</h1>
                            </div>
                            <div class="col-md-3 col-4 text-center">
                                <h1 class="top-centerhead-slider position-relative">Monthly Rents</h1>    
                                <div class="bottom-lineborder position-relative pt-4"><img src="images/wallet.png" class="img-fluid" alt=""></div>
                            </div>
                            <div class="col-md-2 col-4 tp-space">
                            <h6 class="smalltit-grey">Profrea Clinic</h6>
                                <h1 class="maintit-grey pt-3">No, Pay For What You Use.</h1>                              
                            </div>
                            <div class="col-md tp-space d-none d-md-block">
                                <img src="images/thumbs-up.png" class="img-fluid w-100" alt="">
                            </div>
                        </div>
                    </div>
                    <div class="item">                        
                        <div class="row pt-5">
                            <div class="col-md tp-space d-none d-md-block">
                                <img src="images/thumbs-down.png" class="img-fluid w-100" alt="">
                            </div>
                            <div class="col-md-2 col-4 tp-space">
                                <h6 class="smalltit-grey">Own Clinic</h6>
                                <h1 class="maintit-grey pt-3">Dont Have A Lab Support?</h1>
                            </div>
                            <div class="col-md-3 col-4 text-center">
                                <h1 class="top-centerhead-slider position-relative">Lab Support</h1>    
                                <div class="bottom-lineborder position-relative pt-4"><img src="images/lab.png" class="img-fluid" alt=""></div>
                            </div>
                            <div class="col-md-2 col-4 tp-space">
                            <h6 class="smalltit-grey">Profrea Clinic</h6>
                                <h1 class="maintit-grey pt-3">We Do, In-Clinic Lab Support With Nabl Accredited Lab Partners</h1>                                
                            </div>
                            <div class="col-md tp-space d-none d-md-block">
                                <img src="images/thumbs-up.png" class="img-fluid w-100" alt="">
                            </div>
                        </div>
                    </div>
                    <div class="item">                        
                        <div class="row pt-5">
                            <div class="col-md tp-space d-none d-md-block">
                                <img src="images/thumbs-down.png" class="img-fluid w-100" alt="">
                            </div>
                            <div class="col-md-2 col-4 tp-space">
                                <h6 class="smalltit-grey">Own Clinic</h6>
                                <h1 class="maintit-grey pt-3">Dont HaveA Pharmacy Support?</h1>
                            </div>
                            <div class="col-md-3 col-4 text-center">
                                <h1 class="top-centerhead-slider position-relative">Pharmacy Support</h1>    
                                <div class="bottom-lineborder position-relative pt-4"><img src="images/pharmacy.png" class="img-fluid" alt=""></div>
                            </div>
                            <div class="col-md-2 col-4 tp-space">
                            <h6 class="smalltit-grey">Profrea Clinic</h6>
                                <h1 class="maintit-grey pt-3">Yes, In-Clinic Pharmacy</h1>                                
                            </div>
                            <div class="col-md tp-space d-none d-md-block">
                                <img src="images/thumbs-up.png" class="img-fluid w-100" alt="">
                            </div>
                        </div>
                    </div>
                    <div class="item">                        
                        <div class="row pt-5">
                            <div class="col-md tp-space  d-none d-md-block">
                                <img src="images/thumbs-down.png" class="img-fluid w-100" alt="">
                            </div>
                            <div class="col-md-2 col-4 tp-space">
                                <h6 class="smalltit-grey">Own Clinic</h6>
                                <h1 class="maintit-grey pt-3">Spend And Wait For AtLeast 2 Months To Get Operational</h1>
                            </div>
                            <div class="col-md-3 col-4 text-center">
                                <h1 class="top-centerhead-slider position-relative">Waiting Period</h1>    
                                <div class="bottom-lineborder position-relative pt-4"><img src="images/waiting.png" class="img-fluid" alt=""></div>
                            </div>
                            <div class="col-md-2 col-4 tp-space">
                            <h6 class="smalltit-grey">Profrea Clinic</h6>
                                <h1 class="maintit-grey pt-3">No, You can Start Practicing Immediately</h1>                                
                            </div>
                            <div class="col-md tp-space  d-none d-md-block">
                                <img src="images/thumbs-up.png" class="img-fluid w-100" alt="">
                            </div>
                        </div>
                    </div>
                    <div class="item">                        
                        <div class="row pt-5">
                            <div class="col-md tp-space d-none d-md-block">
                                <img src="images/thumbs-down.png" class="img-fluid w-100" alt="">
                            </div>
                            <div class="col-md-2 col-4 tp-space">
                                <h6 class="smalltit-grey">Own Clinic</h6>
                                <h1 class="maintit-grey pt-3">Limited To One Market With Cost Associated</h1>
                            </div>
                            <div class="col-md-3 col-4 text-center">
                                <h1 class="top-centerhead-slider position-relative">Marked Associated</h1>    
                                <div class="bottom-lineborder position-relative pt-4"><img src="images/map.png" class="img-fluid" alt=""></div>
                            </div>
                            <div class="col-md-2 col-4 tp-space">
                            <h6 class="smalltit-grey">Profrea Clinic</h6>
                                <h1 class="maintit-grey pt-3">practice In Multiple Markerts Within  Same Cost Spend</h1>                                
                            </div>
                            <div class="col-md tp-space d-none d-md-block">
                                <img src="images/thumbs-up.png" class="img-fluid w-100" alt="">
                            </div>
                        </div>
                    </div>
                    <div class="item">                        
                        <div class="row pt-5">
                            <div class="col-md tp-space d-none d-md-block ">
                                <img src="images/thumbs-down.png" class="img-fluid w-100" alt="">
                            </div>
                            <div class="col-md-2 col-4 tp-space">
                                <h6 class="smalltit-grey">Own Clinic</h6>
                                <h1 class="maintit-grey pt-3">Cash Burn For Hiring, Paying & Managing Staff</h1>
                            </div>
                            <div class="col-md-3 col-4 text-center">
                                <h1 class="top-centerhead-slider position-relative">Staff Management</h1>    
                                <div class="bottom-lineborder position-relative pt-4"><img src="images/staff.png" class="img-fluid" alt=""></div>
                            </div>
                            <div class="col-md-2 col-4 tp-space">
                            <h6 class="smalltit-grey">Profrea Clinic</h6>
                                <h1 class="maintit-grey pt-3">Well Qualified & Trained Staff Ready To Facilitate You </h1>                                
                            </div>
                            <div class="col-md tp-space d-none d-md-block ">
                                <img src="images/thumbs-up.png" class="img-fluid w-100" alt="">
                            </div>
                        </div>
                    </div>
                    <div class="item">                        
                        <div class="row pt-5">
                            <div class="col-md tp-space  d-none d-md-block ">
                                <img src="images/thumbs-down.png" class="img-fluid w-100" alt="">
                            </div>
                            <div class="col-md-2 col-4 tp-space">
                                <h6 class="smalltit-grey">Own Clinic</h6>
                                <h1 class="maintit-grey pt-3">Limited Footfall</h1>
                            </div>
                            <div class="col-md-3 col-4 text-center">
                                <h1 class="top-centerhead-slider position-relative">Footfall</h1>    
                                <div class="bottom-lineborder position-relative pt-4"><img src="images/football.png" class="img-fluid" alt=""></div>
                            </div>
                            <div class="col-md-2 col-4 tp-space">
                            <h6 class="smalltit-grey">Profrea Clinic</h6>
                                <h1 class="maintit-grey pt-3">Reach Up To 100000+ Patients</h1>                                
                            </div>
                            <div class="col-md tp-space  d-none d-md-block ">
                                <img src="images/thumbs-up.png" class="img-fluid w-100" alt="">
                            </div>
                        </div>
                    </div>
                    <div class="item">                        
                        <div class="row pt-5">
                            <div class="col-md tp-space d-none d-md-block">
                                <img src="images/thumbs-down.png" class="img-fluid w-100" alt="">
                            </div>
                            <div class="col-md-2 col-4 tp-space">
                                <h6 class="smalltit-grey">Own Clinic</h6>
                                <h1 class="maintit-grey pt-3">Limited Online Presence</h1>
                            </div>
                            <div class="col-md-3 col-4 text-center">
                                <h1 class="top-centerhead-slider position-relative">Online Presence</h1>    
                                <div class="bottom-lineborder position-relative pt-4"><img src="images/op.png" class="img-fluid" alt=""></div>
                            </div>
                            <div class="col-md-2 col-4 tp-space">
                            <h6 class="smalltit-grey">Profrea Clinic</h6>
                                <h1 class="maintit-grey pt-3">Branding Support</h1>                                
                            </div>
                            <div class="col-md tp-space d-none d-md-block">
                                <img src="images/thumbs-up.png" class="img-fluid w-100" alt="">
                            </div>
                        </div>
                    </div>
                    <div class="item">                        
                        <div class="row pt-5">
                            <div class="col-md tp-space  d-none d-md-block">
                                <img src="images/thumbs-down.png" class="img-fluid w-100" alt="">
                            </div>
                            <div class="col-md-2 col-4 tp-space">
                                <h6 class="smalltit-grey">Own Clinic</h6>
                                <h1 class="maintit-grey pt-3">No Resource To Manage Appointment</h1>
                            </div>
                            <div class="col-md-3 col-4 text-center">
                                <h1 class="top-centerhead-slider re-ma position-relative">Resource Management</h1>    
                                <div class="bottom-lineborder position-relative pt-4"><img src="images/rm.png" class="img-fluid" alt=""></div>
                            </div>
                            <div class="col-md-2 col-4 tp-space">
                            <h6 class="smalltit-grey">Profrea Clinic</h6>
                                <h1 class="maintit-grey pt-3">Dedicated Trained Resource To Attend Calls</h1>                                
                            </div>
                            <div class="col-md tp-space  d-none d-md-block">
                                <img src="images/thumbs-up.png" class="img-fluid w-100" alt="">
                            </div>
                        </div>
                    </div>                    
                </div>
            </div>
        </div>
    </div>
</section> -->

<section class="table-info">
    <div class="container">
        <div class="row pt-5 pb-5 justify-content-center">
            <div class="col-md-10 pt-5">
                <table class="table table-striped shadow">
                    <thead>
                        <tr>
                            <th scope="col" style="font-size: 24px; border: none; line-height: 1.8; width:40%;">Establish new clinic</th>
                            <th scope="col" style="border: none; line-height: 1.8; width:15%;"></th>
                            <th scope="col" style="font-size: 24px; border: none; line-height: 1.8;">Profrea Smart Clinic</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>                            
                            <td style="font-size: 18px; border: none;">Recurring monthly rent  </td>
                            <th class="text-center text-md-start" scope="row" style="border: none;"><img src="images/p1-1.png" class="img-fluid w-50" alt="" title="" /></th>
                            <td style="font-size: 18px; border: none;">Pay for what you use</td>
                        </tr>                        
                        <tr>                            
                            <td style="font-size: 18px; border: none;">No lab support </td>
                            <th class="text-center text-md-start" scope="row" style="border: none;"><img src="images/p5-1.png" class="img-fluid w-50" alt="" title="" /></th>
                            <td style="font-size: 18px; border: none;">In-clinic NABL accredited labs support</td>
                        </tr>
                        <tr>                            
                            <td style="font-size: 18px; border: none;">No Pharmacy support </td>
                            <th class="text-center text-md-start" scope="row" style="border: none;"><img src="images/p6.png" class="img-fluid w-50" alt="" title="" /></th>
                            <td style="font-size: 18px; border: none;">In-clinic pharmacy</td>
                        </tr>
                        <tr>                            
                            <td style="font-size: 18px; border: none;">Atleast two months to get operational</td>
                            <th class="text-center text-md-start" scope="row" style="border: none;"><img src="images/p10.png" class="img-fluid w-50" alt="" title="" /></th>
                            <td style="font-size: 18px; border: none;">Start practicing immediately </td>
                        </tr>
                        <tr>                            
                            <td style="font-size: 18px; border: none;">Get limited to one market with cost associated </td>
                            <th class="text-center text-md-start" scope="row" style="border: none;"><img src="images/p8.png" class="img-fluid w-50" alt="" title="" /></th>
                            <td style="font-size: 18px; border: none;">Practice in multiple market in same spend</td>
                        </tr>
                        <!-- <tr>                            
                            <td style="font-size: 18px; border: none;">No Pharmacy support</td>
                            <th class="text-center text-md-start" scope="row" style="border: none;"><img src="images/p6.png" class="img-fluid w-50" alt="" title="" /></th>
                            <td style="font-size: 18px; border: none;">In-clinic pharmacy</td>
                        </tr> -->
                        <!-- <tr>                            
                            <td style="font-size: 18px; border: none;">Spend and wait for at least 2 months to get operational</td>
                            <th class="text-center text-md-start" scope="row" style="border: none;"><img src="images/p7.png" class="img-fluid w-50" alt="" title="" /></th>
                            <td style="font-size: 18px; border: none;">Start practicing immediately</td>
                        </tr> -->
                        <!-- <tr>                            
                            <td style="font-size: 18px; border: none;">Limited to one market with cost associated</td>
                            <th class="text-center text-md-start" scope="row" style="border: none;"><img src="images/p8.png" class="img-fluid w-50" alt="" title="" /></th>
                            <td style="font-size: 18px; border: none;">Practice in multiple markets within same cost spend</td>
                        </tr> -->
                        <!-- <tr>                            
                            <td style="font-size: 18px; border: none;">Headache of Utility bills, CAM bills, Wi-fi etc.</td>
                            <th class="text-center text-md-start" scope="row" style="border: none;"><img src="images/p9.png" class="img-fluid w-50" alt="" title="" /></th>
                            <td style="font-size: 18px; border: none;">ZERO Headache of bills</td>
                        </tr> -->
                        <!-- <tr>                            
                            <td style="font-size: 18px; border: none;">Brokerage to finalize space for clinic</td>
                            <th class="text-center text-md-start" scope="row" style="border: none;"><img src="images/p10.png" class="img-fluid w-50" alt="" title="" /></th>
                            <td style="font-size: 18px; border: none;">ZERO Brokerage</td>
                        </tr> -->
                        <!-- <tr>                            
                            <td style="font-size: 18px; border: none;">Interior cost burn a whole in pocket</td>
                            <th class="text-center text-md-start" scope="row" style="border: none;"><img src="images/p11.png" class="img-fluid w-50" alt="" title="" /></th>
                            <td style="font-size: 18px; border: none;">ZERO Interior Cost</td>
                        </tr> -->
                        <!-- <tr>                            
                            <td style="font-size: 18px; border: none;">Huge Capital Investment</td>
                            <th class="text-center text-md-start" scope="row" style="border: none;"><img src="images/p12.png" class="img-fluid w-50" alt="" title="" /></th>
                            <td style="font-size: 18px; border: none;">ZERO capital Investment</td>
                        </tr> -->
                        <!-- <tr>                            
                            <td style="font-size: 18px; border: none;">Spend on Huge Equipment Cost</td>
                            <th class="text-center text-md-start" scope="row" style="border: none;"><img src="images/p13.png" class="img-fluid w-50" alt="" title="" /></th>
                            <td style="font-size: 18px; border: none;">ZERO Equipment Cost</td>
                        </tr> -->
                        <!-- <tr>                            
                            <td style="font-size: 18px; border: none;">Spend on website to create, host domain</td>
                            <th class="text-center text-md-start" scope="row" style="border: none;"><img src="images/p14.png" class="img-fluid w-50" alt="" title="" /></th>
                            <td style="font-size: 18px; border: none;">ZERO spend, get website with your own name</td>
                        </tr> -->
                        <tr>                            
                            <td style="font-size: 18px; border: none;">Cash burn for hiring, paying & managing staff</td>
                            <th class="text-center text-md-start" scope="row" style="border: none;"><img src="images/p15.png" class="img-fluid w-50" alt="" title="" /></th>
                            <td style="font-size: 18px; border: none;">Well Qualified & Trained staff ready to facilitate you</td>
                        </tr>
                        <tr>                            
                            <td style="font-size: 18px; border: none;">Limited footfall</td>
                            <th class="text-center text-md-start" scope="row" style="border: none;"><img src="images/p16.png" class="img-fluid w-50" alt="" title="" /></th>
                            <td style="font-size: 18px; border: none;">Reach Up to 10000+ Patients</td>
                        </tr>
                        <tr>                            
                            <td style="font-size: 18px; border: none;">Limited online presence</td>
                            <th class="text-center text-md-start" scope="row" style="border: none;"><img src="images/p17.png" class="img-fluid w-50" alt="" title="" /></th>
                            <td style="font-size: 18px; border: none;">Branding Support</td>
                        </tr>
                        <tr>                            
                            <td style="font-size: 18px; border: none;">Resource take appointment while operational </td>
                            <th class="text-center text-md-start" scope="row" style="border: none;"><img src="images/p18.png" class="img-fluid w-50" alt="" title="" /></th>
                            <td style="font-size: 18px; border: none;">Dedicated trained resource to attend calls round the clock</td>
                        </tr>
                    </tbody>
                </table>  
                <div class="more-spacebtn text-center mt-5 mb-5">
                    <a href="tel:+919643555592">Call Now</a>
                </div>              
            </div>
        </div>
    </div>
</section>

<?php include_once('footer.php');?>