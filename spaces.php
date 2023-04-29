<?php 
$title = "Profrea";
$description = "";
$keywords = "";
$page = 1;
include_once('header.php');

require_once('src/Classes/Model/Database.php');
require_once('vendor/autoload.php');
use App\Classes\Model\Database;
$db_connection = new Database;

// if(!array_key_exists('industry_id', $_GET) || (array_key_exists('industry_id', $_GET) && $_GET['industry_id'] == 'All' )){
//     $selected_industry_id = 'All';
    // $sql_space_types = "SELECT id,name FROM space_types WHERE rowstate = 1";
// } 
// elseif (array_key_exists('industry_id', $_GET)){
//     $selected_industry_id = $_GET['industry_id'];
//     $sql_space_types = "SELECT id,name FROM space_types WHERE id IN($selected_industry_id) AND rowstate = 1";
// }

// if(!array_key_exists('city_id', $_GET) || (array_key_exists('city_id', $_GET) && $_GET['city_id'] == 'All' )){
//     $selected_city_id = 'All';
// } 
// elseif (array_key_exists('city_id', $_GET)){
//     $selected_city_id = $_GET['city_id'];
// }

// if(!array_key_exists('location_id', $_GET) || (array_key_exists('location_id', $_GET) && $_GET['location_id'] == 'All' )){
//     $selected_location_id = 'All';
// } 
// elseif (array_key_exists('location_id', $_GET)){
//     $selected_location_id = $_GET['location_id'];
// }
$sql_space_types = "SELECT id,name FROM space_types WHERE rowstate = 1";
$con_space_types = $db_connection->getDbHandler()->query($sql_space_types);
if($con_space_types)
{
    $res_space_types = $con_space_types->fetchAll();
}
$sql_spec = "SELECT DISTINCT(speciality_operating) as speciality FROM spaces WHERE is_deleted = 0";
$con_spec = $db_connection->getDbHandler()->query($sql_spec);
$speciality_array = [];
if($con_spec)
{
    $res_spec = $con_spec->fetchAll();
    $spstring = "";
    $lop = 0;
    foreach($res_spec as $row_spec)
    {

        if($lop != 0)
            $spstring = $spstring.", ";

        $spstring = $spstring.$row_spec['speciality']; 
        $lop++;
    }
    $speciality_array = array_unique(explode(", ",$spstring));

}

$sql_city = "SELECT DISTINCT(city) as city FROM spaces WHERE is_deleted = 0";
$con_city = $db_connection->getDbHandler()->query($sql_city);
if($con_city)
{
    $res_city = $con_city->fetchAll();
}


