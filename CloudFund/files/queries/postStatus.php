<?php

include ("../../connect/connectPDO.php");

session_start();

if (isset($_POST['mode']) && !empty($_POST['mode'])) {
	if (isset($_POST['status']) && !empty($_POST['status'])&& isset($_POST['privacy']) && !empty($_POST['privacy'])) {
		$userid = $db->quote($_SESSION['LoggedInUserID']);
		$privacy = $db->quote($_POST['privacy']);
		$time = $db->quote(date("Y-m-d H:i:s", strtotime("now + 3 hours")));
		$timeunquoted = date("Y-m-d H:i:s", strtotime("now + 3 hours"));
		$statuscontentunquoted = $_POST['status'];
		$statuscontent = $db->quote($statuscontentunquoted);
		
		//hello 
		if($_POST['mode'] == 'image') {
			
			$query = "INSERT INTO post(PostID, UserID, Type, LevelOfAccess, Content, DateTimeOfPost) VALUES(NULL, $userid, 2, $privacy, $statuscontent, $time)";
			$exec = $db->exec($query);
			
			if($exec) {
				$postid = $db->lastInsertId();
				$extension = explode("/", $_FILES['file']['type'])[1];

				//where i want to store the pic
				$location = "../static/images/uploads/posts/".$postid.'.'.$extension;
				//how i want store to it bel db
				$relativetofileslocation = $db->quote("static/images/uploads/posts/".$postid.'.'.$extension);
				$relativetofileslocationunquoted = "static/images/uploads/posts/".$postid.'.'.$extension;
				$uploadOk = 1;

				$valid_extensions = array("jpg","jpeg","png");
			
				if(!in_array(strtolower($extension),$valid_extensions) ) {
				   $uploadOk = 0;
				}

				if($uploadOk == 0){
				   echo "Bad extension ".$extension;
				
				} else {
					if(move_uploaded_file($_FILES['file']['tmp_name'], $location)){
					
						$query = "UPDATE post SET FileLocation = $relativetofileslocation WHERE PostID = $postid;";
						$exec = $db->exec($query);
							
						if ($exec) {
							$query = $db->prepare("SELECT * from user WHERE UserID = $userid;");
							
							$query->execute();
							$row = $query->fetch();
							
							$result = array();
							
							$result['PostID'] = $postid;
							$result['FirstName'] = $row['FirstName'];
							$result['LastName'] = $row['LastName'];
							$result['Content'] = $statuscontentunquoted;
							$result['Image'] = $relativetofileslocationunquoted;
							$result['PostDate'] = $timeunquoted;
							
							if ($row['ProfilePicture']=="") {
								$result['ProfilePicture'] = "static/images/emptyuser.jpg";
							}
							else {
								$result['ProfilePicture'] = $row['ProfilePicture'];
							}
							echo json_encode($result);
						}
					}
				}		
			}
		}
		//mode is video
		else {
			
			
		}
	}
	else {
		echo 0;
	}
}
else {
	// Plain post
	if (isset($_POST['statuscontent'])&&!empty($_POST['statuscontent'])&&isset($_POST['privacy'])&&!empty($_POST['privacy'])) {
		$userid = $db->quote($_SESSION['LoggedInUserID']);
		$privacy = $db->quote($_POST['privacy']);
		$time = $db->quote(date("Y-m-d H:i:s", strtotime("now + 3 hours")));
		$timeunquoted = date("Y-m-d H:i:s", strtotime("now + 3 hours"));
		$statuscontentunquoted = $_POST['statuscontent'];
		$statuscontent = $db->quote($statuscontentunquoted);
		
		$query = "INSERT INTO post(PostID, UserID, Type, LevelOfAccess, Content, DateTimeOfPost) VALUES(NULL, $userid, 1, $privacy, $statuscontent, $time)";
		$exec = $db->exec($query);
		
		if ($exec) {
			$query = $db->prepare("SELECT * from user WHERE UserID = $userid;");
			
			$query->execute();
			$row = $query->fetch();
			
			$result = array();
			
			$postid = $db->lastInsertId();
			$result['PostID'] = $postid;
			$result['FirstName'] = $row['FirstName'];
			$result['LastName'] = $row['LastName'];
			$result['Content'] = $statuscontentunquoted;
			$result['PostDate'] = $timeunquoted;
			
			if ($row['ProfilePicture']=="") {
				$result['ProfilePicture'] = "static/images/emptyuser.jpg";
			}
			else {
				$result['ProfilePicture'] = $row['ProfilePicture'];
			}
			
			echo json_encode($result);
		}
	}
	else {
		echo 0;
	}
}
?>