<!DOCTYPE html>
<html>
<head>
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
		
		.media-body a, .media-body a:hover {
			color: inherit;
			text-decoration: inherit;
			cursor: pointer;
		}
		
		.clicked {
			color: darkred !important;
		}
		
		#upload-image, #upload-video {
			cursor: pointer;
		}
		
	</style>
	<?php  include 'styles.php'; ?>
	<script src="static/profile.js"></script>
	<link href="static/post.css" type="text/css" rel="stylesheet"/>
	<script type="text/javascript" src="static/post.js"></script>
</head>
<body>

	<?php include 'navbar.php'; ?>
	<?php include 'modals.php'; ?>
	<?php include "../connect/connectPDO.php"; ?>

<div id="content">
	<div class="container">
		<?php if (!isset($_SESSION['LoggedInUserID'])) { ?> 
		<div class="row">
			<div class="col-lg-12">
				<h1>CloudFund</h1>
				<h3>Bring your startup ideas to life</h3>
				<hr>
				<!--<button class="btn btn-info btn-lg">Get Started</button>-->
			</div>
		</div>
		<?php } else { ?>
		<div class="container-fluid bootstrap snippet">
		<div class="row">
        <div class="col-md-offset-3 col-md-6 col-xs-12">
            <div class="well well-sm well-social-post">
        <form>
            <ul class="list-inline" id='list_PostActions'>
				<div id="post-result"></div>
				<li class='active'>
					<a>Update status</a>
				</li>
				<img id="post-thumbnail" style="display: none;"/>
            </ul>
            <textarea id="status-content" class="form-control" placeholder="What's on your mind?"></textarea>
			<!--
			<div id="panel-2" class="form-control">
				<span class="control-fileupload">
					<label for="pic" class="text-left">Please choose a file on your computer.</label>
					<input type="file" name="file" id="pic">
				</span>
			</div>
			-->
            <ul class='list-inline post-actions'>
				<li class="pull-left">
					<span id="upload-image"><i onclick="uploadMedia()" style="color: black;" class="fa fa-image"></i><input type="file" name="file" id="image" style="display: none;" /></span>
					|
					<span id="upload-video"><i onclick="uploadMedia()" style="color: black;" class="fa fa-film"></i><input type="file" name="file" id="video" style="display: none;" /></span>
				</li>
				<label>Post Privacy:</label>
				<li><label><input type="radio" name="privacy" value="1" checked="checked"> Public</label></li>
				<li><label><input type="radio" name="privacy" value="2"> Friends Only</label></li>
				<li><label><input type="radio" name="privacy" value="3"> Private</label></li>
                <li class='pull-right'><input id="postStatus" type="button" value="Post" class='disabled btn btn-primary btn-xs'/></li>
            </ul>
        </form>
            </div>
        </div>
    </div>
	</div>  	
	</div>
</div>
	<div class="container-fluid">
					<div class="col-md-offset-3 col-md-6 col-xs-12" id="posts">
					<?php
						$userid = $_SESSION['LoggedInUserID'];
						$query = "(SELECT *, posttype.type AS PostType FROM post, posttype, user WHERE post.UserID = user.UserID AND post.Type = posttype.PostTypeID AND post.UserID IN (SELECT isfriendof.UserIDFrom FROM isfriendof WHERE isfriendof.accepted = 1 AND isfriendof.UserIDTo = $userid UNION SELECT isfriendof.UserIDTo FROM isfriendof WHERE isfriendof.accepted = 1 AND isfriendof.UserIDFrom = $userid UNION SELECT $userid) ORDER BY DateTimeOfPost DESC);";
						$rows = $db->query($query);
						foreach($rows as $row){
							$posterid = $row['UserID'];
							$postid = $row['PostID'];
							$loaid = $row['LevelOfAccess'];
							$query = $db->query("SELECT * FROM reactpost WHERE PostID = $postid;");
							$privacy = $db->prepare("SELECT * FROM levelofaccess WHERE LevelOfAccessID = $loaid;");
							$privacy->execute();
							$loa = $privacy->fetch();
							$loa = $loa['LevelOfAccess'];
							if (($posterid == $userid) || (($posterid != $userid)&&($loa!='Private'))) {
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
										<?php if ($row['ProfilePicture']=="") { ?> 
										<p class="text-left"><img width="30px" height="30px" src="static/images/emptyuser.jpg" alt="No profile picture set"> <?=$row['FirstName'] . " " . $row['LastName']?></p>
										<?php } else { ?>
										<p class="text-left"><img width="30px" height="30px" src="<?=$row['ProfilePicture']?>" alt="Profile picture"> <?=$row['FirstName'] . " " . $row['LastName']?></p>
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
							} // done checking for privacy
						} // done with the posts ?>	
						</div>
					</div>
<?php 
	}
include 'footer.php'; ?>	
</body>
</html>