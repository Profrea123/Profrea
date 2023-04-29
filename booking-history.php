<?php 
date_default_timezone_set("Asia/Calcutta");
$title = "Booking History";
$description =  $keywords = "";
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
    $mobile_no              = $_GET["mobile_no"] ?? '';
    $booking_no             = $_GET["booking_no"] ?? '';
    $booking_date_filter    = $_GET["booking_date_filter"] ?? '';
    $booking_type           = $_GET["booking_type"] ?? '';
    $booking_status         = $_GET["booking_status"] ?? '';

    $per_page_record = 10;  // Number of entries to show in a page.   // Look for a GET variable page if not found default is 1.        
    if (isset($_GET["page"]) &&  $_GET["page"] != '' ) {
        $page  = $_GET["page"];
    }
    else {
        $page=1;
    }

    $start_from = ($page-1) * $per_page_record;

    $last_year  = date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s") . " - 1 year"));
    $today      = date("Y-m-d");
    // echo  $last_year; exit;

    $login_id = $_SESSION['ap_profrea_login_id'];
    $sql_log_user = $db_connection->getDbHandler()->query("SELECT id,name,profession_id,is_verified FROM users WHERE users.id = $login_id");
    $row_user = $sql_log_user->fetch();
    if($row_user)
    {
        if ($row_user['profession_id'] == 1) {
            
            if ($mobile_no != '' || $booking_no != '' || $booking_date_filter != '' || $booking_type != '' || $booking_status != ''  ) {
                $con_details    = $db_connection->getDbHandler()->query("SELECT booking_details.*,users.* FROM booking_details LEFT JOIN users ON booking_details.user_id = users.id WHERE booking_details.doctor_id=".$login_id." AND users.mobileNo  LIKE  '%$mobile_no%' AND booking_details.booking_no  LIKE  '%$booking_no%' AND booking_details.booking_date  LIKE  '%$booking_date_filter%' AND booking_details.booking_type  LIKE  '%$booking_type%' AND booking_details.booking_status LIKE '%$booking_status%' ORDER BY booking_details.id DESC LIMIT $start_from, $per_page_record");

                $con_records    = $db_connection->getDbHandler()->query("SELECT booking_details.*,users.* FROM booking_details LEFT JOIN users ON booking_details.user_id = users.id WHERE booking_details.doctor_id=".$login_id." AND users.mobileNo  LIKE  '%$mobile_no%' AND booking_details.booking_no  LIKE  '%$booking_no%' AND booking_details.booking_date  LIKE  '%$booking_date_filter%' AND booking_details.booking_type  LIKE  '%$booking_type%' AND booking_details.booking_status LIKE '%$booking_status%' ORDER BY booking_details.id DESC");
            } else {
                $con_details    = $db_connection->getDbHandler()->query("SELECT booking_details.*,users.* FROM booking_details LEFT JOIN users ON booking_details.user_id = users.id WHERE booking_details.doctor_id=".$login_id." AND booking_details.transaction_date >='$last_year' ORDER BY booking_details.id DESC LIMIT $start_from, $per_page_record");

                $con_records    = $db_connection->getDbHandler()->query("SELECT booking_details.*,users.* FROM booking_details LEFT JOIN users ON booking_details.user_id = users.id WHERE booking_details.doctor_id=".$login_id." AND booking_details.transaction_date>='$last_year' ORDER BY booking_details.id DESC");
            }

            $sql_holidays = "SELECT * FROM holidays WHERE doctor_id = $login_id AND from_date >= '$today' AND to_date <= '$today' ";
            $res_holidays = $db_connection->getDbHandler()->query($sql_holidays);
            
            if($res_holidays)
            {
                $row_holidays = $res_holidays->fetchAll();
            }

            // $con_users    = $db_connection->getDbHandler()->query("SELECT booking_details.*,users.* FROM booking_details LEFT JOIN users ON booking_details.user_id = users.id WHERE booking_details.doctor_id=".$login_id." GROUP BY booking_details.user_id ");
            // $res_users           = $con_users->fetchAll();
        } else {
            $con_details    = $db_connection->getDbHandler()->query("SELECT booking_details.*,users.* FROM booking_details LEFT JOIN users ON booking_details.doctor_id = users.id WHERE booking_details.user_id=".$login_id." AND booking_details.transaction_date >='$last_year' ORDER BY booking_details.id DESC LIMIT $start_from, $per_page_record");
            
            $con_records    = $db_connection->getDbHandler()->query("SELECT booking_details.*,users.* FROM booking_details LEFT JOIN users ON booking_details.doctor_id = users.id WHERE booking_details.user_id=".$login_id." AND booking_details.transaction_date >='$last_year' ORDER BY booking_details.id DESC");
        }
        
        $res_booking_details = $con_details->fetchAll();
        $res_booking_records = $con_records->fetchAll();

        $total_records =  count($res_booking_records);
           
        $total_pages = ceil($total_records / $per_page_record);     
        $pagLink = "";
    }
} else {
    header('Location: login');
}

