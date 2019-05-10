<?php

include '../../connect/connectPDO.php';

session_start();

if (isset($_POST['postid'])&&!empty($_POST['postid'])) {
	$postid = $db->quote($_POST['postid']);
	$query = $db->prepare("SELECT COUNT(*) count FROM comment WHERE PostID = $postid;");
	$query->execute();
	$row = $query->fetch();
	echo $row['count'];
}
else {
	echo "Something is missing!";
}