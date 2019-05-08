<!DOCTYPE html>
<html>
<head>
	<?php include "styles.php"; ?>
	<link rel="stylesheet" type="text/css" href="static/account.css"/>
	<script type="text/javascript" src="static/account.js"></script>
	
	<style>
	
	#content .btn-default, .modal .btn-default
 
	{
	 
		background-color: #68889E;
		 
		color:#FFF;
		 
		border-color: #2F3E48;
	 
	}
	 
	#content .btn-default:hover, #content .btn-default:focus, #content .btn-default:active, #content .btn-default.active, #content .open .dropdown-toggle.btn-default,
	.modal .btn-default:hover, .modal .btn-default:focus, .modal .btn-default:active, .modal .btn-default.active, .modal .open .dropdown-toggle.btn-default {
	 
		 
		background-color: #2F3E48;
		 
		color:#FFF;
		 
		border-color: #31347B;
	 
	}
	
	</style>
</head>
<body>
	<?php include "../connect/sessionCheck.php"; ?>
	<?php include "navbar.php"; ?>
	<?php include "modals.php"; ?>
	<div id="content" style="padding-top: 5%">
		<div class="container">
			<h2>Edit your account details, <?= $_SESSION['FirstName'] ?>!</h2>
			<div class="jumbotron">
				<!--<div id="profile-picture-container">
				<img id="profile-picture" src="static/images/emptyuser.jpg" class="img-thumbnail"/>
				<input type="file" id="upload" value="Upload picture">
				</div>-->
				<div class="box">
          <!-- fileuploader view component -->
          <form action="#" method="post" class="text-center">
			<input id="userid" type="hidden" value="<?= $_SESSION['LoggedInUserID'] ?>" />
            <div class="margin-bottom-20"> 
			
			  <?php include "../connect/connectPDO.php";
				include "../connect/updateSession.php";
				
			  $id = $_SESSION['LoggedInUserID'];
			  
			  $query = $db->prepare("SELECT * FROM user WHERE UserID = $id;");
			  
			  $query->execute();
			  
			  $row = $query->fetch();
			  
			  updateSession($row);
			  
			  if (!$_SESSION['UserRow']['ProfilePicture']) { ?>
              <img id="profile-picture" width="100" height="100" class="thumbnail box-center margin-top-20" alt="No image" src="static/images/emptyuser.jpg">
			  <?php } else { ?>
			  <img id="profile-picture" width="100" height="100" class="haspic thumbnail box-center margin-top-20" alt="No image" src="<?= $_SESSION['UserRow']['ProfilePicture'] ?>">
			  <?php } ?>
            </div>
            <p>
              <button id="deleteProfileBtn" type="button" class="btn btn-sm" name="delete"><i class="icon-remove"></i> Remove</button>
            </p>
          </form>
          <!-- ./fileuploader view component -->
          <div class="row">
            <div class="col-sm-10">
              <span class="control-fileupload">
                <label for="pic" class="text-left">Please choose a file on your computer.</label>
                <input type="file" name="file" id="pic">
              </span>
            </div>
            <div class="col-sm-2">  
              <button id="uploadProfileBtn" type="button" class="btn btn-primary btn-block">
                <i class="icon-upload icon-white"></i> Upload
              </button>
            </div>
          </div>
        </div>
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
					<label for="accountPassword">Enter your password to continue</label>
					<input type="password" class="form-control" id="accountPassword" placeholder="Password">
				  </div>
				  <button style="margin-right: 10px;" type="button" id="deactivateAccount"  data-target="#deactivateAccountModal" data-toggle="modal" class="pull-left btn btn-danger"><i class="fa fa-times"></i> Deactivate account</button>
				  <input type="button" id="deleteAccount" data-target="#deleteAccountModal" data-toggle="modal" class="pull-left btn btn-default" value="Delete account"/>
				  <input type="button" id="accountUpdateBtn" class="pull-right btn btn-primary" onclick="updateAccount()" value="Update information" disabled/>
				</form>	
				<p id="accountSubmitResult" style="visibility: hidden;"></p>
			</div>
		</div>
	</div>
	
	<div class="modal fade" tabindex="-1" id="deactivateAccountModal">
		<div class="modal-dialog modal-md">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">
						&times;
					</button>
					<h4 class="modal-title">Deactivate your account</h4>
				</div>
				<div class="modal-body">
					<p>Are you sure you want to deactivate your account?</p>
				</div>
				<div class="modal-footer">
					<a href="queries/deactivateAccount.php" role="button" type="submit" id="deactivateAccountBtn" class="btn btn-danger"><i class="fa fa-times"></i> Deactivate account</a>
				</div>
			</div>
		</div>
	</div>
	
	<div class="modal fade" tabindex="-1" id="deleteAccountModal">
		<div class="modal-dialog modal-md">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">
						&times;
					</button>
					<h4 class="modal-title">Delete your account</h4>
				</div>
				<div class="modal-body">
					<p>Are you sure you want to delete your account? This action cannot be undone!</p>
				</div>
				<div class="modal-footer">
					<a href="queries/deleteAccount.php" role="button" id="deleteAccountBtn" class="btn btn-default">Delete account</a>
				</div>
			</div>
		</div>
	</div>
	
	
<?php include "footer.php" ?>
</body>
</html>