<?php

try {
	
	include '../../connect/connectPDO.php';

	if (isset($_REQUEST['email'])&&!empty($_REQUEST['email'])
		&&isset($_REQUEST['password'])&&!empty($_REQUEST['password'])) {

		$email = $db->quote($_REQUEST['email']);
		$verifyLength = strlen($_REQUEST['password']) >= 8;
		$verifySymb = preg_match("/[-!\$%\^&*()_+|~=`\{\}\[\]:\";'<>?,\.\/@]/", $_REQUEST['password']);
		$verifyNum = preg_match("/\d/", $_REQUEST['password']);
		$verifyCapital = preg_match("/[A-Z]/", $_REQUEST['password']);
		$verifyPass = $verifyLength && $verifySymb && $verifyNum && $verifyCapital;
		
		if (!$verifyPass) {
			echo "<span style='color: red'>Invalid password format!</span>";
		}
		else {
			$password = openssl_digest($_REQUEST['password'], 'sha512');
			$password = $db->quote($password);
			
			$hash = $db->quote($_REQUEST['hash']);
			
			$query = $db->prepare("SELECT * FROM user WHERE Email = $email;");
			$query->execute();
			$row = $query->fetch();
			
			$id = $db->quote($row['UserID']);
			
			$query = $db->prepare("SELECT * FROM passwordreset WHERE UserID = $id AND Hash = $hash;");
			$query->execute();
			$row = $query->fetch();
			
			if ($row['Active']==0) {
				echo "<span style='color: red'>You have already clicked this link, please reset your password again!</span>";
			}
			else {
				// make all the password change requests of this user useless
				$query = $db->prepare("UPDATE passwordreset SET Active = 0 WHERE UserID = $id;");
				$query->execute();
				
				// update password
				$query = $db->prepare("UPDATE user SET Password = $password WHERE UserID = $id;");
				$query->execute();
				
				echo "<span style='color: green'>Password changed! Redirecting soon... Click <a href='index.php'>here</a> if you're not redirected automatically</span>";
			}
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