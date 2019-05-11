<!DOCTYPE html>
<html>
<head>
    <?php include 'styles.php'; ?>
	<!-- includes for the table -->
	<link rel="stylesheet" type="text/css" href="static/table/vendor/animate/animate.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="static/table/vendor/select2/select2.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="static/table/vendor/perfect-scrollbar/perfect-scrollbar.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="static/table/css/util.css">
	<link rel="stylesheet" type="text/css" href="static/table/css/main.css">
<!--===============================================================================================-->
	<!-- end of includes for the table -->
	<script src="static/requests.js" type="text/javascript"></script>
	<style>
		.start {
			text-align: start;
		}
	</style>
</head>
<body>
	<?php 
	include "../connect/connectPDO.php";
	include "../connect/sessionCheck.php"; 
	include 'navbar.php'; 
	include "../connect/updateSession.php"; 
	?>
<div id="content">
		<!--<table border="1" style="margin: auto;" id="requests-table">
			<thead>
				<tr>
					<th>Name</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>-->
				<?php				
				$id = $db->quote($_SESSION['LoggedInUserID']);
				$query = "SELECT firstName, lastName, UserIDFrom FROM user, isfriendof WHERE UserIDFrom = user.UserID AND UserIDTo = $id AND accepted=0;";
				$rows = $db->query($query);
				$row_count = $rows->rowCount();
				
				if ($row_count==0) { ?>
					<div class="container container-fluid">
						<div class="row">
							<div class="col-lg-12">
								<h3>You don't have any friend requests!</h3>
							</div>
						</div>
					</div>
				<?php } else { ?>
					<div class="limiter">
						<div class="container-table100">
							<div  class="wrap-table100">
								<h2 id="header-message" style="margin-bottom: 20px;">Friend requests</h2>
								<div id="requests-container" class="table100 ver2 m-b-110">
									<div class="table100-head">
										<table>
											<thead>
												<tr class="row100 head">
													<th class="cell100 column1">Name</th>
													<th class="cell100 column2">Action</th>
												</tr>
											</thead>
										</table>
									</div>

									<div class="table100-body js-pscroll">
										<table>
											<tbody>
											
											
				<?php foreach($rows as $row)
				{
					?> 
					<tr class="start row100 body" id='row<?= $row['UserIDFrom']?>'>
						<td class="cell100 column1" id='<?= $row['UserIDFrom']?>' value='<?= $row['UserIDFrom']?>'><?= $row['firstName'] . " ". $row['lastName'] ?></td>
						<td class="cell100 column2">
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
			</div>
		</div>
	</div>
				<?php } ?>
			
</div>
<?php include 'footer.php'; ?>
</body>
</html>