<?php
/**
 * Form to edit security roles
 *
 * Allows admin to edit, delete or add new security roles
 *
 * @author Steven Chavez <schavez256@yahoo.com>
 * @see Profile
 */

// require files necessary
require_once("/etc/apache2/capstone-mysql/ddconnect.php");
require_once("php/class/security.php");
require_once("php/lib/csrf.php");

// verify that only siteAdmin can use this page
$admin = isset($_SESSION["security"]["siteAdmin"]) ? $_SESSION["security"]["siteAdmin"] : false;

// relocates user to index if not logged in or not a siteAdmin
if(empty($_SESSION["profile"]["profileId"]) === true || $admin !== 1) {
	header("Location: index.php");
}

$mysqli = MysqliConfiguration::getMysqli();

//create array to catch security objects
$security[] = Security::getSecurityObjects($mysqli);

//acquire total of array
$total = count($security[0]);


//shows dynamic table of Security Objects
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

//generate a row for each security object
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

// Form that allows Admin to edit, update or delete security objects
echo"<h3>Select Security Description</h3>
		<script src=\"js/admin.js\"></script>
		<p>Select title to change permissions or create add a new one </p>
		<form id=\"securityDropDown\" action=\"php/form-processor/admin-processor.php\" method=\"POST\">";

// generate csrf token
generateInputTags();

// creates drop down with dynamic content of security description
echo	"<select id=\"securityOption\" name=\"securityOption\" >";
for($i = 0; $i <$total; $i++){
	echo "<option value=\"" . $security[0][$i]->getSecurityId() . "\">" .
		$security[0][$i]->getDescription() . "</option>";
}

// options for creating and deleting security objects
echo "	<option value=\"new\">*Create*</option>
			<option value=\"delete\">*Delete*</option>
			</select>";

// place holder to add inputs for delete or create with jQuery
echo		"<p id=\"newOutput\"></p>";

// manipulate the values of security objects
echo		"<h3>Change Values</h3>
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