include_once("user_profile_header.php");
?>
    <section class="bg-space-header">
        <div class="container">         
           <div class="row pt-5">
               <div class="col-md-10 text-center">
                   <h2 class="space-headtitle f1 fw-bold">Booking History</h2>
               </div>

               <?php if ($row_user['profession_id'] == 1 && count($row_holidays) == 0) { ?>
                    <div class="col-md-2 text-right">
                        <a href="booking-emergency-cancel" class="space-headtitle"><button class="bk_his_cancel_btn"><i class="fa fa-fire"></i> Emergency Cancel</button></a>
                    </div>
               <?php } ?>
            </div>
        </div>
        <div class="container">
            <div class="row align-items-center mt-3">
                <div class="col-xl-12 col-lg-12 col-md-6 mb-5">
                    <div class="card border-0 rounded shadow overflow-hidden">
                        <div class="card-body">
                            <!-- Filtration -->
                            <?php if ($row_user['profession_id'] == 1 ) {  ?>
                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="p-2 col-md-12 me-4">
                                            <label for="" class="form-label text-grey ft-14 mb-0">Mobile No</label>
                                            <input type="number" name="mobile_no" value="<?php echo $mobile_no ?? ''; ?>" id="mobile_no" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="p-2 col-md-12 me-4">
                                            <label for="" class="form-label text-grey ft-14 mb-0">Booking No</label>
                                            <input type="text" name="booking_no" value="<?php echo $booking_no; ?>" id="booking_no" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="p-2 col-md-12 me-4">
                                            <label for="" class="form-label text-grey ft-14 mb-0">Booking Date</label>
                                            <input type="text" name="booking_date" value="<?php echo $booking_date_filter; ?>" id="booking_date" class="form-control datepick">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="p-2 col-md-12 me-4">
                                            <label for="" class="form-label text-grey ft-14 mb-0">Booking Type</label>
                                            <select name="booking_type" id="booking_type"  class="form-control">
                                                <option value="">-- Select --</option>
                                                <option value="1" <?php echo $booking_type == 1 ? 'selected' : ''?>>Audio</option>
                                                <option value="2" <?php echo $booking_type == 2 ? 'selected' : ''?>>Video</option>
                                                <option value="3" <?php echo $booking_type == 3 ? 'selected' : ''?>>In-Clinic</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="p-2 col-md-12 me-4">
                                            <label for="" class="form-label text-grey ft-14 mb-0">Booking Status</label>
                                            <select name="booking_status" id="booking_status" class="form-control">
                                                <option value="">-- Select --</option>
                                                <option value="0" <?php echo $booking_status == 0 ? 'selected' : ''?>>Pending</option>
                                                <option value="1" <?php echo $booking_status == 1 ? 'selected' : ''?>>Completed</option>
                                                <option value="2" <?php echo $booking_status == 2 ? 'selected' : ''?>>Cancelled</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2 row">
                                        <div class="p-2 col-md-4 ">
                                            <button class="btn btn-primary mt-4 filter"><i class="fa fa-filter"></i></button>
                                        </div>
                                        <?php if ($mobile_no != '' || $booking_no != '' || $booking_date_filter != '' || $booking_type != '' || $booking_status != ''  ) {?>
                                            <div class="p-2 col-md-6  ">
                                                <a href='booking-history'><button class="btn btn-danger mt-4"><i class="fa fa-refresh"></i></button></a>
                                            </div>
                                        <?php } ?>
                                    </div>
                                        
                                </div>
                            <?php } ?>

                            <?php foreach($res_booking_details as $booking) { ?>
                            <div class="row align-center border-bottom-dashed mt-2">
                                <div class="col-xl-1 col-lg-1 col-md-3 text-center">
                                    <img <?php if($booking['profile_picture'] != '' && file_exists("datafiles/uploads/profiles/".$booking['profile_picture'])) {?> src="datafiles/uploads/profiles/<?php echo $booking['profile_picture'];?>" <?php } else { ?> src="images/no-image.png"<?php } ?> class="img-fluid doctor-list-img" alt="">
                                </div>
                                <?php if ($row_user['profession_id'] == 1) { ?>
                                <div class="col-xl-7 col-lg-7 col-md-6 mb-3">
                                    <?php if($booking['booking_status'] == 0) { ?>
                                        <h5 class="d-block mb-0 doc-name"><?php echo $booking['name'] ?? '';?><i class="bk_pending">Pending</i></h5>
                                    <?php } elseif($booking['booking_status'] == 1){ ?>
                                        <h5 class="d-block mb-0 doc-name"><?php echo $booking['name'] ?? '';?><i class="bk_completed">Completed</i></h5>
                                    <?php } else { ?>
                                        <h5 class="d-block mb-0 doc-name"><?php echo $booking['name'] ?? '';?><i class="bk_cancelled">Cancelled</i></h5>
                                    <?php } ?>
                                    <h6 class="title text-dark d-block mb-0">Booking Date: <?php echo $booking['booking_date'] ?? '';?></h6>
                                    <h6 class="title text-dark d-block mb-0">Booking Time: <?php echo $booking['booking_time'] ?? '';?></small>
                                </div>
                                <?php } else { ?>
                                <div class="col-xl-7 col-lg-7 col-md-6 mb-3">
                                    <?php if($booking['booking_status'] == 0) { ?>
                                        <h5 class="d-block mb-0 doc-name">Dr.<?php echo $booking['name'] ?? '';?><i class="bk_pending">Pending</i></h5>
                                    <?php } elseif($booking['booking_status'] == 1){ ?>
                                        <h5 class="d-block mb-0 doc-name">Dr.<?php echo $booking['name'] ?? '';?><i class="bk_completed">Completed</i></h5>
                                    <?php } else { ?>
                                        <h5 class="d-block mb-0 doc-name">Dr.<?php echo $booking['name'] ?? '';?><i class="bk_cancelled">Cancelled</i></h5>
                                    <?php } ?>
                                    <small class="text-muted speciality"><?php echo $booking['education'] ?? '';?></small>
                                    <?php 
                                    $row_specialty = '';
                                    if($booking['speciality'] != '') {
                                        $sql_specialty = $db_connection->getDbHandler()->query("SELECT name FROM operating_specialty WHERE id = ".$booking['speciality']);
                                        $row_specialty = $sql_specialty->fetch();
                                    }
                                    if($row_specialty !='') {
                                    ?>
                                        <h6 class="text-muted speciality"><?php echo $row_specialty['name'] ?? '';?></h6>
                                    <?php } ?>
                                    <h6 class="title text-dark d-block mb-0">Booking Date: <?php echo $booking['booking_date'] ?? '';?></h6>
                                    <h6 class="title text-dark d-block mb-0">Booking Time: <?php echo $booking['booking_time'] ?? '';?></small>
                                </div>
                                <?php } ?>
                                <div class="col-xl-4 col-lg-4 col-md-6">
                                    <div class="">
                                        <?php  
                                            $current_date = strtotime(date('Y-m-d h:i A'));

                                            preg_match("/([0-9]+)/", $booking['time_duration'], $time_duration);
                                            $duration           = date('h:i A', strtotime('+'.$time_duration[0].'minutes', strtotime($booking['booking_time'])));
                                            $booking_duration   = strtotime($booking['booking_date'].$duration); 
                                            
                                            $booking_time       = date('h:i A', strtotime('-1 minutes', strtotime($booking['booking_time']))); 
                                            $booking_date       = strtotime($booking['booking_date'].$booking_time); ?>
                                        <!-- join Link -->
                                        <?php if( $current_date >= $booking_date && $current_date < $booking_duration && $booking['booking_status'] == 0 ){ ?>
                                            <a href="video-call.php?channel=2222&token=006b0f2efac08d548239012af03cd1f5730IABivtcZSkkDXkhRgaTErKsdhs4h05s7HL9iEcvuNVjMCjnbLnkh39v0IgAO4gAAT5bSYgQAAQBXWNFiAwBXWNFiAgBXWNFiBABXWNFi"><button class="bk_his_join_link_btn"><i class="feather-link"></i> Join Link</button></a>
                                        <?php } ?>
                                        <!-- View  -->
                                        <a href="booking-details?booking=<?php echo $booking['booking_no'];?>"><button class="bk_his_view_btn"><i class="feather-eye"></i> View</button></a>
                                        <!-- Booking Cancel -->
                                        <?php if( $current_date < $booking_date  && $booking['booking_status'] == 0) { ?>
                                            <a href="javascript:void(0)" data-bs-toggle="modal" data-id="<?php echo $booking['booking_no'];?>" class="cancel" data-bs-target="#bookingCancel"><button class="bk_his_cancel_btn fs15"><i class="feather-trash-2"></i> Cancel</button></a>
                                        <?php } ?>
                                        <!-- Booking Status -->
                                        <?php if ($row_user['profession_id'] == 1 && $current_date >= $booking_date && $booking['booking_status'] == 0) { ?>
                                            <a href="javascript:void(0)" data-bs-toggle="modal" data-id="<?php echo $booking['booking_no'];?>" class="complete" data-bs-target="#bookingComplete"><button class="btn btn-warning fs15" style="border-radius: 25px;" ><i class="feather-alert-circle"></i> Status</button></a>
                                            <a href="javascript:void(0)" data-id="<?php echo $booking['booking_no'];?>" class="caseSheet"><button class="btn btn-info  text-light fs15" style="border-radius: 25px;" ><i class="feather-align-justify"></i> Case Sheet</button></a>
                                        <?php } ?>

                                     </div>
                                </div>
                                
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <div class="container">
                    <div class="row">
                        <input type="hidden" class="page" value="<?php  if($total_records > 10){ echo '1'; } else { echo $page;  } ?>">
                        <?php
                            if($total_records > 10){
                                $pagLink .= '<ul class="pagination justify-content-center">';
                                if($page>=2){
                                    $pagLink .= "<li class='page-item'><a class='page-link' href='booking-history.php?page=".($page-1)."&mobile_no=".$mobile_no."&booking_no=".$booking_no."&booking_date_filter=".$booking_date_filter."&booking_type=".$booking_type."&booking_status=".$booking_status."'>Prev</a></li>";
                                }
                                        
                                for ($i=1; $i<=$total_pages; $i++) {
                                    if ($i == $page) {
                                        $pagLink .= "<li class='page-item active'><a class='page-link' href='booking-history.php?page=".$i."&mobile_no=".$mobile_no."&booking_no=".$booking_no."&booking_date_filter=".$booking_date_filter."&booking_type=".$booking_type."&booking_status=".$booking_status."'>".$i."</a></li>";
                                    } else  {
                                        $pagLink .= "<li class='page-item'><a class='page-link' href='booking-history.php?page=".$i."&mobile_no=".$mobile_no."&booking_no=".$booking_no."&booking_date_filter=".$booking_date_filter."&booking_type=".$booking_type."&booking_status=".$booking_status."'>".$i."</a></li>";
                                    }
                                };
                                echo $pagLink;

                                if($page<$total_pages){
                                    echo "<li class='page-item'><a class='page-link' href='booking-history.php?page=".($page+1)."&mobile_no=".$mobile_no."&booking_no=".$booking_no."&booking_date_filter=".$booking_date_filter."&booking_type=".$booking_type."&booking_status=".$booking_status."'> Next </a></li>";
                                }

                                $pagLink .= "</ul> ";
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>  
                                            <!-- Booking Cancel -->
        <div class="modal fade" id="bookingCancel" tabindex="-1" aria-labelledby="scheduleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title f1 fw-bold ft-32 text-start" id="exampleModalLabel">Booking Cancel </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form  id="booking-cancel-form" role="form" action="" method="post" data-parsley-validate="">
                            <div class="full-input p-2 col-xl col-lg me-2 mb-3 w-100">
                                <label for="phone" class="form-label text-grey">Reason for cancellation*</label>    
                                <textarea id="phone" class="form-control" name="reason" required>  </textarea>        
                            </div>
                            <div class="row">
                                <div class="text-center">
                                    <input type="hidden" name="booking_no" id="booking_no">
                                    <button type="submit" class="btn btn-info requestbtn">Submit</button>
                                </div>
                            </div>
                        </form>
                        <div id="booking_status"></div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Booking Complete -->
        <div class="modal fade" id="bookingComplete" tabindex="-1" aria-labelledby="scheduleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title f1 fw-bold ft-32 text-start" id="exampleModalLabel">Status</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form  id="booking-complete-form" role="form" action="" method="post" data-parsley-validate="">
                            <div class="full-input p-2 col-xl col-lg me-2 mb-3 w-100">
                                <label for="phone" class="form-label text-grey">Booking Status*</label>    
                                <select name="booking_status" class="form-control">
                                    <option value="0">Pending</option>
                                    <option value="1">Completed</option>
                                </select>
                            </div>
                            <div class="row">
                                <div class="text-center">
                                    <input type="hidden" name="booking_no" id="booking_no">
                                    <button type="submit" class="btn btn-info requestbtn">Submit</button>
                                </div>
                            </div>
                        </form>
                        <div id="booking_complete"></div>
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
    });
