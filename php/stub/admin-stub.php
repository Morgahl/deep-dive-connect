<?php

require_once("php/class/security.php");

//create array to catch security objects
$security[] = Security::getSecurityObjects($mysqli);

$total = count($security[0]);

echo $security[0][2]->getSecurityId();

echo"<h3>Admin Page</h3>
		<p>Select which one you want to change permissions</p>
		<form id=\"securityDropDown\" action=\"php/form-processor/admin-processor.php\" method=\"POST\">
			<select id=\"securityOption\" name=\"securityOption\">";

for($i = 0; $i <$total; $i++){
	echo "<option value=\"" . $security[0][$i]->getSecurityId() . "\">" .
		$security[0][$i]->getDescription() . "</option>";
}

echo "	</select>
	<button id=\"securitySubmit\" type=\"submit\" name=\"submit\">Submit</button>
</form>
<p id=\"cohortEditOutput\"></p>";