<?php

error_reporting(0);
// Post Params
require_once('Classes/Model/Database.php');
require_once('util/validate.php');
require_once('util/util.php');
require_once('mail/sendmail.php');
use App\Classes\Model\Database;
use Exception as Exception;
// validation expected data exists
if(!isset($_POST['basic_info_id'])
|| !isset($_POST['first_name'])
|| !isset($_POST['email_Id'])
|| !isset($_POST['space_type'])
|| !isset($_POST['city'])
|| !isset($_POST['locality'])
|| !isset($_POST['landmark'])
|| !isset($_POST['address'])
// || !isset($_POST['security_deposit'])
// || !isset($_POST['setup_rules'])
|| !isset($_POST['setup_description'])
|| !isset($_POST['worksp_name'])
|| !isset($_POST['work_avail'])
|| !isset($_POST['work_desc'])
) {
  died('We are sorry, but there appears to be a problem with the form you submitted.');
}

//echo"<pre>"; print_r($_POST); die;
$basic_info_id = trim( $_POST['basic_info_id'] );
$first_name = trim( $_POST['first_name'] );
$email_Id = trim( $_POST['email_Id'] );
$space_type = trim( $_POST['space_type'] );
$city = trim( $_POST['city'] );
$locality = trim( $_POST['locality'] );
$landmark = trim( $_POST['landmark'] );
$address = trim( $_POST['address'] );
$security_deposit = trim( $_POST['security_deposit'] );
$setup_rules = trim( $_POST['setup_rules'] );
$setup_desc = trim( $_POST['setup_description'] );
$operating_specialty = isset($_POST['operating_specialty']) ? ( $_POST['operating_specialty'] ) : array();
$utility = isset($_POST['utility']) ? ( $_POST['utility'] ) : array();
$paid_utilities = isset($_POST['paid_utilities']) ? ( $_POST['paid_utilities'] ) : array();
$amenities = isset($_POST['amenities']) ? ( $_POST['amenities'] ) : array();
$map_location = trim( $_POST['map_loc'] );
$map_cordinates = trim( $_POST['map_loc1'] );
$ws_name = $_POST['worksp_name'] ;
$ws_count = count($ws_name);
$ws_available_from = $_POST['work_avail'] ;
$ws_hourly_charges = $_POST['work_charge'];
$ws_desc = $_POST['work_desc'] ;
if(isset($_POST['work_cap'])){
  $ws_capacity = isset($_POST['work_cap']) ? ( $_POST['work_cap'] ) : array();
}
else{
  $ws_capacity = $_POST['work_charge'] ?? array();  
}
$ws_offered_slots_mon = isset($_POST['work_mon'] ) ? ( $_POST['work_mon'] ) : array();  
$ws_offered_slots_tue = isset($_POST['work_tue'] ) ? ( $_POST['work_tue'] ) : array();  
$ws_offered_slots_wed = isset($_POST['work_wed'] ) ? ( $_POST['work_wed'] ) : array();  
$ws_offered_slots_thu = isset($_POST['work_thu'] ) ? ( $_POST['work_thu'] ) : array();  
$ws_offered_slots_fri = isset($_POST['work_fri'] ) ? ( $_POST['work_fri'] ) : array();  
$ws_offered_slots_sat = isset($_POST['work_sat'] ) ? ( $_POST['work_sat'] ) : array();  
$ws_offered_slots_sun = isset($_POST['work_sun'] ) ? ( $_POST['work_sun'] ) : array();  
foreach ($operating_specialty as $key =>  $value) {
  $operating_specialty[$key] = trim( $value);
}
foreach ($utility as $key =>  $value) {
  $utility[$key] = trim( $value);
}
foreach ($paid_utilities as $key =>  $value) {
  $paid_utilities[$key] = trim( $value);
}
foreach ($amenities as $key =>  $value) {
  $amenities[$key] = trim( $value);
}
foreach ($ws_name as $key =>  $value) {
  $ws_name[$key] = trim( $value);
}
foreach ($ws_available_from as $key =>  $value) {
  $ws_available_from[$key] = trim( $value);
}
foreach ($ws_hourly_charges as $key =>  $value) {
  $ws_hourly_charges[$key] = trim($value);
}
foreach ($ws_desc as $key =>  $value) {
  $ws_desc[$key] = trim( $value);
}
foreach ($ws_capacity as $key =>  $value) {
  $ws_capacity[$key] = trim( $value);
}
foreach ($ws_offered_slots_mon as $key1 =>  $value1) {
  foreach ($value1 as $key2 =>  $value2) 
    $ws_offered_slots_mon[$key1][$key2] = trim( $value2);
}

