<?php

 function died($error) {
	$page ='
	<p style="font-size:18px; "> We are very sorry, but there were error(s) found with the form you submitted. </p>
	<p style="font-size:18px; "> These errors appear below. </p>
	<p style="font-size:18px; color:red; "><b>'.$error.'</b> </p>
	<p style="font-size:18px; "> Please go back and fix these errors. </p>
	';
	echo $page;
	die();
}   

function success($title,$message) {
	$page ='
	<p style="font-size:18px; color:green; "><b>'.$title.'</b> </p>
	<p style="font-size:18px; ">'.$message.'</p>
	';
	echo $page;
	die();
}   

function failed($title,$message) {
	$page ='
	<p style="font-size:18px; color:red; "><b>'.$title.'</b> </p>
	<p style="font-size:18px; ">'.$message.'</p>
	';
	echo $page;
	die();
}   

function clean_string($string)
{
$bad = array("content-type", "bcc:", "to:", "cc:", "href");
return str_replace($bad, "", $string);
}


function is_image($path)
{
//	$a = getimagesize($path);
 	return exif_imagetype ($path);
	// $image_type = $a[2];	
	// if(in_array($image_type , array(IMAGETYPE_GIF , IMAGETYPE_JPEG ,IMAGETYPE_PNG , IMAGETYPE_BMP)))
	// {
	// 	return true;
	// }
	return false;
}


?>            