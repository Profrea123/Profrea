<?php
session_start();
require('config.php');
require('razorpay/Razorpay.php');
use Razorpay\Api\Api;
?>
<!DOCTYPE html>
<html>
<head>
    <title></title>
</head>
<body>
    <?php
    $api = new Api($keyId, $keySecret);
    $orderData = [
        'receipt'         => 3456,
        'amount'          => $_POST['amount'] * 100,
        'currency'        => $_POST['currency'],
        'payment_capture' => 1
    ];
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
        "name"              => $_POST['item_name'],
        "description"       => $_POST['item_description'],
        "image"             => "",
        "prefill"           => [
            "name"              => $_POST['cust_name'],
            "email"             => $_POST['email'],
            "contact"           => $_POST['contact'],
        ],
        "notes"             => [
            "address"           => $_POST['address'],
            "merchant_order_id" => "12312321",
        ],
        "theme"             => [
            "color"             => "#F37254"
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
    <button id="rzp-button1" class="btn btn-primary">Pay with Razorpay</button>    
    <form name='razorpayform' action="verify.php" method="POST">
        <input type="hidden" name="razorpay_payment_id" id="razorpay_payment_id">
        <input type="hidden" name="razorpay_signature"  id="razorpay_signature" >
    </form>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script>
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
    document.getElementById('rzp-button1').onclick = function(e){
        rzp.open();
        e.preventDefault();
    }
    </script>
</body>
</html>