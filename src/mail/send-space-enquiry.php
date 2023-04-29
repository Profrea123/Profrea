<?php
require_once('../Classes/Model/Database.php');
require_once('../util/validate.php');
require_once('sendmail.php');                      
require_once('../util/util.php');
require_once('../../vendor/autoload.php');
use App\Classes\RealEstate\Spaces;
use App\Classes\Model\Database;

//echo"<pre>"; print_r($_FILE); die;


echo "\n first_name: ".$_POST['first_name'];
echo  "\n last_name : ".$_POST['last_name'];
echo  "\n email : ".$_POST['email'];
echo  "\n mobile : ".$_POST['mobile'];
echo  "\n Start Date : ".$_POST['start_date'];

if(isset($_POST['brief_profile1']))
{
  echo "\n SCHEDULE A TOUR ";
  echo "\n Brief Profile: ".$_POST['brief_profile1'];
  echo  "\n time slot : ".$_POST['slot-list'];
}

//echo"<pre>"; print_r($_FILES); die;

if (isset($_POST['email'])) {
  
  if (
    !isset($_POST['first_name']) ||
    !isset($_POST['last_name']) ||
    !isset($_POST['email']) ||
    !isset($_POST['mobile']) ||
    !isset($_POST['start_date']) ||
    !isset($_POST['space_id']) ||
    !isset($_POST['brief_profile1'])
  ) {
    died('We are sorry, but there appears to be a problem with the form you submitted.');
  }


  if($_FILES['file-input']['name'] != ''){
    $test = explode(".", $_FILES['file-input']['name']);
    $extension = end($test);
    $filename = rand(100, 999).'.'.$extension;
  
    $location= $_SERVER['DOCUMENT_ROOT'].'/datafiles/uploads/property_documents';
  
    $locationImage = $location.'/'.$filename;
  
    try{
      move_uploaded_file($_FILES['file-input']['tmp_name'],$locationImage);
    }catch(Exception $e){
        print_r($e);
    }
  }

  
  $first_name = $_POST['first_name']; // required
  $last_name = $_POST['last_name']; //not required
  $email_from = $_POST['email']; // required
  $mobile = $_POST['mobile']; // required
  $start_date = $_POST['start_date']; //not required
  $message = $_POST['brief_profile1']; // required
  $space_id = $_POST['space_id']; //required

  $brief_profile1 = $_POST['brief_profile1']; 
  $start_date = $_POST['start_date']; 
  $p_amount = $_POST['p_amount']; 
  $select_date = $_POST['select_date']; 
  $select_time = $_POST['select_time']; 
  $work_mon = 'MON~'.$_POST['work_mon'][0].'-'.$_POST['work_mon'][1]; 
  $work_tue = 'TUE~'.$_POST['work_tue'][0].'-'.$_POST['work_tue'][1]; 
  $work_wed = 'WED~'.$_POST['work_wed'][0].'-'.$_POST['work_wed'][1]; 
  $work_thu = 'THU~'.$_POST['work_thu'][0].'-'.$_POST['work_thu'][1]; 
  $work_fri = 'FRI~'.$_POST['work_fri'][0].'-'.$_POST['work_fri'][1]; 
  $work_sat = 'SAT~'.$_POST['work_sat'][0].'-'.$_POST['work_sat'][1]; 
  $work_sun = 'SUN~'.$_POST['work_sun'][0].'-'.$_POST['work_sun'][1]; 
  date_default_timezone_set('Asia/Kolkata');
  $created_at = date("Y-m-d h:i:s");
  
  // Create a new object from Rectangle class
  $db_conn = new Database;
  $unique_id = uniqid(); 

  //INSERT 
  if($select_date){
    $query = " INSERT INTO `space_enquiry` (space_id, first_name, last_name, mobile, email, brief_profile1, start_date, p_amount, select_date,select_time, work_mon, work_tue, work_wed, work_thu, work_fri, work_sat, work_sun, property_documents , created_at )  VALUES ( '$space_id', '$first_name', '$last_name', '$mobile', '$email_from', '$brief_profile1', '$start_date', '$p_amount', 
    '$select_date', '$select_time', '$work_mon', '$work_tue', '$work_wed', '$work_thu', '$work_fri', '$work_sat','$work_sun', '$filename' , '$created_at' ) "; 
  }else{
    $query = " INSERT INTO `space_enquiry` (space_id, first_name, last_name, mobile, email, brief_profile1, start_date, p_amount, work_mon, work_tue, work_wed, work_thu, work_fri, work_sat, work_sun, property_documents , created_at)  VALUES ( '$space_id', '$first_name', '$last_name', '$mobile', '$email_from', '$brief_profile1', '$start_date', '$p_amount', 
   '$work_mon', '$work_tue', '$work_wed', '$work_thu', '$work_fri', '$work_sat','$work_sun', '$filename' , '$created_at'  ) "; 
  }

  //echo $query; die; 
  
  $dbresult = $db_conn->getDbHandler()->query($query); 



  $real_estate = new Spaces();
  $singleData = $real_estate->viewSingleData($space_id);
    
  if (  strlen($message) < 10  )   
  died("Invalid Message"); 
  $email_to = "info@profrea.com";
  $email_subject = "Space enquiry";
  $email_from = $email_from;//$_POST['email']; // required
  $email_message = '
      <html><body>
      <p style="font-size:20px;">Space enquiry by <b>'.($first_name).'</b>.</p>
      <p style="font-size:18px;">
      <b> First Name: </b> '. ($first_name) . ' <br/>
      <b> Last Name: </b> '. ($last_name) . ' <br/>
      <b> Email: </b> '. ($email_from) . ' <br/>
      <b> Mobile: </b> '. ($mobile) . ' <br/>
      <b> Start Date: </b> '. ($start_date) . ' <br/>
      <b> Message: </b> '. ($message) . ' <br/>				   
      </p>
      <p style="font-size:20px;">Enquired Space Details :-</p>
      <p style="font-size:18px;">
      <b> Space Id: </b> '. ($space_id) . ' <br/>
      <b> Space Type: </b> '. ($singleData->space_type) . ' <br/>
      <b> Space Owner Id: </b> '. ($singleData->owner_id) . ' <br/>
      <b> Hourly Charges: </b> '. ($singleData->hourly_charges) . ' <br/>
      <b> Address: </b> '. ($singleData->address) . ' <br/>
      <b> Locality: </b> '. ($singleData->locality) . ' <br/>
      <b> Landmark: </b> '. ($singleData->landmark) . ' <br/>
      <b> City: </b> '. ($singleData->city) . ' <br/>
      <b> State: </b> '. ($singleData->state) . ' <br/>
      </p>
      <p style="font-size:20px;">Customize Plan :-</p>
      <p style="font-size:18px;">
      <b> Monday: </b> '. ($work_mon) . ' <br/>
      <b> Tuesday: </b> '. ($work_tue) . ' <br/>
      <b> Wednesday: </b> '. ($work_wed) . ' <br/>
      <b> Thursday: </b> '. ($work_thu) . ' <br/>
      <b> Friday: </b> '. ($work_fri) . ' <br/>
      <b> Saturday: </b> '. ($work_sat) . ' <br/>
      <b> Sunday: </b> '. ($work_sun) . ' <br/>
      <b> Total Plan Amount: </b> '. ($p_amount) . ' <br/>
      <b> Select Visit Date: </b> '. ($select_date) . ' <br/>
      <b> Select Visit Time: </b> '. ($select_time) . ' <br/>
      </p>
      </body></html>
      ';

    $result = sendMail( $email_subject,$email_message,$email_to,$email_from);
    if ($result) {
    success("Hey.. "," Thanks for submitting space enquiry");
    } else {
    failed("Error! "," There is some problem while submitting your request. Please try again");
    }

?>


  <!-- include your own success html here -->

<?php
}
?>