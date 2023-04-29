<?php
 
   require_once('src/Classes/Model/Database.php');
   require_once('vendor/autoload.php');
   use App\Classes\Model\Database;    
   $db_conn = new Database;
   
   
   echo "<br>" ; 
   use App\Classes\RealEstate\Spaces;
   $real_estate = new Spaces();
   $allData1 = $real_estate->index();
   echo "Properties size: ".sizeof($allData1) ; 

   echo "<br>" ; 
   use App\Classes\RealEstate\Users;
   $user = new Users();
   $allData2 = $user->index();
   echo "Users size: ".sizeof($allData2) ; 

   echo "<br>" ; 
   use App\Classes\RealEstate\BlogPost;
   $blog_post = new BlogPost();
   $allData = $blog_post->index();
   echo "BlogPost size: ".sizeof($allData) ; 


?>


