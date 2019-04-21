<!DOCTYPE html>
<html>
<head>
    <?php include 'styles.php'; ?>
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
		
		<?php } ?>
	</div>
</div>
<?php include 'footer.php'; ?>
</body>
</html>