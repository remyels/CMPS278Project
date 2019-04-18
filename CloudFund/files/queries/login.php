<?php

try {
	
	include '../../connect/connectPDO.php';

	session_start();

	if (isset($_REQUEST['email'])&&!empty($_REQUEST['email'])
		&&!empty($_REQUEST['email'])&&!empty($_REQUEST['password'])) {
		$email = $db->quote($_REQUEST['email']);
		$password = openssl_digest($_REQUEST['password'], 'sha512');
		$password = $db->quote($password);

		$query = "SELECT * FROM user WHERE Email = $email AND Password = $password";
		
		$res = $db->query($query);
		
		if ($res->rowCount() > 0) {
			$row = $res->fetch();

			$active = $row['Active'];
			if ($active == 1) {
				$_SESSION["LoggedInUserID"] = $row['UserID'];
				$_SESSION["LoggedInUserType"] = $row['UserType'];
				$_SESSION["FirstName"] = $row['FirstName'];
				$_SESSION["LastName"] = $row['LastName'];

				echo "<script>window.location =  'home.php'";
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