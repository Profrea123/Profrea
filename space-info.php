<?php
$title = "Profrea";
$description = "";
$keywords = "";
$page = 1;
include 'header.php'; 
?>
<div>
    <!--/ Intro Single star /-->
    <section class="intro-single pt-5">
      <?php
    if(!isset($_GET['id']) ){
      die('Invalid Request');
    }
    $id = trim($_GET['id']);
    require_once('./src/Classes/Model/Database.php');
    require_once('./vendor/autoload.php');
    use App\Classes\Model\Database;
    use App\Classes\RealEstate\Spaces; 
    $db_conn = new Database;
    $real_estate = new Spaces();

    $ws_name = "select ws_name from `space_info` where ws_name !=''";
    $ws_result = $db_conn->getDbHandler()->query($ws_name);
    $ws_rows = $ws_result->fetchAll();
    $ws_names = implode(",", array_map(function($value) {
        return '"' . $value['ws_name'] . '"';
    }, $ws_rows));

    $query = "select * from `basic_info`  where  unique_id = '".$id."'";
    $dbresult = $db_conn->getDbHandler()->query($query); if($dbresult) { $data_rows = $dbresult->fetchAll(); if(count($data_rows)>0) $basic_info = $data_rows[0]; } if(!isset($basic_info)){ die('Invalid Record'); } $query = "SELECT distinct
        space_type FROM spaces ORDER BY space_type ASC"; $dbresult = $db_conn->getDbHandler()->query($query); if($dbresult) { $space_type_list = $dbresult->fetchAll(); } ?>
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-lg-8">
                    <div class="title-single-box">
                        <h1 class="title-single f1">
                            Hi
                            <?php echo $basic_info['first_name'] ?>
                        </h1>
                        <!-- <p class="color-text-a pt-5 text-grey ft-18">Please fill your space related details</p> -->
                    </div>
                </div>
                <div class="col-md-12 col-lg-4 d-flex justify-content-lg-end"></div>
            </div>
        </div>
    </section>
    <!--/ Intro Single End /-->
    <!--/ Contact Star /-->
    <section class="contact">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 section-t7">
                    <!form id="form1" name="form1" method="post" action="..\src\submit-space-info" enctype="multipart/form-data">
                    <form id="form1" name="form1" enctype="multipart/form-data" class="bg-white mt-3 p-3 mb-5">
                        <div class="info">
                        <p class="color-text-a  text-grey ft-20 pb-4">Please fill your space related details</p>
                            <h2 id="setup_title" class="title-single ft-18">Setup Details</h2>
                            <h2 id="workspace_title" class="title-single ft-18" style="display: none;">Workspace Details</h2>
                            <h2 id="documnets_title" class="title-single ft-18" style="display: none;">Documents</h2>
                            <div class="progress">
                                <div class="progress-bar progress-bar-striped active progress-bar-animated" role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <!-- Form code start Here -->
                            <div id="wrapper">
                                <span class="baricon" id="bari1"></span>
                                <span class="baricon" id="bari2"> </span>
                                <span class="baricon" id="bari3"></span>
                            </div>
                            <!-- <br class="clear" />
                            <br class="clear" /> -->
                            <fieldset>
                                <div id="setup">
                                    <div class="row pt-5">
                                        <input class="collapse" name="basic_info_id" id="basic_info_id" value="<?php echo $basic_info['id'] ?>" />
                                        <input class="collapse" name="first_name" id="first_name" value="<?php echo $basic_info['first_name'] ?>" />
                                        <input class="collapse" name="email_Id" id="email_Id" value="<?php echo $basic_info['email_Id'] ?>" />
                                        <div class="col-md-4 mb-4">
                                            <div class="form-group">
                                                <label for="space_type">Space Type</label>
                                                <input class="input form-control form-control-lg form-control-a" name="space_type" id="space_type" value="<?php echo $basic_info['space_type'] ?>" readonly />
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-4">
                                            <div class="form-group">
                                                <label for="city">City</label>
                                                <input class="input form-control form-control-lg form-control-a" name="city" id="city" value="<?php echo $basic_info['city'] ?>" readonly />
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-4">
                                            <div class="form-group">
                                                <label for="locality">Locality</label>
                                                <input class="input form-control form-control-lg form-control-a" name="locality" id="locality" value="<?php echo $basic_info['locality'] ?>" readonly />
                                            </div>
                                        </div>                                       
                                        <div class="col-md-6 mb-4">
                                            <div class="form-group">
                                                <label for="address">Address <span class="text-danger">*</span></label>
                                                <textarea class="form-control form-control-lg form-control-a input" name="address" id="address" placeholder="Enter Address *" required onkeypress="fun_pin();" onkeyup="fun_pin();"></textarea>
                                                <span id="alert_pin" style="display: none; color: red;">*This field is required</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-4">
                                            <div class="form-group">
                                                <label for="landmark">Landmark</label>
                                                <input class="input form-control form-control-lg form-control-a" name="landmark" id="landmark" value="<?php echo $basic_info['landmark'] ?>" readonly />
                                            </div>
                                        </div>
                                        <!-- <div class="col-md-6 mb-3">
                                              <div class="form-group">
                                                <label for="security_deposit">Security Deposit</label>
                                                <select class="form-control form-control-lg form-control-a input" name="security_deposit"
                                                  id="security_deposit" required onchange="fun_deposit()">
                                                  <option value="" selected="true" disabled="disabled">choose option</option>
                                                  <option value="N/A">N/A</option>
                                                  <option value="One Month">One Month</option>
                                                  <option value="Two Months">Two Months</option>
                                                  <option value="Three Months">Three Months</option>
                                                </select>
                                                <span id="alert_deposit" style="display:none;color:red">
                                                *This field is required</span>
                                              </div>
                                            </div> -->
                                        <div class="col-md-6 mb-3">
                                            <div class="form-group">
                                                <label for="setup_rules">
                                                    List Rules <a href="#" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-placement="top" data-bs-content="If desired,add criterias to offer " onclick="return false;"><sup>?</sup></a>
                                                </label>
                                                <textarea class="input form-control form-control-lg form-control-a" name="setup_rules" id="setup_rules" placeholder="Rules to use space"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <div class="form-group">
                                                <label for="setup_description">Setup Description<span class="text-danger">*</span></label>
                                                <textarea
                                                    class="input form-control form-control-lg form-control-a"
                                                    name="setup_description"
                                                    id="setup_description"
                                                    placeholder="Minimum 25 words"
                                                    required
                                                    onkeypress="fun_setup();"
                                                    onkeyup="fun_setup();"
                                                ></textarea>
                                                <span id="alert_setup" style="display: none; color: red;">*This field is required</span>
                                                <span id="alert_setup2" style="display: none; color: red;">*Please write minimum 25 words</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <div class="form-group">
                                                <label>
                                                    Operating Specialty <a href="#" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-placement="top" data-bs-content="Current catagories run into setup " onclick="return false;"><sup>?</sup></a>
                                                    <span id="alert_oper" style="display: none; color: red;">*You can not add more than 5 Operating Specialties</span>
                                                </label>
                                                <ul id="oper" class="ps-0"></ul>
                                                <input class="form-control form-control-lg form-control-a input" name="specialty_operating" id="specialty_operating" autocomplete="off" placeholder="add speciality operatings" />
                                                <h5 class="text-end mt-2 hover-style-b addtxt-sty" id="oper_add"><i class="fa fa-plus-circle me-1"></i>Add</h5>
                                             
                                                <datalist id="special" style="position: inherit; min-width: 80%; width: 50%;" class="dropdown-menu dropdown-menu-left" aria-labelledby="navbarDropdownMenuLink"></datalist>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <div class="form-group">
                                                <label for="utility">Utility</label>
                                                <ul id="util" class="ps-0"></ul>
                                                <input class="form-control form-control-lg form-control-a input" name="utility" id="utility" autocomplete="off" placeholder="Complimentary equipment accessories & machinery" />
                                                <h5 class="text-end mt-2 hover-style-b addtxt-sty" id="util_add"><i class="fa fa-plus-circle me-1"></i>Add</h5>
                                              
                                                <datalist id="uti" style="position: inherit; min-width: 80%;" class="dropdown-menu dropdown-menu-left" aria-labelledby="navbarDropdownMenuLink"></datalist>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <div class="form-group">
                                                <label for="paid_utilities">Paid Utilities</label>
                                                <ul id="paid_util" class="ps-0"></ul>
                                                <input class="form-control form-control-lg form-control-a input" name="paid_utilities" id="paid_utilities" autocomplete="off" placeholder="Chargeable equipment accessories & machinery" />
                                                <h5 class="text-end mt-2 hover-style-b addtxt-sty" id="paid_util_add"><i class="fa fa-plus-circle me-1"></i>Add</h5>
                                               
                                                <datalist id="paid_uti" style="position: inherit; min-width: 80%;" class="dropdown-menu dropdown-menu-left" aria-labelledby="navbarDropdownMenuLink"></datalist>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <div class="form-group">
                                                <label for="amenities">
                                                    Amenities <a href="#" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-placement="top" data-bs-content="Feature and Facilities " onclick="return false;"><sup>?</sup></a>
                                                </label>
                                                <ul id="amen" class="ps-0"></ul>
                                                <input class="form-control form-control-lg form-control-a input" name="amenities" id="amenities" autocomplete="off" placeholder="add amenities " />
                                                <h5 class="text-end mt-2 hover-style-b addtxt-sty" id="amen_add"><i class="fa fa-plus-circle me-1"></i>Add</h5>
                                               
                                                <datalist id="drop" style="position: inherit; min-width: 80%;" class="dropdown-menu dropdown-menu-left" aria-labelledby="navbarDropdownMenuLink"></datalist>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <div class="form-group">
                                                <label>Drag "<span style="color: red;">red</span>" pin on the map to mark your location :</label>
                                                <input id="map_loc" name="map_loc" class="form-control form-control-lg form-control-a input" readonly />
                                                <input id="map_loc1" name="map_loc1" class="form-control form-control-lg form-control-a input" style="display: none;" />
                                                <br />
                                                <div id="map"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-end row justify-content-end">
                                      <div class="col-md-2">
                                    <input type="button" id="nxt" class="btn btn-b ft-btn" value="Next" onclick="show_next('setup','workplace','workspace_title');" /></div>
                                    </div>
                                </div>
                            </fieldset>
                            <fieldset>
                                <div id="workplace">
                                    <h5 id="work_alert" style="display: none; color: red;">* Please add atleast ONE workspace</h5>
                                    <div id="workspace_modal" class="workspace_modal"></div>
                                    <h5 class="hover-style-b mt-4 mb-4 mb-md-0 ft-18 text-center tp-btnview  m-auto" id="addworkspace" style="color: #2275ff;">Click here to add workspace</h5>
                                    <div class="row justify-content-between">
                                      <div class="col-md-2 text-start mb-4 mb-md-0">
                                        <div class="ft-backbtn">
                                        <input type="button" class="btn btn-b ft-btn-back" value="Back" onclick="show_prev('setup','setup_title');" />
                                        </div>
                                      </div>
                                      <div class="col-md-2 text-end mb-4 mb-md-0">
                                      <input type="button" id="nxt" class="btn btn-b ft-btn" value="Next" onclick="show_next('workplace','document','documnets_title');" />
                                      </div>
                                    </div>
                                </div>
                            </fieldset>
                            <fieldset>
                                <div id="document"> 
                                    <div class="row mt-4 align-items-center">
                                        <div class="col-md-4 mb-3">
                                            <div class="form-group">
                                                <label for="space_image" class="ft-14 mb-3"> Space Image <span class="text-danger">*</span></label><span id="space_image_alert1" style="display: none; color: red;">&nbsp; Please upload space images <span class="text-danger">*</span></span>
                                                <span id="space_image_alert2" style="display: none; color: red;">&nbsp; Only supported file types are : jpeg,jpg,png and gif <span class="text-danger">*</span> </span>
                                                <div id="ulList1"></div>
                                                <input class="form-control-lg form-control-a" type="file" name="space_image[]" id="space_image" multiple onchange="javascript:updateList1()" />
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <div class="form-group">
                                                <label for="identity_proof" class="ft-14 mb-3">
                                                    Identity Proof <span class="text-danger">*</span><a href="#" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-placement="top" data-bs-content="Adhar card,voter card etc" onclick="return false;"><sup>?</sup></a>
                                                </label>
                                                <span id="identity_alert1" style="display: none; color: red;">&nbsp; Please upload some Identity proof <span class="text-danger">*</span></span>
                                                <span id="identity_alert2" style="display: none; color: red;">&nbsp; Only supported file types are : jpeg,jpg,png and pdf <span class="text-danger">*</span></span>
                                                <div id="ulList2"></div>
                                                <input class="form-control-lg form-control-a" type="file" name="identity_proof[]" id="identity_proof" multiple onchange="javascript:updateList2()" required />
                                                <br class="clear" />
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <div class="form-group">
                                                <label for="space_ownership_docs" class="ft-14 mb-3" >
                                                    Setup ownership document <span class="text-danger">*</span><a href="#" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-placement="top" data-bs-content="Ownership proof" onclick="return false;"><sup>?</sup></a>
                                                </label>
                                                <span id="space_ownership_alert1" style="display: none; color: red;">&nbsp; Please upload ownership documents <span class="text-danger">*</span></span>
                                                <span id="space_ownership_alert2" style="display: none; color: red;">&nbsp; Only supported file types are : jpeg,jpg,png and pdf <span class="text-danger">*</span></span>
                                                <div id="ulList3"></div>
                                                <input class="form-control-lg form-control-a" type="file" name="space_ownership_docs[]" id="space_ownership_docs" multiple onchange="javascript:updateList3()" />
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <div class="form-group">
                                                <label for="noc" class="ft-14 mb-3">
                                                    NOC(for tenant)
                                                    <a href="../img/NOC.pdf" download="NOC" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-placement="top" data-bs-content="Click to download NOC template as referenced in Profrea's mail ">
                                                        <i class="fa fa-download" style="font-size: 15px; color: #2275ff;"></i>
                                                    </a>
                                                </label>
                                                <span id="noc_alert" style="display: none; color: red;">&nbsp; Only supported file types are : jpeg,jpg,png and pdf <span class="text-danger">*</span></span>
                                                <input class="form-control-lg form-control-a" type="file" name="noc" id="noc" onchange="javascript:updateList4()" />
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <div class="form-group">
                                                <label for="other_docs" class="ft-14 mb-3">Other documents</label>
                                                <span id="other_docs_alert" style="display: none; color: red;">&nbsp; Only supported file types are : jpeg,jpg,png and pdf <span class="text-danger">*</span></span>
                                                <div id="ulList6"></div>
                                                <input class="form-control-lg form-control-a" type="file" name="other_docs[]" id="other_docs" multiple onchange="javascript:updateList6()" />
                                            </div>
                                        </div>
                                        <div class="col-md-12 mt-4">                                           
                                            <h4 class="ft-20 fw-bold">
                                                <i class="material-icons" style="font-size: 18px; color: #2275ff;">&#xe85d;</i> &nbsp;Our CheckList
                                            </h4>
                                        </div>
                                        <div class="col-md-6 mb-6 mt-4">  
                                            <h5 class="ft-18">
                                                <span><i class="fa fa-thumbs-up" style="font-size: 15px; color: #2275ff;"></i> &nbsp;DO'S</span>
                                            </h5>
                                            <ul class="mt-2">
                                                <li><i style="font-size: 15px; color: green;" class="fas">&#xf14a;</i> &nbsp;Prerequisite to have receptionist cum workspace manager.</li>
                                                <li><i style="font-size: 15px; color: green;" class="fas">&#xf14a;</i> &nbsp;Give at least 15 mins of buffer time for space users.</li>
                                                <li>
                                                    <span><i style="font-size: 15px; color: green;" class="fas">&#xf14a;</i> &nbsp;Keep your space available for at least 2 hrs.</span>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="col-md-6 mb-6 mt-4">
                                            <h5 class="ft-18">
                                                <span><i style="font-size: 15px; color: #2275ff;" class="fa">&#xf165;</i> &nbsp;DON'TS</span>
                                            </h5>
                                            <ul class="mt-2">
                                                <li><i style="font-size: 15px; color: red;" class="fa">&#xf2d3;</i> &nbsp;Contact directly or get into an arrangement with space user.</li>
                                                <li><i style="font-size: 15px; color: red;" class="fa">&#xf2d3;</i> &nbsp;Deal with other service providers or agents.</li>
                                            </ul>
                                        </div>
                                        <div class="col-md-12 mb-6 mt-4">                                          
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="vehicle1" name="vehicle1" />
                                                <!-- onchange="fun_terms()" -->
                                                <label for="vehicle1"  style="font-weight: bolder;">
                                                    I hereby agree to Profrea's <span style="color: #2275ff; cursor: pointer;"><a style="color: #2275ff;" href="terms_spaceprovider" target="_blank">terms of use</a></span>
                                                </label>
                                            </div>
                                            <p id="terms_alert" style="display: none; color: red;">&nbsp; Please agree with our terms of use.</p>
                                        </div>
                                    </div>
                                    <div class="row justify-content-between mt-4">
                                        <div class="col-md-2 mb-4 mb-md-0">
                                            <input type="button" class="btn btn-b ft-btn-back" value="Back" onclick="show_prev('workplace','workspace_title');" />
                                        </div>
                                        <div class="col-md-2 mb-4 mb-md-0">
                                            <input type="button" id="nxt" class="btn btn-b ft-btn" value="Preview" onclick="preview1();" />
                                        </div>
                                    </div>
                                    <!--button  id="nxt" class="btn btn-b " onclick="preview1()">Submit</button-->
                                </div>
                            </fieldset>
                        </div>
                        <div class="preview pb-5" style="display: none;">
                            
                                <h1 class="title-single text-center fw-bold ft-30" style="color: #2275ff;">PREVIEW</h1>
                            
                            
                            <hr style="height: 2px; border-width: 0; color: #2275ff; background-color: #2275ff; opacity: 0.7;" />
                            
                            <h3  class="ft-20 pt-3" style="color: #2275ff;">
                                <u><i>SetUp Details</i></u> :
                            </h3>
                            <form>
                                <div class="row pt-4">
                                    <div class="col-md-4 mb-3 mb-md-5">
                                        <label>
                                            <u>
                                                <b><i style="font-size: 18px;" class="fas me-3">&#xf47d;</i>&nbsp;Space Types </b>
                                            </u>
                                        </label>
                                        <p id="space_type" class="space_type ps-md-5 pt-2"><?php echo $basic_info['space_type'] ?></p>
                                    </div>
                                    
                                    <div class="col-md-4 mb-3 mb-md-5 ">
                                        <u>
                                            <b><i style="font-size: 18px;" class="fas me-3">&#xf3c5;</i>&nbsp;Location &nbsp;</b>
                                        </u><br>
                                        <span class="ps-md-5 pt-2">
                                            <span class="address" id="address"></span>
                                            <span class="" id="locality">
                                                <?php echo $basic_info['locality'] ?>
                                                ,
                                            </span>
                                            <span class="" id="landmark">
                                                <?php echo $basic_info['landmark'] ?>
                                                ,
                                            </span>
                                            <span class="" id="city"><?php echo $basic_info['city'] ?></span>
                                        </span>
                                    </div>
                                    <div class="col-md-4 mb-3 mb-md-5">
                                        <div class="form-group">
                                            <label>
                                                <u>
                                                    <b><i style="font-size: 18px;" class="fas me-3">&#xf6b7;</i>&nbsp;List Rules&nbsp;</b>
                                                </u>
                                            </label>
                                            <p class="setup_rules ps-md-5 pt-2" id="setup_rules"></p>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3 mb-md-5">
                                        <div class="form-group">
                                            <label>
                                                <u>
                                                    <b><i style="font-size: 18px;" class="fas me-3">&#xf49e;</i> &nbsp;Setup Description&nbsp;</b>
                                                </u>
                                            </label>
                                            <p class="setup_description ps-md-5 pt-2" id="setup_description2"></p>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3 mb-md-5">
                                        <label>
                                            <u>
                                                <b><i style="font-size: 18px;" class="fas me-3">&#xf471;</i>&nbsp;Operating Specialty&nbsp;</b>
                                            </u>
                                            
                                        </label>
                                        <div id="oper_preview" class="ps-md-5 pt-2"></div>
                                    </div>
                                    <div class="col-md-4 mb-3 mb-md-5">
                                        <label>
                                            <u>
                                                <b><i style="font-size: 18px;" class="fas me-3">&#xf655;</i>&nbsp;Utility&nbsp;</b>
                                            </u>
                                            
                                        </label>
                                        <div id="util_preview" class="ps-md-5 pt-2"></div>
                                    </div>
                                    <div class="col-md-4 mb-3 mb-md-5">
                                        <label>
                                            <u>
                                                <b><i style="font-size: 18px;" class="fas me-3">&#xf2b5;</i>&nbsp;Paid Utilities&nbsp;</b>
                                            </u>
                                            
                                        </label>
                                        <div id="paid_util_preview" class="ps-md-5 pt-2"></div>
                                    </div>
                                    <div class="col-md-4 mb-3 mb-md-5">
                                        <label>
                                            <u>
                                                <b><i style="font-size: 18px;" class="fas me-3">&#xf4ba;</i>&nbsp;Amenities&nbsp;</b>
                                            </u>
                                            
                                        </label>
                                        <div id="amen_preview" class="ps-md-5 pt-2"></div>
                                    </div>
                                </div>
                            </form>
                            <hr style="height: 2px; border-width: 0; color: #2275ff; background-color: #2275ff; opacity: 0.7;" />
                            
                            <h3 style="color: #2275ff;" class="ft-20 pt-3">
                                <u><i>WorkSpace Details</i></u> :
                            </h3>
                            <form class="pt-4">
                                <div id="workspace_container">
                                    <div id="workspace_modal2"></div>
                                </div>
                            </form>
                            <hr style="height: 2px; border-width: 0; color: #2275ff; background-color: #2275ff; opacity: 0.7;" />
                            
                            <h3 style="color: #2275ff;" class="ft-20 pt-3">
                                <u><i>Documents</i></u> :
                            </h3>
                            <form class="pt-4">
                                <div id="list_container1" class="mb-3">
                                    <label> <i class="fas fa-file me-3"></i>&nbsp;Space Image</label>
                                    <div id="ulList12"></div>
                                </div>
                                <div id="list_container2" class="mb-3">
                                    <label> <i class="fas fa-file me-3"></i>&nbsp;Identity Proof</label>
                                    <div id="ulList22"></div>
                                </div>
                                <div id="list_container3" class="mb-3">
                                    <label> <i class="fas fa-file me-3"></i>&nbsp;Space ownership document</label>
                                    <div id="ulList32"></div>
                                </div>
                                <div id="list_container4" class="mb-3">
                                    <label> <i class="fas fa-file me-3"></i>&nbsp;NOC</label>
                                    <div id="ulList42"></div>
                                </div>
                                <div id="list_container6" class="mb-3">
                                    <label> <i class="fas fa-file me-3"></i>&nbsp;Other docs</label>
                                    <div id="ulList62"></div>
                                </div>
                            </form>
                            <div class="editsbtn m-auto col-md-2"><input type="button" class="btn btn-b" value="EDIT" onclick="show_edit();" /></div>
                            <button type="submit" id="nxt" class="btn btn-b ft-btn mb-3 mt-3 mt-md-0">Submit</button>
                            <!input type="button" class="btn btn-b" id="nxt" value="SUBMIT">
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="show-loder d-none" id="loading-image"><img src="https://efullama.files.wordpress.com/2012/10/loading-9.gif?w=461" /></div>
    </section>
    <!--/ Contact End /-->
    <!--/ modal start /-->
    <div class="modal fade" id="myModal" aria-hidden="true" aria-labelledby="myModalToggleLabel" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Fee calculator</h4>
                    <!-- <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button> -->
                    <button type="button" class="btn-close close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <div class="form-group">
                                <label for="operational_cost">
                                    Operational cost:
                                    <a href="#" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-placement="top" data-bs-content="Fix cost including Rent, Elec, Water bill, Salaries etc." onclick="return false;"><sup>?</sup></a>
                                </label>
                                <input type="number" class="form-control form-control-lg form-control-a" name="operational_cost" id="operational_cost" placeholder="Lump Sum" min="1000" max="500000" />
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <div class="form-group">
                                <label for="profit_loading">
                                    Profit Loading (%):
                                    <a href="#" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-placement="top" data-bs-content="Accounting for management, capital cost etc.(ideally 20%)" onclick="return false;"><sup>?</sup></a>
                                </label>
                                <input type="number" class="form-control form-control-lg form-control-a" name="profit_loading" id="profit_loading" placeholder="Profit loading % " min="1" max="100" />
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <div class="form-group">
                                <label for="offered_workspace"> Offered workspace:&nbsp</label>
                                &nbsp &nbsp &nbsp
                                <label class="radio-inline"> <input type="radio" name="offered_workspace" value="Space Provider" id="entire_space" checked /> Entire set-up </label>
                                &nbsp &nbsp &nbsp
                                <label class="radio-inline"> <input type="radio" name="offered_workspace" value="Space User" id="partial_space" /> Part of set-up </label>
                            </div>
                        </div>
                        <div class="col-md-12 mb-3 box2 partial_space">
                            <div class="form-group">
                                <label for="workspace_area">
                                    Offered workspace area (%):
                                    <a href="#" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-placement="top" data-bs-content="i.e.- 20% if workspace area is 200 sqft in 1000 sqft of set-up." onclick="return false;"><sup>?</sup></a>
                                </label>
                                <input type="number" class="form-control form-control-lg form-control-a" name="workspace_area" id="workspace_area" placeholder="%age of setup" min="1" max="100" />
                            </div>
                        </div>
                        <div class="col-md-12 mb-3 box2 partial_space">
                            <div class="form-group">
                                <label for="common_area">
                                    Common Area (%):
                                    <a href="#" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-placement="top" data-bs-content="i.e.- 80% if common area is 800 sqft in 1000 sqft of set-up." onclick="return false;"><sup>?</sup></a>
                                </label>
                                <input type="number" class="form-control form-control-lg form-control-a" name="common_area" id="common_area" placeholder="%age of setup" min="1" max="100" />
                            </div>
                        </div>
                        <div class="col-md-12 mb-3 box2 partial_space">
                            <div class="form-group">
                                <label for="workspace_count">
                                    Workspace in set-up (no's):
                                    <a href="#" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-placement="top" data-bs-content="Common area shared by no. of cubicles, classrooms or activity area." onclick="return false;"><sup>?</sup></a>
                                </label>
                                <input type="number" class="form-control form-control-lg form-control-a" name="workspace_count" id="workspace_count" placeholder="Workspace in set-up *" min="1" max="100" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <label class="control-label col-sm-10" style="font-size: 18px; color: green;" id="fCharge"></label>
                    <button type="button" id="btnSave" class="btn btn-primary">Apply</button>
                    <!-- <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> -->
                </div>
                <label style="font-size: 12px; color: red;"> &nbsp Be competitive earn more.</label>
            </div>
        </div>
    </div>
    <div class="modal fade" id="myModal1" aria-hidden="true" aria-labelledby="myModalToggleLabel1" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title ft-18">Fill this Details</h4>
                    <!-- <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button> -->
                    <button type="button" class="btn-close close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body row">
                    <div class="form-group col-md-6 mb-3">
                        <label for="workspace_name" class="ft-16 mb-3">
                            Workspace Name<span class="text-danger">*</span><a href="#" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-placement="top" data-bs-content="e.g. Front cabin, garden facing activity area or classroom 1 etc." onclick="return false;"><sup>?</sup></a>
                        </label>
                        <span id="alert_work_name" style="display: none; color: red;"> *This field is required</span>
                        <span id="alert_work_unique_name" style="display: none; color: red;"> *Workspace name is taken. Try another</span>
                        <span id="alert_work_length" style="display: none; color: red;"> *Workspace name should not be more than 15 words</span>
                        <input class="form-control form-control-lg form-control-a" placeholder="Enter Unique name*" id="workspace_name" name="workspace_name" required onchange="fun_work()" onkeypress="fun_work()" />
                    </div>
                    <div class="form-group col-md-6 mb-3">
                        <label for="available_from" class="ft-16 mb-3">Available From <span class="text-danger">*</span></label>
                        <span id="alert_available" style="display: none; color: red;"> *This field is required</span>
                        <input class="form-control form-control-lg form-control-a" type="date" id="available_from" name="available_from" min="05/04/2020" required onchange="fun_avail()" />
                    </div>
                    <div class="form-container">
                        <div class="selectAll form-check">
                            <input type="checkbox" name="selectall" class="form-check-input" id="selectall" />
                            <label for="selectall">Select same time slots for whole week</label>
                        </div>
                        <hr />
                        <div id="mon" class="day d-flex align-items-center">
                            <h3 class="ft-18 fw-bold mb-0 me-3 w-10">Mon</h3>
                            <div class="sessions">
                                <div class="mon-sessions alert-container"></div>
                                <button class="btn btn-default addSession" value="mon-sessions"><i class="fa fa-plus-circle me-1" aria-hidden="true"></i> Add New Session</button>
                            </div>
                        </div>
                        <hr />
                        <div id="tue" class="day  d-flex align-items-center">
                            <h3 class="ft-18 fw-bold mb-0 me-3 w-10">Tue</h3>
                            <div class="sessions">
                                <div class="tue-sessions day-session alert-container"></div>
                                <button class="btn btn-default addSession" value="tue-sessions"><i class="fa fa-plus-circle me-1" aria-hidden="true"></i> Add New Session</button>
                            </div>
                        </div>
                        <hr />
                        <div id="wed" class="day  d-flex align-items-center">
                            <h3 class="ft-18 fw-bold mb-0 me-3 w-10">Wed</h3>
                            <div class="sessions">
                                <div class="wed-sessions day-session alert-container"></div>
                                <button class="btn btn-default addSession" value="wed-sessions"><i class="fa fa-plus-circle me-1" aria-hidden="true"></i> Add New Session</button>
                            </div>
                        </div>
                        <hr />
                        <div id="thu" class="day  d-flex align-items-center">
                            <h3 class="ft-18 fw-bold mb-0 me-3 w-10">Thu</h3>
                            <div class="sessions">
                                <div class="thu-sessions day-session alert-container"></div>
                                <button class="btn btn-default addSession" value="thu-sessions"><i class="fa fa-plus-circle me-1" aria-hidden="true"></i> Add New Session</button>
                            </div>
                        </div>
                        <hr />
                        <div id="fri" class="day  d-flex align-items-center">
                            <h3 class="ft-18 fw-bold mb-0 me-3 w-10">Fri</h3>
                            <div class="sessions">
                                <div class="fri-sessions day-session alert-container"></div>
                                <button class="btn btn-default addSession" value="fri-sessions"><i class="fa fa-plus-circle me-1" aria-hidden="true"></i> Add New Session</button>
                            </div>
                        </div>
                        <hr />
                        <div id="sat" class="day  d-flex align-items-center">
                            <h3 class="ft-18 fw-bold mb-0 me-3 w-10">Sat</h3>
                            <div class="sessions">
                                <div class="sat-sessions day-session alert-container"></div>
                                <button class="btn btn-default addSession" value="sat-sessions"><i class="fa fa-plus-circle me-1" aria-hidden="true"></i> Add New Session</button>
                            </div>
                        </div>
                        <hr />
                        <div id="sun" class="day  d-flex align-items-center">
                            <h3 class="ft-18 fw-bold mb-0 me-3 w-10">Sun</h3>
                            <div class="sessions">
                                <div class="sun-sessions day-session alert-container"></div>
                                <button class="btn btn-default addSession" value="sun-sessions"><i class="fa fa-plus-circle me-1" aria-hidden="true"></i> Add New Session</button>
                            </div>
                        </div>
                    </div>
                    <div class="row align-items-center">
                        <!-- <div class="col-md-2 col-6 pb-3 pb-md-0">
              <h3 class="selc-slo ">Selected Slots</h3>
            </div>
            <div class="col-md-2 col-6 pb-3 pb-md-0">
              <div class="ash-boxedtext">
                <h2 class="mb-0">10</h2>
              </div>
            </div> -->
                        <!--  <div class="col-md-3 col-6">
              <h3 class="selc-slo ">Approximate Plan Amount</h3>
            </div>
            <div class="col-md-3 col-6">
              <div class="ash-boxedtext">
                <h2 class="mb-0">Rs 5200</h2>
              </div>
            </div> -->
                    </div>
                </div>
                <!--form start-->
                <div class="form-group p-3">
                    <label for="description" class="ft-16 mb-3">Description</label>
                    <span id="alert_hide" style="display: none; color: red;"> *This field is required </span>
                    <textarea class="form-control form-control-lg form-control-a" name="description" id="description" required onkeypress="alert_h()"></textarea>
                </div>
                <div class="form-group p-3" id="cap">
                    <label for="capacity" class="ft-16 mb-3">Capacity</label>
                    <input type="number" class="form-control form-control-lg form-control-a" name="capacity" id="capacity" placeholder="Enter capacity, If Applicable" />
                </div>
                <div class="form-group p-3 pt-0">
                    <div class="row">
                        <div class="col-md-6 col-12 mb-3">
                            <label for="space_profile_image" class="ft-16 mb-3">Space Profile Image <span class="text-danger">*</span></label>
                            <span id="alert_space" style="display: none; color: red;"> *This field is required </span>
                            <input class="form-control-lg form-control-a" type="file" name="space_profile_image" id="space_profile_image" required onchange="alert_img()" />
                        </div>
                        <div class="col-md-6 col-12 mb-3">
                            <img id="im" src="" alt="*Please add one profile image" width="100" height="110" style="float: right; display: none;" />
                        </div>
                    </div>
                </div>
                <button type="submit" id="save_data" class="btn btn-b ft-btn m-auto mb-3" style="float: right;">DONE</button>
            </div>
        </div>
    </div>
    <div class="modal fade" id="myModal2" aria-hidden="true" aria-labelledby="myModalToggleLabel2" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="ft-18">Enter Time Values :</h3>
                    <!-- <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button> -->
                    <button type="button" class="btn-close close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="message"></div>
                    <form id="sessionform" method="POST">
                        <div class="time-container">
                            <div class="time-input input-group time" id="timepicker1">
                                <label>
                                    <h4 class="ft-16">START TIME</h4>
                                </label>
                                <input class="sessionInput" id="startingtime" placeholder="00:00 AM" />
                            </div>
                            <input type="text" class="form-control" id="hiddenInput" hidden />
                            <div class="line"></div>
                            <div class="time-input input-group time" id="timepicker2">
                                <label>
                                    <h4 class="ft-16">END TIME</h4>
                                </label>
                                <input class="sessionInput" id="endingtime" placeholder="00:00 AM" />
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn saveBtn ft-btn" type="submit">Save Session</button>
                </div>
            </div>
        </div>
    </div>
    <!-- /.modal End -->
</div>
<?php include 'footer.php'; ?>
<script src="js/session-script.js"></script>
<link rel="stylesheet" href="css/jquery-editable-select.min.css" />
<script src="js/jquery-editable-select.min.js"></script>
<script>
    $(document).ready(function () {
        $("#specialty_operating").keyup(function () {
            var name = $("#specialty_operating").val();
            var space_type = $("#space_type").val();
            if (name == "") {
                $("#special").hide();
            } else {
                $.ajax({
                    type: "POST",
                    url: "./ajax/get_specialty_operating.php",
                    data: {
                        search: name,
                        space_type: space_type,
                    },
                    success: function (html) {
                        $("#special").html(html).show();
                        $("#special option").click(function () {
                            fillspecialty_operating($(this).attr("href"), $(this).text());
                        });
                    },
                });
            }
        });

        function fillspecialty_operating(href, Value) {
            $("#specialty_operating").val(Value);
            $("#special").hide();
        }

        $("#utility").keyup(function () {
            var name = $("#utility").val();
            var space_type = $("#space_type").val();
            if (name == "") {
                $("#uti").hide();
            } else {
                $.ajax({
                    type: "POST",
                    url: "./ajax/get_utility.php",
                    data: {
                        search: name,
                        space_type: space_type,
                    },
                    success: function (html) {
                        $("#uti").html(html).show();
                        $("#uti option").click(function () {
                            fillutility($(this).attr("href"), $(this).text());
                        });
                    },
                });
            }
        });

        function fillutility(href, Value) {
            $("#utility").val(Value);
            $("#uti").hide();
        }

        $("#paid_utilities").keyup(function () {
            var name = $("#paid_utilities").val();
            var space_type = $("#space_type").val();
            if (name == "") {
                $("#paid_uti").hide();
            } else {
                $.ajax({
                    type: "POST",
                    url: "./ajax/get_paid_utilities.php",
                    data: {
                        search: name,
                        space_type: space_type,
                    },
                    success: function (html) {
                        $("#paid_uti").html(html).show();
                        $("#paid_uti option").click(function () {
                            fillpaid_utilities($(this).attr("href"), $(this).text());
                        });
                    },
                });
            }
        });

        function fillpaid_utilities(href, Value) {
            $("#paid_utilities").val(Value);
            $("#paid_uti").hide();
        }

        $("#amenities").keyup(function () {
            var name = $("#amenities").val();
            var space_type = $("#space_type").val();
            if (name == "") {
                $("#drop").hide();
            } else {
                $.ajax({
                    type: "POST",
                    url: "./ajax/get_amenities.php",
                    data: {
                        search: name,
                        space_type: space_type,
                    },
                    success: function (html) {
                        $("#drop").html(html).show();
                        $("#drop option").click(function () {
                            fillamenities($(this).attr("href"), $(this).text());
                        });
                    },
                });
            }
        });

        function fillamenities(href, Value) {
            $("#amenities").val(Value);
            $("#drop").hide();
        }

        //   var radio_selected = $('input[name=category]:checked', '#form1').attr('id')
        //   var targetBox = $("." + radio_selected);
        //       $(".box").not(targetBox).hide();
        //       $(targetBox).show();
        //   $('input[type="radio"]').click(function(){
        //       var inputValue = $(this).attr("id");
        //       var targetBox = $("." + inputValue);
        //       $(".box").not(targetBox).hide();
        //       $(targetBox).show();
        //   });
        //  document.getElementById('space_type').min = new Date().toISOString().split("T")[0];
        // $('#space_type').editableSelect();

        if ($("#space_type").val() == "Clinic") $("#cap").hide();

        $("select").on("change", function () {
            var spacename = $("#space_type").val();
            if (spacename == "Clinic") {
                $("#cap").hide();
            } else $("#cap").show();
        });
        available_from.min = new Date().toISOString().split("T")[0];
    });
</script>
<script>
    $(function () {
        $("#form1").on("submit", function (e) {
            e.preventDefault();
            var amenities = [];
            $("#amen_preview")
                .find("li")
                .each(function () {
                    amenities.push($(this).html());
                });
            var utility = [];
            $("#util_preview")
                .find("li")
                .each(function () {
                    utility.push($(this).html());
                });
            var paid_utilities = [];
            $("#paid_util_preview")
                .find("li")
                .each(function () {
                    paid_utilities.push($(this).html());
                });
            var operating_specialty = [];
            $("#oper_preview")
                .find("li")
                .each(function () {
                    operating_specialty.push($(this).html());
                });
            var worksp_name = [];
            $("#workspace_modal2")
                .find("div")
                .find("h4")
                .each(function () {
                    worksp_name.push($(this).html());
                });
            var work_charge = [];
            $("#workspace_modal2")
                .find("div")
                .find("#hourly")
                .find("span")
                .each(function () {
                    work_charge.push($(this).html());
                });
            var work_desc = [];
            $("#workspace_modal2")
                .find("div")
                .find("#desc")
                .find("span")
                .each(function () {
                    work_desc.push($(this).html());
                });
            var work_avail = [];
            $("#workspace_modal2")
                .find("div")
                .find("#avail_from")
                .find("span")
                .each(function () {
                    work_avail.push($(this).html());
                });
            var kn = $("#workspace_modal2").find("div").length;
            var work_cap = [];
            for (var i = 1; i <= kn; i++) {
                $("#workspace_modal2")
                    .find("div:nth-of-type(" + i + ")")
                    .find("#cap")
                    .find("span")
                    .each(function () {
                        work_cap.push($(this).html() + " " + i);
                    });
            }
            var work_mon = [];
            for (var i = 1; i <= kn; i++) {
                work_mon[i - 1] = [];
                $("#workspace_modal2")
                    .find("div:nth-of-type(" + i + ")")
                    .find("#mon-id")
                    .find("span")
                    .each(function () {
                        work_mon[i - 1].push($(this).html());
                    });
                // work_mon.push("end");
            }
            var work_tue = [];
            for (var i = 1; i <= kn; i++) {
                work_tue[i - 1] = [];
                $("#workspace_modal2")
                    .find("div:nth-of-type(" + i + ")")
                    .find("#tue-id")
                    .find("span")
                    .each(function () {
                        work_tue[i - 1].push($(this).html());
                    });
            }
            var work_wed = [];
            for (var i = 1; i <= kn; i++) {
                work_wed[i - 1] = [];
                $("#workspace_modal2")
                    .find("div:nth-of-type(" + i + ")")
                    .find("#wed-id")
                    .find("span")
                    .each(function () {
                        work_wed[i - 1].push($(this).html());
                    });
            }
            var work_thu = [];
            for (var i = 1; i <= kn; i++) {
                work_thu[i - 1] = [];
                $("#workspace_modal2")
                    .find("div:nth-of-type(" + i + ")")
                    .find("#thu-id")
                    .find("span")
                    .each(function () {
                        work_thu[i - 1].push($(this).html());
                    });
            }
            var work_fri = [];
            for (var i = 1; i <= kn; i++) {
                work_fri[i - 1] = [];
                $("#workspace_modal2")
                    .find("div:nth-of-type(" + i + ")")
                    .find("#fri-id")
                    .find("span")
                    .each(function () {
                        work_fri[i - 1].push($(this).html());
                    });
            }
            var work_sat = [];
            for (var i = 1; i <= kn; i++) {
                work_sat[i - 1] = [];
                $("#workspace_modal2")
                    .find("div:nth-of-type(" + i + ")")
                    .find("#sat-id")
                    .find("span")
                    .each(function () {
                        work_sat[i - 1].push($(this).html());
                    });
            }
            var work_sun = [];
            for (var i = 1; i <= kn; i++) {
                work_sun[i - 1] = [];
                $("#workspace_modal2")
                    .find("div:nth-of-type(" + i + ")")
                    .find("#sun-id")
                    .find("span")
                    .each(function () {
                        work_sun[i - 1].push($(this).html());
                    });
            }
            var work_img = [];
            $("#workspace_modal")
                .find("div")
                .find("img")
                .each(function () {
                    work_img.push($(this).attr("src"));
                });
            var basic_info_id = $("#basic_info_id").val();
            var first_name = $("#first_name").val();
            var email_Id = $("#email_Id").val();
            var space_type = $("#space_type").val();
            var locality = $("#locality").val();
            var landmark = $("#landmark").val();
            var city = $("#city").val();
            var address = $("#address").val();
            var security_deposit = $("#security_deposit").val();
            var setup_rules = $("#setup_rules").val();
            var setup_description = $("#setup_description").val();
            var map_loc = $("#map_loc").val();
            var map_loc1 = $("#map_loc1").val();
            var space_ownership_docs = space_ownership_docsfileArray; //$("#space_ownership_docs").val();
            var other_docs = other_docsfileArray; //$("#other_docs").val();
            var space_image = fileArray; //$("#space_image").val();
            var identity_proof = identity_prooffileArray; //$("#identity_proof").val();
            var noc = nocfileArray;
            var space_profile_image = space_profile_imagefileArray;
            var myKeyVals = {
                basic_info_id: basic_info_id,
                first_name: first_name,
                email_Id: email_Id,
                space_type: space_type,
                locality: locality,
                landmark: landmark,
                city: city,
                address: address,
                security_deposit: security_deposit,
                setup_rules: setup_rules,
                setup_description: setup_description,
                map_loc: map_loc,
                map_loc1: map_loc1,
                work_mon: work_mon,
                work_tue: work_tue,
                work_wed: work_wed,
                work_thu: work_thu,
                work_fri: work_fri,
                work_sat: work_sat,
                work_sun: work_sun,
                work_img: work_img,
                work_charge: work_charge,
                work_desc: work_desc,
                worksp_name: worksp_name,
                work_cap: work_cap,
                work_avail: work_avail,
                amenities: amenities,
                utility: utility,
                paid_utilities: paid_utilities,
                operating_specialty: operating_specialty,
                noc: $("#noc").val(),
                other_docs: other_docs,
                space_ownership_docs: space_ownership_docs,
                identity_proof: identity_proof,
                space_image: space_image,
                noc: noc,
                space_profile_image: space_profile_image,
            };
            //var form_data = new FormData(this);
            var fad = toFormData(myKeyVals);
            $("#loading-image").removeClass("d-none");
            $.ajax({
                type: "post",
                url: "./src/submit-space-info.php",
                data: fad,
                processData: false,
                contentType: false,
                success: function (result) {
                    
                    window.location.href = "space-info-submit.php";
                },
                complete: function () {
                    $("#loading-image").addClass("d-none");
                },
            });
        });
    });
    function toFormData(obj, form, namespace) {
        let fd = form || new FormData();
        let formKey;
        for (let property in obj) {
            if (obj.hasOwnProperty(property) && obj[property]) {
                if (namespace) {
                    formKey = namespace + "[" + property + "]";
                } else {
                    formKey = property;
                }
                // if the property is an object, but not a File, use recursivity.
                if (obj[property] instanceof Date) {
                    fd.append(formKey, obj[property].toISOString());
                } else if (typeof obj[property] === "object" && !(obj[property] instanceof File)) {
                    toFormData(obj[property], fd, formKey);
                } else {
                    // if it's a string or a File object
                    fd.append(formKey, obj[property]);
                }
            }
        }
        return fd;
    }
</script>
<script>
    /* space_profile_image Image */
    var space_profile_imagefileArray = [];
    var space_profile_imagefileToRead = document.getElementById("space_profile_image");
    space_profile_imagefileToRead.addEventListener(
        "change",
        function (event) {
            var files = space_profile_imagefileToRead.files;
            if (files.length) {
                space_profile_imagefileArray = files[0];
            }
        },
        false
    );

    /* space_image Image */
    var fileArray = [];
    var fileToRead = document.getElementById("space_image");
    fileToRead.addEventListener(
        "change",
        function (event) {
            var files = fileToRead.files;
           // console.log(files);
            if (files.length) {
                fileArray = files;
            }
        },
        false
    );

    /* identity_proof Image Multiple */
    var identity_prooffileArray = [];
    var identity_prooffileToRead = document.getElementById("identity_proof");
    identity_prooffileToRead.addEventListener(
        "change",
        function (event) {
            var files = identity_prooffileToRead.files;
            if (files.length) {
                identity_prooffileArray = files[0];
            }
        },
        false
    );

    /* space_ownership_docs Image Multiple */
    var space_ownership_docsfileArray = [];
    var space_ownership_docsfileToRead = document.getElementById("space_ownership_docs");
    space_ownership_docsfileToRead.addEventListener(
        "change",
        function (event) {
            var files = space_ownership_docsfileToRead.files;
            if (files.length) {
                space_ownership_docsfileArray = files[0];
            }
        },
        false
    );

    /* noc Image */
    var nocfileArray = [];
    var nocfileToRead = document.getElementById("noc");
    nocfileToRead.addEventListener(
        "change",
        function (event) {
            var files = nocfileToRead.files;
            if (files.length) {
                nocfileArray = files;
            }
        },
        false
    );

    /* terms Image */

    /* other_docs Image Multiple */
    var other_docsfileArray = [];
    var other_docsfileToRead = document.getElementById("other_docs");
    other_docsfileToRead.addEventListener(
        "change",
        function (event) {
            var files = other_docsfileToRead.files;
            if (files.length) {
                other_docsfileArray = files[0];
            }
        },
        false
    );

    //preview
    updateList1 = function () {
        $("#space_image_alert1").hide();
        var input = document.getElementById("space_image");
        var l = input.files.length;
        var temp = true;
        for (var i = 0; i < l; ++i) {
            var input_type = input.files.item(i).type;
            if (input_type == "image/jpg" || input_type == "image/jpeg" || input_type == "image/png" || input_type == "image/gif") {
            } else {
                temp = false;
            }
        }
        if (temp == true) {
            $("#space_image_alert2").hide();
            var output = document.getElementById("ulList1");
            var output1 = document.getElementById("ulList12");
            var children = "";
            for (var i = 0; i < l; ++i) {
                children += "<li>" + input.files.item(i).name + "</li>";
            }
            if (l > 1) {
                $("#ulList1").show();
                output.innerHTML = "<ul><b><u>Uploaded files </u>:</b>" + children + "</ul>";
                $("#ulList12").remove();
                $("#list_container1").append('<div id="ulList12"></div>');
                $("#ulList1").clone().appendTo($("#ulList12"));
            } else {
                $("#ulList1").hide();
                output1.innerHTML = "<ul><b><u>Uploaded files </u>:</b>" + children + "</ul>";
            }
        } else {
            $("#space_image").val("");
            $("#space_image_alert2").show();
            $("#ulList1").hide();
        }
    };

    updateList2 = function () {
        $("#identity_alert1").hide();
        var input = document.getElementById("identity_proof");
        var l = input.files.length;
        var temp = true;
        for (var i = 0; i < l; ++i) {
            var input_type = input.files.item(i).type;
            if (input_type == "image/jpg" || input_type == "image/jpeg" || input_type == "image/png" || input_type == "application/pdf") {
            } else {
                temp = false;
            }
        }
        if (temp == true) {
            $("#identity_alert2").hide();
            var output = document.getElementById("ulList2");
            var output1 = document.getElementById("ulList22");
            var children = "";
            for (var i = 0; i < l; ++i) {
                children += "<li>" + input.files.item(i).name + "</li>";
            }
            if (l > 1) {
                $("#ulList2").show();
                output.innerHTML = "<ul><b><u>Uploaded files </u>:</b>" + children + "</ul>";
                $("#ulList22").remove();
                $("#list_container2").append('<div id="ulList22"></div>');
                $("#ulList2").clone().appendTo($("#ulList22"));
            } else {
                $("#ulList2").hide();
                output1.innerHTML = "<ul><b><u>Uploaded files </u>:</b>" + children + "</ul>";
            }
        } else {
            $("#identity_proof").val("");
            $("#identity_alert2").show();
            $("#ulList2").hide();
        }
    };

    updateList3 = function () {
        $("#space_ownership_alert1").hide();
        var input = document.getElementById("space_ownership_docs");
        var l = input.files.length;
        var temp = true;
        for (var i = 0; i < l; ++i) {
            var input_type = input.files.item(i).type;
            if (input_type == "image/jpg" || input_type == "image/jpeg" || input_type == "image/png" || input_type == "application/pdf") {
            } else {
                temp = false;
            }
        }
        if (temp == true) {
            $("#space_ownership_alert2").hide();
            var input = document.getElementById("space_ownership_docs");
            var output = document.getElementById("ulList3");
            var output1 = document.getElementById("ulList32");
            var children = "";
            for (var i = 0; i < input.files.length; ++i) {
                children += "<li>" + input.files.item(i).name + "</li>";
            }
            if (l > 1) {
                $("#ulList3").show();
                output.innerHTML = "<ul><b><u>Uploaded files </u>:</b>" + children + "</ul>";
                $("#ulList32").remove();
                $("#list_container3").append('<div id="ulList32"></div>');
                $("#ulList3").clone().appendTo($("#ulList32"));
            } else {
                $("#ulList3").hide();
                output1.innerHTML = "<ul><b><u>Uploaded files </u>:</b>" + children + "</ul>";
            }
        } else {
            $("#space_ownership_docs").val("");
            $("#space_ownership_alert2").show();
            $("#ulList3").hide();
        }
    };

    updateList4 = function () {
        var input = $("#noc")[0].files[0].name;
        var input_type = $("#noc")[0].files[0].type;
        if (input_type == "image/jpg" || input_type == "image/jpeg" || input_type == "image/png" || input_type == "application/pdf") {
            $("#noc_alert").hide();
            $("#ulList42").show();
            var output = document.getElementById("ulList42");
            var children = "";
            children += "<li>" + input + "</li>";
            output.innerHTML = "<ul><b><u>Uploaded file </u>:</b>" + children + "</ul>";
        } else {
            $("#noc_alert").show();
            $("#noc").val("");
            $("#ulList42").hide();
        }
    };

    updateList6 = function () {
        var input = document.getElementById("other_docs");
        var l = input.files.length;
        var temp = true;
        for (var i = 0; i < l; ++i) {
            var input_type = input.files.item(i).type;
            if (input_type == "image/jpg" || input_type == "image/jpeg" || input_type == "image/png" || input_type == "application/pdf") {
            } else {
                temp = false;
            }
        }
        if (temp == true) {
            $("#other_docs_alert").hide();
            var output = document.getElementById("ulList6");
            var output1 = document.getElementById("ulList62");
            var children = "";
            for (var i = 0; i < l; ++i) {
                children += "<li>" + input.files.item(i).name + "</li>";
            }
            if (l > 1) {
                $("#ulList6").show();
                output.innerHTML = "<ul><b><u>Uploaded files </u>:</b>" + children + "</ul>";
                $("#ulList62").remove();
                $("#list_container6").append('<div id="ulList62"></div>');
                $("#ulList6").clone().appendTo($("#ulList62"));
            } else {
                $("#ulList6").hide();
                output1.innerHTML = "<ul><b><u>Uploaded files </u>:</b>" + children + "</ul>";
            }
        } else {
            $("#other_docs").val("");
            $("#other_docs_alert").show();
            $("#ulList6").hide();
        }
    };

    $(document).ready(function () {
        // $('.'+$().attr('id')+'').val($this.val());
        var conceptName = $("#space_type").val();
        $("#space_type2").val(conceptName);
        $(".input").on("keypress keydown keyup change", function () {
            var $this = $(this);
            $("." + $this.attr("id") + "").text($this.val());
            $("." + $this.attr("id") + "").val($this.val());
        });
        $(".preview").find("input, textarea, select").attr("readonly", "readonly");
    });
</script>
<script>
    //utility
    $(document).ready(function () {
        var n = 1;
        $("#util_add").on("click", function () {
            var val = document.getElementById("utility").value;
            $("#utility").val("");
            if (val != "") {
                $("#util").append(
                    '<li class="util_li" id="util_li' +
                        n +
                        '"><span id="preview_util">' +
                        val +
                        '</span>   <input type="hidden" name="util[]" value="' +
                        val +
                        '"/>  <span class="removeclass" onclick="fun2(' +
                        n +
                        ')"> &nbsp; x &nbsp;</span></li>'
                );
                $("#util_preview").append('<li id="util_li2' + n + '">' + val + "</li>");
                n++;
            }
            $("#uti")
                .find("option[value='" + val + "']")
                .prop("disabled", true);
        });
    });
</script>
<script>
    //Paid_utility
    $(document).ready(function () {
        var n1 = 1;
        $("#paid_util_add").on("click", function () {
            var val = document.getElementById("paid_utilities").value;
            $("#paid_utilities").val("");
            if (val != "") {
                $("#paid_util").append(
                    '<li class="paid_util_li" id="paid_util_li' +
                        n1 +
                        '"><span id="preview_paid_util">' +
                        val +
                        '</span>   <input type="hidden" name="paid_util[]" value="' +
                        val +
                        '"/>   <span class="removeclass" onclick="fun3(' +
                        n1 +
                        ')"> &nbsp; x &nbsp;</span></li>'
                );
                $("#paid_util_preview").append('<li id="paid_util_li2' + n1 + '">' + val + "</li>");
                n1++;
            }
            $("#paid_uti")
                .find("option[value='" + val + "']")
                .prop("disabled", true);
        });
    });
</script>
<script>
    //seciality operatings
    $(document).ready(function () {
        var n2 = 1;
        $("#oper_add").on("click", function () {
            // var count = $("#oper li").length;
            // if (count >= 5) $("#alert_oper").show();
            // else {
                $("#alert_oper").hide();
                var val = document.getElementById("specialty_operating").value;
                $("#specialty_operating").val("");
                if (val != "") {
                    $("#oper").append(
                        '<li class="oper_li" id="oper_li' +
                            n2 +
                            '"><span id="preview_oper">' +
                            val +
                            '</span>    <input type="hidden" name="oper[]" value="' +
                            val +
                            '"/>  <span class="removeclass" onclick="fun4(' +
                            n2 +
                            ')"> &nbsp; x &nbsp;</span></li>'
                    );
                    $("#oper_preview").append('<li id="oper_li2' + n2 + '">' + val + "</li>");
                    n2++;
                }
                $("#special")
                    .find("option[value='" + val + "']")
                    .prop("disabled", true);
            // }
        });
    });
</script>
<script>
    //amenities
    function fun_potential() {
        var p = fun_calculator();
        var t = Math.floor($("#hourly_charges").val() * p * 4);
        if (t != 0) {
            $("#revenue").html(t);
            $("#potential").show();
        } else $("#potential").hide();
    }

    function some(p1) {
        var tSplit = p1.split("-");
        var startTime = tSplit[0];
        var endTime = tSplit[1];
        var hours1;
        var mins1;
        var hours2;
        var mins2;
        if (startTime.indexOf("AM") > -1 || startTime.indexOf("am") > -1) {
            startTime = startTime.replace("am", "");
            startTime = startTime.replace("AM", "");
            var fields = startTime.split(":");
            hours1 = fields[0];
            mins1 = fields[1];
            if (hours1 == "12") hours1 = "0";
        } else {
            startTime = startTime.replace("pm", "");
            startTime = startTime.replace("PM", "");
            var fields = startTime.split(":");
            hours1 = fields[0];
            mins1 = fields[1];
            if (hours1 != "12") hours1 = hours1 * 1 + 12;
        }
        if (endTime.indexOf("AM") > -1 || endTime.indexOf("am") > -1) {
            endTime = endTime.replace("am", "");
            endTime = endTime.replace("AM", "");
            var fields = endTime.split(":");
            hours2 = fields[0];
            mins2 = fields[1];
            if (hours2 == "12") hours2 = "0";
        } else {
            endTime = endTime.replace("pm", "");
            endTime = endTime.replace("PM", "");
            var fields = endTime.split(":");
            hours2 = fields[0];
            mins2 = fields[1];
            if (hours2 != "12") hours2 = hours2 * 1 + 12;
        }
        var stime = mins1 != undefined ? hours1 * 60 + mins1 * 1 : hours1 * 60;
        var etime = mins2 != undefined ? hours2 * 60 + mins2 * 1 : hours2 * 60;

        var diff = etime - stime;
        var x = diff / 60;
        return x;
    }

    function fun_calculator() {
        var mon_1 = [];
        var tue_1 = [];
        var wed_1 = [];
        var thu_1 = [];
        var fri_1 = [];
        var sat_1 = [];
        var sun_1 = [];
        $(".mon-sessions")
            .find("p")
            .each(function () {
                var p1 = $(this).html();
                mon_1.push(some(p1));
            });
        $(".tue-sessions")
            .find("p")
            .each(function () {
                var p1 = $(this).html();
                tue_1.push(some(p1));
            });
        $(".wed-sessions")
            .find("p")
            .each(function () {
                var p1 = $(this).html();
                wed_1.push(some(p1));
            });
        $(".thu-sessions")
            .find("p")
            .each(function () {
                var p1 = $(this).html();
                thu_1.push(some(p1));
            });
        $(".fri-sessions")
            .find("p")
            .each(function () {
                var p1 = $(this).html();
                fri_1.push(some(p1));
            });
        $(".sat-sessions")
            .find("p")
            .each(function () {
                var p1 = $(this).html();
                sat_1.push(some(p1));
            });
        $(".sun-sessions")
            .find("p")
            .each(function () {
                var p1 = $(this).html();
                sun_1.push(some(p1));
            });
        var total_hours = 0;
        for (var i = 0; i < mon_1.length; i++) total_hours += mon_1[i];
        for (var i = 0; i < tue_1.length; i++) total_hours += tue_1[i];
        for (var i = 0; i < wed_1.length; i++) total_hours += wed_1[i];
        for (var i = 0; i < thu_1.length; i++) total_hours += thu_1[i];
        for (var i = 0; i < fri_1.length; i++) total_hours += fri_1[i];
        for (var i = 0; i < sat_1.length; i++) total_hours += sat_1[i];
        for (var i = 0; i < sun_1.length; i++) total_hours += sun_1[i];
        return total_hours;
    }

    $(document).ready(function () {
        $("#btnLaunch").click(function () {
            $("#myModal").modal("show");
        });
        $("#btnSave").click(function () {
            var hourly_charges = document.getElementById("hourly_charges");
            var suggestedPrice = document.getElementById("suggestedPrice");
            var fCharge = document.getElementById("fCharge");
            var str = fCharge.innerHTML;
            var price = parseInt(str.split(":")[1]);
            if (price > 0) {
                hourly_charges.value = price;
                suggestedPrice.innerHTML = "Recommended - Estimate Charges: " + price;
            } else {
                hourly_charges.value = "";
                suggestedPrice.innerHTML = "";
            }
            fun_potential();
            $("#myModal").modal("hide");
        });
    });

    $(document).ready(function () {
        var n3 = 1;
        $("#amen_add").on("click", function () {
            var val = document.getElementById("amenities").value;
            $("#amenities").val("");
            if (val != "") {
                $("#amen").append(
                    '<li class="amen_li" id="amen_li' +
                        n3 +
                        '"><span id="preview_amen">' +
                        val +
                        '</span>   <input type="hidden" name="amen[]" value="' +
                        val +
                        '"/>   <span class="removeclass" onclick="fun5(' +
                        n3 +
                        ')"> &nbsp; x &nbsp;</span></li>'
                );
                $("#amen_preview").append('<li id="amen_li2' + n3 + '">' + val + "</li>");
                n3++;
            }
            $("#drop")
                .find("option[value='" + val + "']")
                .prop("disabled", true);
        });
    });

    //myModal1
    $(document).ready(function () {
        $("#space_profile_image").change(function () {
            $("#im").css("display", "block");
            if (this.files && this.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $("#im").attr("src", e.target.result);
                };
                reader.readAsDataURL(this.files[0]); // convert to base64 string
            }
        });
    });

    $(function () {
        var x = 1;
        $("#addworkspace").click(function () {
            $("#myModal1").modal("show");
        });
        var workspace_names = [<?php echo $ws_names ?>];
        $("#save_data").click(function () {
            if ($("#description").val() == "" && $("#hourly_charges").val() == "" && $("#available_from").val() == "" && $("#workspace_name").val() == "" && $("#space_profile_image").val() == "") {
                $("#alert_hide").css("display", "block");
                $("#alert_charges").css("display", "block");
                $("#alert_available").css("display", "block");
                $("#alert_space").css("display", "block");
                $("#alert_work_name").css("display", "block");
                $("#myModal1").scrollTop(0);
            } else if ($("#workspace_name").val() == "") {
                $("#alert_work_name").css("display", "block");
                $("#myModal1").scrollTop(0);
            } else if ($("#workspace_name").val().length > 15) {
                $("#alert_work_length").css("display", "block");
                $("#myModal1").scrollTop(0);
            } else if ($("#available_from").val() == "") {
                $("#alert_available").css("display", "block");
                $("#myModal1").scrollTop(0);
            } else if ($("#hourly_charges").val() == "") {
                $("#alert_charges").css("display", "block");
            } else if ($("#description").val() == "") {
                $("#alert_hide").css("display", "block");
            } else if ($("#space_profile_image").val() == "") {
                $("#alert_space").css("display", "block");
            }
            //saving data to workspace_modal
            else {
                $("#alert_hide").hide();
                $("#alert_charges").hide();
                $("#alert_available").hide();
                $("#alert_work_name").hide();
                $("#alert_space").hide();
                var temp = true;
                // for (var i = 0; i < workspace_names.length; i++) {
                    if (workspace_names.includes($("#workspace_name").val())) {
                        temp = false;
                        $("#alert_work_unique_name").css("display", "block");
                        $("#myModal1").scrollTop(0);
                        //break;
                    // }
                }
                if (temp == true) {
                    $("#alert_work_unique_name").hide();
                    var idi = document.createElement("div");
                    idi.id = "counter" + x;
                    $("#workspace_modal").append(idi);
                    var idi_clone = document.createElement("div");
                    idi_clone.id = "counter_clone" + x;
                    $("#workspace_modal2").append(idi_clone);
                    var val_name = $("#workspace_name").val();
                    workspace_names.push(val_name);
                    $("#counter" + x).append("<h2>" + val_name + '&nbsp;&nbsp;&nbsp;&nbsp;<span class="removeclass" style="color:red;" onclick="dele(' + x + ');">   X </span></h2>');
                    $("#counter_clone" + x).append("<h4>" + val_name + "</h4>");
                    var img1 = $("<img />").attr({
                        id: "im1",
                        alt: "Workspace profile image",
                        width: 100,
                        height: 110,
                    });
                    img1.attr("src", $("#im").attr("src"));
                    $("#counter" + x).append(img1);
                    $(img1)
                        .clone()
                        .appendTo($("#counter_clone" + x));
                    var iDiv1 = document.createElement("p");
                    iDiv1.id = "hourly";
                    $("#counter" + x).append(iDiv1);
                    //var val1 = $("#hourly_charges").val();
                    //if (val1 != "") iDiv1.innerHTML = "<u><b>Hourly Charges</b></u> : <span>" + val1 + "</span>";
                    $(iDiv1)
                        .clone()
                        .appendTo($("#counter_clone" + x));
                    var iDiv2 = document.createElement("p");
                    iDiv2.id = "desc";
                    $("#counter" + x).append(iDiv2);
                    var val2 = $("#description").val();
                    if (val2 != "") iDiv2.innerHTML = "<u><b>Description</b> </u>: <span>" + val2 + "</span>";
                    $(iDiv2)
                        .clone()
                        .appendTo($("#counter_clone" + x));
                    var iDiv3 = document.createElement("p");
                    iDiv3.id = "cap";
                    $("#counter" + x).append(iDiv3);
                    var val3 = $("#capacity").val();
                    if (val3 != "") iDiv3.innerHTML = "<u><b>Capacity</b> </u>: <span>" + val3 + "</span>";
                    $(iDiv3)
                        .clone()
                        .appendTo($("#counter_clone" + x));
                    var iDiv32 = document.createElement("p");
                    iDiv32.id = "avail_from";
                    $("#counter" + x).append(iDiv32);
                    var val32 = $("#available_from").val();
                    iDiv32.innerHTML = "<u><b>Available From</b> </u>: <span>" + val32 + "</span>";
                    $(iDiv32)
                        .clone()
                        .appendTo($("#counter_clone" + x));
                    //time pickers
                    var times = document.createElement("p");
                    $("#counter" + x).append(times);
                    times.innerHTML = "<u><b>Time Slots</b></u> :";
                    $(times)
                        .clone()
                        .appendTo($("#counter_clone" + x));
                    var iDiv4 = document.createElement("p");
                    iDiv4.id = "mon-id";
                    $("#counter" + x).append(iDiv4);
                    var m = 0;
                    $(".mon-sessions")
                        .find("p")
                        .each(function () {
                            if (m == 0) {
                                iDiv4.innerHTML = "&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp &nbsp; &nbsp;<b>Mon </b> : ";
                                iDiv4.innerHTML += "<span>" + $(this).html() + "</span>";
                                m++;
                            } else iDiv4.innerHTML += " , <span>" + $(this).html() + "</span>";
                        });
                    $(iDiv4)
                        .clone()
                        .appendTo($("#counter_clone" + x));
                    var iDiv5 = document.createElement("p");
                    iDiv5.id = "tue-id";
                    var t = 0;
                    $("#counter" + x).append(iDiv5);
                    $(".tue-sessions")
                        .find("p")
                        .each(function () {
                            if (t == 0) {
                                iDiv5.innerHTML = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp&nbsp; &nbsp;&nbsp; &nbsp;&nbsp <b>Tue </b> : ";
                                iDiv5.innerHTML += "<span>" + $(this).html() + "</span>";
                                t++;
                            } else iDiv5.innerHTML += " , <span>" + $(this).html() + "</span>";
                        });
                    $(iDiv5)
                        .clone()
                        .appendTo($("#counter_clone" + x));
                    var iDiv7 = document.createElement("p");
                    iDiv7.id = "wed-id";
                    var w = 0;
                    $("#counter" + x).append(iDiv7);
                    $(".wed-sessions")
                        .find("p")
                        .each(function () {
                            if (w == 0) {
                                iDiv7.innerHTML = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp&nbsp; &nbsp;&nbsp; &nbsp;&nbsp<b> Wed </b>: ";
                                iDiv7.innerHTML += "<span>" + $(this).html() + "</span>";
                                w++;
                            } else iDiv7.innerHTML += " , <span>" + $(this).html() + "</span>";
                        });
                    $(iDiv7)
                        .clone()
                        .appendTo($("#counter_clone" + x));
                    var iDiv8 = document.createElement("p");
                    iDiv8.id = "thu-id";
                    var th = 0;
                    $("#counter" + x).append(iDiv8);
                    $(".thu-sessions")
                        .find("p")
                        .each(function () {
                            var tn = $(this).html();
                            if (th == 0) {
                                iDiv8.innerHTML = " &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp&nbsp; &nbsp;&nbsp; &nbsp; &nbsp&nbsp<b> Thu </b>: ";
                                iDiv8.innerHTML += "<span>" + tn + "</span>";
                                th++;
                            } else iDiv8.innerHTML += " , <span>" + tn + "</span>";
                        });
                    $(iDiv8)
                        .clone()
                        .appendTo($("#counter_clone" + x));
                    var iDiv9 = document.createElement("p");
                    iDiv9.id = "fri-id";
                    var f = 0;
                    $("#counter" + x).append(iDiv9);
                    $(".fri-sessions")
                        .find("p")
                        .each(function () {
                            if (f == 0) {
                                iDiv9.innerHTML = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp&nbsp; &nbsp;&nbsp; &nbsp;&nbsp<b>  Fri </b> : ";
                                iDiv9.innerHTML += "<span>" + $(this).html() + "</span>";
                                f++;
                            } else iDiv9.innerHTML += " , <span>" + $(this).html() + "</span>";
                        });
                    $(iDiv9)
                        .clone()
                        .appendTo($("#counter_clone" + x));
                    var iDiv10 = document.createElement("p");
                    iDiv10.id = "sat-id";
                    var s = 0;
                    $("#counter" + x).append(iDiv10);
                    $(".sat-sessions")
                        .find("p")
                        .each(function () {
                            if (s == 0) {
                                iDiv10.innerHTML = "&nbsp; &nbsp; &nbsp&nbsp; &nbsp; &nbsp; &nbsp; &nbsp&nbsp; &nbsp; &nbsp;&nbsp; &nbsp;<b>Sat </b> :  ";
                                iDiv10.innerHTML += "<span>" + $(this).html() + "</span>";
                                s++;
                            } else iDiv10.innerHTML += " , <span>" + $(this).html() + "</span>";
                        });
                    $(iDiv10)
                        .clone()
                        .appendTo($("#counter_clone" + x));
                    var iDiv11 = document.createElement("p");
                    iDiv11.id = "sun-id";
                    var su = 0;
                    $("#counter" + x).append(iDiv11);
                    $(".sun-sessions")
                        .find("p")
                        .each(function () {
                            if (su == 0) {
                                iDiv11.innerHTML = "&nbsp; &nbsp; &nbsp&nbsp; &nbsp; &nbsp; &nbsp; &nbsp&nbsp; &nbsp; &nbsp;&nbsp; &nbsp;<b>Sun </b> :  ";
                                iDiv11.innerHTML += "<span>" + $(this).html() + "</span>";
                                su++;
                            } else iDiv11.innerHTML += " , <span>" + $(this).html() + "</span>";
                        });
                    $(iDiv11)
                        .clone()
                        .appendTo($("#counter_clone" + x));
                    //timepickers ends
                    var iDiv6 = document.createElement("br");
                    $("#counter" + x).append(iDiv6);
                    $(iDiv6)
                        .clone()
                        .appendTo($("#counter_clone" + x));
                    //reseting modal input fields
                    $("#myModal1")
                        .find(":input")
                        .each(function () {
                            switch (this.type) {
                                case "password":
                                case "text":
                                case "file":
                                case "select-one":
                                case "select-multiple":
                                case "date":
                                case "number":
                                case "tel":
                                case "email":
                                    $(this).val("");
                                    break;
                                case "checkbox":
                                case "radio":
                                    this.checked = false;
                                    break;
                            }
                        });
                    $("#im").attr("src", "");
                    $("#im").css("display", "none");
                    $(".alert-container").empty();
                    $("#work_alert").hide();
                    x++;
                    $("#myModal1").modal("hide");
                    //allow at most 10 workspaces
                    if (x >= 11) {
                        $("#addworkspace").css("visibility", "hidden");
                        $("#addworkspace").hide();
                    }
                    $("#alert_hide").hide();
                }
            }
        });
    });
