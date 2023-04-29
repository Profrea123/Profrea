<?php
require_once('src/Classes/Model/Database.php');
require_once('vendor/autoload.php');
use App\Classes\Model\Database;
use App\Classes\RealEstate\Spaces;
$db_conn = new Database;

require_once('src/Classes/Profrea/CountryState.php');
use App\Classes\Profrea\CountryStateCity;
$countryStateCity = new CountryStateCity();
$cityResult = $countryStateCity->getAllCity();
?>
<form class="pt-3 pb-4" id="spaceProviderForm" action=".\src\submit-basic-info" method="POST" novalidate>
    <div class="row pt-5">
        <div class="col-md-4">
            <div class="post-free-formbox">
                <h6 class="personal-details-head f1 pb-3">Space Details</h6>
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Type*</label>
                    <select id="space_type" name="space_type" required class="form-select" aria-label="Default select example">
                        <option value="Clinic"  selected>Clinic</option>
                        
                    </select>
                </div>
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">City*</label>
                    <select name="city" required class="form-select"  id="city-list" aria-label="Default select example">
                        <option value=""  selected>Enter space city</option>
                        <?php
                        foreach ($cityResult as $city) 
                        {
                            ?>
                            <option value="<?php echo $city["name"].",".$city["id"]; ?>"><?php echo $city["name"]; ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Location*</label>
                    <select required name="locality" autocomplete="off" id="locality-list" required class="form-control form-control-lg form-control-a" placeholder="Select Locality *">
                    </select>                    
                </div>
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Landmark*</label>
                    <input type="text" name="landmark" autocomplete="off" id="landmark-list" class="form-control form-control-lg form-control-a" placeholder="Enter Space Landmark *" required="">
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <h6 class="personal-details-head f1 pt-4">Personal Details</h6>
            <div class="row pt-3">
                <div class='full-input p-2 col-md-5 me-4 mb-3'>
                    <label for="exampleInputPassword1" class="form-label text-grey ft-14 mb-0">Full Name *</label>
                    <input type="text" name='first_name' id="first_name" required data-parsley-minlength="4" placeholder="Enter Your full name">
                </div>
                <div class='full-input p-2 col-md-5 me-4 mb-3'>
                    <label for="exampleInputEmail1" class="form-label text-grey ft-14 mb-0">Email *</label>
                    <input type="text" id='email_Id' name='email_Id' required data-parsley-minlength="4" placeholder="Enter Your Email">
                </div>
                <div class='full-input p-2 col-md-5 me-4 mb-3'>
                    <label for="exampleInputPassword1" class="form-label text-grey ft-14 mb-0">Phone Number *</label>
                    <input type="text" id='phone_no' name='phone_no' required data-parsley-minlength="4" placeholder="Enter Your Phone Number">
                </div>
                <div class='full-input p-2 col-md-5 me-4 mb-3'>
                    <label for="exampleInputPassword1" class="form-label text-grey ft-14 mb-0">Alternative Number </label>
                    <input type="text" id='phone_no2' name='phone_no2' placeholder="Enter Your Alternative Number">
                </div>                
                <div class="col-md-7 ">
                    <div class="g-recaptcha" data-sitekey="6LfX55EbAAAAAOfxrtASLUNG14LFhb39dNoPvGNG"></div>
                    <!--<input type="hidden" id="captcha-response" requried="" name="captcha-response" />-->
                </div>
                <div class="col-md-5 ">
                    <div class=" pt-5 pb-5 ">
                        <input type="hidden" name="page" value="<?php echo $_SERVER['REQUEST_URI']; ?>"/>
                        <input type="button" id="spaceProviderSubmit" class="text-decoration-none freepostbtn" value="Submit"/>
                    </div>
                </div>
                <div style="margin-top:20px">
                    <div id="success" style="display:none;color:green;">Thank you for your interest. We will be in touch with you soon.</div>
                    <div id="error" style="display:none;color:red;">Problem submitting your request, Please try again later.</div>
                </div>
            </div>
        </div>
    </div>
</form>