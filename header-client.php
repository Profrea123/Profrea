<?php 
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
if($description == ""){
    $description = 'Profrea';
}
date_default_timezone_set("Asia/Calcutta");
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
        <link rel="stylesheet" href="css/style.css?<?php echo rand(7000000,9000000) ?>">
        <link href="css/font-awesome-min.css" rel="stylesheet">
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="css/owl.carousel.css">
        <link rel="stylesheet" type="text/css" href="css/owl.theme.default.min.css">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="css/custom1.css?<?php echo rand(400000,6000000); ?>">
        <link rel="stylesheet" type="text/css" href="css/simplePagination.css">
        <link href="//cdn.jsdelivr.net/npm/@sweetalert2/theme-minimal@4/minimal.css" rel="stylesheet">
        <link href="css/lightbox.min.css" rel="stylesheet"></script>
        <link href="css/all_icons_min.css" rel="preload" as="style" onload="this.rel = 'stylesheet'">
	    <link href="css/book-slot.css" rel="preload" as="style" onload="this.rel = 'stylesheet'"> </head>
        <!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-NGT8LTJ');</script>
<!-- End Google Tag Manager -->    
    
    </head>
    <body>
        <!-- Header section started -->
        <header class="bg-header shadow-sm">
            <div class="container">
                <div class="row align-items-center pt-4 pb-4">
                    <div class="col-xl-8 col-md-3 col-sm-5 col-5 text-md-start text-center">
                        <a href="website?domain=<?php echo $domain; ?>"><h1 class="logo mb-0"><?php echo "Dr. ".ucwords($row_user["name"]); ?></h1></a>
                    </div>
                    <div class="col-xl-1 col-md-2 col-7 pt-sm-0 pt-4 text-end d-none d-md-block">
                        <!--<div class="bookspace-header text-blue">
                            <a href="#">Book Appointment</a>
                        </div>-->
                    </div>
                    <div class="col-xl-3 col-md-3 col-sm-7 col-7 text-md-end pt-sm-0  text-end">
                        <!-- <div class="login-header text-grey mb-0">
                            <?php if (isset($_SESSION['ap_profrea_login_id'])) { ?>
                            <a class="text-grey" href="profile-view"><i class="fas fa-user-circle text-blue pe-2"></i> My Profile</a> |
                            <a class="text-grey" href="logout"> Log out</a>
                            <?php } else { ?>
                            <a class="text-grey" href="login"><i class="fas fa-user-circle text-blue pe-2"></i> Log In</a>    
                            <?php } ?>
                        </div> -->
                        <div class="getcallbackbtn">
                            <a href="">Book Appointment</a>
                        </div>
                        
                                
                    </div>
                </div>
            </div>
        </header>        
        <!-- Header section ended -->