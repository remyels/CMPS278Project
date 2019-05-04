<?php

include '../../connect/connectPDO.php';

session_start();

if (isset($_POST['postid'])&&!empty($_POST['postid'])
	&&isset($_POST['mode'])&&!empty($_POST['mode'])) {
	if ($_POST['mode']=='likes' || $_POST['mode']=='dislikes') {
		$lookingfor = ($_POST['mode']=='likes') ? 1 : 0;
		$postid = $db->quote($_POST['postid']);
		$query = $db->prepare("SELECT COUNT(*) count FROM reactpost WHERE PostID = $postid AND IsLike = $lookingfor;");
		$query->execute();
		$row = $query->fetch();
		echo $row['count'];
	}
	else {
		echo "Invalid mode";
	}
}
else {
	echo 0;
}