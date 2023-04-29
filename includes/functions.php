<?php
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
if (isset($_SESSION['ap_profrea_login_id'])) 
{    
    $login_id = $_SESSION['ap_profrea_login_id']; 
}
require_once('./../src/Classes/Model/Database.php');
require_once('./../vendor/autoload.php');
require_once('./../src/mail/sendmail.php');
use App\Classes\Profrea\CountryStateCity;
use App\Classes\Model\Database;

// require_once('./../vendor/laravel/framework/src');
// use Illuminate\Http\Request;

$db_connection = new Database;

use App\Classes\RealEstate\Spaces;
$real_estate = new Spaces();

date_default_timezone_set('Asia/Kolkata');
$action = $_GET['action'];
$today = date("Y-m-d H:i:s");
$rowstate = FALSE;  
$insert = date("Y-m-d h:i:s");

function checkEmail($email) {
   $find1 = strpos($email, '@');
   $find2 = strrpos($email, '.');
   return ($find1 !== false && $find2 !== false && $find2 > $find1);
}
function getslug($string){
	$slug = trim($string); // trim the string
	$slug = preg_replace('/[^a-zA-Z0-9 -]/','',$slug ); // only take alphanumerical characters, but keep the spaces and dashes too...
	$slug = str_replace(' ','-', $slug); // replace spaces by dashes
	$slug = strtolower($slug);  // make it lowercase
	return $slug;
}
function uniques_max_id($table_name)
{
	global $db_connection;
	$sel_table = "SELECT MAX(id) AS maxid FROM $table_name";
	$res_table = $db_connection->getDbHandler()->prepare($sel_table);
	$res_table->execute();
	$row_table = $res_table->fetch(PDO::FETCH_ASSOC);
	$maxid = $row_table['maxid'];
	$random = 10000+$maxid+1;
	$unique = 'BK'.$random;
	return $unique;
}

// Profession Insert
if ($action=='profession_insert')
{
	if(!isset($_POST['full_name']) 
	|| !isset($_POST['profession']) 
	|| !isset($_POST['email']) 
	|| !isset($_POST['phone']) 
	) {
		echo json_encode(
			array(
				'msg'=>"We are sorry, but there appears to be a problem with the form you submitted.",
				'icon'=>'error',
				'title' => 'New Profession Request'
		));
		$_SESSION["mode"] = "error";
		$_SESSION["msg"] = "We are sorry, but there appears to be a problem with the form you submitted.";
		header('Location: index.php');
	}
	$full_name = trim($_POST['full_name']);
	$profession = trim($_POST['profession']);
	$email = trim($_POST['email']);
	$phone = trim($_POST['phone']);

	$sql_space_type_insert = "INSERT INTO `industry_request` (`name`,`profession`,`mail`,`phone`) VALUES(:name,:profession,:mail,:phone)";
	$stmt = $db_connection->getDbHandler()->prepare($sql_space_type_insert);
	$stmt->bindParam(':name', $full_name);
	$stmt->bindParam(':profession', $profession);
	$stmt->bindParam(':mail', $email);
	$stmt->bindParam(':phone', $phone);

	if( $stmt->execute() )
	{

		if($email != ""){
			$email_subject = "Addition of new Profession with Profrea!!!";
			$email_message = '<html><body>
			<p style="font-size:15px;">Hey <b>'.$full_name.'</b>, </p>
			<p style="font-size:15px;">Thank you for interest in Profrea! </p>
			<p style="font-size:15px;">Our executive will soon get in touch with you to help you on boarded with Profrea. </p>
		   <p style="font-size:15px;"><br/><br/><b>Thanks</b>, </p>
			<p style="font-size:15px;">Team Profrea </p>
			<p style="font-size:28px;"><img src="https://www.profrea.com/img/mail.png" height="42" width="82"> </p>
			<p style="font-size:12px;"><br/><br/><u>Confidentiality Warning</u>: This message and any attachments are intended only for the use of the intended recipient(s), are confidential and may be privileged. If you are not the intended recipient, you are hereby notified that any review, re-transmission, conversion to hard copy, copying, circulation or other use of this message and any attachments is strictly prohibited. If you are not the intended recipient, please notify the sender immediately by return email and delete this message and any attachments from your system. </p>
			</body></html>';
			$result = sendMail($email_subject,$email_message,$email);
		   }
   
		   $email_subject = $full_name." - New Profession Request with Profrea!!!";
		   $email_message = '<html><body>
		   <p style="font-size:15px;">Dear Admin, </p>
		   <p style="font-size:15px;">'.$full_name.' has requested to add new Profession in Profrea</p>
		   <p style="font-size:15px;">Name :'.$full_name.'</p>
		   <p style="font-size:15px;">Profession :'.$profession.'</p>
		   <p style="font-size:15px;">Phone :'.$phone.'</p>
		   <p style="font-size:15px;">e-mail :'.$email.'</p>
		  <p style="font-size:15px;"><br/><br/><b>Thanks</b>, </p>
		   <p style="font-size:28px;"><img src="https://www.profrea.com/img/mail.png" height="42" width="82"> </p>
		   <p style="font-size:12px;"><br/><br/><u>Confidentiality Warning</u>: This message and any attachments are intended only for the use of the intended recipient(s), are confidential and may be privileged. If you are not the intended recipient, you are hereby notified that any review, re-transmission, conversion to hard copy, copying, circulation or other use of this message and any attachments is strictly prohibited. If you are not the intended recipient, please notify the sender immediately by return email and delete this message and any attachments from your system. </p>
		   </body></html>';
		   sendMail($email_subject,$email_message,'hello@webchirpy.com');
		   sendMail($email_subject,$email_message,'marketing@profrea.com');
	 	   sendMail($email_subject,$email_message,'saurabh3178@gmail.com');

		echo json_encode(array(
				'msg'=>"Thanks for providing us the details, Our team will get back to you soon.",
				'icon'=>'success',
				'title'=> 'Profession Request'
		));
	
	}
	else
	{
		echo 'Query Failed';
	}
}
// Profile Update
elseif ($action=='profile_update')
{
	if(!isset($_POST['phone']) 
	|| !isset($_POST['email']) 
	|| !isset($_POST['id']) 
	|| !isset($_POST['gender']) 
	|| !isset($_POST['city']) 
	) {
		die(json_encode(
			array(
				'msg'=>"We are sorry, but there appears to be a problem with the form you submitted.",
				'icon'=>'error',
				'title' => 'Profile Update'
		)));
	}
	$id = trim($_POST['id']);
	$phone = trim($_POST['phone']);
	$email = trim($_POST['email']);
	$gender = trim($_POST['gender']);
	$city = trim($_POST['city']);
	$rowstate = trim(($_POST['rowstate'] == 0?1:$_POST['rowstate']));
	$profession_id = trim($_POST['profession_id']);
	$education = trim((isset($_POST['education'])?$_POST['education']:""));
	$speciality = trim((isset($_POST['speciality'])?$_POST['speciality']:""));
	$experiance = trim((isset($_POST['experiance'])?$_POST['experiance']:""));
	$about = trim((isset($_POST['about'])?$_POST['about']:""));
	$profileImg = $photoDoc = $regDoc = $indemnitoDoc = "";
	if (isset($_FILES['profileImage']['name']))
	{
		$info = pathinfo($_FILES['profileImage']['name']);
		if($info["basename"] !== ""){
			$ext = $info['extension']; // get the extension of the file
			$newname = $id.date("Y_m_d_H_m_s").".".$ext;
			$profileImg = $newname;
			$target = dirname(__DIR__).'/datafiles/uploads/profiles/'.$newname;
			move_uploaded_file( $_FILES['profileImage']["tmp_name"], $target);
		}
	}
	if (isset($_FILES['photo_doc']['name']))
	{
		$info = pathinfo($_FILES['photo_doc']['name']);
		if($info["basename"] !== ""){
			$ext = $info['extension']; // get the extension of the file
			$newname = $id.date("Y_m_d_H_m_s").".".$ext;
			$photoDoc = $newname;
			$target = dirname(__DIR__).'/datafiles/uploads/photoId/'.$newname;
			move_uploaded_file( $_FILES['photo_doc']["tmp_name"], $target);
		}
	}
	if (isset($_FILES['reg_doc']['name']))
	{
		$info = pathinfo($_FILES['reg_doc']['name']);
		if($info["basename"] !== ""){
			$ext = $info['extension']; // get the extension of the file
			$newname = $id.date("Y_m_d_H_m_s").".".$ext;
			$regDoc = $newname;
			$target = dirname(__DIR__).'/datafiles/uploads/regDoc/'.$newname;
			move_uploaded_file( $_FILES['reg_doc']["tmp_name"], $target);
		}
	}
	if (isset($_FILES['indemnity_doc']['name']))
	{
		$info = pathinfo($_FILES['indemnity_doc']['name']);
		if($info["basename"] !== ""){
			$ext = $info['extension']; // get the extension of the file
			$newname = $id.date("Y_m_d_H_m_s").".".$ext;
			$indemnitoDoc = $newname;
			$target = dirname(__DIR__).'/datafiles/uploads/IndemnityDoc/'.$newname;
			move_uploaded_file( $_FILES['indemnity_doc']["tmp_name"], $target);
		}
	}

	// $sql_user_detail_insert = "select * from user_details where user_id = :id";
	// $ustmt = $db_connection->getDbHandler()->prepare($sql_user_detail_insert);
	// $ustmt->bindParam(':id', $id);
	// if($ustmt->execute()){
	// 	$row = $ustmt->fetch(PDO::FETCH_ASSOC);
	// 	if($row !== false){
	// 		$sql_user_update = "UPDATE `user_details` set `education` = :education,`speciality` = :speciality,`experience` = :experience,`about`=:about".( ($regDoc !== ""?",`reg_doc`=:regDoc":"").($photoDoc !== ""?",`photo_doc` = :photoDoc":"").($indemnitoDoc !== ""?",`Indemnity_doc` = :indemnitoDoc":""))." where user_id = :id";
	// 		$udstmt = $db_connection->getDbHandler()->prepare($sql_user_update);
	// 		$udstmt->bindParam(':id', $id);
	// 		$udstmt->bindParam(':education', $education);
	// 		$udstmt->bindParam(':speciality', $speciality);
	// 		$udstmt->bindParam(':experience', $experiance);
	// 		$udstmt->bindParam(':about', $about);			
	// 		if($regDoc !== ""){
	// 			$udstmt->bindParam(':regDoc', $regDoc);
	// 		}
	// 		if($photoDoc !== ""){
	// 			$udstmt->bindParam(':photoDoc', $photoDoc);
	// 		}
	// 		if($indemnitoDoc !== ""){
	// 			$udstmt->bindParam(':indemnitoDoc', $indemnitoDoc);
	// 		}
	// 		if($udstmt->execute()){
	// 			//Do Nothing
	// 		}
	// 	}
	// 	else{
	// 		$sql_user_insert = "INSERT INTO `user_details` (`education`,`speciality`,`experience`,`about`,`user_id`,`reg_doc`,`photo_doc`,`Indemnity_doc`) value (:education,:speciality,:experience,:about,:userId,:regDoc,:photoDoc,:indemnitoDoc)";
	// 		$udstmt = $db_connection->getDbHandler()->prepare($sql_user_insert);
	// 		$udstmt->bindParam(':userId', $id);
	// 		$udstmt->bindParam(':education', $education);
	// 		$udstmt->bindParam(':speciality', $speciality);
	// 		$udstmt->bindParam(':experience', $experiance);
	// 		$udstmt->bindParam(':about', $about);
	// 		$udstmt->bindParam(':regDoc', $regDoc);
	// 		$udstmt->bindParam(':photoDoc', $photoDoc);
	// 		$udstmt->bindParam(':indemnitoDoc', $indemnitoDoc);
	// 		if($udstmt->execute()){
	// 			//Do Nothing
	// 		}
	// 	}
	// }

	$sql_user_insert = "UPDATE `users` SET `mobileNo`=:phone, `email`=:email, `gender_id`=:gender, `city`=:city, rowstate=:rowstate, `education`=:education, `speciality`=:speciality, `experience`=:experience, `about`=:about ".($profileImg !== ""?",profile_picture=:profileImg":"").($regDoc !== ""?",`reg_doc`=:regDoc":"").($photoDoc !== ""?",`photo_doc`=:photoDoc":"").($indemnitoDoc !== ""?",`indemnity_doc`=:indemnitoDoc":"")." WHERE id=:id";
	$stmt = $db_connection->getDbHandler()->prepare($sql_user_insert);
	$stmt->bindParam(':phone', $phone);
	$stmt->bindParam(':email', $email);
	$stmt->bindParam(':gender', $gender);
	$stmt->bindParam(':city', $city);
	$stmt->bindParam(':rowstate', $rowstate);
	$stmt->bindParam(':education', $education);
	$stmt->bindParam(':speciality', $speciality);
	$stmt->bindParam(':experience', $experiance);
	$stmt->bindParam(':about', $about);
	if($profileImg !== ""){
		$stmt->bindParam(':profileImg', $profileImg);
	}
	if($regDoc !== ""){
		$stmt->bindParam(':regDoc', $regDoc);
	}
	if($photoDoc !== ""){
		$stmt->bindParam(':photoDoc', $photoDoc);
	}
	if($indemnitoDoc !== ""){
		$stmt->bindParam(':indemnitoDoc', $indemnitoDoc);
	}
	$stmt->bindParam(':id', $id);
	if( $stmt->execute() )
	{
		echo json_encode(array(
			'msg'=>"Congratulations !!! You have successfully submitted details.",
			'icon'=>'success',
			'title'=> 'Profession'
		));
	}
	else
	{
		echo '1';
	}
}
//Website Update
elseif ($action=='website_update')
{
	if(!isset($_POST['domain']) 
	|| !isset($_POST['fbLink']) 
	|| !isset($_POST['twitterLink']) 
	|| !isset($_POST['inLink']) 
	|| !isset($_POST['instaLink']) 
	|| !isset($_POST['service']) 
	|| !isset($_POST['story'])
	) {
		die(json_encode(
			array(
				'msg'=>"We are sorry, but there appears to be a problem with the form you submitted.",
				'icon'=>'error',
				'title' => 'Website Update'
		)));
	}
	$domain = trim($_POST['domain']);
	
	if($_POST['fbLink']!=""){
		$fbLink = trim(strpos($_POST['fbLink'],"http")) === false?"http://".$_POST["fbLink"]:$_POST["fbLink"];
	}else {
		$fbLink = "";
	}

	if($_POST['twitterLink']!=""){
		$twitterLink = trim(strpos($_POST['twitterLink'],"http") === false?"http://".$_POST["twitterLink"]:$_POST["twitterLink"]);
	
	}else {
		$twitterLink = "";
	}

	if($_POST['google_review_link']!=""){
		$google_review_link = $_POST['google_review_link'];
	
	}else {
		$google_review_link = "";
	}

	if($_POST['inLink']!=""){
		$inLink = trim(strpos($_POST['inLink'],"http") === false?"http://".$_POST["inLink"]:$_POST["inLink"]);
	
	}else {
		$inLink = "";
	}

	if($_POST['instaLink']!=""){
		$instaLink = trim(strpos($_POST['instaLink'],"http") === false?"http://".$_POST["instaLink"]:$_POST["instaLink"]);
	
	}else {
		$instaLink = "";
	}

	$service = trim($_POST['service']);
	$story = trim($_POST['story']);
	
	$domain_name = getslug($domain);
	$query = "SELECT * FROM website_details WHERE domain='$domain_name' AND user_id!=$login_id";
	$result = $db_connection->getDbHandler()->query($query); 
	$row_domain = $result->fetch();
	if($row_domain)
	{
		echo json_encode(array(
			'msg'=>"Domain Name Already Exist!",
			'icon'=>'error',
			'title'=> 'Error'
		));
	}
	else{
		$sql_user_detail_insert = "SELECT * FROM website_details WHERE user_id = :id";
		$ustmt = $db_connection->getDbHandler()->prepare($sql_user_detail_insert);
		$ustmt->bindParam(':id', $login_id);
		if($ustmt->execute()){
			$row = $ustmt->fetch(PDO::FETCH_ASSOC);
			if($row !== false){
				$sql_user_update = "UPDATE `website_details` set `domain` = :domain,`fb_link` = :fbLink,`twitter_link` = :twitterLink,`linkedin_link` = :linkedinLink,`insta_link` = :instaLink,`rowservice` = :services,`story` = :story,`google_review_link`=:google_review_link where user_id = :id";
				$udstmt = $db_connection->getDbHandler()->prepare($sql_user_update);
				$udstmt->bindParam(':id', $login_id);
				$udstmt->bindParam(':domain', $domain_name);
				$udstmt->bindParam(':fbLink', $fbLink);
				$udstmt->bindParam(':twitterLink', $twitterLink);
				$udstmt->bindParam(':linkedinLink', $inLink);
				$udstmt->bindParam(':instaLink', $instaLink);
				$udstmt->bindParam(':services', $service);
				$udstmt->bindParam(':story', $story);
				$udstmt->bindParam(':google_review_link', $google_review_link);
				if($udstmt->execute()){
					echo json_encode(array(
						'msg'=>"Congratulations !!! You have successfully submitted details.",
						'icon'=>'success',
						'title'=> 'Website Details'
					));
				}
				else{
					echo '11';
				}
			}
			else{
				$sql_user_insert = "INSERT INTO `website_details` (`domain`,`fb_link`,`twitter_link`,`linkedin_link`,`insta_link`,`rowservice`,`story`,`user_id`,`google_review_link`) value (:domain,:fbLink,:twitterLink,:linkedinLink,:instaLink,:services,:story,:id,:google_review_link)";
				$udstmt = $db_connection->getDbHandler()->prepare($sql_user_insert);
				$udstmt->bindParam(':id', $login_id);
				$udstmt->bindParam(':domain', $domain_name);
				$udstmt->bindParam(':fbLink', $fbLink);
				$udstmt->bindParam(':twitterLink', $twitterLink);
				$udstmt->bindParam(':linkedinLink', $inLink);
				$udstmt->bindParam(':instaLink', $instaLink);
				$udstmt->bindParam(':services', $service);
				$udstmt->bindParam(':story', $story);
				$udstmt->bindParam(':google_review_link', $google_review_link);
				if($udstmt->execute()){
					echo json_encode(array(
						'msg'=>"Congratulations !!! You have successfully submitted details.",
						'icon'=>'success',
						'title'=> 'Website Details'
					));
				}
				else{
					echo '1';
				}
			}
		}
		else{
			echo '1';
		}
	}
}

//Clinic delete
elseif ($action=='deleteclinic')
{
	if(!isset($_POST['clinicid'])) {
		die(json_encode(
			array(
				'msg'=>"We are sorry, but there appears to be a problem with the form you submitted.",
				'icon'=>'error',
				'title' => 'Clinic Delete'
		)));
	}
	$clinicid = trim($_POST['clinicid']);
	$userid = $_SESSION['ap_profrea_login_id'];

	
	
			$sql_user_insert = "DELETE from `clinic_details` where id=:clinicid and user_id=:userid";
			$udstmt = $db_connection->getDbHandler()->prepare($sql_user_insert);
			$udstmt->bindParam(':clinicid', $clinicid);
			$udstmt->bindParam(':userid', $userid);
			// var_dump($udstmt->execute());
			if($udstmt->execute()){
				echo json_encode(array(
					'msg'=>"",
					'icon'=>'success',
					'title'=> 'Clinic Removed'
				));
			}
			else{
				die(json_encode(
					array(
						'msg'=>"We are sorry, but there appears to be a problem with the form you submitted.",
						'icon'=>'error',
						'title' => 'Clinic Add Failed'
				)));
			}

}


