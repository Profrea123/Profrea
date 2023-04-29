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
    $sql_holiday = "SELECT * FROM holidays  WHERE doctor_id = $login_id and id=$cid";
    $res_holiday = $db_connection->getDbHandler()->query($sql_holiday);
    if($res_holiday)
    {
        $row_holiday = $res_holiday->fetch();
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
                    <h1 class="website-detailhead f1 ft-32 fw-bold">Edit Holiday</h1>
                </div>
                <div class="col-md-12 col-12 pt-3">
                    <form id="holiday" method="POST" novalidate>
                        <div class="row">
                        <div class="col-md-4">
                                <div class="full-input p-2 col-md-12 me-4" style="position: relative;">
                                    <label for="" class="form-label text-grey ft-14 mb-0">From Date*</label>
                                    <input type="text" value="<?php echo date('d-m-Y', strtotime($row_holiday['from_date']));?>" name="from_date" required class="form-control date_from" placeholder="">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="full-input p-2 col-md-12 me-4" style="position: relative;">
                                    <label for="" class="form-label text-grey ft-14 mb-0">To Date*</label>
                                    <input type="text" value="<?php echo date('d-m-Y', strtotime($row_holiday['to_date']));?>" name="to_date" required class="form-control date_to" placeholder="">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="full-input p-2 col-md-12 me-4">
                                    <label for="" class="form-label text-grey ft-14 mb-0">Schedule Type*</label>
                                    <select name="schedule_type" class="form-control" id="" required>
                                        <option value="emergency" <?php if($row_holiday['schedule_type'] == 'emergency') { echo 'selected';}?>>Emergency</option>
                                        <option value="out_of_station" <?php if($row_holiday['schedule_type'] == 'out_of_station') { echo 'selected';}?>>Out Of Station</option>
                                        <option value="holiday" <?php if($row_holiday['schedule_type'] == 'holiday') { echo 'selected';}?>>Holiday</option>
                                        <option value="personal_leave" <?php if($row_holiday['schedule_type'] == 'personal_leave') { echo 'selected';}?>>Personal Leave</option>
                                        <option value="other" <?php if($row_holiday['schedule_type'] == 'other') { echo 'selected';}?>>Other</option>
                                    </select> 	
                                </div>
                            </div>
                            <div class="col-md-4 pt-3">
                                <div class="full-input p-2 col-md-12 me-4">
                                    <label for="" class="form-label text-grey ft-14 mb-0">Status*</label>
                                    <select name="status" class="form-control" id="" required>
                                        <option value="1" <?php if($row_holiday['status'] == '1') { echo 'selected';}?>>Active</option>
                                        <option value="0" <?php if($row_holiday['status'] == '0') { echo 'selected';}?>>In-Active</option>
                                     </select> 	
                                </div>
                            </div>
                            <div class="col-md-4  pt-3 ">
                                <div class="full-input p-2 col-md-12 me-4">
                                    <label for="" class="form-label text-grey ft-14 mb-0">Reason</label>
                                    <textarea name="reason" class="form-control" id=""><?php echo $row_holiday['reason']?> </textarea>
                                 </div>
                            </div>
                            <div class="col-md-12 text-center pt-5 pb-5">
                                <div id="clinicStatus">
                                    <input type="hidden" name="holidayid" value="<?php echo $row_holiday['id'] ?>" />
                                    <button class="submit-btn" type="submit">Save And Update</button>
                                </div>
                            </div>                                                
                        </div>
                    </form>
                    <div id="holidayAddStatus"></div>
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
    $('.date_from').datetimepicker({
        format: 'DD-MM-YYYY',
        minDate:new Date()
    });
    $('.date_to').datetimepicker({
        format: 'DD-MM-YYYY',
        minDate:new Date()
    });
    $(function() {
        // Update Profile
        $("#holiday").submit(function(e){
            e.preventDefault();
            if ( $(this).parsley().isValid() )
            {
                var formData = new FormData(this);
                $.ajax({
                    type: 'POST',
                    url: './includes/functions.php?action=holiday_update',
                    data: formData,
                    cache: false,
                    processData: false,
                    contentType: false,
                    beforeSend: function(){
                        $('#holidayAddStatus').html('<p class="text-center"><i class="fa fa-spinner fa-spin"></i> Please wait as we process..</p>').fadeIn();
                    },
                    success : function(res){
                       
                            $('#holidayAddStatus').html('');
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