<div class="modal fade" tabindex="-1" id="loginModal">
		<div class="modal-dialog modal-md">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">
						&times;
					</button>
					<h4 class="modal-title">Do you already have an account? Sign in here!</h4>
				</div>
				<div class="modal-body">
					<form method="" action="#">
						<div id="login-email-form-group" class="form-group">
							<label for="inputEmailAddress">Email address:</label>
							<input class="form-control" placeholder="Email address "
									type="text" id="inputEmailAddress" name="inputEmailAddress" />
						</div>
						<div id="login-password-form-group" class="form-group">
							<label for="inputPassword">Password:</label>
							<input class="form-control" placeholder="Password"
									type="password" id="inputPassword" name="inputPassword" />
						</div>
					</form>
				</div>
				<p id="loginResult" style="text-align: center; opacity: 0; user-select: none;">PLACEHOLDER</p>
				<div class="modal-footer">
					<a href="#" id="forgotPassword" class="pull-left">Forgot your password? Click here!</a>
					<a type="submit" id="loginBtn" class="btn btn-success">Login</a>
				</div>
			</div>

      </div>
</div>

<div class="modal fade" tabindex="-1" id="signUpModal">
		<div class="modal-dialog modal-md">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">
						&times;
					</button>
					<h4 class="modal-title">New to CloudFund? Sign up below!</h4>
				</div>
				<div class="modal-body">
					<form method="" action="#">
						<div class="form-group">
							<label for="inputSignUpFirstName">First name:</label>
							<input class="form-control" placeholder="First name "
									type="text" id="inputSignUpFirstName" name="inputSignUpFirstName" />
						</div>
						<div class="form-group">
							<label for="inputSignUpLastName">Last name:</label>
							<input class="form-control" placeholder="Last name "
									type="text" id="inputSignUpLastName" name="inputSignUpLastName" />
						</div>
						<div class="form-group">
							<label for="inputSignUpGender">Gender:</label>
							<div id="inputSignUpGender">
								<label class="radio-inline">
								  <input type="radio" name="gender" value="Male" checked>Male
								</label>
								<label class="radio-inline">
								  <input type="radio" name="gender" value="Female">Female
								</label>
								<label class="radio-inline">
								  <input type="radio" name="gender" value="Other">Other
								</label>
							</div>
						</div>
						<div class="form-group">
							<label for="inputSignUpEmailAddress">Email address:</label>
							<input class="form-control" placeholder="Email address "
									type="text" id="inputSignUpEmailAddress" name="inputSignUpEmailAddress" />
						</div>
						<div class="form-group">
							<label for="inputSignUpPassword">Password:</label>
							<input class="form-control" placeholder="Password (should contain a capital letter, a symbol, a number and be of length 8+)"
									type="password" id="inputSignUpPassword" name="inputSignUpPassword" />
						</div>
                        <div class="form-group">
							<label for="inputSignUpRepeatPassword">Confirm password:</label>
							<input class="form-control" placeholder="Confirm your password"
									type="password" id="inputSignUpRepeatPassword" name="inputSignUpRepeatPassword" />
						</div>
					</form>
				</div>
				<p id="signUpResult" style="text-align: center; opacity: 0; user-select: none;">PLACEHOLDER</p>
				<div class="modal-footer">
					<button type="submit" id="signUpBtn" class="btn btn-info">Sign up!</button>
				</div>
			</div>
      </div>
</div>

<div class="modal fade" tabindex="-1" id="passwordResetModal">
		<div class="modal-dialog modal-md">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">
						&times;
					</button>
					<h4 class="modal-title">Reset your password</h4>
				</div>
				<div class="modal-body">
					<form method="" action="#">
						<div class="form-group">
							<?php if (isset($_REQUEST['email'])) { ?>
							<input type="hidden" id="resetEmail" value="<?=$_REQUEST['email']?>"/>
							<?php } ?>
							<?php if (isset($_REQUEST['hash'])) { ?>
							<input type="hidden" id="resetHash" value="<?=$_REQUEST['hash']?>"/>
							<?php } ?>
							<label for="resetPassword">Password:</label>
							<input class="form-control" placeholder="Password (should contain a capital letter, a symbol, a number and be of length 8+)"
									type="password" id="resetPassword" name="resetPassword" />
						</div>
                        <div class="form-group">
							<label for="resetPasswordConfirm">Confirm password:</label>
							<input class="form-control" placeholder="Confirm your password"
									type="password" id="resetPasswordConfirm" name="resetPasswordConfirm" />
						</div>
					</form>
				</div>
				<p id="resetPasswordResult" style="text-align: center; opacity: 0; user-select: none;">PLACEHOLDER</p>
				<div class="modal-footer">
					<button type="submit" id="resetPasswordBtn" class="btn btn-info">Reset password</button>
				</div>
			</div>
      </div>
</div>