//Clinic delete
elseif ($action=='deletevideo')
{
	if(!isset($_POST['videoid'])) {
		die(json_encode(
			array(
				'msg'=>"",
				'icon'=>'error',
				'title' => 'Unable to Delte Video'
		)));
	}
	$ytlinkid = trim($_POST['videoid']);
	$userid = $_SESSION['ap_profrea_login_id'];

	$sql_user_insert = "DELETE from `clinic_yt_videos` where id=:ytlinkid and user_id=:userid";
	$udstmt = $db_connection->getDbHandler()->prepare($sql_user_insert);
	$udstmt->bindParam(':ytlinkid', $ytlinkid);
	$udstmt->bindParam(':userid', $userid);
	// var_dump($udstmt->execute());
	if($udstmt->execute()){
		echo json_encode(array(
			'msg'=>"",
			'icon'=>'success',
			'title'=> 'Video Removed'
		));
	} else {
		die(json_encode(
			array(
				'msg'=>"",
				'icon'=>'error',
				'title' => 'Unable to delete our video'
		)));
	}

}



//gallery delete 
elseif ($action=='deletegallery')
{
	if(!isset($_POST['galleryid'])) {
		die(json_encode(
			array(
				'msg'=>"",
				'icon'=>'error',
				'title' => 'Unable to Delete Gallery '
		)));
	}
	$galleryid = trim($_POST['galleryid']);
	$galleryname = trim($_POST['galleryname']);
	$userid = $_SESSION['ap_profrea_login_id'];

			$sql_user_insert = "DELETE from `clinic_gallery` where id=:galleryid and user_id=:userid";
			$udstmt = $db_connection->getDbHandler()->prepare($sql_user_insert);
			$udstmt->bindParam(':galleryid', $galleryid);
			$udstmt->bindParam(':userid', $userid);
			// var_dump($udstmt->execute());
			if($udstmt->execute()){

				if ($galleryname !=="" && file_exists("../datafiles/uploads/clinicImg/".$galleryname)) {
					unlink("../datafiles/uploads/clinicImg/".$galleryname);
				}


				echo json_encode(array(
					'msg'=>"",
					'icon'=>'success',
					'title'=> 'Image Removed'
				));
			}
			else{
				die(json_encode(
					array(
						'msg'=>"",
						'icon'=>'error',
						'title' => 'Unable to Delete Gallery '
				)));
			}

}

elseif($action == "booking-emergency-cancel") {
	// print_r($_POST); die;
	
	if( !isset($_POST['from_date'])
	|| !isset($_POST['reason']) ) {
		die(json_encode(
			array(
				'msg'=>"We are sorry, but there appears to be a problem with the form you submitted.",
				'icon'=>'error',
				'title' => 'Emergency Cancel'
		)));
	}

	$from_date 		= trim(date('Y-m-d', strtotime($_POST['from_date'])));
	$to_date 		= trim(date('Y-m-d', strtotime($_POST['from_date'])));
	$schedule_type 	= 'emergency';
	$reason 		= trim($_POST['reason']);
	$booking_status = 2;

	$sql_users					= "SELECT id,booking_no,payment_id,doctor_id,user_id,booking_date,booking_time FROM booking_details as a WHERE a.doctor_id = ".$login_id . " AND a.booking_date = '$from_date' AND a.booking_status = 0";
	$check_users				= $db_connection->getDbHandler()->query($sql_users);
	$exist_user					= $check_users->fetchAll();
	if(count($exist_user) > 0)
	{
		foreach($exist_user as $booking)
		{
			$booking_no = $booking['booking_no'];
			$sql_bkupdate = "UPDATE `booking_details` set `booking_status` = :bookingstatus, `reason` = :reason where booking_no = :bookingno";
			$bkupdate = $db_connection->getDbHandler()->prepare($sql_bkupdate);

			$bkupdate->bindParam(':reason', $reason);
			$bkupdate->bindParam(':bookingstatus', $booking_status);
			$bkupdate->bindParam(':bookingno', $booking_no);
			$bkupdate->execute();

			$doctor_id 	= $booking['doctor_id'];
			$user_id 	= $booking['user_id'];
			$payment_id = $booking['payment_id'];

			$booking_date_time = $booking['booking_date'].$booking['booking_time'];
	
			$query_user = "SELECT id,name,email,mobileNo FROM users WHERE id='$user_id'";
			$res_users = $db_connection->getDbHandler()->query($query_user);
			$row_users = $res_users->fetch();

			$query_doctor = "SELECT id,name,email,mobileNo FROM users WHERE id='$doctor_id'";
			$res_doctor = $db_connection->getDbHandler()->query($query_doctor);
			$row_doctor = $res_doctor->fetch();
			
			try {
				if($row_users['email']){
					$email_subject = "Emergency Cancellation of Booking From Profrea!!!";
							
					$user_email = file_get_contents("../template/slot-emergency-user.html");
					$user_email = str_replace("@@name@@",$row_users['name'],$user_email);
					$user_email = str_replace("@@razorpay_payment_id@@",$payment_id,$user_email);
					$user_email = str_replace("@@date_time@@",date('d-M-y, g:i A', strtotime($booking_date_time)),$user_email);
					$user_email = str_replace("@@doctor_name@@",$row_doctor['name'],$user_email);
					
					$result = sendMail( $email_subject,$user_email, $row_users['email']);
				}
			} catch (Exception $e){

			}
		}
	}

	$sql_user_insert = "INSERT INTO `holidays` (`doctor_id`,`from_date`,`to_date`,`schedule_type`,`reason`) value (:id,:from_date,:to_date,:schedule_type,:reason)";
	$udstmt = $db_connection->getDbHandler()->prepare($sql_user_insert);
	$udstmt->bindParam(':id', $login_id);
	$udstmt->bindParam(':from_date', $from_date);
	$udstmt->bindParam(':to_date', $to_date);
	$udstmt->bindParam(':schedule_type', $schedule_type);
	$udstmt->bindParam(':reason', $reason);
	if($udstmt->execute()){

		echo json_encode(array(
			'msg'=>"",
			'icon'=>'success',
			'title'=> 'Emergency Cancel Updated'
		));
	}
	else{
		die(json_encode(
			array(
				'msg'=>"We are sorry, but there appears to be a problem with the form you submitted.",
				'icon'=>'error',
				'title' => 'Emergency Cancel Failed'
		)));
	}
}

elseif ($action=='holiday')
{
	if( !isset($_POST['from_date'])
	|| !isset($_POST['to_date']) 
	|| !isset($_POST['schedule_type'])) {
		die(json_encode(
			array(
				'msg'=>"We are sorry, but there appears to be a problem with the form you submitted.",
				'icon'=>'error',
				'title' => 'Holiday Create'
		)));
	}

	$from_date 		= trim(date('Y-m-d', strtotime($_POST['from_date'])));
	$to_date 		= trim(date('Y-m-d', strtotime($_POST['to_date'])));
	$schedule_type 	= trim($_POST['schedule_type']);
	$reason 		= trim($_POST['reason']);

	$sql_user_insert = "INSERT INTO `holidays` (`doctor_id`,`from_date`,`to_date`,`schedule_type`,`reason`) value (:id,:from_date,:to_date,:schedule_type,:reason)";
	$udstmt = $db_connection->getDbHandler()->prepare($sql_user_insert);
	$udstmt->bindParam(':id', $login_id);
	$udstmt->bindParam(':from_date', $from_date);
	$udstmt->bindParam(':to_date', $to_date);
	$udstmt->bindParam(':schedule_type', $schedule_type);
	$udstmt->bindParam(':reason', $reason);
	if($udstmt->execute()){
		echo json_encode(array(
			'msg'=>"",
			'icon'=>'success',
			'title'=> 'Holidays Details Added'
		));
	}
	else{
		die(json_encode(
			array(
				'msg'=>"We are sorry, but there appears to be a problem with the form you submitted.",
				'icon'=>'error',
				'title' => 'Holidays Add Failed'
		)));
	}
}

elseif ($action=='deleteSpeciality')
{
	if(!isset($_POST['speciality'])) {
		die(json_encode(
			array(
				'msg'=>"We are sorry, but there appears to be a problem with the form you submitted.",
				'icon'=>'error',
				'title' => 'Speciality Delete'
		)));
	}
	$speciality = trim($_POST['speciality']);
	$doctor_id 	= $_SESSION['ap_profrea_login_id'];

	$sql_user_insert = "DELETE from `user_speciality` where id=:speciality and doctor_id=:doctor_id";
	$udstmt = $db_connection->getDbHandler()->prepare($sql_user_insert);
	$udstmt->bindParam(':speciality', $speciality);
	$udstmt->bindParam(':doctor_id', $doctor_id);
	if($udstmt->execute()){
		echo json_encode(array(
			'msg'=>"",
			'icon'=>'success',
			'title'=> 'Speciality Removed'
		));
	}
	else{
		die(json_encode(
			array(
				'msg'=>"We are sorry, but there appears to be a problem with the form you submitted.",
				'icon'=>'error',
				'title' => 'Speciality Remove Failed'
		)));
	}
}
elseif ($action=='deleteHoliday')
{
	if(!isset($_POST['holidayid'])) {
		die(json_encode(
			array(
				'msg'=>"We are sorry, but there appears to be a problem with the form you submitted.",
				'icon'=>'error',
				'title' => 'Holiday Delete'
		)));
	}
	$holidayid = trim($_POST['holidayid']);
	$doctor_id = $_SESSION['ap_profrea_login_id'];

	$sql_user_insert = "DELETE from `holidays` where id=:holidayid and doctor_id=:doctor_id";
	$udstmt = $db_connection->getDbHandler()->prepare($sql_user_insert);
	$udstmt->bindParam(':holidayid', $holidayid);
	$udstmt->bindParam(':doctor_id', $doctor_id);
	if($udstmt->execute()){
		echo json_encode(array(
			'msg'=>"",
			'icon'=>'success',
			'title'=> 'Holiday Removed'
		));
	}
	else{
		die(json_encode(
			array(
				'msg'=>"We are sorry, but there appears to be a problem with the form you submitted.",
				'icon'=>'error',
				'title' => 'Holiday Remove Failed'
		)));
	}
}

elseif ($action=='holiday_update')
{
	if( !isset($_POST['from_date']) 
	|| !isset($_POST['to_date']) 
	|| !isset($_POST['status'])
	|| !isset($_POST['schedule_type']) ) {
		die(json_encode(
			array(
				'msg'=>"We are sorry, but there appears to be a problem with the form you submitted.",
				'icon'=>'error',
				'title' => 'Holiday Update'
		)));
	}
	$hid 			= trim($_POST['holidayid']);
	$from_date 		= trim(date('Y-m-d', strtotime($_POST['from_date'])));
	$to_date 		= trim(date('Y-m-d', strtotime($_POST['to_date'])));
	$schedule_type 	= trim($_POST['schedule_type']);
	$reason 		= trim($_POST['reason']);
	$status 		= trim($_POST['status']);

	$sql_user_insert = "UPDATE `holidays` set `from_date`=:from_date,`to_date`=:to_date,`schedule_type`=:schedule_type,`reason`=:reason,`status`=:status WHERE id=:hid";
	$udstmt = $db_connection->getDbHandler()->prepare($sql_user_insert);

	$udstmt->bindParam(':from_date', $from_date);
	$udstmt->bindParam(':to_date', $to_date);
	$udstmt->bindParam(':schedule_type', $schedule_type);
	$udstmt->bindParam(':reason', $reason);
	$udstmt->bindParam(':status', $status);
	$udstmt->bindParam(':hid', $hid);

	if($udstmt->execute()){
		echo json_encode(array(
			'msg'=>"",
			'icon'=>'success',
			'title'=> 'Holiday Details Updated'
		));
	}
	else{
		die(json_encode(
			array(
				'msg'=>"We are sorry, but there appears to be a problem with the form you submitted.",
				'icon'=>'error',
				'title' => 'Holiday Update Failed'
		)));
	}
}
elseif ($action=='add_specialist')
{
	if( !isset($_POST['speciality']) ) {
		die(json_encode(
			array(
				'msg'=>"We are sorry, but there appears to be a problem with the form you submitted.",
				'icon'=>'error',
				'title' => 'Specialist Create'
		)));
	}
	$name 		= $_POST['speciality'];
	$user 		= $_POST['userid'];

	foreach ($name as $key => $value) {
		$sql_user_insert = "INSERT INTO `user_speciality` (`doctor_id`,`speciality_name`) value (:id,:speciality_name)";
		$udstmt = $db_connection->getDbHandler()->prepare($sql_user_insert);
		$udstmt->bindParam(':id', $user);
		$udstmt->bindParam(':speciality_name', $_POST['speciality'][$key]);
		$udstmt->execute();
	}
	echo json_encode(array(
		'msg'=>"Speciality Added",
		'icon'=>'success',
		'title'=> 'Speciality'
	));

	// $sql_user_insert = "INSERT INTO `family_members` (`user_id`,`name`,`dob`,`relation`,`gender`) value (:id,:name,:dob,:relation,:gender)";
	// $udstmt = $db_connection->getDbHandler()->prepare($sql_user_insert);
	// $udstmt->bindParam(':id', $login_id);
	// $udstmt->bindParam(':name', $name);
	// if($udstmt->execute()){
	// 	echo json_encode(array(
	// 		'msg'=>"",
	// 		'icon'=>'success',
	// 		'title'=> 'Family Member Details Added'
	// 	));
	// }
	// else{
	// 	die(json_encode(
	// 		array(
	// 			'msg'=>"We are sorry, but there appears to be a problem with the form you submitted.",
	// 			'icon'=>'error',
	// 			'title' => 'Family Member Add Failed'
	// 	)));
	// }
}

// family members
elseif ($action=='familyMembers')
{
	if( !isset($_POST['name']) 
	|| !isset($_POST['dob']) 
	|| !isset($_POST['relation'])
	|| !isset($_POST['gender']) ) {
		die(json_encode(
			array(
				'msg'=>"We are sorry, but there appears to be a problem with the form you submitted.",
				'icon'=>'error',
				'title' => 'Family Member Create'
		)));
	}
	$name 		= trim($_POST['name']);
	$dob 		= trim(date('Y-m-d', strtotime($_POST['dob'])));
	$relation 	= trim($_POST['relation']);
	$gender 	= trim($_POST['gender']);

	$sql_user_insert = "INSERT INTO `family_members` (`user_id`,`name`,`dob`,`relation`,`gender`) value (:id,:name,:dob,:relation,:gender)";
	$udstmt = $db_connection->getDbHandler()->prepare($sql_user_insert);
	$udstmt->bindParam(':id', $login_id);
	$udstmt->bindParam(':name', $name);
	$udstmt->bindParam(':dob', $dob);
	$udstmt->bindParam(':relation', $relation);
	$udstmt->bindParam(':gender', $gender);
	if($udstmt->execute()){
		echo json_encode(array(
			'msg'=>"",
			'icon'=>'success',
			'title'=> 'Family Member Details Added'
		));
	}
	else{
		die(json_encode(
			array(
				'msg'=>"We are sorry, but there appears to be a problem with the form you submitted.",
				'icon'=>'error',
				'title' => 'Family Member Add Failed'
		)));
	}
}
elseif ($action=='family_member_update')
{
	if( !isset($_POST['name']) 
	|| !isset($_POST['dob']) 
	|| !isset($_POST['relation'])
	|| !isset($_POST['gender']) ) {
		die(json_encode(
			array(
				'msg'=>"We are sorry, but there appears to be a problem with the form you submitted.",
				'icon'=>'error',
				'title' => 'Family Member Update'
		)));
	}
	$mid 		= trim($_POST['memberid']);
	$name 		= trim($_POST['name']);
	$dob 		= trim(date('Y-m-d', strtotime($_POST['dob'])));
	$relation 	= trim($_POST['relation']);
	$gender 	= trim($_POST['gender']);

	$sql_user_insert = "UPDATE `family_members` set `name`=:name,`dob`=:dob,`relation`=:relation,`gender`=:gender WHERE id=:mid";
	$udstmt = $db_connection->getDbHandler()->prepare($sql_user_insert);

	$udstmt->bindParam(':name', $name);
	$udstmt->bindParam(':dob', $dob);
	$udstmt->bindParam(':relation', $relation);
	$udstmt->bindParam(':gender', $gender);
	$udstmt->bindParam(':mid', $mid);

	if($udstmt->execute()){
		echo json_encode(array(
			'msg'=>"",
			'icon'=>'success',
			'title'=> 'Family Member Details Updated'
		));
	}
	else{
		die(json_encode(
			array(
				'msg'=>"We are sorry, but there appears to be a problem with the form you submitted.",
				'icon'=>'error',
				'title' => 'Family Member Update Failed'
		)));
	}
}

elseif ($action=='deleteFamilyMember')
{
	if(!isset($_POST['memberid'])) {
		die(json_encode(
			array(
				'msg'=>"We are sorry, but there appears to be a problem with the form you submitted.",
				'icon'=>'error',
				'title' => 'Family Member Delete'
		)));
	}
	$memberid = trim($_POST['memberid']);
	$userid = $_SESSION['ap_profrea_login_id'];

	$sql_user_insert = "DELETE from `family_members` where id=:memberid and user_id=:userid";
	$udstmt = $db_connection->getDbHandler()->prepare($sql_user_insert);
	$udstmt->bindParam(':memberid', $memberid);
	$udstmt->bindParam(':userid', $userid);
	if($udstmt->execute()){
		echo json_encode(array(
			'msg'=>"",
			'icon'=>'success',
			'title'=> 'Family Member Removed'
		));
	}
	else{
		die(json_encode(
			array(
				'msg'=>"We are sorry, but there appears to be a problem with the form you submitted.",
				'icon'=>'error',
				'title' => 'Family Member Remove Failed'
		)));
	}
}

//Clinic Add
elseif ($action=='clinicAdd')
{
	if(!isset($_POST['name']) 
	|| !isset($_POST['address']) 
	|| !isset($_POST['time_slot']) 
	) {
		die(json_encode(
			array(
				'msg'=>"We are sorry, but there appears to be a problem with the form you submitted.",
				'icon'=>'error',
				'title' => 'Clinic Create'
		)));
	}
	$name = trim($_POST['name']);
	$address = trim($_POST['address']);
	$time_slot = trim($_POST['time_slot']);

	$map_link = trim($_POST['map_link']);
	$clinic_phone = trim($_POST['clinic_phone']);
	$today =  date("Y-m-d H:i:s");

			$sql_user_insert = "INSERT INTO `clinic_details` (`user_id`,`name`,`address`,`time_slot`,`created_at`,`contact_number`,`google_map_link`) value (:id,:name,:address,:time,:created,:contact_number,:google_map_link)";
			$udstmt = $db_connection->getDbHandler()->prepare($sql_user_insert);
			$udstmt->bindParam(':id', $login_id);
			$udstmt->bindParam(':name', $name);
			$udstmt->bindParam(':address', $address);
			$udstmt->bindParam(':time', $time_slot);
			$udstmt->bindParam(':google_map_link', $map_link);
			$udstmt->bindParam(':contact_number', $clinic_phone);
			//$udstmt->bindParam(':images', $images);
			$udstmt->bindParam(':created',$today);
			// var_dump($udstmt->execute());
			if($udstmt->execute()){
				echo json_encode(array(
					'msg'=>"",
					'icon'=>'success',
					'title'=> 'Clinic Details Added'
				));
			}
			else{
				die(json_encode(
					array(
						'msg'=>"We are sorry, but there appears to be a problem with the form you submitted.",
						'icon'=>'error',
						'title' => 'Clinic Add Failed'
				)));
			}

}


