<?php




if (isset($_POST['email'])) {
  
  require_once('sendmail.php');                      
  require_once('../util/util.php');
  
  // validation expected data exists
  if (
    !isset($_POST['email']) 
      ) {
    died('We are sorry, but there appears to be a problem with the form you submitted.');
  }

  $email_from = $_POST['email']; // required

  $error_message = "";
  $email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';
  if (!preg_match($email_exp, $email_from)) {
    $error_message .= 'The Email Address you entered does not appear to be valid.<br />';
  }
  if (strlen($error_message) > 0) {
    died($error_message);
  }

  $email_to = 'info@profrea.com';
  $email_subject = "Newsletter subscription";
  $email_from = $_POST['email']; // required
  $email_message = '
                    <html><body>
                    <p style="font-size:18px;">Hi newsletter subscribed by</p>
                    <p style="font-size:18px;"><b> '. clean_string($email_from) . '</b> </p>
                    </body></html>
                    ';

   $result = sendMail( $email_subject,$email_message,$email_to,$email_from);
     if ($result) {
    	success("Congratulations !!! "," You have successfully subscribed profrea newsletter.");
      } else {
    	failed("Error! "," There is some problem while submitting your request. Please try again");
      }

?>


  <!-- include your own success html here -->

<?php
}
?>