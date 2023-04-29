<?php 
require_once('src/Classes/Model/Database.php');
require_once('vendor/autoload.php');
use App\Classes\Model\Database;
$db_connection = new Database;
if (version_compare(phpversion(), '5.4.0', '<')) {
    if(session_id() == '') {
        session_start();
    }
}
else
{
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
}
$title = 'Profile Update';
$keywords = 'Profrea';
$description = 'Profrea';
$page="profile";

if (isset($_SESSION['ap_profrea_login_id'])) 
{    
    $login_id = $_SESSION['ap_profrea_login_id'];    
    
    $sql_user = "SELECT users.*, gender.name AS gender, city.name AS city FROM users 
        LEFT JOIN gender ON gender.id = users.gender_id 
        LEFT JOIN city ON city.id = users.city 
        LEFT JOIN operating_specialty AS os ON os.id = users.speciality
        WHERE users.id = $login_id";
    $res_user = $db_connection->getDbHandler()->query($sql_user);
    if($res_user)
    {
        $row_user = $res_user->fetch();        
        if($row_user["profession_id"] == 1 && $row_user["rowstate"] == 0){
           // header('Location: profile-update');
        }
        if($row_user['profile_picture']!=''){
            $profile_picture = $row_user['profile_picture'];
        }
        else{
            if($row_user['gender_id']==1){
                $profile_picture = "male.png";
            }
            else{
                $profile_picture = "female.png";
            }
        }
    }

    $sql_gender = "SELECT * FROM gender";
    $res_gender = $db_connection->getDbHandler()->query($sql_gender);
    if($res_gender)
    {
        $row_gender = $res_gender->fetchAll();
    }
    
    $sql_city = "SELECT * FROM city";
    $res_city = $db_connection->getDbHandler()->query($sql_city);
    if($res_city)
    {
        $row_city = $res_city->fetchAll();
    }
    
    $sql_speciality = "SELECT * FROM operating_specialty  WHERE space_type_id = ".$row_user["profession_id"];
    $res_speciality = $db_connection->getDbHandler()->query($sql_speciality);
    if($res_speciality)
    {
        $row_speciality = $res_speciality->fetchAll();
    }

}
else
{
    header('Location: login');
}

include_once("user_profile_header.php");

