<?php

try {
	
	include '../../connect/connectPDO.php';

	session_start();

	if (isset($_REQUEST['email'])&&!empty($_REQUEST['email'])
		&&isset($_REQUEST['password'])&&!empty($_REQUEST['password'])
		&&isset($_REQUEST['id'])&&!empty($_REQUEST['id'])) {
		
		$verifyEmail  = preg_match("/^\w+@[A-Za-z0-9]+(\.[A-Za-z0-9]+)+$/", $_REQUEST['email']);
		$verifyLength = strlen($_REQUEST['password']) >= 8;
		$verifySymb = preg_match("/[-!\$%\^&*()_+|~=`\{\}\[\]:\";'<>?,\.\/@]/", $_REQUEST['password']);
		$verifyNum = preg_match("/\d/", $_REQUEST['password']);
		$verifyCapital = preg_match("/[A-Z]/", $_REQUEST['password']);
		$verifyPass = $verifyLength && $verifySymb && $verifyNum && $verifyCapital;
		
		if (!$verifyEmail) {
			echo "<span style='color: red'>Invalid email format!</span>";
		}
		else if (!$verifyPass) {
			echo "<span style='color: red'>Invalid password format!</span>";
		}
		else {					
			$email = $db->quote($_REQUEST['email']);
			$userid = $db->quote($_REQUEST['id']); 
			
			$password = openssl_digest($_REQUEST['password'], 'sha512');
			$password = $db->quote($password);
			$personalinformation = $db->quote($_REQUEST['personalinformation']);
			$professionalinformation = $db->quote($_REQUEST['professionalinformation']);

			$query = "UPDATE user SET Email = $email, Password = $password, PersonalInfo = $personalinformation, ProfessionalInfo = $professionalinformation WHERE UserID = $userid;";
			
			$exec = $db->exec($query);
			
			if ($exec) {
				echo "<span style='color: green'>User information updated successfully!</span>";
			}
			else {
				echo "<span style='color: red'>Something wrong happened on the server-side of things!</span>";
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