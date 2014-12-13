<?php

echo "<aside class=\"col-sm-3 col-xs-12\">
	<form name=\"login\" action=\"php/form-processor/login-form-processor.php\" method=\"POST\" accept-charset=\"utf-8\">
	<div class=\"col-sm-12 hidden-xs input-group input-group-xs\">
		<h4><strong>Login</strong></h4>
	</div>
	<div class=\"col-sm-12 col-xs-4\">
		<input type=\"email\" class=\"form-control\" name=\"email\" placeholder=\"yourname@email.com\" required>
	</div>
	<div class=\"col-sm-12 col-xs-4\">
		<input type=\"password\" class=\"form-control\" name=\"password\" placeholder=\"password\" required>
	</div>
	<div class=\"col-sm-12 col-xs-4\">
		<button id=\"loginBtn\" type=\"submit\" class=\"btn btn-primary btn-sm btn-sm\" name=\"submit\">Login</button>
		<button class=\"btn btn-primary btn-sm\" onclick=\"signupForm.php\">Sign-up</a>
	</div>
	</div>
	</form>
</aside>";