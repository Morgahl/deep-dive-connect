<?php session_start()
?>
<!DOCTYPE html>
<html>
	<head lang="en">
		<meta charset="UTF-8">
		<title>Create New Topic</title>
		<link type="text/css" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" />
		<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
		<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery.form/3.51/jquery.form.min.js"></script>
		<script type="text/javascript" src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.12.0/jquery.validate.min.js"></script>
		<script type="text/javascript" src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.12.0/additional-methods.min.js"></script>
		<script type="text/javascript" src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="js/topic-new-edit.js"></script>
	</head>
	<body>
		<div class="container">
			<div class="row">
				<form id="topic" method="post" action="php/form-processor/topic-new-edit.php">
					<label for="subject">Subject: </label><br />
					<textarea id="subject" name="subject" class="form-control" rows="2" maxlength="256"></textarea><br />
					<label for="body">Body: </label><br />
					<textarea id="body" name="body" class="form-control" rows="10" maxlength="4096"></textarea><br />
					<button type="submit">Create</button>
				</form>
			</div>
		</div>
	</body>
</html>