<?php
//Post Params
require_once('../src/util/util.php');
require_once('../src/mail/sendmail.php');
$email_subject = "Test Mail!!!";
$email_message = '
	<html><body>
		<p style="font-size:12px; "> This is testing mail </p>
	</body></html>
	';
$result = sendMail( $email_subject,$email_message,'rajaeximait@gmail.com');
if ($result) {
	success("Congratulations !!! "," You have successfully registered with us, please check your mail to complete the onboard process.");
} 
else {
	failed("Error! "," There is some problem while submitting your request. Please try again");
}
?>