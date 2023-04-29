<form class="pt-3" id="callbackForm" role="form" action="" method="post" data-parsley-validate="">
    <div class='full-input p-2 col-md-12 me-4 mb-3'>
        <label for="full_name" class="form-label text-grey ft-14 mb-0">Full Name *</label>
        <input type="text" name='full_name' value="<?php echo isset($username) && $username !=""?ucwords($username):""; ?>" required data-parsley-minlength="4" placeholder="Enter Your full name">
    </div>
    
    <div class='full-input p-2 col-md-12 me-4 mb-3'>
        <label for="phone" class="form-label text-grey ft-14 mb-0">Phone *</label>
        <input type="text" name='phone' value="<?php echo isset($mobileno) && $mobileno !=""?$mobileno:""; ?>" required data-parsley-minlength="10" data-parsley-type="digits" data-parsley-minlength="10" data-parsley-maxlength="10" placeholder="Enter Your Phone Number">
    </div>

    <!-- <div class='full-input p-2 col-md-12 me-4 mb-3'>
        <label for="profession" class="form-label text-grey ft-14 mb-0">Profession </label>
        <input type="text" name='profession' placeholder="Enter Your Profession">
    </div> -->
    <div class='full-input p-2 col-md-12 me-4 mb-3'>
        <label for="email" class="form-label text-grey ft-14 mb-0">E-Mail </label>
        <input type="email" name='email' value="<?php echo isset($useremail) && $useremail !=""?$useremail:""; ?>" placeholder="Enter Your Email Id">
    </div>

    <div class='full-input p-2 col-md-12 me-4 mb-3'>
        <label for="your_message" class="form-label text-grey ft-14 mb-0">Enquiry Details</label>
        <input type="text" name='your_message' placeholder="Enter Your Requirements">
       
    </div>
    <div class="row pt-2 align-items-center ">
        <div class="col-md-6 ">
            <div class="g-recaptcha" data-sitekey="6LfX55EbAAAAAOfxrtASLUNG14LFhb39dNoPvGNG"></div>
            <!--<input type="hidden" id="captcha-response" requried="" name="captcha-response" />-->
        </div>
        <div class="col-md-6 ">
            <div class="service-btn pt-5 ">
                <input type="hidden" name="page" value="<?php echo $_SERVER['REQUEST_URI']; ?>"/>
                <input type="hidden" name="enquiry_type" value="header-menu"/>
                <input type="submit" class="text-decoration-none requestbtn" value="Request a callback"/>
            </div>
        </div>
    </div>
    <div style="margin-top:20px">
        <div id="success" style="display:none;color:green;">Thank you for your interest. We will be in touch with you soon.</div>
        <div id="error" style="display:none;color:red;">Problem submitting your request, Please try again later.</div>
    </div>
</form>
<div id="callbackForm_status"></div>