</script>
<script>
    //cost calculation
    var hourly_charges = document.getElementById("hourly_charges");
    var suggestedPrice = document.getElementById("suggestedPrice");
    var fCharge = document.getElementById("fCharge");
    var operational_cost = document.getElementById("operational_cost");
    var workspace_area = document.getElementById("workspace_area");
    var common_area = document.getElementById("common_area");
    var workspace_count = document.getElementById("workspace_count");
    var profit_loading = document.getElementById("profit_loading");
    var entire_space = document.getElementById("entire_space");
    var partial_space = document.getElementById("partial_space");
    //hourly_charges.addEventListener("focusout", verify_hourly_charges);
    entire_space.addEventListener("change", calcPrice);
    partial_space.addEventListener("change", calcPrice);
    operational_cost.addEventListener("focusout", calcPrice);
    workspace_area.addEventListener("focusout", calcPrice);
    common_area.addEventListener("focusout", calcPrice);
    workspace_count.addEventListener("focusout", calcPrice);
    profit_loading.addEventListener("focusout", calcPrice);

    function verify_hourly_charges() {
        if (hourly_charges.value > 0) {
            var str = suggestedPrice.innerHTML;
            var price = parseInt(str.split(":")[1]);
            if (!((price > 0) & (hourly_charges.value <= price))) {
                alert("Price must be less then suggested price");
                hourly_charges.value = "";
            }
        }
    }

    function calcPrice() {
        var operationalCost = parseInt(operational_cost.value);
        var profitLoading = parseInt(profit_loading.value);
        var workspaceArea = parseInt(workspace_area.value);
        var commonArea = parseInt(common_area.value);
        var workspaceCount = parseInt(workspace_count.value);
        if ((operationalCost > 0) & (profitLoading > 0)) {
            if (partial_space.checked) {
                if ((workspaceArea > 0) & (commonArea > 0) & (workspaceCount > 0)) {
                    var p1 = (operationalCost * (workspaceArea + commonArea / workspaceCount)) / 100 / 300;
                    var p2 = (p1 * profitLoading) / 100;
                    var p3 = Math.round(p1 + p2);
                    fCharge.innerHTML = "Estimate per hour charges: " + p3;
                } else fCharge.innerHTML = "";
            } else {
                var p1 = operationalCost / 300;
                var p2 = (p1 * profitLoading) / 100;
                var p3 = Math.round(p1 + p2);
                fCharge.innerHTML = "Estimate per hour charges: " + p3;
            }
        } else {
            fCharge.innerHTML = "";
        }
    }

    //radio button
    $(document).ready(function () {

       // $('[data-bs-toggle="popover"]').popover();
       var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
  return new bootstrap.Popover(popoverTriggerEl)
})
        var radio_selected = $("input[name=user_type]:checked", "#form1").attr("id");
        var targetBox = $("." + radio_selected);
        $(".box2").not(targetBox).hide();
        $(targetBox).show();
        $('input[type="radio"]').click(function () {
            var inputValue = $(this).attr("id");
            var targetBox = $("." + inputValue);
            $(".box2").not(targetBox).hide();
            $(targetBox).show();
        });
    });