//Clinic Add
elseif ($action=='youtubeAdd')
{
	if(!isset($_POST['ytlink']) 
	) {
		die(json_encode(
			array(
				'msg'=>"",
				'icon'=>'error',
				'title' => 'Unable to embed Youtube Link'
		)));
	}
	$ytlink = trim($_POST['ytlink']);

			$sql_user_insert = "INSERT INTO `clinic_yt_videos` (`user_id`,`ytlink`) value (:id,:ytlink)";
			$udstmt = $db_connection->getDbHandler()->prepare($sql_user_insert);
			$udstmt->bindParam(':id', $login_id);
			$udstmt->bindParam(':ytlink', $ytlink);
			// var_dump($udstmt->execute());
			if($udstmt->execute()){
				echo json_encode(array(
					'msg'=>"",
					'icon'=>'success',
					'title'=> 'Video Added to your profile'
				));
			}
			else{
				die(json_encode(
					array(
						'msg'=>"",
						'icon'=>'error',
						'title' => 'Unable to add Video'
				)));
			}

}
elseif ($action=='timeslot-clinic')
{
	// echo'<pre>';print_r($_POST);die;
	if( !isset($_POST['day']))
	{
		echo json_encode(array(
			'status' 	=> false,
			'msg'		=> "Unable to Process Check missing fields",
			'icon'		=> 'error',
			'title'		=> 'Validation Error'
		));
		return true;
	}
	
	$errors['clinic_slot_interval'] = $errors['clinic_booking_open_upto'] = $errors['clinic_booking_slot_status'] = $errors['clinic_amount'] = $errors['monday_clinic_start_time'] = $errors['tuesday_clinic_start_time'] = $errors['wednesday_clinic_start_time'] = $errors['thursday_clinic_start_time'] = $errors['friday_clinic_start_time'] = $errors['saturday_clinic_start_time'] = $errors['sunday_clinic_start_time'] = $errors['monday_clinic_end_time'] = $errors['tuesday_clinic_end_time'] = $errors['wednesday_clinic_end_time'] = $errors['thursday_clinic_end_time'] = $errors['friday_clinic_end_time'] = $errors['saturday_clinic_end_time'] = $errors['sunday_clinic_end_time'] = '';

	$status    = $dayStatus['sunday']    = $dayStatus['monday'] = $dayStatus['tuesday'] = $dayStatus['wednesday'] = $dayStatus['thursday'] = $dayStatus['friday'] = $dayStatus['saturday']    = false;
	
	foreach ($_POST['day'] as $value) {
		if(isset($_POST["clinic_is_available"][$value]) && $_POST["clinic_is_available"][$value] == 1) {
			if(!isset($_POST['clinic_start_time']) || empty($_POST["clinic_start_time"][$value])) {
				$errors[$value.'_clinic_start_time']  = 'This field is required';
			}
			if(!isset($_POST['clinic_end_time']) || empty($_POST["clinic_end_time"][$value])) {
				$errors[$value.'_clinic_end_time']  = 'This field is required';
			} else {
				if(strtotime($_POST["clinic_start_time"][$value]) >= strtotime($_POST["clinic_end_time"][$value])) {
					$errors[$value.'_clinic_end_time'] = 'End time should be greater than start time';
				} else {
					if (isset($_POST['day_time_slots'][$value]) && count($_POST['day_time_slots'][$value]) > 0) {
						$dayStatus[$value]    = true;
					} else {
						$errors[$value.'_clinic_end_time'] = 'Please select atlease one time slot.';
					}
				}
			}
		} else {
			$dayStatus[$value]    = true;
		}
	}
	
	$dayStatus['clinic_slot_interval']    = $dayStatus['clinic_booking_open_upto']    = $dayStatus['clinic_booking_slot_status']    = $dayStatus['clinic_amount'] = true;

	if( !isset($_POST['clinic_slot_interval']) && $_POST['clinic_slot_interval'] == "") {
		$errors['clinic_slot_interval']	= 'This field is required';
		$dayStatus['clinic_slot_interval']	= false;
	}
	if( !isset($_POST['clinic_booking_open_upto']) && $_POST['clinic_booking_open_upto'] == "" || $_POST['clinic_booking_open_upto'] == 0) {
		$errors['clinic_booking_open_upto'] = 'This field is required';
		if ($_POST['clinic_booking_open_upto'] <= 0 ) {
			$errors['clinic_booking_open_upto'] = 'Minimum booking slot open upto 1 day';
		}
		$dayStatus['clinic_booking_open_upto'] = false;
	}
	if( !isset($_POST['clinic_booking_slot_status']) && $_POST['clinic_booking_slot_status'] =="") {
		$errors['clinic_booking_slot_status'] = 'This field is required';
		$dayStatus['clinic_booking_slot_status'] = false;
	}
	if( !isset($_POST['clinic_amount']) && $_POST['clinic_amount'] =="" || $_POST['clinic_amount'] == 0) {
		$errors['clinic_amount'] = 'This field is required';
		if ($_POST['clinic_amount'] <= 0 ) {
			$errors['clinic_amount'] = 'Minimum amount 1rs for Clinic/Video Amount Per Slot.';
		}
		$dayStatus['clinic_amount'] = false;
	}

	if($dayStatus['sunday'] == true && $dayStatus['monday'] == true && $dayStatus['tuesday'] == true && $dayStatus['wednesday'] == true && $dayStatus['thursday'] == true && $dayStatus['friday'] == true && $dayStatus['saturday'] == true && $dayStatus['clinic_slot_interval'] == true && $dayStatus['clinic_booking_open_upto'] == true && $dayStatus['clinic_booking_slot_status'] == true && $dayStatus['clinic_amount'] == true ) {
		$status = true;
	}
	
	if($status == false){
		echo json_encode([
            'status'	=> $status,
            'errors'	=> $errors,
			'msg'		=> "Unable to Process Check missing fields",
			'icon'		=> 'error',
			'title'		=> 'Validation Error'
        ]);
	} else {
		$slotinterval 		= $_POST['clinic_slot_interval'] ?? '10 Mmin';
		$bookingopenupto 	= $_POST['clinic_booking_open_upto'] ?? 1;
		$bookingslotstatus 	= $_POST['clinic_booking_slot_status'] ?? 0;
		$audiovideoamount 	= $_POST['clinic_amount'] ?? 1;

		foreach($_POST['day'] as $result_day)
		{
			$doctor_time_slot_id= null;
			$isavailable		= $_POST['clinic_is_available'][$result_day] ?? 0;
			$clinic_start_time	= $_POST['clinic_start_time'][$result_day] ?? null;
			$clinic_end_time	= $_POST['clinic_end_time'][$result_day] ?? null;
			$type				= 3;

			$sql_doctor_time_slot		= "SELECT id FROM doctor_time_slots as a WHERE a.doctor_id = ".$login_id . " AND a.day = '$result_day' AND a.type = 3";
			$check_doctor_time_slot		= $db_connection->getDbHandler()->query($sql_doctor_time_slot);
			$existing_doctor_time_slot	= $check_doctor_time_slot->fetch();
			if($existing_doctor_time_slot)
			{
				$doctor_time_slot_id = $existing_doctor_time_slot['id'];
				$sql_update = "UPDATE `doctor_time_slots` set `slot_interval` = :slotinterval, `is_available` = :isavailable, `day` = :slot_day, `start_time` = :start_time, `end_time` = :end_time, `type` = :slot_type where id = :id";
				$video = $db_connection->getDbHandler()->prepare($sql_update);
				$video->bindParam(':id', $doctor_time_slot_id);
				$video->bindParam(':slot_day', $result_day);
				$video->bindParam(':isavailable', $isavailable);
				$video->bindParam(':start_time', $clinic_start_time);
				$video->bindParam(':end_time', $clinic_end_time);
				$video->bindParam(':slotinterval', $slotinterval);
				$video->bindParam(':slot_type', $type);
				$video->execute();

				$sql_delete_time_slot	= "DELETE from `doctor_day_time_slots` where doctor_time_slot_id=".$doctor_time_slot_id;
				$delete_stmt			= $db_connection->getDbHandler()->prepare($sql_delete_time_slot);
				$delete_stmt->execute();
				if ($isavailable) {
					if (isset($_POST['day_time_slots'][$result_day])) {
						foreach($_POST['day_time_slots'][$result_day] as $day_time_slot) {
							$sql_slots = "INSERT INTO doctor_day_time_slots (`doctor_time_slot_id`, `slot_time`) VALUES( $doctor_time_slot_id, '$day_time_slot')";
							$res_slots = $db_connection->getDbHandler()->query($sql_slots);
						}
					}
				}
			} else {
				$sql_insert = "INSERT INTO `doctor_time_slots` (`doctor_id`, `day`, `is_available`, `start_time`, `end_time`, `slot_interval`, `type`) value (:doctor_id, :slot_day, :isavailable, :start_time, :end_time, :slotinterval, :slot_type)";

				$video = $db_connection->getDbHandler()->prepare($sql_insert);
				$video->bindParam(':doctor_id', $login_id);
				$video->bindParam(':slot_day', $result_day);
				$video->bindParam(':isavailable', $isavailable);
				$video->bindParam(':start_time', $clinic_start_time);
				$video->bindParam(':end_time', $clinic_end_time);
				$video->bindParam(':slotinterval', $slotinterval);
				$video->bindParam(':slot_type', $type);
				$video->execute();
				$doctor_time_slot_id = $db_connection->lastInsertId();

				if ($isavailable) {
					if (isset($_POST['day_time_slots'][$result_day])) {
						foreach($_POST['day_time_slots'][$result_day] as $day_time_slot) {
							$sql_slots = "INSERT INTO doctor_day_time_slots (`doctor_time_slot_id`, `slot_time`) VALUES( $doctor_time_slot_id, '$day_time_slot')";
							$res_slots = $db_connection->getDbHandler()->query($sql_slots);
						}
					}
				}
			}
		}

		$sql_website_detail_insert = "SELECT * FROM website_details WHERE user_id = :id";
		$website = $db_connection->getDbHandler()->prepare($sql_website_detail_insert);
		$website->bindParam(':id', $login_id);
		if($website->execute()){
			$row = $website->fetch(PDO::FETCH_ASSOC);
			if($row !== false){
				$sql_website_update = "UPDATE `website_details` set `clinic_slot_interval` = :slotinterval, `clinic_booking_open_upto` = :bookingopenupto, `clinic_booking_slot_status` = :bookingslotstatus, `clinic_amount` = :audiovideoamount where user_id = :id";
				$website_details = $db_connection->getDbHandler()->prepare($sql_website_update);
				$website_details->bindParam(':id', $login_id);
				$website_details->bindParam(':slotinterval', $slotinterval);
				$website_details->bindParam(':bookingopenupto', $bookingopenupto);
				$website_details->bindParam(':bookingslotstatus', $bookingslotstatus);
				$website_details->bindParam(':audiovideoamount', $audiovideoamount);
				$website_details->execute();
			}
			else{
				$sql_website_insert = "INSERT INTO `website_details` (`clinic_slot_interval`,`user_id`,`clinic_booking_open_upto`,`clinic_booking_slot_status`,`clinic_amount`) value (:slotinterval,:id,:bookingopenupto,:bookingslotstatus,:audiovideoamount)";
				$website_details = $db_connection->getDbHandler()->prepare($sql_website_insert);
				$website_details->bindParam(':id', $login_id);
				$website_details->bindParam(':slotinterval', $slotinterval);
				$website_details->bindParam(':bookingopenupto', $bookingopenupto);
				$website_details->bindParam(':bookingslotstatus', $bookingslotstatus);
				$website_details->bindParam(':audiovideoamount', $audiovideoamount);
				$website_details->execute();
			}
		}

		echo json_encode(array(
			'status' => $status,
			'msg'=>"",
			'icon'=>'success',
			'title'=> 'Clinic Time Slot Added Successfully'
		));
	}
}
elseif ($action=='custom-timeslot')
{
	// echo '<pre>'; print_r($_POST); exit;

	if( !isset($_POST['weekdays']))
	{
		echo json_encode(array(
			'status' 	=> false,
			'msg'		=> "Unable to Process Check Atleast One Day",
			'icon'		=> 'error',
			'title'		=> 'Validation Error'
		));
		return true;
	}

	$errors['weekdays_error'] = $errors['slot_interval'] = $errors['booking_open_upto'] = $errors['booking_slot_status'] = $errors['amount'] = $errors['start_time'] = $errors['end_time'] = '' ;

	$status    = $dayStatus['slot_start_time']    = $dayStatus['slot_end_time'] = false;

	if(isset($_POST["slot_start_time"]) && isset($_POST["slot_end_time"])) {
		if(!isset($_POST['slot_start_time']) || empty($_POST["slot_end_time"])) {
			$errors['start_time']  = 'This field is required';
		}
		if(!isset($_POST['slot_end_time']) || empty($_POST["slot_end_time"])) {
			$errors['start_time']  = 'This field is required';
		} else {
			if(strtotime($_POST["slot_start_time"]) >= strtotime($_POST["slot_end_time"])) {
				$errors['end_time'] = 'End time should be greater than start time';
			} else {
				if (isset($_POST['day_time_slots']) && count($_POST['day_time_slots']) > 0) {
					$dayStatus['slot_start_time']    = $dayStatus['slot_end_time'] =  true;
				} else {
					$errors['end_time'] = 'Please select atlease one time slot.';
				}
			}
		}
	} else{
		$dayStatus['slot_start_time']    = $dayStatus['slot_end_time'] =  false;
	}

	$dayStatus['slot_interval'] = $dayStatus['booking_open_upto'] = $dayStatus['booking_slot_status'] = $dayStatus['amount'] = true;

	if( !isset($_POST['slot_interval']) && $_POST['slot_interval'] == "") {
		$errors['slot_interval']	= 'This field is required';
		$dayStatus['slot_interval']	= false;
	}
	if( !isset($_POST['booking_open_upto']) && $_POST['booking_open_upto'] == "" || $_POST['booking_open_upto'] == 0) {
		$errors['booking_open_upto'] = 'This field is required';
		if ($_POST['booking_open_upto'] <= 0 ) {
			$errors['booking_open_upto'] = 'Minimum booking slot open upto 1 day';
		}
		$dayStatus['booking_open_upto'] = false;
	}
	if( !isset($_POST['booking_slot_status']) && $_POST['booking_slot_status'] =="") {
		$errors['booking_slot_status'] = 'This field is required';
		$dayStatus['booking_slot_status'] = false;
	}
	if( !isset($_POST['amount']) && $_POST['amount'] =="" || $_POST['amount'] == 0) {
		$errors['amount'] = 'This field is required';
		if ($_POST['amount'] <= 0 ) {
			$errors['amount'] = 'Minimum amount 1rs for Clinic/Video/Audio Amount Per Slot.';
		}
		$dayStatus['amount'] = false;
	}

	if($dayStatus['slot_interval'] == true && $dayStatus['booking_open_upto'] == true && $dayStatus['booking_slot_status'] ==  true && $dayStatus['amount'] == true && $dayStatus['slot_start_time']    == true && $dayStatus['slot_end_time'] == true) {
		$status = true;
	}
	
	if($status == false){
		echo json_encode([
            'status'	=> $status,
            'errors'	=> $errors,
			'msg'		=> "Unable to Process Check missing fields",
			'icon'		=> 'error',
			'title'		=> 'Validation Error'
        ]);
	} else{
		$slotinterval 		= $_POST['slot_interval'] ?? '10 Mmin';
		$bookingopenupto 	= $_POST['booking_open_upto'] ?? 1;
		$bookingslotstatus 	= $_POST['booking_slot_status'] ?? 0;
		$audiovideoamount 	= $_POST['amount'] ?? 1;

		$doctor_time_slot_id	= null;
		
		if($_POST['slot_type'] == 'audio'){
			$type				= 1;
		}
		if($_POST['slot_type'] == 'video'){
			$type				= 2;
		}
		if($_POST['slot_type'] == 'clinic'){
			$type				= 3;
		}

		$list_of_week_days = ['sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'];

		foreach($list_of_week_days as $list_of_week_day) {
			if (in_array($list_of_week_day, $_POST['weekdays'])) {
				//Found
				$isavailable		= 1;
				$start_time			= $_POST['slot_start_time'] ?? null;
				$end_time			= $_POST['slot_end_time'] ?? null;

				$sql_doctor_time_slot		= "SELECT id FROM doctor_time_slots as a WHERE a.doctor_id = ".$login_id . " AND a.day = '$list_of_week_day' AND a.type = '$type'";
				$check_doctor_time_slot		= $db_connection->getDbHandler()->query($sql_doctor_time_slot);
				$existing_doctor_time_slot	= $check_doctor_time_slot->fetch();
				if($existing_doctor_time_slot)
				{
					$doctor_time_slot_id = $existing_doctor_time_slot['id'];
					$sql_update = "UPDATE `doctor_time_slots` set `slot_interval` = :slotinterval, `is_available` = :isavailable, `day` = :slot_day, `start_time` = :start_time, `end_time` = :end_time, `type` = :slot_type where id = :id";
					$video = $db_connection->getDbHandler()->prepare($sql_update);
					$video->bindParam(':id', $doctor_time_slot_id);
					$video->bindParam(':slot_day', $list_of_week_day);
					$video->bindParam(':isavailable', $isavailable);
					$video->bindParam(':start_time', $start_time);
					$video->bindParam(':end_time', $end_time);
					$video->bindParam(':slotinterval', $slotinterval);
					$video->bindParam(':slot_type', $type);
					$video->execute();

					$sql_delete_time_slot	= "DELETE from `doctor_day_time_slots` where doctor_time_slot_id=".$doctor_time_slot_id;
					$delete_stmt			= $db_connection->getDbHandler()->prepare($sql_delete_time_slot);
					$delete_stmt->execute();
					if ($isavailable) {
						if (isset($_POST['day_time_slots'])) {
							foreach($_POST['day_time_slots'] as $day_time_slot) {
								$sql_slots = "INSERT INTO doctor_day_time_slots (`doctor_time_slot_id`, `slot_time`) VALUES( $doctor_time_slot_id, '$day_time_slot')";
								$res_slots = $db_connection->getDbHandler()->query($sql_slots);
							}
						}
					}
				} else {
					$sql_insert = "INSERT INTO `doctor_time_slots` (`doctor_id`, `day`, `is_available`, `start_time`, `end_time`, `slot_interval`, `type`) value (:doctor_id, :slot_day, :isavailable, :start_time, :end_time, :slotinterval, :slot_type)";

					$video = $db_connection->getDbHandler()->prepare($sql_insert);
					$video->bindParam(':doctor_id', $login_id);
					$video->bindParam(':slot_day', $list_of_week_day);
					$video->bindParam(':isavailable', $isavailable);
					$video->bindParam(':start_time', $start_time);
					$video->bindParam(':end_time', $end_time);
					$video->bindParam(':slotinterval', $slotinterval);
					$video->bindParam(':slot_type', $type);
					$video->execute();
					$doctor_time_slot_id = $db_connection->lastInsertId();

					if ($isavailable) {
						if (isset($_POST['day_time_slots'])) {
							foreach($_POST['day_time_slots'] as $day_time_slot) {
								$sql_slots = "INSERT INTO doctor_day_time_slots (`doctor_time_slot_id`, `slot_time`) VALUES( $doctor_time_slot_id, '$day_time_slot')";
								$res_slots = $db_connection->getDbHandler()->query($sql_slots);
							}
						}
					}
				}
			} else {
				//Not Found
				$isavailable	= 0;
				$start_time 	= '';
				$end_time 		= '';

				$sql_time_slot_not_in		= "SELECT id FROM doctor_time_slots as a WHERE a.doctor_id = ".$login_id . " AND a.day = '$list_of_week_day' AND a.type = '$type'";
				$check_time_slot_not_in		= $db_connection->getDbHandler()->query($sql_time_slot_not_in);
				$time_slot_not_in			= $check_time_slot_not_in->fetch();
				if(!$time_slot_not_in){
					$sql_not_in_insert = "INSERT INTO `doctor_time_slots` (`doctor_id`, `day`, `is_available`, `start_time`, `end_time`, `slot_interval`, `type`) value (:doctor_id, :slot_day, :isavailable, :start_time, :end_time, :slotinterval, :slot_type)";

					$not_in = $db_connection->getDbHandler()->prepare($sql_not_in_insert);
					$not_in->bindParam(':doctor_id', $login_id);
					$not_in->bindParam(':slot_day', $list_of_week_day);
					$not_in->bindParam(':isavailable', $isavailable);
					$not_in->bindParam(':start_time', $start_time);
					$not_in->bindParam(':end_time', $end_time);
					$not_in->bindParam(':slotinterval', $slotinterval);
					$not_in->bindParam(':slot_type', $type);
					$not_in->execute();
				}
			}
		}

		$sql_website_detail_insert = "SELECT * FROM website_details WHERE user_id = :id";
		$website = $db_connection->getDbHandler()->prepare($sql_website_detail_insert);
		$website->bindParam(':id', $login_id);
		if($website->execute()){
			$row = $website->fetch(PDO::FETCH_ASSOC);
			if($row !== false){

				if($type == 1){
					$sql_website_update = "UPDATE `website_details` set `audio_slot_interval` = :slotinterval, `audio_booking_open_upto` = :bookingopenupto, `audio_booking_slot_status` = :bookingslotstatus, `audio_amount` = :audiovideoamount where user_id = :id";
				}
				if($type == 2){
					$sql_website_update = "UPDATE `website_details` set `slot_interval` = :slotinterval, `booking_open_upto` = :bookingopenupto, `booking_slot_status` = :bookingslotstatus, `video_amount` = :audiovideoamount where user_id = :id";
				}
				if($type == 3){
					$sql_website_update = "UPDATE `website_details` set `clinic_slot_interval` = :slotinterval, `clinic_booking_open_upto` = :bookingopenupto, `clinic_booking_slot_status` = :bookingslotstatus, `clinic_amount` = :audiovideoamount where user_id = :id";
				}

				$website_details = $db_connection->getDbHandler()->prepare($sql_website_update);
				$website_details->bindParam(':id', $login_id);
				$website_details->bindParam(':slotinterval', $slotinterval);
				$website_details->bindParam(':bookingopenupto', $bookingopenupto);
				$website_details->bindParam(':bookingslotstatus', $bookingslotstatus);
				$website_details->bindParam(':audiovideoamount', $audiovideoamount);
				$website_details->execute();
			}
			else{
				if($type == 1){
					$sql_website_insert = "INSERT INTO `website_details` (`audio_slot_interval`,`user_id`,`audio_booking_open_upto`,`audio_booking_slot_status`,`audio_amount`) value (:slotinterval,:id,:bookingopenupto,:bookingslotstatus,:audiovideoamount)";
				}
				if($type == 2){
					$sql_website_insert = "INSERT INTO `website_details` (`slot_interval`,`user_id`,`booking_open_upto`,`booking_slot_status`,`video_amount`) value (:slotinterval,:id,:bookingopenupto,:bookingslotstatus,:audiovideoamount)";
				}
				if($type == 3){
					$sql_website_insert = "INSERT INTO `website_details` (`clinic_slot_interval`,`user_id`,`clinic_booking_open_upto`,`clinic_booking_slot_status`,`clinic_amount`) value (:slotinterval,:id,:bookingopenupto,:bookingslotstatus,:audiovideoamount)";
				}
				$website_details = $db_connection->getDbHandler()->prepare($sql_website_insert);
				$website_details->bindParam(':id', $login_id);
				$website_details->bindParam(':slotinterval', $slotinterval);
				$website_details->bindParam(':bookingopenupto', $bookingopenupto);
				$website_details->bindParam(':bookingslotstatus', $bookingslotstatus);
				$website_details->bindParam(':audiovideoamount', $audiovideoamount);
				$website_details->execute();
			}
		}

		echo json_encode(array(
			'status' => $status,
			'msg'=>"",
			'icon'=>'success',
			'title'=> 'Time Slot Added Successfully'
		));
	}
}

