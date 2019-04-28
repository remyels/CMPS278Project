<?php

include ("../../connect/connectPDO.php");

session_start();

if (isset($_GET['id'])&&!empty($_GET['id'])) {
	$currentUserId = $db->quote($_SESSION['LoggedInUserID']);
	$currentMessageId = $db->quote($_GET['id']);
	$exec = $db->exec("DELETE FROM message m WHERE m.UserIDTo = $currentUserId AND m.MessageID = $currentMessageId;");
	if ($exec) {
		echo 1;
	}
	else {
		echo 0;
	}
}
?>