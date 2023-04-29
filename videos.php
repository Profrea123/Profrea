<?php 
require_once('src/Classes/Model/Database.php');
require_once('vendor/autoload.php');
use App\Classes\Model\Database;
$db_connection = new Database;
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



if (isset($_GET['domain'])) 
{    
    // $login_id = base64_decode($_GET['id']);    
    $domain = $_GET['domain'];
    $sql_website_details = "SELECT * FROM website_details as wd  WHERE wd.domain = '$domain'";
    $res_website_details = $db_connection->getDbHandler()->query($sql_website_details);
    if($res_website_details)
    {     
        $row_website_details = $res_website_details->fetch();
        $user_id = $row_website_details['user_id'];
        $sql_user = "SELECT users.*,city.name as city,os.name as op_speciality,os.id as op_specialityid FROM users left join operating_specialty as os on os.id = users.speciality left join gender on gender.id=users.gender_id left join city on city.id=users.city WHERE users.id = $user_id";
        $res_user = $db_connection->getDbHandler()->query($sql_user);
        if($res_user)
        {
            $row_user = $res_user->fetch();
            if($row_user['profile_picture']!=''){
                $profile_picture = $row_user['profile_picture'];
            }
            else{
                if($row_user['gender_id']==1){
                    $profile_picture = "male.png";
                }
                else{
                    $profile_picture = "female.png";
                }
            }

            $splid = $row_user['op_specialityid'];
        }

           //$sql_profrea_clinic = "SELECT * FROM spaces WHERE owner_id = $login_id AND space_type = 'Clinic'";
           $sql_profrea_clinic = "SELECT sbook.*,sp.* FROM space_bookings as sbook 
           LEFT JOIN spaces AS sp ON sp.id = sbook.space_id
           WHERE sbook.user_id = $user_id and sbook.booking_status > 0";

           $res_profrea_clinic = $db_connection->getDbHandler()->query($sql_profrea_clinic);
       
           if($res_profrea_clinic)
           {
               $row_profrea_clinic = $res_profrea_clinic->fetchAll();
           }

        
    
        // print_r( $row_website_details);
    }
    else{
        header('Location: index');
    }
}
else
{
    header('Location: index');
}
if(count($row_profrea_clinic) > 0){
    $ccity = $row_profrea_clinic[0]['locality'].", ".$row_profrea_clinic[0]['city'];
}else {
    $ccity = "Gurugram";
}

$title = "Dr. ".ucwords($row_user["name"])." top ".$row_user["op_speciality"]." in ".$ccity;
$description = $title;

$keywords = "";
$page = 1;
include_once('header-client.php');
?>

<div class="newpro-pgheader bg-white  pt-4 pb-4  w-100 ">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
            <h4 class="herohead-1 mb-0"><a href="website?domain=<?php echo $domain; ?>" class="text-decoration-none"><i class="fa fa-arrow-left pe-3"></i></a> <?php echo $row_service_details[0]['name'] ?></h4>
            </div>
        </div>
    </div>
</div>


<!-- indivual section -->
<section class="new-wp pb-5">
    <div class="container">
        <div class="row bg-white shadow p-3">
            <div class="col-md-12">
            <div class="row pt-5">
                    <div class="col-md-1 p-0 col-3 cir-newimg text-center text-md-start">
                        <img src="datafiles/uploads/profiles/<?php echo $profile_picture; ?>" class="img-fluid" alt="" title="">
                    </div>
                    <div class="col-md-11 col-9 align-self-stretch mb-5">
                        <div><h4 class="herohead pt-3"><?php echo "Dr. ".ucwords($row_user["name"]); ?><i class="fa fa-check-circle"></i></h4></div>
                        <div><h6 class="subherohead"><?php echo $row_user["op_speciality"]; ?></h6></div>
                        <a href="website?domain=<?php echo $domain; ?>" class="vwp">View Profile</a>
                    </div>
                    <div class="col-md-4">
                    <iframe src="https://www.youtube.com/embed/UJB4eh-Vtz8?autoplay=1&amp;mute=1&amp;enablejsapi=1&amp;loop=1" width="100%" height="360" frameborder="0"></iframe>
                    </div>
                    <div class="col-md-4">
                        <iframe src="https://www.youtube.com/embed/UJB4eh-Vtz8?autoplay=1&amp;mute=1&amp;enablejsapi=1&amp;loop=1" width="100%" height="360" frameborder="0"></iframe>
                    </div>
                    <div class="col-md-4">
                        <iframe src="https://www.youtube.com/embed/UJB4eh-Vtz8?autoplay=1&amp;mute=1&amp;enablejsapi=1&amp;loop=1" width="100%" height="360" frameborder="0"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php 

include_once('footer-client.php');
?>    
    
