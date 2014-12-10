<?php

echo "<aside class=\"col-xs-4\">
		<form name=\"login\" action=\"php/form-processor/login-form-processor.php\" method=\"POST\" accept-charset=\"utf-8\">
        <p>
        		<label for=\"email\">Email</label><br>
        		<input type=\"email\" name=\"email\" placeholder=\"yourname@email.com\" required>
        </p>
        <p>
        		<label for=\"passwordHash\">Password</label><br>
        		<input type=\"passwordHash\" name=\"passwordHash\" placeholder=\"password\" required>
			</p>
			<button id=\"loginBtn\" type=\"submit\" name=\"submit\">Login</button>
		</form>
		</aside>";