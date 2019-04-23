<?php

function updateSession($row) {
	$_SESSION["LoggedInUserID"] = $row['UserID'];
	$_SESSION["LoggedInUserType"] = $row['UserType'];
	$_SESSION["FirstName"] = $row['FirstName'];
	$_SESSION["LastName"] = $row['LastName'];
	$_SESSION["UserRow"] = $row;
}

?>