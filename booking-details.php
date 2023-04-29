<?php 
date_default_timezone_set("Asia/Calcutta");
$title = "Booking Details";
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

    if($row_user !='' && isset($_GET['booking']))
    {
        
        $booking_no = $_GET['booking'];

        $sql_files = $db_connection->getDbHandler()->query("SELECT * FROM attachments WHERE booking_no = '$booking_no'");
        $files     = $sql_files->fetchAll();

        if ($row_user['profession_id'] == 1) {
            $sql_booking = $db_connection->getDbHandler()->query("SELECT booking_details.*,users.* FROM booking_details LEFT JOIN users ON booking_details.user_id = users.id  WHERE booking_details.doctor_id=".$login_id." AND booking_details.booking_no = '$booking_no'");
        } else {
            $sql_booking = $db_connection->getDbHandler()->query("SELECT booking_details.*,users.* FROM booking_details LEFT JOIN users ON booking_details.doctor_id = users.id  WHERE booking_details.user_id=".$login_id." AND booking_details.booking_no = '$booking_no'");
        }
        $booking = $sql_booking->fetch();

        if($booking['booking_for'] == 'family'){
            $sql_family = $db_connection->getDbHandler()->query("SELECT * FROM family_members WHERE id = ".$booking['family_member_id']."");
            $family     = $sql_family->fetch();
        }
    } else {
        header('Location: login');
    }
    $row_city ='';
    if($booking['city'] != ''){ 
        $sql_city = $db_connection->getDbHandler()->query("SELECT name FROM city WHERE id = ".$booking['city']);
        $row_city = $sql_city->fetch();
    }
    
}else{
    header('Location: login');
}

