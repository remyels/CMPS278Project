<?php

session_start();

$filename = $_FILES['file']['name'];

$id = $_SESSION['LoggedInUserID'];
$extension = explode("/", $_FILES['file']['type'])[1];

$location = "../static/images/uploads/profilepictures/".$filename.$extension;
$relativetofileslocation = "static/images/uploads/profilepictures/".$filename.$extension;
$uploadOk = 1;

$valid_extensions = array("jpg","jpeg","png");
if(!in_array(strtolower($extension),$valid_extensions) ) {
   $uploadOk = 0;
}

if($uploadOk == 0){
   echo 0;
}else{
   /* Upload file */
   if(move_uploaded_file($_FILES['file']['tmp_name'],$location)){
	  $query = "UPDATE User SET ProfilePicture = $relativetofileslocation WHERE UserID=$id";
	  $exec = $db->exec($query);
	  if ($exec) {
		  // File was uploaded successfully and the database was updated
		  echo 1;
	  }
	  else {
		  echo 0;
	  }
   }else{
      echo 0;
   }
}