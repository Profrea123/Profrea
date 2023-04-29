<?php 
$title = "Register | Profrea";
$description = "";
$keywords = "";
$page = 1;
include_once('header.php');
?>
<section class="bg-video-layout">
    <div class="container">
        <div class="row pt-4 pb-2">
            <div class="col-md-6">
                <div class="">
                <img src="images/log2.jpg" class="img-fluid" alt="" title="" />
                </div>
            </div>
            <div class="col-md-6">
                <h2 class="form-right-head f1">Register</h2>
                <?php include_once("register-form.php"); ?>                    
                <div class="col-md-5 col-8 mt-4 pb-5 pb-md-0">
                    <h2 class="new-profrea f1">Have account ?</h2>
                </div>
                <div class="col-md-3 col-4 signup mt-4">
                    <a href="login"><u>Sign In</u></a>
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
