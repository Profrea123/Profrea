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
$sql_space_types = "SELECT id,name FROM space_types WHERE rowstate = 1";
$con_space_types = $db_connection->getDbHandler()->query($sql_space_types);
if($con_space_types)
{
	$res_space_types = $con_space_types->fetchAll();
}
$sql_city = "SELECT id,name FROM city WHERE rowstate = 1";
$con_city = $db_connection->getDbHandler()->query($sql_city);
if($con_city)
{
	$res_city = $con_city->fetchAll();
}
$sql_city1 = "SELECT id,name FROM city WHERE rowstate != 1";
$con_city1 = $db_connection->getDbHandler()->query($sql_city1);
if($con_city1)
{
	$res_city1 = $con_city1->fetchAll();
}
$sql_locality = "SELECT id,name FROM locality";
$con_locality = $db_connection->getDbHandler()->query($sql_locality);
if($con_locality)
{
	$res_locality = $con_locality->fetchAll();
}
?>
<!-- slider image only -->
<section class="bg-header-slider position-relative">
	<div class="container-fluid p-0">
		<div class="row">
			<div class="col-md-12 p-0">
				<div id="owl-sliderbg" class="owl-carousel owl-theme">
					<div class="item firstslider">
						<!-- <img src="../images/Assets/banner1.jpg" class="img-fluid w-100" alt="" title=""> -->
					</div>
					<div class="item secondslider">
						<!-- <img src="../images/Assets/banner1.jpg" class="img-fluid w-100" alt="" title=""> -->
					</div>
					<div class="item thirdslider">
						<!-- <img src="../images/Assets/banner1.jpg" class="img-fluid w-100" alt="" title=""> -->
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<!-- form-layout -->
<!-- <section class="form-toplayout">	
	<div class="container">
		<div class="row">
			<div class="col-lg-5 col-md-12 pt-5 pb-5">
				<div class="bg-white top-box-in p-md-5 p-3">
					<form id="findForm" role="form" action="#" method="post" enctype="multipart/form-data" data-parsley-validate="">
                        <h1 class="header-title f1">Perfect workspace </h1>
						<div id="owl-sliderbg-cont" class="owl-carousel owl-theme">
							<div class="item ps-3 ps-md-0">
                        		<h5 class="sub-header-title f1">For Medical</h5>
							</div>
							<div class="item ps-3 ps-md-0">
                        		<h5 class="sub-header-title f1">For Educational</h5>
							</div>
							<div class="item ps-3 ps-md-0">
                        		<h5 class="sub-header-title f1">For Fitness</h5>
							</div>
						</div>

                        <h5 class="sub-header-title f1">For professionals</h5> -->

                        <!-- <h5 class="sub-title-header-title pt-4 f1">Select Industry:</h5>
                        <div class="row pt-3 p-industry">
                        	<input type="hidden" name="industry_id" id="industry_id" value="All"/>
                            <?php
                            $i = 0;
                            foreach($res_space_types as $row_space_type)
                            {
                            	$i++;
                                ?>
                                <div class="col-md-4 col-sm-4 col-6 mb-4 mb-md-0">
                                    <div class="industry-box" data-industry_id="<?php echo $row_space_type['id']; ?>">
                                        <img src="../images/a<?php echo $i; ?>.png" class="img-fluid" alt="" title="">
                                        <h2 class="title-cat text-grey pt-3"><?php echo $row_space_type['name']; ?></h2>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>

                             <div class="col-md-4 col-sm-4 col-6 mb-4 mb-md-0">
                                <div class="industry-box">
                                    <a href="medical.php">
                                        <img src="../images/a1.png" class="img-fluid" alt="" title="">
                                        <h2 class="title-cat text-grey pt-3">Medical</h2>
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4 col-6 mb-4 mb-md-0">
                                <div class="industry-box">
                                    <a href="educational.php">
                                        <img src="../images/a2.png" class="img-fluid" alt="" title="">
                                        <h2 class="title-cat text-grey pt-3">Educational</h2>
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4 col-6 mb-4 mb-md-0">
                                <div class="industry-box">
                                    <a href="fitness.php">
                                        <img src="../images/a3.png" class="img-fluid" alt="" title="">
                                        <h2 class="title-cat text-grey pt-3">Fitness</h2>
                                    </a>
                                </div>
                            </div> -->
                        <!-- </div>
                        <h5 class="sub-title-header-title pt-5 f1">Select City:</h5>
                        <div class="row pt-3 p-city">
                        	<input type="hidden" name="city_id" id="city_id" value="All"/>
                        	<?php
                            $i = 0;
                            foreach($res_city as $row_city)
                            {
                            	$i++;
                            	?>
                            	<div class="col-md-6 col-sm-6 mb-4 mb-md-2">
	                                <div class="industry-box-city" data-city_id="<?php echo $row_city['id']; ?>">
                                        <div class="row align-items-center">
                                            <div class="col-md-5 col-5">
                                                <img src="../images/c<?php echo $i; ?>.png" class="img-fluid" alt="" title="">
                                            </div>
                                            <div class="col-md-7 col-7">
                                                <h4 class="cityname-header mb-0 text-grey"><?php echo $row_city['name']; ?></h4>
                                            </div>
                                        </div>
	                                </div>
	                            </div>
                            	<?php
                            }
                            ?>
                            <div class="col-md-6 col-sm-6 mb-4 mb-md-2">
                                <div class="industry-box-city" data-city_id="others">
                                    <div class="row align-items-center">
                                        <h4 class="cityname-header mb-0 text-grey">Others</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 mb-4 mb-md-2">
                            	<select name="other_city_id" id="other_city_id" class="form-select" aria-label="Default select example" style="display:none;">
                                    <option value="All" selected>All City</option>
                                    <?php
		                            $i = 0;
		                            foreach($res_city1 as $row_city1)
		                            {
		                            	$i++;
		                            	?>
                                    	<option value="<?php echo $row_city1['id']; ?>"><?php echo $row_city1['name']; ?></option>
                                    	<?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="row pt-4 align-items-center">
                            <div class="col-md-6">
                                <h5 class="sub-title-header-title f1 mb-0">Select Location:</h5>
                            </div>
                            <div class="col-md-6 pt-3 pt-md-0">
                                <select name="location_id" id="location_id" class="form-select" aria-label="Default select example">
                                    <option value="All" selected>All Location</option>
                                    <?php
		                            $i = 0;
		                            foreach($res_locality as $row_locality)
		                            {
		                            	$i++;
		                            	?>
                                    	<option value="<?php echo $row_locality['id']; ?>"><?php echo $row_locality['name']; ?></option>
                                    	<?php
                                    }
                                    ?>
                                </select>
                            </div>

                        </div> -->
	                    <!-- <div class="find-workspacebtn pt-4"> -->
	                    	<!-- <a href="spaces.php">Find Workspaces</a> -->
                            <!-- <button type="submit" class="log-inbtn">Find Workspaces</button>
                        </div>
                    </form>
                    <div id="findForm_status"></div>
				</div>
			</div>
		</div>
	</div>	
</section> -->

<!-- form layout -->

 <section class="bg-header-index form-toplayout">

	<div class="container">
		<div class="row">
			<div class="col-lg-5 col-md-12 pt-5 pb-5">
				<div class="bg-white top-box-in p-md-5 p-3">
					<form id="findForm" role="form" action="#" method="post" enctype="multipart/form-data" data-parsley-validate="">
                        <h1 class="header-title f1">Perfect workspace <h1>
                        <div id="owl-sliderbg-cont" class="owl-carousel owl-theme">

							<div class="item">
                        		<h5 class="sub-header-title f1">For Medical</h5>
							</div>
							<div class="item">
                        		<h5 class="sub-header-title f1">For Educational</h5>
							</div>
							<div class="item">

                        		<h5 class="sub-header-title f1">For Fitness</h5>
							</div>
						</div>
                        <h5 class="sub-title-header-title pt-4 f1">Select Industry:</h5>
                        <div class="row pt-3 p-industry">
                        	<input type="hidden" name="industry_id" id="industry_id" value="All"/>
                            <?php
                            $i = 0;
                            foreach($res_space_types as $row_space_type)
                            {
                            	$i++;
                                ?>
                                <div class="col-md-4 col-sm-4 col-6 mb-4 mb-md-0">
                                    <a href="#"><div class="industry-box" data-industry_id="<?php echo ($row_space_type['id'] == 1?"Clinic":($row_space_type['id'] == 2?"Institute":($row_space_type['id'] == 3?"Wellness Center":""))); ?>">
                                        <img src="images/a<?php echo $i; ?>.png" class="img-fluid" alt="" title="">
                                        <h2 class="title-cat text-grey pt-3"><?php echo $row_space_type['name']; ?></h2>
                                    </div>
									</a>
                                </div>
                                <?php
                            }
                            ?>

                           <!--  <div class="col-md-4 col-sm-4 col-6 mb-4 mb-md-0">

                                <div class="industry-box">
                                    <a href="medical">
                                        <img src="images/a1.png" class="img-fluid" alt="" title="">
                                        <h2 class="title-cat text-grey pt-3">Medical</h2>
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4 col-6 mb-4 mb-md-0">
                                <div class="industry-box">
                                    <a href="educational">
                                        <img src="images/a2.png" class="img-fluid" alt="" title="">
                                        <h2 class="title-cat text-grey pt-3">Educational</h2>
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4 col-6 mb-4 mb-md-0">
                                <div class="industry-box">
                                    <a href="fitness">
                                        <img src="images/a3.png" class="img-fluid" alt="" title="">
                                        <h2 class="title-cat text-grey pt-3">Fitness</h2>
                                    </a>
                                </div>

                            </div>  -->
                        </div>

                        <h5 class="sub-title-header-title pt-5 f1">Select City:</h5>
                        <div class="row pt-3 p-city">
                        	<input type="hidden" name="city_id" id="city_id" value="All"/>
                        	<?php
                            $i = 0;
                            foreach($res_city as $row_city)
                            {
                            	$i++;
                            	?>
                            	<div class="col-md-6 col-sm-6 mb-4 mb-md-2">
	                                <div class="industry-box-city" data-city_id="<?php echo $row_city['name']; ?>">
                                        <div class="row align-items-center">
                                            <div class="col-md-5 col-5">
                                                <img src="images/c<?php echo $i; ?>.png" class="img-fluid" alt="" title="">
                                            </div>
                                            <div class="col-md-7 col-7">
                                                <h4 class="cityname-header mb-0 text-grey"><?php echo $row_city['name']; ?></h4>
                                            </div>
                                        </div>
	                                </div>
	                            </div>
                            	<?php
                            }
                            ?>
                            <div class="col-md-6 col-sm-6 mb-4 mb-md-2">
                                <div class="industry-box-city" data-city_id="others">
                                    <div class="row align-items-center">
                                        <h4 class="cityname-header mb-0 text-grey">Others</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 mb-4 mb-md-2">
                            	<select name="other_city_id" id="other_city_id" class="form-select" aria-label="Default select example" style="display:none;">
                                    <option value="All" selected>All City</option>
                                    <?php
		                            $i = 0;
		                            foreach($res_city1 as $row_city1)
		                            {
		                            	$i++;
		                            	?>
                                    	<option value="<?php echo $row_city1['name']; ?>"><?php echo $row_city1['name']; ?></option>
                                    	<?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>                        

	                    <div class="find-workspacebtn pt-4">
	                    	<!-- <a href="spaces">Find Workspaces</a> -->
                            <button type="submit" class="log-inbtn">Find Workspaces</button>

                        </div>
                    </form>
                    <div id="findForm_status"></div>
				</div>
			</div>
		</div>
	</div>

</section> 

<section class="bg-whoareyou">
	<div class="container pt-lg-5 ">
		<div class="row pt-5 pb-5">
			<div class="col-md-12 text-center pb-3">
				<h2 class="who-title f1">Who You Are?</h2>
				<p class="who-para text-grey ft-16">Please select the industry that defines your Profession</p>
			</div>
			<div class="col-md-4 col-sm-6 mb-3 mb-md-0">
				<a href="medical">
					<img src="images/fit1.jpg" class="img-fluid w-100" alt="" title="">
					<div class="prof-box bg-white">
						<h1 class="prof-cat-head fw-bold f1 mb-0">Medical</h1>
					</div>
				</a>
			</div>
			<div class="col-md-4 col-sm-6 mb-3 mb-md-0">
				<a href="educational">
					<img src="images/teacher.jpg" class="img-fluid w-100" alt="" title="">
					<div class="prof-box bg-white">
						<h1 class="prof-cat-head fw-bold f1 mb-0">Education</h1>
					</div>
				</a>
			</div>
			<div class="col-md-4 col-sm-6 mb-3 mb-md-0">
				<a href="fitness">
					<img src="images/fitn.jpg" class="img-fluid w-100" alt="" title="">
					<div class="prof-box bg-white">
						<h1 class="prof-cat-head fw-bold f1 mb-0">Fitness</h1>
					</div>
				</a>
			</div>
			<div class="col-md-12 mt-5 pt-3 pb-3">
				<div class="other-profbtn text-center">
					<a href="" data-bs-toggle="modal" data-bs-target="#exampleModal">Are you into other profession?</a>
				</div>
				<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title f1 fw-bold ft-32 text-start" id="exampleModalLabel">Tell Us About <br> Your Profession</h5>
								<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
							</div>
							<div class="modal-body">
								<?php include_once("other-prof.php"); ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<section class="bg-panel">
	<div class="container">
		<div class="row pt-5 pb-5 justify-content-center">
			<div class="col-md-12 text-center pb-5 mb-3">
				<h1 class="panel-titlehead f1">Why Join Our Panel</h1>
			</div>
			<div class="col-md-4 col-sm-6 mb-5">
				<div class="row align-items-center">
					<div class="col-md-3 col-3">
						<div class="img-panelbox">
							<img src="images/p1.png" class="img-fluid" alt="" title="">
						</div>
					</div>
					<div class="col-md-9 col-9">
						<h2 class="panel-titlebox f1 ft-18 fw-bold">Zero Investment</h2>
					</div>
					<div class="col-md-12">
						<p class="panel-desc ft-16 text-grey pt-3">What you invest as a capital investment is ZERO rupees. </p>
					</div>
				</div>
			</div>
			<div class="col-md-4 col-sm-6 mb-5">
				<div class="row align-items-center">
					<div class="col-md-3 col-3">
						<div class="img-panelbox">
							<img src="images/p2.png" class="img-fluid" alt="" title="">
						</div>
					</div>
					<div class="col-md-9 col-9">
						<h2 class="panel-titlebox f1 ft-18 fw-bold">No Long term commitment</h2>
					</div>
					<div class="col-md-12">
						<p class="panel-desc ft-16 text-grey pt-3">Say bye bye to traditional lease choose brief plans of 3 months </p>
					</div>
				</div>
			</div>
			<div class="col-md-4 col-sm-6 mb-5">
				<div class="row align-items-center">
					<div class="col-md-3 col-3">
						<div class="img-panelbox">
							<img src="images/p3.png" class="img-fluid" alt="" title="">
						</div>
					</div>
					<div class="col-md-9 col-9">
						<h2 class="panel-titlebox f1 ft-18 fw-bold">Storage Space</h2>
					</div>
					<div class="col-md-12">
						<p class="panel-desc ft-16 text-grey pt-3">Dedicated private space just for you </p>
					</div>
				</div>
			</div>
			<div class="col-md-4 col-sm-6 mb-5 pt-md-5">
				<div class="row align-items-center">
					<div class="col-md-3 col-3">
						<div class="img-panelbox">
							<img src="images/p4.png" class="img-fluid" alt="" title="">
						</div>
					</div>
					<div class="col-md-9 col-9">
						<h2 class="panel-titlebox f1 ft-18 fw-bold">Customized website</h2>
					</div>
					<div class="col-md-12">
						<p class="panel-desc ft-16 text-grey pt-3">Get your very own website with free domain and hosting </p>
					</div>
				</div>
			</div>
			<div class="col-md-4 col-sm-6 mb-5 pt-md-5">
				<div class="row align-items-center">
					<div class="col-md-3 col-3">
						<div class="img-panelbox">
							<img src="images/p5.png" class="img-fluid" alt="" title="">
						</div>
					</div>
					<div class="col-md-9 col-9">
						<h2 class="panel-titlebox f1 ft-18 fw-bold">Branding</h2>
					</div>
					<div class="col-md-12">
						<p class="panel-desc ft-16 text-grey pt-3">Dedicated branding in clinic highlighting your name to get more walk-in patients </p>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<?php
include_once('footer.php');
?>
<script type="text/javascript">
$(document).ready(function () {
	$('.industry-box').click(function () {
		var industry_id = $(this).data("industry_id");
		$('#industry_id').val(industry_id);
		$('.industry-box.current').removeClass('current');
		$(this).addClass('current');
	});
	$('.industry-box-city').click(function () {
		var city_id = $(this).data("city_id");
		$('#city_id').val(city_id);
		$('.industry-box-city.current').removeClass('current');
		$(this).addClass('current');
		if (city_id === 'others') {
			$("#other_city_id").show();
		}
		else{
			$("#other_city_id").hide();
			// location_details(city_id);
		}		
	});
	$('#other_city_id').on( 'change', function(){ 
		var city_id = $(this).val();
		$('#city_id').val(city_id);
		// location_details(city_id); 
	});	
	function location_details(city_id) {
		$.ajax({
			url: 'includes/functions.php?action=location_get_by_city',
			data: {city_id:city_id},
			method: "POST",
			beforeSend: function(){
				$("#location_id").html('<p class="text-center"><i class="fa fa-spinner fa-spin"></i> Please wait as we process..</p>').fadeIn();
			},
			success: function (result)
			{
				var result = $.trim(result);
				$("#location_id").html(result);
				return false;
			}
		});
	}
});
</script>