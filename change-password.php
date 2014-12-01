<!DOCTYPE html>
<html>
	<head lang="en">
		<meta charset="UTF-8">
		<title>Change Password</title>
	</head>
	<body>
		<h3>Change Password</h3>
		<form action="/php/form/change-password-form-processor.php" method="post">
			<p>
				<label for="current-password">Current Password:</label><br>
				<input type="text" id="current-password" name="current-password">
			</p>
			<p>
				<label for="new-password">New Password:</label><br>
				<input type="text" id="new-password" name="new-password">
			</p>
			<p>
				<label for="confirm-password">Confirm Password:</label><br>
				<input type="text" id="confirm-password" name="confirm-password">
			</p>
			<button type="submit" name="confirm">Confirm</button>

		</form>

	</body>
</html>