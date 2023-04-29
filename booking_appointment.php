<?php
session_start();
$title = 'Appointment Summary';
$keywords = 'Profrea';
$description = 'Profrea';
$page="booking_appointment";

require_once('src/Classes/Model/Database.php');
require_once('vendor/autoload.php');
require_once('src/mail/sendmail.php');
use App\Classes\Model\Database;
$db_connection = new Database;
require('payments/config.php');
require('payments/razorpay/Razorpay.php');
use Razorpay\Api\Api;
$api = new Api($keyId, $keySecret);

if (isset($_POST['chosen_slot_time']) && isset($_POST['chosendate']) && isset($_POST['chosen_slot_time']))
{
    $doctor_id      = $_POST['bookingpage'];
    $booking_date   = $_POST['chosendate'];
    $booking_time   = $_POST['chosen_slot_time'];
    $booking_type   = $_POST['booking_type'];

    $sql_website_details = "SELECT users.*, website_details.* FROM users LEFT JOIN website_details ON website_details.user_id = users.id WHERE website_details.user_id = ".$doctor_id;
    $res_website_details = $db_connection->getDbHandler()->query($sql_website_details);
    $row_website_details = $res_website_details->fetch();
    if ($row_website_details =='') {
        header('Location: index');
    }
    
    $sql_city = $db_connection->getDbHandler()->query("SELECT name FROM city WHERE id = ".$row_website_details['city']);
    $row_city = $sql_city->fetch();

    $res_operating_specialty = $db_connection->getDbHandler()->query("SELECT name FROM operating_specialty WHERE id = ".$row_website_details['speciality']);
    $row_operating_specialty = $res_operating_specialty->fetch();

    $res_gender = $db_connection->getDbHandler()->query("SELECT * FROM gender");
    if($res_gender)
    {
        $row_gender = $res_gender->fetchAll();
    }

    $is_otp_verified = $is_send_otp = 0;
    $otp_message = '';
    
    $name                   = $_POST['name'] ?? '';
    $email                  = $_POST['email'] ?? '';
    $phone                  = $_POST['phone'] ?? '';
    $gender                 = $_POST['gender'] ?? '';
    $otp_code               = $_POST['otp_code'] ?? '';
    $visiting_reason        = $_POST['visiting_reason'] ?? '';
    $booking_for            = $_POST['booking_for'] ?? '';
    $family_member          = $_POST['family_member'] ?? '';
    
    if (isset($_SESSION['ap_profrea_login_id']))
    {
        $sql_login_details = "SELECT * FROM users WHERE id = ".$_SESSION['ap_profrea_login_id'];
        $res_login_details = $db_connection->getDbHandler()->query($sql_login_details);
        $row_login_details = $res_login_details->fetch();

        $res_family = $db_connection->getDbHandler()->query("SELECT * FROM family_members Where user_id = ".$_SESSION['ap_profrea_login_id']."");
        if($res_family)
        {
            $row_family_member = $res_family->fetchAll();
        }

        if(isset($_POST['name']) == '' && isset($_POST['email']) == '' && isset($_POST['phone']) == ''){
            $name   = $row_login_details['name'];
            $email  = $row_login_details['email'];
            $phone  = $row_login_details['mobileNo'];
        }
    }

    $amount = 0; $time_duration  = '';
    if ($booking_type == 1) { 
        $amount = $row_website_details['audio_amount']; 
        $time_duration  = $row_website_details['audio_slot_interval'];
    } elseif($booking_type == 2){ 
        $amount = $row_website_details['video_amount']; 
        $time_duration  = $row_website_details['slot_interval'];
    } else {
        $amount = $row_website_details['clinic_amount']; 
        $time_duration  = $row_website_details['clinic_slot_interval'];
    }

    if (isset($_POST['send_otp_btn'])) {
        if($otp_code !='')
        {
            $sql_otp = $db_connection->getDbHandler()->query("SELECT * FROM otp_verifications WHERE (email='$email' OR mobile='$phone') AND otp=$otp_code");
            $res_otp = $sql_otp->fetch();
            if($res_otp !='') {
                $query1 = "UPDATE otp_verifications SET otp=0, status=1 WHERE id=".$res_otp["id"];
                $db_connection->getDbHandler()->query($query1);
                $is_send_otp = 0;
                $is_otp_verified = 1;
                $otp_message = 'OTP has been verified. Pay to book your slot.';
            } else {
                $is_send_otp    = 1;
                $otp_message = 'Invalid OTP. Please enter valid OTP code';
            }
        } else {
            $sql_otp        = $db_connection->getDbHandler()->query("SELECT * FROM otp_verifications WHERE (email='$email' OR mobile='$phone')");
            $result_otp     = $sql_otp->fetch();
            $mobile_otp     = rand(100000,999999);
            if ($result_otp !='') {
                $result1 = $db_connection->getDbHandler()->query("UPDATE otp_verifications SET otp='$mobile_otp', status=0, email='$email', mobile='$phone' WHERE (email='$email' OR mobile='$phone')");
                $result1->execute();
            } else {
                $result1 = $db_connection->getDbHandler()->prepare("INSERT INTO otp_verifications (mobile,email,otp,status) VALUES('$phone','$email','$mobile_otp','0')");
                $result1->execute();
            }
            try {
                $is_send_otp    = 1;
                if ($email !='') {
                    $email_subject = "OTP Generated with Profrea!!!";
                        
                    $email_message = file_get_contents("template/otpmail.html");
                    $email_message = str_replace("@@otp@@",$mobile_otp,$email_message);
                    
                    $result = sendMail( $email_subject,$email_message, $email);
                }

                if($phone !='') {
                    $message    = $mobile_otp." is your Profrea OTP. Do not share it with anyone.";
                    $mobileNos  = $phone;
                    
                    $url = "https://sms.nettyfish.com/api/v2/SendSMS?SenderId=PRFREA&Message=".urlencode($message)."&MobileNumbers=".$mobileNos."&ApiKey=pNIg7phvNboA+wW5Q4gDgYTOYOK3q4/gRTSud7uoGTI=&ClientId=bea0553d-0c7f-481f-a8af-f65db8a5b395";

                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL,$url);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET"); 
                    
                    $output = curl_exec($ch);
                    curl_close($ch);
                }
                
                $otp_message = 'OTP sent to your mobile and email !.Please enter OTP to continue';
            } catch (\Exception $e) {
                $is_send_otp    = 0;
                $otp_message = 'OTP could not be sent. Please try again.';
            }
        }
    }
}
else
{
    header('Location: index');
}

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

