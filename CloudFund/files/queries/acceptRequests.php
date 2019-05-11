<?php
	include '../../connect/connectPDO.php';
	include "../../connect/sessionCheck.php"; 
	
	if (isset($_REQUEST['source'])&&!empty($_REQUEST['source'])) {
		if ($_REQUEST['source'] == 'profile') {
			if (isset($_REQUEST['UserID']) && !empty($_REQUEST['UserID'])) {
				$to = $db->quote($_SESSION['LoggedInUserID']);
				$fromunquoted = $_REQUEST['UserID'];
				$from = $db->quote($fromunquoted);
				
				
				$query = $db->exec("UPDATE isfriendof SET accepted = 1 WHERE UserIDFrom = $from AND UserIDTo = $to;");
				if ($query) {
					header("Location: ../profile.php?UserID=$fromunquoted");
				}
			}
			else {
				echo "Missing parameter: UserID!";
			}
		}
		else if ($_REQUEST['source'] == 'requests') {
			$id = $db->quote($_SESSION['LoggedInUserID']);
			$from = $db->quote($_REQUEST['UserIDFrom']);
			
			$result = "false";

			if(isset($_REQUEST["UserIDFrom"]) && !empty($_REQUEST["UserIDFrom"])) 
			{
				$query = "UPDATE isfriendof SET accepted = 1 WHERE UserIDFrom = $from AND UserIDTo = $id;";
				$execution = $db->exec($query);
				
				$numnotaccepted = $db->prepare("SELECT COUNT(*) AS count FROM isfriendof WHERE UserIDTo = $id AND accepted=0;");
				$numnotaccepted->execute();
				$row = $numnotaccepted->fetch();
				$numleft = $row['count'];
				
				if($execution){
					$result = "true ".$numleft;
				}
			}
			echo $result;
		}
		else {
			echo "Invalid parameter: source!";
		}
	}
	else {
		echo "Missing parameter: source!";
	}
?>