else if ($action=='getCustomTimeSlotList') {

	$existing_time_slot 	= "SELECT doctor_day_time_slots.slot_time FROM doctor_time_slots LEFT JOIN doctor_day_time_slots ON doctor_time_slots.id = doctor_day_time_slots.doctor_time_slot_id WHERE doctor_time_slots.doctor_id = ".$login_id . "";
    $con_details			= $db_connection->getDbHandler()->query($existing_time_slot);
	$res_existing_time_slot	= $con_details->fetchAll();

	$duration 	= $_POST['time_slot_interval'] ?? '';
	$start_time	= strtotime($_POST['booking_start_time']);
	$end_time	= strtotime($_POST['booking_end_time']);
	$i = 0;
	
	$time_slot_html = '<div class="row time-slot-box">
		<ul class="ul-pl0">';
		
	while ($start_time < $end_time) {
		$is_checked  ="";
		if ($i == 0) {
			
			$time_slot_html .= '<li class="times">
				<div id="ck-button">
					<label>
						<input type="checkbox" id="day_time_slots"  name="day_time_slots[]" value="'.ucwords($_POST['booking_start_time']).'"><span>'.ucwords($_POST['booking_start_time']).'</span> </label>
				</div>
			</li>';
		} else {
			$start_time = strtotime('+'.$duration, $start_time);

			if ($start_time <= $end_time) {
				$time_slot_html .= '<li class="times">
					<div id="ck-button">
						<label>
							<input type="checkbox" id="day_time_slots"  name="day_time_slots[]" value="'.date('h:i A', $start_time).'"><span>'.date('h:i A', $start_time).'</span> </label>
					</div>
				</li>';
			}
		}
		$i++;
	}
	$time_slot_html .= '</ul>
	</div>';

	echo $time_slot_html;
}
else if ($action=='getClinicTimeSlotList') {
	$index 					= $_POST['index'] ?? '';
	$is_available 			= 0;
	
	$existing_time_slot 	= "SELECT doctor_day_time_slots.slot_time FROM doctor_time_slots LEFT JOIN doctor_day_time_slots ON doctor_time_slots.id = doctor_day_time_slots.doctor_time_slot_id WHERE doctor_time_slots.doctor_id = ".$login_id . " AND doctor_time_slots.day = '$index' AND doctor_time_slots.type = 3";
    $con_details			= $db_connection->getDbHandler()->query($existing_time_slot);
	$res_existing_time_slot	= $con_details->fetchAll();

	$selected_time_slots = array_map(function ($value) { return $value['slot_time']; }, $res_existing_time_slot);

	$duration 	= $_POST['time_slot_interval'] ?? '';
	$start_time	= strtotime($_POST['booking_start_time']);
	$end_time	= strtotime($_POST['booking_end_time']);
	$i = 0;
	
	$time_slot_html = '<div class="row time-slot-box">
		<ul class="ul-pl0">';
		
	while ($start_time < $end_time) {
		$is_checked  ="";
		if ($i == 0) {
			$begining_time = $_POST['booking_start_time'];
			if (in_array($begining_time, $selected_time_slots)) {
				$is_checked  ="checked";
			}

			$time_slot_html .= '<li class="times">
				<div id="ck-button">
					<label>
						<input type="checkbox" id="day_time_slots" '.$is_checked.' name="day_time_slots['.$index.'][]" value="'.ucwords($_POST['booking_start_time']).'"><span>'.ucwords($_POST['booking_start_time']).'</span> </label>
				</div>
			</li>';
		} else {
			$start_time = strtotime('+'.$duration, $start_time);

			$begining_time = date('h:i A', $start_time);
			if (in_array($begining_time, $selected_time_slots)) {
				$is_checked  ="checked";
			}
			if ($start_time <= $end_time) {
				$time_slot_html .= '<li class="times">
					<div id="ck-button">
						<label>
							<input type="checkbox" id="day_time_slots" '.$is_checked.' name="day_time_slots['.$index.'][]" value="'.date('h:i A', $start_time).'"><span>'.date('h:i A', $start_time).'</span> </label>
					</div>
				</li>';
			}
		}
		$i++;
	}
	$time_slot_html .= '</ul>
	</div>';

	echo $time_slot_html;
}
elseif ($action=='timeslot-audio')
{
	// echo'<pre>';print_r($_POST);die;
	if( !isset($_POST['day']))
	{
		echo json_encode(array(
			'status' 	=> false,
			'msg'		=> "Unable to Process Check missing fields",
			'icon'		=> 'error',
			'title'		=> 'Validation Error'
		));
		return true;
	}
	
	$errors['audio_slot_interval'] = $errors['audio_booking_open_upto'] = $errors['audio_booking_slot_status'] = $errors['audio_amount'] = $errors['monday_audio_start_time'] = $errors['tuesday_audio_start_time'] = $errors['wednesday_audio_start_time'] = $errors['thursday_audio_start_time'] = $errors['friday_audio_start_time'] = $errors['saturday_audio_start_time'] = $errors['sunday_audio_start_time'] = $errors['monday_audio_end_time'] = $errors['tuesday_audio_end_time'] = $errors['wednesday_audio_end_time'] = $errors['thursday_audio_end_time'] = $errors['friday_audio_end_time'] = $errors['saturday_audio_end_time'] = $errors['sunday_audio_end_time'] = '';

	$status    = $dayStatus['sunday']    = $dayStatus['monday'] = $dayStatus['tuesday'] = $dayStatus['wednesday'] = $dayStatus['thursday'] = $dayStatus['friday'] = $dayStatus['saturday']    = false;
	
	foreach ($_POST['day'] as $value) {
		if(isset($_POST["audio_is_available"][$value]) && $_POST["audio_is_available"][$value] == 1) {
			if(!isset($_POST['audio_start_time']) || empty($_POST["audio_start_time"][$value])) {
				$errors[$value.'_audio_start_time']  = 'This field is required';
			}
			if(!isset($_POST['audio_end_time']) || empty($_POST["audio_end_time"][$value])) {
				$errors[$value.'_audio_end_time']  = 'This field is required';
			} else {
				if(strtotime($_POST["audio_start_time"][$value]) >= strtotime($_POST["audio_end_time"][$value])) {
					$errors[$value.'_audio_end_time'] = 'End time should be greater than start time';
				} else {
					if (isset($_POST['day_time_slots'][$value]) && count($_POST['day_time_slots'][$value]) > 0) {
						$dayStatus[$value]    = true;
					} else {
						$errors[$value.'_audio_end_time'] = 'Please select atlease one time slot.';
					}
				}
			}
		} else {
			$dayStatus[$value]    = true;
		}
	}
	
	$dayStatus['audio_slot_interval']    = $dayStatus['audio_booking_open_upto']    = $dayStatus['audio_booking_slot_status']    = $dayStatus['audio_amount'] = true;

	if( !isset($_POST['audio_slot_interval']) && $_POST['audio_slot_interval'] == "") {
		$errors['audio_slot_interval']	= 'This field is required';
		$dayStatus['audio_slot_interval']	= false;
	}
	if( !isset($_POST['audio_booking_open_upto']) && $_POST['audio_booking_open_upto'] == "" || $_POST['audio_booking_open_upto'] == 0) {
		$errors['audio_booking_open_upto'] = 'This field is required';
		if ($_POST['audio_booking_open_upto'] <= 0 ) {
			$errors['audio_booking_open_upto'] = 'Minimum booking slot open upto 1 day';
		}
		$dayStatus['audio_booking_open_upto'] = false;
	}
	if( !isset($_POST['audio_booking_slot_status']) && $_POST['audio_booking_slot_status'] =="") {
		$errors['audio_booking_slot_status'] = 'This field is required';
		$dayStatus['audio_booking_slot_status'] = false;
	}
	if( !isset($_POST['audio_amount']) && $_POST['audio_amount'] =="" || $_POST['audio_amount'] == 0) {
		$errors['audio_amount'] = 'This field is required';
		if ($_POST['audio_amount'] <= 0 ) {
			$errors['audio_amount'] = 'Minimum amount 1rs for Audio/Video Amount Per Slot.';
		}
		$dayStatus['audio_amount'] = false;
	}

	if($dayStatus['sunday'] == true && $dayStatus['monday'] == true && $dayStatus['tuesday'] == true && $dayStatus['wednesday'] == true && $dayStatus['thursday'] == true && $dayStatus['friday'] == true && $dayStatus['saturday'] == true && $dayStatus['audio_slot_interval'] == true && $dayStatus['audio_booking_open_upto'] == true && $dayStatus['audio_booking_slot_status'] == true && $dayStatus['audio_amount'] == true ) {
		$status = true;
	}
	
	if($status == false){
		echo json_encode([
            'status'	=> $status,
            'errors'	=> $errors,
			'msg'		=> "Unable to Process Check missing fields",
			'icon'		=> 'error',
			'title'		=> 'Validation Error'
        ]);
	} else {
		$slotinterval 		= $_POST['audio_slot_interval'] ?? '10 Mmin';
		$bookingopenupto 	= $_POST['audio_booking_open_upto'] ?? 1;
		$bookingslotstatus 	= $_POST['audio_booking_slot_status'] ?? 0;
		$audiovideoamount 	= $_POST['audio_amount'] ?? 1;

		foreach($_POST['day'] as $result_day)
		{
			$doctor_time_slot_id= null;
			$isavailable		= $_POST['audio_is_available'][$result_day] ?? 0;
			$audio_start_time	= $_POST['audio_start_time'][$result_day] ?? null;
			$audio_end_time		= $_POST['audio_end_time'][$result_day] ?? null;
			$type				= 1;

			$sql_doctor_time_slot		= "SELECT id FROM doctor_time_slots as a WHERE a.doctor_id = ".$login_id . " AND a.day = '$result_day' AND a.type = 1";
			$check_doctor_time_slot		= $db_connection->getDbHandler()->query($sql_doctor_time_slot);
			$existing_doctor_time_slot	= $check_doctor_time_slot->fetch();
			if($existing_doctor_time_slot)
			{
				$doctor_time_slot_id = $existing_doctor_time_slot['id'];
				$sql_update = "UPDATE `doctor_time_slots` set `slot_interval` = :slotinterval, `is_available` = :isavailable, `day` = :slot_day, `start_time` = :start_time, `end_time` = :end_time, `type` = :slot_type where id = :id";
				$video = $db_connection->getDbHandler()->prepare($sql_update);
				$video->bindParam(':id', $doctor_time_slot_id);
				$video->bindParam(':slot_day', $result_day);
				$video->bindParam(':isavailable', $isavailable);
				$video->bindParam(':start_time', $audio_start_time);
				$video->bindParam(':end_time', $audio_end_time);
				$video->bindParam(':slotinterval', $slotinterval);
				$video->bindParam(':slot_type', $type);
				$video->execute();

				$sql_delete_time_slot	= "DELETE from `doctor_day_time_slots` where doctor_time_slot_id=".$doctor_time_slot_id;
				$delete_stmt			= $db_connection->getDbHandler()->prepare($sql_delete_time_slot);
				$delete_stmt->execute();
				if ($isavailable) {
					if (isset($_POST['day_time_slots'][$result_day])) {
						foreach($_POST['day_time_slots'][$result_day] as $day_time_slot) {
							$sql_slots = "INSERT INTO doctor_day_time_slots (`doctor_time_slot_id`, `slot_time`) VALUES( $doctor_time_slot_id, '$day_time_slot')";
							$res_slots = $db_connection->getDbHandler()->query($sql_slots);
						}
					}
				}
			} else {
				$sql_insert = "INSERT INTO `doctor_time_slots` (`doctor_id`, `day`, `is_available`, `start_time`, `end_time`, `slot_interval`, `type`) value (:doctor_id, :slot_day, :isavailable, :start_time, :end_time, :slotinterval, :slot_type)";

				$video = $db_connection->getDbHandler()->prepare($sql_insert);
				$video->bindParam(':doctor_id', $login_id);
				$video->bindParam(':slot_day', $result_day);
				$video->bindParam(':isavailable', $isavailable);
				$video->bindParam(':start_time', $audio_start_time);
				$video->bindParam(':end_time', $audio_end_time);
				$video->bindParam(':slotinterval', $slotinterval);
				$video->bindParam(':slot_type', $type);
				$video->execute();
				$doctor_time_slot_id = $db_connection->lastInsertId();

				if ($isavailable) {
					if (isset($_POST['day_time_slots'][$result_day])) {
						foreach($_POST['day_time_slots'][$result_day] as $day_time_slot) {
							$sql_slots = "INSERT INTO doctor_day_time_slots (`doctor_time_slot_id`, `slot_time`) VALUES( $doctor_time_slot_id, '$day_time_slot')";
							$res_slots = $db_connection->getDbHandler()->query($sql_slots);
						}
					}
				}
			}
		}

		$sql_website_detail_insert = "SELECT * FROM website_details WHERE user_id = :id";
		$website = $db_connection->getDbHandler()->prepare($sql_website_detail_insert);
		$website->bindParam(':id', $login_id);
		if($website->execute()){
			$row = $website->fetch(PDO::FETCH_ASSOC);
			if($row !== false){
				$sql_website_update = "UPDATE `website_details` set `audio_slot_interval` = :slotinterval, `audio_booking_open_upto` = :bookingopenupto, `audio_booking_slot_status` = :bookingslotstatus, `audio_amount` = :audiovideoamount where user_id = :id";
				$website_details = $db_connection->getDbHandler()->prepare($sql_website_update);
				$website_details->bindParam(':id', $login_id);
				$website_details->bindParam(':slotinterval', $slotinterval);
				$website_details->bindParam(':bookingopenupto', $bookingopenupto);
				$website_details->bindParam(':bookingslotstatus', $bookingslotstatus);
				$website_details->bindParam(':audiovideoamount', $audiovideoamount);
				$website_details->execute();
			}
			else{
				$sql_website_insert = "INSERT INTO `website_details` (`audio_slot_interval`,`user_id`,`audio_booking_open_upto`,`audio_booking_slot_status`,`audio_amount`) value (:slotinterval,:id,:bookingopenupto,:bookingslotstatus,:audiovideoamount)";
				$website_details = $db_connection->getDbHandler()->prepare($sql_website_insert);
				$website_details->bindParam(':id', $login_id);
				$website_details->bindParam(':slotinterval', $slotinterval);
				$website_details->bindParam(':bookingopenupto', $bookingopenupto);
				$website_details->bindParam(':bookingslotstatus', $bookingslotstatus);
				$website_details->bindParam(':audiovideoamount', $audiovideoamount);
				$website_details->execute();
			}
		}

		echo json_encode(array(
			'status' => $status,
			'msg'=>"",
			'icon'=>'success',
			'title'=> 'Audio Time Slot Added Successfully'
		));
	}
}
else if ($action=='getAudioTimeSlotList') {
	$index 					= $_POST['index'] ?? '';
	$is_available 			= 0;
	
	$existing_time_slot 	= "SELECT doctor_day_time_slots.slot_time FROM doctor_time_slots LEFT JOIN doctor_day_time_slots ON doctor_time_slots.id = doctor_day_time_slots.doctor_time_slot_id WHERE doctor_time_slots.doctor_id = ".$login_id . " AND doctor_time_slots.day = '$index' AND doctor_time_slots.type = 1";
    $con_details			= $db_connection->getDbHandler()->query($existing_time_slot);
	$res_existing_time_slot	= $con_details->fetchAll();

	$selected_time_slots = array_map(function ($value) { return $value['slot_time']; }, $res_existing_time_slot);

	$duration 	= $_POST['time_slot_interval'] ?? '';
	$start_time	= strtotime($_POST['booking_start_time']);
	$end_time	= strtotime($_POST['booking_end_time']);
	$i = 0;
	
	$time_slot_html = '<div class="row time-slot-box">
		<ul class="ul-pl0">';
		
	while ($start_time < $end_time) {
		$is_checked  ="";
		if ($i == 0) {
			$begining_time = $_POST['booking_start_time'];
			if (in_array($begining_time, $selected_time_slots)) {
				$is_checked  ="checked";
			}

			$time_slot_html .= '<li class="times">
				<div id="ck-button">
					<label>
						<input type="checkbox" id="day_time_slots" '.$is_checked.' name="day_time_slots['.$index.'][]" value="'.ucwords($_POST['booking_start_time']).'"><span>'.ucwords($_POST['booking_start_time']).'</span> </label>
				</div>
			</li>';
		} else {
			$start_time = strtotime('+'.$duration, $start_time);

			$begining_time = date('h:i A', $start_time);
			if (in_array($begining_time, $selected_time_slots)) {
				$is_checked  ="checked";
			}
			if ($start_time <= $end_time) {
				$time_slot_html .= '<li class="times">
					<div id="ck-button">
						<label>
							<input type="checkbox" id="day_time_slots" '.$is_checked.' name="day_time_slots['.$index.'][]" value="'.date('h:i A', $start_time).'"><span>'.date('h:i A', $start_time).'</span> </label>
					</div>
				</li>';
			}
		}
		$i++;
	}
	$time_slot_html .= '</ul>
	</div>';

	echo $time_slot_html;
}
elseif ($action=='timeSlot')
{
	// echo'<pre>';print_r($_POST);die;
	if( !isset($_POST['day'])) 
	{
		echo json_encode(array(
			'status' 	=> false,
			'msg'		=> "Unable to Process Check missing fields",
			'icon'		=> 'error',
			'title'		=> 'Validation Error'
		));
		return true;
	}
	
	$errors['slot_interval'] = $errors['booking_open_upto'] = $errors['booking_slot_status'] = $errors['video_amount'] = $errors['monday_video_start_time'] = $errors['tuesday_video_start_time'] = $errors['wednesday_video_start_time'] = $errors['thursday_video_start_time'] = $errors['friday_video_start_time'] = $errors['saturday_video_start_time'] = $errors['sunday_video_start_time'] = $errors['monday_video_end_time'] = $errors['tuesday_video_end_time'] = $errors['wednesday_video_end_time'] = $errors['thursday_video_end_time'] = $errors['friday_video_end_time'] = $errors['saturday_video_end_time'] = $errors['sunday_video_end_time'] = '';

	$status    = $dayStatus['sunday']    = $dayStatus['monday'] = $dayStatus['tuesday'] = $dayStatus['wednesday'] = $dayStatus['thursday'] = $dayStatus['friday'] = $dayStatus['saturday']    = false;
	
	foreach ($_POST['day'] as $value) {
		if(isset($_POST["video_is_available"][$value]) && $_POST["video_is_available"][$value] == 1) {
			if(!isset($_POST['video_start_time']) || empty($_POST["video_start_time"][$value])) {
				$errors[$value.'_video_start_time']  = 'This field is required';
			}
			if(!isset($_POST['video_end_time']) || empty($_POST["video_end_time"][$value])) {
				$errors[$value.'_video_end_time']  = 'This field is required';
			} else {
				if(strtotime($_POST["video_start_time"][$value]) >= strtotime($_POST["video_end_time"][$value])) {
					$errors[$value.'_video_end_time'] = 'End time should be greater than start time';
				} else {
					if (isset($_POST['day_time_slots'][$value]) && count($_POST['day_time_slots'][$value]) > 0) {
						$dayStatus[$value]    = true;
					} else {
						$errors[$value.'_video_end_time'] = 'Please select atlease one time slot.';
					}
				}
			}
		} else {
			$dayStatus[$value]    = true;
		}
	}
	
	$dayStatus['slot_interval']    = $dayStatus['booking_open_upto']    = $dayStatus['booking_slot_status']    = $dayStatus['video_amount'] = true;

	if( !isset($_POST['slot_interval']) && $_POST['slot_interval'] == "") {
		$errors['slot_interval']	= 'This field is required';
		$dayStatus['slot_interval']	= false;
	}
	if( !isset($_POST['booking_open_upto']) && $_POST['booking_open_upto'] == "" || $_POST['booking_open_upto'] == 0) {
		$errors['booking_open_upto'] = 'This field is required';
		if ($_POST['booking_open_upto'] <= 0 ) {
			$errors['booking_open_upto'] = 'Minimum booking slot open upto 1 day';
		}
		$dayStatus['booking_open_upto'] = false;
	}
	if( !isset($_POST['booking_slot_status']) && $_POST['booking_slot_status'] =="") {
		$errors['booking_slot_status'] = 'This field is required';
		$dayStatus['booking_slot_status'] = false;
	}
	if( !isset($_POST['video_amount']) && $_POST['video_amount'] =="" || $_POST['video_amount'] == 0) {
		$errors['video_amount'] = 'This field is required';
		if ($_POST['video_amount'] <= 0 ) {
			$errors['video_amount'] = 'Minimum amount 1rs for Audio/Video Amount Per Slot.';
		}
		$dayStatus['video_amount'] = false;
	}

	if($dayStatus['sunday'] == true && $dayStatus['monday'] == true && $dayStatus['tuesday'] == true && $dayStatus['wednesday'] == true && $dayStatus['thursday'] == true && $dayStatus['friday'] == true && $dayStatus['saturday'] == true && $dayStatus['slot_interval'] == true && $dayStatus['booking_open_upto'] == true && $dayStatus['booking_slot_status'] == true && $dayStatus['video_amount'] == true ) {
		$status = true;
	}
	
	if($status == false){
		echo json_encode([
            'status'	=> $status,
            'errors'	=> $errors,
			'msg'		=> "Unable to Process Check missing fields",
			'icon'		=> 'error',
			'title'		=> 'Validation Error'
        ]);
	} else {
		$slotinterval 		= $_POST['slot_interval'] ?? '10 Mmin';
		$bookingopenupto 	= $_POST['booking_open_upto'] ?? 1;
		$bookingslotstatus 	= $_POST['booking_slot_status'] ?? 0;
		$audiovideoamount 	= $_POST['video_amount'] ?? 1;

		foreach($_POST['day'] as $result_day)
		{
			$doctor_time_slot_id= null;
			$isavailable		= $_POST['video_is_available'][$result_day] ?? 0;
			$video_start_time	= $_POST['video_start_time'][$result_day] ?? null;
			$video_end_time		= $_POST['video_end_time'][$result_day] ?? null;
			$type				= 2;

			$sql_doctor_time_slot		= "SELECT id FROM doctor_time_slots as a WHERE a.doctor_id = ".$login_id . " AND a.day = '$result_day' AND a.type = 2";
			$check_doctor_time_slot		= $db_connection->getDbHandler()->query($sql_doctor_time_slot);
			$existing_doctor_time_slot	= $check_doctor_time_slot->fetch();
			if($existing_doctor_time_slot)
			{
				$doctor_time_slot_id = $existing_doctor_time_slot['id'];
				$sql_update = "UPDATE `doctor_time_slots` set `slot_interval` = :slotinterval, `is_available` = :isavailable, `day` = :slot_day, `start_time` = :start_time, `end_time` = :end_time, `type` = :slot_type where id = :id";
				$video = $db_connection->getDbHandler()->prepare($sql_update);
				$video->bindParam(':id', $doctor_time_slot_id);
				$video->bindParam(':slot_day', $result_day);
				$video->bindParam(':isavailable', $isavailable);
				$video->bindParam(':start_time', $video_start_time);
				$video->bindParam(':end_time', $video_end_time);
				$video->bindParam(':slotinterval', $slotinterval);
				$video->bindParam(':slot_type', $type);
				$video->execute();

				$sql_delete_time_slot	= "DELETE from `doctor_day_time_slots` where doctor_time_slot_id=".$doctor_time_slot_id;
				$delete_stmt			= $db_connection->getDbHandler()->prepare($sql_delete_time_slot);
				$delete_stmt->execute();
				if ($isavailable) {
					if (isset($_POST['day_time_slots'][$result_day])) {
						foreach($_POST['day_time_slots'][$result_day] as $day_time_slot) {
							$sql_slots = "INSERT INTO doctor_day_time_slots (`doctor_time_slot_id`, `slot_time`) VALUES( $doctor_time_slot_id, '$day_time_slot')";
							$res_slots = $db_connection->getDbHandler()->query($sql_slots);
						}
					}
				}
			} else {
				$sql_insert = "INSERT INTO `doctor_time_slots` (`doctor_id`, `day`, `is_available`, `start_time`, `end_time`, `slot_interval`, `type`) value (:doctor_id, :slot_day, :isavailable, :start_time, :end_time, :slotinterval, :slot_type)";

				$video = $db_connection->getDbHandler()->prepare($sql_insert);
				$video->bindParam(':doctor_id', $login_id);
				$video->bindParam(':slot_day', $result_day);
				$video->bindParam(':isavailable', $isavailable);
				$video->bindParam(':start_time', $video_start_time);
				$video->bindParam(':end_time', $video_end_time);
				$video->bindParam(':slotinterval', $slotinterval);
				$video->bindParam(':slot_type', $type);
				$video->execute();
				$doctor_time_slot_id = $db_connection->lastInsertId();

				if ($isavailable) {
					if (isset($_POST['day_time_slots'][$result_day])) {
						foreach($_POST['day_time_slots'][$result_day] as $day_time_slot) {
							$sql_slots = "INSERT INTO doctor_day_time_slots (`doctor_time_slot_id`, `slot_time`) VALUES( $doctor_time_slot_id, '$day_time_slot')";
							$res_slots = $db_connection->getDbHandler()->query($sql_slots);
						}
					}
				}
			}
		}

		$sql_website_detail_insert = "SELECT * FROM website_details WHERE user_id = :id";
		$website = $db_connection->getDbHandler()->prepare($sql_website_detail_insert);
		$website->bindParam(':id', $login_id);
		if($website->execute()){
			$row = $website->fetch(PDO::FETCH_ASSOC);
			if($row !== false){
				$sql_website_update = "UPDATE `website_details` set `slot_interval` = :slotinterval, `booking_open_upto` = :bookingopenupto, `booking_slot_status` = :bookingslotstatus, `video_amount` = :audiovideoamount where user_id = :id";
				$website_details = $db_connection->getDbHandler()->prepare($sql_website_update);
				$website_details->bindParam(':id', $login_id);
				$website_details->bindParam(':slotinterval', $slotinterval);
				$website_details->bindParam(':bookingopenupto', $bookingopenupto);
				$website_details->bindParam(':bookingslotstatus', $bookingslotstatus);
				$website_details->bindParam(':audiovideoamount', $audiovideoamount);
				$website_details->execute();
			}
			else{
				$sql_website_insert = "INSERT INTO `website_details` (`slot_interval`,`user_id`,`booking_open_upto`,`booking_slot_status`,`video_amount`) value (:slotinterval,:id,:bookingopenupto,:bookingslotstatus,:audiovideoamount)";
				$website_details = $db_connection->getDbHandler()->prepare($sql_website_insert);
				$website_details->bindParam(':id', $login_id);
				$website_details->bindParam(':slotinterval', $slotinterval);
				$website_details->bindParam(':bookingopenupto', $bookingopenupto);
				$website_details->bindParam(':bookingslotstatus', $bookingslotstatus);
				$website_details->bindParam(':audiovideoamount', $audiovideoamount);
				$website_details->execute();
			}
		}

		echo json_encode(array(
			'status' => $status,
			'msg'=>"",
			'icon'=>'success',
			'title'=> 'Video Time Slot Added Successfully'
		));
	}
}

