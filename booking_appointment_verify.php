<?php
session_start();
date_default_timezone_set("Asia/Calcutta");
$title = "Appointment Summary";
$description = "";
$keywords = "";
$page = 1;
if (!isset($_POST['razorpay_payment_id']))
{
    header("Location: doctor-consult");
}

require_once('src/Classes/Model/Database.php');
require('payments/config.php');
require('payments/razorpay/Razorpay.php');
require_once('src/mail/sendmail.php');
include("vendor/agora/api/src/RtcTokenBuilder.php");

use App\Classes\Model\Database;
$db_connection = new Database;
use Razorpay\Api\Api;
use Razorpay\Api\Errors\SignatureVerificationError;

$clinic_name            = "Profrea Smart Clinic";
$clinic_address         = "";
$clinic_location        = "";
$profrea_admin_mobile   = "9643555592";
$website_url            = "https://www.profrea.com";
$video_call_link        = "https://www.profrea.com";
$invoice_url            = "https://www.profrea.com";
if(isset($_POST['payment_mode']) && $_POST['payment_mode'] == 'cash')
{
    function generateRandomString($length = 20) {
        return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
    }

    try
    {
        $success = true;
        $payment_id         = generateRandomString();
        $doctor_id          = $_SESSION['cash_data']['doctor_id'] ?? '';
        $name               = $_SESSION['cash_data']['name'] ?? '';
        $email              = $_SESSION['cash_data']['email'] ?? '';
        $mobile             = $_SESSION['cash_data']['mobile'] ?? '';
        $gender             = $_SESSION['cash_data']['gender'] ?? '';
        $booking_no         = $_SESSION['cash_data']['booking_no'] ?? '';
        $booking_date       = $_SESSION['cash_data']['booking_date'] ?? '';
        $booking_date       = $booking_date ? date('Y-m-d', strtotime($booking_date)) : '';
        $booking_time       = $_SESSION['cash_data']['booking_time'] ?? '';
        $time_duration      = $_SESSION['cash_data']['time_duration'] ?? '';
        $transaction_date   = date('Y-m-d H:i:s');
        $amount             = $_SESSION['cash_data']['amount'] ?? 0;
        $transaction_charge = $_SESSION['cash_data']['transaction_charge'] ?? 0;
        $service_charge     = 0;
        $sub_total          = $_SESSION['cash_data']['sub_total'] ?? $amount;
        $tax_amount         = $_SESSION['cash_data']['tax_amount'] ?? 0;
        $tax_percentage     = $_SESSION['cash_data']['tax_percentage'] ?? 0;
        $discount_amount    = $_SESSION['cash_data']['discount_amount'] ?? 0;
        $payment_mode       = $_POST['payment_mode'];
        $booking_type       = $_SESSION['cash_data']['booking_type'] ?? '';
        $visiting_reason    = $_SESSION['cash_data']['visiting_reason'] ?? '';
        $booking_for        = $_SESSION['cash_data']['booking_for'] ?? '';
        $token              = $agora_channel_name = null;
       
        $family_member      = null;
        if(isset($_POST['family_member']) && $_POST['family_member'] != '' ){
            $family_member      = $_POST['family_member'] ?? '';
        }
        
        $booking_status     = 0;
        $payment_status     = 0;
        
        if(isset($_POST['user_id']) && $_POST['user_id'] != '') {
            $sql_user   = $db_connection->getDbHandler()->query("SELECT * FROM users WHERE id=".$_POST['user_id']);
        } else {
            $sql_user   = $db_connection->getDbHandler()->query("SELECT * FROM users WHERE (email='$email' OR mobileNo='$mobile')");
        }
        $result_user     = $sql_user->fetch();
        if ($result_user !='') {
            $user_id = $result_user['id'];
            $_SESSION['ap_profrea_login_id'] = $result_user['id'];
        } else {
            $profession = 5;
            
            $sql_user_insert = $db_connection->getDbHandler()->prepare("INSERT INTO users (name,profession_id,first_name,gender_id,email,mobileNo,rowstate,is_verified) VALUES('$name','$profession','$name','$gender','$email','$mobile',1,1)");
            $sql_user_insert->execute();
            $user_id = $db_connection->lastInsertId();
            $_SESSION['ap_profrea_login_id'] = $user_id;
        }

        $qry_transactions = "INSERT INTO `booking_details` (`payment_id`,`doctor_id`,`user_id`,`booking_no`,`booking_date`,`booking_time`,`time_duration`,`transaction_date`,`amount`,`transaction_charge`,`service_charge`,`sub_total`,`tax_amount`,`tax_percentage`,`discount_amount`,`payment_mode`,`booking_type`,`booking_status`,`payment_status`,`visiting_reason`,`booking_for`,`family_member_id`,`audio_video_token`,`agora_channel_name`) VALUES(:payment_id,:doctor_id,:user_id,:booking_no,:booking_date,:booking_time,:time_duration,:transaction_date,:amount,:transaction_charge,:service_charge,:sub_total,:tax_amount,:tax_percentage,:discount_amount,:payment_mode,:booking_type,:booking_status,:payment_status,:visiting_reason,:booking_for,:family_member,:audio_video_token,:agora_channel_name)";
        $stmt_transactions = $db_connection->getDbHandler()->prepare($qry_transactions);
        $stmt_transactions->bindParam(':payment_id', $payment_id);
        $stmt_transactions->bindParam(':doctor_id', $doctor_id);
        $stmt_transactions->bindParam(':user_id', $user_id);
        $stmt_transactions->bindParam(':booking_no', $booking_no);
        $stmt_transactions->bindParam(':booking_date', $booking_date);
        $stmt_transactions->bindParam(':booking_time', $booking_time);
        $stmt_transactions->bindParam(':time_duration', $time_duration);
        $stmt_transactions->bindParam(':transaction_date', $transaction_date);
        $stmt_transactions->bindParam(':amount', $amount);
        $stmt_transactions->bindParam(':transaction_charge', $transaction_charge);
        $stmt_transactions->bindParam(':service_charge', $service_charge);
        $stmt_transactions->bindParam(':sub_total', $sub_total);
        $stmt_transactions->bindParam(':tax_amount', $tax_amount);
        $stmt_transactions->bindParam(':tax_percentage', $tax_percentage);
        $stmt_transactions->bindParam(':discount_amount', $discount_amount);
        $stmt_transactions->bindParam(':payment_mode', $payment_mode);
        $stmt_transactions->bindParam(':booking_type', $booking_type);
        $stmt_transactions->bindParam(':booking_status', $booking_status);
        $stmt_transactions->bindParam(':payment_status', $payment_status);
        $stmt_transactions->bindParam(':visiting_reason', $visiting_reason);
        $stmt_transactions->bindParam(':booking_for', $booking_for);
        $stmt_transactions->bindParam(':family_member', $family_member);
        $stmt_transactions->bindParam(':audio_video_token', $token);
        $stmt_transactions->bindParam(':agora_channel_name', $agora_channel_name);
        $stmt_transactions->execute();

        $_SESSION['booking_payment_reference_id'] = $payment_id;
        $booking_date_time  = $booking_date .' '. $booking_time;
        $sql_doctor         = $db_connection->getDbHandler()->query("SELECT name,email,mobileNo FROM users WHERE id='$doctor_id'");
        $result_doctor      = $sql_doctor->fetch();
        $sql_inserted_user  = $db_connection->getDbHandler()->query("SELECT name,email,mobileNo FROM users WHERE id='$user_id'");
        $result_user_data   = $sql_inserted_user->fetch();

        try {
            if ($email !='') {
                $email_subject = "Confirmation of Booking From Profrea!!!";
                    
                $user_email_message = file_get_contents("template/slot-appointment-user.html");
                $user_email_message = str_replace("@@name@@",$name,$user_email_message);
                $user_email_message = str_replace("@@razorpay_payment_id@@",$payment_id,$user_email_message);
                $user_email_message = str_replace("@@date_time@@",date('d-M-y, g:i A', strtotime($booking_date_time)),$user_email_message);
                $user_email_message = str_replace("@@doctor_name@@",$result_doctor['name'],$user_email_message);

                $result = sendMail( $email_subject,$user_email_message, $email);
            }

            if ($mobile !='') {
                if($booking_type == 3){
                    // In-Clinic Booking Confirmation
                    $message    = "Dear ".$result_user_data['name'].", your In-clinic appointment with Dr ".$result_doctor['name']." is scheduled for ".date('d-M-y', strtotime($booking_date)).", ".date('g:i', strtotime($booking_time)).", ".date('A', strtotime($booking_time))." at ".$clinic_name.". Call ".$profrea_admin_mobile." for any enquiry - Profrea";
                    $mobileNos  = $mobile;
                    
                    $url = "https://sms.nettyfish.com/api/v2/SendSMS?SenderId=PRFREA&Message=".urlencode($message)."&MobileNumbers=".$mobileNos."&ApiKey=pNIg7phvNboA+wW5Q4gDgYTOYOK3q4/gRTSud7uoGTI=&ClientId=bea0553d-0c7f-481f-a8af-f65db8a5b395";

                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL,$url);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET"); 
                    
                    $output = curl_exec($ch);
                    curl_close($ch);

                    // In-Clinic Payment Mode
                    $message    = "Hi ".$result_user_data['name'].", to confirm your In-clinic appointment with Dr ".$result_doctor['name']." on ".date('d-M-y', strtotime($booking_date)).", ".date('g:i A', strtotime($booking_time))."  please pay on pay via cash in-clinic . Ignore if already paid. - Profrea";
                    $mobileNos  = $mobile;
                    
                    $url = "https://sms.nettyfish.com/api/v2/SendSMS?SenderId=PRFREA&Message=".urlencode($message)."&MobileNumbers=".$mobileNos."&ApiKey=pNIg7phvNboA+wW5Q4gDgYTOYOK3q4/gRTSud7uoGTI=&ClientId=bea0553d-0c7f-481f-a8af-f65db8a5b395";

                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL,$url);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET"); 
                    
                    $output = curl_exec($ch);
                    curl_close($ch);

                }

                if($booking_type == 2){
                    // Video Payment Mode Cash
                    $message    = "Hi ".$result_user_data['name'].", to confirm your Video appointment with Dr ".$result_doctor['name']." on ".date('d-M-y', strtotime($booking_date)).", ".date('g:i A', strtotime($booking_time))." please pay on ".$sub_total." . Ignore if already paid. - Profrea";
                    $mobileNos  = $mobile;
                    
                    $url = "https://sms.nettyfish.com/api/v2/SendSMS?SenderId=PRFREA&Message=".urlencode($message)."&MobileNumbers=".$mobileNos."&ApiKey=pNIg7phvNboA+wW5Q4gDgYTOYOK3q4/gRTSud7uoGTI=&ClientId=bea0553d-0c7f-481f-a8af-f65db8a5b395";

                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL,$url);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET"); 
                    
                    $output = curl_exec($ch);
                    curl_close($ch);
                }

                if($booking_type == 1){
                    // Audio Payment Mode Cash
                    $message    = "Hi ".$result_user_data['name'].", to confirm your Video appointment with Dr ".$result_doctor['name']." on ".date('d-M-y', strtotime($booking_date)).", ".date('g:i A', strtotime($booking_time))." please pay on ".$sub_total." . Ignore if already paid. - Profrea";
                    $mobileNos  = $mobile;
                    
                    $url = "https://sms.nettyfish.com/api/v2/SendSMS?SenderId=PRFREA&Message=".urlencode($message)."&MobileNumbers=".$mobileNos."&ApiKey=pNIg7phvNboA+wW5Q4gDgYTOYOK3q4/gRTSud7uoGTI=&ClientId=bea0553d-0c7f-481f-a8af-f65db8a5b395";

                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL,$url);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET"); 
                    
                    $output = curl_exec($ch);
                    curl_close($ch);
                }
            }
        } catch (\Throwable $th) {
            
        }
        try {
            if ($result_doctor !='') {
                if ($result_doctor['email']) {
                    $email_subject = "Confirmation of Booking From Profrea!!!";
                    
                    $doctor_email_message = file_get_contents("template/slot-appointment-doctor.html");
                    $doctor_email_message = str_replace("@@doctor_name@@",$result_doctor['name'],$doctor_email_message);
                    $doctor_email_message = str_replace("@@razorpay_payment_id@@",$payment_id,$doctor_email_message);
                    $doctor_email_message = str_replace("@@date_time@@",date('d-M-y, g:i A', strtotime($booking_date_time)),$doctor_email_message);
                    $doctor_email_message = str_replace("@@user_name@@",$name,$doctor_email_message);

                    $result = sendMail( $email_subject,$doctor_email_message, $result_doctor['email']);
                }

                if($result_doctor['mobileNo']) {
                    $message    = $mobile_otp." is your Profrea OTP. Do not share it with anyone.";
                    $mobileNos  = $result_doctor['mobileNo'];
                    
                    $url = "https://sms.nettyfish.com/api/v2/SendSMS?SenderId=PRFREA&Message=".urlencode($message)."&MobileNumbers=".$mobileNos."&ApiKey=pNIg7phvNboA+wW5Q4gDgYTOYOK3q4/gRTSud7uoGTI=&ClientId=bea0553d-0c7f-481f-a8af-f65db8a5b395";

                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL,$url);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET"); 
                    
                    $output = curl_exec($ch);
                    curl_close($ch);
                }
            }
        } catch (\Throwable $th) {
            
        }
    }
    catch(SignatureVerificationError $e)
    {
        $success = false;
        $payment_status     = 0;
        $_SESSION['booking_payment_failure'] = $e->getMessage();
    }
} else {
    $api                    = new Api($keyId, $keySecret);
    $razorpay_order_id      = $_POST['razorpay_order_id'];
    $razorpay_payment_id    = $_POST['razorpay_payment_id'];
    $razorpay_signature     = $_POST['razorpay_signature'];
    try
    {
        $attributes = array(
            'razorpay_order_id' => $razorpay_order_id,
            'razorpay_payment_id' => $razorpay_payment_id,
            'razorpay_signature' => $razorpay_signature
        );
        $api->utility->verifyPaymentSignature($attributes);
        $payment    = $api->payment->fetch($razorpay_payment_id);
        $success = true;
        $doctor_id          = $_POST['doctor_id'] ?? $payment['notes']['doctor_id'];
        $name               = $payment['notes']['name'];
        $email              = $payment['notes']['email'];
        $mobile             = $payment['notes']['mobile'];
        $gender             = $payment['notes']['gender'];
        $booking_no         = $payment['notes']['booking_no'];
        $booking_date       = $payment['notes']['booking_date'] ?? '';
        $booking_date       = $booking_date ? date('Y-m-d', strtotime($booking_date)) : '';
        $booking_time       = $payment['notes']['booking_time'] ?? '';
        $time_duration      = $payment['notes']['time_duration'] ?? '';
        $transaction_date   = date('Y-m-d H:i:s');
        $amount             = $payment['amount']/100 ?? 0;
        $transaction_charge = $payment['notes']['transaction_charge'] ?? 0;
        $service_charge     = 0;
        $sub_total          = $payment['notes']['sub_total'] ?? $amount;
        $tax_amount         = $payment['notes']['tax_amount'] ?? 0;
        $tax_percentage     = $payment['notes']['tax_percentage'] ?? 0;
        $discount_amount    = $payment['notes']['discount_amount'] ?? 0;
        $payment_mode       = $payment['method'];
        $booking_type       = $payment['notes']['booking_type'] ?? '';
        $visiting_reason    = $_POST['visiting_reason'] ?? '';
        $booking_for        = $_POST['booking_for'] ?? '';

        $family_member      = Null;
        if(isset($_POST['family_member']) && $_POST['family_member'] != '' ){
            $family_member      = $_POST['family_member'] ?? '';
        }

        $booking_status     = 0;
        $payment_status     = 0;
        if (isset($payment['captured']) && $payment['captured'] == 1) {
            $payment_status     = 1;
        }

        $token              = $agora_channel_name = null;
        if($booking_type != 3){
            /*** Agora Token Generation */
            $consultingDuration = (int) $time_duration;
            $channelID          = bin2hex(random_bytes(28));
            $agoraAppID         = 'b0f2efac08d548239012af03cd1f5730';
            $duration           = $consultingDuration * 60;

            $channelName        = (string)$channelID;
            $uidStr             = "0"; // No need to authenticate the user
            $appCertificate     = "94037d1f508c4ba0ab584d4ef93dec68";
            $role               = RtcTokenBuilder::RolePublisher;
            // $consultingDateTime = $booking_date .' '. $booking_time;
            $consultingDateTime = date('d-m-Y H:i:s');
            $currentTimestamp   = strtotime(date('d-m-Y H:i:s', strtotime($consultingDateTime)));
            $privilegeExpiredTs = $currentTimestamp + $duration;
            $agora_channel_name = $channelName;

            $token = RtcTokenBuilder::buildTokenWithUserAccount($agoraAppID, $appCertificate, $channelName, $uidStr, $role, $privilegeExpiredTs);
            /****** End */
        }

        if(isset($_POST['user_id']) && $_POST['user_id'] != '') {
            $sql_user   = $db_connection->getDbHandler()->query("SELECT * FROM users WHERE id=".$_POST['user_id']);
        } else {
            $sql_user   = $db_connection->getDbHandler()->query("SELECT * FROM users WHERE (email='$email' OR mobileNo='$mobile')");
        }

        $result_user     = $sql_user->fetch();
        if ($result_user !='') {
            $user_id = $result_user['id'];
            $_SESSION['ap_profrea_login_id'] = $result_user['id'];
        } else {
            $profession = 5;
            
            $sql_user_insert = $db_connection->getDbHandler()->prepare("INSERT INTO users (name,profession_id,first_name,gender_id,email,mobileNo,rowstate,is_verified) VALUES('$name','$profession','$name','$gender','$email','$mobile',1,1)");
            $sql_user_insert->execute();
            $user_id = $db_connection->lastInsertId();
            $_SESSION['ap_profrea_login_id'] = $user_id;
        }

        $qry_transactions = "INSERT INTO `booking_details` (`payment_id`,`doctor_id`,`user_id`,`booking_no`,`booking_date`,`booking_time`,`time_duration`,`transaction_date`,`amount`,`transaction_charge`,`service_charge`,`sub_total`,`tax_amount`,`tax_percentage`,`discount_amount`,`payment_mode`,`booking_type`,`booking_status`,`payment_status`,`visiting_reason`,`booking_for`,`family_member_id`,`audio_video_token`,`agora_channel_name`) VALUES(:payment_id,:doctor_id,:user_id,:booking_no,:booking_date,:booking_time,:time_duration,:transaction_date,:amount,:transaction_charge,:service_charge,:sub_total,:tax_amount,:tax_percentage,:discount_amount,:payment_mode,:booking_type,:booking_status,:payment_status,:visiting_reason,:booking_for,:family_member,:audio_video_token,:agora_channel_name)";
        $stmt_transactions = $db_connection->getDbHandler()->prepare($qry_transactions);
        $stmt_transactions->bindParam(':payment_id', $razorpay_payment_id);
        $stmt_transactions->bindParam(':doctor_id', $doctor_id);
        $stmt_transactions->bindParam(':user_id', $user_id);
        $stmt_transactions->bindParam(':booking_no', $booking_no);
        $stmt_transactions->bindParam(':booking_date', $booking_date);
        $stmt_transactions->bindParam(':booking_time', $booking_time);
        $stmt_transactions->bindParam(':time_duration', $time_duration);
        $stmt_transactions->bindParam(':transaction_date', $transaction_date);
        $stmt_transactions->bindParam(':amount', $amount);
        $stmt_transactions->bindParam(':transaction_charge', $transaction_charge);
        $stmt_transactions->bindParam(':service_charge', $service_charge);
        $stmt_transactions->bindParam(':sub_total', $sub_total);
        $stmt_transactions->bindParam(':tax_amount', $tax_amount);
        $stmt_transactions->bindParam(':tax_percentage', $tax_percentage);
        $stmt_transactions->bindParam(':discount_amount', $discount_amount);
        $stmt_transactions->bindParam(':payment_mode', $payment_mode);
        $stmt_transactions->bindParam(':booking_type', $booking_type);
        $stmt_transactions->bindParam(':booking_status', $booking_status);
        $stmt_transactions->bindParam(':payment_status', $payment_status);
        $stmt_transactions->bindParam(':visiting_reason', $visiting_reason);
        $stmt_transactions->bindParam(':booking_for', $booking_for);
        $stmt_transactions->bindParam(':family_member', $family_member);
        $stmt_transactions->bindParam(':audio_video_token', $token);
        $stmt_transactions->bindParam(':agora_channel_name', $agora_channel_name);
        $stmt_transactions->execute();

        $_SESSION['booking_payment_reference_id'] = $razorpay_payment_id;
        $booking_date_time = $booking_date .' '. $booking_time;
        $sql_doctor        = $db_connection->getDbHandler()->query("SELECT name,email,mobileNo FROM users WHERE id='$doctor_id'");
        $result_doctor     = $sql_doctor->fetch();
        $sql_inserted_user        = $db_connection->getDbHandler()->query("SELECT name,email,mobileNo FROM users WHERE id='$user_id'");
        $result_user_data     = $sql_inserted_user->fetch();


        try {
            if ($email !='') {
                $email_subject = "Confirmation of Booking From Profrea!!!";
                    
                $user_email_message = file_get_contents("template/slot-appointment-user.html");
                $user_email_message = str_replace("@@name@@",$name,$user_email_message);
                $user_email_message = str_replace("@@razorpay_payment_id@@",$razorpay_payment_id,$user_email_message);
                $user_email_message = str_replace("@@date_time@@",date('d-M-y, g:i A', strtotime($booking_date_time)),$user_email_message);
                $user_email_message = str_replace("@@doctor_name@@",$result_doctor['name'],$user_email_message);

                $result = sendMail( $email_subject,$user_email_message, $email);
            }

            if ($mobile !='') {
                if($booking_type == 2){
                    
                    // Video booking confirmation
                    $message    = "Dear ".$result_user_data['name'].", your payment of Rs.".$sub_total." has been received and your VIDEO-consult with Dr ".$result_doctor['name']." is confirmed for ".date('d-M-y', strtotime($booking_date)).", ".date('g:i', strtotime($booking_time)).", ".date('A', strtotime($booking_time)).". Upload previous records on ".$website_url.", and start the video call on ".$video_call_link."- Profrea";
                    $mobileNos  = $mobile;
                    
                    $url = "https://sms.nettyfish.com/api/v2/SendSMS?SenderId=PRFREA&Message=".urlencode($message)."&MobileNumbers=".$mobileNos."&ApiKey=pNIg7phvNboA+wW5Q4gDgYTOYOK3q4/gRTSud7uoGTI=&ClientId=bea0553d-0c7f-481f-a8af-f65db8a5b395";

                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL,$url);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET"); 
                    
                    $output = curl_exec($ch);
                    curl_close($ch);
                }
                if($booking_type == 1){
                    // Audio booking confirmation

                    $message    = "Dear ".$result_user_data['name'].", your payment of Rs.".$sub_total." has been received and your VIDEO-consult with Dr ".$result_doctor['name']." is confirmed for ".date('d-M-y', strtotime($booking_date)).", ".date('g:i', strtotime($booking_time)).", ".date('A', strtotime($booking_time)).". Upload previous records on ".$website_url.", and start the video call on ".$video_call_link."- Profrea";
                    $mobileNos  = $mobile;
                    
                    $url = "https://sms.nettyfish.com/api/v2/SendSMS?SenderId=PRFREA&Message=".urlencode($message)."&MobileNumbers=".$mobileNos."&ApiKey=pNIg7phvNboA+wW5Q4gDgYTOYOK3q4/gRTSud7uoGTI=&ClientId=bea0553d-0c7f-481f-a8af-f65db8a5b395";

                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL,$url);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
                    
                    $output = curl_exec($ch);
                    curl_close($ch);
                }

                $message    = "Dear ".$result_user_data['name'].",Thanks for paying Rs. ".$sub_total." to ".$clinic_name.". Download your invoice here ".$invoice_url." - Profrea";
                $mobileNos  = $mobile;
                
                $url = "https://sms.nettyfish.com/api/v2/SendSMS?SenderId=PRFREA&Message=".urlencode($message)."&MobileNumbers=".$mobileNos."&ApiKey=pNIg7phvNboA+wW5Q4gDgYTOYOK3q4/gRTSud7uoGTI=&ClientId=bea0553d-0c7f-481f-a8af-f65db8a5b395";

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL,$url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET"); 
                
                $output = curl_exec($ch);
                curl_close($ch);
            }
        } catch (\Throwable $th) {
            
        }
        try {
            if ($result_doctor !='') {
                if ($result_doctor['email']) {
                    $email_subject = "Confirmation of Booking From Profrea!!!";
                    
                    $doctor_email_message = file_get_contents("template/slot-appointment-doctor.html");
                    $doctor_email_message = str_replace("@@doctor_name@@",$result_doctor['name'],$doctor_email_message);
                    $doctor_email_message = str_replace("@@razorpay_payment_id@@",$razorpay_payment_id,$doctor_email_message);
                    $doctor_email_message = str_replace("@@date_time@@",date('d-M-y, g:i A', strtotime($booking_date_time)),$doctor_email_message);
                    $doctor_email_message = str_replace("@@user_name@@",$name,$doctor_email_message);

                    $result = sendMail( $email_subject,$doctor_email_message, $result_doctor['email']);
                }

                if($result_doctor['mobileNo']) {
                    
                }
            }
        } catch (\Throwable $th) {
            
        }
    }
    catch(SignatureVerificationError $e)
    {
        $success = false;
        $payment_status     = 0;
        $_SESSION['booking_payment_failure'] = $e->getMessage();
    }
}

if ($success) {
    header("Location: booking-success");
} else {
    header("Location: booking-failure");
}
?>