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
$title = 'Website Update';
$keywords = 'Profrea';
$description = 'Profrea';
$page = "profile";
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
    
    $sql_website_detail = "SELECT * FROM website_details  WHERE user_id = $login_id";
    $res_website_detail = $db_connection->getDbHandler()->query($sql_website_detail);
    if($res_website_detail)
    {
        $row_website_detail = $res_website_detail->fetch();
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
                    <h1 class="website-detailhead f1 ft-32 fw-bold">Website Details</h1>
                </div>
                <div class="col-md-12 col-12 pt-3">
                    <form id="websiteForm" method="POST" novalidate>
                        <div class="col-md-12 pt-5">
                            <h6 class="website-edithead ft-16 mb-0">Domain Name</h6>
                            <div class="row pt-3 align-items-center">
                                <div class="col-md-2 col-8 websiteformfield">
                                    <input type="text" name='domain' class="p-2" required data-parsley-minlength="4" placeholder="Domain Name" value="<?php echo (!empty($row_website_detail)?$row_website_detail["domain"]:""); ?>">
                                </div>
                                <div class="col-md-9 col-4">
                                    <h6 class="ft-16 mb-0">.profrea.com</h6>                            
                                </div>
                                <div class="col-md-12 pt-2">
                                    <div class="text-grey ft-12">Don’t use special characters, numeric values</div>
                                </div>
                            </div>
                            <div class="row pt-5 socialmedia-formfield">
                                <div class="col-md-12 pb-3">
                                    <h6 class="website-edithead ft-16 mb-0">Social Media</h6>
                                </div>
                                <div class="col-lg-3 col-md-6 mb-3 mb-lg-0">
                                    <div class="row align-items-center">
                                        <div class="col-md-1 col-1">
                                            <i class="ft-16 fab fa-facebook-f text-grey text-center"></i>
                                        </div>
                                        <div class="col-md-10 col-8 websiteformfield">
                                            <input type="text" name='fbLink' value="<?php echo (!empty($row_website_detail)?$row_website_detail["fb_link"]:""); ?>" class="p-2"  placeholder="Facebook Profile Link">
                                        </div>
                                        
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6 mb-3 mb-lg-0">
                                    <div class="row align-items-center">
                                        <div class="col-md-1 col-1">
                                            <i class="ft-16 fab fa-twitter text-grey text-center"></i>                                    
                                        </div>
                                        <div class="col-md-10 col-8 websiteformfield">
                                            <input type="text" name='twitterLink' class="p-2"  value="<?php echo (!empty($row_website_detail)?$row_website_detail["twitter_link"]:""); ?>" placeholder="Twitter Profile Link">
                                        </div>
                                        
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6 mb-3 mb-lg-0">
                                    <div class="row align-items-center">
                                        <div class="col-md-1 col-1">
                                            <i class="ft-16 fab fa-linkedin-in text-grey text-center"></i>
                                        </div>
                                        <div class="col-md-10 col-8 websiteformfield">
                                            <input type="text" name='inLink' value="<?php echo (!empty($row_website_detail)?$row_website_detail["linkedin_link"]:""); ?>" class="p-2"  placeholder="LinkedIn Profile Link">
                                        </div>
                                        
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6 mb-3 mb-lg-0">
                                    <div class="row align-items-center">
                                        <div class="col-md-1 col-1">
                                            <i class="ft-16 fab fa-instagram text-grey text-center"></i>
                                        </div>
                                        <div class="col-md-10 col-8 websiteformfield">
                                            <input type="text" name='instaLink' class="p-2"  value="<?php echo (!empty($row_website_detail)?$row_website_detail["insta_link"]:""); ?>" placeholder="Instagram Profile Link">
                                        </div>
                                        
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6 mb-3 mb-lg-0">
                                    <div class="row align-items-center pt-3">
                                        <div class="col-md-1 col-1">
                                            <i class="ft-16 fab fa-google text-grey text-center"></i>
                                        </div>
                                        <div class="col-md-10 col-8 websiteformfield ">
                                            <input type="text" name='google_review_link' class="p-2"  value="<?php echo (!empty($row_website_detail)?$row_website_detail["google_review_link"]:""); ?>" placeholder="Google Review Direct link">
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                            <div class="row pt-5 socialmedia-formfield">
                                <div class="col-md-6 pb-3">
                                    <h6 class="website-edithead ft-16 mb-0">Services</h6>
                                    <textarea name="service" class="form-control mt-3" placeholder="Enter Services what you can offer" id="floatingTextarea2" style="height: 200px"><?php echo (!empty($row_website_detail)?$row_website_detail["rowservice"]:""); ?></textarea>
                                </div>
                                <div class="col-md-6 pb-3">
                                    <h6 class="website-edithead ft-16 mb-0">Story</h6>
                                    <textarea name="story" class="form-control mt-3" placeholder="Tell Us About Yourself (Upto 300 words)" id="floatingTextarea2" style="height: 200px"><?php echo (!empty($row_website_detail)?$row_website_detail["story"]:""); ?></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 pb-5">
                            <div class="col-lg-12 text-lg-center">
                                <div id="websiteStatus">
                                    <input type="hidden" name="id" value="<?php echo $login_id; ?>" />
                                    <button class="submit-btn mt-md-2" type="submit">Save And Update</button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div id="websiteFormStatus"></div>
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
    <script>
    $(function() {        
        // Update Profile
        $("#websiteForm").submit(function(e){
            e.preventDefault();
            if ( $(this).parsley().isValid() )
            {
                var formData = new FormData(this);
                $.ajax({
                    type: 'POST',
                    url: './includes/functions.php?action=website_update',
                    data: formData,
                    cache: false,
                    processData: false,
                    contentType: false,
                    beforeSend: function(){
                        $('#websiteFormStatus').html('<p class="text-center"><i class="fa fa-spinner fa-spin"></i> Please wait as we process..</p>').fadeIn();
                    },
                    success : function(res){
                        if (res=='0')
                        {
                            $("#websiteForm")[0].reset();
                        }
                        else if (res=='1')
                        {
                            $('#websiteFormStatus').html('<p class="text-center text-danger">Error in Updating!</p>').fadeIn();
                        }
                        else if (res=='2')
                        {
                            $('#websiteFormStatus').html('<p class="text-center text-danger">Client already exist!</p>').fadeIn();
                        }
                        else if (res=='3')
                        {
                            $('#websiteFormStatus').html('<p class="text-center text-danger">Domain name already exist!</p>').fadeIn();
                        }
                        else
                        {
                            $('#websiteFormStatus').html('');
                            let resObj = JSON.parse(res);
                            Swal.fire({
                                icon: resObj.icon,
                                title: resObj.title,
                                text: resObj.msg,
                                // footer: '<a href="">Why do I have this issue?</a>'
                            }).then((result) => {
                                if (resObj.icon=='success') {
                                    window.location = "profile-view";
                                }                                
                            })
                            // $('#websiteStatus').html(`<button class="submit-btn" type="submit">Save And Update</button>`).fadeIn();
                            // window.location = "profile-view"
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