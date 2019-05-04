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
	<link href="static/post.css" type="text/css" rel="stylesheet"/>
    <?php include 'styles.php'; ?>
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
		<div class="container bootstrap snippet">
		<div class="row">
        <div class="col-md-offset-3 col-md-6 col-xs-12">
            <div class="well well-sm well-social-post">
        <form>
            <ul class="list-inline" id='list_PostActions'>
				<div id="post-result"></div>
                <li class='active'><a href='#'>Update status</a></li>
                <li><a href='#'>Add photo/video</a></li>
				<img id="post-thumbnail" style="display: none;"/>
            </ul>
            <textarea class="form-control" placeholder="What's on your mind?"></textarea>
            <ul class='list-inline post-actions'>
                <li><a href="#"><span class="glyphicon glyphicon-camera"></span></a></li>
                <li><a href="#" class='glyphicon glyphicon-user'></a></li>
                <li><a href="#" class='glyphicon glyphicon-map-marker'></a></li>
				<label>Post Privacy:</label>
				<li><input type="radio" name="privacy" value="1"> Public</li>
				<li><input type="radio" name="privacy" value="2"> Friends Only</li>
				<li><input type="radio" name="privacy" value="3"> Private</li>
                <li class='pull-right'><a id="postStatus" href="#" class='btn btn-primary btn-xs'>Post</a></li>
            </ul>
        </form>
            </div>
        </div>
    </div>
	</div>  	
	</div>
</div>
	<div class="container-fluid">
					<div class="col-md-offset-3 col-md-6 col-xs-12">
					<?php
						$userid = $db->quote($_SESSION['LoggedInUserID']);
						$query = "SELECT *, posttype.type AS PostType FROM post, posttype, user WHERE post.UserID = user.UserID AND post.Type = posttype.PostTypeID AND post.UserID IN (SELECT isfriendof.UserIDFROM FROM isfriendof WHERE isfriendof.accepted = 1 AND isfriendof.UserIDTo = $userid) ORDER BY DateTimeOfPost DESC";
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
													$query = $db->prepare("SELECT * FROM reactpost WHERE ReacterID = $userid AND PostID = $postid;");
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
												
												<li><a id="anchorcomment<?=$row['PostID']?>"><i class="fa fa-comments"></i> Comment (<span id="numcomments<?=$row['PostID']?>"><?=$numcomments?></span>)</a></li>
												<li class="pull-right">Posted on: <?=$row['DateTimeOfPost']?></li>
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
											<ul class="undo list-inline list-unstyled">
											<?php 
													// need to check whether it is already liked or disliked or neither
													$query = $db->prepare("SELECT * FROM reactpost WHERE ReacterID = $userid AND PostID = $postid;");
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
<?php 
	}
include 'footer.php'; ?>	
</body>
</html>