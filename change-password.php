<!DOCTYPE html>
<html>
	<head lang="en">
		<meta charset="UTF-8">
		<title>Change Password</title>
		<link type="text/css" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" />
		<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
		<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery.form/3.51/jquery.form.min.js"></script>
		<script type="text/javascript" src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.12.0/jquery.validate.min.js"></script>
		<script type="text/javascript" src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.12.0/additional-methods.min.js"></script>
		<script type="text/javascript" src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>

		<script type="text/javascript" src="js/change-password.js"></script>
	</head>
	<body>
		<main class="container">
			<h3>Change Password</h3>
			<form id="changePasswordForm" action="/php/form-processor/change-password-form-processor.php" method="post">
				<p>
					<label for="currentPassword">Current Password:</label><br>
					<input type="text" id="currentPassword" name="currentPassword">
				</p>
				<p>
					<label for="newPassword">New Password:</label><br>
					<input type="text" id="newPassword" name="newPassword">
				</p>
				<p>
					<label for="confirmPassword">Confirm Password:</label><br>
					<input type="text" id="confirmPassword" name="confirmPassword">
				</p>
				<button type="submit" name="confirm">Confirm</button>

			</form>
			<p id="outputArea"></p>

		</main>
	</body>
</html>