<?php
session_start();
date_default_timezone_set("Asia/Calcutta");

require_once('src/Classes/Model/Database.php');
require_once('src/mail/sendmail.php');

use App\Classes\Model\Database;
$db_connection = new Database;

$booking_date    = '2022-07-03';
$current_time    = date('h:i A');
$sql_user        = $db_connection->getDbHandler()->query("SELECT * FROM booking_details WHERE (booking_status='0' AND booking_date='$booking_date')");
$result_user     = $sql_user->fetchAll();

if ($result_user !='') {
    // echo '<pre>'; print_r($result_user);
    foreach($result_user as $user){
        $booking_time = date('h:i A', strtotime('-10 minutes', strtotime($user['booking_time'])));

        if($current_time < $user['booking_time'] && $current_time >= $booking_time) {
            $booking_date_time = $user['booking_time'].$user['booking_time'];
            $doctor_id = $user['doctor_id'];
            $user_id = $user['user_id'];

            $sql_doctor        = $db_connection->getDbHandler()->query("SELECT * FROM users WHERE (id=$doctor_id) ");
            $result_doctor     = $sql_doctor->fetch();

            $sql_user_data          = $db_connection->getDbHandler()->query("SELECT * FROM users WHERE (id=$user_id) ");
            $result_user_data       = $sql_user_data->fetch();

            $email = $result_doctor['email'];
            $email_user = $result_user_data['email'];
            try {

                // User 
                $email_subject = "Reminder of Booking From Profrea!!!";
                    
                $user_email_message = file_get_contents("template/reminder.html");
                $user_email_message = str_replace("@@name@@",$result_user_data['name'],$user_email_message);
                $user_email_message = str_replace("@@razorpay_payment_id@@",$user['payment_id'],$user_email_message);
                $user_email_message = str_replace("@@date_time@@",$booking_date_time,$user_email_message);
                $user_email_message = str_replace("@@doctor_name@@",'Dr'.$result_doctor['name'],$user_email_message);

                $result = sendMail( $email_subject,$user_email_message, $email_user);
                
                 // Doctor
                $email_subject = "Reminder of Booking From Profrea!!!";

                $doctor_email_messages = file_get_contents("template/reminder.html");
                $doctor_email_messages = str_replace("@@name@@",'Dr. '.$result_doctor['name'],$doctor_email_messages);
                $doctor_email_messages = str_replace("@@razorpay_payment_id@@",$user['payment_id'],$doctor_email_messages);
                $doctor_email_messages = str_replace("@@date_time@@",$booking_date_time,$doctor_email_messages);
                $doctor_email_messages = str_replace("@@doctor_name@@",$result_user_data['name'],$doctor_email_messages);
                echo $doctor_email_messages; die;
                $result = sendMail( $email_subject,$doctor_email_messages, $email);

            } catch(Exception $e){
                // echo $e;
            }
        }
        
    }
}
