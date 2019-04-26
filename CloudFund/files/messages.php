<!DOCTYPE html>
<html>
<head>
    <?php include 'styles.php'; ?>
	<link rel="stylesheet" type="text/css" href="static/AdminLTE.min.css">
	<style>
		.btn-primary,
		.btn-primary:hover,
		.btn-primary:active,
		.btn-primary:visited,
		.btn-primary:focus {
			background-color: rgb(237, 57, 36) !important;
			border-color: rgb(237, 57, 36) !important;
		}
		
		.box.box-primary {
			border-top-color: rgb(237, 57, 36) !important;
		}
		
		.nav-stacked>li.active>a, .nav-stacked>li.active>a:hover {
			border-left-color: rgb(237, 57, 36) !important;
		}
		
		.bg-light-blue, .label-primary, .modal-primary .modal-body {
			background-color: rgb(237, 57, 36) !important;
		}
		
		.nav-pills>li.active>a:focus, .nav-pills>li.active>a:hover {
			color: #fff;
			background-color: rgb(237, 57, 36);
		}
		
		.undo {
			color: black;
		}
	</style>
</head>
<body>
	<?php include 'navbar.php'; ?>
	<?php include 'modals.php'; ?>
	
	    <!-- Main content -->
    <div id="content">
	  <div class="container container-fluid">
		  <div class="row">
			<div class="col-md-3">
			  <a href="compose.php" class="btn btn-primary btn-block margin-bottom">Compose Message</a>

			  <div class="box box-solid">
				<div class="box-header with-border">
				  <h3 class="box-title">Folders</h3>
				</div>
				<div class="box-body no-padding">
				  <ul class="nav nav-pills nav-stacked">
					<li class="active"><a href="messages.php"><i class="fa fa-inbox"></i> Inbox
					  <span class="label label-primary pull-right">3</span></a></li>
					<li><a href="sentMessages.php"><i class="fa fa-envelope-o"></i> Sent</a></li>
					</li>
					<li><a href="deletedMessages.php"><i class="fa fa-trash-o"></i> Trash</a></li>
				  </ul>
				</div>
				<!-- /.box-body -->
			  </div>
			  
			</div>
			<!-- /.col -->
			<div class="col-md-9">
			  <div class="box box-primary">
				<div class="box-header with-border">
				  <h3 class="box-title">Inbox</h3>
				  <!-- /.box-tools -->
				</div>
				<!-- /.box-header -->
				<div class="box-body no-padding">
				  <div class="mailbox-controls">
					<!-- Check all button -->
					<button type="button" class="btn btn-default btn-sm checkbox-toggle"><i class="fa fa-square-o"></i>
					</button>
					<div class="btn-group">
					  <button type="button" class="btn btn-default btn-sm"><i class="fa fa-trash-o"></i></button>
					</div>
					<div class="pull-right">
					  <span class="undo"> 1-50/200 </span>
					  <div class="btn-group">
						<button type="button" class="btn btn-default btn-sm"><i class="fa fa-chevron-left"></i></button>
						<button type="button" class="btn btn-default btn-sm"><i class="fa fa-chevron-right"></i></button>
					  </div>
					  <!-- /.btn-group -->
					</div>
					<!-- /.pull-right -->
				  </div>
				  <div class="table-responsive mailbox-messages">
					<table class="table table-hover table-striped">
					  <tbody>
					  <?php
						include('../connect/connectPDO.php');
				
						$numberOfMessages = 0;
						
						$currentUserId = $db->quote($_SESSION['LoggedInUserID']);
						$query = "SELECT * FROM message m JOIN user u on m.UserIDFrom = u.UserID JOIN messagestatus ms on m.MessageStatus = ms.MessageStatusID where m.UserIDTo = $currentUserId AND ms.MessageStatus <> 'Deleted' ORDER BY m.MessageDate DESC";
						$rows = $db->query($query);
						
						if($rows->rowCount() > 0){
							$numberOfMessages = $rows->rowCount();
							foreach($rows as $row){
								
					  ?>
					  <tr id="<?=$row['MessageID']?>">
						<td><div class="icheckbox_flat-blue" aria-checked="false" aria-disabled="false" style="position: relative;"><input type="checkbox" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins></div></td>
						<td class="mailbox-name notranslate"><a data-id="<?=$row['MessageID']?>"><?php if($row["MessageStatus"] == "Unread"){echo '<span class="label label-primary pull-right">new</span>';}?>From: <?=$row['FirstName']?> <?=$row['LastName']?></a></td>
						<td class="mailbox-subject notranslate"><b><?=$row['Subject']?></b></td>
						<td class="mailbox-attachment"></td>
						<td class="mailbox-date"><?=$row['MessageDate']?></td>
					  </tr>
					  <?php
						}
						}else{
							//Do something if the user has no messages
							?>
							<tr>
								<td class="mailbox-subject undo">You have no new messages</td>
							</tr>
							<?php
						}
					  ?>
					  </tbody>
					</table>
					<!-- /.table -->
				  </div>
				  <!-- /.mail-box-messages -->
				</div>
				<!-- /.box-body -->
				<div class="box-footer no-padding">
				  <div class="mailbox-controls">
					<!-- Check all button -->
					<button type="button" class="btn btn-default btn-sm checkbox-toggle"><i class="fa fa-square-o"></i>
					</button>
					<div class="btn-group">
					  <button type="button" class="btn btn-default btn-sm"><i class="fa fa-trash-o"></i></button>
					</div>
					<!-- /.btn-group -->
					<button type="button" class="btn btn-default btn-sm"><i class="fa fa-refresh"></i></button>
					<div class="pull-right">
					  <span class="undo"> 1-50/200 </span>
					  <div class="btn-group">
						<button type="button" class="btn btn-default btn-sm"><i class="fa fa-chevron-left"></i></button>
						<button type="button" class="btn btn-default btn-sm"><i class="fa fa-chevron-right"></i></button>
					  </div>
					  <!-- /.btn-group -->
					</div>
					<!-- /.pull-right -->
				  </div>
				</div>
			  </div>
			  <!-- /. box -->
			</div>
			
			
			<div class="col-md-9">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Read Mail</h3>

              <div class="box-tools pull-right">
                <a href="#" class="btn btn-box-tool" data-toggle="tooltip" title="" data-original-title="Previous"><i class="fa fa-chevron-left"></i></a>
                <a href="#" class="btn btn-box-tool" data-toggle="tooltip" title="" data-original-title="Next"><i class="fa fa-chevron-right"></i></a>
              </div>
            </div>
            <!-- /.box-header -->
			<?php
				include('connectPDO.php');
			
				$currentUserId = $db->quote($_SESSION['LOGGED_IN_USER_ID']);
				$currentMessageId = $db->quote($_GET['messageId']);
				$query = $db->prepare("SELECT * FROM message m JOIN user u on m.FROM_USER = USERID JOIN messagestatus ms on m.MESSAGESTATUSID = ms.MESSAGESTATUSID where (m.TO_USER = $currentUserId OR m.FROM_USER = $currentUserId) AND m.MESSAGEID = $currentMessageId;");
				$query->execute();
				$row = $query->fetch();
				
				$messageid = $row['MessageID'];
				
				if($row["MessageStatus"] == "Unread") {
					$query = "UPDATE message SET MessageStatus = 2 WHERE MessageID = $messageid;";
				}
							
							?>
            <div class="box-body no-padding">
              <div class="mailbox-read-info">
                <h3 id="subject">Subject here</h3>
                <h5>From: <span id="first-name">First Name</span> <span id="last-name">Last Name</span>
                  <span id="date" class="mailbox-read-time pull-right">Sent on this specific day</span></h5>
              </div>
              <!-- /.mailbox-read-info -->
              <div class="mailbox-controls with-border text-center">
                <div class="btn-group">
                  <button id="deleteBtn2" type="button" class="btn btn-default btn-sm" data-toggle="tooltip" data-container="body" title="" data-original-title="Delete">
                    <i class="fa fa-trash-o"></i></button>
                  <button type="button" class="btn btn-default btn-sm" data-toggle="tooltip" data-container="body" title="" data-original-title="Reply">
                    <i class="fa fa-reply"></i></button>
                  
                </div>
                <!-- /.btn-group -->
                <button type="button" class="btn btn-default btn-sm" data-toggle="tooltip" title="" data-original-title="Print">
                  <i class="fa fa-print"></i></button>
              </div>
              <!-- /.mailbox-controls -->
              <div class="mailbox-read-message">
                This is to test the message
              </div>
              <!-- /.mailbox-read-message -->
            </div>
          
            <!-- /.box-footer -->
            <div class="box-footer">
              <div class="pull-right">
                <button type="button" class="btn btn-default"><i class="fa fa-reply"></i> Reply</button>
              </div>
			  
              <button type="button" id="deleteBtn" class="btn btn-danger"><i class="fa fa-trash-o"></i> Delete</button>
              <button type="button" class="btn btn-default"><i class="fa fa-print"></i> Print</button>
            </div>
			<div id="feedback"></div>
            </div>
            <!-- /.box-footer -->
          </div>
			<!-- /.col -->
		  </div>
		</div>
      <!-- /.row -->
    </div>
	<?php include 'footer.php'; ?>
</body>
</html>