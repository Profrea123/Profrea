<form class="pt-3" id="forgetpasswordForm" action="#" method="POST" novalidate autocomplete="off" data-parsley-validate>
    <!-- <div class='full-input p-2 ps-4 mb-3 w-100'>
        <label for='phone' class="form-label text-grey ft-14 mb-0">Mobile Number</label>
        <input type='phone' name='phone' id='phone' placeholder="Enter Registered Mobile Number" required="">
    </div> -->
    <div class='full-input p-2 ps-4 mb-3 w-100'>
        <label for='username' class="form-label text-grey ft-14 mb-0">Email / Phone</label>
        <input type='text' name='username' id='username' data-parsley-emailorphone placeholder="Enter Registered Email / Phone" required="">
    </div>
    <div id="otp_box" style="display: none;">
        <div class='full-input p-2 ps-4 mb-3 w-100'>
            <label for="otp" class="form-label text-grey ft-14 mb-0">OTP</label>
            <input type="otp" name='otp' id='otp' placeholder="Enter Your OTP"></input>
        </div>
        <label id="resendotp" data-from="forgotpassword" style="float: right;">Resend OTP</label>
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
<div id="forgetpasswordForm_status"></div>
<div id="resend_status"></div>
<div class="mob-align-center">
    <a href="login"><i class="fa fa-arrow-alt-circle-left"></i> Back to Login</a>
</div>