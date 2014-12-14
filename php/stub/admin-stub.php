<?php

require_once("php/class/security.php");
require_once("php/lib/csrf.php");

//create array to catch security objects
$security[] = Security::getSecurityObjects($mysqli);

$total = count($security[0]);

$inputTag = generateInputTags();

//create table of Security Objects
echo "<table>
			<tr>
				<td>Id</td>
				<td>Description</td>
				<td>isDefault</td>
				<td>createTopic</td>
				<td>canEditOther</td>
				<td>canPromote</td>
				<td>siteAdmin</td>
			</tr>";

for($i = 0; $i < $total; $i++){
	echo"<tr>
			<td>".$security[0][$i]->getSecurityId()."</td>
			<td>".$security[0][$i]->getDescription()."</td>
			<td>".$security[0][$i]->getIsDefault()."</td>
			<td>".$security[0][$i]->getCreateTopic()."</td>
			<td>".$security[0][$i]->getCanEditOther()."</td>
			<td>".$security[0][$i]->getCanPromote()."</td>
			<td>".$security[0][$i]->getSiteAdmin()."</td>
			</tr>";
}

echo "</table>";

echo"<h3>Select Security Description</h3>
		<script src=\"js/admin.js\"></script>
		<p>Select title to change permissions or create add a new one </p>
		<form id=\"securityDropDown\" action=\"php/form-processor/admin-processor.php\" method=\"POST\">".$inputTag."
			<select id=\"securityOption\" name=\"securityOption\" >";

for($i = 0; $i <$total; $i++){
	echo "<option value=\"" . $security[0][$i]->getSecurityId() . "\">" .
		$security[0][$i]->getDescription() . "</option>";
}

echo "	<option value=\"new\">*Create*</option>
			<option value=\"delete\">*Delete*</option>
			</select>
			<p id=\"newOutput\"></p>
			<h3>Change Values</h3>
			<p>Default:</p>
				<select id=\"isDefault\" name=\"isDefault\">
					<option value=\"0\">No</option>
					<option value=\"1\">Yes</option>
				</select>
			<p>Create Topic:</p>
				<select id=\"createTopic\" name=\"createTopic\">
					<option value=\"0\">No</option>
					<option value=\"1\">Yes</option>
				</select>
			<p>Can Edit Other:</p>
				<select id=\"canEditOther\" name=\"canEditOther\">
					<option value=\"0\">No</option>
					<option value=\"1\">Yes</option>
				</select>
			<p>Can Promote:</p>
				<select id=\"canPromote\" name=\"canPromote\">
					<option value=\"0\">No</option>
					<option value=\"1\">Yes</option>
				</select>
			<p>Site Admin:</p>
				<select id=\"siteAdmin\" name=\"siteAdmin\">
					<option value=\"0\">No</option>
					<option value=\"1\">Yes</option>
				</select><br><br>
	<button id=\"securitySelect\" class=\"btn btn-primary btn-xs\" type=\"Submit\">Select</button>
</form>
<p id=\"adminOutput\"></p>
";

