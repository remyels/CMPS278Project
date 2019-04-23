<?php

session_start();

include '../../connect/connectPDO.php';

$filename = $_FILES['file']['name'];

print_r($_FILES['file']);

$id = $_SESSION['LoggedInUserID'];

$extension = explode("/", $_FILES['file']['type'])[1];

echo $extension;

$location = "../static/images/uploads/profilepictures/".$id.'.'.$extension;
$relativetofileslocation = $db->quote("static/images/uploads/profilepictures/".$id.'.'.$extension);
$uploadOk = 1;

$valid_extensions = array("jpg","jpeg","png");
if(!in_array(strtolower($extension),$valid_extensions) ) {
   $uploadOk = 0;
}

if($uploadOk == 0){
   echo "Bad extension ".$extension;
}else{
   /* Upload file */
   if(file_exists($location)) {
	   unlink($location);
   }
   if(move_uploaded_file($_FILES['file']['tmp_name'],$location)){
	  $query = "UPDATE user SET ProfilePicture = $relativetofileslocation WHERE UserID=$id";
	  $exec = $db->exec($query);
	  if ($exec) {
		  // File was uploaded successfully and the database was updated
		  echo "Database updated";
	  }
	  else {
		  echo "File uploaded but couldn't update database";
	  }
   }else{
      echo "Couldn't upload file";
   }
}