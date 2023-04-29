<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="keywords" itemprop="keywords" content="<?php echo $keywords; ?>" />
        <meta name="description" itemprop="description" content="<?php echo $description; ?>">
        <meta name="robots" content="index, follow">
        <title>Register</title>
        <link rel="icon" type="image/png" href="images/favicon.png">
        <link rel="stylesheet" href="css/style.css">
        <link href="css/font-awesome.min.css" rel="stylesheet">
        <link href="css/bootstrap.min.css" rel="stylesheet">        
        <link href="//cdn.jsdelivr.net/npm/@sweetalert2/theme-minimal@4/minimal.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="css/custom.css">
    </head>
    <!-- <section class="bg-top-loginhead">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <a href="index.php"><h2 class="logo">Profrea</h2></a>
                </div>
            </div>
        </div>
    </section> -->
    <section class="bg-login-header">
        <div class="container">
            <div class="row align-items-start">
                <div class="col-lg-6 pt-5 bg-grey">
                    <p class="loginhead pt-5 f1">Perfect workspace For <br> professionals</p>                    
                    <div class="about-explorebtn  pt-4 pb-5 mb-5">
                        <a href="spaces">Explore Workspaces</a>
                    </div>                    
                </div>
                <div class="col-lg-6 pt-5 bg-loginform-right ps-md-5 pb-md-5">
                    <h2 class="form-right-head f1">Register</h2>
                    <?php include_once("register-form.php"); ?>                    
                     <div class="col-md-5 col-8 pt-5 mt-4 pb-5 pb-md-0">
                            <h2 class="new-profrea f1">Have account ?</h2>
                        </div>
                        <div class="col-md-3 col-4 signup pt-5 mt-4">
                            <a href="login"><u>Sign In</u></a>
                        </div>
                  <!--  <h2 class="login-with pt-4">Register With</h2> -->
                    <div class="row pt-4">
                       <!-- <div class="col-lg-4 col-md-4 col-sm-4 col-12 text-center text-lg-start mb-5 mb-lg-0">
                            <div class="login-facebook">
                                <a class="text-white" href="https://www.facebook.com/"><i class="fa fa-facebook text-white pe-2"></i> Facebook</a>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-12 text-center text-lg-start mb-5 mb-lg-0">
                            <div class="login-instagram">
                                <a class="text-white" href="https://www.instagram.com/"><i class="fa fa-instagram text-white pe-2"></i>Instagram</a>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-12 text-center text-lg-start mb-5 mb-lg-0">
                            <div class="login-truecaller">
                                <a class="text-white" href="https://www.truecaller.com/"><i class="fa fa-phone-alt text-white pe-2"></i> Truecaller</a>
                            </div>
                        </div> -->
                       
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="js/jquery.min.js" type="text/javascript"></script>
    <!-- bootstrap -->
    <script src="js/bootstrap.popper.min.js "></script>
    <script src="js/bootstrap.bundle.min.js "></script>
    <!-- font-awesome -->
    <script src="js/font-awesome.js "></script>    
    <script src="js/parsley.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
    <script src="js/custom.js"></script>
    
</body>
</html>