// $sql_locality = "SELECT id,name FROM locality";
// $con_locality = $db_connection->getDbHandler()->query($sql_locality);
// if($con_locality)
// {
//     $res_locality = $con_locality->fetchAll();
// }
use App\Classes\RealEstate\Spaces;
$real_estate = new Spaces();
$selected_speciality ="";
if(isset($_GET["city_id"])){
    $selected_city_id = $_GET["city_id"];
    $selected_speciality = $_GET["speciality"];
    $allData = $real_estate->viewFilterDataNew($_GET["city_id"],$_GET["speciality"],$_GET["availtime"],$_GET["offset"]);
    $countData = $real_estate->viewFilterDataNew($_GET["city_id"],$_GET["speciality"],$_GET["availtime"],0,"true");

  


}
else{
    $selected_city_id = 'All';
    $allData = $real_estate->viewFilterDataNew();
    $countData = $real_estate->viewFilterDataNew("","","","",0,"true");
}
// echo $_POST["city_id"].$_POST["industry_id"];
// $_GET['city'],$_GET['locality'],$_GET['spacetype'] , $_GET['time']
// print_r($_POST);
// echo $_POST["city_id"];
?>
    <section class="bg-space-header">
        <div class="container">         
           <div class="row pt-5">
               <div class="col-md-12 text-center">
                   <h1 class="space-headtitle f1 fw-bold">Our Amazing Spaces</h1>
                   <p class="space-para pt-3 text-grey">Select your space & hours to operate</p>
               </div>
           </div>
        </div>
        <div class="container">
            <div class="row mt-5">                
                <div class="col-lg-12 col-sm-6 pl-4 col-offset-2 mb-3 mb-sm-0">
                    <div class="space-tabbar-inner">
                        <div class="row ps-3 grid-spacecontbox align-items-center">
                            <div class="col-md-4">
                            <div class="mb-3 ">
                                <label for="exampleInputEmail1" class="form-label">City</label>
                                <h6 class=" position-relative ft-16 text-grey <?php echo ($selected_city_id != "Gurgaon" && $selected_city_id != "Noida")?'active':''; ?>">
                                    <select name="other_city_id" id="other_city_id" class="filters form-select" aria-label="Default select example">
                                        <option value="All">All City</option>
                                        <?php
                                        $i = 0;
                                        foreach($res_city as $row_city1)
                                        {
                                            $i++;
                                            ?>
                                            <option value="<?php echo $row_city1['city']; ?>" <?php echo ($selected_city_id == $row_city1['city'])?'selected':''; ?>><?php echo $row_city1['city']; ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </h6>
                            </div>
                                <!-- <h6 class="tab-small-titlee position-relative ft-16 fw-bold mb-0 text-grey pt-2 pb-2">Select City :</h6> -->

                            </div>
                            <!-- <div class="col-md col-sm col">
                                <h6 class="tab-small-title position-relative ft-16 mb-0 text-grey pt-2 pb-2 <?php //echo ($_GET["city_id"] == "Gurgaon")?'active':''; ?> cityGurgaon">Gurgaon</h6>
                            </div>
                            <div class="col-md col-sm col">
                                <h6 class="tab-small-title position-relative ft-16 mb-0 text-grey pt-2 pb-2 <?php //echo ($_GET["city_id"] == "Noida")?'active':''; ?> cityNoida">Noida</h6>
                            </div> -->
                            <div class="col-md-4">
                                <div class="mb-3 ">
                                    <label for="exampleInputEmail1" class="form-label">Time Slots</label>
                                    <select id="other_timeslot" name="other_timeslot" class="form-select" aria-label="Default select example">
                                        <option <?php echo (!isset($_GET['availtime']) || (isset($_GET['availtime']) && $_GET['availtime']=="All") )?"selected":""; ?> value="All">All Slots</option>
                                        <option <?php echo (isset($_GET['availtime']) && $_GET['availtime']=="Morning")?"selected":""; ?> value="Morning">Morning</option>
                                        <option <?php echo (isset($_GET['availtime']) && $_GET['availtime']=="Afternoon")?"selected":""; ?>  value="Afternoon">Afternoon</option>
                                        <option <?php echo (isset($_GET['availtime']) && $_GET['availtime']=="Evening")?"selected":""; ?>  value="Evening">Evening</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Speciality</label>
                                    <select name="other_special" id="other_special" class=" form-select" id="city-list" aria-label="Default select example">
                                        <option value="" selected="">All Speciality</option>
                                        <?php
                                        $i = 0;

                                        foreach($speciality_array as $onespeciality)
                                        {
                                            $i++;
                                            ?>
                                            <option value="<?php echo $onespeciality; ?>" <?php echo ($selected_speciality == $onespeciality)?'selected':''; ?>><?php echo $onespeciality; ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <?php if(isset($_GET['city_id']))
                                    echo '<a href="#" id="clearFilter">clear filter</a>';
                            ?>        
                        </div>
                    </div>
                </div>
                <!-- <div class="col-lg-3 col-sm-6 mb-3 mb-sm-0">
                    <div class="space-tabbar-inner">
                    <div class="row ps-3 border-right-line">
                        <div class="col-md-12 pt-3">
                            <h6 class="text-grey ft-14">Location <i class="ft-14 fas fa-chevron-down"></i></h6>
                        </div>
                        <div class="col-md col-sm col pb-3">
                            <h6 class="tab-small-title position-relative ft-16 text-grey active">All Location</h6>
                        </div>
                        <div class="col-md col-sm col pb-3">
                            <h6 class="tab-small-title position-relative ft-16 text-grey">Gurgpoan</h6>
                        </div>
                        <div class="col-md col-sm col pb-3">
                            <h6 class="tab-small-title position-relative ft-16 text-grey">Naida</h6>
                        </div>
                    </div>
                    </div>
                </div> -->
                <!-- <div class="col-lg-3 col-sm-6 col-12 text-center text-md-start">
                    <div class="space-tabbar-inner">
                        <a href="spaces" id="clearFilter">
                            <div class="space-tabbar-inner">
                                <h5 class="text-blue ft-14 mb-0">Clear Filters</h5>                        
                            </div>
                        </a>
                    </div>
                </div>             -->
                <div id="spaceContent" class="row space-gridview pt-5">
                    <?php
                        //print_r($countData);
                    //when empty
                    if($countData[0]->count==0){
                    ?>
                    <div class="text-center">No clinics available for the given condition</div>
                    <?php    
                    }                    


                    foreach ($allData as $oneData) {
                        $image = "";
                        $fileList = glob("datafiles/spaces/".$oneData->id."/space_image_profile/*");
                        if(sizeof($fileList)>0)
                            $image =$fileList[0];
                        // else
                        //     continue; //Todo Log
                        ?>
                        <div class="col-lg-4 col-md-6 mb-5 spaceItem">
                            <div class="space-gridbox">
                                <div class="text-center"><img src="<?php echo $image; ?>" class="img-fluid w-100" alt="" title=""></div>
                                <div class="grid-spacecontbox">
                                <!--  <p class="text-grey ft-14 mb-0"><?php echo $oneData->locality; ?></p> -->
                                    <a href="spaces-ind?id=<?php echo $oneData->id; ?>">
                                        <h2 class="grid-spacetitle fw-bold text-blue f1"><?php echo $oneData->ws_name; ?></h2>
                                    </a>
                                    <div class="row align-items-center pt-2">
                                        <div class="col-md-6 col-6 p-0 p-lg-2">
                                            <p class="text-grey ft-14 mb-0">Pricing starts from</p>
                                            <h6 class="rate-title ft-18">₹<?php echo $oneData->hourly_charges; ?> per hour</h6>
                                            <div class="seedetail-btn text-center mt-5 mb-3">
                                                <?php if (isset($_SESSION['ap_profrea_login_id'])) { ?>
                                                <a href="spaces-ind?id=<?php echo $oneData->id; ?>">See Details</a>
                                                <?php } else { ?>
                                                <a href="login">See Details</a>
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-6 p-0">
                                            <p class="text-grey ft-14 mb-0">Locality</p>
                                            <h6 class="rate-title ft-18"><?php  echo $oneData->locality; ?></h6>
                                            <div class="booknow-btn mt-5 mb-3 text-end">
                                            <?php if (isset($_SESSION['ap_profrea_login_id'])) { ?>
                                                <a href="spaces-ind?id=<?php echo $oneData->id; ?>#plans">Book Now</a>
                                                <?php } else { ?>
                                                <a href="login">Book Now</a>
                                                <?php } ?>
                                            </div>
                                        </div>                                    
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php 
                    } 
                    ?>
                </div>
                <div id="pagination"></div>        
                <!-- <div class="col-md-4 spt mt-5 mt-md-0">
                    <div class="post-free-formbox">
                        <h6 class="personal-details-head f1 pb-3">More Filters</h6>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Time Slots</label>
                            <select id="space_type" name="space_type" required="" class="form-select" aria-label="Default select example">
                                <option value="" selected="">Select space type</option>
                                <option value="Clinic">Clinic</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Speciality</label>
                            <select name="city" required="" class="form-select" id="city-list" aria-label="Default select example">
                                <option value="" selected="">Enter space city</option>
                                <option value="New Delhi,1">New Delhi</option>
                            </select>
                        </div>
                    </div> 
                </div>    -->
            </div>
        </div>  
    </section>   


    <section class="about-wrap">
        <div class="container">
            <div class="row pt-5">
                <div class="col-md-12 text-center pt-5">
                    <h1 class="about-wrap-head f1">We Can Help You To Find <br> Your Workspace</h1>
                    <div class="text-center about-explorebtn pt-5 pb-5 mb-5">
                        <a href="contact">Request a callback</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <form method="GET" action="spaces" id="filter_form" class="hidden">
        <input type="hidden" name="availtime" id="availtime" value="<?php if(isset($_GET["availtime"])){ echo $_GET["availtime"]; } ?>"/>
        <input type="hidden" name="speciality" id="speciality" value="<?php if(isset($_GET["speciality"])){ echo $_GET["speciality"]; } ?>"/>
        <input type="hidden" name="city_id" id="city_id" value="<?php if(isset($_GET["city_id"])){ echo $_GET["city_id"]; } ?>"/>
        <input type="hidden" name="offset" id="offset" value="<?php if(isset($_GET["offset"])){ echo $_GET["offset"]; } else { echo 0; } ?>"/>
        <input type="hidden" name="count" id="count" value="<?php if(isset($_GET["count"])){ echo $_GET["count"]; } else { echo 'false'; }?>"/>
    </form>

<?php include_once('footer.php');?>    
<script>
    $(document).ready(function(){
        let selectedCity = "";
        let selectedIndustry = "";
        let totalRow = Number(<?php echo (sizeof($countData) > 0?$countData[0]->count:0); ?>);        
        let pageOffset = Number(<?php echo (isset($_GET["offset"])?$_GET["offset"]:0); ?>);        

        $(".Medical,.Educational,.Fitness").click(function(){
            selectedIndustry = ($(this).html() === "Medical"?"Clinic":($(this).html() === "Educational"?"Institute":($(this).html() === "Fitness"?"Wellness Center":"")))
            $('#industry_id').val(selectedIndustry);
            getSpaceDetails();
            // getSpaceDetails(0,true);
        })

        $(".cityGurgaon,.cityNoida").click(function(){
            selectedCity = $(this).html();
            $('#city_id').val(selectedCity);
            $("#other_city_id").val("All");
            getSpaceDetails();            
            // getSpaceDetails(0,true);
        })

        $("#other_city_id").change(function(){
            selectedCity = $(this).val();
            $('#city_id').val(selectedCity);
            getSpaceDetails();
            // getSpaceDetails(0,true);
        })

        $("#other_timeslot").change(function(){
            availtime = $(this).val();
            $('#availtime').val(availtime);
            getSpaceDetails();
            // getSpaceDetails(0,true);
        })

        $("#other_special").change(function(){
            speciality = $(this).val();
            $('#speciality').val(speciality);
            getSpaceDetails();
            // getSpaceDetails(0,true);
        })

        $("#clearFilter").click(function(){
            $('#speciality').val("All");
            $('#availtime').val("All");
            $('#city_id').val("All");
            getSpaceDetails();
            // getSpaceDetails(0,true);
            return false;
        })

        function getSpaceDetails(offset = 0,count = false){
            $('#offset').val(offset);
            $('#count').val(count);
            // var postFormStr = "<form method='GET' action='spaces' class='form_filter'>\n";
            // postFormStr += "<input type='hidden' name='city_id' value='" + selectedCity + "'></input>";
            // // postFormStr += "<input type='hidden' name='location_id' value='" + $('#location_id').val() + "'></input>";
            // postFormStr += "<input type='hidden' name='industry_id' value='" + selectedIndustry + "'></input>";
            // postFormStr += "<input type='hidden' name='offset' value='" + offset + "'></input>";
            // postFormStr += "<input type='hidden' name='count' value='" + count + "'></input>";
            // postFormStr += "</form>";

            // var formElement = $(postFormStr);

            // $('#filter_form').html(postFormStr);
            $('#filter_form').submit();

            // $.ajax({
            //     url: 'includes/functions.php?action=getSpaceData',
            //     data: {
            //         city_id:selectedCity,
            //         industry_id : selectedIndustry,
            //         offset : offset,
            //         count : count
            //     },
            //     method: "POST",
            //     beforeSend: function(){
            //         $("#spaceContent").html('<p class="text-center"><i class="fa fa-spinner fa-spin"></i> Please wait as we process..</p>').fadeIn();
            //     },
            //     success: function (result)
            //     {
            //         let txt = "";
            //         let json = JSON.parse(result);
            //         if(json.length==0){
            //             $("#pagination").pagination('updateItems',0);
            //             totalRow = 0;
            //             $("#pagination").hide();
            //         }
            //         json.map((data,index) => {
            //             if(index === 0 && data.count !== undefined){
            //                 totalRow = Number(data.count);
            //                 $("#pagination").pagination('updateItems',totalRow);
            //                 if(offset === 0){
            //                     $("#pagination").pagination('selectPage',1);
            //                 }
            //                 $("#pagination").show();
            //             }
            //             txt = txt+`<div class="col-lg-4 col-md-6 mb-5">
            //                 <div class="space-gridbox">
            //                     <div class="text-center"><img src="${data.imageLocation}" class="img-fluid w-75" alt="" title=""></div>
            //                     <div class="grid-spacecontbox">
                                  
            //                         <h2 class="grid-spacetitle fw-bold text-blue f1">${data.ws_name}</h2>
            //                         <div class="row align-items-center pt-2">
            //                             <div class="col-md-6 col-6 p-0 p-lg-2">
            //                             <p class="text-grey ft-14 mb-0">Price</p>
            //                             <h6 class="rate-title ft-18">₹${data.hourly_charges} per hour</h6>
                                        
            //                             </div>
            //                             <div class="col-md-6 col-6 p-0">
            //                             <p class="text-grey ft-14 mb-0">Locality</p>
            //                             <h6 class="rate-title ft-18">${data.locality}</h6>
                                        
            //                             </div>
            //                             <div class="col-md-12 text-center">
            //                             <div class="seedetail-btn mt-5 mb-3">
            //                                 <a href="spaces-ind?id=${data.id}">See Details</a>
            //                             </div></div>
            //                         </div>
            //                     </div>
            //                 </div>
            //             </div>`;
            //         })
            //         if(txt === ""){
            //             txt = txt+`<p class="text-center">No Data Found</p>`;
            //         }
            //         $("#spaceContent").html(txt)
            //         // var result = $.trim(result);
            //         // $("#location_id").html(result);
            //         // return false;
            //     }
            // });
        } 

        $(function() {
            let pageNo = totalRow;
            var perPage = 9;
            if(pageNo!=0){
                $("#pagination").pagination({
                    items: pageNo,
                    itemsOnPage: perPage,
                    cssStyle: 'light-theme',
                    onPageClick:function(pageNumber,event){
                        getSpaceDetails(((pageNumber*9)-9));
                    }
                });
                console.log(pageOffset)
                $("#pagination").pagination('drawPage',(Math.ceil(pageOffset/9) === 0?1:Math.ceil(pageOffset/9)));
            }
        });            
    })
    

</script>
    
