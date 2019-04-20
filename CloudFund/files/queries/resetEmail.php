<?php

try {
	
	include '../../connect/connectPDO.php';

	if (isset($_REQUEST['email'])&&!empty($_REQUEST['email']) {

		$email = $db->quote($_REQUEST['email']);
		
		//First, we need to check whether the account is already created given the provided email

		$query = "SELECT * FROM user WHERE email = $email";
		
		$res = $db->query($query);
		
		if ($res->rowCount() > 0) {
			// An account with the provided email was found
			$query = "SELECT UserID FROM user WHERE email = $email AND active = 0";
			$res = $db->query($query);
			if ($res->rowCount() > 0) {
				// An unverified account was found
				echo "<span style='color: red'>You haven't verified your email yet! Please check your email for the verification link!</span>";
			}
			else {
				// A verified account was found, an email will be sent
				$row = $res->fetch();
				$userid = $row['UserID'];
				
				$hash = md5(rand(0, 1000));
				$hashesc = $db->quote($hash);
				
				$query = "INSERT INTO passwordreset VALUES($userid, $hashesc, 1)";
				
				$exec = $db->exec($query);
				
				if ($exec) {
					$to = $_REQUEST['email'];
					$subject = "CloudFund password reset";
					$body = '
	 
					You have requested a password reset. In order to reset your password, please click on the link below:
					
					localhost/CloudFund/files/resetPassword.php?email='.$to.'&hash='.$hash.'
					 
					(If you did not request a password reset, please disregard this email.). 
					 
					'; 

					$headers = "From: remysabeh@gmail.com\r\n";
					
					if (!mail($to, $subject, $body, $headers)) {
						echo "Mailer Error: ".$mail->ErrorInfo;
					} else {
						echo "<span style='color: green'>Password reset request successfully went through, please check your email to proceed!</span>";
					}
				}
				else {
					echo "<span style='color: red'>Something went wrong, please try again later!</span>";
				}
			}
		}
		else {
			echo "<span style='color: red'>No account was found with the provided email!</span>";
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