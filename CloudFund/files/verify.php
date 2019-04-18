<?php

try {
	include '../connect/connectPDO.php';


	if (isset($_REQUEST['email'])&&isset($_REQUEST['hash'])
		&&!empty($_REQUEST['email'])&&!empty($_REQUEST['hash'])) {
		$email = $db->quote($_REQUEST['email']);
		$hash = $db->quote($_REQUEST['hash']);
		
		$query = "SELECT * FROM user WHERE email=$email AND hash=$hash;";

		$rows = $db->query($query);
		
		if ($rows->rowCount() == 0) {
			echo "<p style='text-align: center'>You have followed an invalid link and will be redirected shortly</p>";
			echo "<script>
						setInterval(function() {window.location = 'index.php'}, 3000);
				</script>";
		}
		else {
			$row = $rows->fetch();
			if ($row['Active'] == 0) {
				$query = "UPDATE user SET Active=1 WHERE email=$email";
				$db->exec($query);
				if (!$db) {
					echo "<p style='text-align: center'>An unexpected error occurred, please try again later.</p>";
				}
				else {
					echo "<p style='text-align: center'>You have successfully activated your account and will be redirected shortly</p>";
					echo "<script>
						setInterval(function() {window.location = 'index.php'}, 3000);
						</script>";
				}
			}
			else {
					echo "<p style='text-align: center'>You have already activated your account and will be redirected shortly</p>";
					echo "<script>
						setInterval(function() {window.location = 'index.php'}, 3000);
						</script>";
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