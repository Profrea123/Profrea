<?php 
$title = "Profrea";
$description = "";
$keywords = "";
$page = 1;
include_once('header.php');
?>
    <section class="bg-contact-header">
        <div class="container">         
           <div class="row align-items-start">
               <div class="col-md-6 pt-5">
                   <h2 class="contactus f1">Contact Us</h2>
                   <p class="contactpara text-grey">Questions about plans,pricing,or availablity? <br> Just reach us at</p>
                   <div class="contact-details pt-3 pb-3">
                       <div class="text-blue">
                           <i class="fa fa-phone-alt pe-2 mb-3 text-blue b-gap-bg"></i> 96435 55592 
                       </div>
                       <div class="text-blue">
                           <i class="fa fa-envelope-o pe-2 mb-3 text-blue b-gap-bg"></i> info@profrea.com
                       </div>
                   </div>
                   <div class="contactfaq">
                       <div class="contact-faq">
                           <p class="mb-0 text-grey">Check out our comprehensive <a href="faq" class="text-blue">FAQ</a></p>
                       </div>
                   </div>
                   <div class="contact-map pt-5 mt-3">
                   <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d250646.68136289966!2d76.8271453355799!3d11.012014524273273!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3ba859af2f971cb5%3A0x2fc1c81e183ed282!2sCoimbatore%2C%20Tamil%20Nadu!5e0!3m2!1sen!2sin!4v1633808553541!5m2!1sen!2sin" width="400" height="300" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                   </div>
               </div>
               <div class="col-md-6 pt-5 bg-contactform-right ps-md-5 pb-md-5">
                   <h2 class="form-right-head f1">Request a <br> Callback from us</h2>
                   <p class="request-para pt-3">Fill up this form and wait for our agents to call you soon</p>
                   <?php include_once("contact-form.php"); ?>
               </div>
           </div>
        </div>    
    </section>

    <section class="contact-wrap">
        <div class="container">
            <div class="row pt-5">
                <div class="col-md-12 text-center pt-5">
                    <h1 class="about-wrap-head f1">Find Your Next Convenient <br> Workspace Now</h1>
                    <div class="text-center about-explorebtn  pt-5 pb-5 mb-5">
                        <a href="contact">Explore Workspaces</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

<?php 

include_once('footer.php');
?>    
    
