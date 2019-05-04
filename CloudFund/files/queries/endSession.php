<?php 

session_start();

include '../../connect/connectPDO.php';

$userid = $_SESSION['LoggedInUserID']; 

if (session_destroy()) {
	$query = $db->exec("UPDATE user SET Online = 0 WHERE UserID = $userid;");
	if ($query) header("Location: ../index.php");
}

?>