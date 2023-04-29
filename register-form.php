<?php
require_once('src/Classes/Model/Database.php');
use App\Classes\Model\Database;
$db_connection = new Database;
$sql_profession_types = "SELECT id as value,name as label FROM profession_type WHERE rowstate = 1 ORDER BY name desc";
$con_profession_types = $db_connection->getDbHandler()->query($sql_profession_types);
if($con_profession_types)
{
    $res_profession_types = $con_profession_types->fetchAll();
}
?>
<form class="pt-3 pb-4" id="registerForm" action="#" method="POST" novalidate autocomplete="off" data-parsley-validate>
    <div class='full-input p-2 ps-4 mb-3 w-100'>
        <label for='name' class="form-label text-grey ft-14 mb-0">Name</label>
        <input type='text' name='name' id='name' placeholder="Enter Name" required="">
    </div>
    <div class='full-input p-2 ps-4 mb-3 w-100'>
        <label for='email' class="form-label text-grey ft-14 mb-0">Email</label>
        <input type='email' name='email' id='email' placeholder="Enter Email" required="">
    </div>
    <div class='full-input p-2 ps-4 mb-3 w-100'>
        <label for='phone' class="form-label text-grey ft-14 mb-0">Mobile Number</label>
        <input type='number' name='phone' id='phone' max="9999999999" pattern="/[0-9]{10}/" placeholder="Enter Mobile Number" required="">
    </div>
    <div class='full-input p-2 ps-4 mb-3 w-100'>
        <label for='profession' class="form-label text-grey ft-14 mb-0">Profession</label>
        <select name="profession" id="profession" class="form-select" aria-label="Default select example">
            <?php
                foreach($res_profession_types as $row_value)
                {
                    ?>
                    <option value="<?php echo $row_value['value']; ?>"><?php echo $row_value['label']; ?></option>
                    <?php
                }
            ?>
        </select>
    </div>
    <div id="password_box">
        <div class='full-input p-2 ps-4 mb-3 w-100'>
            <label for="password" class="form-label text-grey ft-14 mb-0">Password <span class="text-danger">* </span> </label>
            <input type="password" name='password' id='password' placeholder="Enter Your Password" required="" data-parsley-minlength="6" >
        </div>
    </div>
    <div id="otp_box" style="display: none;">
        <div class='full-input p-2 ps-4 mb-3 w-100'>
            <label for="otp" class="form-label text-grey ft-14 mb-0">OTP</label>
            <input type="otp" name='otp' id='otp' placeholder="Enter Your OTP"></input>
        </div>
        <label id="resendotp" data-from="register" style="float: right;">Resend OTP</label>
    </div>
    <div class="row pt-2 align-items-center">
        <div class="col-md-12 ">
            <div class="log-inbtnn w-100">
                <input type="hidden" name="page" value="<?php echo $_SERVER['REQUEST_URI']; ?>"/>
                <button type="submit" class="text-decoration-none log-inbtn">Send OTP</button>
            </div>
        </div>
    </div>
    <div style="margin-top:20px">
        <div id="success" style="display:none;color:green;">Thank you for your interest. We will be in touch with you soon.</div>
        <div id="error" style="display:none;color:red;">Problem submitting your request, Please try again later.</div>
    </div>
</form>
<div id="registerForm_status"></div>
<div id="resend_status"></div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.js"></script>
<script>
    $(function() {
        $('input[type=number][max]:not([max=""])').on('input', function(ev) {
            var $this = $(this);
            var maxlength = $this.attr('max').length;
            var value = $this.val();
            if (value && value.length >= maxlength) {
                $this.val(value.substr(0, maxlength));
            }
        });
    });
    </script>