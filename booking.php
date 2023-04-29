<?php
session_start();
$title = "Booking";
$description = "";
$keywords = "";
$page = 1;
include_once('header.php');
require_once('src/Classes/Model/Database.php');
use App\Classes\Model\Database;
$db_connection = new Database;
require('payments/config.php');
require('payments/razorpay/Razorpay.php');
use Razorpay\Api\Api;
$api = new Api($keyId, $keySecret);
function uniques_max_id($table_name)
{
    global $db_connection;
    $sel_table = "SELECT MAX(id) AS maxid FROM $table_name";
    $res_table = $db_connection->getDbHandler()->prepare($sel_table);
    $res_table->execute();
    $row_table = $res_table->fetch(PDO::FETCH_ASSOC);
    $maxid = $row_table['maxid'];
    $random = 10000+$maxid+1;
    $unique = 'BK'.$random;
    return $unique;
}
// $data = [];
// $json = json_encode($data);
?>
<section class="bg-post-free-header">
    <div class="container">
       <div class="row align-items-start">
            <div class="col-md-12 pt-5 pb-5">
                <?php
                if(isset($_POST['formData']))
                {
                    $formData = $_POST['formData'];
                    parse_str($formData, $data_array);
                    $user_id = trim($data_array['user_id']);
                    $sql_user = "SELECT name,email,mobileNo,address FROM users WHERE id = $user_id";
                    $res_user = $db_connection->getDbHandler()->query($sql_user);
                    $row_user = $res_user->fetch();
                    $space_id = trim($data_array['space_id']);
                    $plan_id = $data_array['plan_id'];
                    $sql_space_plan = "SELECT * FROM p2_plans WHERE p2_plans.id = $plan_id";
              
                    $res_space_plan = $db_connection->getDbHandler()->query($sql_space_plan);
                    $space_plan = $res_space_plan->fetch();
                    $date_from = $start_date = $data_array['date_from'];
                    // $date_to = $end_date = $data_array['date_to'];
                    $date_to = $end_date = date("d-m-Y", strtotime("+1 month", strtotime($date_from)));
                    $booking_start_date = date("Y-m-d", strtotime($date_from));
                    $booking_end_date = date("Y-m-d", strtotime($date_to));
                    $booking_status = 1;
                    $slots = $data_array['slots'];
                    $mon_slots = $tue_slots = $wed_slots = $thu_slots = $fri_slots = $sat_slots = $sun_slots = '';
                    if(isset($slots['mon'])){
                        $mon_slots = implode(',', $slots['mon']);
                    }
                    if(isset($slots['tue'])){
                        $tue_slots = implode(',', $slots['tue']);
                    }
                    if(isset($slots['wed'])){
                        $wed_slots = implode(',', $slots['wed']);
                    }
                    if(isset($slots['thu'])){
                        $thu_slots = implode(',', $slots['thu']);
                    }
                    if(isset($slots['fri'])){
                        $fri_slots = implode(',', $slots['fri']);
                    }
                    if(isset($slots['sat'])){
                        $sat_slots = implode(',', $slots['sat']);
                    }
                    if(isset($slots['sun'])){
                        $sun_slots = implode(',', $slots['sun']);
                    }                    
                    $booking_code = uniques_max_id('space_bookings');
                    $space_booking_insert = "INSERT INTO `space_bookings` (`booking_code`,`user_id`,`space_id`,`plan_id`,`booking_start_date`,`booking_end_date`,`booking_status`,`mon_slots`,`tue_slots`,`wed_slots`,`thu_slots`,`fri_slots`,`sat_slots`,`sun_slots`) VALUES(:booking_code,:user_id,:space_id,:plan_id,:booking_start_date,:booking_end_date,:booking_status,:mon_slots,:tue_slots,:wed_slots,:thu_slots,:fri_slots,:sat_slots,:sun_slots)";
                    $stmt = $db_connection->getDbHandler()->prepare($space_booking_insert);
                    $stmt->bindParam(':booking_code', $booking_code);
                    $stmt->bindParam(':user_id', $user_id);
                    $stmt->bindParam(':space_id', $space_id);
                    $stmt->bindParam(':plan_id', $plan_id);
                    $stmt->bindParam(':booking_start_date', $booking_start_date);
                    $stmt->bindParam(':booking_end_date', $booking_end_date);
                    $stmt->bindParam(':booking_status', $booking_status);                    
                    $stmt->bindParam(':mon_slots', $mon_slots);
                    $stmt->bindParam(':tue_slots', $tue_slots);
                    $stmt->bindParam(':wed_slots', $wed_slots);
                    $stmt->bindParam(':thu_slots', $thu_slots);
                    $stmt->bindParam(':fri_slots', $fri_slots);
                    $stmt->bindParam(':sat_slots', $sat_slots);
                    $stmt->bindParam(':sun_slots', $sun_slots);
                    if( $stmt->execute() ){
                        $booking_id = $db_connection->lastInsertId();
                    }
                    $amount = $space_plan['initial_payment'];
                    $currency = "INR";
                    $item_name = "Slots";
                    $item_description = "From ".$start_date." to ".$end_date;
                    $cust_name = $row_user['name'];
                    $email = $row_user['email'];
                    $contact = $row_user['mobileNo'];
                    $address = $row_user['address'];
                    $orderData = [
                        'receipt'         => strtotime("now"),
                        'amount'          => $amount * 100,
                        'currency'        => $currency,
                        'payment_capture' => 1
                    ];
                    if ($amount > 0) {
                        $razorpayOrder = $api->order->create($orderData);
                        $razorpayOrderId = $razorpayOrder['id'];
                        $_SESSION['razorpay_order_id'] = $razorpayOrderId;
                        $displayAmount = $amount = $orderData['amount'];
                        if ($displayCurrency !== 'INR') {
                            $url = "https://api.fixer.io/latest?symbols=$displayCurrency&base=INR";
                            $exchange = json_decode(file_get_contents($url), true);
                            $displayAmount = $exchange['rates'][$displayCurrency] * $amount / 100;
                        }
                        $data = [
                            "key"               => $keyId,
                            "amount"            => $amount,
                            "name"              => $item_name,
                            "description"       => $item_description,
                            "image"             => "",
                            "prefill"           => [
                                "name"              => $cust_name,
                                "email"             => $email,
                                "contact"           => $contact,
                            ],
                            "notes"             => [
                                "address"           => $address,
                                "merchant_order_id" => $booking_code,
                            ],
                            "theme"             => [
                                "color"             => "#528FF0"
                            ],
                            "order_id"          => $razorpayOrderId,
                        ];
                        if ($displayCurrency !== 'INR')
                        {
                            $data['display_currency']  = $displayCurrency;
                            $data['display_amount']    = $displayAmount;
                        }
                        $json = json_encode($data);
                        ?>
                        <div class="row">
                            <div class="co-md-12 table-responsive">
                                <h4>Booking Details</h4>
                                <table class="table table-bordered table-hover">
                                    <tbody>
                                        <tr>
                                            <th>Booking Code</th>
                                            <td><?php echo $booking_code; ?></td>
                                        </tr>
                                        <tr>
                                            <th>Booking Date</th>
                                            <td><?php echo $date_from; ?></td>
                                        </tr>    
                                        <tr>
                                            <th>Visit Permises Before</th>
                                            <td><?php 
                                            $date = date('d-m-Y', strtotime("+5 day"));
                                            echo $date; ?></td>
                                        </tr>                                     
                                        <tr>
                                            <th>Plan Name</th>
                                            <td><?php echo $space_plan['title']; ?></td>
                                        </tr>
                                        <tr>
                                            <th>Plan Amount</th>
                                            <td><?php echo $space_plan['plan_amount']; ?></td>
                                        </tr>
                                        <tr>
                                            <th>Cost Per Hour</th>
                                            <td><?php echo $space_plan['cost_per_hour']; ?></td>
                                        </tr>
                                        <tr>
                                            <th>Initial Amount</th>
                                            <td><?php echo $space_plan['initial_payment']; ?></td>
                                        </tr>
                                        <tr>
                                            <th>Currency</th>
                                            <td><?php echo $currency; ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <p class="text-center">
                                    <button id="rzp-button" class="btn btn-primary">Pay with Razorpay</button>
                                </p>
                            </div>
                            <div class="co-md-12">
                                <form name='razorpayform' action="verify" method="POST">                                    
                                    <input type="hidden" name="razorpay_payment_id" id="razorpay_payment_id">
                                    <input type="hidden" name="razorpay_signature" id="razorpay_signature">
                                    <input type="hidden" name="razorpay_order_id" id="razorpay_order_id" value="<?php echo $razorpayOrderId; ?>">
                                    <input type="hidden" name="user_id" id="user_id" value="<?php echo $user_id; ?>">
                                    <input type="hidden" name="space_id" id="space_id" value="<?php echo $space_id; ?>">
                                    <input type="hidden" name="plan_id" id="plan_id" value="<?php echo $plan_id; ?>">
                                    <input type="hidden" name="booking_id" id="booking_id" value="<?php echo $booking_id; ?>">
                                </form>
                            </div>
                        </div>
                        <?php
                    }
                    else
                    {
                        ?>
                        <p class="text-center text-danger"><b>payment amount invalid!</b></p>
                        <?php
                    }
                }
                else
                {
                    ?>
                    <p class="text-center text-danger"><b>Data not available!</b></p>
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
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script type="text/javascript">
    var options = <?php echo $json?>;
    options.handler = function (response){
        document.getElementById('razorpay_payment_id').value = response.razorpay_payment_id;
        document.getElementById('razorpay_signature').value = response.razorpay_signature;
        document.razorpayform.submit();
    };
    options.theme.image_padding = false;
    options.modal = {
        ondismiss: function() {
            console.log("This code runs when the popup is closed");
        },
        escape: true,
        backdropclose: false
    };
    var rzp = new Razorpay(options);
    document.getElementById('rzp-button').onclick = function(e){
        rzp.open();
        e.preventDefault();
    }
</script>