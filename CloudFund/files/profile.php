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
		
		.undo {
			color: black;
		}
		
		.media-body a {
			color: inherit;
			text-decoration: inherit;
			cursor: pointer;
		}
		
		.clicked {
			color: darkred !important;
		}
		
	</style>
	<script src="static/profile.js"></script>
	<link rel="stylesheet" type="text/css" href="static/comments.css"></script>
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
						<?php if ($profile['ProfilePicture']=="") { ?> 
						<img class="img-thumbnail" height="140px" width="140px" src="static/images/emptyuser.jpg" />
						<?php } else { ?>
						<img class="img-thumbnail" height="140px" width="140px" src="<?=$profile['ProfilePicture']?>"/>
						<?php } ?>
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
							<a href="compose.php?UserID=<?= $_GET['UserID'] ?>">
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
								<li id="comments-tab" class="hidden">
									<a href="#special-panel-123456" data-toggle="tab" style="background: #e3e3e3;">Comments</a>
								</li>
							</ul>
							<div style="border-bottom-left-radius: 25px; border-bottom-right-radius: 25px; background: #e3e3e3; padding: 10px;" class="tab-content">
								<div class="tab-pane fade in active" id="panel-200304">
									 <div class="row clearfix">
										<div class="col-md-12 column">
											<p>
												<strong>Personal information</strong><br/>
												<span class="undo"><?php if ($profile['PersonalInfo']) { ?> <?= $profile['PersonalInfo'] ?> <?php } else { ?> None specified <?php } ?></span>
											</p>
											<hr/>
											<p>
												<strong>Professional information</strong><br/>
												<span class="undo"><?php if ($profile['ProfessionalInfo']) { ?> <?= $profile['ProfessionalInfo'] ?> <?php } else { ?> None specified <?php } ?></span>
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
						$query = "SELECT *, posttype.type AS PostType FROM post, posttype, user WHERE post.userid = $uservisited AND post.userid = user.userid AND posttypeid = post.type ORDER BY DateTimeOfPost DESC;";
						$rows = $db->query($query);
						foreach($rows as $row){
							$postid = $row['PostID'];
							$query = $db->query("SELECT * FROM reactpost WHERE PostID = $postid;");
							$numlikes = 0;
							$numdislikes = 0;
							foreach($query as $res) {
								if ($res['IsLike']==0) {
									$numdislikes = $numdislikes+1;
								}
								else {
									$numlikes = $numlikes+1;
								}
							}
							
							$query = $db->prepare("SELECT COUNT(*) count FROM comment WHERE PostID = $postid;");
							$query->execute();
							$res = $query->fetch();
							
							$numcomments = $res['count'];
							if($row['PostType'] == "Text"){
							?>
								<div class="well">
									<div class="media">
										<?php if ($profile['ProfilePicture']=="") { ?> 
										<p class="text-left"><img width="30px" height="30px" src="static/images/emptyuser.jpg" alt="No profile picture set"> <?=$row['FirstName'] . " " . $row['LastName']?></p>
										<?php } else { ?>
										<p class="text-left"><img width="30px" height="30px" src="<?=$profile['ProfilePicture']?>" alt="Profile picture"> <?=$row['FirstName'] . " " . $row['LastName']?></p>
										<?php } ?>
										<div class="media-body">
										  <p class="undo"> <?= $row['Content'] ?></p>
											<ul class="text-left list-inline list-unstyled">
												<?php 
													// need to check whether it is already liked or disliked or neither
													$query = $db->prepare("SELECT * FROM reactpost WHERE ReacterID = $currentuserid AND PostID = $postid;");
													$query->execute();
													$numrows = $query->rowCount();
													
													// this means the user has never reacted to this post
													if ($numrows == 0) { 
												?>
												<li><a id="anchorlike<?=$row['PostID']?>"><i class="fa fa-thumbs-up"></i> Like (<span id="numlikes<?=$row['PostID']?>"><?=$numlikes?></span>)</a></li>
												<li>|</li>
												<li><a id="anchordislike<?=$row['PostID']?>"><i class="fa fa-thumbs-down"></i> Dislike (<span id="numdislikes<?=$row['PostID']?>"><?=$numdislikes?></span>)</a></li>
												<li>|</li>
												<?php } else {
													$res = $query->fetch();
													
													if ($res['IsLike']==1) { ?>
														<li><a class="clicked" id="anchorlike<?=$row['PostID']?>"><i class="fa fa-thumbs-up"></i> Like (<span id="numlikes<?=$row['PostID']?>"><?=$numlikes?></span>)</a></li>
														<li>|</li>
														<li><a id="anchordislike<?=$row['PostID']?>"><i class="fa fa-thumbs-down"></i> Dislike (<span id="numdislikes<?=$row['PostID']?>"><?=$numdislikes?></span>)</a></li>
														<li>|</li>
													<?php } else { ?>
														<li><a id="anchorlike<?=$row['PostID']?>"><i class="fa fa-thumbs-up"></i> Like (<span id="numlikes<?=$row['PostID']?>"><?=$numlikes?></span>)</a></li>
														<li>|</li>
														<li><a class="clicked" id="anchordislike<?=$row['PostID']?>"><i class="fa fa-thumbs-down"></i> Dislike (<span id="numdislikes<?=$row['PostID']?>"><?=$numdislikes?></span>)</a></li>
														<li>|</li>
												<?php }} ?>
												
												<li><a onclick="collapse(this)" id="anchorcomment<?=$row['PostID']?>"><i class="fa fa-comments"></i> Comment (<span id="numcomments<?=$row['PostID']?>"><?=$numcomments?></span>)</a></li>
												<li class="pull-right">Posted on: <?=$row['DateTimeOfPost']?></li>
											</ul>
										</div>
									</div>
								</div>
							</div>
						</div>
						
						<!-- COMMENTS START HERE -->
						
						<div class="row clearfix">
						
						<div class="col-md-1"></div>
						
						<div class="col-md-10 column">

						<div class="container-fluid">
						
						<div class="collapse" id="commentbox<?=$row['PostID']?>">
							<div class="well">
                                <div class="media">
										<p class="text-left"><img width="30px" height="30px" src="static/images/emptyuser.jpg" alt="No profile picture set"> Random guy</p>
										<div class="media-body">
										  <p class="undo"> This is a hypothetical content times </p>
											<ul class="text-left list-inline list-unstyled">
												<li><a id="anchorlike123"><i class="fa fa-thumbs-up"></i> Like (nobody likes u)</a></li>
												<li>|</li>
												<li><a id="anchordislike123"><i class="fa fa-thumbs-down"></i> Dislike (literally everyone)</a></li>
												<li class="pull-right">Posted on: <?=$row['DateTimeOfPost']?></li>
											</ul>
										</div>
									</div> 
								</div>
								<div class="well">
									<div class="media">
										<p class="text-left"><img width="30px" height="30px" src="static/images/emptyuser.jpg" alt="No profile picture set"> Random guy 2</p>
										<div class="media-body">
										  <p class="undo"> This is a hypothetical content times numero dos </p>
											<ul class="text-left list-inline list-unstyled">
												<li><a id="anchorlike1234"><i class="fa fa-thumbs-up"></i> Like (nobody likes u)</a></li>
												<li>|</li>
												<li><a id="anchordislike1234"><i class="fa fa-thumbs-down"></i> Dislike (literally everyone)</a></li>
												<li class="pull-right">Posted on: <?=$row['DateTimeOfPost']?></li>
											</ul>
										</div>
									</div> 
								</div>
                        </div>
								</div>
								</div>
								</div>
								
						<!-- COMMENTS END HERE -->
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
											<ul class="undo list-inline list-unstyled">
											<?php 
													// need to check whether it is already liked or disliked or neither
													$query = $db->prepare("SELECT * FROM reactpost WHERE ReacterID = $currentuserid AND PostID = $postid;");
													$query->execute();
													$numrows = $query->rowCount();
													
													// this means the user has never reacted to this post
													if ($numrows == 0) { ?>
												<li><a id="anchorlike<?=$row['PostID']?>"><i class="fas fa-thumbs-up"></i> Like (<span id="numlikes<?=$row['PostID']?>"><?=$numlikes?></span>)</a></li>
												<li>|</li>
												<li><a id="anchordislike<?=$row['PostID']?>"><i class="fas fa-thumbs-down"></i> Dislike (<span id="numdislikes<?=$row['PostID']?>"><?=$numdislikes?></span>)</a></li>
												<li>|</li>
													<?php } else {
													$res = $query->fetch();
		
													if ($res['IsLike']==1) { ?>
												<li><a class="clicked" id="anchorlike<?=$row['PostID']?>"><i class="fas fa-thumbs-up"></i> Like (<span id="numlikes<?=$row['PostID']?>"><?=$numlikes?></span>)</a></li>
												<li>|</li>
												<li><a id="anchordislike<?=$row['PostID']?>"><i class="fas fa-thumbs-down"></i> Dislike (<span id="numdislikes<?=$row['PostID']?>"><?=$numdislikes?></span>)</a></li>
												<li>|</li>
													<?php } else { ?>
													<li><a id="anchorlike<?=$row['PostID']?>"><i class="fas fa-thumbs-up"></i> Like (<span id="numlikes<?=$row['PostID']?>"><?=$numlikes?></span>)</a></li>
													<li>|</li>
													<li><a class="clicked" id="anchordislike<?=$row['PostID']?>"><i class="fas fa-thumbs-down"></i> Dislike (<span id="numdislikes<?=$row['PostID']?>"><?=$numdislikes?></span>)</a></li>
													<li>|</li>
													<?php }} ?>
												<li><a id="anchorcomment<?=$row['PostID']?>"><i class="fas fa-comments"></i> Comment (<span id="numcomments<?=$row['PostID']?>"><?=$numcomments?></span>)</a></li>
												<li class="pull-right">Posted on: <?=$row['DateTimeOfPost']?></li>
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
		
	<?php }}} ?>
</div>
<?php include 'footer.php'; ?>
</body>
</html>