else if ($action=='getVideoTimeSlotList') {
	$index 					= $_POST['index'] ?? '';
	$is_available 			= 0;
	
	$existing_time_slot 	= "SELECT doctor_day_time_slots.slot_time FROM doctor_time_slots LEFT JOIN doctor_day_time_slots ON doctor_time_slots.id = doctor_day_time_slots.doctor_time_slot_id WHERE doctor_time_slots.doctor_id = ".$login_id . " AND doctor_time_slots.day = '$index' AND doctor_time_slots.type = 2";
    $con_details			= $db_connection->getDbHandler()->query($existing_time_slot);
	$res_existing_time_slot	= $con_details->fetchAll();

	$selected_time_slots = array_map(function ($value) { return $value['slot_time']; }, $res_existing_time_slot);

	$duration 	= $_POST['time_slot_interval'] ?? '';
	$start_time	= strtotime($_POST['booking_start_time']);
	$end_time	= strtotime($_POST['booking_end_time']);
	$i = 0;
	
	$time_slot_html = '<div class="row time-slot-box">
		<ul class="ul-pl0">';
		
	while ($start_time < $end_time) {
		$is_checked  ="";
		if ($i == 0) {
			$begining_time = $_POST['booking_start_time'];
			if (in_array($begining_time, $selected_time_slots)) {
				$is_checked  ="checked";
			}

			$time_slot_html .= '<li class="times">
				<div id="ck-button">
					<label>
						<input type="checkbox" id="day_time_slots" '.$is_checked.' name="day_time_slots['.$index.'][]" value="'.ucwords($_POST['booking_start_time']).'"><span>'.ucwords($_POST['booking_start_time']).'</span> </label>
				</div>
			</li>';
		} else {
			$start_time = strtotime('+'.$duration, $start_time);

			$begining_time = date('h:i A', $start_time);
			if (in_array($begining_time, $selected_time_slots)) {
				$is_checked  ="checked";
			}
			if ($start_time <= $end_time) {
				$time_slot_html .= '<li class="times">
					<div id="ck-button">
						<label>
							<input type="checkbox" id="day_time_slots" '.$is_checked.' name="day_time_slots['.$index.'][]" value="'.date('h:i A', $start_time).'"><span>'.date('h:i A', $start_time).'</span> </label>
					</div>
				</li>';
			}
		}
		$i++;
	}
	$time_slot_html .= '</ul>
	</div>';

	echo $time_slot_html;
}


