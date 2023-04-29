<?php 
// Post Params
require_once('Classes/Model/Database.php');
require_once('util/validate.php');
require_once('util/util.php');
require_once('mail/sendmail.php');
use App\Classes\Model\Database;
// validation expected data exists
if(!isset($_POST['first_name'])
|| !isset($_POST['phone_no'])
|| !isset($_POST['email_Id'])
|| !isset($_POST['space_type'])
|| !isset($_POST['locality'])
|| !isset($_POST['landmark'])
|| !isset($_POST['city'])
) {
	died('We are sorry, but there appears to be a problem with the form you submitted.');
}
$first_name = trim( $_POST['first_name'] );
//$last_name = trim( $_POST['last_name'] );
$phone_no = trim( $_POST['phone_no'] );
$phone_no2 = trim( $_POST['phone_no2'] );
$email_Id = trim($_POST['email_Id']);
//$email_Id2 = trim( $_POST['email_Id2'] );
$user_type ="Space Provider";
$space_type = trim($_POST['space_type']);
$city = trim( explode (",",  $_POST['city'])[0]);
$locality = trim($_POST['locality']);
$landmark = trim($_POST['landmark']);
$rowstate = TRUE;
date_default_timezone_set('Asia/Kolkata');
$insert = date("Y-m-d h:i:s");
//Validate Data
/*if (  strlen($first_name) < 2   || !isValidString($first_name) )
died("Invalid First Name");
if (  strlen($last_name) < 2 || !isValidString($last_name) )
died("Invalid Last Name");
if(!isValidPhone($phone_no))
died("Invalid Phone no.");
if (  strlen($phone_no2) > 0  and !isValidPhone($phone_no2) )
died("Invalid Phone no.");
if( !isValidEmail($email_Id))
died("Invalid Email");
if ( strlen($email_Id2) > 0  and !isValidEmail($email_Id2) )
died("Invalid Email");
if (  strlen($locality) < 100  || !isValidString($locality) )
died("Invalid Locality");
if (  strlen($landmark) < 100 || !isValidString($landmark) )
died("Invalid Landmark");
if (  strlen($city) < 2  || !isValidString($city) )
died("Invalid City : ".$city);  */
// Create a new object from Rectangle class
$db_conn = new Database;
$unique_id = uniqid();
//INSERT
$query = " INSERT INTO `basic_info` (`unique_id`, `first_name`,  `phone_no`, `phone_no2`, `email_Id`,  `space_type`,`user_type`, `locality`, `landmark`, `city`, `rowstate`, `insert` )  VALUES ( '$unique_id', '$first_name',  '$phone_no', '$phone_no2', '$email_Id',  '$space_type' ,'$user_type', '$locality', '$landmark', '$city','$rowstate' ,'$insert' ) ";
//echo $query; die;
$dbresult = $db_conn->getDbHandler()->query($query);
if( $dbresult )
{
	if( $user_type== "Space Provider")
	{
		$form_link='https://profrea.com/space-info?id='.$unique_id;
		$email_subject = "You are just a step away from earning revenue from your workspaces !!!";
		$content = '
			<p style="font-family: Montserrat, sans-serif; font-size: 18px; line-height: 28px;"> Hey <b> '. $first_name . '</b>,</p>
			<p style="font-family: Montserrat, sans-serif; font-size: 18px; line-height: 28px;"> We want to take a second and not only thank you, but also congratulate you on making a GREAT decision today! </p>
			<p style="font-family: Montserrat, sans-serif; font-size: 18px; line-height: 28px;">So welcome aboard – We know you are going to love <a href="https://www.profrea.com/"><b>Profrea</b></a> .  </p>
			<p style="font-family: Montserrat, sans-serif; font-size: 18px; line-height: 28px;"> We believe transparency is the key for success, Download our  <a href="www.profrea.com/datafiles/downloads/terms-of-use.pdf"  download="terms of use"><b> terms of use  </b></a> &nbsp; & let us know in case of any query.</p>
			<p style="font-family: Montserrat, sans-serif; font-size: 18px; line-height: 28px;">Wait no more; follow simple steps here in the link  <a href="'.$form_link.'"><b>Click here to get started</b> </a>.</p>
			<p style="font-family: Montserrat, sans-serif; font-size: 18px; line-height: 28px;">If you have ANY comments, questions or feedback. Please don’t hesitate to let us know, you can also refer our <a href="https://www.profrea.com/faq"><b>FAQ</b></a>   </p>
			<p style="font-family: Montserrat, sans-serif; font-size: 18px; line-height: 28px;">We love hearing from our customers </p>
			';

		$email_message = file_get_contents("../template/partner.html");

		$email_message = str_replace("@@message@@",$content,$email_message);
		

	}
	else
	{
		$email_subject = "Congratulations you are just a step away from starting or extending your entrepreneurial journey!!!  ";
		$email_message = '
			<html><body>
				<p style="font-size:28px;">  </br>&nbsp; <img src="https://www.profrea.com/img/mail.png" `  height="42" width="82">  <b>&nbsp;&nbsp; Welcome to Profrea</b> </p>
				<p style="font-size:15px;"> Hey <b> '. $first_name . '</b>,</p>
				<p style="font-size:15px;">We want to take a second and not only thank you, but also congratulate you on making a GREAT decision today! </p>
				<p style="font-size:15px;">So welcome aboard – I know you are going to love <b>Profrea</b>.  </p>
				<p style="font-size:15px;">We will get back you, after shortlisting some workspaces for you as per your interest. </a>   </p>
				<p style="font-size:15px;">If you have ANY comments, questions or feedback. Please don’t hesitate to let us know, you can also refer our  <a href="https://www.profrea.com/faq">FAQ</a>   </p>
				<p style="font-size:15px;">We love hearing from our customers </p>
				<p style="font-size:15px;"> For Terms of Use, please   <a href="https://www.profrea.com/cancellation-return-policy">click here </a>   </p>
				<p style="font-size:15px;"><br/><br/><b>To your success</b>, </p>
				<p style="font-size:15px; ">Team Profrea </p>
				<p style="font-size:12px; "> <br/><br/><u>Confidentiality Warning</u>: This message and any attachments are intended only for the use of the intended recipient(s), are confidential and may be privileged. If you are not the intended recipient, you are hereby notified that any review, re-transmission, conversion to hard copy, copying, circulation or other use of this message and any attachments is strictly prohibited. If you are not the intended recipient, please notify the sender immediately by return email and delete this message and any attachments from your system. </p>
			</body></html>
			';
	}
	$result = sendMail( $email_subject,$email_message,$email_Id);
	if ($result and isValidEmail($email_Id2) )
	$result = sendMail( $email_subject,$email_message,$email_Id2);
		//sendMail( $email_subject,$email_message,'info@profrea.com',$email_Id,$first_name);
		//sendMail( $email_subject,$email_message,'marketing@profrea.com',$email_Id,$first_name);
		header("Location: ../success"); /* Redirect browser */
		exit();
		//success("Congratulations !!! "," You have successfully registered with us, please check your mail to complete the onboard process.");
	if ($result) {
		header("Location: ../success-provider"); /* Redirect browser */
		exit();
		//success("Congratulations !!! "," You have successfully registered with us, please check your mail to complete the onboard process.");
	} else {
		header("Location: ../falied-provider"); /* Redirect browser */
		exit();
		//failed("Error! "," There is some problem while submitting your request. Please try again");
	}
}
else
{
	header("Location: ../falied-provider"); /* Redirect browser */
	exit();
	//echo 'Query Failed';
}
?>