foreach ($ws_offered_slots_tue as $key1 =>  $value1) {
  foreach ($value1 as $key2 =>  $value2) 
    $ws_offered_slots_tue[$key1][$key2] = trim( $value2);
}
foreach ($ws_offered_slots_wed as $key1 =>  $value1) {
  foreach ($value1 as $key2 =>  $value2) 
    $ws_offered_slots_wed[$key1][$key2] = trim( $value2);
}
foreach ($ws_offered_slots_thu as $key1 =>  $value1) {
  foreach ($value1 as $key2 =>  $value2) 
    $ws_offered_slots_thu[$key1][$key2] = trim( $value2);
}
foreach ($ws_offered_slots_fri as $key1 =>  $value1) {
  foreach ($value1 as $key2 =>  $value2) 
    $ws_offered_slots_fri[$key1][$key2] = trim( $value2);
}
foreach ($ws_offered_slots_sat as $key1 =>  $value1) {
  foreach ($value1 as $key2 =>  $value2) 
    $ws_offered_slots_sat[$key1][$key2] = trim( $value2);
}
foreach ($ws_offered_slots_sun as $key1 =>  $value1) {
  foreach ($value1 as $key2 =>  $value2) 
    $ws_offered_slots_sun[$key1][$key2] = trim( $value2);
}
      
$operating_specialty_str = implode(", ",$operating_specialty);
$utility_str = implode(", ",$utility);
$paid_utilities_str = implode(", ",$paid_utilities);
$amenities_str = implode(", ",$amenities);
      
