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
$title = 'Dashboard';
$keywords = 'Profrea';
$description = 'Profrea';
$page="dashboard";
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
            header('Location: profile-update');
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

}
else
{
    header('Location: login');
}

include_once("user_profile_header.php");

?>


    <!-- detail section started -->
    <section class="bg-updation">
        <div class="container">
            <div class="row pt-5 pb-5">
                <div class="col-md-12 col-12">
                    <h1 class="website-detailhead f1 ft-32 fw-bold">Dashboard Details</h1>
                </div>
                <div class="col-md-12 col-12 pt-3">

                </div>
            </div>
        </div>
    </section>
    <!-- detbuttonil section ended -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.js"></script>
    <script src="js/bootstrap.popper.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/font-awesome.js"></script>

</body>
</html> 