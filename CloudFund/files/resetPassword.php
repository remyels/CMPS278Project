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
		<?php if (!isset($_REQUEST['email'])||!isset($_REQUEST['hash'])) { ?> 
		<div class="container container-fluid">
			<div class="row">
				<div class="col-lg-12">
					<h3>One or more parameters are missing.</h3>
				</div>
			</div>
		</div>
		<?php } else { ?>
		<script type="text/javascript" src="static/resetPassword.js"></script>  	
		<?php } ?>
	</div>
</div>
<?php include 'footer.php'; ?>
</body>
</html>