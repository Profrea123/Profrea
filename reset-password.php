<?php
$title = "Reset Password | Profrea";
$description = "";
$keywords = "";
$page = 1;

require_once('src/Classes/Model/Database.php');
use App\Classes\Model\Database;
$db_connection = new Database;
if (isset($_POST['username']) || isset($_POST['phone'])) 
{
    $requestUser = $_POST['username'] ?? $_POST['phone'];
    $sql_user = "SELECT name FROM users WHERE (email='$requestUser' OR mobileNo='$requestUser')";
    $res_user = $db_connection->getDbHandler()->query($sql_user);
    if($res_user)
    {
        $row_user = $res_user->fetch();
    }
} else {
    header('Location: login');
}
include_once('header.php');
?>
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
                <h2 class="form-right-head f1"><a href="login" class="ms-2"><i class="fa fa-long-arrow-alt-left text-blue "></i></a> Welcome <?php echo $row_user['name']; ?>, </h2>
                <h6 class="forget-passhead pt-2">Set A New Password</h6>
                <form class="pt-3 pb-4" id="resetpasswordForm" action="#" method="POST" novalidate autocomplete="off" data-parsley-validate>
                    <div class='full-input p-2 ps-4 mb-3 w-100'>
                        <label for="password" class="form-label text-grey ft-14 mb-0">New Password</label>
                        <input type="password" name='password' id='password' placeholder="Enter New Password" required="" data-parsley-minlength="6" >
                        <!-- <input type="password" name='password' id='password' placeholder="Enter New Password" required="" data-parsley-minlength="6" data-parsley-pattern="(?=.*[a-z])(?=.*[A-Z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).*" data-parsley-pattern-message="Password must contain at least 1 lowercase, 1 uppercase, 1 numeric and 1 special character."> -->
                    </div>
                    <div class='full-input p-2 ps-4 mb-3 w-100'>
                        <label for="password1" class="form-label text-grey ft-14 mb-0">Confirm Password</label>
                        <input type="password" name='password1' id='password1' placeholder="Enter Confirm Password" required="" data-parsley-equalto="#password">
                    </div>
                    <div class="row pt-2 align-items-center">
                        <div class="col-md-12 ">
                            <div class="log-inbtnn w-100 ">
                                <input type="hidden" name="username" value="<?php echo $requestUser; ?>"/>
                                <input type="hidden" name="page" value="<?php echo $_SERVER['REQUEST_URI']; ?>"/>
                                <button type="submit" class="text-decoration-none log-inbtn">RESET PASSWORD</button>
                            </div>
                        </div>
                    </div>
                </form>
                <div id="resetpasswordForm_status"></div>
            </div>
        </div>
    </div>    
</section>
<?php include_once('footer.php'); ?>