//****************Print Start *******
// echo "basic_info_id : ".$basic_info_id."\n";
// echo "first_name : ".$first_name."\n";
// echo "space_type : ".$space_type."\n";
// echo "city : ".$city."\n";
// echo "landmark : ".$landmark."\n";
// echo "locality : ".$locality."\n";
// echo "address : ".$address."\n";
// echo "security_deposit : ".$security_deposit."\n";
// echo "setup_rules : ".$setup_rules."\n";
// echo "setup_desc : ".$setup_desc."\n";
// echo "map_location : ".$map_location."\n";
// echo "map_cordinates : ".$map_cordinates."\n";
// echo "operating_specialty-".$operating_specialty_str."\n";
// echo "utility-".$utility_str."\n";
// echo "paid_utilities-".$paid_utilities_str."\n";
// echo "amenities-".$amenities_str."\n";
// for ($i=0; $i < $ws_count ; $i++) { 
//   echo "ws_name : ".$ws_name[$i]."\n";
//   echo "ws_available_from : ".$ws_available_from[$key]."\n";
//   echo "ws_hourly_charges : ".$ws_hourly_charges[$key]."\n";
//   echo "ws_desc : ".$ws_desc[$i]."\n";
//   $capacity = ($i < count($ws_capacity))?$ws_capacity[$i]:"";
//   $slots_mon= ($i < count($ws_offered_slots_mon))? implode(", ",$ws_offered_slots_mon[$i]):"";
//   $slots_tue = ($i < count($ws_offered_slots_tue))? implode(", ",$ws_offered_slots_tue[$i]):"";
//   $slots_wed = ($i < count($ws_offered_slots_wed))? implode(", ",$ws_offered_slots_wed[$i]):"";
//   $slots_thu = ($i < count($ws_offered_slots_thu))? implode(", ",$ws_offered_slots_thu[$i]):"";
//   $slots_fri = ($i < count($ws_offered_slots_fri))? implode(", ",$ws_offered_slots_fri[$i]):"";
//   $slots_sat = ($i < count($ws_offered_slots_sat))? implode(", ",$ws_offered_slots_sat[$i]):"";
//   $slots_sun = ($i < count($ws_offered_slots_sun))? implode(", ",$ws_offered_slots_sun[$i]):"";
//   echo "ws_capacity : ".$capacity."\n";
//   echo "slots_mon : ".$slots_mon."\n";
//   echo "slots_tue : ".$slots_tue."\n";
//   echo "slots_wed : ".$slots_wed."\n";
//   echo "slots_thu : ".$slots_thu."\n";
//   echo "slots_fri : ".$slots_fri."\n";
//   echo "slots_sat : ".$slots_sat."\n";
//   echo "slots_sun : ".$slots_sun."\n";
//   echo "\n";
// }
//****************Print END *******
for ($i=0; $i < $ws_count ; $i++) { 
  
  $capacity = ($i < count($ws_capacity)) ? $ws_capacity[$i]:"";
  $slots_mon = ($i < count($ws_offered_slots_mon))? implode(", ",$ws_offered_slots_mon[$i]):"";
  $slots_tue = ($i < count($ws_offered_slots_tue))? implode(", ",$ws_offered_slots_tue[$i]):"";
  $slots_wed = ($i < count($ws_offered_slots_wed))? implode(", ",$ws_offered_slots_wed[$i]):"";
  $slots_thu = ($i < count($ws_offered_slots_thu))? implode(", ",$ws_offered_slots_thu[$i]):"";
  $slots_fri = ($i < count($ws_offered_slots_fri))? implode(", ",$ws_offered_slots_fri[$i]):"";
  $slots_sat = ($i < count($ws_offered_slots_sat))? implode(", ",$ws_offered_slots_sat[$i]):"";
  $slots_sun = ($i < count($ws_offered_slots_sun))? implode(", ",$ws_offered_slots_sun[$i]):"";
  date_default_timezone_set('Asia/Kolkata');
  $insert = date("Y-m-d h:i:s");
  // Create a new object from Rectangle class
  
  $db_conn = new Database;

  
  // echo PHP_EOL;
  // // print_r($ws_offered_slots_tue[$i]);
  // foreach ($ws_offered_slots_mon[$i] as $key_mon => $slot_mon) {
  //   $slots = explode("-", $slot_mon);
  //   $slot_from = $slots[0];
  //   $slot_to = $slots[1];
  //   $slot_start = explode(":", str_replace(" ", ":", $slot_from));
  //   if ($slot_start[2]=='PM') {
  //     $slot_start[0] = $slot_start[0]+12;
  //   }
  //   $slot_end = explode(":", str_replace(" ", ":", $slot_to));
  //   $difference = round(abs(strtotime($slot_to) - strtotime($slot_from)) / 3600,2);
  //   for ($j=0; $j < $difference; $j++) {       
  //     $s = $slot_start[0]+$j;
  //     $e = $s+1;
  //     $time_slot = 'mon-'.$s.'-'.$e;
  //     $sql_slots = "INSERT INTO space_available_slots (`space_info_id`, `time_slot`) VALUES( $last_id, '$time_slot')";
  //     $res_slots = $db_conn->getDbHandler()->query($sql_slots);
  //   }
  // }
  // foreach ($ws_offered_slots_tue[$i] as $key_tue => $slot_tue) {
  //   $slots = explode("-", $slot_tue);
  //   $slot_from = $slots[0];
  //   $slot_to = $slots[1];
  //   $slot_start = explode(":", str_replace(" ", ":", $slot_from));
  //   if ($slot_start[2]=='PM') {
  //     $slot_start[0] = $slot_start[0]+12;
  //   }
  //   $slot_end = explode(":", str_replace(" ", ":", $slot_to));
  //   $difference = round(abs(strtotime($slot_to) - strtotime($slot_from)) / 3600,2);
  //   for ($j=0; $j < $difference; $j++) {       
  //     $s = $slot_start[0]+$j;
  //     $e = $s+1;
  //     $time_slot = 'tue-'.$s.'-'.$e;
  //     $sql_slots = "INSERT INTO space_available_slots (`space_info_id`, `time_slot`) VALUES( $last_id, '$time_slot')";
  //     $res_slots = $db_conn->getDbHandler()->query($sql_slots);
  //   }
  // }
  
  // $last_id=47;
  // $location = '../datafiles/spaces/'.$last_id.'/space_image_profile';
  // if (!file_exists($location)) {
  //   echo $location;
  //   mkdir($location, 0777, true);
  // }
  // die();

  // INSERT
  $query = "INSERT INTO space_info (`basic_info_id`, `space_type`, `city`, `locality`, `landmark`, `addresss`, `security_deposit`, `setup_rules`, `setup_desc`, `operating_specialty`, `utility`, `paid_utilities`, `amenities`, `map_location`, `map_cordinates`, `ws_name`, `ws_available_from`, `ws_offered_slots_mon`, `ws_offered_slots_tue`, `ws_offered_slots_wed`, `ws_offered_slots_thu`, `ws_offered_slots_fri`, `ws_offered_slots_sat`, `ws_offered_slots_sun`, `ws_hourly_charges`, `ws_desc`, `ws_capacity`, `insert`) 
    VALUES ( $basic_info_id, '$space_type', '$city', '$locality', '$landmark', '$address', '$security_deposit', '$setup_rules', '$setup_desc', '$operating_specialty_str', '$utility_str', '$paid_utilities_str', '$amenities_str', '$map_location', '$map_cordinates', '$ws_name[$i]', '$ws_available_from[$i]', '$slots_mon', '$slots_tue', '$slots_wed', '$slots_thu', '$slots_fri', '$slots_sat', '$slots_sun', '$ws_hourly_charges[$i]', '$ws_desc[$i]', '$capacity' , '$insert')";
   
  //echo"<pre>"; print_r($query); die;

  $dbresult = $db_conn->getDbHandler()->query($query); 
  
  $last_id = $db_conn->lastInsertId();

  

  foreach ($ws_offered_slots_mon[$i] as $key_mon => $slot_mon) {
    $slots = explode("-", $slot_mon);
    $slot_from = $slots[0];
    $slot_to = $slots[1];
    $slot_start = explode(":", str_replace(" ", ":", $slot_from));
    if ($slot_start[2]=='PM') {
      $slot_start[0] = $slot_start[0]+12;
    }
    $slot_end = explode(":", str_replace(" ", ":", $slot_to));
    $difference = round(abs(strtotime($slot_to) - strtotime($slot_from)) / 3600,2);
    for ($j=0; $j < $difference; $j++) {       
      $s = $slot_start[0]+$j;
      $e = $s+1;
      $time_slot = 'mon-'.$s.'-'.$e;
      $sql_slots = "INSERT INTO space_available_slots (`space_info_id`, `time_slot`) VALUES( $last_id, '$time_slot')";
      $res_slots = $db_conn->getDbHandler()->query($sql_slots);
    }
  }
  foreach ($ws_offered_slots_tue[$i] as $key_tue => $slot_tue) {
    $slots = explode("-", $slot_tue);
    $slot_from = $slots[0];
    $slot_to = $slots[1];
    $slot_start = explode(":", str_replace(" ", ":", $slot_from));
    if ($slot_start[2]=='PM') {
      $slot_start[0] = $slot_start[0]+12;
    }
    $slot_end = explode(":", str_replace(" ", ":", $slot_to));
    $difference = round(abs(strtotime($slot_to) - strtotime($slot_from)) / 3600,2);
    for ($j=0; $j < $difference; $j++) {       
      $s = $slot_start[0]+$j;
      $e = $s+1;
      $time_slot = 'tue-'.$s.'-'.$e;
      $sql_slots = "INSERT INTO space_available_slots (`space_info_id`, `time_slot`) VALUES( $last_id, '$time_slot')";
      $res_slots = $db_conn->getDbHandler()->query($sql_slots);
    }
  }
  foreach ($ws_offered_slots_wed[$i] as $key_wed => $slot_wed) {
    $slots = explode("-", $slot_wed);
    $slot_from = $slots[0];
    $slot_to = $slots[1];
    $slot_start = explode(":", str_replace(" ", ":", $slot_from));
    if ($slot_start[2]=='PM') {
      $slot_start[0] = $slot_start[0]+12;
    }
    $slot_end = explode(":", str_replace(" ", ":", $slot_to));
    $difference = round(abs(strtotime($slot_to) - strtotime($slot_from)) / 3600,2);
    for ($j=0; $j < $difference; $j++) {       
      $s = $slot_start[0]+$j;
      $e = $s+1;
      $time_slot = 'wed-'.$s.'-'.$e;
      $sql_slots = "INSERT INTO space_available_slots (`space_info_id`, `time_slot`) VALUES( $last_id, '$time_slot')";
      $res_slots = $db_conn->getDbHandler()->query($sql_slots);
    }
  }
  foreach ($ws_offered_slots_thu[$i] as $key_thu => $slot_thu) {
    $slots = explode("-", $slot_thu);
    $slot_from = $slots[0];
    $slot_to = $slots[1];
    $slot_start = explode(":", str_replace(" ", ":", $slot_from));
    if ($slot_start[2]=='PM') {
      $slot_start[0] = $slot_start[0]+12;
    }
    $slot_end = explode(":", str_replace(" ", ":", $slot_to));
    $difference = round(abs(strtotime($slot_to) - strtotime($slot_from)) / 3600,2);
    for ($j=0; $j < $difference; $j++) {       
      $s = $slot_start[0]+$j;
      $e = $s+1;
      $time_slot = 'thu-'.$s.'-'.$e;
      $sql_slots = "INSERT INTO space_available_slots (`space_info_id`, `time_slot`) VALUES( $last_id, '$time_slot')";
      $res_slots = $db_conn->getDbHandler()->query($sql_slots);
    }
  }
  foreach ($ws_offered_slots_fri[$i] as $key_fri => $slot_fri) {
    $slots = explode("-", $slot_fri);
    $slot_from = $slots[0];
    $slot_to = $slots[1];
    $slot_start = explode(":", str_replace(" ", ":", $slot_from));
    if ($slot_start[2]=='PM') {
      $slot_start[0] = $slot_start[0]+12;
    }
    $slot_end = explode(":", str_replace(" ", ":", $slot_to));
    $difference = round(abs(strtotime($slot_to) - strtotime($slot_from)) / 3600,2);
    for ($j=0; $j < $difference; $j++) {       
      $s = $slot_start[0]+$j;
      $e = $s+1;
      $time_slot = 'fri-'.$s.'-'.$e;
      $sql_slots = "INSERT INTO space_available_slots (`space_info_id`, `time_slot`) VALUES( $last_id, '$time_slot')";
      $res_slots = $db_conn->getDbHandler()->query($sql_slots);
    }
  }
  foreach ($ws_offered_slots_sat[$i] as $key_sat => $slot_sat) {
    $slots = explode("-", $slot_sat);
    $slot_from = $slots[0];
    $slot_to = $slots[1];
    $slot_start = explode(":", str_replace(" ", ":", $slot_from));
    if ($slot_start[2]=='PM') {
      $slot_start[0] = $slot_start[0]+12;
    }
    $slot_end = explode(":", str_replace(" ", ":", $slot_to));
    $difference = round(abs(strtotime($slot_to) - strtotime($slot_from)) / 3600,2);
    for ($j=0; $j < $difference; $j++) {       
      $s = $slot_start[0]+$j;
      $e = $s+1;
      $time_slot = 'sat-'.$s.'-'.$e;
      $sql_slots = "INSERT INTO space_available_slots (`space_info_id`, `time_slot`) VALUES( $last_id, '$time_slot')";
      $res_slots = $db_conn->getDbHandler()->query($sql_slots);
    }
  }
  foreach ($ws_offered_slots_sun[$i] as $key_sun => $slot_sun) {
    $slots = explode("-", $slot_sun);
    $slot_from = $slots[0];
    $slot_to = $slots[1];
    $slot_start = explode(":", str_replace(" ", ":", $slot_from));
    if ($slot_start[2]=='PM') {
      $slot_start[0] = $slot_start[0]+12;
    }
    $slot_end = explode(":", str_replace(" ", ":", $slot_to));
    $difference = round(abs(strtotime($slot_to) - strtotime($slot_from)) / 3600,2);
    for ($j=0; $j < $difference; $j++) {       
      $s = $slot_start[0]+$j;
      $e = $s+1;
      $time_slot = 'sun-'.$s.'-'.$e;
      $sql_slots = "INSERT INTO space_available_slots (`space_info_id`, `time_slot`) VALUES( $last_id, '$time_slot')";
      $res_slots = $db_conn->getDbHandler()->query($sql_slots);
    }
  }


  if($_FILES['space_profile_image']['name'] != ''){
    $test = explode(".", $_FILES['space_profile_image']['name']);
    $extension = end($test);
    $space_profile_image_name = rand(100, 999).'.'.$extension;
    //$location= $_SERVER['DOCUMENT_ROOT'].'/devteam_arpit/datafiles/uploads/space_info/'.$last_id.'/space_image_profile';
    $location = '../datafiles/spaces/'.$last_id.'/space_image_profile';
    if (!file_exists($location)) {
      mkdir($location, 0777, true);
    }
    //$locationImage = $location.'/'.$space_profile_image_name;
    $locationImageSpace = $location.'/'.$space_profile_image_name;
   
    try{
      move_uploaded_file($_FILES['space_profile_image']['tmp_name'],$locationImageSpace);
    }
    catch(Exception $e){
      print_r($e);
    }
  }

  $imgcount  = count($_FILES['space_image']['name']);

  $all_image_names = "";
  // Loop through each file
  for( $i=0 ; $i < $imgcount ; $i++ ) {

  if($_FILES['space_image']['name'][$i] != ''){
    $test = explode(".", $_FILES['space_image']['name'][$i]);
    $extension = end($test);
    $space_image_name = rand(1000, 99999).'.'.$extension;

    if($i != 0)
      $all_image_names = $all_image_names.",";

      $all_image_names =  $all_image_names.$space_image_name; 
    //$location= $_SERVER['DOCUMENT_ROOT'].'/devteam_arpit/datafiles/uploads/space_info/'.$last_id.'/space_images';
    $location = '../datafiles/spaces/'.$last_id.'/space_images';
    if (!file_exists($location)) {
      mkdir($location, 0777, true);
    }
    $locationImage = $location.'/'.$space_image_name;
   
    try{
      move_uploaded_file($_FILES['space_image']['tmp_name'][$i],$locationImage);
    }
    catch(Exception $e){
      print_r($e);
    }
  }

  
}


  




  if($_FILES['identity_proof']['name'] != ''){
    $test = explode(".", $_FILES['identity_proof']['name']);
    $extension = end($test);
    $identity_proof_name = rand(100, 999).'.'.$extension;
    //$location= $_SERVER['DOCUMENT_ROOT'].'/devteam_arpit/datafiles/uploads/space_info/'.$last_id.'/space_docs/identity_proof';
    $location = '../datafiles/spaces/'.$last_id.'/space_docs/identity_proof';
    
    if (!file_exists($location)) {
      mkdir($location, 0777, true);
    }
    $locationImage = $location.'/'.$identity_proof_name;
    try{
      move_uploaded_file($_FILES['identity_proof']['tmp_name'],$locationImage);
    }
    catch(Exception $e){
      print_r($e);
    }
  }
  if($_FILES['space_ownership_docs']['name'] != ''){
    $test = explode(".", $_FILES['space_ownership_docs']['name']);
    $extension = end($test);
    $space_ownership_docs_name = rand(100, 999).'.'.$extension;
    //$location= $_SERVER['DOCUMENT_ROOT'].'/devteam_arpit/datafiles/uploads/space_info/'.$last_id.'/space_docs/space_ownership_docs';
    $location = '../datafiles/spaces/'.$last_id.'/space_docs/space_ownership_docs';
    if (!file_exists($location)) {
      mkdir($location, 0777, true);
    }
    $locationImage = $location.'/'.$space_ownership_docs_name;
    try{
      move_uploaded_file($_FILES['space_ownership_docs']['tmp_name'],$locationImage);
    }
    catch(Exception $e){
      print_r($e);
    }
  }
  if($_FILES['noc']['name'][0] != ''){
    $test = explode(".", $_FILES['noc']['name'][0]);
    $extension = end($test);
    $noc_name = rand(100, 999).'.'.$extension;
    
    $location = '../datafiles/spaces/'.$last_id.'/space_docs/noc_name';
    if (!file_exists($location)) {
      mkdir($location, 0777, true);
    }
    $locationImage = $location.'/'.$noc_name;
    try{
      move_uploaded_file($_FILES['noc']['tmp_name'][0],$locationImage);
    }
    catch(Exception $e){
      print_r($e);
    }
  }
  if($_FILES['other_docs']['name'] != ''){
    $test = explode(".", $_FILES['other_docs']['name']);
    $extension = end($test);
    $other_docs_name = rand(100, 999).'.'.$extension;
    $location = '../datafiles/spaces/'.$last_id.'/space_docs/other_docs_name';
    if (!file_exists($location)) {
      mkdir($location, 0777, true);
    }
    $locationImage = $location.'/'.$other_docs_name;
    try{
      move_uploaded_file($_FILES['other_docs']['tmp_name'],$locationImage);
    }
    catch(Exception $e){
      print_r($e);
    }
  }
  $queryUpdate = " UPDATE space_info SET `other_docs` = '$other_docs_name', `noc_name` = '$noc_name', `space_ownership_docs_name` = '$space_ownership_docs_name', `space_image_name` = '$all_image_names', `identity_proof_name` = '$identity_proof_name', `space_profile_image` = '$space_profile_image_name' WHERE id = $last_id";
  $dbresult = $db_conn->getDbHandler()->query($queryUpdate); 
  if( $dbresult )
  {
    
    //echo "ss"; die;
    // echo "Space ownership documents : \n";
    // $space_profile_image = "";  
    // $space_image ="";  
    // $space_docs = "";  
    // $space_ownership_docs = "";  
    
    
    // $last_inserted_id = $db_conn->lastInsertId();
    // $ret = require 'upload-space-profile-image.php';
    // if(current($ret))
    // {
    //   foreach($ret   as $key => $value)
    //   {
    //     if($key < 1) continue;
    //     if($key == 1) $space_profile_image=$value;
    //     else $space_profile_image =$space_profile_image .','.$value;
    //   }
    // }
        
    $form_link='https://www.profrea.com'; 
    $email_subject = "Thanks you are successfully registered with Profrea!!!";
    $email_message = '
      <html><body>
          <p style="font-size:15px;">Hey <b> '. $first_name . '</b>,</p>
          <p style="font-size:15px;">Thank you for posting your workspace with us! </p>
          <p style="font-size:15px;">Your workspace will be screened in 48 business hours. </p>
          <p style="font-size:15px;">Have a question? Visit Profrea Contact Us section. </p>
          <p style="font-size:15px;"><br/><br/><b>To your success</b>, </p>
          <p style="font-size:15px;">Team Profrea </p>
          <p style="font-size:12px;"><br/><br/><u>Confidentiality Warning</u>: This message and any attachments are intended only for the use of the intended recipient(s), are confidential and may be privileged. If you are not the intended recipient, you are hereby notified that any review, re-transmission, conversion to hard copy, copying, circulation or other use of this message and any attachments is strictly prohibited. If you are not the intended recipient, please notify the sender immediately by return email and delete this message and any attachments from your system. </p>
      </body></html>
    ';
    $result = sendMail( $email_subject,$email_message,$email_Id);
    sendMail( $email_subject,$email_message,'info@profrea.com',$email_Id,$first_name);
    sendMail( $email_subject,$email_message,'marketing@profrea.com',$email_Id,$first_name);          
    if ($result) {
      echo "Congratulations !!! "," You have successfully submitted details.";
    } 
    else {
      echo "Error! "," There is some problem while submitting your request. Please try again";
    }
  }
  else
  {
    echo 'Detail submission failed ';
  }  
}