elseif($action == "booking-postpone") {

	if( !isset($_POST['datepick'])
	|| !isset($_POST['booking_type'])
	|| !isset($_POST['booking_page'])
	|| !isset($_POST['booking_no'])
	|| !isset($_POST['time_duration']) 
	|| !isset($_POST['chosen_slot_time']) ) {
		die(json_encode(
			array(
				'msg'=>"We are sorry, but there appears to be a problem with the form you submitted.",
				'icon'=>'error',
				'title' => 'PostPone Update'
		)));
	}
	$booking_no 			= trim($_POST['booking_no']);
	$booking_date			= trim(date('Y-m-d', strtotime($_POST['datepick'])));
	$booking_type 			= trim($_POST['booking_type']);
	$doctor_id 				= trim($_POST['booking_page']);
	$user_id 				= trim($_POST['user_id']);
	$payment_id				= trim($_POST['payment_id']);
	$booking_time			= trim($_POST['chosen_slot_time']);
	$time_duration			= trim($_POST['time_duration']);

	$sql_postpone = "UPDATE `booking_details` set `booking_date`=:booking_date,`booking_time`=:booking_time,`time_duration`=:time_duration WHERE booking_no=:booking_no";
	$udstmt = $db_connection->getDbHandler()->prepare($sql_postpone);

	$udstmt->bindParam(':booking_date', $booking_date);
	$udstmt->bindParam(':booking_time', $booking_time);
	$udstmt->bindParam(':time_duration', $time_duration);
	$udstmt->bindParam(':booking_no', $booking_no);

	if($udstmt->execute()){
		// $booking_date_time = $booking_date.$booking_time;
	
		// $query_user = "SELECT id,name,email,mobileNo FROM users WHERE id='$user_id'";
		// $res_users = $db_connection->getDbHandler()->query($query_user);
		// $row_users = $res_users->fetch();

		// $query_doctor = "SELECT id,name,email,mobileNo FROM users WHERE id='$doctor_id'";
		// $res_doctor = $db_connection->getDbHandler()->query($query_doctor);
		// $row_doctor = $res_doctor->fetch();
		
		// try {
		// 	if($row_users['email']){
		// 		$email_subject = "Postponed of Booking From Profrea!!!";
						
		// 		$user_email = file_get_contents("../template/slot-appointment-postpone-user.html");
		// 		$user_email = str_replace("@@name@@",$row_users['name'],$user_email);
		// 		$user_email = str_replace("@@razorpay_payment_id@@",$payment_id,$user_email);
		// 		$user_email = str_replace("@@date_time@@",date('d-M-y, g:i A', strtotime($booking_date_time)),$user_email);
		// 		$user_email = str_replace("@@doctor_name@@",$row_doctor['name'],$user_email);
				
		
		// 		$result = sendMail( $email_subject,$user_email, $row_users['email']);
		// 	}

		// 	if($row_doctor['email']){
		// 		$email_subject = "Postponed of Booking From Profrea!!!";
						
		// 		$doctor_email = file_get_contents("../template/slot-appointment-postpone-doctor.html");
		// 		$doctor_email = str_replace("@@doctor_name@@",$row_doctor['name'],$doctor_email);
		// 		$doctor_email = str_replace("@@razorpay_payment_id@@",$payment_id,$doctor_email);
		// 		$doctor_email = str_replace("@@date_time@@",date('d-M-y, g:i A', strtotime($booking_date_time)),$doctor_email);
		// 		$doctor_email = str_replace("@@user_name@@",$row_users['name'],$doctor_email);
				
		// 		$result = sendMail( $email_subject,$doctor_email, $row_doctor['email']);
		// 	}
			// if($row_users['mobileNo']){
			// 	$message    = "";
			// 	$mobileUser  = $row_users["mobileNo"];
				
			// 	$url = "https://sms.nettyfish.com/api/v2/SendSMS?SenderId=PRFREA&Message=".urlencode($message)."&MobileNumbers=".$mobileUser."&ApiKey=pNIg7phvNboA+wW5Q4gDgYTOYOK3q4/gRTSud7uoGTI=&ClientId=bea0553d-0c7f-481f-a8af-f65db8a5b395";

			// 	$ch = curl_init();
			// 	curl_setopt($ch, CURLOPT_URL,$url);
			// 	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			// 	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
				
			// 	$output = curl_exec($ch);
			// 	curl_close($ch);
			// }

			// if($row_doctor['mobileNo']){

			// 	$message    = "";
			// 	$mobileDoc  = $row_doctor["mobileNo"];
				
			// 	$url = "https://sms.nettyfish.com/api/v2/SendSMS?SenderId=PRFREA&Message=".urlencode($message)."&MobileNumbers=".$mobileDoc."&ApiKey=pNIg7phvNboA+wW5Q4gDgYTOYOK3q4/gRTSud7uoGTI=&ClientId=bea0553d-0c7f-481f-a8af-f65db8a5b395";

			// 	$ch = curl_init();
			// 	curl_setopt($ch, CURLOPT_URL,$url);
			// 	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			// 	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
				
			// 	$output = curl_exec($ch);
			// 	curl_close($ch);
			// }

		// } catch(Exception $e){
			
		// }

		echo json_encode(array(
			'msg'=>"",
			'icon'=>'success',
			'title'=> 'PostPone Details Updated'
		));
	}
	else{
		die(json_encode(
			array(
				'msg'=>"We are sorry, but there appears to be a problem with the form you submitted.",
				'icon'=>'error',
				'title' => 'PostPone Failed'
		)));
	}
}
elseif($action == "get_booking_slots") {
	// print_r($_POST);die;
	$doctor_id		= $_POST['bookingpage'] ?? '';
	$booking_type	= $_POST['type'] ?? '';
	$booking_date	= $_POST['booking_date'] ?? '';
	$booking_day	= $_POST['booking_day'] ?? '';
	$chosendate		= $_POST['chosendate'] ?? '';

	if ($booking_type == 1) { $class_type ="_audio"; } elseif($booking_type == 2){ $class_type ="_video"; } else { $class_type ="_clinic"; }
	
	$sql_holiday       = "SELECT * FROM holidays as h WHERE h.from_date >= '".date('Y-m-d', strtotime($booking_date))."' AND h.to_date <= '".date('Y-m-d', strtotime($booking_date))."' AND h.doctor_id = ".$doctor_id ." ";
	$check_holiday     = $db_connection->getDbHandler()->query($sql_holiday);
	$row_holiday  	   = $check_holiday->fetchAll();
	
	if(count($row_holiday) > 0){
		echo '<li style="display: contents;">
			<div class="row text-center">
				<h6>Doctor Not Available</h6>
			</div>
		</li>';
	} else {

	if ($doctor_id == '' && $booking_type == '' && $chosendate == '' && $booking_day == '') {
		echo '<li style="display: contents;">
			<div class="row text-center">
				<h6>No Slots Available</h6>
			</div>
		</li>';
	} else {
		$sql_doctor_time_slot       = "SELECT id,is_available FROM doctor_time_slots as a WHERE a.doctor_id = ".$doctor_id . " AND a.day = '".strtolower($booking_day)."' AND a.type = ".$booking_type;
		$check_doctor_time_slot     = $db_connection->getDbHandler()->query($sql_doctor_time_slot);
		$existing_doctor_time_slot  = $check_doctor_time_slot->fetch();

		if($existing_doctor_time_slot != '' && isset($existing_doctor_time_slot['is_available']) && $existing_doctor_time_slot['is_available'] == 1) {
			$doctor_time_slot_id	= $existing_doctor_time_slot['id'];
			$sql_booking_slot		= "SELECT id,booking_time FROM booking_details WHERE doctor_id = $doctor_id AND booking_date = '".date('Y-m-d', strtotime($booking_date))."' AND booking_status !=2";
			$res_booking_slot   	= $db_connection->getDbHandler()->query($sql_booking_slot);
			$total_booking_slots 	= $res_booking_slot->fetchAll();
			$selected_booking_slots = array_map(function ($value) { return $value['booking_time']; }, $total_booking_slots);

			$sql_time_slot_video            = "SELECT * FROM  doctor_day_time_slots WHERE doctor_time_slot_id = $doctor_time_slot_id";
			$res_time_slot_video            = $db_connection->getDbHandler()->query($sql_time_slot_video);
			$list_of_available_time_slots   = $res_time_slot_video->fetchAll();

			if ($list_of_available_time_slots) {
				$booked_count = 0;
				foreach ($list_of_available_time_slots as $key=> $list_time_slot) {
					if(!in_array($list_time_slot['slot_time'], $selected_booking_slots)) {
						if ($chosendate == date('d-m-Y') ) {
							if (strtotime($list_time_slot['slot_time']) > strtotime(date('g:i A'))) {
								$booked_count = $booked_count + 1;
								echo '<li>
										<input class="chosen_slot_time'.$class_type.'" type="radio" id="radio'.$list_time_slot['id'].'" name="chosen_slot_time" value="'.$list_time_slot['slot_time'].'">
										<label id="lblradio'.$list_time_slot['id'].'" for="radio'.$list_time_slot['id'].'">'.$list_time_slot['slot_time'].'</label>
									</li>';
							}
						} else {
							$booked_count = $booked_count + 1;
							echo '<li>
									<input class="chosen_slot_time'.$class_type.'" type="radio" id="radio'.$list_time_slot['id'].'" name="chosen_slot_time" value="'.$list_time_slot['slot_time'].'">
									<label id="lblradio'.$list_time_slot['id'].'" for="radio'.$list_time_slot['id'].'">'.$list_time_slot['slot_time'].'</label>
								</li>';
						}
					}
				}
				if ($booked_count == 0) {
					echo '<li style="display: contents;">
						<div class="row text-center">
							<h6>No Slots Available.</h6>
						</div>
					</li>';
				}
			} else {
				echo '<li style="display: contents;">
					<div class="row text-center">
						<h6>No Slots Available</h6>
					</div>
				</li>';
			}
		} else {
			echo '<li style="display: contents;">
				<div class="row text-center">
					<h6>No Slots Available</h6>
				</div>
			</li>';
		}
	}
	}
}
//Clinic update
elseif ($action=='clinic_update')
{
	if(!isset($_POST['name']) 
	|| !isset($_POST['address']) 
	|| !isset($_POST['time_slot']) 
	) {
		die(json_encode(
			array(
				'msg'=>"We are sorry, but there appears to be a problem with the form you submitted.",
				'icon'=>'error',
				'title' => 'Clinic Create'
		)));
	}
	$name = trim($_POST['name']);
	$address = trim($_POST['address']);
	$time_slot = trim($_POST['time_slot']);
	$cid = trim($_POST['clinicid']);
	$map_link = trim($_POST['map_link']);
	$clinic_phone = trim($_POST['clinic_phone']);
	$today =  date("Y-m-d H:i:s");

	$sql_user_insert = "UPDATE `clinic_details` set `name`=:name,`address`=:address,`time_slot`=:timeslot,`contact_number`=:clinicphone,`google_map_link`=:maplink WHERE id=:cid";
	$udstmt = $db_connection->getDbHandler()->prepare($sql_user_insert);


	$udstmt->bindParam(':name', $name);
	$udstmt->bindParam(':address', $address);
	$udstmt->bindParam(':timeslot', $time_slot);
	$udstmt->bindParam(':maplink', $map_link);
	$udstmt->bindParam(':clinicphone', $clinic_phone);
	$udstmt->bindParam(':cid', $cid);
	
	if($udstmt->execute()){
		echo json_encode(array(
			'msg'=>"",
			'icon'=>'success',
			'title'=> 'Clinic Details Updated'
		));
	}
	else{
		print_r(error_get_last());
	
		die(json_encode(
			array(
				'msg'=>"We are sorry, but there appears to be a problem with the form you submitted.",
				'icon'=>'error',
				'title' => 'Clinic Update Failed'
		)));
	}

}
//galleryAdd
else if($action == 'galleryAdd'){


	if( !isset($_POST['userid']) || !isset($_FILES['gallerynew']['name'])) {
		die(json_encode(
			array(
				'msg'=>"",
				'icon'=>'error',
				'title' => 'Unable to add Image'
		)));
	}

	$userid = trim($_POST['userid']);

	if (isset($_FILES['gallerynew']['name']))
	{
		$info = pathinfo($_FILES['gallerynew']['name']);
		if($info["basename"] !== ""){
			$ext = $info['extension']; // get the extension of the file
			$newname = date("Y_m_d_H_m_s").".".$ext;
			$galleryImg = $newname;
			$target = dirname(__DIR__).'/datafiles/uploads/clinicImg/'.$newname;
			move_uploaded_file( $_FILES['gallerynew']["tmp_name"], $target);
		}
	}

	$sql_gallery_insert = "INSERT INTO `clinic_gallery` (`user_id`,`imgpath`) VALUES(:userid,:imagepath)";
	$stmt = $db_connection->getDbHandler()->prepare($sql_gallery_insert);
	$stmt->bindParam(':userid', $userid);
	$stmt->bindParam(':imagepath', $galleryImg);

	if($stmt->execute()){
		echo json_encode(array(
			'msg'=>"",
			'icon'=>'success',
			'title'=> 'Gallery Updated'
		));
	}
	else{
		print_r(error_get_last());
	
		die(json_encode(
			array(
				'msg'=>"",
				'icon'=>'error',
				'title' => 'Gallery Update Error'
		)));
	}



}

// Find Space
else if($action == "location_get_by_city")
{
	$city_id = $_POST["city_id"];
	if ($city_id === 'others' || $city_id === 'All') {
		$sql_locality = "SELECT id,name FROM locality";
	}
	else{
		$sql_locality = "SELECT id,name FROM locality WHERE city_id=$city_id";
	}
	$con_locality = $db_connection->getDbHandler()->query($sql_locality);
	if($con_locality)
	{
		$res_locality = $con_locality->fetchAll();
	}
	$html = '<option value="All" selected>All Location</option>';
	if(!empty($res_locality))
	{
		foreach($res_locality as $row_locality)
		{
			$location_id = $row_locality['id'];
			$location_name = $row_locality['name'];
			$html .= '<option value="'.$location_id.'">'.$location_name.'</option>';
		}
	}
	echo $html;
}
// Login
else if($action == "login")
{
	// check_login();
	$username = $_POST["username"];	
	if (isset($_POST['otpcheck'])) 
	{
		if($_POST["otp"]!='')
		{
			$otp = $_POST["otp"];
			if ($otp!=0) 
			{
				$query = "SELECT id,name,email,mobileNo FROM users WHERE (email='$username' OR mobileNo='$username') AND mobile_otp=$otp";
				$res_users = $db_connection->getDbHandler()->query($query);
				$row_users = $res_users->fetch();
				if($row_users)
				{					
					$query1 = "UPDATE users SET mobile_otp=0 WHERE id=".$row_users["id"];
					$result1 = $db_connection->getDbHandler()->query($query1);
					$_SESSION['ap_profrea_login_id'] = $row_users['id'];
					echo "0";
				}
				else
				{
					echo "5";
				}
			}
			else
			{
				echo "5";
			}
		}
		else
		{
			$query = "SELECT id,name,email,mobileNo FROM users WHERE (email='$username' OR mobileNo='$username')";
			$result = $db_connection->getDbHandler()->query($query);
			$rows = $result->fetch();
			if($rows)
			{
				$mobile_otp = rand(100000,999999);
				$query1 = "UPDATE users SET mobile_otp='$mobile_otp' WHERE id=".$rows["id"];
				
				$result1 = $db_connection->getDbHandler()->query($query1);
				if($result1)
				{
					if ( checkEmail($username) ) {
						$email_subject = "OTP Generated with Profrea!!!";
						
						$email_message = file_get_contents("../template/otpmail.html");
						$email_message = str_replace("@@otp@@",$mobile_otp,$email_message);
					

						$result = sendMail( $email_subject,$email_message, $username);
						echo "3";
					}
					else{
						try {
							$message    = $mobile_otp." is your Profrea OTP. Do not share it with anyone.";
							$mobileNos  = $rows["mobileNo"];
							
							$url = "https://sms.nettyfish.com/api/v2/SendSMS?SenderId=PRFREA&Message=".urlencode($message)."&MobileNumbers=".$mobileNos."&ApiKey=pNIg7phvNboA+wW5Q4gDgYTOYOK3q4/gRTSud7uoGTI=&ClientId=bea0553d-0c7f-481f-a8af-f65db8a5b395";

							$ch = curl_init();
							curl_setopt($ch, CURLOPT_URL,$url);
							curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
							curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET"); 
							
							$output = curl_exec($ch);
							curl_close($ch);
							$json   = json_decode($output, true);
							if (isset($json["ErrorCode"]) && $json["ErrorCode"] =='0') {
								echo "3";
							} else {
								echo "6";
							}
						} catch (\Exception $e) {
							echo "6";
						}
					}
				}
				else
				{
					echo "4";
				}
			}
			else
			{
				echo "2";
			}
		}
	}
	else
	{
		$password = md5($_POST["password"]);

		$query = "SELECT * FROM users WHERE (email='$username' OR mobileNo='$username') AND password='$password'";
		$result = $db_connection->getDbHandler()->query($query); 
		$row_users = $result->fetch();
		if($row_users)
		{
			$_SESSION['ap_profrea_login_id'] = $row_users['id'];
			echo "0";
		}
		else
		{
			
			echo "1";
		}
	}	
}
// Register
else if($action == "register")
{
	$name = $_POST["name"];
	$profession = isset($_POST["profession"]) ? $_POST["profession"] : 1;
	$email = $_POST["email"];
	$phone = $_POST["phone"];
	$password = md5($_POST["password"]);
	$mobile_otp = rand(100000,999999);

	if($_POST["otp"]!='')
	{
		$otp = $_POST["otp"];
		if ($otp!=0) 
		{
			$query = "SELECT id,name,email,mobileNo FROM users WHERE (email='$email' OR mobileNo='$phone') AND mobile_otp=$otp";
			$res_users = $db_connection->getDbHandler()->query($query);
			$row_users = $res_users->fetch();
			if($row_users)			{
				
				$query1 = "UPDATE users SET mobile_otp=0 WHERE id=".$row_users["id"];
				$result1 = $db_connection->getDbHandler()->query($query1);
				$_SESSION['ap_profrea_login_id'] = $row_users['id'];
				echo "0";
			}
			else
			{
				echo "5";
			}
		}
		else
		{
			echo "5";
		}
	}
	else
	{
		$query = "SELECT id,name,email,mobileNo FROM users WHERE email='$email' OR mobileNo='$phone'"; 
		$res_users = $db_connection->getDbHandler()->query($query);
		$row_users = $res_users->fetch();
		if($row_users)
		{
			echo "1";
		}
		else
		{
			$query1 = "INSERT INTO users (name,profession_id,email,mobileNo,mobile_otp,password) VALUES(:name,:profession,:email,:mobileNo,:mobile_otp,:password)";
			$result1 = $db_connection->getDbHandler()->prepare($query1);
			$result1->bindParam(':name', $name);
			$result1->bindParam(':profession', $profession);
			$result1->bindParam(':email', $email);
			$result1->bindParam(':mobileNo', $phone);
			$result1->bindParam(':mobile_otp', $mobile_otp);
			$result1->bindParam(':password', $password);
			if( $result1->execute() )
			{
				$email_subject = "OTP Generated with Profrea!!!";
				
				$email_message = file_get_contents("../template/otpmail.html");
				$email_message = str_replace("@@otp@@",$mobile_otp,$email_message);
				


				$result = sendMail( $email_subject,$email_message, $email);

				try {
					$message    = $mobile_otp." is your Profrea OTP. Do not share it with anyone.";
					$mobileNos  = $phone;
					
					$url = "https://sms.nettyfish.com/api/v2/SendSMS?SenderId=PRFREA&Message=".urlencode($message)."&MobileNumbers=".$mobileNos."&ApiKey=pNIg7phvNboA+wW5Q4gDgYTOYOK3q4/gRTSud7uoGTI=&ClientId=bea0553d-0c7f-481f-a8af-f65db8a5b395";

					$ch = curl_init();
					curl_setopt($ch, CURLOPT_URL,$url);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
					curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET"); 
					
					$output = curl_exec($ch);
					curl_close($ch);
					$json   = json_decode($output, true);
					if (isset($json["ErrorCode"]) && $json["ErrorCode"] =='0') {
						echo "3";
					} else {
						echo "6";
					}
				} catch (\Exception $e) {
					echo "6";
				}
			}
			else
			{
				echo "4";
			}
		}
	}
}
// Forgetpassword
else if($action == "forgetpassword")
{
	// check_login();
	$username = $_POST["username"];
	if(isset($_POST["otp"]) && $_POST["otp"]!='') {
		$otp = $_POST["otp"];
		if ($otp!=0) {
			$query = "SELECT id,name,mobileNo FROM users WHERE (email='$username' OR mobileNo='$username') AND mobile_otp=$otp";
			$res_users = $db_connection->getDbHandler()->query($query);
			$row_users = $res_users->fetch();
			if($row_users) {					
				$query1 = "UPDATE users SET mobile_otp=0 WHERE id=".$row_users["id"];
				$result1 = $db_connection->getDbHandler()->query($query1);
				$_SESSION['ap_profrea_login_id'] = $row_users['id'];
				echo "0";
			} else {
				echo "5";
			}
		} else {
			echo "5";
		}
	} else {
		$query = "SELECT id,name,email,mobileNo FROM users WHERE email='$username' OR mobileNo='$username'";
		$result = $db_connection->getDbHandler()->query($query);
		$rows = $result->fetch();
		if($rows) {
			$mobile_otp = rand(100000,999999);
			$query1 = "UPDATE users SET mobile_otp='$mobile_otp' WHERE id=".$rows["id"];
			$result1 = $db_connection->getDbHandler()->query($query1);
			if($result1) {
				if ( checkEmail($username) ) {
					$email_subject = "OTP Generated with Profrea!!!";
					
					$email_message = file_get_contents("../template/otpmail.html");
					$email_message = str_replace("@@otp@@",$mobile_otp,$email_message);
					
					$result = sendMail( $email_subject,$email_message, $rows['email']);
					echo "3";
				} else {
					try {
						$message    = $mobile_otp." is your Profrea OTP. Do not share it with anyone.";
						$mobileNos  = $rows["mobileNo"];
						
						$url = "https://sms.nettyfish.com/api/v2/SendSMS?SenderId=PRFREA&Message=".urlencode($message)."&MobileNumbers=".$mobileNos."&ApiKey=pNIg7phvNboA+wW5Q4gDgYTOYOK3q4/gRTSud7uoGTI=&ClientId=bea0553d-0c7f-481f-a8af-f65db8a5b395";
	
						$ch = curl_init();
						curl_setopt($ch, CURLOPT_URL,$url);
						curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
						curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET"); 
						
						$output = curl_exec($ch);
						curl_close($ch);
						$json   = json_decode($output, true);
						if (isset($json["ErrorCode"]) && $json["ErrorCode"] =='0') {
							echo "3";
						} else {
							echo "6";
						}
					} catch (\Exception $e) {
						echo "6";
					}
				}
			} else {
				echo "4";
			}
		} else {
			echo "2";
		}
	}
}
// Resetpassword
else if($action == "resetpassword")
{
	$username = $_POST["username"] ?? '';	
	$query = "SELECT id,name,email,mobileNo FROM users WHERE email='$username' OR mobileNo='$username'";
	$result = $db_connection->getDbHandler()->query($query);
	$rows = $result->fetch();
	if ($rows) {
		$password = md5($_POST["password"]);
		$query1 = "UPDATE users SET password='$password' WHERE id=".$rows["id"];
		$result1 = $db_connection->getDbHandler()->query($query1);
		if($result1) {
			$_SESSION['ap_profrea_login_id'] = $rows['id'];
			echo "0";
		} else {
			echo "2";
		}
	} else {
		echo "1";
	}
}
// Changepassword
else if($action == "changepassword")
{
	$login_id = $_POST["login_id"];	
	$query = "SELECT id,name,mobileNo FROM users WHERE id=$login_id";
	$result = $db_connection->getDbHandler()->query($query);
	$rows = $result->fetch();
	if($rows)
	{
		$password = md5($_POST["password"]);
		$query1 = "UPDATE users SET password='$password' WHERE id=".$rows["id"];
		$result1 = $db_connection->getDbHandler()->query($query1);
		if($result1)
		{	
			echo "0";
		}
		else
		{
			echo "2";
		}
	}
	else
	{
		echo "1";
	}
}
// Resend OTP
else if($action == "resendotp")
{
	$resendotpfrom = $_POST["resendotpfrom"];
	if($resendotpfrom == 'login' || $resendotpfrom == 'forgotpassword'){
		$username = $_POST["username"];
		$qry = "email='".$username."' OR mobileNo='".$username."'";
	}
	else if ($resendotpfrom == 'register') {
		$email = $_POST["email"];
		$phone = $_POST["phone"];
		$qry = "email='".$email."' AND mobileNo='".$phone."'";
	}
	$query = "SELECT id,name,email,mobileNo FROM users WHERE $qry";
	$result = $db_connection->getDbHandler()->query($query);
	$rows = $result->fetch();
	if($rows)
	{
		$mobile_otp = rand(100000,999999);
		$query1 = "UPDATE users SET mobile_otp='$mobile_otp' WHERE id=".$rows["id"];
		$result1 = $db_connection->getDbHandler()->query($query1);
		if($result1)
		{
			if ($resendotpfrom == 'register') {
				$email_subject = "OTP Generated with Profrea!!!";
				$email_message = file_get_contents("../template/otpmail.html");
				$email_message = str_replace("@@otp@@",$mobile_otp,$email_message);
				
				$result = sendMail( $email_subject,$email_message, $email);

				try {
					$message    = $mobile_otp." is your Profrea OTP. Do not share it with anyone.";
					$mobileNos  = $phone;
					
					$url = "https://sms.nettyfish.com/api/v2/SendSMS?SenderId=PRFREA&Message=".urlencode($message)."&MobileNumbers=".$mobileNos."&ApiKey=pNIg7phvNboA+wW5Q4gDgYTOYOK3q4/gRTSud7uoGTI=&ClientId=bea0553d-0c7f-481f-a8af-f65db8a5b395";

					$ch = curl_init();
					curl_setopt($ch, CURLOPT_URL,$url);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
					curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET"); 
					
					$output = curl_exec($ch);
					curl_close($ch);
					$json   = json_decode($output, true);
					if (isset($json["ErrorCode"]) && $json["ErrorCode"] =='0') {
						echo "0";
					} else {
						echo "3";
					}
				} catch (\Exception $e) {
					echo "3";
				}
			} else {
				if ( checkEmail($username) ) {
					$email_subject = "OTP Generated with Profrea!!!";
					

					$email_message = file_get_contents("../template/otpmail.html");
					$email_message = str_replace("@@otp@@",$mobile_otp,$email_message);
					

					$result = sendMail( $email_subject,$email_message, $username);
					echo "0";
				} else {
					try {
						$message    = $mobile_otp." is your Profrea OTP. Do not share it with anyone.";
						$mobileNos  = $rows["mobileNo"];
						
						$url = "https://sms.nettyfish.com/api/v2/SendSMS?SenderId=PRFREA&Message=".urlencode($message)."&MobileNumbers=".$mobileNos."&ApiKey=pNIg7phvNboA+wW5Q4gDgYTOYOK3q4/gRTSud7uoGTI=&ClientId=bea0553d-0c7f-481f-a8af-f65db8a5b395";
	
						$ch = curl_init();
						curl_setopt($ch, CURLOPT_URL,$url);
						curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
						curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET"); 
						
						$output = curl_exec($ch);
						curl_close($ch);
						$json   = json_decode($output, true);
						if (isset($json["ErrorCode"]) && $json["ErrorCode"] =='0') {
							echo "0";
						} else {
							echo "6";
						}
					} catch (\Exception $e) {
						echo "6";
					}
				}
			}
		}
		else
		{
			echo "1";
		}
	}
	else
	{
		echo "2";
	}
}
else if($action == "getSpaceData"){
	//check_login();
	$city = (isset($_POST["city_id"])?$_POST["city_id"]:"");
	$industry = (isset($_POST["industry_id"])?$_POST["industry_id"]:"");
	$offset = (isset($_POST["offset"])?$_POST["offset"]:0);
	$count = (isset($_POST["count"])?$_POST["count"]:"false");
	$returnData = $real_estate->viewFilterData($city,"",$industry,"",$offset);
	$countData = ($count === "true"?$real_estate->viewFilterData($city,"",$industry,"",$offset,$count):array());
	
	foreach($returnData as $key => $value){
		$image ="";
		$fileList = glob("../datafiles/spaces/".$value->id."/space_image_profile/*");
		if(sizeof($fileList)>0)
				$image = str_replace("../","",$fileList[0]);
		$returnData[$key]->imageLocation = $image;
		if(sizeof($countData) > 0 && $key === 0){
			$returnData[$key]->count = $countData[0]->count;
		}
	}
	echo json_encode($returnData);
}
else if($action == "publish"){
	$wdid = $_POST["wdid"];
	$query = "UPDATE website_details SET publish_status=1 WHERE id=$wdid";
	$result = $db_connection->getDbHandler()->query($query);
	if($result)
	{
		echo json_encode(array(
			'msg'=>"Website Published",
			'icon'=>'success',
			'title'=> 'Success'
		));
	}
	else{
		echo json_encode(array(
			'msg'=>"Website UnPublished",
			'icon'=>'error',
			'title' => 'Error'
		));
	}	
}
else if($action == "unpublish"){
	$wdid = $_POST["wdid"];
	$query = "UPDATE website_details SET publish_status=0 WHERE id=$wdid";
	$result = $db_connection->getDbHandler()->query($query);
	if($result)
	{
		echo json_encode(array(
			'msg'=>"Website Unpublished",
			'icon'=>'success',
			'title'=> 'Success'
		));
	}
	else{
		echo json_encode(array(
			'msg'=>"Website Unpublished",
			'icon'=>'error',
			'title' => 'Error'
		));
	}	
}
function check_login(){
	if (isset($_SESSION['ap_profrea_login_id'])) 
	{    
		$login_id = $_SESSION['ap_profrea_login_id'];
	}
	else{
		echo json_encode(
			array(
				'msg'=>"We are sorry, but there appears to be a problem with the form you submitted.",
				'icon'=>'error',
				'title' => 'Service'
		));
		die();
	}
}

