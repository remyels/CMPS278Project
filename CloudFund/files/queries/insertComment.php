<?php 

include ("../../connect/connectPDO.php");

session_start();

if (isset($_POST['postid'])&&!empty($_POST['postid'])
	&&isset($_POST['content'])&&!empty($_POST['content']))
	{
		$postid = $db->quote($_POST['postid']);
		$content = $db->quote($_POST['content']);
		$commenterid = $db->quote($_SESSION['LoggedInUserID']);
		$unquotedcommentdate = date("Y-m-d H:i:s", strtotime("now + 3 hours"));
		$commentdate = $db->quote($unquotedcommentdate);
		
		$query = "INSERT INTO comment VALUES(NULL, $commenterid, $postid, $content, $commentdate)";
		
		$exec = $db->exec($query);
		$commentid = $db->lastInsertId();
		$result = array();
		
		$result['CommentID'] = $commentid;
		$result['PostID'] = $postid;
		$result['Content'] = $_POST['content'];
		$result['CommentDate'] = $unquotedcommentdate;
		
		if ($exec) {
			$query = $db->prepare("SELECT * from user WHERE UserID = $commenterid;");
			
			$query->execute();
			$row = $query->fetch();
			
			$result['UserID'] = $row['UserID'];
			if($row['ProfilePicture'] == ''){
				$result['ProfilePicture'] = "static/images/emptyuser.jpg";
			}
			else{
				$result['ProfilePicture'] = $row['ProfilePicture'];
			}
			$result['FirstName'] = $row['FirstName'];
			$result['LastName'] = $row['LastName'];
			
			echo json_encode($result);
		}
	}
else {
	echo "Oops! Something's missing...";
}
?>