?>
    <!-- detail section started -->
    <section class="bg-updation">
        <div class="container">
            <div class="row pt-5 pb-5">
                <div class="col-md-12 col-12">
                    <h1 class="website-detailhead f1 ft-32 fw-bold">Profile Details</h1>
                </div>
                <div class="col-md-12 col-12 pt-3">
                    <form id="profileForm" method="POST" novalidate>
                        <div class="row">
                            <div class="col-lg-2 col-md-3 col-5 profile-membername">
                                <button class="file-upload">            
                                    <input type="file" name="profileImage" class="file-input ft-16" accept="image/png, image/gif, image/jpeg">Profile Image
                                </button>
                                <!-- <img src="images/w1.png" class="img-fluid" alt="" title=""> -->
                            </div>
                            <div class="col-lg-8 col-md-9 col-7">
                                <h2 class="top-namehead fw-bold f1"><?php echo $row_user["name"]; ?>,</h2>
                                <div class="row pt-3">
                                    <div class="full-input col-lg-3 col-md-3">
                                        <h6 class="top-stitle ft-14 text-grey">Phone</h6>
                                        <input type="number" id='phone' name='phone' max="9999999999" pattern="/[0-9]{10}/" required placeholder="Enter Your Phone Number" value="<?php echo $row_user["mobileNo"]; ?>" />
                                        <input type="hidden" id='rowstate' name='rowstate' required value="<?php echo $row_user["rowstate"]; ?>" />
                                        <input type="hidden" id='profession_id' name='profession_id' required value="<?php echo $row_user["profession_id"]; ?>" />
                                    </div>
                                    <div class="full-input col-lg-4 col-md-4">
                                        <h6 class="top-stitle ft-14 text-grey">Email</h6>
                                        <input type="text" id='email' name='email' required placeholder="Enter Your Phone Number" value="<?php echo $row_user["email"]; ?>" />
                                    </div>
                                    <div class="full-input col-lg-2 col-md-2">
                                        <h6 class="top-stitle ft-14 text-grey">Gender</h6>
                                        <select id="gender" name="gender" class="form-select" aria-label="Default select example">
                                            <?php foreach($row_gender as $gender){ ?>
                                                <option value="<?php echo $gender["id"]; ?>" <?php echo ($row_user["gender_id"] === $gender["id"]?"selected":""); ?>><?php echo $gender["name"]; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="full-input col-lg-3 col-md-2">
                                        <h6 class="top-stitle ft-14 text-grey">Location</h6>
                                        <select id="city" name="city" class="form-select" aria-label="Default select example">
                                            <?php foreach($row_city as $city){ ?>
                                                <option value="<?php echo $city["id"]; ?>" <?php echo ($row_user["city"] === $city["id"]?"selected":""); ?> ><?php echo $city["name"]; ?> </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <!-- <div class="col-md-3 pt-3">
                                        <div class="edit-sec text-blue"><i class="fas fa-pencil-alt pe-1 text-blue"></i> Edit Details </div>
                                    </div> -->
                                </div>
                            </div>
                        </div>
                        <?php if($row_user["profession_id"] == 1){ ?>
                        <div class="col-md-12 pt-5">
                            <div class="education-box p-4">
                                <h2 class="education-titlehead text-center ft-18 f1 fw-bold">Education And Experience Information</h2>
                                <div class="row pt-2">
                                    <div class="col-md-4">
                                        <div class='full-input p-2 col-md-12 me-4'>
                                            <label for="education" class="form-label text-grey ft-14 mb-0">Education Qualification</label>
                                            <input id="education" name="education" type="text" required data-parsley-minlength="2" placeholder="Enter Your Education Qualification" value="<?php echo (!empty($row_user)?$row_user["education"]:""); ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class='full-input p-2 col-md-12 me-4'>
                                            <label for="speciality" class="form-label text-grey ft-14 mb-0">Speciality *</label>
                                            <select id="speciality" name="speciality" class="form-select" aria-label="Default select example">
                                                <option value="" selected>Select Speciality</option>
                                                <?php foreach($row_speciality as $speciality){ ?>
                                                    <option value="<?php echo $speciality["id"]; ?>" <?php echo (($row_user !== false) && ($speciality["id"] === $row_user["speciality"])?"selected":""); ?>><?php echo $speciality["name"]; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class='full-input p-2 col-md-12 me-4'>
                                            <label for="experiance" class="form-label text-grey ft-14 mb-0">Years of experience</label>
                                            <input id="experiance" name="experiance" type="text" required data-parsley-minlength="1" placeholder="Years of experience" value="<?php echo ($row_user !== false?$row_user["experience"]:""); ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 pt-5 pb-5">
                            <h2 class="education-titlehead ft-18 f1 fw-bold">Registration Information</h2>
                            <div class="row pt-3">
                                <div class="col-lg-3 col-4">
                                    <h6 class="file-uploadlabel text-grey ft-14">Submit a photo id</h6>                            
                                    <div class="row pt-2">
                                        <div class="col">
                                            <button class="file-upload">            
                                                <input id="photo_doc" name="photo_doc" type="file" class="file-input ft-16" accept="image/png, image/gif, image/jpeg, application/pdf">Choose Image
                                            </button>
                                        </div>
                                    </div>
                                </div> 
                                <div class="col-lg-3 col-4">
                                    <h6 class="file-uploadlabel text-grey ft-14">Submit dr. registration no.</h6>
                                    <div class="row pt-2">
                                        <div class="col">
                                            <button class="file-upload">            
                                                <input id="reg_doc" name="reg_doc" type="file" class="file-input ft-16" accept="image/png, image/gif, image/jpeg, application/pdf">Choose Image
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-4">
                                    <h6 class="file-uploadlabel text-grey ft-14">Indemnity bond</h6>
                                    <div class="row pt-2">
                                        <div class="col">
                                            <div>
                                                <button class="file-upload">            
                                                    <input id="indemnity_doc" name="indemnity_doc" type="file" class="file-input ft-16" accept="image/png, image/gif, image/jpeg, application/pdf">Choose Image 
                                                </button> 
                                                <p class="text-grey elselabel mb-0 pt-3 ft-14">If You don't have bond, <br>
                                                    Let Us know <a class="text-blue text-decoration-underline" href="contact"> Contact Us</a>
                                                </p>
                                            </div>                                   
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php } else { ?>
                        <div class="col-md-12 pt-5">
                            <div class="education-box p-4">
                                <h2 class="education-titlehead text-center ft-18 f1 fw-bold">Personal Information</h2>
                                <div class="row pt-2">
                                    <div class="col-md-12">                            
                                        <div class='full-input p-2 col-md-12 me-12'>
                                            <label for="education" class="form-label text-grey ft-14 mb-0">About</label><br/>
                                            <textarea id="about" name="about" class="form-control" required data-parsley-minlength="2" placeholder="Enter About Yourself" ><?php echo (!empty($row_user)?$row_user["about"]:""); ?></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                        <div class="col-md-12 pb-5">
                            <div class="col-lg-12 text-lg-center">
                                <div id="profileStatus">
                                    <input type="hidden" name="id" value="<?php echo $login_id; ?>" />
                                    <button class="submit-btn mt-md-2" type="submit">Save And Update</button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div id="profileFormStatus"></div>
                </div>
            </div>
        </div>
    </section>
    <!-- detbuttonil section ended -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
    <script src="js/bootstrap.popper.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/font-awesome.js"></script>
    <script src="js/parsley.min.js"></script>
    <script type="text/javascript">
    $(function() {
        $('input[type=number][max]:not([max=""])').on('input', function(ev) {
            var $this = $(this);
            var maxlength = $this.attr('max').length;
            var value = $this.val();
            if (value && value.length >= maxlength) {
                $this.val(value.substr(0, maxlength));
            }
        });
        $('.file-input').change(function(){
            var curElement = $('.image');
            // console.log(curElement);
            var reader = new FileReader();
            reader.onload = function (e) {
                // get loaded data and render thumbnail.
                curElement.attr('src', e.target.result);
            };
            // read the image file as a data URL.
            reader.readAsDataURL(this.files[0]);
        });
        // Update Profile
        $("#profileForm").submit(function(e){
            e.preventDefault();
            if ( $(this).parsley().isValid() )
            {
                var formData = new FormData(this);
                $.ajax({
                    type: 'POST',
                    url: './includes/functions.php?action=profile_update',
                    data: formData,
                    cache: false,
                    processData: false,
                    contentType: false,
                    beforeSend: function(){
                        $('#profileStatus').html('<p class="text-center"><i class="fa fa-spinner fa-spin"></i> Please wait as we process..</p>').fadeIn();
                    },
                    success : function(res){
                        if (res=='0')
                        {
                            $("#profileForm")[0].reset();
                        }
                        else if (res=='1')
                        {
                            $('#profileStatus').html('<p class="text-center text-danger">Error in Updating!</p>').fadeIn();
                        }
                        else if (res=='2')
                        {
                            $('#profileStatus').html('<p class="text-center text-danger">Client already exist!</p>').fadeIn();
                        }
                        else
                        {
                            let resObj = JSON.parse(res);
                            Swal.fire({
                                icon: resObj.icon,
                                title: resObj.title,
                                text: resObj.msg,
                                // footer: '<a href="">Why do I have this issue?</a>'
                            }).then((result) => {
                                window.location = "profile-view"
                            })
                            // $('#profileStatus').html(`<button class="submit-btn" type="submit">Save And Update</button>`).fadeIn();            
                        }
                    }
                });
            }
            return false;
        });
    })
    </script>

</body>
</html> 