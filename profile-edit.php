<!DOCTYPE html>
<html>
	<head lang="en">
		<meta charset="UTF-8">
		<title>Edit Profile</title>
	</head>
	<body>
		<form action="/php/form/profile-edit-form-processor.php" method="post">
			<!-- upload photo -->
			<p>
				<h3>Change Profile Picture</h3>
				<form action="/php/form/do-upload.php" enctype="multipart/form-data" method="post">
				<input type="hidden" name="MAX_FILE_SIZE" value="1048576">
				<label for="file-upload">photo location:</label>
				<input type="file" id="img-upload" name="img-upload"><br>
				<button type="submit" name="submit" value="send">Change Image</button>
				</form>
			</p>
			<!-- Change profile information -->
			<h3>Change Profile Information</h3>
			<p>
				<label for="firstName">First Name:</label><br>
				<input type="text" id="firstName" name="firstName">
			</p>
			<p>
				<label for="middleName">Middle Name:</label><br>
				<input type="text" id="middleName" name="middleName">
			</p>
			<p>
				<label for="lastName">Last Name:</label><br>
				<input type="text" id="lastName" name="lastName">
			</p>
			<p>
				<label for="location">Location:</label><br>
				<input type="text" id="location" name="location">
			</p>
			<p>
				<label for="description">Description:</label><br>
				<input type="text" id="description" name="description">
			</p>
			<button type="submit" name="submit">Submit</button>
		</form>

		<!-- Account Settings -->
		<h3>Account Settings</h3>
		<p><a href="change-password.php">change password</a></p>

	</body>
</html>