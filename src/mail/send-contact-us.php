<?php

//require_once('vendor/autoload.php');

//use App\Classes\RealEstate\Spaces;


if (isset($_POST['email'])) {

    require_once('sendmail.php');                      
    require_once('../util/util.php');

  // validation expected data exists
  if (
    !isset($_POST['first_name']) ||
    !isset($_POST['last_name']) ||
    !isset($_POST['email']) ||
    !isset($_POST['mobile']) ||
    !isset($_POST['subject']) ||
    !isset($_POST['message'])
  ) {
    died('We are sorry, but there appears to be a problem with the form you submitted.');
  }



  $first_name = $_POST['first_name']; // required
  $last_name = $_POST['last_name']; //not required
  $email_from = $_POST['email']; // required
  $mobile = $_POST['mobile']; // required
  $subject = $_POST['subject']; //not required
  $message = $_POST['message']; // required

  //Validate Data
 // if (  strlen($first_name) < 2   || !isValidString($first_name) )   
 // died("Invalid First Name");  

 // if(!isValidPhone($mobile))
 // died("Invalid Phone no."); 
  
//  if( !isValidEmail($email_from))
//  died("Invalid Email"); 
  
  if (  strlen($message) < 10  )   
  died("Invalid Message"); 



  $email_to = "info@profrea.com";
  $email_subject = "Contact us";
  $email_from = $_POST['email']; // required
  $email_message = '
				   <html><body>
				   <p style="font-size:20px;">Enquiry by <b>'.($first_name).'</b> using ContactUs.</p>
				   <p style="font-size:18px;">
				   <b> First Name: </b> '. ($first_name) . ' <br/>
				   <b> Last Name: </b> '. ($last_name) . ' <br/>
				   <b> Email: </b> '. ($email_from) . ' <br/>
				   <b> Mobile: </b> '. ($mobile) . ' <br/>
				   <b> subject: </b> '. ($subject) . ' <br/>
				   <b> Message: </b> '. ($message) . ' <br/>				   
				   </p>
				   </body></html>
				   ';
				   
   $result = sendMail( $email_subject,$email_message,$email_to,$email_from);
     if ($result) {
    	success("Hey.. "," Thanks for contact us");
      } else {
    	failed("Error! "," There is some problem while submitting your request. Please try again");
      }
?>


  <!-- include your own success html here -->

<?php
}
?>