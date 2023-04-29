<?php 
require_once('src/Classes/Model/Database.php');
require_once('vendor/autoload.php');
use App\Classes\Model\Database;
$db_connection = new Database;
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
$title = 'Spaces';
$keywords = 'Profrea';
$description = 'Profrea';
if (isset($_SESSION['ap_profrea_login_id'])) 
{    
    $login_id = $_SESSION['ap_profrea_login_id'];    
    
    $sql_user = "SELECT users.*, gender.name AS gender, city.name AS city FROM users 
        LEFT JOIN gender ON gender.id = users.gender_id 
        LEFT JOIN city ON city.id = users.city 
        LEFT JOIN operating_specialty AS os ON os.id = users.speciality
        WHERE users.id = $login_id";
    $res_user = $db_connection->getDbHandler()->query($sql_user);
    if($res_user)
    {
        $row_user = $res_user->fetch();        
        if($row_user["profession_id"] == 1 && $row_user["rowstate"] == 0){
           // header('Location: profile-update');
        }
        if($row_user['profile_picture']!=''){
            $profile_picture = $row_user['profile_picture'];
        }
        else{
            if($row_user['gender_id']==1){
                $profile_picture = "male.png";
            }
            else{
                $profile_picture = "female.png";
            }
        }
    }

    $sql_profrea_clinic = "SELECT * FROM spaces WHERE owner_id = $login_id";
    $res_profrea_clinic = $db_connection->getDbHandler()->query($sql_profrea_clinic);
    if($res_profrea_clinic)
    {
        $row_profrea_clinic = $res_profrea_clinic->fetchAll();
    }

}
else
{
    header('Location: login');
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
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/owl.theme.default.min.css">
    <link href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css" rel="stylesheet">
</head>
<body>
    <!-- Header section started -->
    <header class="bg-header shadow-sm">
        <div class="container">
            <div class="row align-items-center pt-4 pb-4">
                <div class="col-lg-3 col-md-2 col-12 text-md-start text-center d-none d-md-block">
                    <a href="index"><h1 class="logo mb-0">Profrea</h1></a>
                </div>
                <div class="col-lg-6 col-md-6 profile-menu">
                    <nav class="navbar navbar-expand-md navbar-light">
                        <div class="container-fluid">
                            <a class="navbar-brand d-block d-md-none" href="index"><h1 class="logo mb-0">Profrea</h1></a>
                            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                            </button>
                            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                                <ul class="navbar-nav  mb-2 mb-lg-0">
                                    <li class="nav-item">
                                        <a class="nav-link ft-16" href="dashboard">Dashboard</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link ft-16" href="profile-view">Profile</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link ft-16 active" href="my-spaces">Spaces</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link ft-16" href="transaction">Transactions</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </nav>
                </div>
                <div class="col-lg-3 col-md-4 col-12">
                    <div class="row">
                        <div class="col-lg-3 col-3 text-md-end text-center p-md-0">
                            <i class="fas fa-user-circle w-100 userbadge-icon"></i>
                        </div>
                        <div class="col-lg-8 col-8 ps-0 ps-md-2 dropdown-new">
                            <div id="profile_menu" data-bs-toggle="dropdown" aria-expanded="false" class="user-detailbadge position-relative">                        
                                <h3 class="user-detailheadname mb-0 ft-16 fw-bold"><?php echo $row_user["name"]; ?>,</h3>
                                <p class="user-namestatus position-absolute mb-0 ft-12 text-grey">Verification Pending</p>
                            </div>
                            <ul class="dropdown-menu" aria-labelledby="profile_menu">
                                <li><a class="dropdown-item" href="profile-view">My Profile</a></li>
                                <li><a class="dropdown-item" href="change-password">Change Password</a></li>
                                <li><a class="dropdown-item" href="logout">Logout</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>   
    <!-- Header section ended -->

    <!-- detail section started -->
    <section class="bg-updation">
        <div class="container">
            <div class="row pt-5 pb-5">
                <div class="col-md-12 col-12">
                    <h1 class="website-detailhead f1 ft-32 fw-bold">Booking Spaces</h1>
                </div>
                <div class="col-md-12 col-12 pt-3">
                    <table class="table" id="spaceTable">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Name</th>
                                <th>Address</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 0;
                            foreach($row_profrea_clinic as $profrea_clinic)
                            {
                                $i++;
                                ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $profrea_clinic["ws_name"]; ?></td>
                                    <td><?php echo $profrea_clinic["address"]; ?></td>
                                </tr>
                                <?php 
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
    <!-- detbuttonil section ended -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.js"></script>
    <script src="js/bootstrap.popper.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/font-awesome.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript">
    $(function() {        
        $('#spaceTable').dataTable();
    });
    </script>

</body>
</html> 