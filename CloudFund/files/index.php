<!DOCTYPE html>
<html>
<head>
	<link href="static/post.css" type="text/css" rel="stylesheet"/>
    <?php include 'styles.php'; ?>
	<script type="text/javascript" src="static/post.js"></script>
</head>
<body>

	<?php include 'navbar.php'; ?>

	<?php include 'modals.php'; ?>

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
                <li class='active'><a href='#'>Update status</a></li>
                <li><a href='#'>Add photos/Video</a></li>
                <li><a href='#'>Create photo album</a></li>
            </ul>
            <textarea class="form-control" placeholder="What's in your mind?"></textarea>
            <ul class='list-inline post-actions'>
                <li><a href="#"><span class="glyphicon glyphicon-camera"></span></a></li>
                <li><a href="#" class='glyphicon glyphicon-user'></a></li>
                <li><a href="#" class='glyphicon glyphicon-map-marker'></a></li>
                <li class='pull-right'><a href="#" class='btn btn-primary btn-xs'>Post</a></li>
            </ul>
        </form>
            </div>
        </div>
    </div>
	</div>  	
		<?php } ?>
	</div>
</div>
<?php include 'footer.php'; ?>
</body>
</html>