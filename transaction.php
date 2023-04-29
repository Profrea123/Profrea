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
$title = 'Transactions';
$keywords = 'Profrea';
$description = 'Profrea';
$page="transaction";

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
            //header('Location: profile-update');
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

    $sql_transaction = "SELECT transactions.*,space_bookings.booking_code FROM transactions
        LEFT JOIN space_bookings ON space_bookings.id = transactions.booking_id
        WHERE space_bookings.user_id = $login_id";
    $res_transaction = $db_connection->getDbHandler()->query($sql_transaction);
    if($res_transaction)
    {
        $row_transaction = $res_transaction->fetchAll();
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
                    <h1 class="website-detailhead f1 ft-32 fw-bold">Transaction Details</h1>
                </div>
                <div class="col-md-12 col-12 pt-3">
                    <table class="table" id="transactionTable">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Booking Code</th>
                                <th>Transaction On</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 0;
                            foreach($row_transaction as $transaction)
                            {
                                $i++;
                                ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $transaction["booking_code"]; ?></td>
                                    <td><?php echo $transaction["created_at"]; ?></td>
                                    <td><?php echo $transaction["status"]; ?></td>
                                </tr>
                                <?php 
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
    <!-- detbuttonil section ended -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.js"></script>
    <script src="js/bootstrap.popper.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/font-awesome.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript">
    $(function() {        
        $('#transactionTable').dataTable( {
            // "ajax": {
            //     "url": "data.json",
            //     "type": "POST"
            // }
        });
    });
    </script>

</body>
</html> 