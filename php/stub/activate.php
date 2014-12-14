<?php
/**
 * Signup HTML form
 *
 * @author Joseph Bottone  <bottone.joseph@gmail.com>
 * @author Marc Hayes <marc.hayes.tehc@gmail.com>
 */

session_start();
require_once("/etc/apache2/capstone-mysql/ddconnect.php");

$authToken = filter_input(INPUT_GET,"authToken",FILTER_SANITIZE_STRING);

	echo "<form id=\"verify\" action=\"php/form-processor/activate-form-processor.php\" method=\"POST\">
		<input id=\"authToken\" type=\"hidden\" name=\"email\" value=\"$authToken\">";
	echo generateInputTags();
	echo "<button type=\"submit\" class=\"btn btn-primary btn-xs\">Click here to verify your email.</button>
	</form>";