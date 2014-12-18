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
require_once("php/class/cohort.php");
require_once("php/lib/status-message.php");

// verify that only siteAdmin can use this page
$admin = isset($_SESSION["security"]["siteAdmin"]) ? $_SESSION["security"]["siteAdmin"] : false;

// relocates user to index if not logged in or not a siteAdmin
if(empty($_SESSION["profile"]["profileId"]) === true || $admin !== 1) {
	header("Location: index.php");
}

// connect to mysqli
$mysqli = MysqliConfiguration::getMysqli();

//generate input tags
$addTag = generateInputTags();
$deleteTag = generateInputTags();

echo "<h3>Cohorts</h3>
		<script src=\"js/adminCohort.js\"></script>";

$cohorts = Cohort::getCohortObjects($mysqli);


//shows dynamic table of Security Objects
echo "<table>
			<tr class=\"trHeader\">
				<td>Description</td>
				<td>Location</td>
				<td>Start Date</td>
				<td>End Date</td>
			</tr>";

//generate a row for each security object
foreach($cohorts as $i => $element){
	echo"<tr>
			<td>".$cohorts[$i]->getDescription()."</td>
			<td>".$cohorts[$i]->getLocation()."</td>
			<td>".$cohorts[$i]->getStartDate()->format("M d, Y")."</td>
			<td>".$cohorts[$i]->getEndDate()->format("M d, Y")."</td>
			</tr>";
}
echo "</table>";

echo "<section class=\"col-md-4\">
		<h3>Select input type</h3>
		<button id=\"addBtn\" class=\"btn btn-primary btn-xs\"type=\"button\">Add</button>
		<button id=\"deleteBtn\" class=\"btn btn-danger btn-xs\"type=\"button\">Delete</button>
		<br><br>
		";

echo getStatusMessage("cohortAdmin");

echo "<form id=\"cohortAdd\" action=\"php/form-processor/adminCohort-processor.php\" method=\"POST\">". $addTag;

echo	"<h3>Add Cohort Form</h3>
			<label for=\"cohortDesc\">Description</label><br>
			<input class=\"form-control\" type=\"text\" id=\"cohortDesc\" name=\"cohortDesc\"><br>
			<label for=\"cohortLoc\">Location</label><br>
			<input class=\"form-control\" type=\"text\" id=\"cohortLoc\" name=\"cohortLoc\"><br>
			<label for=\"startDate\">Start Date</label><br>
			<input class=\"form-control\" type=\"text\" id=\"startDate\" name=\"startDate\"><br>
			<label for=\"endDate\">End Date</label><br>
			<input class=\"form-control\" type=\"text\" id=\"endDate\" name=\"endDate\"><br>
		<button id=\"securitySelect\" class=\"btn btn-primary btn-xs\"type=\"Submit\">Add</button>
		</form>
		";

echo "<form id=\"cohortDelete\" action=\"php/form-processor/adminCohort-processor.php\" method=\"Post\">". $deleteTag .
		"<h3>Delete Cohort Form</h3>";
echo "<select id=\"deleteSelect\" name=\"deleteSelect\">";

foreach($cohorts as $i => $element){
	echo "<option value=\"". $cohorts[$i]->getCohortId() ."\">".
		$cohorts[$i]->getDescription()
		."</option>";
};
echo "
		</select>
		<button id=\"deleteSubmit\" class=\"btn btn-primary btn-xs\"type=\"Submit\">Delete</button>
		</form>
	</section>";

