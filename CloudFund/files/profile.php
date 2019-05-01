<!DOCTYPE html>
<html>
<head>
    <?php include 'styles.php'; ?>
	<script
		src="https://code.jquery.com/jquery-3.4.0.min.js"
		integrity="sha256-BJeo0qm959uMBGb65z40ejJYGSgR7REI4+CW1fNKwOg="
		crossorigin="anonymous">
	</script>
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
							
							<?php } else {
							?> 
							<a href="compose.php?UserID=<?= $profileid ?>">
							 <button class="btn btn-default btn-block" type="button">
								Message
							 </button>
							 </a>
							<?php } ?>
					 
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
					
					<div class="col-md-12 column">
						
					

					<div class="container-fluid">
					<?php
						$uservisited = $db->quote($_GET['UserID']);
						$query = "SELECT *, posttype.type AS PostType FROM post, posttype, user WHERE post.userid = $uservisited AND post.userid = user.userid AND posttypeid = post.type;";
						$rows = $db->query($query);
						foreach($rows as $row){
							if($row['PostType'] == "Text"){
							?>
								<div class="well">
									<div class="media">
										<p class="text-left"><img width="30px" height="30px" src="cutefatcat.jpg" alt="Cute fat cat"> <?=$row['FirstName'] . " " . $row['LastName']?></p>
										<div class="media-body">
										  <p> <?= $row['Content'] ?></p>
											<ul class="list-inline list-unstyled">
												<li><span><i class="fas fa-thumbs-up"></i> Like</span></li>
												<li>|</li>
												<li><span><i class="fas fa-thumbs-down"></i> Dislike</span></li>
												<li>|</li>
												<li><span><i class="fas fa-comments"></i> Comment</span></li>
												<li class="pull-right"><?=$row['DateTimeOfPost']?></li>
											</ul>
										</div>
									</div>
								</div>
							<?php
							} else if($row['PostType'] == "Image") { ?>
								<div class="well">
									<div class="media">
										<p class="text-left"><img width="30px" height="30px" src="cutefatcat.jpg" alt="Cute fat cat"> <?=$row['FirstName'] . " " . $row['LastName']?></p>
										<div class="media-body">
											<a style="margin-right: 10px; pointer-events: none; cursor: default;" class="pull-left">
											<img class="media-object" src="http://placekitten.com/150/150">
											</a>
											<p><?= $row['Content'] ?></p>
											<ul class="list-inline list-unstyled">
												<li><span><i class="fas fa-thumbs-up"></i> Like</span></li>
												<li>|</li>
												<li><span><i class="fas fa-thumbs-down"></i> Dislike</span></li>
												<li>|</li>
												<li><span><i class="fas fa-comments"></i> Comment</span></li>
												<li class="pull-right"><?=$row['DateTimeOfPost']?></li>
											</ul>
									   </div>
									</div>
								  </div>
							<?php
							}
							//check 3rd type for video
						} ?>	
						</div>

								</div>
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