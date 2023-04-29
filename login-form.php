<form class="pt-3 pb-4" id="loginForm" action="#" method="POST" novalidate autocomplete="off" data-parsley-validate>
   <!--  <div class='full-input p-2 ps-4 mb-3 w-100'>
        <label for='phone' class="form-label text-grey ft-14 mb-0">Mobile Number</label>
        <input type='phone' name='phone' id='phone' placeholder="Enter Registered Mobile Number" required="">
    </div> -->
    <div class='full-input p-2 ps-4 mb-3 w-100'>
        <label for='username' class="form-label text-grey ft-14 mb-0">Email / Phone</label>
        <input type='text' name='username' id='username' data-parsley-emailorphone placeholder="Enter Registered Email / Phone" required="">
    </div>
    <div id="password_box">
        <div class='full-input p-2 ps-4 mb-3 w-100'>
            <label for="password" class="form-label text-grey ft-14 mb-0">Password</label>
            <input type="password" name='password' id='password' placeholder="Enter Your Password">
        </div>
    </div>
    <div id="otp_box" style="display: none;">
        <div class='full-input p-2 ps-4 mb-3 w-100'>
            <label for="otp" class="form-label text-grey ft-14 mb-0">OTP</label>
            <input type="otp" name='otp' id='otp' placeholder="Enter Your OTP"></input>
        </div>
        <label id="resendotp" data-from="login" style="float: right;">Resend OTP</label>
    </div>
    <div class='p-2 ps-0 mb-3 w-100'>
        <input type="checkbox" name="otpcheck" id="otpcheck" style="width: auto;display: inline;">
        <label for="otpcheck" class="form-label text-grey ft-14 mb-0 ps-2"> Login with OTP </label>         
    </div>
    <div class="forgetpassword">
        <a href="forget-password">Forgot Password</a>
    </div>
    <div class="row pt-4 align-items-center ">
        <div class="col-md-4">
            <div class="log-inbtnn w-100">
                <input type="hidden" name="page" value="<?php echo $_SERVER['REQUEST_URI']; ?>"/>
                <button type="submit" class="text-decoration-none log-inbtn">Login</button>
            </div>
        </div>
        <div class="col-md-5 col-8 pt-4 pt-md-0">
            <h2 class="new-profrea f1">New To Profrea ?</h2>
            <a href="register">Sign Up Now</a>
        </div>
        <!-- <div class="col-md-3 col-4 signup">
            <a href="register"><u>Sign Up Now</u></a>
        </div> -->
    </div>
    <div style="margin-top:20px">
        <div id="success" style="display:none;color:green;">Thank you for your interest. We will be in touch with you soon.</div>
        <div id="error" style="display:none;color:red;">Problem submitting your request, Please try again later.</div>
    </div>
</form>
<div id="loginForm_status"></div>
<div id="resend_status"></div>