</script>
<script>
    $(document).ready(function(){
      $('.filter').click(function (){
        var mobile_no               = $('#mobile_no').val();
        var booking_no              = $('#booking_no').val();
        var booking_date_filter     = $('#booking_date').val();
        var booking_type            = $('#booking_type').val();
        var booking_status          = $('#booking_status').val();
        var page                    = $('.page').val();

        var url = "booking-history"+'?page='+page+'&booking_no='+booking_no+'&booking_date_filter='+booking_date_filter+'&booking_type='+booking_type+'&booking_status='+booking_status+'&mobile_no='+mobile_no;
        window.location.href = url;
      });
    });
</script>

<script>
    $("#mydiv").load(location.href + " #mydiv");
</script>

<script>

    $(document).ready(function(){
        $('.cancel').click(function(){
            var cancel = $(this).data('id');
            $(".modal-body #booking_no").val( cancel );
        });
        $('.complete').click(function(){
            var complete = $(this).data('id');
            $(".modal-body #booking_no").val( complete );
        });
        $('.caseSheet').click(function(){
            var booking_no = $(this).data('id');
            var origin   = window.location.origin;   // Returns base URL (https://example.com)
            window.location.href = origin + '/admin/public/doctor/patient-case/'+ booking_no
        });
        
    });
    

</script>
    