</script>
<script>
    var form_count = 1,
        form_count_form,
        next_form;
    var total_forms = 3;
    function dele(x) {
        $("#counter" + x).hide();
        $("#counter" + x).remove();
        $("#counter_clone" + x).hide();
        $("#counter_clone" + x).remove();
    }
    function fun2(n) {
        $("#util_li" + n).hide();
        $("#util_li" + n).remove();
        $("#util_li2" + n).hide();
        $("#util_li2" + n).remove();
    }
    function fun3(n) {
        $("#paid_util_li" + n).hide();
        $("#paid_util_li" + n).remove();
        $("#paid_util_li2" + n).hide();
        $("#paid_util_li2" + n).remove();
    }
    function fun4(n) {
        $("#oper_li" + n).hide();
        $("#oper_li" + n).remove();
        $("#oper_li2" + n).hide();
        $("#oper_li2" + n).remove();
    }
    function fun5(n) {
        $("#amen_li" + n).hide();
        $("#amen_li" + n).remove();
        $("#amen_li2" + n).hide();
        $("#amen_li2" + n).remove();
    }
    function preview1() {
        if ($("#space_image").val() == "" && $("#identity_proof").val() == "" && $("#space_ownership_docs").val() == "") {
            $("#space_image_alert1").show();
            $("#identity_alert1").show();
            $("#space_ownership_alert1").show();
            $("html, body").animate({ scrollTop: 0 }, 100);
        } else if ($("#space_image").val() == "") {
            $("#space_image_alert1").show();
            $("html, body").animate({ scrollTop: 0 }, 100);
        } else if ($("#identity_proof").val() == "") {
            $("#identity_alert1").show();
            $("html, body").animate({ scrollTop: 0 }, 100);
        } else if ($("#space_ownership_docs").val() == "") {
            $("#space_ownership_alert1").show();
            $("html, body").animate(
                {
                    scrollTop: $("#space_image").offset().top,
                },
                100
            );
        } else if ($("#vehicle1").prop("checked") == false) {
            $("#terms_alert").show();
        } else {
            $(".info").hide();
            $(".preview").show();
            //$("#preview_oper").clone().appendTo($("#oper_preview"));
        }
    }
    function alert_h() {
        $("#alert_hide").hide();
    }
    function alert_img() {
        $("#alert_space").hide();
    }
    function fun_pin() {
        $("#alert_pin").hide();
    }
    function fun_deposit() {
        $("#alert_deposit").hide();
    }
    function fun_noc() {
        $("#noc_alert").hide();
    }
    function fun_setup() {
        $("#alert_setup").hide();
        var x = $.trim($('[name="setup_description"]').val())
            .split(" ")
            .filter(function (v) {
                return v !== "";
            }).length;
        if (x >= 25) $("#alert_setup2").hide();
        $("#description").val($("#setup_description").val());
    }
    function fun_charges() {
        $("#alert_charges").hide();
    }
    function fun_avail() {
        $("#alert_available").hide();
    }
    function fun_work() {
        $("#alert_work_unique_name").hide();
        $("#alert_work_name").hide();
        var x = $("#workspace_name").val().length;
        if (x <= 15) $("#alert_work_length").hide();
    }
    function show_edit() {
        $(".preview").hide();
        $(".info").show();
        $("#document").fadeIn();
        $("#documnets_title").fadeIn();
    }
    function show_next(id, nextid, nexttitle) {
        var x = 30;
        // var x = $.trim($('[name="setup_description"]').val()).split(' ').filter(function (v) { return v !== '' }).length;
        if ($("#address").val() == "" && $("#setup_description").val() == "" && $("#security_deposit :selected").val() == "") {
            $("#alert_pin").show();
            $("#alert_setup").show();
            $("#alert_deposit").show();
            $("html, body").animate(
                {
                    scrollTop: $("#locality").offset().top,
                },
                100
            );
        }
        if ($("#address").val() == "") {
            $("#alert_pin").show();
            $("html, body").animate(
                {
                    scrollTop: $("#locality").offset().top,
                },
                100
            );
        }
        if ($("#security_deposit :selected").val() == "") {
            $("#alert_deposit").show();
            $("html, body").animate(
                {
                    scrollTop: $("#locality").offset().top,
                },
                100
            );
        }
        if ($("#setup_description").val() == "") {
            $("#alert_setup").show();
            $("html, body").animate(
                {
                    scrollTop: $("#locality").offset().top,
                },
                100
            );
        }
        if (x < 25) {
            $("#alert_setup2").show();
            $("html, body").animate(
                {
                    scrollTop: $("#locality").offset().top,
                },
                100
            );
        }
        if ($("#address").val() != "" && $("#setup_description").val() != "" && $("#security_deposit :selected").val() != "" && x >= 25) {
            if (id == "workplace") {
                if ($("#workspace_modal").is(":empty")) {
                    $("#work_alert").show();
                } else {
                    $("#work_alert").hide();
                    document.getElementById("setup").style.display = "none";
                    document.getElementById("workplace").style.display = "none";
                    document.getElementById("document").style.display = "none";
                    document.getElementById("setup_title").style.display = "none";
                    document.getElementById("workspace_title").style.display = "none";
                    document.getElementById("documnets_title").style.display = "none";
                    $("#" + nextid).fadeIn();
                    $("#" + nexttitle).fadeIn();
                    setProgressBar(++form_count);
                }
            } else {
                document.getElementById("setup").style.display = "none";
                document.getElementById("workplace").style.display = "none";
                document.getElementById("document").style.display = "none";
                document.getElementById("setup_title").style.display = "none";
                document.getElementById("workspace_title").style.display = "none";
                document.getElementById("documnets_title").style.display = "none";
                $("#" + nextid).fadeIn();
                $("#" + nexttitle).fadeIn();
                setProgressBar(++form_count);
            }
        }
    }
    function show_prev(previd, prevtitle) {
        document.getElementById("setup").style.display = "none";
        document.getElementById("workplace").style.display = "none";
        document.getElementById("document").style.display = "none";
        document.getElementById("setup_title").style.display = "none";
        document.getElementById("workspace_title").style.display = "none";
        document.getElementById("documnets_title").style.display = "none";
        $("#" + previd).fadeIn();
        $("#" + prevtitle).fadeIn();
        setProgressBar(--form_count);
    }
    setProgressBar(form_count);
    function setProgressBar(curStep) {
        var percent = parseFloat(100 / total_forms) * curStep;
        percent = percent.toFixed();
        $(".progress-bar")
            .css("width", percent + "%")
            .html(percent + "%");
    }
