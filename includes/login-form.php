<form class="pt-3 pb-4" id="loginForm" action="#" method="POST" novalidate>
    <div class='full-input p-2 ps-4 mb-3 w-100'>
        <label for='phone' class="form-label text-grey ft-14 mb-0">Mobile Number</label>
        <input type='phone' name='phone' placeholder="Enter Registered Mobile Number"></input>
    </div>

    <div class='full-input p-2 ps-4 mb-3 w-100'>
        <label for="exampleInputPassword1" class="form-label text-grey ft-14 mb-0">Password</label>
        <input type="password" name='email' placeholder="Enter Your Password"></input>
    </div>

    <div class="forgetpassword">
        <a href="forget-password"><u>Forget Password</u></a>
    </div>
    <div class="row pt-2 align-items-center ">        
        <div class="col-md-12 ">
            <div class="log-inbtnn w-100 pt-5 ">
                <input type="hidden" name="page" value="<?php echo $_SERVER['REQUEST_URI']; ?>"/>
                <input type="submit" class="text-decoration-none log-inbtn" value="Log In"/>
            </div>
        </div>
    </div>
    <div style="margin-top:20px">
        <div id="success" style="display:none;color:green;">Thank you for your interest. We will be in touch with you soon.</div>
        <div id="error" style="display:none;color:red;">Problem submitting your request, Please try again later.</div>
    </div>
</form> 