include_once('header.php');
?>
<section class="bg-space-header">
    <div class="container">
        <div class="col-md-12">
            <div class="row mb-5">
                <div class="col-md-4">
                    <div class="card widget-profile pat-widget-profile">
                        <div class="card-body">
                            <div class="pro-widget-content">
                                <div class="profile-info-widget">
                                    <a href="#" class="booking-doc-img">
                                    <?php 
                                        $profile_image = 'images/no-image.png';
                                        if($row_website_details['profile_picture'] != '' && file_exists("datafiles/uploads/profiles/".$row_website_details['profile_picture'])) {
                                            $profile_image = 'datafiles/uploads/profiles/'.$row_website_details['profile_picture'];
                                        }
                                    ?>
                                        <img src="<?php echo $profile_image;?>" alt="<?php echo $row_website_details['name']; ?>">
                                    </a>
                                    <div class="profile-det-info">
                                        <h3>Dr.<?php echo $row_website_details['name']; ?></h3>
                                        <div class="patient-details">
                                            <?php if ($row_operating_specialty !='') { ?>
                                            <h5><b><?php echo $row_operating_specialty['name']; ?></b></h5>
                                            <?php } if ($row_city !='') { ?>
                                            <h5 class="mb-0"><i class="fas fa-map-marker-alt"></i> <?php echo $row_city['name']; ?></h5>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="patient-info">
                                <ul>
                                    <li>Experience <span><?php echo $row_website_details['experience']; ?></span></li>
                                    <li>Address <span><?php echo $row_website_details['address'] .' '.($row_city ? $row_city['name'] : '' ).'-'.$row_website_details['pinCode'] .', '.$row_website_details['state']; ?> </span></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-8 booking_summary_card">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="appointment_summary">
                                <div class="title text-center">
                                    <h5>Appointment Summary</h5>
                                </div>
                                <div class="text-start">
                                    <ul class="list-style-none pl0">
                                        <li><b>Date:</b> <?php echo date('l, jS F, Y ', strtotime($booking_date));?></li>
                                        <li><b>Time:</b> <?php echo $booking_time;?></li>
                                        <li><b>Duration:</b> <?php echo $time_duration;?></li>
                                        <li><b>Booking Type:</b> 
                                            <?php
                                            if ($booking_type == 1) {
                                                echo 'Audio';
                                            } elseif($booking_type == 2){
                                                echo 'Video';
                                            } else {
                                                echo 'In-Clinic';
                                            }
                                            ?>
                                        </li>
                                        <li><b>Consultant:</b> DR.<?php echo $row_website_details['name']; ?></li>
                                        <li><b>Amount:</b> ₹<?php echo $amount; ?></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="summary_form">
                            <?php
                                
                                $transaction_charge = 0;
                                $service_charge = 0;
                                $sub_total = $amount;
                                $tax_percentage = 0;
                                $tax_amount = 0;
                                $discount_amount = 0;
                                $currency = "INR";
                                $orderData = [
                                    'receipt'         => strtotime("now"),
                                    'amount'          => $amount * 100,
                                    'currency'        => $currency,
                                    'payment_capture' => 1
                                ];
                                if ($amount > 0) {
                                    $booking_code = uniques_max_id('booking_details');
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
                                        "name"              => '',
                                        "description"       => '',
                                        "image"             => "",
                                        "prefill"           => [
                                            "name"          => $name,
                                            "email"         => $email,
                                            "contact"       => $phone,
                                        ],
                                        "notes"             => [
                                            "doctor_id"         => $doctor_id,
                                            "booking_no"        => $booking_code,
                                            "name"              => $name,
                                            "email"             => $email,
                                            "mobile"            => $phone,
                                            "gender"            => $gender,
                                            "booking_date"      => $booking_date,
                                            "booking_time"      => $booking_time,
                                            "time_duration"     => $time_duration,
                                            "transaction_charge"=> $transaction_charge,
                                            "sub_total"         => $sub_total,
                                            "tax_amount"        => $tax_amount,
                                            "tax_percentage"    => $tax_percentage,
                                            "discount_amount"   => $discount_amount,
                                            "booking_type"      => $booking_type,
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
                                    $_SESSION['cash_data'] = [
                                        "doctor_id"         => $doctor_id,
                                        "booking_no"        => $booking_code,
                                        "name"              => $name,
                                        "email"             => $email,
                                        "mobile"            => $phone,
                                        "gender"            => $gender,
                                        "booking_date"      => $booking_date,
                                        "booking_time"      => $booking_time,
                                        "time_duration"     => $time_duration,
                                        "transaction_charge"=> $transaction_charge,
                                        "amount"            => $sub_total,
                                        "sub_total"         => $sub_total,
                                        "tax_amount"        => $tax_amount,
                                        "tax_percentage"    => $tax_percentage,
                                        "discount_amount"   => $discount_amount,
                                        "booking_type"      => $booking_type,
                                        "visiting_reason"   => $visiting_reason,
                                        "booking_for"       => $booking_for,
                                        "family_member"     => $family_member,
                                    ];
                                ?>
                                <form name='razorpayform' action="booking_appointment_verify.php" method="POST">
                                    <input type="hidden" name="user_id" id="user_id" value="<?php if(isset($_SESSION['ap_profrea_login_id'])) { echo $_SESSION['ap_profrea_login_id']; } ?>">
                                    <input type="hidden" name="razorpay_payment_id" id="razorpay_payment_id">
                                    <input type="hidden" name="razorpay_signature" id="razorpay_signature">
                                    <input type="hidden" name="razorpay_order_id" id="razorpay_order_id" value="<?php echo $razorpayOrderId; ?>">
                                    <input type="hidden" name="doctor_id" id="doctor_id" value="<?php echo $doctor_id; ?>">
                                    <input type="hidden" name="visiting_reason" id="visiting_reason" value="<?php echo  $visiting_reason; ?>">
                                    <input type="hidden" name="booking_for" id="booking_for" value="<?php echo  $booking_for; ?>">
                                    <input type="hidden" name="family_member" value="<?php echo  $family_member; ?>">
                                    <input type="hidden" name="booking_date" id="booking_date" value="<?php echo $booking_date; ?>">
                                    <input type="hidden" name="booking_time" id="booking_time" value="<?php echo $booking_time; ?>">
                                    <input type="hidden" name="time_duration" id="time_duration" value="<?php echo $time_duration; ?>">
                                    <input type="hidden" name="booking_type" id="booking_type" value="<?php echo $booking_type; ?>">
                                    <input type="hidden" name="payment_mode" id="payment_mode" value="online">
                                </form>
                                <form id="checkout-selection" action="booking_appointment.php" method="POST"  novalidate autocomplete="off" data-parsley-validate>	
                                    <?php if (!$is_otp_verified) {  ?>
                                    <div class="row mb-3">
                                        <div class="radio text-left">
                                            <label style="padding: 0;">Booking For <span class="error">*</span></label>
                                            <label> 
                                                <input id="myself" type="radio" name="booking_for" value="myself" <?php if($booking_for != '') {  if($booking_for == 'myself') { echo 'checked'; } } else { echo 'checked'; }?>  required />  My-Self
                                            </label>
                                            <?php if(isset($_SESSION['ap_profrea_login_id'])) {  ?>
                                            <label>
                                                <input id="family" type="radio" name="booking_for" value="family"  <?php echo ($booking_for == 'family'?"checked":"")?> required  />  Family
                                            </label>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <div class="mb-3" id="family_div" style="display: none;">
                                        <label for="">Family Member <span class="error">*</span></label>
                                        <select id="family_member" name="family_member" class="form-control" <?php if ($is_otp_verified) { echo "readonly"; } ?>>
                                            <option value="">-- select --</option>
                                            <?php foreach($row_family_member as $family_members){ ?>
                                                <option value="<?php echo $family_members["id"]; ?>" <?php echo ($family_member == $family_members["id"]?"selected":""); ?>><?php echo $family_members["name"]; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <?php } else { ?>
                                        <div class="mb-3">
                                            <label for="">Booking For <span class="error">*</span></label>
                                            <input type="text" required name="booking_for" class="p-2 col-lg-6 col-6 form-control" value="<?php echo $booking_for; ?>" readonly>
                                        </div>
                                        <div class="mb-3" id="family_div" style="display:none;">
                                            <label for="">Family Member <span class="error">*</span></label>
                                            <?php foreach($row_family_member as $family_members){ if($family_member == $family_members["id"]) { ?>
                                                <input type="text" required class="p-2 col-lg-6 col-6 form-control" value="<?php echo ($family_members["name"]); ?>" readonly>
                                            <?php } } ?>
                                        </div>
                                        <input type="hidden" id="family_member" value="<?php echo $family_member; ?>" class="p-2 col-lg-6 col-6 form-control" readonly>
                                    <?php } ?>
                                    <div class="mb-3">
                                        <label for="">Patient Name <span class="error">*</span></label>
                                        <input type="hidden" class="form-control" name="bookingpage" value="<?php echo $doctor_id; ?>">
                                        <input type="hidden" class="form-control" name="chosendate" value="<?php echo $booking_date; ?>">
                                        <input type="hidden" class="form-control" name="chosen_slot_time" value="<?php echo $booking_time; ?>">
                                        <input type="hidden" class="form-control" name="booking_type" value="<?php echo $booking_type; ?>">
                                        <input type="text" required class="form-control" name="name" id="name" class="p-2 col-lg-6 col-6 form-control" placeholder="Enter Patient name" value="<?php echo $name; ?>" <?php if ($is_otp_verified) { echo "readonly"; } ?>>
                                    </div>
                                    <div class="mb-3">
                                        <label for="">Email <span class="error">*</span></label>
                                        <input type="email" required name="email" id="email" class="p-2 col-lg-6 col-6 form-control" placeholder="Enter your Email (to send OTP)" value="<?php echo $email; ?>" <?php if ($is_otp_verified) { echo "readonly"; } ?>>
                                    </div>
                                    <div class="mb-3">
                                        <label for="phone">Phone Number <span class="error">*</span></label>
                                        <input type="number" required name="phone" id="phone" class="p-2 col-lg-6 col-6 form-control" max="9999999999" pattern="/[0-9]{10}/" placeholder="Enter your Phone Number (to send OTP)" value="<?php echo $phone; ?>" <?php if ($is_otp_verified) { echo "readonly"; } ?>>
                                    </div>
                                    <div class="mb-3">
                                        <label for="">Gender <span class="error">*</span></label>
                                        <select id="gender" name="gender" class="form-control">
                                            <?php foreach($row_gender as $gender){ ?>
                                                <option value="<?php echo $gender["id"]; ?>" <?php echo ($gender == $gender["id"]?"selected":""); ?>><?php echo $gender["name"]; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="">Reason For Visit <span class="error">*</span></label>
                                        <textarea required name="visiting_reason" id="visiting_reason" class="p-2 col-lg-6 col-6 form-control" placeholder="Reason" <?php if ($is_otp_verified) { echo "readonly"; } ?>><?php echo $visiting_reason; ?></textarea>
                                    </div>
                                    <?php if ($is_otp_verified == 0 && $is_send_otp == 1) { ?>
                                    <div class="mb-3">
                                        <label for="">OTP Code <span class="error">*</span></label>
                                        <input type="text" required name="otp_code" class="p-2 col-lg-6 col-6 form-control" placeholder="Enter your OTP Code" value="">
                                        <label class=" p-2" style="float: right;"><a href="javascript:void(0);" id="resend_otp_verification"> Resend OTP </a></label>
                                    </div>
                                    <?php } ?>
                                    <?php if ($is_otp_verified == 1 && $booking_type == 3) { ?>
                                    <div class="row">
                                        <div class="radio">
                                            <label>
                                                <input id="razorpay" type="radio" name="mode" value="online" checked="" required /> <img class="payment-logo" src="images/banktransfer.png" alt="Bank Transfer" /> Credit/Debit Card/Net Banking/UPI
                                            </label>
                                            <label>
                                                <input id="cod" type="radio" name="mode" value="cash" required /> <img class="payment-logo" src="images/cod.png" alt="Cash on Delivery" /> Pay Cash at Clinic
                                            </label>
                                        </div>
                                    </div>
                                    <?php } ?>
                                    <div class="text-center mt-4">
                                        <?php if ($is_otp_verified) { ?>
                                            <button id="rzp-button" class="submit-btn">Pay with Razorpay</button>
                                            <button id="cash-button" type="button" style="display:none;" class="submit-btn">Pay with Cash</button>
                                        <?php } else { ?>
                                            <button class="submit-btn" name="send_otp_btn" id="send_otp_btn" type="submit">Confirm with OTP</button>
                                        <?php } ?>
                                    </div>
                                    <div class="text-center mt-4">
                                        <div id="otp_verification_status"><?php echo $otp_message; ?></div>
                                    </div>
                                    <span id="msg" class="text-danger"></span>
                                </form>
                                
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<?php include_once('footer.php');?>

<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script type="text/javascript">
<?php if ($is_otp_verified) { ?>
    var options = <?php echo $json?>;
    options.handler = function(response) {
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
    document.getElementById('rzp-button').onclick = function(e) {
        rzp.open();
        e.preventDefault();
    }

<?php } ?>

$('#resend_otp_verification').click(function(){
    $("input[name='otp_code']").val('');
    $("input[name='otp_code']").removeAttr('required');
    $("#send_otp_btn").trigger("click");
});

$('input[name=mode]').click(function(){
    $('#cash-button,#rzp-button').hide();
    if($('input[name=mode]:checked').val() == 'cash'){
        $('#cash-button').show();
    } 
    if($('input[name=mode]:checked').val() == 'online'){
        $('#rzp-button').show();
    }
    $('#payment_mode').val($('input[name=mode]:checked').val());
});

$(document).ready(function(){
    $('input[type=number][max]:not([max=""])').on('input', function(ev) {
        var $this = $(this);
        var maxlength = $this.attr('max').length;
        var value = $this.val();
        if (value && value.length >= maxlength) {
            $this.val(value.substr(0, maxlength));
        }
    });
    if($('#family_member').val() != ''){
        $('#family_div').show();
    }
    $('input[name=booking_for]').click(function(){
        $('#family_div').hide();
        $('#family_member').prop('required', false);
        $('#family_member').val('');
        if($('input[name=booking_for]:checked').val() == 'family'){
            $('#family_div').show();
            $('#family_member').prop('required', true);
        }
    });
    // $('#family_member').change(function(){
    //     var family = $( "#family_member option:selected" ).text();

    // });
});

$('body').on('click', '#cash-button', function(e) {
    document.getElementById('cash-button').onclick = function(e) {
        document.razorpayform.submit();
    }
});

$("#phone, #email").on("keyup",function(){

    var email = $('#email').val();
    var phone = $('#phone').val();
    if(email && phone){
        $.ajax({
            type: 'POST',
            url: './includes/functions.php?action=checkEmailPhone',
            data: {
                email:email, 
                phone:phone
            },
            success : function(res){
                const obj = JSON.parse(res);
                $('#send_otp_btn').prop('disabled', false);
                $('#send_otp_btn').css({'cursor': 'pointer', "background-color": "#0d6efd", "color":"#fff"});
                $('#msg').text('');

                if(obj.msg != '1'){
                    $('#send_otp_btn').prop('disabled', true);
                    $('#send_otp_btn').css({'cursor': 'not-allowed', "background-color": "#d1d1d1", "color":"black"});
                    $('#msg').text(obj.msg);
                }
                console.log(obj.msg);
            }
        });
    } else{
        $('#send_otp_btn').prop('disabled', false);
        $('#send_otp_btn').css({'cursor': 'pointer', "background-color": "#0d6efd", "color":"#fff"});
        $('#msg').text('');
    }
    return false;
});

</script>