<?php

	session_start();

	include '../../connect/connectPDO.php';
	
	$id = $db->quote($_SESSION['LoggedInUserID']);
	
	$query = "SELECT UserID, FirstName, LastName FROM user WHERE UserID <> $id;";
	$users = $db->query($query);
	
	$result = array();
	foreach ($users as $user) {
		array_push($result, $user);
	}

	echo json_encode($result);

?>