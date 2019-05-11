<?php

include ("../../connect/connectPDO.php");

session_start();

if (isset($_GET['id'])&&!empty($_GET['id'])) {
	$currentUserId = $db->quote($_SESSION['LoggedInUserID']);
	$currentMessageId = $db->quote($_GET['id']);
	$query = $db->prepare("SELECT * FROM message m JOIN user ON m.UserIDFrom = user.UserID WHERE m.UserIDTo = $currentUserId AND m.MessageID = $currentMessageId;");
	$query->execute();
	$row = $query->fetch();
	
	$result = array();
	$result['firstname'] = $row['FirstName'];
	$result['lastname'] = $row['LastName'];
	$result['subject'] = $row['Subject'];
	$result['date'] = $row['MessageDate'];
	
	$exec = $db->exec("UPDATE message SET MessageStatusID = (SELECT MessageStatusID FROM messagestatus WHERE MessageStatus = 'Deleted') WHERE UserIDTo = $currentUserId AND MessageID = $currentMessageId;");
	if ($exec) {
		echo json_encode($result);
	}
	else {
		echo 0;
	}
}
?>