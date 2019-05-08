<?php

try {
	
	include '../../connect/connectPDO.php';

	session_start();

	if (isset($_REQUEST['email'])&&!empty($_REQUEST['email'])
		&&isset($_REQUEST['password'])&&!empty($_REQUEST['password'])) {
		$email = $db->quote($_REQUEST['email']);
		$password = openssl_digest($_REQUEST['password'], 'sha512');
		$password = $db->quote($password);

		$query = "SELECT * FROM user WHERE Email = $email AND Password = $password";
		
		$res = $db->query($query);
		
		if ($res->rowCount() > 0) {
			$row = $res->fetch();

			$active = $row['Active'];
			if ($active == 1) {
				// make the user online
				$id = $db->quote($row['UserID']);
				$query = $db->exec("UPDATE user SET Online = 1 WHERE UserID = $id;");
				$_SESSION["LoggedInUserID"] = $row['UserID'];
				$_SESSION["LoggedInUserType"] = $row['UserType'];
				$_SESSION["FirstName"] = $row['FirstName'];
				$_SESSION["LastName"] = $row['LastName'];
				$_SESSION["UserRow"] = $row;
				
				// need to check if user was deactivated, if they were, set Deactivated = 0
				if ($row['Deactivated']==1) {
					$userid = $row['UserID'];
					$query = "UPDATE user SET Deactivated = 0 WHERE UserID = $userid;";
					$db->exec($query);
				}

				if ($query) echo "<script>window.location =  'index.php'";
				else echo "<span style='color: red'>Database error, please try again later!</span>";
			}
			else {
				// A verified account was found
				echo "<span style='color: red'>You have not activated your account yet, make sure to check your email for the verification link!</span>";
			}
		}
		else {
			echo "<span style='color: red'>No user found with these credentials!</span>";
		}
	}
	//Should theoretically never happen
	else {
		echo "<span style='color: red'>Something is missing!</span>";
	}

} catch (PDOException $e) {
	echo "<span style='color: red'>".$e->getMessage()."</span>";
} 


?>