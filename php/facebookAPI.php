<!DOCTYPE html>
<html>
	<head lang="en">
		<meta charset="UTF-8">
		<title>Facebook Login</title>
		<script type="text/javascript" src="../javaScript/facebookAPI.js"></script>
	</head>
	<body>

		<!--
		  Below we include the Login Button social plugin. This button uses
		  the JavaScript SDK to present a graphical Login button that triggers
		  the FB.login() function when clicked.
		-->

		<fb:login-button scope="public_profile,email" onlogin="checkLoginState();">
		</fb:login-button>



		<div id="status">
		</div>

		<!-- Facebook like button
		<div
			class="fb-like"
			data-share="true"
			data-width="450"
			data-show-faces="true">
		</div>
		-->

	</body>
</html>`