<?php

echo "<form id=\"signup-form-processor.php\" action=\"php/form-processor/signup-form-processor.php\" method=\"post\">
	<!-- submit signup form -->
	<h3>Signup Form</h3>
	<p>
		<label for=\"email\">Email:</label><br>
		<input type=\"text\" id=\"email\" name=\"email\">
	</p>
	<p>
		<label for=\"firstName\">First Name:</label><br>
		<input type=\"text\" id=\"firstName\" name=\"firstName\">
	</p>
	<p>
		<label for=\"lastName\">Last Name:</label><br>
		<input type=\"text\" id=\"lastName\" name=\"lastName\">
	</p>
	<p>
	<button id=\"profileSubmit\" type=\"submit\" name=\"submit\">Submit</button>
</form>

<p id=\"outputProfileEdit"></p>";