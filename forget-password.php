<?php 

$title = "Forgot Password | Profrea";
$description = "";
$keywords = "";
$page = 1;
include_once('header.php');
?>
<!-- <section class="bg-top-loginhead">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-12">
                <a href="index"><h2 class="logo">Profrea</h2></a>
            </div>
        </div>
    </div>
</section> -->
<section class="bg-login-header">
    <div class="container">
        <div class="row align-items-start">
            <div class="col-lg-6 pt-5 bg-grey">
                <p class="loginhead pt-5 f1">Perfect clinics for <br> Doctors</p>                    
                <div class="about-explorebtn  pt-4 pb-5 mb-5">
                    <a href="spaces">Explore Workspaces</a>
                </div>
            </div>
            <div class="col-md-6 pt-5 bg-loginform-right ps-md-5 pb-md-5">
                <h2 class="form-right-head f1">Forgot Password?</h2>
                <?php include_once("forget-password-form.php"); ?>
                <!-- <h6 class="forget-passhead pt-2"></h6>
                <p class="otp-box-para pt-2">Enter The OTP that you've received on +91 ***** *3198</p>
                <div class="otp-newpass">
                    <a href="forget-password1">Set a new password</a>
                </div> -->
            </div>
        </div>
    </div>
</section>
<?php include_once('footer.php'); ?>
