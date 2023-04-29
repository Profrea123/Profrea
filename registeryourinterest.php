<?php 
$title = "Profrea";
$description = "";
$keywords = "";
$page = 1;
include_once('header.php');
?>
<section class="bg-interest">
    <div class="container">
        <div class="row pt-5">
            <div class="col-md-12  pb-5">
                <h2 class="f1 fw-bold ft-32 text-center">Welcome Sridhar,</h2>
                <p class="ft-16 text-grey text-center">Please fill your space related details</p>

                <section class="cd-horizontal-timeline d-none d-lg-block">
                    <div class="timeline">
                        <div class="events-wrapper">
                            <div class="events">
                                <ul class="list-unstyled">
                                    <li><a class="ft-14" href="#0" data-date="16/01/2014" class="selected">Step 1<span>Personal Details</span></a></li>
                                    <li><a class="ft-14" href="#0" data-date="28/02/2014">Step 2<span>Space Features</span></a></li>
                                    <li><a class="ft-14" href="#0 next-key" data-date="20/04/2014">Step 3<span>Workspace Details</span></a></li>
                                    <li><a class="ft-14" href="#0" data-date="20/05/2014">Step 4<span>Documents</span></a></li>
                                    <li><a class="ft-14" href="#0" data-date="09/07/2014">Step 5</a></li>
                                    <li><a class="ft-14" href="#0" data-date="30/08/2014">30 Aug</a></li>
                                    <li><a class="ft-14" href="#0" data-date="15/09/2014">15 Sep</a></li>
                                    <li><a class="ft-14" href="#0" data-date="01/11/2014">01 Nov</a></li>
                                    <li><a class="ft-14" href="#0" data-date="10/12/2014">10 Dec</a></li>
                                    <li><a class="ft-14" href="#0" data-date="19/01/2015">29 Jan</a></li>
                                    <li><a class="ft-14" href="#0" data-date="03/03/2015">3 Mar</a></li>
                                </ul>

                                <span class="filling-line" aria-hidden="true"></span>
                            </div>
                            <!-- .events -->
                        </div>
                        <!-- .events-wrapper -->                     
                    </div>
                    <!-- .timeline -->

                    <div class="events-content pt-5">
                        <ul class="list-unstyled">
                        <li class="selected" data-date="16/01/2014">
                            
                        </li>

                        <li data-date="28/02/2014">
                            <div class="row pb-5">
                                <div class="col-md-4">
                                    <div class="spaceedit-details p-3">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <h2 class="fw-bold ft-18">Space Details</h2>
                                            </div>
                                            <div class="col-md-4">
                                            <p class="ft-14 text-blue"><i class="fas fa-pencil-alt"></i><a href=""> Edit</a></p>
                                            </div>
                                        </div>
                                        <form class="pt-3 pb-4" id="spacedetailForm" action="#" method="POST" novalidate="">
                                            <div class="full-input p-2 col-md-12 me-4 mb-3">
                                                <label for="exampleInputPassword1" class="form-label text-grey ft-14 mb-0">Type</label>
                                                <input type="text" name="email" required="" data-parsley-minlength="4" placeholder="Clinic">
                                            </div>
                                            <div class="full-input p-2 col-md-12 me-4 mb-3">
                                                <label for="exampleInputPassword1" class="form-label text-grey ft-14 mb-0">City</label>
                                                <input type="text" name="email" required="" data-parsley-minlength="4" placeholder="Gurgoan">
                                            </div>
                                            <div class="full-input p-2 col-md-12 me-4 mb-3">
                                                <label for="exampleInputPassword1" class="form-label text-grey ft-14 mb-0">Location</label>
                                                <input type="text" name="email" required="" data-parsley-minlength="4" placeholder="Sector 18">
                                            </div>
                                            <div class="full-input p-2 col-md-12 me-4">
                                                <label for="exampleInputPassword1" class="form-label text-grey ft-14 mb-0">Landmark</label>
                                                <input type="text" name="email" required="" data-parsley-minlength="4" placeholder="Space Landmark">
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <form class="pt-3 pb-4" id="spForm" action="#" method="POST" novalidate="">
                                        <div class="full-input p-2 col-md-12 me-4 mb-3">
                                            <label for="exampleInputPassword1" class="form-label text-grey ft-14 mb-0">Address *</label>
                                            <input type="text" name="email" required="" data-parsley-minlength="4" placeholder="Enter your Sapce Address">
                                        </div>
                                        <div class="full-input p-2 col-md-12 me-4 mb-3">
                                            <label for="exampleInputPassword1" class="form-label text-grey ft-14 mb-0">Setup Description</label>
                                            <input type="text" name="email" required="" data-parsley-minlength="4" placeholder="Enter your Space Description (min 25 Words)" >
                                        </div>
                                        <div class="full-input p-2 col-md-12 me-4 mb-3">
                                            <label for="exampleInputPassword1" class="form-label text-grey ft-14 mb-0">List Rules ?</label>
                                            <input type="text" name="email" required="" data-parsley-minlength="4" placeholder="Enter your List Rules? (if any)">
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <div class="full-input p-2 col-md-12 me-4">
                                                    <div class="row">
                                                        <div class="col-md-8">
                                                            <label for="exampleInputPassword1" class="form-label text-grey ft-14 mb-0">Operating Speciality ?</label>
                                                            <input type="text" name="email" required="" data-parsley-minlength="4" placeholder="Add Operating Speciality">
                                                        </div>
                                                        <div class="col-md-4">
                                                            <a href="" class="text-blue ft-14"><i class="rounded-circle fa fa-plus text-white ft-12 me-2" aria-hidden="true"></i>Add</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <div class="full-input p-2 col-md-12 me-4">
                                                    <div class="row">
                                                        <div class="col-md-8">
                                                            <label for="exampleInputPassword1" class="form-label text-grey ft-14 mb-0">Amenities ?</label>
                                                            <input type="text" name="email" required="" data-parsley-minlength="4" placeholder="Add Amenties">
                                                        </div>
                                                        <div class="col-md-4">
                                                            <a href="" class="text-blue ft-14"><i class="rounded-circle fa fa-plus text-white ft-12 me-2" aria-hidden="true"></i>Add</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <div class="full-input p-2 col-md-12 me-4">
                                                    <div class="row">
                                                        <div class="col-md-8">
                                                            <label for="exampleInputPassword1" class="form-label text-grey ft-14 mb-0">Utilities</label>
                                                            <input type="text" name="email" required="" data-parsley-minlength="4" placeholder="Complimentary Machines,Accessories">
                                                        </div>
                                                        <div class="col-md-4">
                                                            <a href="" class="text-blue ft-14"><i class="rounded-circle fa fa-plus text-white ft-12 me-2" aria-hidden="true"></i>Add</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <div class="full-input p-2 col-md-12 me-4">
                                                    <div class="row">
                                                        <div class="col-md-8">
                                                            <label for="exampleInputPassword1" class="form-label text-grey ft-14 mb-0">paid Utitlities</label>
                                                            <input type="text" name="email" required="" data-parsley-minlength="4" placeholder="paid Machines,Accesories">
                                                        </div>
                                                        <div class="col-md-4">
                                                            <a href="" class="text-blue ft-14"><i class="rounded-circle fa fa-plus text-white ft-12 me-2" aria-hidden="true"></i>Add</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12 text-end pt-3">
                                                <div class="next-btnform">
                                                    <a href="">Next</a>
                                                </div>
                                            </div>
                                        </div>                                        
                                    </form>
                                </div>
                            </div>
                        </li>

                        <li data-date="20/04/2014" id="next-key">
                            <h6 class="text-grey ft-14 text-center">Please Add your workspace details to finish</h6>
                            <div class="text-center pt-4 pb-5 pubwebsite-btn">
                                <a href="" class="mb-5" data-bs-toggle="modal" data-bs-target="#exampleModal">Click Here To Add Workspace</a>
                                
                            </div>
                            
                            <div class="backbtn-form pt-3 pb-5 mb-5 text-center">
                                <a href="">Back</a>
                            </div>
                        </li>

                        <li data-date="20/05/2014">
                            <div class="row pb-5">
                                <div class="col-md-3">
                                    <h6 class="file-uploadlabel text-grey ft-14">Space Image *</h6>                            
                                    <div class="row pt-2">
                                        <div class="col">
                                            <button class="file-upload">            
                                                <input type="file" class="file-input ft-16">Choose Image
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <h6 class="file-uploadlabel text-grey ft-14">Identity Proof *</h6>                            
                                    <div class="row pt-2">
                                        <div class="col">
                                            <button class="file-upload">            
                                                <input type="file" class="file-input ft-16">Choose Image
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <h6 class="file-uploadlabel text-grey ft-14">Setup ownership document *</h6>                            
                                    <div class="row pt-2">
                                        <div class="col">
                                            <button class="file-upload">            
                                                <input type="file" class="file-input ft-16">Choose Image
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <h6 class="file-uploadlabel text-grey ft-14">Other documents</h6>                            
                                    <div class="row pt-2">
                                        <div class="col">
                                            <button class="file-upload">            
                                                <input type="file" class="file-input ft-16">Choose Image
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-7 pt-5">
                                    <h6 class="file-uploadlabel text-grey ft-14">NOC(for tenant)* <span class="text-blue"><i class="fas fa-file-download pe-2"></i>Download NOC template</span></h6>                            
                                    <div class="row pt-2">
                                        <div class="col">
                                            <button class="file-upload">            
                                                <input type="file" class="file-input ft-16">Choose Image
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12 pt-5">
                                    <h1 class="ft-bold ft-18 f1">Our Checklist</h1>
                                </div>
                                <div class="col-md-6 pt-2 pb-2 mb-5">
                                    <h5 class="ft-16 pb-2"><i class="fas fa-thumbs-up text-blue ft-16 pe-2"></i> DO'S</h5>
                                    <div class="mb-5">
                                        <p class="text-grey ft-14"><i class="far fa-check-circle text-green pe-2"></i>Prerequisite to have receptionist cum workspace manager.</p>
                                        <p class="text-grey ft-14"><i class="far fa-check-circle text-green pe-2"></i>Give at least 15 mins of buffer time for space users.</p>
                                        <p class="text-grey ft-14"><i class="far fa-check-circle text-green pe-2"></i>Keep your space available for at least 2 hrs.</p>
                                    </div>
                                </div>
                                <div class="col-md-6 pt-2 pb-2 mb-5">
                                    <h5 class="ft-16 pb-2"><i class="fas fa-thumbs-down text-blue ft-16 pe-2"></i> DONT'S</h5>
                                    <div class="mb-5">
                                        <p class="text-grey ft-14"><i class="fas fa-times-circle text-danger pe-2"></i>Contact directly or get into an arrangement with space user.</p>
                                        <p class="text-grey ft-14"><i class="fas fa-times-circle text-danger pe-2"></i> Deal with other service providers or agents.</p>
                                    </div>
                                </div>
                                <div class="col-md-12 text-end pb-5"> 
                                    <div class="row align-items-center">
                                        <div class="col-md-8 d-none d-md-block"></div>
                                        <div class="col-md p-0">
                                            <span class="d-flex">
                                                <input type="checkbox" class="form-check-input me-2" id="exampleCheck1">
                                                <span class="text-grey ft-14">hereby agree to Profrea’s terms of use</span>
                                            </span>
                                        </div>                                        
                                    </div>                     
                                </div>
                                <div class="col-md-6">
                                    <div class="clinic-b">
                                        <a href="">Back</a>
                                    </div>
                                </div>
                                <div class="col-md-6 text-end mb-5">
                                    <div class="next-btnform">
                                        <a href="">Preview</a>
                                    </div>
                                </div>
                            </div>
                        </li>
                        </ul>
                        <!-- Modal -->
                        <div class="modal fade abtwork" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content p-3">
                                    <div class="modal-header">
                                        <h5 class="modal-title ft-32 fw-bold" id="exampleModalLabel">About <br> Your Workspace</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <form class="pt-3 pb-4" id="adddetForm" action="#" method="POST" novalidate="">
                                                    <div class="full-input p-2 col-md-12 me-4 mb-3">
                                                        <label for="exampleInputPassword1" class="form-label text-grey ft-14 mb-0">Workspace name *</label>
                                                        <input type="text" name="email" required="" data-parsley-minlength="4" placeholder="Enter Unique Name">
                                                    </div>
                                                    <div class="full-input p-2 col-md-12 me-4 mb-3">
                                                        <label for="exampleInputPassword1" class="form-label text-grey ft-14 mb-0">Available From</label>
                                                        <input type="text" name="email" required="" data-parsley-minlength="4" placeholder="MM/DD/YYY">
                                                    </div>
                                                    <div>
                                                        <h6 class="file-uploadlabel text-grey ft-14">Space Profile Image</h6>
                                                        <div class="row pt-1">
                                                            <div class="col">
                                                                <button class="file-upload">            
                                                                    <input type="file" class="file-input ft-16">Choose Image
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="col-md-6">                                                
                                                <h1 class="website-detailhead f1 ft-14 text-grey">Time Slots Availability</h1>
                                                <div class="mb-3 form-check pt-2">
                                                    <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                                    <label class="form-check-label" for="exampleCheck1">Select same time slots for whole week</label>
                                                </div>                   
                                        
                                                <div class="row pb-1 bb-bottom align-items-center">
                                                    <div class="col-md-3">
                                                        <h6 class="calenderday-head">Monday</h6>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <div class="calender-boxinner">
                                                            <div class="row align-items-center">
                                                                <div class="col-md-8 pe-0">
                                                                    <h6 class="text-grey ft-14">Starts time - End Time</h6>
                                                                    <p class="timing-calender ft-16 mb-0">11:11AM - 2:11PM</p>
                                                                </div>                                        
                                                                <div class="col-md-4">
                                                                    <p class="text-blue mb-0 ft-14"><i class="rounded-circle ft-14 fas fa-plus text-white pe-1" aria-hidden="true"></i> Add</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <p class="added-date text-grey ft-14 pt-4">11:11AM-2:11PM <span><span class="close text-blue ps-2" onclick="document.getElementById('myDiv').style.display='none'">X</span></span></p>
                                                    </div>
                                                </div>
                                                <div class="row pb-3 bb-bottom align-items-center pt-3">
                                                    <div class="col-md-3">
                                                        <h6 class="calenderday-head">Tuesday</h6>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <div class="calender-boxinner">
                                                            <div class="row align-items-center">
                                                                <div class="col-md-8 pe-0">
                                                                    <h6 class="text-grey ft-14">Starts time - End Time</h6>
                                                                    <p class="timing-calender ft-16 mb-0">11:11AM - 2:11PM</p>
                                                                </div>                                        
                                                                <div class="col-md-4">
                                                                    <p class="text-blue mb-0 ft-14"><i class="rounded-circle ft-14 fas fa-plus text-white pe-1" aria-hidden="true"></i> Add</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row pb-3 bb-bottom align-items-center pt-3">
                                                    <div class="col-md-3">
                                                        <h6 class="calenderday-head">Wednesday</h6>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <div class="calender-boxinner">
                                                            <div class="row align-items-center">
                                                                <div class="col-md-8 pe-0">
                                                                    <h6 class="text-grey ft-14">Starts time - End Time</h6>
                                                                    <p class="timing-calender ft-16 mb-0">11:11AM - 2:11PM</p>
                                                                </div>                                        
                                                                <div class="col-md-4">
                                                                    <p class="text-blue mb-0 ft-14"><i class="rounded-circle ft-14 fas fa-plus text-white pe-1" aria-hidden="true"></i> Add</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row pb-3 bb-bottom align-items-center pt-3">
                                                    <div class="col-md-3">
                                                        <h6 class="calenderday-head">Thursday</h6>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <div class="calender-boxinner">
                                                            <div class="row align-items-center">
                                                                <div class="col-md-8 pe-0">
                                                                    <h6 class="text-grey ft-14">Starts time - End Time</h6>
                                                                    <p class="timing-calender ft-16 mb-0">11:11AM - 2:11PM</p>
                                                                </div>                                        
                                                                <div class="col-md-4">
                                                                    <p class="text-blue mb-0 ft-14"><i class="rounded-circle ft-14 fas fa-plus text-white pe-1" aria-hidden="true"></i> Add</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row pb-3 bb-bottom align-items-center pt-3">
                                                    <div class="col-md-3">
                                                        <h6 class="calenderday-head">Friday</h6>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <div class="calender-boxinner">
                                                            <div class="row align-items-center">
                                                                <div class="col-md-8 pe-0">
                                                                    <h6 class="text-grey ft-14">Starts time - End Time</h6>
                                                                    <p class="timing-calender ft-16 mb-0">11:11AM - 2:11PM</p>
                                                                </div>                                        
                                                                <div class="col-md-4">
                                                                    <p class="text-blue mb-0 ft-14"><i class="rounded-circle ft-14 fas fa-plus text-white pe-1" aria-hidden="true"></i> Add</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row pb-3 bb-bottom align-items-center pt-3">
                                                    <div class="col-md-3">
                                                        <h6 class="calenderday-head">Saturday</h6>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <div class="calender-boxinner">
                                                            <div class="row align-items-center">
                                                                <div class="col-md-8 pe-0">
                                                                    <h6 class="text-grey ft-14">Starts time - End Time</h6>
                                                                    <p class="timing-calender ft-16 mb-0">11:11AM - 2:11PM</p>
                                                                </div>                                        
                                                                <div class="col-md-4">
                                                                    <p class="text-blue mb-0 ft-14"><i class="rounded-circle ft-14 fas fa-plus text-white pe-1" aria-hidden="true"></i> Add</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row pb-3 bb-bottom align-items-center pt-3">
                                                    <div class="col-md-3">
                                                        <h6 class="calenderday-head">Sunday</h6>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <div class="calender-boxinner">
                                                            <div class="row align-items-center">
                                                                <div class="col-md-8 pe-0">
                                                                    <h6 class="text-grey ft-14">Starts time - End Time</h6>
                                                                    <p class="timing-calender ft-16 mb-0">11:11AM - 2:11PM</p>
                                                                </div>                                        
                                                                <div class="col-md-4">
                                                                    <p class="text-blue mb-0 ft-14"><i class="rounded-circle ft-14 fas fa-plus text-white pe-1" aria-hidden="true"></i> Add</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12 text-center pt-5 pb-5">
                                                <div class="donebtn">
                                                    <a href="">Done</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- .events-content -->
                </section>




                <section class="d-block d-lg-none mobiletab-tavb">
                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                    <!-- <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="pills-mobile1-tab" data-bs-toggle="pill" data-bs-target="#pills-mobile1" type="button" role="tab" aria-controls="pills-mobile1" aria-selected="true"><span class="ps-3">Personal Details</span></button>
                    </li> -->
                    <li class="nav-item w-100" role="presentation">
                        <button class="nav-link active" id="pills-mobile2-tab" data-bs-toggle="pill" data-bs-target="#pills-mobile2" type="button" role="tab" aria-controls="pills-mobile2" aria-selected="false"><span class="ps-3">Space Features</button>
                    </li>
                    <li class="nav-item w-100" role="presentation">
                        <button class="nav-link" id="pills-mobile3-tab" data-bs-toggle="pill" data-bs-target="#pills-mobile3" type="button" role="tab" aria-controls="pills-mobile3" aria-selected="false"><span class="ps-3">Workspace Details</span></button>
                    </li>
                    <li class="nav-item w-100" role="presentation">
                        <button class="nav-link" id="pills-mobile4-tab" data-bs-toggle="pill" data-bs-target="#pills-mobile4" type="button" role="tab" aria-controls="pills-mobile4" aria-selected="false"><span class="ps-3">Documents</span></span></button>
                    </li>
                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                    <!-- <div class="tab-pane fade show active" id="pills-mobile1" role="tabpanel" aria-labelledby="pills-mobile1-tab">...</div> -->
                    <div class="tab-pane fade show active" id="pills-mobile2" role="tabpanel" aria-labelledby="pills-mobile2-tab">
                        <div class="row pb-5">
                            <div class="col-md-4">
                                <div class="spaceedit-details p-3">
                                    <div class="row">
                                        <div class="col-md-8 col-8">
                                            <h2 class="fw-bold ft-18">Space Details</h2>
                                        </div>
                                        <div class="col-md-4 col-4">
                                        <p class="ft-14 text-blue"><i class="fas fa-pencil-alt"></i><a href=""> Edit</a></p>
                                        </div>
                                    </div>
                                    <form class="pt-3 pb-4" id="spacedetailForm" action="#" method="POST" novalidate="">
                                        <div class="full-input p-2 col-md-12 me-4 mb-3">
                                            <label for="exampleInputPassword1" class="form-label text-grey ft-14 mb-0">Type</label>
                                            <input type="text" name="email" required="" data-parsley-minlength="4" placeholder="Clinic">
                                        </div>
                                        <div class="full-input p-2 col-md-12 me-4 mb-3">
                                            <label for="exampleInputPassword1" class="form-label text-grey ft-14 mb-0">City</label>
                                            <input type="text" name="email" required="" data-parsley-minlength="4" placeholder="Gurgoan">
                                        </div>
                                        <div class="full-input p-2 col-md-12 me-4 mb-3">
                                            <label for="exampleInputPassword1" class="form-label text-grey ft-14 mb-0">Location</label>
                                            <input type="text" name="email" required="" data-parsley-minlength="4" placeholder="Sector 18">
                                        </div>
                                        <div class="full-input p-2 col-md-12 me-4">
                                            <label for="exampleInputPassword1" class="form-label text-grey ft-14 mb-0">Landmark</label>
                                            <input type="text" name="email" required="" data-parsley-minlength="4" placeholder="Space Landmark">
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <form class="pt-3 pb-4" id="spForm" action="#" method="POST" novalidate="">
                                    <div class="full-input p-2 col-md-12 me-4 mb-3">
                                        <label for="exampleInputPassword1" class="form-label text-grey ft-14 mb-0">Address *</label>
                                        <input type="text" name="email" required="" data-parsley-minlength="4" placeholder="Enter your Sapce Address">
                                    </div>
                                    <div class="full-input p-2 col-md-12 me-4 mb-3">
                                        <label for="exampleInputPassword1" class="form-label text-grey ft-14 mb-0">Setup Description</label>
                                        <input type="text" name="email" required="" data-parsley-minlength="4" placeholder="Enter your Space Description (min 25 Words)" >
                                    </div>
                                    <div class="full-input p-2 col-md-12 me-4 mb-3">
                                        <label for="exampleInputPassword1" class="form-label text-grey ft-14 mb-0">List Rules ?</label>
                                        <input type="text" name="email" required="" data-parsley-minlength="4" placeholder="Enter your List Rules? (if any)">
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <div class="full-input p-2 col-md-12 me-4">
                                                <div class="row">
                                                    <div class="col-md-8 col-8">
                                                        <label for="exampleInputPassword1" class="form-label text-grey ft-14 mb-0">Operating Speciality ?</label>
                                                        <input type="text" name="email" required="" data-parsley-minlength="4" placeholder="Add Operating Speciality">
                                                    </div>
                                                    <div class="col-md-4 col-4">
                                                        <a href="" class="text-blue ft-14"><i class="rounded-circle fa fa-plus text-white ft-12 me-2" aria-hidden="true"></i>Add</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <div class="full-input p-2 col-md-12 me-4">
                                                <div class="row">
                                                    <div class="col-md-8 col-8">
                                                        <label for="exampleInputPassword1" class="form-label text-grey ft-14 mb-0">Amenities ?</label>
                                                        <input type="text" name="email" required="" data-parsley-minlength="4" placeholder="Add Amenties">
                                                    </div>
                                                    <div class="col-md-4 col-4">
                                                        <a href="" class="text-blue ft-14"><i class="rounded-circle fa fa-plus text-white ft-12 me-2" aria-hidden="true"></i>Add</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <div class="full-input p-2 col-md-12 me-4">
                                                <div class="row">
                                                    <div class="col-md-8 col-8">
                                                        <label for="exampleInputPassword1" class="form-label text-grey ft-14 mb-0">Utilities</label>
                                                        <input type="text" name="email" required="" data-parsley-minlength="4" placeholder="Complimentary Machines,Accessories">
                                                    </div>
                                                    <div class="col-md-4 col-4">
                                                        <a href="" class="text-blue ft-14"><i class="rounded-circle fa fa-plus text-white ft-12 me-2" aria-hidden="true"></i>Add</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <div class="full-input p-2 col-md-12 me-4">
                                                <div class="row">
                                                    <div class="col-md-8 col-8">
                                                        <label for="exampleInputPassword1" class="form-label text-grey ft-14 mb-0">paid Utitlities</label>
                                                        <input type="text" name="email" required="" data-parsley-minlength="4" placeholder="paid Machines,Accesories">
                                                    </div>
                                                    <div class="col-md-4 col-4">
                                                        <a href="" class="text-blue ft-14"><i class="rounded-circle fa fa-plus text-white ft-12 me-2" aria-hidden="true"></i>Add</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12 text-end pt-3">
                                            <div class="next-btnform">
                                                <a href="">Next</a>
                                            </div>
                                        </div>
                                    </div>                                        
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-mobile3" role="tabpanel" aria-labelledby="pills-mobile3-tab">
                        <h6 class="text-grey ft-14 text-center">Please Add your workspace details to finish</h6>
                        <div class=" pt-4 pb-5 pubwebsite-btn">
                           <div class="text-center"> <a href="" class="mb-5" data-bs-toggle="modal" data-bs-target="#exampleModal2">Click Here To Add Workspace</a></div>
                            <!-- Modal -->
                            <div class="modal fade abtwork" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content p-3">
                                        <div class="modal-header">
                                            <h5 class="modal-title ft-32 fw-bold" id="exampleModalLabel">About <br> Your Workspace</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <form class="pt-3 pb-4" id="adddetForm" action="#" method="POST" novalidate="">
                                                        <div class="full-input p-2 col-md-12 me-4 mb-3">
                                                            <label for="exampleInputPassword1" class="form-label text-grey ft-14 mb-0">Workspace name *</label>
                                                            <input type="text" name="email" required="" data-parsley-minlength="4" placeholder="Enter Unique Name">
                                                        </div>
                                                        <div class="full-input p-2 col-md-12 me-4 mb-3">
                                                            <label for="exampleInputPassword1" class="form-label text-grey ft-14 mb-0">Available From</label>
                                                            <input type="text" name="email" required="" data-parsley-minlength="4" placeholder="MM/DD/YYY">
                                                        </div>
                                                        <div>
                                                            <h6 class="file-uploadlabel text-grey ft-14">Space Profile Image</h6>
                                                            <div class="row pt-1">
                                                                <div class="col">
                                                                    <button class="file-upload">            
                                                                        <input type="file" class="file-input ft-16">Choose Image
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="col-md-6">                                                
                                                    <h1 class="website-detailhead f1 ft-14 text-grey">Time Slots Availability</h1>
                                                    <div class="mb-3 form-check pt-2">
                                                        <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                                        <label class="form-check-label" for="exampleCheck1">Select same time slots for whole week</label>
                                                    </div>                   
                                            
                                                    <div class="row pb-1 bb-bottom align-items-center">
                                                        <div class="col-md-3">
                                                            <h6 class="calenderday-head">Monday</h6>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <div class="calender-boxinner">
                                                                <div class="row align-items-center">
                                                                    <div class="col-md-8 col-8 pe-0">
                                                                        <h6 class="text-grey ft-14">Starts time - End Time</h6>
                                                                        <p class="timing-calender ft-16 mb-0">11:11AM - 2:11PM</p>
                                                                    </div>                                        
                                                                    <div class="col-md-4 col-4">
                                                                        <p class="text-blue mb-0 ft-14"><i class="rounded-circle ft-14 fas fa-plus text-white pe-1" aria-hidden="true"></i> Add</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <p class="added-date text-grey ft-14 pt-4">11:11AM-2:11PM <span><span class="close text-blue ps-2" onclick="document.getElementById('myDiv').style.display='none'">X</span></span></p>
                                                        </div>
                                                    </div>
                                                    <div class="row pb-3 bb-bottom align-items-center pt-3">
                                                        <div class="col-md-3">
                                                            <h6 class="calenderday-head">Tuesday</h6>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <div class="calender-boxinner">
                                                                <div class="row align-items-center">
                                                                    <div class="col-md-8 col-8 pe-0">
                                                                        <h6 class="text-grey ft-14">Starts time - End Time</h6>
                                                                        <p class="timing-calender ft-16 mb-0">11:11AM - 2:11PM</p>
                                                                    </div>                                        
                                                                    <div class="col-md-4 col-4">
                                                                        <p class="text-blue mb-0 ft-14"><i class="rounded-circle ft-14 fas fa-plus text-white pe-1" aria-hidden="true"></i> Add</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row pb-3 bb-bottom align-items-center pt-3">
                                                        <div class="col-md-3">
                                                            <h6 class="calenderday-head">Wednesday</h6>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <div class="calender-boxinner">
                                                                <div class="row align-items-center">
                                                                    <div class="col-md-8 col-8 pe-0">
                                                                        <h6 class="text-grey ft-14">Starts time - End Time</h6>
                                                                        <p class="timing-calender ft-16 mb-0">11:11AM - 2:11PM</p>
                                                                    </div>                                        
                                                                    <div class="col-md-4 col-4">
                                                                        <p class="text-blue mb-0 ft-14"><i class="rounded-circle ft-14 fas fa-plus text-white pe-1" aria-hidden="true"></i> Add</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row pb-3 bb-bottom align-items-center pt-3">
                                                        <div class="col-md-3">
                                                            <h6 class="calenderday-head">Thursday</h6>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <div class="calender-boxinner">
                                                                <div class="row align-items-center">
                                                                    <div class="col-md-8 col-8 pe-0">
                                                                        <h6 class="text-grey ft-14">Starts time - End Time</h6>
                                                                        <p class="timing-calender ft-16 mb-0">11:11AM - 2:11PM</p>
                                                                    </div>                                        
                                                                    <div class="col-md-4 col-4">
                                                                        <p class="text-blue mb-0 ft-14"><i class="rounded-circle ft-14 fas fa-plus text-white pe-1" aria-hidden="true"></i> Add</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row pb-3 bb-bottom align-items-center pt-3">
                                                        <div class="col-md-3">
                                                            <h6 class="calenderday-head">Friday</h6>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <div class="calender-boxinner">
                                                                <div class="row align-items-center">
                                                                    <div class="col-md-8 col-8 pe-0">
                                                                        <h6 class="text-grey ft-14">Starts time - End Time</h6>
                                                                        <p class="timing-calender ft-16 mb-0">11:11AM - 2:11PM</p>
                                                                    </div>                                        
                                                                    <div class="col-md-4 col-4">
                                                                        <p class="text-blue mb-0 ft-14"><i class="rounded-circle ft-14 fas fa-plus text-white pe-1" aria-hidden="true"></i> Add</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row pb-3 bb-bottom align-items-center pt-3">
                                                        <div class="col-md-3">
                                                            <h6 class="calenderday-head">Saturday</h6>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <div class="calender-boxinner">
                                                                <div class="row align-items-center">
                                                                    <div class="col-md-8 col-8 pe-0">
                                                                        <h6 class="text-grey ft-14">Starts time - End Time</h6>
                                                                        <p class="timing-calender ft-16 mb-0">11:11AM - 2:11PM</p>
                                                                    </div>                                        
                                                                    <div class="col-md-4 col-4">
                                                                        <p class="text-blue mb-0 ft-14"><i class="rounded-circle ft-14 fas fa-plus text-white pe-1" aria-hidden="true"></i> Add</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row pb-3 bb-bottom align-items-center pt-3">
                                                        <div class="col-md-3">
                                                            <h6 class="calenderday-head">Sunday</h6>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <div class="calender-boxinner">
                                                                <div class="row align-items-center">
                                                                    <div class="col-md-8 col-8 pe-0">
                                                                        <h6 class="text-grey ft-14">Starts time - End Time</h6>
                                                                        <p class="timing-calender ft-16 mb-0">11:11AM - 2:11PM</p>
                                                                    </div>                                        
                                                                    <div class="col-md-4 col-4">
                                                                        <p class="text-blue mb-0 ft-14"><i class="rounded-circle ft-14 fas fa-plus text-white pe-1" aria-hidden="true"></i> Add</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 text-center pt-5 pb-5">
                                                    <div class="donebtn">
                                                        <a href="">Done</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>                                    
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="backbtn-form pt-3 pb-5 mb-5 text-center">
                            <a href="">Back</a>
                        </div>
                         
                        
                    </div>
                    <div class="tab-pane fade" id="pills-mobile4" role="tabpanel" aria-labelledby="pills-mobile4-tab">
                        <div class="row pb-5">
                            <div class="col-md-3 col-6 mb-3 mb-md-0">
                                <h6 class="file-uploadlabel text-grey ft-14">Space Image *</h6>                            
                                <div class="row pt-2">
                                    <div class="col">
                                        <button class="file-upload">            
                                            <input type="file" class="file-input ft-16">Choose Image
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-6 mb-3 mb-md-0">
                                <h6 class="file-uploadlabel text-grey ft-14">Identity Proof *</h6>                            
                                <div class="row pt-2">
                                    <div class="col">
                                        <button class="file-upload">            
                                            <input type="file" class="file-input ft-16">Choose Image
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-6 mb-3 mb-md-0">
                                <h6 class="file-uploadlabel text-grey ft-14">Setup ownership document *</h6>                            
                                <div class="row pt-2">
                                    <div class="col">
                                        <button class="file-upload">            
                                            <input type="file" class="file-input ft-16">Choose Image
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-6 mb-3 mb-md-0">
                                <h6 class="file-uploadlabel text-grey ft-14">Other documents</h6>                            
                                <div class="row pt-2">
                                    <div class="col">
                                        <button class="file-upload">            
                                            <input type="file" class="file-input ft-16">Choose Image
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-7 pt-5">
                                <h6 class="file-uploadlabel text-grey ft-14">NOC(for tenant)* <span class="text-blue"><i class="fas fa-file-download pe-2"></i>Download NOC template</span></h6>                            
                                <div class="row pt-2">
                                    <div class="col">
                                        <button class="file-upload">            
                                            <input type="file" class="file-input ft-16">Choose Image
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 pt-5">
                                <h1 class="ft-bold ft-18 f1">Our Checklist</h1>
                            </div>
                            <div class="col-md-6 pt-2 pb-2 mb-md-5">
                                <h5 class="ft-16 pb-2"><i class="fas fa-thumbs-up text-blue ft-16 pe-2"></i> DO'S</h5>
                                <div class="mb-5">
                                    <p class="text-grey ft-14"><i class="far fa-check-circle text-green pe-2"></i>Prerequisite to have receptionist cum workspace manager.</p>
                                    <p class="text-grey ft-14"><i class="far fa-check-circle text-green pe-2"></i>Give at least 15 mins of buffer time for space users.</p>
                                    <p class="text-grey ft-14"><i class="far fa-check-circle text-green pe-2"></i>Keep your space available for at least 2 hrs.</p>
                                </div>
                            </div>
                            <div class="col-md-6 pt-2 pb-2 mb-5">
                                <h5 class="ft-16 pb-2"><i class="fas fa-thumbs-down text-blue ft-16 pe-2"></i> DONT'S</h5>
                                <div class="mb-5">
                                    <p class="text-grey ft-14"><i class="fas fa-times-circle text-danger pe-2"></i>Contact directly or get into an arrangement with space user.</p>
                                    <p class="text-grey ft-14"><i class="fas fa-times-circle text-danger pe-2"></i> Deal with other service providers or agents.</p>
                                </div>
                            </div>
                            <div class="col-md-12 text-end pb-5"> 
                                <div class="row align-items-center">
                                    <div class="col-md-8 d-none d-md-block"></div>
                                    <div class="col-md p-0">
                                        <span class="d-flex">
                                            <input type="checkbox" class="form-check-input me-2" id="exampleCheck1">
                                            <span class="text-grey ft-14">hereby agree to Profrea’s terms of use</span>
                                        </span>
                                    </div>                                        
                                </div>                     
                            </div>
                            <div class="col-md-6 col-6">
                                <div class="clinic-b">
                                    <a href="">Back</a>
                                </div>
                            </div>
                            <div class="col-md-6 col-6 text-end mb-5">
                                <div class="next-btnform">
                                    <a href="">Preview</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>

                    <!-- .events-content -->
                </section>
            </div>
        </div>
    </div>
</section>

<?php 


include_once('footer.php');
?>
