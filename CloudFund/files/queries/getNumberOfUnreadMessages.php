<?php

include ("../../connect/connectPDO.php");

session_start();

$currentUserId = $db->quote($_SESSION['LoggedInUserID']);

$query = $db->prepare("SELECT COUNT(*) count FROM message m NATURAL JOIN messagestatus ms WHERE m.UserIDTo = $currentUserId AND ms.MessageStatus = 'Unread';");
$query->execute();

$row = $query->fetch();

echo $row['count'];

?>