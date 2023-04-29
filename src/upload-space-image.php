<?php 
//if(isset($_POST['submit'])){
 
$file = $_FILES['space_image'];
if (!empty($_FILES['space_image']['name']))
{

 // Count total files
 $countfiles = count($_FILES['space_image']['name']);
 $uploadOk = 1;
 unset($ret);
 $ret[]=    $uploadOk;
 // Looping all files
 for($i=0;$i<$countfiles;$i++){
    if (!empty($_FILES['space_image']['name'][$i]))
    {
        $fileName = $_FILES['space_image']['name'][$i];
        $fileTmpName = $_FILES['space_image']['tmp_name'][$i];
        $fileSize = $_FILES['space_image']['size'][$i];
        $fileError = $_FILES['space_image']['error'][$i];
        $fileType = $_FILES['space_image']['type'][$i]; 
        $fileExt = explode('.', $fileName);
        $fileActualExt = strtolower(end($fileExt));
        $target_dir = "../datafiles/uploads/space_info/".$last_inserted_id."/space_image/";
        $fileNameNew = uniqid('', true) . "." . $fileActualExt;
        $target_file = $target_dir .$fileNameNew;
        $ret[] = basename($target_file);
        //echo "<script>console.log(' check: " . $fileTmpName .  "' );</script>"; 
              
        
        // Check if image file is a actual image or fake image
        // if(isset($_POST["submit"])) {
        //     $check = getimagesize($fileTmpName);
        //     if($check) {
        //         $uploadOk = 1;
        //     } else {
        //         echo "File is not an image.";
        //         $uploadOk = 0;
        //     }
        // } 

        // Allow certain file formats
        $allowed = array('jpg', 'jpeg', 'png', 'gif','pdf');
        if (!in_array($fileActualExt, $allowed))
        {
            echo "Sorry, only JPG, JPEG, PNG,  GIF & PDF files are allowed.";
            $uploadOk = 0;
        }

        // Check file size
        if ($fileSize > 50000000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }


        // Check if target dir already exists
        if ( !file_exists ($target_dir)) {
            mkdir($target_dir, 0777, true);
        }


        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
                echo "Sorry, your file was not uploaded.";
                $uploadOk = 0;
            } 
        // if everything is ok, try to upload file
        else {
            if (move_uploaded_file($fileTmpName , $target_file)) {
                $uploadOk = 1;
                //echo "The file ". basename( $target_file). " has been uploaded.";
            } else {
                $uploadOk = 0;
                echo "Sorry, there was an error uploading your file.";
            }
        }
        
    } 
}
$ret[0]=    $uploadOk;
return $ret;
} 

?>