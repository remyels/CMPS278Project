<!DOCTYPE html>
<html>
<head>
    <?php include 'styles.php'; ?>
	<link rel="stylesheet" type="text/css" href="static/AdminLTE.min.css">
	<link rel="stylesheet" href="static/bootstrap3-wysihtml5.min.css">
	<script src="static/bootstrap3-wysihtml5.all.min.js" type="text/javascript"></script>
	<script src="static/compose.js" type="text/javascript"></script>
	<script src="https://unpkg.com/moment"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/moment-timezone/0.5.25/moment-timezone.min.js"></script>
	<style>
	.undo {
		color: black;
	}
	
	#content p {
		text-align: left;
	}
	
	.box.box-primary {
		border-top-color: rgb(237, 57, 36);
	}
	
	.form-control:focus {
		border-color: rgb(237, 57, 36);
	}
	</style>
</head>
<body>
	<?php include 'navbar.php'; ?>

	<?php include 'modals.php'; ?>
<div id="content">
	<div class="container">
		<div class="row">
			<div class="col-md-2"></div>
			<div class="col-md-8">
			  <div class="box box-primary">
				<div class="box-header with-border">
				  <h3 class="box-title">Compose New Message</h3>
				</div>
				<!-- /.box-header -->
				<div class="box-body">
				  <div class="form-group undo">
				  <?php if (isset($_GET['UserID'])) { ?>
				  <input id="PostedUserID" type="hidden" value="<?= $_GET['UserID']?>"/>
				  <?php } else { ?>
				  <input id="PostedUserID" type="hidden" value=""/>
				  <?php } ?>
				  <p>Select a friend to send a message to:</p>
					<p>To:</p><select class="form-control" id="toUser" >
				<?php
					
					include "../connect/connectPDO.php";
				
					$currentUserId = $db->quote($_SESSION['LoggedInUserID']);
					$query = "SELECT UserIDFrom, UserIDTo FROM isfriendof WHERE ((UserIDFrom = $currentUserId AND accepted = 1) OR (UserIDTo = $currentUserId AND accepted = 1));";
					$rows = $db->query($query);
					if($rows->rowCount() > 0){
						foreach($rows as $row){
							$user;
							if ($row['UserIDFrom']==$_SESSION['LoggedInUserID']) {
								$user = $row['UserIDTo'];
							}
							else {
								$user = $row['UserIDFrom'];
							}
							$query = $db->prepare("SELECT FirstName, LastName FROM user WHERE UserID = $user;");
							$query->execute();
							$res = $query->fetch();
							
						?>
						<option value="<?=$user?>">
							<?=$res['FirstName']?> <?=$res['LastName']?>
						</option>
					<?php }
					} 
					else { ?>
						<option value="">You have no friends!</option>
					<?php }
					
				?>
					</select>
				  </div>
				  <div class="form-group">
					<input id="inputSubject" class="form-control" placeholder="Subject:">
				  </div>
				  <div class="form-group">
						<textarea id="compose-textarea" class="form-control" style="height: 300px">
						  
						</textarea>
				  </div>
				  
				</div>
				<!-- /.box-body -->
				<div class="box-footer">
					<div id="messageResult">
					</div>
				  <div class="pull-right">
					<button id="sendBtn" class="btn btn-primary" disabled><i id="send-icon" class="fa fa-paper-plane"></i><span id="send-message"> Send</span></button>
				  </div>
				</div>
				<!-- /.box-footer -->
			  </div>
			  <!-- /. box -->
			</div>
			<div class="col-md-2"></div>
		</div>
	</div>
</div>