<?php
/**
 * Created in collaboration by:
 *
 * @author Gerardo Medrano <GMedranoCode@gmail.com>
 * @author Marc Hayes <Marc.Hayes.Tech@gmail.com>
 * @author Steven Chavez <schavez256@yahoo.com>
 * @author Joseph Bottone <hi@oofolio.com>
 *
 */

require_once("php/lib/csrf.php");


echo "<script type=\"text/javascript\" src=\"js/signup.js\"></script>
<h4>SignUp Form</h4>
<form id=\"signUp\" action=\"php/form-processor/signup-form-processor.php\" method=\"POST\">
		<label for=\"email\">Email</label><br>
		<input type=\"email\" id=\"email\" name=\"email\" autocomplete=\"off\"><br>
		<label for=\"firstName\">First Name:</label><br>
		<input type=\"firstName\" id=\"firstName\" name=\"firstName\" autocomplete=\"off\"><br>
		<label for=\"lastName\">Last Name:</label><br>
		<input type=\"lastName\" id=\"lastName\" name=\"lastName\" autocomplete=\"off\"><br>
		<label for=\"password\">Password:</label><br>
		<input type=\"password\" id=\"password\" name=\"password\" autocomplete=\"off\"><br>
		<label for=\"confPassword\">Confirm Password:</label><br>
		<input type=\"password\" id=\"confPassword\" name=\"confPassword\" autocomplete=\"off\"><br>";
echo generateInputTags();
echo "<br>
		<input type=\"submit\" value=\"Sign Up\">
	</form>";