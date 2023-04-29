<?php 
if (version_compare(phpversion(), '5.4.0', '<')) {
    if(session_id() == '') {
        session_start();
        // echo "dfg";
    }
}
else
{
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
}
if($description==""){
    $description = 'Profrea';
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
    <link href="css/font-awesome-min.css" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/owl.carousel.css">
    <link rel="stylesheet" type="text/css" href="css/owl.theme.default.min.css">
    
</head>
<body>
    <!-- Header section started -->
    <header class="bg-header shadow-sm">
        <div class="container">
            <div class="row align-items-center pt-4 pb-4">
                <div class="col-xl-8 col-sm-5 col-12 text-md-start text-center">
                    <a href="index"><h1 class="logo mb-0">Profrea</h1></a>
                </div>
                <div class="col-xl-2 col-sm-4 col-7 pt-sm-0 pt-4">
                    <div class="bookspace-header text-blue">
                        <a href="spaces">Book a Space</a>
                    </div>
                </div>
                <div class="col-xl-2 col-sm-3 col-5 text-md-end pt-sm-0 pt-4">
                    <!-- <div class="login-header text-grey mb-0">
                        <?php if (isset($_SESSION['ap_profrea_login_id'])) { ?>
                        <a class="text-grey" href="profile-view"><i class="fas fa-user-circle text-blue pe-2"></i> My Profile</a> |
                        <a class="text-grey" href="logout"><i class="fas fa-user-circle text-blue pe-2"></i> Log out</a>
                        <?php } else { ?>
                        <a class="text-grey" href="login"><i class="fas fa-user-circle text-blue pe-2"></i> Log In</a>    
                        <?php } ?>
                    </div> -->
                    <div class="getcallbacktn">
                        <a href="">Get A Callback</a>
                    </div>
                </div>
               
                
            </div>
        </div>
    </header>
   
    <!-- Header section ended -->