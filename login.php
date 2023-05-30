<?php include('include/login-header.php'); ?>

	<!-- Login form -->
	<form class="login-form" action="action/login-verify.php" method="POST" autocomplete="off">
		<div class="card mb-0">
			<div class="card-body">
				<div class="text-center mb-3">
					<img src="images/finallogo.png" width="200" height="200" class="mb-3">
					<span class="d-block font-weight-bolder">E-Learning Management System</span>
				</div>

				<div class="form-group form-group-feedback form-group-feedback-left">
					<input type="text" class="form-control" placeholder="ID number" name="username">
					<div class="form-control-feedback">
						<i class="icon-user text-muted"></i>
					</div>
				</div>

				<div class="form-group form-group-feedback form-group-feedback-left">
					<input type="password" class="form-control" placeholder="Password" name="password">
					<div class="form-control-feedback">
						<i class="icon-lock2 text-muted"></i>
					</div>
				</div>

				<div class="form-group">
					<button type="submit" name="login" class="btn btn-primary btn-block">Login</button>
				</div>

				<div class="text-center d-none">
					<a href="login_password_recover.html">Forgot password?</a>
				</div>
			</div>
		</div>
	</form>
	<!-- /login form -->

<?php include('include/login-footer.php'); ?>