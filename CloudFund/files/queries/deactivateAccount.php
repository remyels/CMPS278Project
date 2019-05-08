<?php 

session_start();

include '../../connect/connectPDO.php';

$userid = $_SESSION['LoggedInUserID']; 

$query = "UPDATE user SET Deactivated = 1 WHERE UserID = $userid;";

$res = $db->exec($query);

if ($res && session_destroy()) {
	$query = $db->exec("UPDATE user SET Online = 0 WHERE UserID = $userid;");
	if ($query) header("Location: ../index.php");
}

?>