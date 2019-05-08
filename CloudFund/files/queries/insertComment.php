<?php 

include ("../../connect/connectPDO.php");

session_start();

if (isset($_POST['postid'])&&!empty($_POST['postid'])
	&&isset($_POST['content'])&&!empty($_POST['content']))
	{
		$postid = $db->quote($_POST['postid']);
		$content = $db->quote($_POST['content']);
		$commenterid = $db->quote($_SESSION['LoggedInUserID']);
		
		$query = "INSERT INTO comment VALUES(NULL, $commenterid, $postid, $content)";
		
		$exec = $db->exec($query);
		
		if ($exec) {
			echo "Successful insertion!";
		}
	}
else {
	echo "Oops! Something's missing...";
}
?>