<?php 

session_start();

include '../../connect/connectPDO.php';

$userid = $_SESSION['LoggedInUserID']; 

$query = "DELETE FROM user WHERE UserID = $userid;";

$res = $db->exec($query);

if ($res && session_destroy()) {
	header("Location: ../index.php");
}

?>