</script>
<script>
    function initMap() {
        var uluru = { lat: 28.501859, lng: 77.41032 };
        var map = new google.maps.Map(document.getElementById("map"), {
            zoom: 16,
            center: uluru,
        });
        geocoder = new google.maps.Geocoder();
        codeAddress(geocoder, map);
    }
    var a1 = document.getElementById("city").value;
    var a2 = document.getElementById("locality").value;
    var a3 = document.getElementById("landmark").value;
    var address = a3 + "," + a2 + "," + a1;
    function codeAddress(geocoder, map) {
        geocoder.geocode({ address: address }, function (results, status) {
            if (status === "OK") {
                map.setCenter(results[0].geometry.location);
                var marker = new google.maps.Marker({
                    map: map,
                    position: results[0].geometry.location,
                    draggable: true,
                });
                $("#map_loc1").val(marker.getPosition());
                var adress = "";
                geocoder = new google.maps.Geocoder();
                geocoder.geocode({ latLng: marker.getPosition() }, function (results, status) {
                    if (status == google.maps.GeocoderStatus.OK) {
                        adress = results[0].formatted_address;
                        $("#map_loc").val(adress);
                    }
                });
                google.maps.event.addListener(marker, "dragend", function () {
                    geocodePosition(marker.getPosition());
                });
            } else {
                alert("Geocode was not successful for the following reason: " + status);
            }
        });
    }
    function geocodePosition(pos) {
        var adress = "";
        geocoder = new google.maps.Geocoder();
        geocoder.geocode({ latLng: pos }, function (results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                adress = results[0].formatted_address;
                $("#map_loc1").val(pos);
                $("#map_loc").val(adress);
            } else {
                alert("Cannot determine address at this location : " + status);
            }
        });
    }
