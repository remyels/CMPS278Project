<?php session_start(); ?>

<!DOCTYPE html>
<html>
<head>
    <?php include 'styles.php'; ?>
	<link rel="stylesheet" type="text/css" href="cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
	<script src="cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js" type="text/javascript"></script>
	<script src="cdn.datatables.net/1.10.19/js/dataTables.bootstrap.min.js" type="text/javascript"></script>
	<script src="static/requests.js" type="text/javascript"></script>
</head>
<body>
	<?php 
	include "../connect/connectPDO.php";
	include "../connect/sessionCheck.php"; 
	include 'navbar.php'; 
	include "../connect/updateSession.php"; 
	?>
<form method="post">
<div id="content">
	<div class="jumbotron container container-fluid">
		<table id="requests-table">
			<thead>
				<tr>
					<th>Name</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				<?php				
				$id = $db->quote($_SESSION['LoggedInUserID']);
				$query = "SELECT firstName, lastName, UserIDFrom FROM user, isfriendof WHERE UserIDFrom = user.UserID AND UserIDTo = $id;";
				$rows = $db->query($query);
				foreach($rows as $row)
				{
					?> 
					<tr id='row<?= $row['UserIDFrom']?>'>
						<td id='<?= $row['UserIDFrom']?>' value='<?= $row['UserIDFrom']?>'><?= $row['firstName'] . " ". $row['lastName'] ?></td>
						<td>
							<div class="btn-group">
								<button id='accept<?= $row['UserIDFrom'] ?>' type="button" class="btn btn-success" onclick="acceptFriend(this.id)">Accept</button>
								<button id='reject<?= $row['UserIDFrom'] ?>' type="button" class="btn btn-danger" onclick="rejectFriend(this.id)">Reject</button>
							</div>
						</td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
</div>
</form>
<?php include 'footer.php'; ?>
</body>
</html>