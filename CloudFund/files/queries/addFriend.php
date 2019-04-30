<?php

include '../../connect/connectPDO.php';

session_start();

if (isset($_POST['id'])&&!empty($_POST['id'])) {
	$idto = $db->quote($_POST['id']);
	$idfrom = $db->quote($_SESSION['LoggedInUserID']);
	$query = "INSERT INTO isfriendof VALUES($idfrom, $idto, 0);";
	
	$exec = $db->exec($query);
	
	if ($exec) {
		echo 1;
	}
	else {
		echo 0;
	}
}

?>