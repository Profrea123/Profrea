<?php 
session_start();

if (!isset($_SESSION['booking_payment_reference_id']))
{
    header("Location: doctor-consult");
}

$title = 'Booking Appointment Success';
$keywords = 'Profrea';
$description = 'Profrea';
$page="booking-success";

require_once('src/Classes/Model/Database.php');

include_once('header.php');
?>
<section class="bg-space-header">
    <div class="container">
        
        <div class="col-md-12">
            <div class="row mb-5 mt-5 text-center">
                <img src="images/tick.gif" alt="" class="success-gif"> 
                <h4>You successfully scheduled a meeting.</h4>
                <p>We have received your booking. Your booking reference no is <b><?php echo $_SESSION['booking_payment_reference_id']; ?></b></p>
            </div>
        </div>
    </div>
</section>


<?php include_once('footer.php');?>