<?php 
error_reporting(1);
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
$title = 'Video Call'; 
$description = 'Profrea';
$page="dashboard";

if (isset($_SESSION['ap_profrea_login_id'])) 
{
    $login_id   = $_SESSION['ap_profrea_login_id'];    
    $sql_user   = "SELECT users.name,users.rowstate,users.mobileNo,users.email,users.profession_id as profession_id,city,gender_id,is_verified FROM users WHERE users.id = $login_id";
    $res_user   = $db_connection->getDbHandler()->query($sql_user);
    $profile_picture = "male.png";
    if($res_user)
    {
        $row_user = $res_user->fetch();
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
}
else
{
    header('Location: login');
}

include_once("user_profile_header.php");

?>
<link rel="stylesheet" href="css/feather.css">
<style>
.main-video {
    width: 50vw;
    height: 80vh;
    max-height: 100vh;
    border-radius: 8px;
    margin: 20px 12px 0 40px;
    background: #eee;
}
.local-video {
    width: 18vw;
    height: 25vh;    
    border-radius: 5px;
}
.timer {
    font-size: 16px;
    text-align: center;
    margin-top: 50px;
    margin-bottom: 10px;
}
.icons-set {
    display: flex;
    flex-direction: row;
    justify-content: center;
    align-items: center;
    margin: 30px;
}
.single-icon {
    margin: 10px;
}
.call-main-row{
    overflow: hidden !important;
}
</style>

    <section class="bg-updation">
        <div class="container pb-5">
            <div class="call-wrapper mt-50">
                <div class="call-main-row">
                    <div class="call-main-wrapper">
                        <div class="call-view">
                            <div class="call-window">
                                <div class="fixed-header">
                                    <div class="navbar">
                                        <div class="user-details">
                                            <div class="float-start user-img">
                                                <a class="avatar avatar-sm me-2" href="javascript:void(0)" title="Charlene Reed">
                                                    <img src="datafiles/uploads/profiles/<?php echo $profile_picture; ?>" alt="<?php echo $row_user['name'];?>" class="rounded-circle">
                                                    <span class="status online"></span>
                                                </a>
                                            </div>
                                            <div class="user-info float-start">
                                                <span><?php echo $row_user['name'];?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row" style="align-items: center;">
                                    <div class="col-md-9 main-video">
                                        <div class="main-video-frame" id="remote-video-frame">
                                        </div>
                                    </div>
                                    <div class="col-md-3" id="">
                                        <div class="timer" id="durationText"></div>
                                        <div class="local-video" id="local-video-frame"></div>
                                        <div class="timer-btn-container">
                                            <div class="icons-set">
                                                <div class="single-icon icon-mic">
                                                    <i onclick="microphoneToggle(this)" class="fa fa-solid fa-microphone" aria-hidden="true"></i>
                                                </div>
                                                <div class="single-icon icon-call">
                                                    <i onclick="callToggle(this)" class="fa fa-call fa-solid fa-phone" aria-hidden="true"></i>
                                                </div>
                                                <div class="single-icon icon-video">
                                                    <i onclick="videoToggle(this)" class="fa fa-solid fa-video" aria-hidden="true"></i>
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

    <script src="js/jquery.min.js" type="text/javascript"></script>
    <!-- bootstrap -->
    <script src="js/bootstrap.popper.min.js "></script>
    <script src="js/bootstrap.bundle.min.js "></script>
    <!-- font-awesome -->
    <script src="js/font-awesome.js "></script>    
    <script src="js/parsley.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
    <script src="js/custom.js"></script>

    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script src="vendor/agora/AgoraRTC_N-4.11.0.js"></script>
    <script src="vendor/agora/index.js"></script>
    <script>
       function microphoneToggle(x) {
            x.classList.toggle("fa-microphone-slash");
            toggleAudio();
        }

        function callToggle(x) {
            x.classList.toggle("fa-phone-slash");
            toggleCall();
        }

        function videoToggle(x) {
            x.classList.toggle("fa-video-slash");
            toggleVideo();
        }
  </script>

</body>
</html> 