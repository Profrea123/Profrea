<?php 
$title = "Profrea";
$description = "";
$keywords = "";
$page = 1;
include_once('header.php');
?>

<?php
   
   
   require_once('src/Classes/Model/Database.php');
   require_once('vendor/autoload.php');
   use App\Classes\Model\Database;    
   $db_conn = new Database;

   $query = "select * from faq where rowstate= True";
   $dbresult = $db_conn->getDbHandler()->query($query); 
   if($dbresult)
   {
     $faq_all = $dbresult->fetchAll();
   }

   $query = "select * from faq where category='Space Provider' and rowstate= True";
   $dbresult = $db_conn->getDbHandler()->query($query); 
   if($dbresult)
   {
     $faq_space_provider = $dbresult->fetchAll();
   }

   $query = "select * from faq where category='Space User' and rowstate= True";
   $dbresult = $db_conn->getDbHandler()->query($query); 
   if($dbresult)
   {
     $faq_space_user = $dbresult->fetchAll();
   }

?>
<section class="bg-faq-header">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-9 pt-5">
                <h2 class="faqus f1 pt-2 text-center">Frequently Asked Question</h2>
               <div class="accordion pt-5" id="accordionExample">
                    <?php
                        foreach($faq_all as $faq){
                    ?>
                    <div class="accordion-item mb-4">
                        <h2 class="accordion-header" id="headingfaq-<?php echo $faq['id']; ?>" >
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq-<?php echo $faq['id']; ?>" aria-expanded="true" aria-controls="faq-<?php echo $faq['id']; ?>">
                        <?php echo $faq['question']; ?>
                        </button>
                        </h2>
                        <div id="faq-<?php echo $faq['id']; ?>" class="accordion-collapse collapse <?php echo isset($_GET['id']) && $_GET['id'] == "faq-".$faq['id']?"show":""; ?>" aria-labelledby="headingfaq-<?php echo $faq['id']; ?>" data-bs-parent="#accordionExample">
                        <div class="accordion-body text-grey">
                        <?php echo $faq['answer']; ?>
                        </div>
                        </div>
                    </div>
                    <?php
                        }
                    ?>
                </div>                
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
                        <a href="">Request a callback</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

<?php 

include_once('footer.php');
?>