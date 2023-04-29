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
$title = 'Clinic Update';
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
    if(isset($_GET['cid']) && $_GET['cid']!=""){

    $recvd = $_GET['cid'];
    $cid = base64_decode($recvd);
    $sql_clinic_detail = "SELECT * FROM clinic_details  WHERE user_id = $login_id and id=$cid";
    $res_clinic_detail = $db_connection->getDbHandler()->query($sql_clinic_detail);
    if($res_clinic_detail)
    {
        $row_clinic_detail = $res_clinic_detail->fetch();
    }


    }else {
        
        header('Location: profile-view');
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
                    <h1 class="website-detailhead f1 ft-32 fw-bold">Clinic Details</h1>
                </div>
                <div class="col-md-12 col-12 pt-3">
                <form id="clinicAdd" method="POST" novalidate>
                        <div class="row">
                            <div class="col-md-4">
                                    <div class="full-input p-2 col-md-12 me-4">
                                        <label for="exampleInputPassword1" class="form-label text-grey ft-14 mb-0">Clinic name*</label>
                                        <input type="text" name="name" value="<?php echo $row_clinic_detail['name'] ?>" required data-parsley-minlength="2" placeholder="Enter Clinic Name">
                                    </div>
                            </div>
                            <div class="col-md-4">
                                    <div class="full-input p-2 col-md-12 me-4">
                                        <label for="exampleInputPassword1" class="form-label text-grey ft-14 mb-0">Address</label>
                                        <input type="text" name="address" value="<?php echo $row_clinic_detail['address'] ?>" required data-parsley-minlength="4" placeholder="Enter Clinic Address">
                                    </div>
                            </div>
                            <div class="col-md-4">
                                    <div class="full-input p-2 col-md-12 me-4">
                                        <label for="exampleInputPassword1" class="form-label text-grey ft-14 mb-0">Clinic Contact Number*</label>
                                        <input type="text" name="clinic_phone" value="<?php echo $row_clinic_detail['contact_number'] ?>" required data-parsley-minlength="2" placeholder="Enter Clinic Contact Number">
                                    </div>
                            </div>
                            <div class="col-md-4  pt-3 ">
                                    <div class="full-input p-2 col-md-12 me-4">
                                        <label for="exampleInputPassword1" class="form-label text-grey ft-14 mb-0">Google Map Link</label>
                                        <input type="text" name="map_link" value="<?php echo $row_clinic_detail['google_map_link'] ?>" required data-parsley-minlength="4" placeholder="Enter Google Map Link">
                                    </div>
                            </div>
                            
                            <div class="col-md-12 pb-4 pt-5 pt-md-4">
                                <h1 class="website-detailhead f1 ft-24 fw-bold">Time Slots</h1>
                                <div class="col-md-12">
                                    <div class="p-2 col-md-12 me-4">
                                        <textarea name="time_slot" required placeholder="Enter time slot"><?php echo $row_clinic_detail['time_slot'] ?>"</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 text-center pt-5 pb-5">
                                <div id="clinicStatus">
                                    <input type="hidden" name="clinicid" value="<?php echo $row_clinic_detail['id'] ?>" />
                                    <button class="submit-btn" type="submit">Save And Update</button>
                                </div>
                            </div>                                                
                        </div>
                    </form>
                    <div id="clinicAddStatus"></div>
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
        $("#clinicAdd").submit(function(e){
            e.preventDefault();
            if ( $(this).parsley().isValid() )
            {
                var formData = new FormData(this);
                $.ajax({
                    type: 'POST',
                    url: './includes/functions.php?action=clinic_update',
                    data: formData,
                    cache: false,
                    processData: false,
                    contentType: false,
                    beforeSend: function(){
                        $('#clinicAddStatus').html('<p class="text-center"><i class="fa fa-spinner fa-spin"></i> Please wait as we process..</p>').fadeIn();
                    },
                    success : function(res){
                       
                            $('#clinicAddStatus').html('');
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
                });
            }
            return false;
        });
    })
    </script>

</body>
</html> 