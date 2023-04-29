
<?php

$file = $_FILES['space_profile_image'];
if (!empty($_FILES['space_profile_image']['name']))
{
    $fileName = $_FILES['space_profile_image']['name'];
    $fileTmpName = $_FILES['space_profile_image']['tmp_name'];
    $fileSize = $_FILES['space_profile_image']['size'];
    $fileError = $_FILES['space_profile_image']['error'];
    $fileType = $_FILES['space_profile_image']['type']; 
    $fileExt = explode('.', $fileName);
    $fileActualExt = strtolower(end($fileExt));
    $target_dir = "../datafiles/uploads/space_info/".$last_inserted_id."/space_profile_image/";
    $fileNameNew = uniqid('', true) . "." . $fileActualExt;
    $target_file = $target_dir .$fileNameNew;
    $uploadOk = 1;
    unset($ret);
    $ret[]=    $uploadOk;
    $ret[] = basename( $target_file);
    //echo "<script>console.log(' check: " . $fileSize .  "' );</script>"; 
    
    
    
    // Check if image file is a actual image or fake image
    if(isset($_POST["submit"])) {
        $check = getimagesize($fileTmpName);
        if($check) {
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }
    } 

    // Check file size
    if ($fileSize > 50000000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    $allowed = array('jpg', 'jpeg', 'png', 'gif');
    if (!in_array($fileActualExt, $allowed))
    {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Check if target dir already exists
    if ( !file_exists ($target_dir)) {
        mkdir($target_dir, 0777, true);
    }


    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
        } 
    // if everything is ok, try to upload file
    else {
        if (move_uploaded_file($fileTmpName , $target_file)) {
            //echo "The file ". basename( $target_file). " has been uploaded.";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
    $ret[0]=    $uploadOk;
    return $ret;
    
}
?>




