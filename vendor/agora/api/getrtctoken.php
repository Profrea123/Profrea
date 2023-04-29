<?php
include("src/RtcTokenBuilder.php");

header("Access-Control-Allow-Origin: *");

header("Access-Control-Allow-Headers: X-Requested-With");
// 006779ebab5c08a4d7bbc54fb2f0920cff3IAAaSfy0LBmo4nHjPYFXmh55qtztuY+9UuChRyweoyf0EpyXhooAAAAAEADR1hyrkOVGYgEAAQCP5UZi
$url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$respArray = [];
$query = parse_url($url, PHP_URL_QUERY);
$queryArray = explode("&", $query);
$respArray = [];
$paramCount = count($queryArray);
if ($paramCount != 3) {
    $respArray['message'] = 'Count of parameters incorrect, provided ' .
        $paramCount . ', expected 3';
    $respArray['status'] = false;
    print_r(json_encode($respArray));
    return;
}
for ($i = 0; $i < count($queryArray); $i++) {
    $key = explode("=", $queryArray[$i])[0];
    $value = explode("=", $queryArray[$i])[1];

    switch ($key) {
        case "channel":
            $channelName = $value;
            break;
        case "duration":
            $duration = intval($value);
            break;
        case "appid":
            $appIdParam = $value;
            break;
        default:
            $respArray['message'] = 'Invalid Parameter Key=' . $key . ', Value=' . $value;
            $respArray['status'] = false;
            print_r(json_encode($respArray));
            return;
    }
}
$uidStr = "0"; // No need to authenticate the user

// $appId = '8f2a3971274449f281ddc9cb25eabc2a';
$appId = "b0f2efac08d548239012af03cd1f5730";

if (strcmp($appId, $appIdParam) != 0) {
    $respArray['message'] = 'Invalid App Id';
    $respArray['status'] = false;
    print_r(json_encode($respArray));
    return;
}


//$appCertificate = "dd637f03dc114ae1a0003fc752a1244b";
$appCertificate = "94037d1f508c4ba0ab584d4ef93dec68";
$role = RtcTokenBuilder::RolePublisher;
 $currentTimestamp = date("Y-m-d H:i:s");

// $privilegeExpiredTs =  $currentTimestamp $duration;
 //$currentTimestamp->add(new DateInterval('PT' . $duration . 'S'));
// $privilegeExpiredTs = date_create_from_format('dmYhi', $expiryTime);

// $privilegeExpiredTs = date_create_from_format('dmYhi', '110420222230');
// privilegeExpiredTs = (time() /1000) +  $duration;

$privilegeExpiredTs = time() + $duration; 


// if ($privilegeExpiredTs < Date.now()) {
//     echo("Expired: 0" . $privilegeExpiredTs);
//     $respArray['message'] = 'Expiry Time in past';
//     $respArray['status'] = false;
//     print_r(json_encode($respArray));
//     return;
// }
$token = RtcTokenBuilder::buildTokenWithUserAccount($appId, $appCertificate, $channelName, $uidStr, $role, $privilegeExpiredTs);
// $token = htmlspecialchars($token);
$respArray['status'] = true;
$respArray['message'] = 'Success';
$respArray['token'] = $token;
print_r(json_encode($respArray));
