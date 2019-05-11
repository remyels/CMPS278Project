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
		
		.undo-center {
			text-align: initial;
		}
		
		.invisible {
			display: none;
		}
	</style>
	<script src="static/messages.js" type="text/javascript"></script>
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
					<li class="active"><a id="inbox" class="folder" style="cursor: pointer;"><i class="fa fa-inbox"></i> Inbox
					  <span id="number-unread" class="label label-primary pull-right"></span></a></li>
					<li><a id="sent" class="folder" style="cursor: pointer;"><i class="fa fa-envelope-o"></i> Sent</a></li>
					</li>
					<li><a id="trash" class="folder" style="cursor: pointer;"><i class="fa fa-trash-o"></i> Trash</a></li>
				  </ul>
				</div>
				<!-- /.box-body -->
			  </div>
			  
			</div>
			
			
			
			
			
			
			
			
			
			
			
			
			<!-- /.col -->
			<div id="all-messages" class="col-md-9">
			  <div class="box box-primary">
				<div class="box-header with-border">
				  <h3 class="box-title">Inbox</h3>
				  <!-- /.box-tools -->
				</div>
				<!-- /.box-header -->
				<div class="box-body no-padding">
				  <div class="mailbox-controls">
					<!-- Check all button -->
					<button type="button" class="btn btn-default btn-sm checkbox-toggle invisible"><i class="fa fa-square-o"></i>
					</button>
					<div class="btn-group">
					  <button type="button" class="btn btn-default btn-sm invisible"><i class="fa fa-trash-o"></i></button>
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
						$query = "SELECT * FROM message m JOIN user u on m.UserIDFrom = u.UserID JOIN messagestatus ms on m.MessageStatusID = ms.MessageStatusID where m.UserIDTo = $currentUserId AND ms.MessageStatus <> 'Deleted' ORDER BY m.MessageDate DESC";
						$rows = $db->query($query);
						
						if($rows->rowCount() > 0){
							$numberOfMessages = $rows->rowCount();
							foreach($rows as $row){
								
					  ?>
					  <tr id="<?=$row['MessageID']?>">
						<td><div class="icheckbox_flat-blue" aria-checked="false" aria-disabled="false" style="position: relative;"><input type="checkbox" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins></div></td>
						<td class="mailbox-name notranslate"><a class="message-click" style="cursor: pointer;" data-id="<?=$row['MessageID']?>"><span style="<?php if($row["MessageStatus"] != "Unread"){echo 'visibility: hidden;';}?>" class="label new-message label-primary pull-right">new</span>From: <?=$row['FirstName']?> <?=$row['LastName']?></a></td>
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
								<td class="mailbox-subject undo">You have no messages</td>
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
				  <div style="margin-bottom: 10px;" class="mailbox-controls">
					<!-- Check all button -->
					<button type="button" class="btn btn-default btn-sm checkbox-toggle invisible"><i class="fa fa-square-o"></i>
					</button>
					<div class="btn-group">
					  <button type="button" class="btn btn-default btn-sm invisible"><i class="fa fa-trash-o"></i></button>
					</div>
					<!-- /.btn-group -->
					<button type="button" class="btn btn-default btn-sm invisible"><i class="fa fa-refresh"></i></button>
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
			
			
			
			
			
			
			
			
			
			
			
			
			
			<div id="selected-message" style="display: none;" class="col-md-9">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Read Mail</h3>
            </div>
            <!-- /.box-header -->
			<?php
			
				// $currentUserId = $db->quote($_SESSION['LoggedInUserID']);
				// $currentMessageId = $db->quote($_GET['MessageID']);
				// $query = $db->prepare("SELECT * FROM message m JOIN user u on m.UserIDFrom = UserID JOIN messagestatus ms on m.MessageStatus = ms.MessageStatusID where (m.UserIDTo = $currentUserId OR m.UserIDFrom = $currentUserId) AND m.MessageID = $currentMessageId;");
				// $query->execute();
				// $row = $query->fetch();
				
				// $messageid = $row['MessageID'];
				
				// if($row["MessageStatus"] == "Unread") {
					// $query = "UPDATE message SET MessageStatus = 2 WHERE MessageID = $messageid;";
				// }
							
							?>
            <div class="box-body no-padding">
              <div class="mailbox-read-info">
                <h3 id="subject" class="undo-center" >Error</h3>
                <h5 class="undo-center"><span id="destination">From:</span> <span id="name">Error</span>
                  <span id="date" class="mailbox-read-time pull-right">Error</span></h5>
              </div>
              <!-- /.mailbox-controls -->
              <div id="message-content" class="mailbox-read-message">
                Error
              </div>
              <!-- /.mailbox-read-message -->
            </div>
          
            <!-- /.box-footer -->
            <div class="box-footer">
			  
              <button type="button" id="deleteBtn" class="btn btn-danger"><i class="fa fa-trash-o"></i> Delete</button>
              <button type="button" id="backBtn" class="btn btn-default"><i class="fa fa-arrow-left"></i> Back</button>
            </div>
            </div>
            <!-- /.box-footer -->
          </div>
		  
		  
		  
		  
		  
		  
		  
		  
		  
		  
		  
		  
		  
		  
		  
		  <div id="sent-messages" style="display: none;" class="col-md-9">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Sent Messages</h3>
              <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding">
              <div class="mailbox-controls">
                <!-- Check all button -->
                <button type="button" class="btn btn-default btn-sm checkbox-toggle invisible"><i class="fa fa-square-o"></i>
                </button>
                <div class="btn-group">
                  <button type="button" class="btn btn-default btn-sm invisible"><i class="fa fa-trash-o"></i></button>
                </div>
                <div class="pull-right">
                  <span class="undo">1-50/200</span>
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
					$query = "SELECT * FROM message m JOIN user u on m.UserIDTo = u.UserID JOIN messagestatus ms on m.MessageStatusID = ms.MessageStatusID WHERE m.UserIDFrom = $currentUserId ORDER BY m.MessageDate DESC";
					$rows = $db->query($query);
					
					if($rows->rowCount() > 0){
						$numberOfMessages = $rows->rowCount();
						foreach($rows as $row){
				
				  ?>
                  <tr id="<?=$row['MessageID']?>">
                    <td><div class="icheckbox_flat-blue" aria-checked="false" aria-disabled="false" style="position: relative;"><input type="checkbox" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins></div></td>
                    <td class="mailbox-name notranslate"><a class="message-sent-click" style="cursor: pointer;" data-id="<?=$row['MessageID']?>"><span style="<?php if($row["MessageStatus"] != "Unread"){echo 'visibility: hidden;';}?>" class="label label-primary pull-right">Not Read</span>To:  <?=$row['FirstName']?> <?=$row['LastName']?></a></td>
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
							<td class="mailbox-subject undo">You did not send any message yet.</td>
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
              <div style="margin-bottom: 10px;" class="mailbox-controls">
                <!-- Check all button -->
                <button type="button" class="btn btn-default btn-sm checkbox-toggle invisible"><i class="fa fa-square-o"></i>
                </button>
                <div class="btn-group">
                  <button type="button" class="btn btn-default btn-sm invisible"><i class="fa fa-trash-o"></i></button>
                </div>
                <!-- /.btn-group -->
                <button type="button" class="btn btn-default btn-sm invisible"><i class="fa fa-refresh"></i></button>
                <div class="pull-right">
                  <span class="undo">1-50/200</span>
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
		
		
		
		
		
		
		
		
		
		
		
		
		<div id="deleted-messages" style="display: none;" class="col-md-9">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Deleted Messages</h3>
              <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding">
              <div class="mailbox-controls">
                <!-- Check all button -->
                <button type="button" class="btn btn-default btn-sm checkbox-toggle invisible"><i class="fa fa-square-o"></i>
                </button>
                <div class="btn-group">
                  <button type="button" class="btn btn-default btn-sm invisible"><i class="fa fa-trash-o"></i></button>
                </div>
                <div class="pull-right">
                  <span class="undo">1-50/200</span>
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
					$query = "SELECT * FROM message m JOIN user u on m.UserIDFrom = u.UserID JOIN messagestatus ms on m.MessageStatusID = ms.MessageStatusID where m.UserIDTo = $currentUserId AND ms.MessageStatus = 'Deleted' ORDER BY m.MessageDate DESC";
					$rows = $db->query($query);
					
					if($rows->rowCount() > 0){
						$numberOfMessages = $rows->rowCount();
						foreach($rows as $row){
				
				  ?>
                  <tr id="<?=$row['MessageID']?>">
                    <td><div class="icheckbox_flat-blue" aria-checked="false" aria-disabled="false" style="position: relative;"><input type="checkbox" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins></div></td>
                    <td class="mailbox-name notranslate">From: <?=$row['FirstName']?> <?=$row['LastName']?></td>
                    <td class="mailbox-subject notranslate"><b><?=$row['Subject']?></b></td>
                    <td class="mailbox-attachment"></td>
                    <td class="mailbox-date"><?=$row['MessageDate']?></td>
                  </tr>
                  <?php
					}
					}else{
						//Do something if the user has no messages
						?>
						<tr class="no-deleted">
							<td class="mailbox-subject undo">You did not delete any message yet.</td>
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
              <div style="margin-bottom: 10px;" class="mailbox-controls">
                <!-- Check all button -->
                <button type="button" class="btn btn-default btn-sm checkbox-toggle invisible"><i class="fa fa-square-o"></i>
                </button>
                <div class="btn-group">
                  <button type="button" class="btn btn-default btn-sm invisible"><i class="fa fa-trash-o"></i></button>
                </div>
                <!-- /.btn-group -->
                <button type="button" class="btn btn-default btn-sm invisible"><i class="fa fa-refresh"></i></button>
                <div class="pull-right">
                  <span class="undo">1-50/200</span>
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
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
			<!-- /.col -->
		  </div>
		</div>
      <!-- /.row -->
    </div>
	<?php include 'footer.php'; ?>
</body>
</html>