// Profession Insert
if ($action=='callback_request')
{
	if(!isset($_POST['full_name']) 
	|| !isset($_POST['phone']) 
	) {
		echo json_encode(
			array(
				'msg'=>"We are sorry, but there appears to be a problem with the form you submitted.",
				'icon'=>'error',
				'title' => 'Callback failed'
		));
		$_SESSION["mode"] = "error";
		$_SESSION["msg"] = "We are sorry, but there appears to be a problem with the form you submitted.";
		header('Location: index.php');
	}
	$full_name = trim($_POST['full_name']);
	//$profession = trim($_POST['profession']);
	$email = trim($_POST['email']);
	$phone = trim($_POST['phone']);
	$enquiry_details = trim($_POST['your_message']);
	$page = trim($_POST['page']);
	$enquiry_type = trim($_POST['enquiry_type']);

	$sql_space_type_insert = "INSERT INTO `website_enquiry` (`name`,`mail`,`phone`,`enquiry_from_page`,`enquiry_type`,`enquiry_details`) VALUES(:name,:mail,:phone,:enquiry_from_page,:enquiry_type,:enquiry_details)";
	$stmt = $db_connection->getDbHandler()->prepare($sql_space_type_insert);
	$stmt->bindParam(':name', $full_name);
	//$stmt->bindParam(':profession', $profession);
	$stmt->bindParam(':mail', $email);
	$stmt->bindParam(':phone', $phone);
	$stmt->bindParam(':enquiry_from_page', $page);
	$stmt->bindParam(':enquiry_type', $enquiry_type);
	$stmt->bindParam(':enquiry_details', $enquiry_details);

	if( $stmt->execute() )
	{

		if($email != ""){
		 $email_subject = "Callback Request Initiated with Profrea!!!";
		 $email_message_content = '<p style="font-size:15px;">Hey <b>'.$full_name.'</b>,
		 Thank you for interest in Profrea! Our executive will soon get in touch with you to help you on boarded with Profrea. </p>';

		 $email_message = file_get_contents("../template/getcallback.html");
		 $email_message = str_replace("@@message@@",$email_message_content,$email_message);
		 


		 $result = sendMail($email_subject,$email_message,$email);
		}

		$email_subject = $full_name." Initiated Callback Request with Profrea!!!";
		$email_message_content = '
		<p style="font-size:15px;">Dear Admin, </p>
		<p style="font-size:15px;">'.$full_name.' has requested a callback from Profrea Team</p>
		<p style="font-size:15px;">Name :'.$full_name.'</p>
		<p style="font-size:15px;">Phone :'.$phone.'</p>
		<p style="font-size:15px;">e-mail :'.$email.'</p>
		<p style="font-size:15px;">From Page :'.$page.'</p>
		<p style="font-size:15px;">Enquiry Type :'.$enquiry_type.'</p>
		<p style="font-size:15px;">Enquiry message :'.$enquiry_details.'</p>
	   <p style="font-size:15px;"><br/><br/><b>Thanks</b>, </p>';

	   $email_message = file_get_contents("../template/getcallback.html");
	   $email_message = str_replace("@@message@@",$email_message_content,$email_message);
	   

		
		sendMail($email_subject,$email_message,'marketing@profrea.com');
		sendMail($email_subject,$email_message,'saurabh3178@gmail.com');
		sendMail($email_subject,$email_message,'hello@webchirpy.com');

		// $email_subject = "Thanks you are successfully registered with Profrea!!!";
		// $email_message = '<html><body>
		// <p style="font-size:15px;">Hey <b>'.$full_name.'</b>, </p>
		// <p style="font-size:15px;">Thank you for posting your workspace with us! </p>
		// <p style="font-size:15px;">Your workspace will be screened in 48 business hours. Once approved, it will start featuring in the search results. </p>
		// <p style="font-size:15px;">Have a question? Visit Profrea Contact Us section. </p>
		// <p style="font-size:15px;"><br/><br/><b>To your success</b>, </p>
		// <p style="font-size:15px;">Team Profrea </p>
		// <p style="font-size:28px;"><img src="https://www.profrea.com/img/mail.png" height="42" width="82"> </p>
		// <p style="font-size:12px;"><br/><br/><u>Confidentiality Warning</u>: This message and any attachments are intended only for the use of the intended recipient(s), are confidential and may be privileged. If you are not the intended recipient, you are hereby notified that any review, re-transmission, conversion to hard copy, copying, circulation or other use of this message and any attachments is strictly prohibited. If you are not the intended recipient, please notify the sender immediately by return email and delete this message and any attachments from your system. </p>
		// </body></html>';
		// $result = sendMail($email_subject,$email_message,$email);
		// echo $result;
		// if ($result) {
		// 	sendMail($email_subject,$email_message,'info@profrea.com',$email,$full_name);
		// 	sendMail($email_subject,$email_message,'marketing@profrea.com',$email,$full_name);
		echo json_encode(array(
				'msg'=>"Thanks for providing us your details, Our team will get back to you soon.",
				'icon'=>'success',
				'title'=> 'Callback Request'
		));
		// } 
		// else {
		// 	echo json_encode(
		// 		array(
		// 			'msg'=>"Error! There is some problem while submitting your request. Please try again",
		// 			'icon'=>'error',
		// 			'title' => 'Profession'
		// 	));
		// }
	}
	else
	{
		echo 'Query Failed';
	}
}

// booking cancel
if ($action=='booking_cancel')
{
	
	if(!isset($_POST['reason']) 
	|| !isset($_POST['booking_no']) 
	) {
		echo json_encode(
			array(
				'msg'=>"We are sorry, but there appears to be a problem with the form you submitted.",
				'icon'=>'error',
				'title' => 'Booking Cancel Status Request'
		));
		return false;
	}

	$reason 			= $_POST['reason'];
	$booking_no 		= $_POST['booking_no'];
	$booking_status 	= 2;

	$sql_update = "UPDATE `booking_details` set `booking_status` = :bookingstatus, `reason` = :reason where booking_no = :bookingno";

	$booking = $db_connection->getDbHandler()->prepare($sql_update);
	$booking->bindParam(':bookingstatus', $booking_status);
	$booking->bindParam(':bookingno', $booking_no);
	$booking->bindParam(':reason', $reason);

	if($booking->execute()){

		$sql_users					= "SELECT id,booking_no,payment_id,doctor_id,user_id,booking_date,booking_time FROM booking_details as a WHERE a.doctor_id = ".$login_id . " AND a.booking_no = '$booking_no'";
		$check_users				= $db_connection->getDbHandler()->query($sql_users);
		$booking					= $check_users->fetch();

		
		$doctor_id 	= $booking['doctor_id'];
		$user_id 	= $booking['user_id'];
		$payment_id = $booking['payment_id'];
		
		$booking_date_time = $booking['booking_date'].$booking['booking_time'];

		$query_user = "SELECT id,name,email,mobileNo FROM users WHERE id='$user_id'";
		$res_users = $db_connection->getDbHandler()->query($query_user);
		$row_users = $res_users->fetch();

		$query_doctor = "SELECT id,name,email,mobileNo FROM users WHERE id='$doctor_id'";
		$res_doctor = $db_connection->getDbHandler()->query($query_doctor);
		$row_doctor = $res_doctor->fetch();
		
		try {
			if($row_users['email']){
				$email_subject = "Emergency Cancellation of Booking From Profrea!!!";
						
				$user_email = file_get_contents("../template/slot-emergency-user.html");
				$user_email = str_replace("@@name@@",$row_users['name'],$user_email);
				$user_email = str_replace("@@razorpay_payment_id@@",$payment_id,$user_email);
				$user_email = str_replace("@@date_time@@",date('d-M-y, g:i A', strtotime($booking_date_time)),$user_email);
				$user_email = str_replace("@@doctor_name@@",$row_doctor['name'],$user_email);
				
				$result = sendMail( $email_subject,$user_email, $row_users['email']);
			}
		} catch (Exception $e){

		}

		echo json_encode(array(
				'msg'=>"Booking Cancelled Successfully",
				'icon'=>'success',
				'title'=> 'Booking Cancel'
		));
	} else {
		echo json_encode(array(
			'msg'=>"",
			'icon'=>'error',
			'title'=> 'Booking Error'
		));
	}
}

if ($action=='checkEmailPhone')
{
	if(isset($_POST['email']) != '' && isset($_POST['phone']) != '') {
		$email 		= $_POST['email'];
		$mobileno 	= $_POST['phone'];

		$query = "SELECT * FROM users WHERE email='$email' AND mobileNo = $mobileno";
		$res_users = $db_connection->getDbHandler()->query($query);
		$row_users = $res_users->fetch();

		if($row_users){
			echo json_encode(
				array(
					'msg'=>"1",	// Existing User
			));
		} else{
			$query_email= "SELECT * FROM users WHERE email ='$email'";
			$res_users_email = $db_connection->getDbHandler()->query($query_email);
			$row_users_email = $res_users_email->fetch();

			$query_mobile= "SELECT * FROM users WHERE mobileNo = $mobileno";
			$res_users_mobile = $db_connection->getDbHandler()->query($query_mobile);
			$row_users_mobile = $res_users_mobile->fetch();
			
			if($row_users_email && $row_users_mobile){
				if($row_users_email['id'] != $row_users_mobile['id']){
					echo json_encode(
						array(
							'msg'=>"The Phone number Or Email has been linked to another account...", // email or phone number already taken 
						));
				}else{
					echo json_encode(
						array(
							'msg'=>"1", // New User
						));
				}
			}else{
				echo json_encode(
						array(
							'msg'=>"1", // New User
						));
			}

			// if($row_users_email){
			// 	if(!$row_users_mobile){
			// 		echo json_encode(
			// 				array(
			// 					'msg'=>"The Phone Number that you've entered doesn't match your account", // phone number invalid but email matched
			// 				));
			// 	}else{
			// 		echo json_encode(
			// 				array(
			// 					'msg'=>"0", // New user
			// 			));
			// 	}
			// } else {
			// 	if($row_users_mobile){
			// 		if(!$row_users_email){
			// 			echo json_encode(
			// 					array(
			// 						'msg'=>"The email address that you've entered doesn't match your account", // Email invalid but phone number matched
			// 				));
			// 		}
			// 	} else{
			// 		echo json_encode(
			// 			array(
			// 				'msg'=>"0", // New user
			// 		));
			// 	}
			// }

		}
	}

}

