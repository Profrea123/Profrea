<?php 
require_once ('vendor/autoload.php');
use App\Classes\Model\Database;
use App\Classes\RealEstate\Spaces;
$db_conn = new Database;
$real_estate = new Spaces();
if (version_compare(phpversion() , '5.4.0', '<')) {
    if (session_id() == '')
    {
        session_start();
    }
} else {
    if (session_status() == PHP_SESSION_NONE)
    {
        session_start();
    }
}
if ($description == "")
{
    $description = 'Profrea';
}

$mobileno = $useremail = $username = "";
if (isset($_SESSION['ap_profrea_login_id'])) {
    $login_id = $_SESSION['ap_profrea_login_id'];

    $sql_user = "SELECT users.*, gender.name AS gender, city.name AS city FROM users 
    LEFT JOIN gender ON gender.id = users.gender_id 
    LEFT JOIN city ON city.id = users.city 
    LEFT JOIN operating_specialty AS os ON os.id = users.speciality
    WHERE users.id = $login_id";
    $res_user = $db_conn->getDbHandler()
        ->query($sql_user);

    if ($res_user) {
        $row_user = $res_user->fetch();
        $profrea_verified = 'yes';
        $mobileno = $row_user["mobileNo"] ?? '';
        $useremail = $row_user["email"] ?? '';
        $username = $row_user["name"] ?? '';
    }
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
         <link href="css/font-awesome-min.css" rel="stylesheet">
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="css/owl.carousel.css">
        <link rel="stylesheet" type="text/css" href="css/owl.theme.default.min.css">
        <link rel="stylesheet" href="css/style.css?<?php echo rand(7000000,9000000) ?>">
       
        <link rel="stylesheet" type="text/css" href="css/custom1.css?<?php echo rand(400000,6000000); ?>">
        <link rel="stylesheet" type="text/css" href="css/simplePagination.css">
        <link rel="stylesheet" type="text/css" href="css/jquery.datetimepicker.css">
        <link href="//cdn.jsdelivr.net/npm/@sweetalert2/theme-minimal@4/minimal.css" rel="stylesheet">


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
        <section class="top-strip">
            <div class="container">
                <div class="row align-items-center pt-2 pb-2">
                    <div class="col-md-12 text-center">
                        <p class="top-phonestrip text-white mb-0"><a href="tel:+919643555592" class="text-white">Call us at : +91 96435 55592</a></p>
                    </div>
                </div>
            </div>
        </section>
        <section class="mt-4 mt-md-0">
            <div class="container">
                <div class="row align-items-center pt-4 pb-4">
                    <div class="col-xl-3  text-md-start text-center d-none d-md-block">
                        <a href="index"><h1 class="logo mb-0">Profrea</h1></a>
                    </div>
                    <div class="col-xl-9 text-center text-md-end">
                        <nav class="navbar navbar-expand-lg navbar-light">
                            <div class="container-fluid">
                                <a class="navbar-brand d-block d-md-none" href="index"><h1 class="logo mb-0">Profrea</h1></a>
                                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                                <span class="navbar-toggler-icon"></span>
                                </button>
                                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                                <ul class="navbar-nav ms-auto mb-2 mb-lg-0 pt-4 pt-md-0">
                                    <li class="nav-item">                                    
                                        <div class="bookspace-header text-blue">
                                            <a href="doctor-consult">Find Doctors</a>
                                        </div>                                    
                                    </li>
                                    <li class="nav-item mb-5 mb-md-0 me-md-3">                                    
                                        <div class="bookspace-header text-blue">
                                            <a href="spaces">Book Clinic</a>
                                        </div>                                    
                                    </li>
                                    <li class="nav-item mb-5 mb-md-0 me-md-3">
                                        <div class="login-header mb-0">
                                            <?php if (isset($_SESSION['ap_profrea_login_id'])) { ?>
                                            <a class="" href="profile-view"><i class="fas fa-user-circle text-blue pe-2"></i> Account</a> |
                                            <a class="" href="logout"> Log out</a>
                                            <?php } else { ?>
                                            <a class="" href="login"><i class="fas fa-user-circle text-blue pe-2"></i> Log In</a>    
                                            <?php } ?>
                                        </div>
                                    </li> 
                                    <li class="nav-item">
                                        <div class="getcallbackbtn">
                                            <a href="" data-bs-toggle="modal" data-bs-target="#exampleModal-1">Get A Callback</a>
                                        </div>
                                        <!-- Modal -->
                                         <div class="modal fade" id="exampleModal-1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title f1 fw-bold ft-32 text-start" id="exampleModalLabel">Get A Callback</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                <?php include_once("callback.php"); ?>
                                                </div>                            
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                                </div>
                            </div>
                        </nav>
                    </div>
                    <!-- <div class="col-xl-2 col-md-3 col-sm-3 col-5 pt-4 pt-sm-4 pt-md-0 text-end order-md-2 order-3">
                        <div class="bookspace-header text-blue">
                            <a href="spaces">Book Clinic</a>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-3 col-sm-4 col-6 text-md-center pt-sm-4 pt-md-0 order-md-3 order-2">
                         <div class="login-header mb-0">
                            <?php if (isset($_SESSION['ap_profrea_login_id'])) { ?>
                            <a class="" href="profile-view"><i class="fas fa-user-circle text-blue pe-2"></i> My Profile</a> |
                            <a class="" href="logout"> Log out</a>
                            <?php } else { ?>
                            <a class="" href="login"><i class="fas fa-user-circle text-blue pe-2"></i> Log In</a>    
                            <?php } ?>
                        </div>
                    </div>
                    <div class="col-xl-2 col-md-4 col-sm-5 col-7 order-md-4 order-4 pt-4 pt-sm-4 pt-md-0">
                        <div class="getcallbackbtn">
                            <a href="" data-bs-toggle="modal" data-bs-target="#exampleModal-1">Get A Callback</a>
                        </div> -->
                        <!-- Modal -->
                        <!-- <div class="modal fade" id="exampleModal-1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title f1 fw-bold ft-32 text-start" id="exampleModalLabel">Get A Callback</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                <?php include_once("callback.php"); ?>
                                </div>                            
                                </div>
                            </div>
                        </div>
                    </div> -->
                </div>
            </div>
        </section>
        </header>        
        <!-- Header section ended -->