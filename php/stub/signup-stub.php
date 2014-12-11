<?php

/**
* Signup HTML form
*
* Author Joseph Bottone  bottone.joseph@gmail.com
*/
require_once("php/lib/csrf.php");


echo "		<head>
		<title>SignUp Form</title>
	</head>
<body>
<h4>SignUp Form</h4>
<div id=\"outputArea\"></div>
<form id=\"signUp\" action=\"php/form-processor/signup-form-processor.php\" method=\"POST\">
		<?php echo generateInputTags();?>
		<label for=\"email\">Email</label>
		<br>
		<input type=\"email\" id=\"email\" name=\"email\" autocomplete=\"off\">
		<br>
		<label for=\"firstName\">First Name:</label>
		<br>
		<input type=\"firstName\" id=\"firstName\" name=\"firstName\" autocomplete=\"off\">
		<br>
		<label for=\"lastName\">Last Name:</label>
		<br>
		<input type=\"lastName\" id=\"lastName\" name=\"lastName\" autocomplete=\"off\">
		<br>
		<label for=\"password\">Password:</label>
		<br>
		<input type=\"password\" id=\"password\" name=\"password\" autocomplete=\"off\">
		<br>
		<label for=\"confPassword\">Confirm Password:</label>
		<br>
		<input type=\"password\" id=\"confPassword\" name=\"confPassword\" autocomplete=\"off\">
		<br>";
echo generateInputTags();
echo "<br>
		<input type=\"submit\" value=\"Sign Up\">

	</form>

</body>
</html>";