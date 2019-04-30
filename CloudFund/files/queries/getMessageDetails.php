<?php

include ("../../connect/connectPDO.php");

session_start();

if (isset($_GET['id'])&&!empty($_GET['id'])) {
	$currentUserId = $db->quote($_SESSION['LoggedInUserID']);
	$currentMessageId = $db->quote($_GET['id']);
	if (strcmp($_GET['mode'], "received")==0) {
		$query = $db->prepare("SELECT * FROM message m NATURAL JOIN messagestatus JOIN user u ON u.UserID = m.UserIDFrom WHERE m.UserIDTo = $currentUserId AND m.MessageID = $currentMessageId;");
		$query->execute();
		$numrows = $query->rowCount();
		
		if ($numrows==0) {
			echo "Error";
		}
		else {
			$row = $query->fetch();
			
			// Update to read
			if(strcmp($row['MessageStatus'], "Unread")==0) {
				$query = "UPDATE message SET MessageStatusID = 2 WHERE MessageID = $currentMessageId;";
				$exec = $db->exec($query);
			}
			
			$result = array();
			$result['subject'] = $row['Subject'];
			$result['date'] = $row['MessageDate'];
			$result['from'] = $row['FirstName']." ".$row['LastName'];
			$result['message'] = $row['Message'];
			
			echo json_encode($result);
		}
	}
	else if (strcmp($_GET['mode'], "sent")==0) {
		$query = $db->prepare("SELECT * FROM message m NATURAL JOIN messagestatus JOIN user u ON u.UserID = m.UserIDTo WHERE m.UserIDFrom = $currentUserId AND m.MessageID = $currentMessageId;");
		$query->execute();
		$numrows = $query->rowCount();
		
		if ($numrows==0) {
			echo "Error";
		}
		else {
			$row = $query->fetch();
			
			$result['subject'] = $row['Subject'];
			$result['date'] = $row['MessageDate'];
			$result['to'] = $row['FirstName']." ".$row['LastName'];
			$result['message'] = $row['Message'];
			
			echo json_encode($result);
		}
	}
	else {
		echo 0;
	}
}

?>