</script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAFNd1j6Zcrmf9Sl8jQ9wKn648EtGKlrKg&callback=initMap"></script>
<style>
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
    /* Firefox */
    input[type="number"] {
        -moz-appearance: textfield;
    }
    .popover {
        background: #2275ff !important;
        color: red;
    }
    sup {
        font-size: 1.1em;
        color: #2275ff;
    }
    sup:hover {
        color: black;
    }
    .popover.upper .arrow:after {
        border-bottom-color: #13408a;
        color: red;
    }
    /*koyel*/
    .modal-tall .modal-body {
        min-height: 325px;
        padding-right: 0;
    }
    ul {
        list-style-type: none;
    }
    li[class="amen_li"] {
        float: left;
    }
    li[class="amen_li"]:nth-child(5n + 1) {
        clear: left;
    }
    li[class="oper_li"] {
        float: left;
    }
    li[class="oper_li"]:nth-child(5n + 1) {
        clear: left;
    }
    li[class="util_li"] {
        float: left;
    }
    li[class="util_li"]:nth-child(5n + 1) {
        clear: left;
    }
    li[class="paid_util_li"] {
        float: left;
    }
    li[class="paid_util_li"]:nth-child(5n + 1) {
        clear: left;
    }
    .modal {
        overflow-y: auto !important;
    }
    .removeclass {
        cursor: pointer;
    }
    .hover-style-b {
        cursor: pointer;
    }
    #nxt {
        float: right !important;
    }
    #amen_add {
        cursor: pointer;
    }
    .progress {
        height: 22px;
    }
    #workplace,
    #document {
        display: none;
    }
    .fas {
        color: #2275ff;
    }
    .show-loder {
        position: fixed;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        background-color: #fff;
        z-index: 9999;
        opacity: 0.6;
        text-align: center;
    }
    .show-loder img {
        width: 80px;
        padding-top: 18%;
    }
</style>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
