<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="keywords" itemprop="keywords" content="<?php echo isset($keywords)?$keywords:''; ?>" />
    <meta name="description" itemprop="description" content="<?php echo isset($description)?$description:''; ?>">
    <meta name="robots" content="index, follow">
    <title><?php echo isset($title)?$title:'Profrea'; ?></title>
    <link rel="icon" type="image/png" href="/images/favicon.png">
    <link rel="stylesheet" href="/css/style.css">
    <link href="/css/font-awesome.min.css" rel="stylesheet">
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="/css/owl.theme.default.min.css">
    <link rel="stylesheet" type="text/css" href="/css/bootstrap-datetimepicker.css">
    <link rel="stylesheet" href="/css/feather.css">
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
        <div class="container">
            <div class="row align-items-center pt-4 pb-4">
                <div class="col-lg-9 col-md-2 col-12 text-md-start text-center d-none d-md-block">
                    <a href="/"><h1 class="logo mb-0">Profrea</h1></a>
                </div>
                <div class="col-lg-3  col-md-4 col-12">                 
                    <div class="row">
                        <!-- <div class="col-lg-3 col-3 text-md-end text-center p-md-0">
                            <i class="fas fa-user-circle w-100 userbadge-icon"></i>
                        </div> -->
                        <div class="col-lg-8 col-8 ps-0 ps-md-2 dropdown-new">
                            <!-- <div id="profile_menu" data-bs-toggle="dropdown" aria-expanded="false" class="user-detailbadge position-relative">                        
                                <h3 class="user-detailheadname mb-0 ft-16 fw-bold"><?php echo ucwords($row_user["name"]); ?>,</h3>
                                <p class="user-namestatus position-absolute mb-0 ft-12 text-grey"><?php echo $row_user["is_verified"]?"Profile Verified":"Verification Pending"; ?></p>
                            </div> -->
                            <ul class="dropdown-menu" aria-labelledby="profile_menu">
                                <li><a class="dropdown-item" href="profile-view">My Profile</a></li>
                                <li><a class="dropdown-item" href="change-password">Change Password</a></li>
                                <li><a class="dropdown-item" href="booking-history">Booking History</a></li>
                                <li><a class="dropdown-item" href="logout">Logout</a></li>
                            </ul>
                        </div>
                    </div>                    
                </div>
            </div>
        </div>
    </header>
    <!-- Header section ended -->