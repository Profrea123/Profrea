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
$title = 'Family Member Update';
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
    $sql_family_member = "SELECT * FROM family_members  WHERE user_id = $login_id and id=$cid";
    $res_family_member = $db_connection->getDbHandler()->query($sql_family_member);
    if($res_family_member)
    {
        $row_family_member = $res_family_member->fetch();
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
                    <h1 class="website-detailhead f1 ft-32 fw-bold">Family Member Details</h1>
                </div>
                <div class="col-md-12 col-12 pt-3">
                    <form id="familyMember" method="POST" novalidate>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="full-input p-2 col-md-12 me-4">
                                    <label for="exampleInputPassword1" class="form-label text-grey ft-14 mb-0">Full name*</label>
                                    <input type="text" name="name" value="<?php echo $row_family_member['name'];?>" required data-parsley-minlength="2" autocomplete="off" class="form-control" placeholder="Enter Full Name">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="full-input p-2 col-md-12 me-4" style="position: relative">
                                    <label for="exampleInputPassword1" class="form-label text-grey ft-14 mb-0">Date Of Birth*</label>
                                    <input type="text" name="dob" required data-parsley-minlength="4" value="<?php echo $row_family_member['dob'];?>"  id="datepick" class="form-control" placeholder="">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="full-input p-2 col-md-12 me-4">
                                    <label for="exampleInputPassword1" class="form-label text-grey ft-14 mb-0">Relation*</label>
                                    <select name="relation" class="form-control" id="" required>
                                        <option value="">-- Select --</option>
                                        <option value="father" <?php if($row_family_member['relation'] == 'father') { echo 'selected';}?>>Father</option>
                                        <option value="mother" <?php if($row_family_member['relation'] == 'mother') { echo 'selected';}?>>Mother</option>
                                        <option value="son" <?php if($row_family_member['relation'] == 'son') { echo 'selected';}?>>Son</option>
                                        <option value="daughter" <?php if($row_family_member['relation'] == 'daughter') { echo 'selected';}?>>Daughter</option>
                                        <option value="husband" <?php if($row_family_member['relation'] == 'husband') { echo 'selected';}?>>Husband</option>
                                        <option value="wife" <?php if($row_family_member['relation'] == 'wife') { echo 'selected';}?>>Wife</option>
                                        <option value="spouse" <?php if($row_family_member['relation'] == 'spouse') { echo 'selected';}?>>Spouse</option>
                                        <option value="brother" <?php if($row_family_member['relation'] == 'brother') { echo 'selected';}?>>Brother</option>
                                        <option value="sister" <?php if($row_family_member['relation'] == 'sister') { echo 'selected';}?>>Sister</option>
                                        <option value="grandfather" <?php if($row_family_member['relation'] == 'grandfather') { echo 'selected';}?>>Grandfather</option>
                                        <option value="grandmother" <?php if($row_family_member['relation'] == 'grandmother') { echo 'selected';}?>>Grandmother</option>
                                        <option value="uncle" <?php if($row_family_member['relation'] == 'uncle') { echo 'selected';}?>>Uncle</option>
                                        <option value="cousin" <?php if($row_family_member['relation'] == 'cousin') { echo 'selected';}?>>Cousin</option>
                                    </select>
                                    <!-- <input type="text" name="clinic_phone" required data-parsley-minlength="2" placeholder="Enter Clinic Contact Number"> -->
                                </div>
                            </div>
                            <div class="col-md-4  pt-3 ">
                                <div class="full-input p-2 col-md-12 me-4">
                                    <label for="exampleInputPassword1" class="form-label text-grey ft-14 mb-0">Gender*</label>
                                    <select name="gender" class="form-control" id="" required>
                                        <option value="">-- Select -- </option>
                                        <option value="male" <?php if($row_family_member['gender'] == 'male') { echo 'selected';}?>>Male</option>
                                        <option value="female" <?php if($row_family_member['gender'] == 'female') { echo 'selected';}?>>Female</option>
                                        <option value="other" <?php if($row_family_member['gender'] == 'other') { echo 'selected';}?>>Other</option>
                                    </select>
                                    <!-- <input type="text" name="map_link" required data-parsley-minlength="4" placeholder="Enter Google Map Link"> -->
                                </div>
                            </div>
                            <div class="col-md-12 text-center pt-5 pb-5">
                                <div id="clinicStatus">
                                    <input type="hidden" name="memberid" value="<?php echo $row_family_member['id'] ?>" />
                                    <button class="submit-btn" type="submit">Save And Update</button>
                                </div>
                            </div>                                                
                        </div>
                    </form>
                    <div id="memberAddStatus"></div>
                </div>
            </div>
        </div>
    </section>
    <!-- detbuttonil section ended -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.js"></script>
    <script src="js/bootstrap.popper.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/font-awesome.js"></script>
    
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
    <script src="js/parsley.min.js"></script>
    <script src="js/moment-with-locales.min.js"></script> 
    <script src="js/bootstrap-datetimepicker.min.js"></script>
    <script>
    $('#datepick').datetimepicker({
        format: 'DD-MM-YYYY',
    });
    $(function() {
        // Update Profile
        $("#familyMember").submit(function(e){
            e.preventDefault();
            if ( $(this).parsley().isValid() )
            {
                var formData = new FormData(this);
                $.ajax({
                    type: 'POST',
                    url: './includes/functions.php?action=family_member_update',
                    data: formData,
                    cache: false,
                    processData: false,
                    contentType: false,
                    beforeSend: function(){
                        $('#memberAddStatus').html('<p class="text-center"><i class="fa fa-spinner fa-spin"></i> Please wait as we process..</p>').fadeIn();
                    },
                    success : function(res){
                       
                            $('#memberAddStatus').html('');
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