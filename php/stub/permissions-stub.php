<?php
/**
 * Created in collaboration by:
 *
 * Gerardo Medrano <GMedranoCode@gmail.com>
 * Marc Hayes <Marc.Hayes.Tech@gmail.com>
 * Steven Chavez <schavez256@yahoo.com>
 * Joseph Bottone <hi@oofolio.com>
 *
 */
require_once("/etc/apache2/capstone-mysql/ddconnect.php");
require_once("php/lib/csrf.php");
require_once("php/lib/status-message.php");
require_once("php/class/profile.php");
require_once("php/class/user.php");
require_once("php/class/security.php");

// verify that only siteAdmin can use this page
$admin = isset($_SESSION["security"]["siteAdmin"]) ? $_SESSION["security"]["siteAdmin"] : false;

// relocates user to index if not logged in or not a siteAdmin
if(empty($_SESSION["profile"]["profileId"]) === true || $admin !== 1) {
	header("Location: index.php");
}

$mysqli = MysqliConfiguration::getMysqli();

//get profileId from url
$profileId = filter_input(INPUT_GET,"profile", FILTER_VALIDATE_INT);

// create objects needed
$profile = Profile::getProfileByProfileId($mysqli, $profileId);
$user = User::getUserByUserId($mysqli, $profile->getUserId());
$security = Security::getSecurityBySecurityId($mysqli, $user->getSecurityId());

//get variables needed from object
$fileName = $profile->getProfilePicFileName();

echo"<div class=\"row\">
		<section class=\"col-md-4 col-xs-12\">
			<h3>Profile Under Scrutiny</h3>";

//profile pic
if ($fileName !== false) {
	echo "<img id=\"profilePic\" class=\"img-responsive\" src=\"/ddconnect/avatars/" .
		$fileName . "\" /><br>";
} else {
	echo "<img id=\"profilePic\" class=\"img-responsive\" src=\"resources/avatar-default.png\" /><br>";
}

echo "<p><strong>". $profile->getFirstName(). " " . $profile->getLastName(). "</strong></p>
		<p>". $profile->getLocation()."</p><br>";

echo "<h4>Current Permission</h4>";
echo "<p><em>". $security->getDescription() ."</em></p>
			</section>";

echo "<section class=\"col-md-6 col-md-offset-1 col-xs-12\">
			<h3>Edit Permissions</h3>";

//create array to catch security objects
$securityOpt[] = Security::getSecurityObjects($mysqli);

//acquire total of array
$total = count($securityOpt[0]);


//shows dynamic table of Security Objects
echo "<table>
			<tr class=\"trHeader\">
				<td>Id</td>
				<td>Description</td>
			</tr>";

//generate a row for each security object
for($i = 0; $i < $total; $i++){
	echo"<tr>
			<td>".$securityOpt[0][$i]->getSecurityId()."</td>
			<td>".$securityOpt[0][$i]->getDescription()."</td>
			</tr>";
}
echo "</table>";

echo"<h3>Select Security Description</h3>
		<script src=\"js/admin.js\"></script>
		<p>Select title to change permissions </p>
		<form id=\"permissionsDropDown\" action=\"php/form-processor/permissions-processor.php\" method=\"POST\">";
echo generateInputTags();

echo "<input type=\"hidden\" id=\"userId\" name=\"userId\" value=\"".$profile->getUserId()."\">";
echo "<input type=\"hidden\" id=\"profileId\" name=\"profileId\" value=\"".$profileId."\">";

// creates drop down with dynamic content of security description
echo	"<select id=\"securityOption\" name=\"securityOption\" >";
for($i = 0; $i <$total; $i++){
	echo "<option value=\"" . $securityOpt[0][$i]->getSecurityId() . "\">" .
		$securityOpt[0][$i]->getDescription() . "</option>";
}
echo "</select>
		<button id=\"securitySelect\" class=\"btn btn-primary btn-xs\" type=\"Submit\">Change</button>
</form>";

echo getStatusMessage("permissions");
