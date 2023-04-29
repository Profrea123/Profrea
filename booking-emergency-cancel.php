<?php 
date_default_timezone_set("Asia/Calcutta");
$title = "Booking Postpone";
$description = "";
$keywords = "";
$page = 1;

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
if (isset($_SESSION['ap_profrea_login_id'])) 
{
    $login_id       = $_SESSION['ap_profrea_login_id'];
    $sql_log_user   = $db_connection->getDbHandler()->query("SELECT id,name,profession_id,is_verified FROM users WHERE users.id = $login_id");
    $row_user       = $sql_log_user->fetch();

    if($row_user['profession_id'] == 1)
    {
        
    } else {
        header('Location: login');
    }


}else{
    header('Location: login');
}

include_once('header-client.php');
?>
<section class="bg-space-header">
        <div class="container">
            <div class="row align-items-center mt-5">
                <div class="col-xl-12 col-lg-12 col-md-6 mb-5">
                    <div class="team border-0 rounded overflow-hidden">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-xl-8 col-lg-8 col-md-8 text-left">
                                    <div class="bk_det_doc_section shadow bk_det_doc_section_p20">
                                        <div class="check-mark-div">
                                            <span class="text-danger">Emergency Cancel</span>
                                            <a href="booking-history"><div class="float-right"><i class="fa fa-angle-double-left"></i> Back</div></a>
                                        </div> 
                                        <hr>
                                        <div class="pro-widget-content pl0">
                                            <div class="profile-info-widget">
                                                <div class="col-md-12">
                                                    <div class="row">
                                                    <form id="booking-emergency-cancel" method="POST" novalidate>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="full-input p-2 col-md-12 me-4">
                                                                    <label for="" class="form-label text-grey ft-14 mb-0">Date <span class="error">*</span></label>
                                                                    <input type="text" name="from_date" required class="form-control datepick" placeholder="">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="full-input p-2 col-md-12 me-4">
                                                                    <label for="" class="form-label text-grey ft-14 mb-0">Reason <span class="error">*</span></label>
                                                                    <textarea name="reason" class="form-control" id="" required> </textarea>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-12 text-center pt-5 pb-5">
                                                                <div id="holidayStatus">
                                                                    <button class="submit-btn" type="submit">Submit</button>
                                                                </div>
                                                            </div>
                                                            
                                                        </div>
                                                    </form>
                                                    <div id="booking_emergency"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> 

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>  
    </section> 
<?php include_once('footer.php');?>
<script src="js/moment-with-locales.min.js"></script> 
<script src="js/bootstrap-datetimepicker.min.js"></script> 

<script>
    $('.datepick').datetimepicker({
        format: 'YYYY-MM-DD',
        minDate:new Date()
    });
        // Booking Postpone
  $("#booking-emergency-cancel").submit(function(e){
    e.preventDefault();
    if ( $(this).parsley().isValid() )
    {
      var formData = new FormData(this);
      $.ajax({
        type: 'POST',
        url: './includes/functions.php?action=booking-emergency-cancel',
        data: formData,
        cache: false,
        processData: false,
        contentType: false,
        beforeSend: function(){
          $('#booking_emergency').html('<p class="text-center"><i class="fa fa-spinner fa-spin"></i> Please wait as we process..</p>').fadeIn();
        },
        success : function(res){
          let resObj = JSON.parse(res);
          Swal.fire({
            icon: resObj.icon,
            title: resObj.title,
            text: resObj.msg,
          }).then(function() {
            $('#booking_emergency').html("").fadeIn();
            window.location = "booking-history"
        })
        }
      });
    }
    return false;
  });
</script>