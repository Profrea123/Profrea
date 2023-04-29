<?php 
$title = "Login | Profrea";
$description = "";
$keywords = "";
$page = 1;
include_once('header.php');
?>

<section class="bg-video-layout">
    <div class="container">
        <div class="row pt-4 pb-4">
            <div class="col-md-6">
                <div class="">
                <img src="images/log2.jpg" class="img-fluid" alt="" title="" />
                </div>
            </div>
            <div class="col-md-6">
            <h2 class="form-right-head f1">Log In</h2>
                    <?php include_once("login-form.php"); ?>
                    <div class="text-center">
                    <!-- <div class="col-md-5 col-8 pt-5 mt-2 pb-5 pb-md-0">
                        <h2 class="new-profrea f1">New To Profrea ?</h2>
                    </div>
                    <div class="col-md-3 col-4 signup pt-5 mt-2">
                        <a href="register"><u>Sign Up Now</u></a>
                    </div> -->
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
 <script type="text/javascript">
    $(document).ready(function() {
        $('input[type="checkbox"]').click(function() {
            if($(this).prop("checked") == true) {
                $('#password_box').hide();                
                $('#otpcheck').val(0);
                $('.log-inbtn').html('Send OTP');
            }
            else if($(this).prop("checked") == false) {
                $('#password_box').show();
                $('#otp_box').hide();
                $('#otpcheck').val(1);
                $('.log-inbtn').html('Login');
            }
        });
    });
</script>