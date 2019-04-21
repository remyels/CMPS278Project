<!DOCTYPE html>
<html>
<head>
	<?php include "styles.php"; ?>
	<script type="text/javascript" src="static/account.js"></script>
</head>
<body>
	<?php include "../connect/sessionCheck.php"; ?>
	<?php include "navbar.php"; ?>
	<?php include "modals.php"; ?>
	<div id="content" style="padding-top: 5%">
		<div class="container">
			<h2>Edit your account details, <?= $_SESSION['FirstName'] ?>!</h2>
			<div class="jumbotron">
				<form>
				  <input type="hidden" id="accountID" name="LoggedInUserID" value="<?= $_SESSION['LoggedInUserID'] ?>"/>
				  <div class="form-row">
					<div class="form-group col-md-6">
					  <label for="accountFirst">First Name</label>
					  <input type="text" class="form-control" id="accountFirst" value="<?= $_SESSION['FirstName']?>" readonly>
					</div>
					<div class="form-group col-md-6">
					  <label for="accountLast">Last Name</label>
					  <input type="text" class="form-control" id="accountLast" value="<?= $_SESSION['LastName']?>" readonly>
					</div>
				  </div>
				  <div class="form-group">
					<label for="accountEmail">Email</label>
					<input type="text" class="form-control" id="accountEmail" value="<?= $_SESSION['UserRow']['Email']?>" placeholder="Email address">
				  </div>
				  <div class="form-group">
					<label for="accountPersonalInformation">Personal Information</label>
					<input type="text" class="form-control" id="accountPersonalInformation" value="<?= $_SESSION['UserRow']['PersonalInfo']?>" placeholder="Personal information">
				  </div>
				  <div class="form-group">
					<label for="accountProfessionalInformation">Professional Information</label>
					<input type="text" class="form-control" id="accountProfessionalInformation" value="<?= $_SESSION['UserRow']['ProfessionalInfo']?>" placeholder="Professional information">
				  </div>
				  <div class="form-group">
					<label for="accountPassword">Password</label>
					<input type="password" class="form-control" id="accountPassword" placeholder="Password (should contain a capital letter, a symbol, a number and be of length 8+)">
				  </div>
				  <div class="form-group">
					<label for="accountConfirmPassword">Confirm Password</label>
					<input type="password" class="form-control" id="accountConfirmPassword" placeholder="Confirm password">
				  </div>
				  <input type="button" id="accountUpdateBtn" class="btn btn-primary" onclick="updateAccount()" value="Update information" disabled>
				</form>	
				<p id="accountSubmitResult" style="visibility: hidden;"></p>
			</div>
		</div>
	</div>
<?php include "footer.php" ?>
</body>
</html>