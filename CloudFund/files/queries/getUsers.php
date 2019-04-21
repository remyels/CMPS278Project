<?php
	include '../../connect/connectPDO.php';
	$query = 'SELECT FirstName, LastName FROM user;';
	$users = $db->query($query);
	
	$result = array();
	foreach ($users as $user) {
		array_push($result, $user);
	}

	echo json_encode($result);

?>