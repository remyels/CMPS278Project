<!DOCTYPE html>
<html>
<head>
	<?php  include 'styles.php'; ?>
	<link href="static/post.css" type="text/css" rel="stylesheet"/>
</head>
<body>

	<?php include 'navbar.php'; ?>
	<?php include 'modals.php'; ?>
	<?php include "../connect/connectPDO.php"; ?>


<div class="container-fluid">
	<div class="col-md-offset-3 col-md-6 col-xs-12" id="posts">
							<div class="col-md-12 column">
								<div class="container-fluid">
								<div class="well">
									<div class="media">
										<p class="text-left"><img width="30px" height="30px" src="static/images/emptyuser.jpg" alt="No profile picture set">Feeder kbeer</p>
										<div class="media-body">
										  <p class="undo"> This is testing for the post with a video</p>
											<ul class="text-left list-inline list-unstyled">
												<li><a id="anchorlike"><i class="fa fa-thumbs-up"></i> Like (0)</a></li>
												<li>|</li>
												<li><a id="anchordislike"><i class="fa fa-thumbs-down"></i> Dislike (0)</a></li>
												<li>|</li>
												<li><a id="anchorcomment"><i class="fa fa-comments"></i> Comment (0)</a></li>
												<li class="pull-right">Posted on: Medre amteen</li>
											</ul>
										</div>
									</div>
								</div>

								<div class="well">
									<div class="media">
										<p class="text-left"><img width="30px" height="30px" src="http://placekitten.com/30/30" alt="Cute cat"> Feeder d3eef</p>
										<div class="media-body">
											<a style="margin-right: 10px; pointer-events: none; cursor: default;" class="pull-left">
											<img class="media-object" style="margin-bottom: 10px;" src="http://placekitten.com/150/150">
											</a>
											<p>This is supposed to serve as a caption for the picture that you can find on the left</p>
											<ul style="clear: left;" class="undo list-inline list-unstyled">
												<li><a id="anchorlike"><i class="fa fa-thumbs-up"></i> Like (0)</a></li>
												<li>|</li>
												<li><a id="anchordislike"><i class="fa fa-thumbs-down"></i> Dislike (0)</a></li>
												<li>|</li>
												<li><a id="anchorcomment"><i class="fa fa-comments"></i> Comment (0)</a></li>
												<li class="pull-right">Posted on: Medre amteen</li>
											</ul>
									   </div>
									</div>
								  </div>
								  
								  <div class="well">
									<div class="media">
										<p class="text-left"><img width="30px" height="30px" src="http://placekitten.com/30/30" alt="Cute cat"> Feeder d3eef</p>
										<div class="media-body">
											<video class="media-object" style="margin-bottom: 10px; margin-right: 10px; float: left;" width="320" height="240" controls>
											  <source src="videoplayback.mp4" type="video/mp4">
											  Your browser does not support the video tag.
											</video>
											<p>This is supposed to serve as a caption for the picture that you can find on the left</p>
											<ul style="clear: left;" class="undo list-inline list-unstyled">
												<li><a id="anchorlike"><i class="fa fa-thumbs-up"></i> Like (0)</a></li>
												<li>|</li>
												<li><a id="anchordislike"><i class="fa fa-thumbs-down"></i> Dislike (0)</a></li>
												<li>|</li>
												<li><a id="anchorcomment"><i class="fa fa-comments"></i> Comment (0)</a></li>
												<li class="pull-right">Posted on: Medre amteen</li>
											</ul>
									   </div>
									</div>
								  </div>
								  
								  

							</div>
						</div>
						
						</div>
					</div>
<?php include 'footer.php'; ?>	
</body>
</html>