if ($action=='booking_attachment')
{
	if(!isset($_FILES['attachment']) 
	|| !isset($_POST['booking_no'])
	) {
		echo json_encode(
			array(
				'msg'=>"We are sorry, but there appears to be a problem with the form you submitted.",
				'icon'=>'error',
				'title' => 'Booking Attachment Request'
		));
		return false;
	}

	function generateRandomString($length = 20) {
        return substr(str_shuffle(str_repeat($x='012_3456789abcdefghijklmnopq_rstuvwxyz_ABCDEFGHIJKLMNO_PQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
    }

	$booking_no = $_POST['booking_no'];
	if (isset($_FILES['attachment']['name']))
	{
		foreach($_FILES['attachment']['name'] as $key => $value){
			$created_at = date('Y-m-d h:i:s');
			$info = pathinfo($_FILES['attachment']['name'][$key]);
			if($info["basename"] !== ""){
				$ext = $info['extension']; // get the extension of the file
				if($ext == 'pdf' || $ext == 'png' || $ext == 'jpeg' ||  $ext == 'jpg'){
					$newname = generateRandomString().".".$ext;
					$attachment = $newname;
					$target = dirname(__DIR__).'/datafiles/uploads/patient_attachments/'.$newname;
					move_uploaded_file( $_FILES['attachment']["tmp_name"][$key], $target);

					$sql_attachment = "INSERT INTO `attachments` (`booking_no`,`attachment`,`created_at`) VALUES(:booking_no,:attachment,:created_at)";
					$stmt = $db_connection->getDbHandler()->prepare($sql_attachment);
					$stmt->bindParam(':booking_no', $booking_no);
					$stmt->bindParam(':attachment', $attachment);
					$stmt->bindParam(':created_at', $created_at);
					$stmt->execute();
				} else {
					echo json_encode(array(
						'msg'=>" Use (pdf, jpg, jpeg, png)",
						'icon'=>'error',
						'title'=> 'Format Not Allowed'
					));
					return false;
				}
			}
		}
		echo json_encode(array(
				'msg'=>"Booking Attachment Added Successfully",
				'icon'=>'success',
				'title'=> 'Booking Attachment'
		));
	}
	
}
elseif ($action=='deleteAttachment')
{
	if(!isset($_POST['fileid'])) {
		die(json_encode(
			array(
				'msg'=>"We are sorry, but there appears to be a problem with the form you submitted.",
				'icon'=>'error',
				'title' => 'Attachment Delete'
		)));
	}
	$fileid = trim($_POST['fileid']);

	$sql_files		= "SELECT * from attachments WHERE id = $fileid";
	$check_files	= $db_connection->getDbHandler()->query($sql_files);
	$existing_files	= $check_files->fetch();

	if($existing_files['attachment']){
		unlink(dirname(__DIR__).'/datafiles/uploads/patient_attachments/'.$existing_files['attachment']); 
	}

	$sql_user_insert = "DELETE from `attachments` where id=:fileid";
	$udstmt = $db_connection->getDbHandler()->prepare($sql_user_insert);
	$udstmt->bindParam(':fileid', $fileid);
	if($udstmt->execute()){
		echo json_encode(array(
			'msg'=>"",
			'icon'=>'success',
			'title'=> 'Attachment Removed'
		));
	}
	else{
		die(json_encode(
			array(
				'msg'=>"We are sorry, but there appears to be a problem with the form you submitted.",
				'icon'=>'error',
				'title' => 'Attachment Remove Failed'
		)));
	}
}
if ($action=='booking_complete')
{
	
	if(!isset($_POST['booking_status'])
	|| !isset($_POST['booking_no'])
	) {
		echo json_encode(
			array(
				'msg'=>"We are sorry, but there appears to be a problem with the form you submitted.",
				'icon'=>'error',
				'title' => 'Booking Status Change Request'
		));
		return false;
	}

	$booking_no 		= $_POST['booking_no'];
	$booking_status 	= $_POST['booking_status'];

	$sql_update = "UPDATE `booking_details` set `booking_status` = :bookingstatus where booking_no = :bookingno";

	$booking = $db_connection->getDbHandler()->prepare($sql_update);
	$booking->bindParam(':bookingstatus', $booking_status);
	$booking->bindParam(':bookingno', $booking_no);

	if($booking->execute()){
		echo json_encode(array(
				'msg'=>"Booking Status Changed Successfully",
				'icon'=>'success',
				'title'=> 'Booking Status'
		));
	} else {
		echo json_encode(array(
			'msg'=>"",
			'icon'=>'error',
			'title'=> 'Booking Error'
		));
	}
}

// Schedule Visit
if ($action=='schedule_visit')
{
	if(!isset($_POST['full_name'])
	|| !isset($_POST['phone'])
	) {
		echo json_encode(
			array(
				'msg'=>"We are sorry, but there appears to be a problem with the form you submitted.",
				'icon'=>'error',
				'title' => 'Visit Request'
		));
		return false;
		//$_SESSION["mode"] = "error";
		//$_SESSION["msg"] = "We are sorry, but there appears to be a problem with the form you submitted.";
		//header('Location: index.php');
	}
	$full_name = trim($_POST['full_name']);
	$space_id = trim($_POST['space_id']);
	$email = trim($_POST['email']);
	$phone = trim($_POST['phone']);
	$select_date = trim($_POST['scheduletime']);

	$sql_space_type_insert = "INSERT INTO `space_enquiry` (`first_name`,`space_id`,`email`,`mobile`,`select_date`) VALUES(:full_name,:space_id,:mail,:phone,:select_date)";
	//echo $sql_space_type_insert;
	$stmt = $db_connection->getDbHandler()->prepare($sql_space_type_insert);
	$stmt->bindParam(':full_name', $full_name);
	$stmt->bindParam(':space_id', $space_id);
	$stmt->bindParam(':mail', $email);
	$stmt->bindParam(':phone', $phone);
	$stmt->bindParam(':select_date', $select_date);

	if( $stmt->execute() )
	{
		
		if($email != ""){
			$email_subject = "Visit Request Initiated with Profrea!!!";
			$email_message_content = 'Hey <b>'.$full_name.'</b>, Thank you for interest in Profrea! Our executive will soon get in touch with you to help you on boarded with Profrea.';

			$email_message = file_get_contents("../template/getcallback.html");
			$email_message = str_replace("@@message@@",$email_message_content,$email_message);
			
	 

			
			$result = sendMail($email_subject,$email_message,$email);
		   }
   
		   $email_subject = $full_name." Initiated Schedule a Visit Request with Profrea!!!";
		   $email_message_content = '
		   <p style="font-size:15px;">Dear Admin, </p>
		   <p style="font-size:15px;">'.$full_name.' has requested a  Schedule a Visit from Profrea Team for the property with ID : '.$space_id.'</p>
		   <p style="font-size:15px;">Name :'.$full_name.'</p>

		   <p style="font-size:15px;">Phone :'.$phone.'</p>
		   <p style="font-size:15px;">e-mail :'.$email.'</p>
		   <p style="font-size:15px;">Selected Date & Time for the Visit :'.$select_date.'</p>';

		   $email_message = file_get_contents("../template/getcallback.html");
		   $email_message = str_replace("@@message@@",$email_message_content,$email_message);
		   
	

		   sendMail($email_subject,$email_message,'hello@webchirpy.com');
		   sendMail($email_subject,$email_message,'marketing@profrea.com');
			sendMail($email_subject,$email_message,'saurabh3178@gmail.com');


		echo json_encode(array(
				'msg'=>"Your Visit to the clinic is confirmed",
				'icon'=>'success',
				'title'=> 'Visit Confirmed'
		));
		// } 
		// else {
		// 	echo json_encode(
		// 		array(
		// 			'msg'=>"Error! There is some problem while submitting your request. Please try again",
		// 			'icon'=>'error',
		// 			'title' => 'Profession'
		// 	));
		// }
	}
	else
	{
		echo json_encode(
			array(
				'msg'=>"We are sorry, but there appears to be a problem with the form you submitted.",
				'icon'=>'error',
				'title' => 'Visit Request'
		));
		return false;
	}
}

// Book Now
if ($action=='booknow')
{
	// print_r($_POST);
	$user_id = trim($_POST['user_id']);
	$space_id = trim($_POST['space_id']);
	$plan_id = trim($_POST['plan_id']);
	$hours_per_day = 1;
	// $sql_plans = "SELECT * FROM p2_plans WHERE id=$plan_id";
	// $res_plans = $db_connection->getDbHandler()->query($sql_plans);
	// if($res_plans)
	// {
	// 	$plans = $res_plans->fetch();
	// 	$hours_per_day = $plans['hours_per_day'];
	// }
	$charges_per_hour = $_POST['charges_per_hour'];
	$date_from = $_POST['date_from'];
	// $date_to = $_POST['date_to'];
	$booking_start_date = date("Y-m-d", strtotime($date_from));
	// $booking_end_date = date("Y-m-d", strtotime($date_to));
	if (isset($_POST['slots'])) {
		$slots = $_POST['slots'];
		$mon_slots = $tue_slots = $wed_slots = $thu_slots = $fri_slots = $sat_slots = $sun_slots = 0;
        if(isset($slots['mon'])){
            $mon_slots = count($slots['mon']);
        }
        if(isset($slots['tue'])){
            $tue_slots = count($slots['tue']);
        }
        if(isset($slots['wed'])){
            $wed_slots = count($slots['wed']);
        }
        if(isset($slots['thu'])){
            $thu_slots = count($slots['thu']);
        }
        if(isset($slots['fri'])){
            $fri_slots = count($slots['fri']);
        }
        if(isset($slots['sat'])){
            $sat_slots = count($slots['sat']);
        }
        if(isset($slots['sun'])){
            $sun_slots = count($slots['sun']);
        }
        if ($mon_slots <= $hours_per_day && $tue_slots <= $hours_per_day && $wed_slots <= $hours_per_day && $thu_slots <= $hours_per_day && $fri_slots <= $hours_per_day && $sat_slots <= $hours_per_day && $sun_slots <= $hours_per_day) {
        	echo "0";
        }
        else{
        	echo "2";
        }
	}
	else{
		echo "1";
	}
}
else if($action == "getslots")
{
	$html = '';	
	$space_id = $_POST["space_id"];
	$mon_bookings = $tue_bookings = $wed_bookings = $thu_bookings = $fri_bookings = $sat_bookings = $sun_bookings = [];
	$sql_bookings = "SELECT * FROM space_bookings WHERE space_id = $space_id AND booking_status = 1";
	$res_bookings = $db_connection->getDbHandler()->query($sql_bookings);
	if($res_bookings)
    {
		$space_bookings = $res_bookings->fetchAll();
		foreach ($space_bookings as $key => $booking) 
		{
			if ($booking['mon_slots']!='') {
				array_push($mon_bookings,$booking['mon_slots']);
			}
			if ($booking['tue_slots']!='') {
				array_push($tue_bookings,$booking['tue_slots']);
			}
			if ($booking['wed_slots']!='') {
				array_push($wed_bookings,$booking['wed_slots']);
			}
			if ($booking['thu_slots']!='') {
				array_push($thu_bookings,$booking['thu_slots']);
			}
			if ($booking['fri_slots']!='') {
				array_push($fri_bookings,$booking['fri_slots']);
			}
			if ($booking['sat_slots']!='') {
				array_push($sat_bookings,$booking['sat_slots']);
			}
			if ($booking['sun_slots']!='') {
				array_push($sun_bookings,$booking['sun_slots']);
			}
		}
    }
	$plan_id = $_POST["plan_id"];
	$sql_plans = "SELECT * FROM p2_plans WHERE id=$plan_id AND status=1";
	$res_plans = $db_connection->getDbHandler()->query($sql_plans);
	if($res_plans)
	{
		$plans = $res_plans->fetch();

		if($plans['mon_slots'] != ""){
		$html .= '<div class="row">
			<div class="full-input p-2 col-xl col-lg me-2 mb-3">
				<label class="form-label text-grey ft-14 mb-0">Monday</label><br/>';
				$mon_slots = $plans['mon_slots'];
				if($plans['mon_slots'] != ""){
					$mon_arr = explode (",", $mon_slots);
					foreach ($mon_arr as $key => $mon) {

						date_default_timezone_set("Asia/Calcutta");
						$splitArr = explode('-', $mon);
						if(is_numeric($splitArr[0])){
							$from = $splitArr[0].':00' ?? 0;
							$displayFromTime 	=  date('h:i A',strtotime($from)); 
						} else {
							$from = $splitArr[0] ?? 0;
							$displayFromTime 	=  date('h:i A',strtotime($from)); 
						}

						if(is_numeric($splitArr[1])){
							$to = $splitArr[1].':00' ?? 0;
							$displayToTime 		=  date('h:i A',strtotime($to)); 
						} else {
							$to = $splitArr[1] ?? 0;
							$displayToTime 		=  date('h:i A',strtotime($to)); 
						}


						
						$html .= '<div class="ck-button">
							<label>';
								if (in_array($mon, $mon_bookings)){
									$html .= '<span class="bslot bslot_no slot-disabled">'.$displayFromTime .'-'. $displayToTime.'</span>';
								}
								else{
									$html .= '<input name="slots[mon]['.$key.']" type="checkbox" value="'.$mon.'"><span class="bslot bslot_yes">'.$displayFromTime .'-'. $displayToTime.'</span>';
								}
							$html .= '</label>
						</div> ';
					}
				}
				else{
					$html .= '<p class="text-center">No Slots</p>';
				}
				$html .= '
			</div>
		</div>';
		}

		if($plans['tue_slots'] != ""){
		$html .= '<div class="row">
			<div class="full-input p-2 col-xl col-lg me-2 mb-3">
				<label class="form-label text-grey ft-14 mb-0">Tuesday</label><br/>';
				$tue_slots = $plans['tue_slots'];
				if($plans['tue_slots'] != ""){
					
					$tue_arr = explode (",", $tue_slots);
					foreach ($tue_arr as $key => $tue) {

						date_default_timezone_set("Asia/Calcutta");
						$splitArr = explode('-', $tue);
						if(is_numeric($splitArr[0])){
							$from = $splitArr[0].':00' ?? 0;
							$displayFromTime 	=  date('h:i A',strtotime($from)); 
						} else {
							$from = $splitArr[0] ?? 0;
							$displayFromTime 	=  date('h:i A',strtotime($from)); 
						}

						if(is_numeric($splitArr[1])){
							$to = $splitArr[1].':00' ?? 0;
							$displayToTime 		=  date('h:i A',strtotime($to)); 
						} else {
							$to = $splitArr[1] ?? 0;
							$displayToTime 		=  date('h:i A',strtotime($to)); 
						}

						$html .= '<div class="ck-button">
							<label>';
								if (in_array($tue, $tue_bookings)){
									$html .= '<span class="bslot bslot_no slot-disabled">'.$displayFromTime .'-'. $displayToTime.'</span>';
								}
								else{
									$html .= '<input name="slots[tue]['.$key.']" type="checkbox" value="'.$tue.'"><span class="bslot bslot_yes">'.$displayFromTime .'-'. $displayToTime.'</span>';
								}
							$html .= '</label>
						</div> ';
					}
				}
				else{
					$html .= '<p class="text-center">No Slots</p>';
				}
				$html .= '
			</div>
		</div>';
		}
		if($plans['wed_slots'] != ""){	
		$html .= '<div class="row">
			<div class="full-input p-2 col-xl col-lg me-2 mb-3">
				<label class="form-label text-grey ft-14 mb-0">Wednesday</label><br/>';
				$wed_slots = $plans['wed_slots'];
				if($plans['wed_slots'] != ""){
					$wed_arr = explode (",", $wed_slots);
					foreach ($wed_arr as $key => $wed) {

						date_default_timezone_set("Asia/Calcutta");
						$splitArr = explode('-', $wed);
						if(is_numeric($splitArr[0])){
							$from = $splitArr[0].':00' ?? 0;
							$displayFromTime 	=  date('h:i A',strtotime($from)); 
						} else {
							$from = $splitArr[0] ?? 0;
							$displayFromTime 	=  date('h:i A',strtotime($from)); 
						}

						if(is_numeric($splitArr[1])){
							$to = $splitArr[1].':00' ?? 0;
							$displayToTime 		=  date('h:i A',strtotime($to)); 
						} else {
							$to = $splitArr[1] ?? 0;
							$displayToTime 		=  date('h:i A',strtotime($to)); 
						}

						$html .= '<div class="ck-button">
							<label>';
								if (in_array($wed, $wed_bookings)){
									$html .= '<span class="bslot bslot_no slot-disabled">'.$displayFromTime .'-'. $displayToTime.'</span>';
								}
								else{
									$html .= '<input name="slots[wed]['.$key.']" type="checkbox" value="'.$wed.'"><span class="bslot bslot_yes">'.$displayFromTime .'-'. $displayToTime.'</span>';
								}
							$html .= '</label>
						</div> ';
					}
				}
				else{
					$html .= '<p class="text-center">No Slots</p>';
				}
				$html .= '
			</div>
		</div>';
	 }			
	 if($plans['thu_slots'] != ""){
		$html .= '<div class="row">
			<div class="full-input p-2 col-xl col-lg me-2 mb-3">
				<label class="form-label text-grey ft-14 mb-0">Thursday</label><br/>';
				$thu_slots = $plans['thu_slots'];
				if($plans['thu_slots'] != ""){
					$thu_arr = explode (",", $thu_slots);
					foreach ($thu_arr as $key => $thu) {

						date_default_timezone_set("Asia/Calcutta");
						$splitArr = explode('-', $thu);
						if(is_numeric($splitArr[0])){
							$from = $splitArr[0].':00' ?? 0;
							$displayFromTime 	=  date('h:i A',strtotime($from)); 
						} else {
							$from = $splitArr[0] ?? 0;
							$displayFromTime 	=  date('h:i A',strtotime($from)); 
						}

						if(is_numeric($splitArr[1])){
							$to = $splitArr[1].':00' ?? 0;
							$displayToTime 		=  date('h:i A',strtotime($to)); 
						} else {
							$to = $splitArr[1] ?? 0;
							$displayToTime 		=  date('h:i A',strtotime($to)); 
						}

						$html .= '<div class="ck-button">
							<label>';
								if (in_array($thu, $thu_bookings)){
									$html .= '<span class="bslot bslot_no slot-disabled">'.$displayFromTime .'-'. $displayToTime.'</span>';
								}
								else{
									$html .= '<input name="slots[thu]['.$key.']" type="checkbox" value="'.$thu.'"><span class="bslot bslot_yes">'.$displayFromTime .'-'. $displayToTime.'</span>';
								}
							$html .= '</label>
						</div> ';
					}
				}
				else{
					$html .= '<p class="text-center">No Slots</p>';
				}
				$html .= '
			</div>
		</div>';
		}
		if($plans['fri_slots'] != ""){
		$html .= '<div class="row">
			<div class="full-input p-2 col-xl col-lg me-2 mb-3">
				<label class="form-label text-grey ft-14 mb-0">Friday</label><br/>';
				$fri_slots = $plans['fri_slots'];
				if($plans['fri_slots'] != ""){
					$fri_arr = explode (",", $fri_slots);
					foreach ($fri_arr as $key => $fri) {

						date_default_timezone_set("Asia/Calcutta");
						$splitArr = explode('-', $fri);
						if(is_numeric($splitArr[0])){
							$from = $splitArr[0].':00' ?? 0;
							$displayFromTime 	=  date('h:i A',strtotime($from)); 
						} else {
							$from = $splitArr[0] ?? 0;
							$displayFromTime 	=  date('h:i A',strtotime($from)); 
						}

						if(is_numeric($splitArr[1])){
							$to = $splitArr[1].':00' ?? 0;
							$displayToTime 		=  date('h:i A',strtotime($to)); 
						} else {
							$to = $splitArr[1] ?? 0;
							$displayToTime 		=  date('h:i A',strtotime($to)); 
						}

						$html .= '<div class="ck-button">
							<label>';
								if (in_array($fri, $fri_bookings)){
									$html .= '<span class="bslot bslot_no slot-disabled">'.$displayFromTime .'-'. $displayToTime.'</span>';
								}
								else{
									$html .= '<input name="slots[fri]['.$key.']" type="checkbox" value="'.$fri.'"><span class="bslot bslot_yes">'.$displayFromTime .'-'. $displayToTime.'</span>';
								}
							$html .= '</label>
						</div> ';
					}
				}
				else{
					$html .= '<p class="text-center">No Slots</p>';
				}
				$html .= '
			</div>
		</div>';
		}
		if($plans['sat_slots'] != ""){
		$html .= '<div class="row">
			<div class="full-input p-2 col-xl col-lg me-2 mb-3">
				<label class="form-label text-grey ft-14 mb-0">Saturday</label><br/>';
				$sat_slots = $plans['sat_slots'];
				if($plans['sat_slots'] != ""){
					$sat_arr = explode (",", $sat_slots);
					foreach ($sat_arr as $key => $sat) {

						date_default_timezone_set("Asia/Calcutta");
						$splitArr = explode('-', $sat);
						if(is_numeric($splitArr[0])){
							$satfrom = $splitArr[0].':00' ?? 0;
							$displaysatFromTime 	=  date('h:i A',strtotime($satfrom)); 
							
						} else {
							$satfrom = $splitArr[0] ?? 0;
							$displaysatFromTime 	=  date('h:i A',strtotime($satfrom));
						}
						

						if(is_numeric($splitArr[1])){
							$satto = $splitArr[1].':00' ?? 0;
							$displaysatToTime 		=  date('h:i A',strtotime($satto));
						} else {
							$satto = $splitArr[1] ?? 0;
							$displaysatToTime 		=  date('h:i A',strtotime($satto)); 
						}
						
						$html .= '<div class="ck-button">
						
							<label>';
								if (in_array($sat, $sat_bookings)){
									$html .= '<span class="bslot bslot_no slot-disabled">'.$displaysatFromTime.'-'.$displaysatToTime.'</span>';
								}
								else{
									$html .= '<input name="slots[sat]['.$key.']" type="checkbox" value="'.$sat.'"><span class="bslot bslot_yes">'.$displaysatFromTime.'-'.$displaysatToTime.'</span>';
								}
							$html .= '</label>
						</div> ';
					}
				}
				else{
					$html .= '<p class="text-center">No Slots</p>';
				}
				$html .= '
			</div>
		</div>';
		}

		if($plans['sun_slots'] != ""){
		$html .= '<div class="row">
			<div class="full-input p-2 col-xl col-lg me-2 mb-3">
				<label class="form-label text-grey ft-14 mb-0">Sunday</label><br/>';
				$sun_slots = $plans['sun_slots'];
				if($plans['sun_slots'] != ""){
					$sun_arr = explode (",", $sun_slots);
					foreach ($sun_arr as $key => $sun) {

						date_default_timezone_set("Asia/Calcutta");
						$splitArr = explode('-', $sun);
						if(is_numeric($splitArr[0])){
							$from = $splitArr[0].':00' ?? 0;
							$displayFromTime 	=  date('h:i A',strtotime($from)); 
						} else {
							$from = $splitArr[0] ?? 0;
							$displayFromTime 	=  date('h:i A',strtotime($from)); 
						}

						if(is_numeric($splitArr[1])){
							$to = $splitArr[1].':00' ?? 0;
							$displayToTime 		=  date('h:i A',strtotime($to)); 
						} else {
							$to = $splitArr[1] ?? 0;
							$displayToTime 		=  date('h:i A',strtotime($to)); 
						}

						$html .= '<div class="ck-button">
							<label>';
								if (in_array($sun, $sun_bookings)){
									$html .= '<span class="bslot bslot_no slot-disabled">'.$displayFromTime .'-'. $displayToTime.'</span>';
								}
								else{
									$html .= '<input name="slots[sun]['.$key.']" type="checkbox" value="'.$sun.'"><span class="bslot bslot_yes">'.$displayFromTime .'-'. $displayToTime.'</span>';
								}
							$html .= '</label>
						</div> ';
					}
				}
				else{
					$html .= '<p class="text-center">No Slots</p>';
				}
				$html .= '
			</div>
		</div>';
		}
	}
	else{
		$html .= '';
	}
	echo $html;
}
?>