include_once("user_profile_header.php");
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
                                            <img src="images/check.png" alt="" class="check-mark-gif"> 
                                            <span>Booking Details</span>
                                            <a href="booking-history"><div class="float-right"><i class="feather-chevrons-left"></i> Back</div></a>
                                        </div> 
                                        <hr>
                                        <div class="pro-widget-content pl0">
                                            <div class="profile-info-widget">
                                                <img <?php if($booking['profile_picture'] != '' && file_exists("datafiles/uploads/profiles/".$booking['profile_picture'])) {?> src="datafiles/uploads/profiles/<?php echo $booking['profile_picture'];?>" <?php } else { ?> src="images/no-image.png"<?php } ?> class="img-fluid doctor-list-img" alt="">
                                                <div class="col-md-12">
                                                    <div class="row">
                                                        <?php if ($row_user['profession_id'] == 1) { ?>
                                                        <div class="col-md-7">
                                                            <div class="profile-det-info">
                                                                <div class="patient-details">
                                                                    <h3 class="d-block mb-0"><?php echo $booking['name'] ?? '';?></h3>
                                                                </div>
                                                                <div class="col-lg-12 mt-1">
                                                                    <div class="row">
                                                                        <div class="col-lg-6">
                                                                            <small class="text-muted speciality">Address</small>
                                                                            <h6 href="#" class="d-block mb-0 doc-name"><span><?php echo $booking['address'] .' '.($row_city ? $row_city['name'] : '-' ).''.$booking['pinCode'] .' '.$booking['state']; ?></h6>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                        <?php } else { ?>
                                                        <div class="col-md-7">
                                                            <div class="profile-det-info">
                                                                <div class="patient-details">
                                                                <h3 class="d-block mb-0">Dr.<?php echo $booking['name'] ?? '';?></h3>
                                                                    <div class="text-muted speciality"><?php echo $booking['education'] ?? '';?></div>
                                                                    <?php 
                                                                    $row_specialty = '';
                                                                    if($booking['speciality'] != ''){
                                                                        $sql_specialty = $db_connection->getDbHandler()->query("SELECT name FROM operating_specialty WHERE id = ".$booking['speciality']);
                                                                        $row_specialty = $sql_specialty->fetch();
                                                                    }
                                                                    if($row_specialty !='') {
                                                                    ?>
                                                                        <div class="text-muted speciality"><?php echo $row_specialty['name'] ?? '';?></div>
                                                                    <?php } ?>
                                                                    <div class="text-muted speciality">Experience <?php echo $booking['experience'];?></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <?php } ?>
                                                        <div class="col-md-3">
                                                            <!-- Join Link -->
                                                            <div class="">
                                                            <?php
                                                                $current_date = strtotime(date('Y-m-d h:i A'));
                                                                $duration           = date('h:i A', strtotime('+'.((int) $booking['time_duration']).'minutes', strtotime($booking['booking_time'])));
                                                                $booking_duration   = strtotime($booking['booking_date'].' '. $duration);

                                                                $booking_time = date('h:i A', strtotime('-1 minutes', strtotime($booking['booking_time']))); 
                                                                $booking_date = strtotime($booking['booking_date'].$booking_time);
                                                                    
                                                                if($booking['booking_status'] == 0 && $current_date < $booking_duration && $current_date >= $booking_date){ ?>
                                                                <!-- <a href="video-call?channel=<?php echo $booking['agora_channel_name']; ?>&token=<?php echo $booking['audio_video_token']; ?>"><button class="bk_his_join_link_btn fs15"><i class="feather-link"></i> Join Link</button></a> -->
                                                            <?php } ?>
                                                            <!-- Join Link -->
                                                                <?php if ($booking['booking_type'] != 3 && $booking['audio_video_token'] !='' && $booking['agora_channel_name'] !='') { ?>
                                                                    <a href="video-call?channel=<?php echo $booking['agora_channel_name']; ?>&token=<?php echo $booking['audio_video_token']; ?>"><button class="bk_his_join_link_btn fs15"><i class="feather-link"></i> Join Link</button></a>
                                                                <?php } ?>
                                                            </div>
                                                            <!-- Regenrate -->
                                                            <div class="mt-2">
                                                                <?php if ($row_user['profession_id'] == 1) { ?>
                                                                    <a href="javascript:void(0)" data-bs-toggle="modal" data-id="<?php echo $booking['booking_no'];?>" class="regenerate" data-bs-target="#bookingRegenerate"><button class="bk_his_regen_link_btn fs15"><i class="feather-refresh-cw"> </i> Regenerate</button></a>
                                                                <?php } ?>   
                                                            </div>
                                                            <!-- PostPone -->
                                                            <div class="mt-2">
                                                                <?php if ($row_user['profession_id'] == 1 && $current_date <= $booking_date && $booking['booking_status'] == 0) { ?>
                                                                    <a href="booking-postpone?booking=<?php echo  $booking['booking_no'];?>"><button class="btn btn-warning fs15" style="border-radius: 25px;" ><i class="feather-clock"></i> Postpone</button></a>
                                                                <?php } ?>
                                                            </div>
                                                            <!-- Attachments -->
                                                            <div class="mt-2">
                                                                <?php if ($row_user['profession_id'] == 5) { ?>
                                                                    <a href="javascript:void(0)" data-bs-toggle="modal" data-id="<?php echo $booking['booking_no'];?>" class="attachment" data-bs-target="#bookingAttachment"><button class="btn btn-warning fs15" style="border-radius: 25px;" ><i class="feather-file"></i> Files</button></a>
                                                                <?php } ?>
                                                            </div>
                                                            <!-- Booking Cancel -->
                                                            <div class="mt-2">
                                                                <?php if($current_date < $booking_date  && $booking['booking_status'] == 0) { ?>
                                                                    <a href="javascript:void(0)" data-bs-toggle="modal" data-id="<?php echo $booking['booking_no'];?>" class="cancel" data-bs-target="#bookingCancel"><button class="bk_his_cancel_btn fs15"><i class="feather-trash-2"></i> Cancel</button></a>
                                                                <?php } ?>
                                                            </div>
                                                            <!-- Booking Status -->
                                                            <div class="mt-2">
                                                                <?php if ($row_user['profession_id'] == 1 && $current_date >= $booking_date && $booking['booking_status'] == 0) { ?>
                                                                    <a href="javascript:void(0)" data-bs-toggle="modal" data-id="<?php echo $booking['booking_no'];?>" class="complete" data-bs-target="#bookingComplete"><button class="btn btn-warning fs15 text-light" style="border-radius: 25px;" ><i class="feather-alert-circle"></i> Status</button></a>
                                                                <?php } ?>
                                                            </div>
                                                            <!-- Booking Status -->
                                                            <div class="mt-2">
                                                            <?php if ($row_user['profession_id'] == 1) { ?>
                                                                <a href="javascript:void(0)" class="goForChatPatient" data-id="<?php echo $booking['booking_no'];?>"><button class="btn btn-info fs15 text-light" style="border-radius: 25px;" ><i class="fa fa-comments"></i> Chat with Patient </button></a>
                                                                <?php } ?>
                                                            </div>
                                                            <div class="mt-2">
                                                            <?php if ($row_user['profession_id'] == 5) { ?>
                                                                <a href="javascript:void(0)" class="goForChat" data-id="<?php echo $booking['booking_no'];?>"><button class="btn btn-info fs15 text-light" style="border-radius: 25px;" ><i class="fa fa-comments"></i> Chat with Doctor </button></a>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-lg-12">
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <small class="text-muted speciality">Consulting Date & Time</small>
                                                    <h6 href="#" class="d-block mb-0 doc-name"><?php echo date('d-M-Y',strtotime($booking['booking_date'])) ?? '';?> <?php echo $booking['booking_time'] ?? '';?></h6>
                                                </div>
                                                <div class="col-lg-6">
                                                    <small class="text-muted speciality">Consulting Duration Time</small>
                                                    <h6 href="#" class="d-block mb-0 doc-name"><?php echo $booking['time_duration'] ?? '';?></h6>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 mt-1">
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <small class="text-muted speciality">Booking For</small>
                                                    <h6 href="#" class="d-block mb-0 doc-name"><?php echo ucfirst($booking['booking_for'])  ?? '-';?></h6>
                                                </div>
                                                <?php if($booking['booking_for'] == 'family'){  ?>
                                                    <div class="col-lg-6">
                                                        <small class="text-muted speciality">Family Member</small>
                                                        <h6 href="#" class="d-block mb-0 doc-name"><?php echo $family?ucfirst($family['name']) : '-';?></h6>
                                                    </div>
                                                <?php } ?>
                                                <?php if($row_user['profession_id'] != 1){?>
                                                    <div class="col-lg-6">
                                                        <small class="text-muted speciality">Address</small>
                                                        <h6 href="#" class="d-block mb-0 doc-name"><span><?php echo $booking['address'] .' '.($row_city ? $row_city['name'] : '-' ).''.$booking['pinCode'] .' '.$booking['state']; ?></h6>
                                                    </div>
                                                <?php } ?>
                                                <div class="col-lg-6">
                                                    <small class="text-muted speciality">Reason for Visit</small>
                                                    <h6 href="#" class="d-block mb-0 doc-name"><?php echo $booking['visiting_reason'] ?? '-';?></h6>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Attachments -->
                                        <?php if(count($files) > 0) { ?>
                                            <hr>
                                            <h5 class="d-block mb-3 text-blue"><b>Attachments</b></h5>
                                            <div class="row">
                                                <?php foreach($files as $file){ $ext = pathinfo($file['attachment'], PATHINFO_EXTENSION);?>
                                                    <div class="col-md-3">

                                                        <?php if($ext == 'pdf') {?>
                                                            <iframe <?php if($file['attachment'] != '' && file_exists("datafiles/uploads/patient_attachments/".$file['attachment'])) {?> src="datafiles/uploads/patient_attachments/<?php echo $file['attachment'];?>" <?php } else { ?> src="images/no-image.png"<?php } ?> class="img-rounded" style="width:100%; height:100px;" alt=""></iframe>
                                                        <?php } else {?>
                                                            <img <?php if($file['attachment'] != '' && file_exists("datafiles/uploads/patient_attachments/".$file['attachment'])) {?> src="datafiles/uploads/patient_attachments/<?php echo $file['attachment'];?>" <?php } else { ?> src="images/no-image.png"<?php } ?> class="img-rounded" style="width:100%; height:100px;" alt="">
                                                        <?php } ?>
                                                        <!-- Delete -->
                                                        <?php if ($row_user['profession_id'] == 5) {?>
                                                            <a data-fileid="<?php echo $file["id"]; ?>" class="delAttachment" href="#"><button type="button" class="btn btn-sm btn-danger mt-2"><i class="feather-trash"></i></button></a>
                                                        <?php } ?>
                                                        <!-- View -->
                                                        <a target="_blank" <?php if($file['attachment'] != '' && file_exists("datafiles/uploads/patient_attachments/".$file['attachment'])) {?> href="datafiles/uploads/patient_attachments/<?php echo $file['attachment']; }?>"><button type="button" class="btn btn-sm btn-info mt-2"><i class="feather-eye"></i></button></a>
                                                   
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        <?php } ?>
                                    </div>
                                    
                                </div> 
                                <div class="col-xl-4 col-lg-4 col-md-4">
                                    <div class="row align-center shadow">
                                        <div class="col-xl-12 col-lg-12 col-md-12">
                                            <div class="row align-center bk_det_doc_section">
                                                <h5 class="booking-title-h51">Booking Slot Information</h5>
                                                <table class="table table-no-border">
                                                    <tr>
                                                        <td> Booking No</td>
                                                        <td class="text-end"> <?php echo $booking['booking_no'] ?? '';?></td>
                                                    </tr>
                                                    <tr>
                                                        <td> Booking Type</td>
                                                        <td class="text-end"> <?php if($booking['booking_type'] == 1) { echo 'Audio'; }elseif($booking['booking_type'] == 2) { echo 'Video'; } else{ echo 'In-Clinic'; }?></td>
                                                    </tr>
                                                    <tr>
                                                        <td> Booking Status</td>
                                                        <td class="text-end"> 
                                                            <?php if($booking['booking_status'] == 0) { ?>
                                                                <i class="bk_pending">Pending</i>
                                                            <?php } elseif($booking['booking_status'] == 1) { ?>
                                                                <i class="bk_completed">Completed</i>
                                                            <?php } else { ?>
                                                                <i class="bk_cancelled">Cancelled</i>
                                                            <?php } ?>
                                                         </td>
                                                    </tr>
                                                    <tr>
                                                        <td> Created At</td>
                                                        <td class="text-end"> <?php echo date('d-M-Y h:i A', strtotime($booking['transaction_date'])) ?? '';?></td>
                                                    </tr>
                                                </table>
                                            </div>                                                
                                        </div>
                                    </div>
                                    <div class="row align-center shadow mt-4">
                                        <div class="col-xl-12 col-lg-12 col-md-12">
                                            <div class="row align-center bk_det_doc_section">
                                                <h5 class="booking-title-h51">Payment Details</h5>
                                                <table class="table table-no-border table-no-mb">
                                                    <tr>
                                                        <td> Payment ID</td>
                                                        <td class="text-end"> <?php echo $booking['payment_id'] ?? '';?></td>
                                                    </tr>
                                                    <tr>
                                                        <td> Payment Mode</td>
                                                        <td class="text-end"> <?php echo ucwords($booking['payment_mode']) ?? '';?></td>
                                                    </tr>
                                                    <tr>
                                                        <td> Payment Status</td>
                                                        <td class="text-end"> 
                                                            <?php if($booking['payment_status'] == 1) { ?>
                                                                <i class="bk_completed">Paid</i>
                                                            <?php } else { ?>
                                                                <i class="bk_pending">Un Paid</i>
                                                            <?php } ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td> Sub total</td>
                                                        <td class="text-end"> ₹<?php echo $booking['sub_total'] ?? '';?></td>
                                                    </tr>
                                                    <tr>
                                                        <td> Taxes &amp; Charges</td>
                                                        <td class="text-end"> ₹<?php echo $booking['tax_amount'] ?? '';?></td>
                                                    </tr>
                                                    <tr class="table-amount-bg">
                                                        <td class="fw-900"> Total Amount</td>
                                                        <td class="text-end fw-900"> ₹<?php echo $booking['amount'] ?? '';?></td>
                                                    </tr>
                                                </table>
                                            </div>                                                
                                        </div>
                                    </div>
                                    <?php if($booking['booking_status'] == 2 && $booking['payment_mode'] != 'cash') { ?>
                                    <div class="row align-center shadow mt-4">
                                        <div class="col-xl-12 col-lg-12 col-md-12">
                                            <div class="row align-center bk_det_doc_section">
                                                <h5 class="booking-title-h51">Refund Details</h5>
                                                <table class="table table-no-border">
                                                    <tr>
                                                        <td> Refund Status</td>
                                                        <td class="text-end refund_pending_text">
                                                        <?php if($booking['refund_status'] == 1) { ?>
                                                                <i class="bk_completed">Settled</i>
                                                            <?php } else { ?>
                                                                <i class="bk_pending">Un settled</i>
                                                            <?php } ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td> Refund Date</td>
                                                        <td class="text-end"> <?php echo $booking['refund_date'] ?? '';?></td>
                                                    </tr>
                                                    <tr>
                                                        <td> Remarks</td>
                                                        <td class="text-end"> <?php echo $booking['refund_remarks'] ?? '';?></td>
                                                    </tr>
                                                </table>
                                            </div>                                                
                                        </div>
                                    </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        
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

                        <div class="modal fade" id="bookingRegenerate" tabindex="-1" aria-labelledby="bookingRegenerate" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title f1 fw-bold ft-32 text-start" id="exampleModalLabel">Token Regenrate </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                       <form  id="booking-regenerate-form" role="form" action="" method="post" data-parsley-validate="">
                                            <div class="full-input p-2 col-xl col-lg me-2 mb-3 w-100">
                                                <label for="phone" class="form-label text-grey">Time Duration*</label>    
                                                <select class="p-2 col-lg-6 col-6  form-control slot_interval" name="time_duration" required>
                                                    <?php for($i=1; $i <= 12; $i++) {
                                                        $time_increment         = $i * 5;
                                                        $slot_time_generation   = $time_increment .' MIN';
                                                    ?>
                                                        <option value="<?php echo $slot_time_generation;?>"><?php echo $slot_time_generation;?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <div class="row">
                                                <div class="text-center">
                                                    <input type="hidden" name="booking_no" id="booking_no">
                                                    <button type="submit" class="btn btn-info requestbtn">Submit</button>
                                                </div>
                                            </div>
                                       </form>
                                       <div id="booking_regenerate"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Booking Attachment -->
                        <div class="modal fade" id="bookingAttachment" tabindex="-1" aria-labelledby="scheduleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title f1 fw-bold ft-32 text-start" id="exampleModalLabel">Add Attachments</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form  id="booking-attachment-form" role="form" action="" method="post" enctype="multipart/form-data" data-parsley-validate="">
                                            <div class="full-input p-2 col-xl col-lg me-2 mb-3 w-100">
                                                <label for="phone" class="form-label text-grey">Attachment (png, jpg, jpeg, pdf)*</label>    
                                                <div class="row addNew ">
                                                    <div class="col-md-10 mb-3">
                                                        <input type="file" name="attachment[]" id="attachment" class="form-control file-input" accept="image/png, image/jpeg, image/jpg, application/pdf" required>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <button type="button" class="add_new btn btn-success rounded-circle"><i class="feather-plus-circle"></i></button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="text-center">
                                                    <input type="hidden" name="booking_no" id="booking_no">
                                                    <button type="submit" class="btn btn-info requestbtn">Submit</button>
                                                </div>
                                            </div>
                                        </form>
                                        <div id="booking_attachment"></div>
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

                    </div>
                </div>
            </div>
        </div>  
    </section> 

<?php include_once('footer.php');?>    
<script>
    
    $(function() {
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
    });

    $(document).ready(function(){
        $('.goForChatPatient').click(function(){
            var bookingId = $(this).data('id');
            var origin   = window.location.origin;   // Returns base URL (https://example.com)
            window.location.href = origin + '/admin/public/doctor/chat-list/'+ bookingId
        });

        $('.goForChat').click(function(){
            var bookingId = $(this).data('id');
            var origin   = window.location.origin;   // Returns base URL (https://example.com)
            window.location.href = origin + '/admin/public/user/chat-list/'+ bookingId
        });

        $('.cancel').click(function(){
            var cancel = $(this).data('id');
            $(".modal-body #booking_no").val( cancel );
        });

        $('.regenerate').click(function(){
            var regenerate = $(this).data('id');
            $(".modal-body #booking_no").val( regenerate );
        });

        $('.attachment').click(function(){
            var attachment = $(this).data('id');
            $(".modal-body #booking_no").val( attachment );
        });

        $('.complete').click(function(){
            var complete = $(this).data('id');
            $(".modal-body #booking_no").val( complete );
        });

        $('.chatNow').click(function(){
            var chatNow = $(this).data('id');
            $(".modal-body #chatNow").val( chatNow );
        });

        $(".add_new").click(function(){
            $(".addNew div:last").after('<div class="col-md-10 mb-3"><input type="file" name="attachment[]" accept="image/png, image/jpeg, image/jpg, application/pdf" class="form-control file-input" required></div><div class="col-md-2"><button type="button" class="btn btn-danger rounded-circle remove"><i class="feather-trash"></i></button></div>');
        });

        $(document).on('click', ".remove", function()
        {
            $(this).parent().prev().remove();
            $(this).parent().remove();
        });
    });

    $(".delAttachment").on("click",function(){

        var fileid = $(this).data("fileid");
        $.ajax({
            type: 'POST',
            url: './includes/functions.php?action=deleteAttachment',
            data: {fileid:fileid},
            success : function(res){
                let resObj = JSON.parse(res);
                Swal.fire({
                    icon: resObj.icon,
                    title: resObj.title,
                    text: resObj.msg,
                }).then((result) => {
                    location.reload();
                });
            }
        });  
        return false;
        });
    
</script>
    
