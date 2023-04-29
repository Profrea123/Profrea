<?php 
error_reporting(1);
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
$title = 'Change Password';
$description = 'Profrea';
$page="dashboard";

if (isset($_SESSION['ap_profrea_login_id'])) 
{    
    $login_id = $_SESSION['ap_profrea_login_id'];    
    
    $sql_user = "SELECT users.name,users.rowstate,users.mobileNo,users.email,users.profession_id as profession_id,city,gender_id,is_verified FROM users WHERE users.id = $login_id";
    $res_user = $db_connection->getDbHandler()->query($sql_user);
    if($res_user)
    {
        $row_user = $res_user->fetch();
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
    
    $sql_user_detail = "SELECT * FROM user_details WHERE user_id = $login_id";
    $res_user_detail = $db_connection->getDbHandler()->query($sql_user_detail);
    if($res_user_detail)
    {
        $row_user_detail = $res_user_detail->fetch();
    }

    $sql_gender = "SELECT * FROM gender";
    $res_gender = $db_connection->getDbHandler()->query($sql_gender);
    if($res_gender)
    {
        $row_gender = $res_gender->fetchAll();
    }
    
    $sql_city = "SELECT * FROM city";
    $res_city = $db_connection->getDbHandler()->query($sql_city);
    if($res_city)
    {
        $row_city = $res_city->fetchAll();
    }
    
    $sql_speciality = "SELECT * FROM operating_specialty  WHERE space_type_id = ".$row_user["profession_id"];
    $res_speciality = $db_connection->getDbHandler()->query($sql_speciality);
    if($res_speciality)
    {
        $row_speciality = $res_speciality->fetchAll();
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
        <div class="container pb-5">
            <form class="pt-3 pb-4" id="changepasswordForm" action="#" method="POST" novalidate autocomplete="off" data-parsley-validate>
                <div class="row align-items-start pt-5">
                    <div class="col-md-12 col-12 ">
                        <h1 class="website-detailhead f1 ft-32 fw-bold">Change Password</h1>
                    </div>
                    <div class="col-md-12 pt-5">
                        <div class="education-box p-4">
                            <h2 class="education-titlehead text-center ft-18 f1 fw-bold">Password Information</h2>
                            <div class="row pt-2">
                                <div class="col-md-6">
                                    <div class='full-input p-2 col-md-12 me-4'>
                                        <label for="password" class="form-label text-grey ft-14 mb-0">Password</label>
                                        <input type="password" name='password' id='password' placeholder="Enter New Password" required="" data-parsley-minlength="6" data-parsley-pattern="(?=.*[a-z])(?=.*[A-Z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).*" data-parsley-pattern-message="Password must contain at least 1 lowercase, 1 uppercase, 1 numeric and 1 special character.">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class='full-input p-2 col-md-12 me-4'>
                                        <label for="password1" class="form-label text-grey ft-14 mb-0">Confirm Password</label>
                                        <input type="password" name='password1' id='password1' placeholder="Enter Confirm Password" required="" data-parsley-equalto="#password">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 pt-5 pb-5">
                        <div class="col-lg-12 text-lg-center">
                            <input type="hidden" name="login_id" value="<?php echo $login_id; ?>" />
                            <button class="submit-btn mt-md-2" type="submit">Update</button>
                        </div>
                    </div>
                </div>
            </form>
            <div id="changepasswordForm_status"></div>
        </div>
    </section>
    <!-- detbuttonil section ended -->

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