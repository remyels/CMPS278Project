<div class="modal fade" tabindex="-1" id="loginModal" data-keyboard="false" data-backdrop="static">
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
						<div class="form-group">
							<label for="inputEmailAddress">Email address:</label>
							<input class="form-control" placeholder="Email address "
									type="text" id="inputEmailAddress" name="inputEmailAddress" />
						</div>
						<div class="form-group">
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

<div class="modal fade" tabindex="-1" id="signUpModal" data-keyboard="false" data-backdrop="static">
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
							<label for="inputSignUpEmailAddress">Email address:</label>
							<input class="form-control" placeholder="Email address "
									type="text" id="inputSignUpEmailAddress" name="inputSignUpEmailAddress" />
						</div>
						<div class="form-group">
							<label for="inputSignUpPassword">Password:</label>
							<input class="form-control" placeholder="Password"
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