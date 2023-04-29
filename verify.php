<?php
session_start();
$title = "Profrea";
$description = "";
$keywords = "";
$page = 1;
if (!isset($_POST['razorpay_payment_id']))
{
    header("Location: spaces");
}
include_once('header.php');
require_once('src/Classes/Model/Database.php');
use App\Classes\Model\Database;
$db_connection = new Database;
require('payments/config.php');
require('payments/razorpay/Razorpay.php');
use Razorpay\Api\Api;
use Razorpay\Api\Errors\SignatureVerificationError;
$api = new Api($keyId, $keySecret);
$razorpay_order_id = $_POST['razorpay_order_id'];
$razorpay_payment_id = $_POST['razorpay_payment_id'];
$razorpay_signature = $_POST['razorpay_signature'];
$user_id = $_POST['user_id'];
$space_id = $_POST['space_id'];
$plan_id = $_POST['plan_id'];
$booking_id = $_POST['booking_id'];
$status = 0;
try
{
    $attributes = array(
        'razorpay_order_id' => $razorpay_order_id,
        'razorpay_payment_id' => $razorpay_payment_id,
        'razorpay_signature' => $razorpay_signature
    );
    $api->utility->verifyPaymentSignature($attributes);
    $success = true;
    $status = 1;
}
catch(SignatureVerificationError $e)
{
    $success = false;
    $status = 2;
    $error = 'Razorpay Error : ' . $e->getMessage();
}
$qry_transactions = "INSERT INTO `transactions` (`razorpay_order_id`,`razorpay_payment_id`,`razorpay_signature`,`user_id`,`space_id`,`plan_id`,`booking_id`,`status`) VALUES(:razorpay_order_id,:razorpay_payment_id,:razorpay_signature,:user_id,:space_id,:plan_id,:booking_id,:status)";
$stmt_transactions = $db_connection->getDbHandler()->prepare($qry_transactions);
$stmt_transactions->bindParam(':razorpay_order_id', $razorpay_order_id);
$stmt_transactions->bindParam(':razorpay_payment_id', $razorpay_payment_id);
$stmt_transactions->bindParam(':razorpay_signature', $razorpay_signature);
$stmt_transactions->bindParam(':user_id', $user_id);
$stmt_transactions->bindParam(':space_id', $space_id);
$stmt_transactions->bindParam(':plan_id', $plan_id);
$stmt_transactions->bindParam(':booking_id', $booking_id);
$stmt_transactions->bindParam(':status', $status);
$stmt_transactions->execute();
?>
<section class="bg-post-free-header">
    <div class="container">
       <div class="row align-items-start">
            <div class="col-md-12 pt-5 text-center" style="min-height:500px;">
                <?php
                if ($success === true)
                {
                    ?>
                    <p>Your payment was successful</p>
                    <p>Payment ID: <?php echo $_POST['razorpay_payment_id']; ?></p>
                    <?php
                }
                else
                {
                    ?>
                    <p>Your payment failed</p>
                    <p><?php echo $error; ?></p>
                    <?php
                }
                ?>
            </div>
        </div>
    </div>
</section>
<?php
include_once('footer.php'); 
?>