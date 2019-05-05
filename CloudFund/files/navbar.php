<!DOCTYPE html>
<html>
	<head>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
		<script src="static/navbar.js"></script>
	</head>
	
	<body>
		<?php session_start(); 
		include "../connect/connectPDO.php"; ?>
		<nav class="navbar navbar-default navbar-fixed-top">
		  <div class="container">
			<!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header">
			  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			  </button>
			  <a class="navbar-brand" href="index.php"><img src="static/images/cloudwhite.jpg" class="img-responsive logo"></img></a>
			</div>

			<!-- Collect the nav links, forms, and other content for toggling -->
			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			  <ul class="nav navbar-nav">
				<li><a href="index.php">Home <span class="sr-only">(current)</span></a></li>
				<?php if (isset($_SESSION['LoggedInUserID'])) { ?> 
					<li><a href="requests.php">Requests</a></li>
					<li><a href="messages.php">Messages</a></li>
				<?php } ?>
				<li><a href="about.php">About</a></li>
				<li><a href="contact.php">Contact us</a></li>
			  </ul>
			  <?php if (isset($_SESSION['LoggedInUserID'])) { ?> 
				<form class="navbar-form navbar-left" autocomplete="off">
					<?php	
						$id = $db->quote($_SESSION['LoggedInUserID']);
						$query = "SELECT UserID, FirstName, LastName FROM user WHERE UserID <> $id;";
						$users = $db->query($query);
						?>
						<div class="form-group">
							<input type="text" autocomplete="off" list="users" data-min-length='1' class="form-control" id="search-bar" placeholder="Search for people...">
								<datalist id="users">
									<?php
									foreach($users as $user){ ?>
										<option value="<?= $user['FirstName'] . ' ' . $user['LastName']?>" data-id="<?=$user['UserID']?>" id="user<?= $user['UserID']?>"><?= $user['FirstName'] . ' ' . $user['LastName']?></option>
									<?php } ?>
								</datalist>
						</div>
						<input type="button" value= "Search" id="searchUser" onclick="search()" class="btn btn-default">
				</form>
			  <?php } ?>
			  <ul class="nav navbar-nav navbar-right">
			  <?php if (isset($_SESSION['LoggedInUserID'])) { ?>
					<li><a href="account.php"><i class="fa fa-cog"></i> Account</a></li>
					<li class="divider"></li>
					<li><a href="./queries/endSession.php"><i class="fa fa-sign-out"></i> Logout</a></li>
			  <?php } else { ?>
				  <li><a id="signUpNav" href="#" data-target="#signUpModal" data-toggle="modal">Sign Up <i class="fa fa-user-plus" aria-hidden="true"></i></a></li>
				  <li><a id="loginUpNav" href="#" data-target="#loginModal" data-toggle="modal">Login <i class="fa fa-user" aria-hidden="true"></i></a></li>
			  <?php } ?>
			  </ul>
			</div><!-- /.navbar-collapse -->
		  </div><!-- /.container-fluid -->
		</nav>
	</body>
</html>