<?php

try {
	include '../../connect/connectPDO.php';


	if (isset($_REQUEST['name'])&&isset($_REQUEST['email'])&&isset($_REQUEST['textContent'])
		&&!empty($_REQUEST['name'])&&!empty($_REQUEST['email'])&&!empty($_REQUEST['textContent'])) {
		$name = $db->quote($_REQUEST['name']);
		$email = $db->quote($_REQUEST['email']);
		$textContent = $db->quote($_REQUEST['textContent']);
		
		$query = "INSERT INTO feedback(Email, Feedback, Name) VALUES ($email, $textContent, $name)";
		
		$db->exec($query);
		
		if ($db)
			echo "<span style='color: green'>Thanks for your feedback!</span>";
		else 
			echo "<span style='color: red'>There seems to be a problem on our end, please try again later.</span>";
	}
	//Should theoretically never happen
	else {
		echo "<span style='color: red'>Something is missing!</span>";
	}

} catch (PDOException $e) {
	echo "<span style='color: red'>".$e->getMessage()."</span>";
} 


?>