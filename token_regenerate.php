<?php
session_start();
date_default_timezone_set("Asia/Calcutta");
$title = "Regenrate Token";
$description = "";
$keywords = "";
$page = 1;
if (!isset($_POST['booking_no']))
{
    header("Location: login");
}

require_once('src/Classes/Model/Database.php');
require('payments/config.php');
require_once('src/mail/sendmail.php');
include("vendor/agora/api/src/RtcTokenBuilder.php");

use App\Classes\Model\Database;
$db_connection = new Database;

if(isset($_POST['booking_no']) && isset($_POST['time_duration']))
{
    $time_duration      = $_POST['time_duration'];
    $booking_no         = $_POST['booking_no'];
    
    $token              = $agora_channel_name = null;
    
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

    $sql_update = "UPDATE `booking_details` set  `audio_video_token` = :token, `agora_channel_name` = :channel where booking_no = :bookingno";

    $booking = $db_connection->getDbHandler()->prepare($sql_update);
    $booking->bindParam(':token', $token);
    $booking->bindParam(':channel', $agora_channel_name);
    $booking->bindParam(':bookingno', $booking_no);

    if($booking->execute()){
        echo json_encode(array(
                'msg'=>"Token Successfully Regenerated",
                'icon'=>'success',
                'title'=> 'Token Regenerated'
        ));
    } else{
        echo json_encode(array(
			'msg'=>"",
			'icon'=>'error',
			'title'=> 'Token Error'
		));
    }

    // echo 'token = '.$token.'  agora_channel_name = '.$agora_channel_name; exit;
}
?>