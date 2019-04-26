<?php
	include '../../connect/connectPDO.php';
	include "../../connect/sessionCheck.php"; 
	
	$id = $db->quote($_SESSION['LoggedInUserID']);
	$from = $db->quote($_REQUEST['UserIDFrom']);
	
	$result = "false";

	if(isset($_REQUEST["UserIDFrom"]) && !empty($_REQUEST["UserIDFrom"])) 
	{
		$query = "UPDATE isfriendof SET accepted = 1 WHERE UserIDFrom = $from AND UserIDTo = $id;";
		$execution = $db->exec($query);
		
		$numnotaccepted = $db->prepare("SELECT COUNT(*) AS count FROM isfriendof WHERE UserIDTo = $id AND accepted=0;");
		$numnotaccepted->execute();
		$row = $numnotaccepted->fetch();
		$numleft = $row['count'];
		
		if($execution){
			$result = "true ".$numleft;
		}
	}
	echo $result;
?>
