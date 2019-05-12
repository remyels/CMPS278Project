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
		
		textarea:focus {   
			border-color: rgba(229, 103, 23, 0.8);
			box-shadow: 0 1px 1px rgba(229, 103, 23, 0.075) inset, 0 0 8px rgba(229, 103, 23, 0.6);
			outline: 0 none;
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
							 
							<?php } else if ($row['accepted']==0 && ($row['UserIDFrom'] == $_SESSION['LoggedInUserID'])) { ?>
							
							<button id="addFriendBtn" class="btn btn-success btn-block" type="button" disabled>
								<i class="fa fa-check"></i> <span id="addFriendBtnText"> Request sent</span>
							 </button>
							
							<?php } else if ($row['accepted']==0 && ($row['UserIDTo'] == $_SESSION['LoggedInUserID'])) { ?>
							<a href="queries/acceptRequests.php?UserID=<?= $_GET['UserID'] ?>&source=profile">
							 <button style="white-space:normal !important; word-wrap: break-word; word-break: normal;" class="btn btn-primary btn-block" type="button">
								<i class="fa fa-check-square-o" aria-hidden="true"></i> Accept incoming friend request
							 </button>
							 </a>
							<?php } else { ?> 
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
									<a href="#posts" data-toggle="tab" style="background: #e3e3e3;">Posts</a>
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
								<div class="tab-pane fade" id="posts">
													 <div class="row clearfix">
					
						
					<?php
						$uservisited = $db->quote($_GET['UserID']);
						// if friends with user
						$rows;
						if ($row['accepted']==1) {
							$query = "SELECT *, pt.Type AS PostType FROM post p JOIN posttype pt ON p.Type = pt.PostTypeID JOIN user u ON p.UserID = u.UserID JOIN levelofaccess loa ON p.LevelOfAccess = loa.LevelOfAccessID WHERE p.userid = $uservisited AND loa.LevelOfAccess<>'Private' ORDER BY DateTimeOfPost DESC;";
							$rows = $db->query($query);
						}
						else {
							$query = "SELECT *, pt.Type AS PostType FROM post p JOIN posttype pt ON p.Type = pt.PostTypeID JOIN user u ON p.UserID = u.UserID JOIN levelofaccess loa ON p.LevelOfAccess = loa.LevelOfAccessID WHERE p.userid = $uservisited AND loa.LevelOfAccess='Public' ORDER BY DateTimeOfPost DESC;";
							$rows = $db->query($query);
						}
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
							?>
							<div class="col-md-12 column">
							<div class="container-fluid">
							<?php
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
							
						<?php
						
						$postid= $row['PostID'];
						
						$query = "SELECT * FROM comment JOIN user ON CommentPosterID = UserID WHERE PostID = $postid;"; 
						
						$comments = $db->query($query);
						
						foreach($comments as $comment) { ?>
						
							<div class="well">
                                <div class="media">
										<?php if ($comment['ProfilePicture']!="") { ?>
										<p class="text-left"><img width="30px" height="30px" src="<?=$comment['ProfilePicture']?>" alt="Profile picture"> <?=$comment['FirstName']?> <?=$comment['LastName']?></p>
										<?php } else { ?>
										<p class="text-left"><img width="30px" height="30px" src="static/images/emptyuser.jpg" alt="Profile picture"> <?=$comment['FirstName']?> <?=$comment['LastName']?></p>
										<?php } ?>
										<div class="media-body">
										  <p class="undo"> <?=$comment['Content']?> </p>
											<ul class="text-left list-inline list-unstyled">
												<?php 
												
												// Need to get number of likes and dislikes on this particular comment as well as whether it's liked or not
												
												$commentid = $comment['CommentID'];
												
												$likes = $db->prepare("SELECT COUNT(*) count FROM reactcomment WHERE CommentID = $commentid AND IsLike = 1;");
												$likes->execute();
												$num_likes = $likes->fetch();
												$num_likes = $num_likes['count'];
												
												$dislikes = $db->prepare("SELECT COUNT(*) count FROM reactcomment WHERE CommentID = $commentid AND IsLike = 0;");
												$dislikes->execute();
												$num_dislikes = $dislikes->fetch();
												$num_dislikes = $num_dislikes['count'];
												
												
												$userreaction = $db->prepare("SELECT * FROM reactcomment WHERE ReacterID = $currentuserid AND CommentID = $commentid;");
												$userreaction->execute();
												$reactionfound = $userreaction->rowCount();
												
												if ($reactionfound==0) { ?>
												<li><a id="commentanchorlike<?=$comment['CommentID']?>"><i class="fa fa-thumbs-up"></i> Like (<span id="commentnumlikes<?=$comment['CommentID']?>"><?=$num_likes?></span>)</a></li>
												<li>|</li>
												<li><a id="commentanchordislike<?=$comment['CommentID']?>"><i class="fa fa-thumbs-down"></i> Dislike (<span id="commentnumdislikes<?=$comment['CommentID']?>"><?=$num_dislikes?></span>)</a></li>
												<?php } else {
													$reaction = $userreaction->fetch();
													
													if ($reaction['IsLike']==1) { ?>
													<li><a class="clicked" id="commentanchorlike<?=$comment['CommentID']?>"><i class="fa fa-thumbs-up"></i> Like (<span id="commentnumlikes<?=$comment['CommentID']?>"><?=$num_likes?></span>)</a></li>
													<li>|</li>
													<li><a id="commentanchordislike<?=$comment['CommentID']?>"><i class="fa fa-thumbs-down"></i> Dislike (<span id="commentnumdislikes<?=$comment['CommentID']?>"><?=$num_dislikes?></span>)</a></li>										
													<?php } else { ?>
													<li><a id="commentanchorlike<?=$comment['CommentID']?>"><i class="fa fa-thumbs-up"></i> Like (<span id="commentnumlikes<?=$comment['CommentID']?>"><?=$num_likes?></span>)</a></li>
													<li>|</li>
													<li><a class="clicked" id="commentanchordislike<?=$comment['CommentID']?>"><i class="fa fa-thumbs-down"></i> Dislike (<span id="commentnumdislikes<?=$comment['CommentID']?>"><?=$num_dislikes?></span>)</a></li>
												<?php }}	?>
												<li class="pull-right">Posted on: <?=$comment['CommentDate']?></li>													
											</ul>
										</div>
									</div> 
								</div>
								<?php } ?>
								<div id="comment-area<?=$postid?>" class="well">
									<div class="media">
										<p class="text-left"><strong>Add a comment</strong></p>
										<div class="media-body">
										    <textarea id="comment-content<?=$postid?>" class="form-control"></textarea>
											<ul class="text-left list-inline list-unstyled">
												<li class="pull-right"><button id="commentBtn<?=$postid?>" style="margin: 10px;" class="btn btn-default" disabled><i class="fa fa-comment"></i> Comment</button></li>
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