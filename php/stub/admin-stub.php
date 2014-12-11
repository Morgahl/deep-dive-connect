<?php

require_once("php/class/security.php");

//create array to catch security objects
$security[] = Security::getSecurityObjects($mysqli);

$total = count($security[0]);

echo"<h3>Select Security Description</h3>
		<script src=\"js/admin.js\"></script>
		<p>Select title to change permissions or create add a new one </p>
		<form id=\"securityDropDown\" action=\"php/form-processor/admin-processor.php\" method=\"POST\">
			<select id=\"securityOption\" name=\"securityOption\" >";

for($i = 0; $i <$total; $i++){
	echo "<option value=\"" . $security[0][$i]->getSecurityId() . "\">" .
		$security[0][$i]->getDescription() . "</option>";
}

echo "	<option value=\"new\">*Create*</option>
			</select>
			<p id=\"newOutput\"></p>
			<h3>Change Values</h3>
			<p>Default:</p>
				<select id=\"isDefault\" name=\"isDefault\">
					<option value=\"0\">0</option>
					<option value=\"1\">1</option>
				</select>
			<p>Create Topic:</p>
				<select id=\"createTopic\" name=\"createTopic\">
					<option value=\"0\">0</option>
					<option value=\"1\">1</option>
				</select>
			<p>Can Edit Other:</p>
				<select id=\"canEditOther\" name=\"canEditOther\">
					<option value=\"0\">0</option>
					<option value=\"1\">1</option>
				</select>
			<p>Can Promote:</p>
				<select id=\"canPromote\" name=\"canPromote\">
					<option value=\"0\">0</option>
					<option value=\"1\">1</option>
				</select>
			<p>Site Admin:</p>
				<select id=\"siteAdmin\" name=\"siteAdmin\">
					<option value=\"0\">0</option>
					<option value=\"1\">1</option>
				</select><br>
	<button id=\"securitySelect\" type=\"Submit\">Select</button>
</form>
<p id=\"adminOutput\"></p>";

