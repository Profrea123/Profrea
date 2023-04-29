<?php 
session_start();
$title = 'Booking Failure';
$keywords = 'Profrea';
$description = 'Profrea';
$page="booking_appointment";

if (!isset($_SESSION['booking_payment_failure']))
{
    header("Location: doctor-consult");
}

require_once('src/Classes/Model/Database.php');
require_once('vendor/autoload.php');
use App\Classes\Model\Database;
$db_connection = new Database;

include_once('header.php');
?>
<section class="bg-space-header">
    <div class="container">
        
        <div class="col-md-12">
            <div class="row mb-5 mt-5 text-center">
                <img src="images/failure.gif" alt="" class="success-gif"> 
                <h4>Please try again. Something went wrong</h4>
                <p>We couldn't book that appointment. <?php echo $_SESSION['booking_payment_failure']; ?></p>
            </div>
        </div>
    </div>
</section>


<?php include_once('footer.php');?>