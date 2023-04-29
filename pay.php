<?php
session_start();
$title = "Profrea";
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
$data = [];
$json = json_encode($data);
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
                    // print_r($data_array);
                    $user_id = trim($data_array['user_id']);
                    $sql_user = "SELECT name,email,mobileNo,address FROM users WHERE id = $user_id";
                    $res_user = $db_connection->getDbHandler()->query($sql_user);
                    $row_user = $res_user->fetch();
                    $space_id = trim($data_array['space_id']);
                    $charges_per_hour = $data_array['charges_per_hour'];
                    $date_from = $start_date = $data_array['date_from'];
                    // $date_to = $end_date = $data_array['date_to'];
                    $date_to = $end_date = date("d-m-Y", strtotime("+1 month", strtotime($date_from)));
                    $booking_start_date = date("Y-m-d", strtotime($date_from));
                    $booking_end_date = date("Y-m-d", strtotime($date_to));
                    $slots = $data_array['slots'];
                    $mon_slots = $tue_slots = $wed_slots = $thu_slots = $fri_slots = $sat_slots = $sun_slots = '';
                    $mon_hours = $tue_hours = $wed_hours = $thu_hours = $fri_hours = $sat_hours = $sun_hours = 0;
                    $mon_count = $tue_count = $wed_count = $thu_count = $fri_count = $sat_count = $sun_count = 0;
                    while(strtotime($date_from) <= strtotime($date_to)){
                        if(date("N",strtotime($date_from))==1){
                            $mon_count++;
                        }
                        if(date("N",strtotime($date_from))==2){
                            $tue_count++;
                        }
                        if(date("N",strtotime($date_from))==3){
                            $wed_count++;
                        }
                        if(date("N",strtotime($date_from))==4){
                            $thu_count++;
                        }
                        if(date("N",strtotime($date_from))==5){
                            $fri_count++;
                        }
                        if(date("N",strtotime($date_from))==6){
                            $sat_count++;
                        }
                        if(date("N",strtotime($date_from))==7){
                            $sun_count++;
                        }
                        $date_from = date("Y-m-d", strtotime("+1 day", strtotime($date_from)));
                    }
                    $booking_code = uniques_max_id('space_bookings');
                    $space_booking_insert = "INSERT INTO `space_bookings` (`booking_code`,`user_id`,`space_id`,`booking_start_date`,`booking_end_date`) VALUES(:booking_code,:user_id,:space_id,:booking_start_date,:booking_end_date)";
                    $stmt = $db_connection->getDbHandler()->prepare($space_booking_insert);
                    $stmt->bindParam(':booking_code', $booking_code);
                    $stmt->bindParam(':user_id', $user_id);
                    $stmt->bindParam(':space_id', $space_id);
                    $stmt->bindParam(':booking_start_date', $booking_start_date);
                    $stmt->bindParam(':booking_end_date', $booking_end_date);
                    // if( $stmt->execute() )
                    // {
                        $booking_id = $db_connection->lastInsertId();
                        $is_available = 1;
                        if(isset($slots['mon'])){
                            $mon_slots = $slots['mon'];
                            foreach ($mon_slots as $key => $monvalue) {
                                $sql_user_insert = "UPDATE `space_available_slots` SET `is_available` = :is_available WHERE id = :id";
                                $stmt = $db_connection->getDbHandler()->prepare($sql_user_insert);
                                $stmt->bindParam(':is_available', $is_available);
                                $stmt->bindParam(':id', $monvalue);
                                // $stmt->execute();
                                $qry_space_booking_slot = "INSERT INTO `space_booking_slots` (`space_id`,`booking_id`,`time_slot_id`) VALUES(:space_id,:booking_id,:time_slot_id)";
                                $stmt_space_booking_slot = $db_connection->getDbHandler()->prepare($qry_space_booking_slot);
                                $stmt_space_booking_slot->bindParam(':space_id', $space_id);
                                $stmt_space_booking_slot->bindParam(':booking_id', $booking_id);
                                $stmt_space_booking_slot->bindParam(':time_slot_id', $monvalue);
                                // $stmt_space_booking_slot->execute();
                                $mon_hours++;
                            }
                        }
                        if(isset($slots['tue'])){
                            $tue_slots = $slots['tue'];
                            foreach ($tue_slots as $key => $tuevalue) {
                                $sql_user_insert = "UPDATE `space_available_slots` SET `is_available` = :is_available WHERE id = :id";
                                $stmt = $db_connection->getDbHandler()->prepare($sql_user_insert);
                                $stmt->bindParam(':is_available', $is_available);
                                $stmt->bindParam(':id', $tuevalue);
                                // $stmt->execute();
                                $qry_space_booking_slot = "INSERT INTO `space_booking_slots` (`space_id`,`booking_id`,`time_slot_id`) VALUES(:space_id,:booking_id,:time_slot_id)";
                                $stmt_space_booking_slot = $db_connection->getDbHandler()->prepare($qry_space_booking_slot);
                                $stmt_space_booking_slot->bindParam(':space_id', $space_id);
                                $stmt_space_booking_slot->bindParam(':booking_id', $booking_id);
                                $stmt_space_booking_slot->bindParam(':time_slot_id', $tuevalue);
                                // $stmt_space_booking_slot->execute();
                                $tue_hours++;
                            }
                        }
                        if(isset($slots['wed'])){
                            $wed_slots = $slots['wed'];
                            foreach ($wed_slots as $key => $wedvalue) {
                                $sql_user_insert = "UPDATE `space_available_slots` SET `is_available` = :is_available WHERE id = :id";
                                $stmt = $db_connection->getDbHandler()->prepare($sql_user_insert);
                                $stmt->bindParam(':is_available', $is_available);
                                $stmt->bindParam(':id', $wedvalue);
                                // $stmt->execute();
                                $qry_space_booking_slot = "INSERT INTO `space_booking_slots` (`space_id`,`booking_id`,`time_slot_id`) VALUES(:space_id,:booking_id,:time_slot_id)";
                                $stmt_space_booking_slot = $db_connection->getDbHandler()->prepare($qry_space_booking_slot);
                                $stmt_space_booking_slot->bindParam(':space_id', $space_id);
                                $stmt_space_booking_slot->bindParam(':booking_id', $booking_id);
                                $stmt_space_booking_slot->bindParam(':time_slot_id', $wedvalue);
                                // $stmt_space_booking_slot->execute();
                                $wed_hours++;
                            }
                        }
                        if(isset($slots['thu'])){
                            $thu_slots = $slots['thu'];
                            foreach ($thu_slots as $key => $thuvalue) {
                                $sql_user_insert = "UPDATE `space_available_slots` SET `is_available` = :is_available WHERE id = :id";
                                $stmt = $db_connection->getDbHandler()->prepare($sql_user_insert);
                                $stmt->bindParam(':is_available', $is_available);
                                $stmt->bindParam(':id', $thuvalue);
                                // $stmt->execute();
                                $qry_space_booking_slot = "INSERT INTO `space_booking_slots` (`space_id`,`booking_id`,`time_slot_id`) VALUES(:space_id,:booking_id,:time_slot_id)";
                                $stmt_space_booking_slot = $db_connection->getDbHandler()->prepare($qry_space_booking_slot);
                                $stmt_space_booking_slot->bindParam(':space_id', $space_id);
                                $stmt_space_booking_slot->bindParam(':booking_id', $booking_id);
                                $stmt_space_booking_slot->bindParam(':time_slot_id', $thuvalue);
                                // $stmt_space_booking_slot->execute();
                                $thu_hours++;
                            }
                        }
                        if(isset($slots['fri'])){
                            $fri_slots = $slots['fri'];
                            foreach ($fri_slots as $key => $frivalue) {
                                $sql_user_insert = "UPDATE `space_available_slots` SET `is_available` = :is_available WHERE id = :id";
                                $stmt = $db_connection->getDbHandler()->prepare($sql_user_insert);
                                $stmt->bindParam(':is_available', $is_available);
                                $stmt->bindParam(':id', $frivalue);
                                // $stmt->execute();
                                $qry_space_booking_slot = "INSERT INTO `space_booking_slots` (`space_id`,`booking_id`,`time_slot_id`) VALUES(:space_id,:booking_id,:time_slot_id)";
                                $stmt_space_booking_slot = $db_connection->getDbHandler()->prepare($qry_space_booking_slot);
                                $stmt_space_booking_slot->bindParam(':space_id', $space_id);
                                $stmt_space_booking_slot->bindParam(':booking_id', $booking_id);
                                $stmt_space_booking_slot->bindParam(':time_slot_id', $frivalue);
                                // $stmt_space_booking_slot->execute();
                                $fri_hours++;
                            }
                        }
                        if(isset($slots['sat'])){
                            $sat_slots = $slots['sat'];
                            foreach ($sat_slots as $key => $satvalue) {
                                $sql_user_insert = "UPDATE `space_available_slots` SET `is_available` = :is_available WHERE id = :id";
                                $stmt = $db_connection->getDbHandler()->prepare($sql_user_insert);
                                $stmt->bindParam(':is_available', $is_available);
                                $stmt->bindParam(':id', $satvalue);
                                // $stmt->execute();
                                $qry_space_booking_slot = "INSERT INTO `space_booking_slots` (`space_id`,`booking_id`,`time_slot_id`) VALUES(:space_id,:booking_id,:time_slot_id)";
                                $stmt_space_booking_slot = $db_connection->getDbHandler()->prepare($qry_space_booking_slot);
                                $stmt_space_booking_slot->bindParam(':space_id', $space_id);
                                $stmt_space_booking_slot->bindParam(':booking_id', $booking_id);
                                $stmt_space_booking_slot->bindParam(':time_slot_id', $satvalue);
                                // $stmt_space_booking_slot->execute();
                                $sat_hours++;
                            }
                        }
                        if(isset($slots['sun'])){
                            $sun_slots = $slots['sun'];
                            foreach ($sun_slots as $key => $sunvalue) {
                                $sql_user_insert = "UPDATE `space_available_slots` SET `is_available` = :is_available WHERE id = :id";
                                $stmt = $db_connection->getDbHandler()->prepare($sql_user_insert);
                                $stmt->bindParam(':is_available', $is_available);
                                $stmt->bindParam(':id', $sunvalue);
                                // $stmt->execute();
                                $qry_space_booking_slot = "INSERT INTO `space_booking_slots` (`space_id`,`booking_id`,`time_slot_id`) VALUES(:space_id,:booking_id,:time_slot_id)";
                                $stmt_space_booking_slot = $db_connection->getDbHandler()->prepare($qry_space_booking_slot);
                                $stmt_space_booking_slot->bindParam(':space_id', $space_id);
                                $stmt_space_booking_slot->bindParam(':booking_id', $booking_id);
                                $stmt_space_booking_slot->bindParam(':time_slot_id', $sunvalue);
                                // $stmt_space_booking_slot->execute();
                                $sun_hours++;
                            }
                        }                        
                    // }

                    $total_mon_hours = $mon_count * $mon_hours;
                    $total_tue_hours = $tue_count * $tue_hours;
                    $total_wed_hours = $wed_count * $wed_hours;
                    $total_thu_hours = $thu_count * $thu_hours;
                    $total_fri_hours = $fri_count * $fri_hours;
                    $total_sat_hours = $sat_count * $sat_hours;
                    $total_sun_hours = $sun_count * $sun_hours;
                    $total_hours = $total_mon_hours+$total_tue_hours+$total_wed_hours+$total_thu_hours+$total_fri_hours+$total_sat_hours+$total_sun_hours;
                    $total_amount = $total_hours * $charges_per_hour;

                    $amount = $total_amount;
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
                        $displayAmount = $orderData['amount'];
                        if ($displayCurrency !== 'INR') {
                            $url = "https://api.fixer.io/latest?symbols=$displayCurrency&base=INR";
                            $exchange = json_decode(file_get_contents($url), true);
                            $displayAmount = $exchange['rates'][$displayCurrency] * $orderData['amount'] / 100;
                            $data['display_currency'] = $displayCurrency;
                            $data['display_amount'] = $displayAmount;
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
                        $json = json_encode($data);
                        ?>
                        <div class="row">
                            <div class="co-md-6 table-responsive">
                                <h4>Booking Details</h4>
                                <table class="table table-bordered table-hover">
                                    <tbody>
                                        <tr>
                                            <th>Booking Code</th>
                                            <td><?php echo $booking_code; ?></td>
                                        </tr>
                                        <tr>
                                            <th>Booking Duration</th>
                                            <td><?php echo $date_from." to ".$date_to; ?></td>
                                        </tr>                                        
                                        <tr>
                                            <th>Total Hours</th>
                                            <td><?php echo $total_hours; ?></td>
                                        </tr>
                                        <tr>
                                            <th>Price Per Hours</th>
                                            <td><?php echo $charges_per_hour; ?></td>
                                        </tr>
                                        <tr>
                                            <th>Total Amount</th>
                                            <td><?php echo $total_amount; ?></td>
                                        </tr>
                                        <tr>
                                            <th>Currency</th>
                                            <td><?php echo $currency; ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="co-md-6">
                                <form name='razorpayform' action="verify.php" method="POST">
                                    
                                    <input type="hidden" name="razorpay_payment_id" id="razorpay_payment_id">
                                    <input type="hidden" name="razorpay_signature" id="razorpay_signature">
                                    <button id="rzp-button1" class="btn btn-primary">Pay with Razorpay</button>
                                </form>
                            </div>
                        </div>
                        <?php
                    }
                    else{
                        ?>
                        <p class="text-center text-danger"><b>payment amount invalid!</b></p>
                        <?php
                    }                    
                }
                else{
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
<script>
var options = <?php echo $json; ?>;
if (options.length) {
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
    document.getElementById('rzp-button1').onclick = function(e){
        rzp.open();
        e.preventDefault();
    }
}
</script>