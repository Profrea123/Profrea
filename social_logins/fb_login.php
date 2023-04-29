<?php
session_start();
require_once('src/Classes/Model/Database.php');
require_once('vendor/autoload.php');
require_once('../src/mail/sendmail.php');
use App\Classes\Model\Database;
$db_connection = new Database;

// added in v4.0.0
require_once 'autoload.php';
use Facebook\FacebookSession;
use Facebook\FacebookRedirectLoginHelper;
use Facebook\FacebookRequest;
use Facebook\FacebookResponse;
use Facebook\FacebookSDKException;
use Facebook\FacebookRequestException;
use Facebook\FacebookAuthorizationException;
use Facebook\GraphObject;
use Facebook\Entities\AccessToken;
use Facebook\HttpClients\FacebookCurlHttpClient;
use Facebook\HttpClients\FacebookHttpable;
// init app with app id and secret
FacebookSession::setDefaultApplication('567284884489272','550cbbfed067eee3a03689ea87dc9e3f');
// login helper with redirect_uri
$helper = new FacebookRedirectLoginHelper('http://localhost/ADHIPRINIA/ap_profrea/social_logins/fb_login.php');
try {
  $session = $helper->getSessionFromRedirect();
} 
catch( FacebookRequestException $ex ) {
  // When Facebook returns an error
} 
catch( Exception $ex ) {
  // When validation fails or other local issues
}
// see if we have a session
if ( isset( $session ) ) 
{
  // graph api request for user data
  $request = new FacebookRequest( $session, 'GET', '/me?locale=en_US&fields=name,email' );
  $response = $request->execute();
  // get response
  $graphObject = $response->getGraphObject();
  $fbid = $graphObject->getProperty('id');              // To Get Facebook ID
  $fbfullname = $graphObject->getProperty('name'); // To Get Facebook full name
  $femail = $graphObject->getProperty('email');    // To Get Facebook email ID
  
  print_r($graphObject);
  $name = $fbfullname;
  $email = $femail;

  $activationkey = base64_encode($email);    
  $referral_code = base64_encode($email);
  $login_type = "FACEBOOK";
  $status = 1;
  $today = date('Y-m-d H:i:s');

  $sel_user = "SELECT * FROM users WHERE email='$email'";
  $res_user = mysqli_query($con,$sel_user);
  if(mysqli_num_rows($res_user) > 0 )
  {
    $row_user = mysqli_fetch_array($res_user);
    $user_id = $row_user['id'];

    $upd_user = "UPDATE users SET login_type='FACEBOOK' WHERE id=$user_id";
    $res_user = mysqli_query($con,$upd_user);    

    $_SESSION['log_info'] = $row_user;
    header('Location: ../profile.php');
  }
  else
  {
    $ins_user = "INSERT INTO users(user_name,email,activation_key,referral_code,login_type,status,added_on) VALUES('$name','$email','$activationkey','$referral_code','$login_type','$status','$today')";
    $res_user = mysqli_query($con,$ins_user);
    if($res_user)
    {
      // send registration e-mail to user
      $from_name = "Fbtimeline";
      $from_mail = $admin_email;
      $to_name = $name;
      $to_email = $email;
      $subject = "Welcome to Facebook Timeline, Confirm your Registration";
      $message_temp = file_get_contents("../includes/mail_templates/register.html");
      $message_temp = str_replace('#activationkey', $activationkey, $message_temp);
      fbtimeline_mail($from_name,$from_mail,$to_name,$to_mail,$subject,$message_temp);

      // send registration e-mail to admin            
      $from_name = $name;
      $from_email = $email;
      $to_name = "Admin";
      $to_email = $admin_email;
      $subject = "New user has been registered.";
      $message_temp = file_get_contents("../includes/mail_templates/register_admin.html");
      $message_temp = str_replace('#useremail', $email, $message_temp);
      fbtimeline_mail($from_name,$from_mail,$to_name,$to_mail,$subject,$message);
    }    
  }  
} 
else 
{
  $loginUrl = $helper->getLoginUrl();
  header("Location: ".$loginUrl);
}

$page = 0;
$title = "FACEBOOK";
include_once('includes/header.php');
?>

    <div class="content-main">
        <div class="container">
            <div class="row">
                <br/><br/><br/><br/>
                <div class="col-md-12 text-center">                    
                    <h4>Welcome to facebook timeline</h4>
                    <br/><br/>  
                    <p>Thanks for registering with facebook timeline</p>
                    <?php 
                    if ($error_msg=='') 
                    { 
                        ?>
                        <p>
                            <h2 class="text-center text-success">Your account activated successfully. Please login and use your account!</h2>
                            <br/><br/>
                            <a href="signin" class="btn btn-xs gd-btn">Login</a>
                        </p> 
                        <?php 
                    } 
                    else 
                    { 
                        ?>
                        <p>
                            <h2 class="text-center text-danger"><?php echo $error_msg; ?></h2>
                        </p>
                        <?php 
                    } 
                    ?>                    
                </div>
                <br/><br/><br/><br/>
            </div>
        </div>
    </div>
    

<?php
include_once('includes/footer.php');
?>