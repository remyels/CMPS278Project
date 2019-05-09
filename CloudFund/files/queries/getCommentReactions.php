<?php

include '../../connect/connectPDO.php';

session_start();

if (isset($_POST['commentid'])&&!empty($_POST['commentid'])
	&&isset($_POST['mode'])&&!empty($_POST['mode'])) {
	if ($_POST['mode']=='likes' || $_POST['mode']=='dislikes') {
		$lookingfor = ($_POST['mode']=='likes') ? 1 : 0;
		$commentid = $db->quote($_POST['commentid']);
		$query = $db->prepare("SELECT COUNT(*) count FROM reactcomment WHERE CommentID = $commentid AND IsLike = $lookingfor;");
		$query->execute();
		$row = $query->fetch();
		// echo '<script>alert('.$row['count'].');</script>';
		echo $row['count'];
	}
	else {
		echo "Invalid mode";
	}
}
else {
	echo 0;
}