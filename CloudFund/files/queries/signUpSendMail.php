<?php

try {
	
	include '../../connect/connectPDO.php';

	if (isset($_REQUEST['email'])&&!empty($_REQUEST['email'])
		&&isset($_REQUEST['password'])&&!empty($_REQUEST['password'])
		&&isset($_REQUEST['firstname'])&&!empty($_REQUEST['firstname'])
		&&isset($_REQUEST['lastname'])&&!empty($_REQUEST['lastname'])) {

		$email = $db->quote($_REQUEST['email']);
		
		//First, we need to check whether the account is already created given the provided email

		$query = "SELECT * FROM user WHERE email = $email";
		
		$res = $db->query($query);
		
		if ($res->rowCount() > 0) {
			// An account with the provided email was found
			$query = "SELECT * FROM user WHERE email = $email AND active = 0";
			$res = $db->query($query);
			if ($res->rowCount() > 0) {
				// An unverified account was found
				echo "<span style='color: red'>You already have an account linked with the provided email; check your email for the verification link!</span>";
			}
			else {
				// A verified account was found
				echo "<span style='color: red'>You already have an account linked with the provided email! If you forgot your password, press 'Forgot your password' on the login screen</span>";
			}
		}
		else {
			$hash = md5(rand(0, 1000));
			$hashesc = $db->quote($hash);

			$password = openssl_digest($_REQUEST['password'], 'sha512');
			$password = $db->quote($password);

			$firstname = $db->quote($_REQUEST['firstname']);
			$lastname = $db->quote($_REQUEST['lastname']);

			$query = "INSERT INTO user(FirstName, LastName, UserType, Email, Password, Hash) VALUES ($firstname, $lastname, 1, $email, $password, $hashesc);";
			
			$db->exec($query);

			if ($db) {

				$to = $_REQUEST['email'];
				$subject = "CloudFund signup";
				$body = '
 
				Thanks for signing up!
				Your CloudFund account has been created; you will be able to log in to your account after activating your account using the link provided below:
				 
				Please click this link to activate your account:
				localhost/CloudFund/files/verify.php?email='.$to.'&hash='.$hash.'
				 
				'; 

				$headers = "From: remysabeh@gmail.com\r\n";
				
				if (!mail($to, $subject, $body, $headers)) {
					echo "Mailer Error: ".$mail->ErrorInfo;
				} else {
					echo "<span style='color: green'>Account successfully created, check your email for the verification link!</span>";
				} // Send our email
			}

			else {
				echo "<span style='color: red'>Something went wrong, please try again later!</span>";
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