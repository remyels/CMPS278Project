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
				  <p>Select a friend to send a message to:</p>
					<p>To:</p><select class="form-control" id="toUser" >
					<option value="1">First1 Last1</option>
					<option value="2">First2 Last2</option>
					<option value="3">First3 Last3</option>
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