//$_POST['c'].find('li').each(function(){
//echo " hii ";
//})
//echo  "\n first_name : ".$_POST['c'] . "<br />";
/*
if(!empty($_POST['amen']))
{
echo "<ul>" ;
    foreach ($_POST['amenities'] as $value) {
    echo "<li>$value</li>";
    }
  echo "</ul>";
}
 if(isset($_POST["amen"])){
   echo 'alert("yoohoo")';
 }
 else
 {
    echo 'alert(" still empty ")';
 }
echo "\n basic_info_id: ".$_POST['basic_info_id'] . "<br />";
echo  "\n first_name : ".$_POST['first_name'] . "<br />";
echo  "\n space_type : ".$_POST['space_type'] . "<br />";
echo  "\n locality : ".$_POST['locality'] . "<br />";
echo  "\n landmark : ".$_POST['landmark'] . "<br />";
echo  "\n city : ".$_POST['city'] . "<br />";
echo  "\n security deposit : ".$_POST['security_deposit'] . "<br />";
echo  "\n use policy : ".$_POST['use_policy'] . "<br />";
echo  "\n Setup Description : ".$_POST['setup_description'] . "<br />";
echo  "\n Map address : ".$_REQUEST['map_loc'] . "<br />";
echo  "\n Map location : ".$_REQUEST['map_loc1'] . "<br />";
if ($_FILES["noc"]["error"] > 0)
  {
  echo "Error: " . $_FILES["noc"]["error"] . "<br />";
  }
else
  {
  echo "Noc file name : " . $_FILES["noc"]["name"] . "<br />";
  echo "Stored in: " . $_FILES["noc"]["tmp_name"]  . "<br />";
  }
if ($_FILES["terms"]["error"] > 0)
  {
  echo "Error: " . $_FILES["terms"]["error"] . "<br />";
  }
else
  {
  echo "Terms of use file name : " . $_FILES["terms"]["name"] . "<br />";
  echo "Stored in: " . $_FILES["terms"]["tmp_name"]  . "<br />";
  }
$total1 = count($_FILES['space_ownership_docs']['name']);
echo "Space ownership documents : \n";
// Loop through each file
for( $i=0 ; $i < $total1 ; $i++ ) {
      echo " ". $_FILES['space_ownership_docs']['name'][$i] ."\n \n \n";
     echo " ". $_FILES['space_ownership_docs']['tmp_name'][$i] ."<br />";
}
$total2 = count($_FILES['space_docs']['name']);
echo "Space documents : \n";
// Loop through each file
for( $i=0 ; $i < $total2 ; $i++ ) {
      echo " ". $_FILES['space_docs']['name'][$i] ."\n \n \n";
     echo " ". $_FILES['space_docs']['tmp_name'][$i] ."<br />";
}
$total3 = count($_FILES['space_image']['name']);
echo "Space ownership documents : \n";
// Loop through each file
for( $i=0 ; $i < $total3 ; $i++ ) {
      echo " ". $_FILES['space_image']['name'][$i] ."\n \n \n";
     echo " ". $_FILES['space_image']['tmp_name'][$i] ."<br />";
}
//echo  "\n space_docs : ".$_POST['coordinates'] . "<br />";
if(!empty($_REQUEST['amen']))
{
echo "<ul>" ;
    foreach ($_POST['amenities'] as $value) {
    echo "<li>$value</li>";
    }
  echo "</ul>";
}
 if(isset($_REQUEST["amen"])){
   echo 'alert("yoohoo")';
 }
 else
 {
    echo 'alert(" still empty ")';
 }
$myAmen = $_REQUEST['amenities'];
foreach ($myAmen as $eachAmen) {
     echo $eachAmen . "<br>";
}
require_once('Classes/Model/Database.php');
require_once('util/validate.php');
require_once('util/util.php');
require_once('mail/sendmail.php');
use App\Classes\Model\Database;
echo ' HII ';
//validation expected data exists
if(!isset($_POST['basic_info_id']) 
|| !isset($_POST['first_name']) 
|| !isset($_POST['email_Id']) 
|| !isset($_POST['space_type']) 
 || !isset($_POST['specialty_operating']) 
 || !isset($_POST['available_from']) 
 || !isset($_POST['capacity']) 
 || !isset($_POST['days_availability']) 
 || !isset($_POST['time_slot_availability']) 
 || !isset($_POST['description']) 
 || !isset($_POST['use_policy']) 
 || !isset($_POST['amenities'])
 || !isset($_POST['utility']) 
 || !isset($_POST['paid_utilities']) 
 || !isset($_POST['hourly_charges']) 
 || !isset($_POST['security_deposit']) 
 || !isset($_POST['locality']) 
 || !isset($_POST['landmark']) 
 || !isset($_POST['city'])
 || !isset($_POST['state']) 
 || !isset($_POST['pin_code']) 
 ) {
died('We are sorry, but there appears to be a problem with the form you submitted.');       
}
$basic_info_id = trim( $_POST['basic_info_id'] );  
$first_name = trim( $_POST['first_name'] );  
$email_Id = trim( $_POST['email_Id'] );  
$space_type = trim( $_POST['space_type'] );  
$specialty_operating = trim( $_POST['specialty_operating'] );  
$available_from = trim( $_POST['available_from'] );  
$capacity = trim( $_POST['capacity'] );  
$days_availability = trim( $_POST['days_availability'] );  
$time_slot_availability = trim( $_POST['time_slot_availability'] );  
$description = trim( $_POST['description'] );  
$use_policy = trim( $_POST['use_policy'] );  
$amenities = trim( $_POST['amenities'] );  
$utility = trim( $_POST['utility'] );  
$paid_utilities = trim( $_POST['paid_utilities'] );  
$hourly_charges = trim( $_POST['hourly_charges'] );  
$security_deposit = trim( $_POST['security_deposit'] );  
// $space_profile_image = trim( $_POST['space_profile_image'] );  
// $space_image = trim( $_POST['space_image'] );  
// $space_docs = trim( $_POST['space_docs'] );  
// $space_ownership_docs = trim( $_POST['space_ownership_docs'] );  
$locality = trim( $_POST['locality'] );  
$landmark = trim( $_POST['landmark'] );  
$city = trim( $_POST['city'] );  
$state = trim( $_POST['state'] );  
$pin_code = trim( $_POST['pin_code'] );  
$rowstate = TRUE;  
// Validate Data
if (  strlen($basic_info_id) < 1  )   
died("Invalid Error");  
if (  strlen($space_type) < 5  )   
died("Invalid space type");  
if (  strlen($specialty_operating) < 5  )   
died( "Invalid specialty operating");  
if (  strlen($available_from) < 10  )   
died("Invalid available from");  
if (  strlen($description) < 10  )   
died("Invalid description");  
if (  strlen($capacity) > 0  and !isValidNumber($capacity) )   
died("Invalid capacity");  
if (   !isValidNumber($hourly_charges) )   
died("Invalid hourly charges");  
if (  strlen($locality) < 4  || !isValidAddress($locality) )   
died("Invalid Locality");  
if (  strlen($landmark) < 4  || !isValidAddress($landmark) )   
died("Invalid Landmark");  
if (  strlen($city) < 2  || !isValidString($city) )   
died("Invalid City");  
if (  strlen($state) < 2  || !isValidString($state) )   
died("Invalid State");  
if (   !isValidPinCode($pin_code) )   
died("Invalid PinCode");  
 // Create a new object from Rectangle class
 $db_conn = new Database;
 //INSERT 
// $query = " INSERT INTO space_info ( basic_info_id, space_type, specialty_operating, available_from, capacity, days_availability, time_slot_availability, description, use_policy, amenities, utility, paid_utilities, hourly_charges, security_deposit,  space_image, space_docs, space_ownership_docs, locality, landmark, city, state, pin_code, rowstate )  VALUES ( '$basic_info_id', '$space_type', '$specialty_operating', '$available_from', '$capacity', '$days_availability', '$time_slot_availability', '$description', '$use_policy', '$amenities', '$utility', '$paid_utilities', '$hourly_charges', '$security_deposit',  '$space_image', '$space_docs', '$space_ownership_docs', '$locality', '$landmark', '$city', '$state', '$pin_code', '$rowstate' ) "; 
 $query = " INSERT INTO space_info ( basic_info_id, space_type, specialty_operating, available_from, capacity, days_availability, time_slot_availability, description, use_policy, amenities, utility, paid_utilities, hourly_charges, security_deposit, locality, landmark, city, state, pin_code, rowstate )  VALUES ( '$basic_info_id', '$space_type', '$specialty_operating', '$available_from', '$capacity', '$days_availability', '$time_slot_availability', '$description', '$use_policy', '$amenities', '$utility', '$paid_utilities', '$hourly_charges', '$security_deposit', '$locality', '$landmark', '$city', '$state', '$pin_code', '$rowstate' ) "; 
 $dbresult = $db_conn->getDbHandler()->query($query); 
 if( $dbresult )
 {
 $space_profile_image = "";  
 $space_image ="";  
 $space_docs = "";  
 $space_ownership_docs = "";  
 
 
 $last_inserted_id = $db_conn->lastInsertId();
 $ret = require 'upload-space-profile-image.php';
 if(current($ret))
 {
 foreach($ret   as $key => $value)
 {
 if($key < 1) continue;
 if($key == 1) $space_profile_image=$value;
 else $space_profile_image =$space_profile_image .','.$value;
 }
 }
  
 
$ret = require 'upload-space-image.php';
if(current($ret))
{
foreach($ret   as $key => $value)
{
if($key < 1) continue;
if($key == 1) $space_image=$value;
else $space_image =$space_image .','.$value;
}
}
$ret = require 'upload-space_docs.php';
if(current($ret))
{
foreach($ret   as $key => $value)
{
if($key < 1) continue;
if($key == 1) $space_docs=$value;
else $space_docs =$space_docs .','.$value;
}
}
$ret = require 'upload-space_ownership_docs.php';
if(current($ret))
{
foreach($ret   as $key => $value)
{
if($key < 1) continue;
if($key == 1) $space_ownership_docs=$value;
else $space_ownership_docs =$space_ownership_docs .','.$value;
}
}
// echo "<script>console.log(' space_profile_image  "  .$space_profile_image.  "' );</script>";
// echo "<script>console.log(' space_image  "  .$space_image.  "');</script>";
// echo "<script>console.log(' space_image  "  .$space_docs.  "');</script>";
// echo "<script>console.log(' space_image  "  .$space_ownership_docs.  "');</script>";
$query = " update space_info set space_profile_image='".$space_profile_image."',  space_image='".$space_image."',  space_docs='".$space_docs."',  space_ownership_docs='".$space_ownership_docs."' where id =".$last_inserted_id ;
$dbresult = $db_conn->getDbHandler()->query($query); 
   
if( $dbresult )
{
$form_link='https://www.profrea.com'; 
$email_subject = "Thanks you are successfully registered with Profrea!!!";
$email_message = '
<html><body>
    <p style="font-size:15px;"> Hey <b> '. $first_name . '</b>,</p>
    <p style="font-size:15px;">Thank you for posting your workspace with us! </p>
    <p style="font-size:15px;">Your workspace will be screened in 48 business hours. Once approved, it will start featuring in the search results. </p>
    <p style="font-size:15px;">Have a question? Visit Profrea Contact Us section. </p>
    <p style="font-size:15px;"><br/><br/><b>To your success</b>, </p>
    <p style="font-size:15px; ">Team Profrea </p>
    <p style="font-size:28px;">  <img src="https://www.profrea.com/img/mail.png" `  height="42" width="82"> </p>
    <p style="font-size:12px; "> <br/><br/><u>Confidentiality Warning</u>: This message and any attachments are intended only for the use of the intended recipient(s), are confidential and may be privileged. If you are not the intended recipient, you are hereby notified that any review, re-transmission, conversion to hard copy, copying, circulation or other use of this message and any attachments is strictly prohibited. If you are not the intended recipient, please notify the sender immediately by return email and delete this message and any attachments from your system. </p>
</body></html>
';
$result = sendMail( $email_subject,$email_message,$email_Id);
    sendMail( $email_subject,$email_message,'info@profrea.com',$email_Id,$first_name);
    sendMail( $email_subject,$email_message,'marketing@profrea.com',$email_Id,$first_name);
    
      if ($result) {
    success("Congratulations !!! "," You have successfully submitted details.");
      } else {
    failed("Error! "," There is some problem while submitting your request. Please try again");
      }
}
else
{
echo 'Detail submission failed ';
}
 }
 else
 {
 echo 'Query Failed ';
 }
 */
?>