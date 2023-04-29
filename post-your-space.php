<?php 
$title = "Profrea";
$description = "";
$keywords = "";
$page = 1;
include_once('header.php');
?>
    <section class="bg-post-free-header">
        <div class="container">         
           <div class="row align-items-start">
                <div class="col-md-12 text-center pt-5">
                   <h2 class="post-freeus f1">Register Your Space</h2>
                   <p class="pb-5 fw-bold">“Let your workspace work for you”</p>                
               </div>
               
            </div>
        </div>
    </section>
    

    <section class="bg-postform">
        <div class="container">
            <div class="row">
               <div class="col-md-12 pt-5 bg-post-freeform-right ps-md-5 pb-md-5">
                   <h2 class="form-right-head f1 text-center">Post Your Interest</h2>
                   <?php include_once("post-free-form.php"); ?>
               </div>
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

<?php 

include_once('footer.php');
?>    
    
