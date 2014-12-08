<!DOCTYPE html>
<html>
<head lang="en">
	<meta charset="UTF-8">
	<title>signupAndLogin</title>
	<link type="text/css" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" />
	<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery.form/3.51/jquery.form.min.js"></script>
	<script type="text/javascript" src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.12.0/jquery.validate.min.js"></script>
	<script type="text/javascript" src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.12.0/additional-methods.min.js"></script>
	<script type="text/javascript" src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="js/profile-edit.js"></script>
	<script type="text/javascript" src="js/do-upload.js"></script>
</head>
<body>

<form id="signup-and-login-form-processor" action="php/form-processor/signup-form-processor.php" method="post">
	<!-- submit signup form -->
	<h3>submit signup form</h3>
	<p>
		<label for="email">Email:</label><br>
		<input type="text" id="email" name="email">
	</p>
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
	<p>
		<label for="description">Photo:</label><br>
	<form id="imgUploadForm" action="/php/form-processor/do-upload.php" enctype="multipart/form-data" method="post">
		<input type="hidden" name="MAX_FILE_SIZE" value="5000000">
		<label for="file-upload">photo location:</label>
		<p>Max-size: 3 mb</p>
		<input type="file" id="imgUpload" name="imgUpload"><br>
	</p>
	<button id="profileSubmit" type="submit" name="submit">Submit</button>
</form>
<p id="outputProfileEdit"></p>








