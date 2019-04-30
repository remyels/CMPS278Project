<!DOCTYPE html>
<html>
<head>
    <?php include 'styles.php'; ?>
	<style>
		blockquote .small:before, blockquote footer:before, blockquote small:before {
			content: "";
		}
		
		#content p, small {
			text-align: left;
		}
		
		hr {
			border-top: 1px solid #050505;
		}
	</style>
	<script src="static/profile.js"></script>
</head>
<body>

	<?php include 'navbar.php'; ?>

	<?php include 'modals.php'; ?>

<div id="content">
	<?php if (!isset($_GET['UserID'])) { ?>
	<div class="container container-fluid">
		<div class="row">
			<div class="col-lg-12">
				<h3>Invalid request! Missing parameter: UserID</h3>
			</div>
		</div>
	</div>
	<?php } else { 
		include "../connect/connectPDO.php";
	
		$userid = $db->quote($_GET['UserID']);
		$query = $db->prepare("SELECT * FROM user WHERE UserID = $userid;");
		$query->execute();
		if ($query->rowCount()==0) { ?>
			<div class="container container-fluid">
				<div class="row">
					<div class="col-lg-12">
						<h3>No user matching the given UserID found!</h3>
					</div>
				</div>
			</div>
		<?php } else { 
			$profile = $query->fetch();
			if (strcmp($profile['UserID'], $_SESSION['LoggedInUserID'])==0) { ?>
			<div class="container container-fluid">
				<div class="row">
					<div class="col-lg-12">
						<h3>You cannot access your own profile!</h3>
					</div>
				</div>
			</div>
			
			<?php } else { ?>
			<div class="container">
				<input id="ProfileID" type="hidden" value="<?=isset($_GET['UserID'])?>"/>
				<div class="row clearfix well">
					<div class="col-md-2 column">
						<img class="img-thumbnail" alt="140x140" src="http://lorempixel.com/140/140/" />
					</div>
					<div class="col-md-8 column">
						<blockquote>
							<p>
								<?= $profile['FirstName'] ?> <?= $profile['LastName'] ?>
							</p> <small><?= $profile['Gender'] ?></small>
						</blockquote>
					</div>
					<div class="col-md-2 column">
							<?php 
							
							$currentuserid = $db->quote($_SESSION['LoggedInUserID']);
							$profileid = $db->quote($_GET['UserID']);
							
							$query = $db->prepare("SELECT *, COUNT(*) count FROM isfriendof WHERE (UserIDFrom = $currentuserid AND UserIDTo = $profileid) OR (UserIDFrom = $profileid AND UserIDTo = $currentuserid);");
							$query->execute();
							
							$row = $query->fetch();
							
							if ($row['count']==0) { ?>
							
							<button id="addFriendBtn" class="btn btn-default btn-block" type="button">
								<span id="addFriendBtnText">Add friend</span>
							 </button>
							 
							<?php } else if ($row['accepted']==0) { ?>
							
							<button id="addFriendBtn" class="btn btn-success btn-block" type="button" disabled>
								<i class="fa fa-check"></i> <span id="addFriendBtnText"> Request sent</span>
							 </button>
							
							<?php } ?> 
							 <button class="btn btn-default btn-block" type="button">
								Message
							 </button>
							 
					 
					</div>
				</div>
				<div class="row clearfix">
					<div class="col-md-12 column">
						<div class="tabbable" id="tabs-444468">
							<ul class="nav nav-tabs">
								<li class="active">
									<a href="#panel-200304" data-toggle="tab" style="background: #e3e3e3;">About</a>
								</li>
								<li>
									<a href="#panel-567649" data-toggle="tab" style="background: #e3e3e3;">Posts</a>
								</li>
							</ul>
							<div style="border-bottom-left-radius: 25px; border-bottom-right-radius: 25px; background: #e3e3e3; padding: 10px;" class="tab-content">
								<div class="tab-pane fade in active" id="panel-200304">
									 <div class="row clearfix">
										<div class="col-md-12 column">
											<p>
												<strong>Personal information</strong><br/>
												<?php if ($profile['PersonalInfo']) { ?> <?= $profile['PersonalInfo'] ?> <?php } else { ?> None specified <?php } ?>
											</p>
											<hr/>
											<p>
												<strong>Professional information</strong><br/>
												<?php if ($profile['ProfessionalInfo']) { ?> <?= $profile['ProfessionalInfo'] ?> <?php } else { ?> None specified <?php } ?> 
											</p>
										</div>
									</div>
								</div>
								<div class="tab-pane fade" id="panel-567649">
													 <div class="row clearfix">
					<div class="col-md-2 column"></div>
					<div class="col-md-8 column">
						<img alt="140x140" src="http://lorempixel.com/140/140/" /><img alt="140x140" src="http://lorempixel.com/140/140/" /><img alt="140x140" src="http://lorempixel.com/140/140/" /><img alt="140x140" src="http://lorempixel.com/140/140/" />
					</div>
					<div class="col-md-2 column"></div>
				</div>
								</div>
							</div>
						</div>
						
					</div>
				</div>
			</div>
		
	<?php }}} ?>
</div>
<?php include 'footer.php'; ?>
</body>
</html>