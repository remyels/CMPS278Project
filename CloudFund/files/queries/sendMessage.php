<?php 

include ("../../connect/connectPDO.php");

session_start();

if (isset($_POST['to'])&&!empty($_POST['to'])
	&&isset($_POST['subject'])&&!empty($_POST['subject'])
	&&isset($_POST['message'])&&!empty($_POST['message']))
	{
		$to = $db->quote($_POST['to']);
		$subject = $db->quote($_POST['subject']);
		$message = $db->quote($_POST['message']);
		$from = $db->quote($_SESSION['LoggedInUserID']);
		$datetime = $db->quote($_POST['datetime']);
		
		$query = "INSERT INTO message VALUES(NULL, $from, $to, $subject, $message, $datetime, 1)";
		
		$exec = $db->exec($query);
		
		if ($exec) {
			echo 1;
		}
		else {
			echo 0;
		}
	}
?>