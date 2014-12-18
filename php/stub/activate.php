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

require_once("/etc/apache2/capstone-mysql/ddconnect.php");
require_once("php/lib/csrf.php");

$authToken = filter_input(INPUT_GET,"authToken",FILTER_SANITIZE_STRING);

echo "<form id=\"verify\" action=\"php/form-processor/activate-form-processor.php\" method=\"POST\">
		<input type=\"hidden\" name=\"authToken\" value=\"$authToken\">";
echo generateInputTags();
echo "<button type=\"submit\" class=\"btn btn-primary btn-xs\">Click here to verify your email.</button>
	</form>";