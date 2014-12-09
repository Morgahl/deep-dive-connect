<?php

echo "<form name=\"login\" action=\"index_submit\" method=\"get\" accept-charset=\"utf-8\">
        <p>
        		<label for=\"email\">Email</label><br>
        		<input type=\"email\" name=\"email\" placeholder=\"yourname@email.com\" required>
        </p>
        <p>
        		<label for=\"passwordHash\">Password</label><br>
        		<input type=\"passwordHash\" name=\"passwordHash\" placeholder=\"password\" required>
			</p>
			<button id=\"loginBtn\" type=\"submit\" name=\"submit\">Login</button>
		</form>";