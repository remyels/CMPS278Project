<?php

include '../../connect/connectPDO.php';

$id = $db->quote($_POST['id']);

$query = $db->prepare("SELECT ProfilePicture FROM user WHERE UserID = $id");

$query->execute();

$row = $query->fetch();

$filelocation = "../".$row['ProfilePicture'];

if (unlink($filelocation)) {
	$query = $db->prepare("UPDATE user SET ProfilePicture='' WHERE UserID = $id");
	$query->execute();
	if ($query) echo 1;
	else echo 0;
}
else {
	echo 0;
}

?>