<?php

try {
	
	include '../../connect/connectPDO.php';

	if (isset($_REQUEST['email'])&&!empty($_REQUEST['email'])
		&&isset($_REQUEST['password'])&&!empty($_REQUEST['password'])
		&&isset($_REQUEST['firstname'])&&!empty($_REQUEST['firstname'])
		&&isset($_REQUEST['lastname'])&&!empty($_REQUEST['lastname'])
		&&isset($_REQUEST['gender'])&&!empty($_REQUEST['gender'])) {

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
				// token te3ito
				$hash = md5(rand(0, 1000));
				$hashesc = $db->quote($hash);

				$password = openssl_digest($_REQUEST['password'], 'sha512');
				$password = $db->quote($password);
				
				$gender = $db->quote($_REQUEST['gender']);
				$firstname = $db->quote($_REQUEST['firstname']);
				$lastname = $db->quote($_REQUEST['lastname']);

				$query = "INSERT INTO user(FirstName, LastName, UserType, Gender, Email, Password, Hash) VALUES ($firstname, $lastname, 1, $gender, $email, $password, $hashesc);";
				
				$exec = $db->exec($query);

				if ($exec) {

					$to = $_REQUEST['email'];
					$subject = "CloudFund signup";
					$body = '
	 
					Thanks for signing up!
					Your CloudFund account has been created; you will be able to log in to your account after activating your account using the link provided below:
					 
					Please click this link to activate your account:
					localhost/CMPS278Project/CloudFund/files/verify.php?email='.$to.'&hash='.$hash.'
					 
					'; 

					$headers = "From: cloudfundlb@gmail.com\r\n";
					
					$mail = mail($to, $subject, $body, $headers);
					
					if (!$mail) {
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
	}
	//Should theoretically never happen
	else {
		echo "<span style='color: red'>Something is missing!</span>";
	}

} catch (PDOException $e) {
	echo "<span style='color: red'>".$e->getMessage()."</span>";
} 


?>