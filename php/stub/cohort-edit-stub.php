<?php

/**
 * Created in collaboration by:
 *
 * Gerardo Medrano GMedranoCode@gmail.com
 * Marc Hayes <Marc.Hayes.Tech@gmail.com>
 * Steven Chavez <schavez256@yahoo.com>
 * Joseph Bottone hi@oofolio.com
 *
 * Form processor for cohort-edit-stub.php
 *
 * Acquires
 */
require_once("/etc/apache2/capstone-mysql/ddconnect.php");
require_once("php/class/cohort.php");
require_once("php/class/profileCohort.php");
require_once("php/lib/csrf.php");

if(empty($_SESSION["profile"]["profileId"]) === true) {
	header("Location: index.php");
}

$mysqli = MysqliConfiguration::getMysqli();

$profileId = isset($_SESSION["profile"]["profileId"]) ? $_SESSION["profile"]["profileId"] : false;
$canPromote = isset($_SESSION["security"]["canPromote"]) ? $_SESSION["security"]["canPromote"] : false;

$cohorts[] = Cohort::getCohorts($mysqli);


echo "<div class=\"col-xs-12\">";
echo "<h3>Cohort Association</h3>";

//obtain cohorts associated with profile
$proCohort = Cohort::getCohortsByProfileId($mysqli, $profileId);

if(empty($proCohort) === false){
	foreach($proCohort as $i => $firstDem){
		echo "<strong>". $i . ":</strong><br>";
		echo "<div class=\"row\">";
		foreach($firstDem as $j => $secondDem){
			echo "<section class=\"col-sm-4 col-xs-6\">";
			echo "<a href=\"cohort.php?cohort=" . $secondDem["cohort"]->getCohortId() . "\"><p><strong>" . $secondDem["cohort"]->getDescription() . "</strong><br>";
			echo "" . $secondDem["cohort"]->getStartDate()->format("M Y") . " - " . $secondDem["cohort"]->getEndDate()->format("M Y") . "<br>";
			echo $secondDem["cohort"]->getLocation() . "</p></a>";
			echo "</section>";
		}
		echo "</div>";
	}
}
else{
	echo "<section><div class=\"alert alert-info\" role=\"alert\"><p>You are not associated with any cohorts.</p></div></section>";
}

echo "</div>";

// drop down of Cohorts
$total = count($cohorts[0]);

echo "<row class=\"row\">
		<section class=\"col-md-6 col-xs-12\">
		<h3>Cohort Edit</h3>
		<form id=\"cohortEditForm\" action=\"php/form-processor/cohort-edit-processor.php\" method=\"POST\">";

echo generateInputTags();

//radio buttons

echo "<label for=\"cohortEditOptions\">options</label><br>
		<input type=\"radio\" name=\"cohortEditOptions\" value=\"add\" checked>Add
		<input type=\"radio\" name=\"cohortEditOptions\" value=\"delete\">Delete<br><br>";

echo "<label for=\"cohortOption\">Cohort:</label>
   	<select class=\"form-control\" id=\"cohortOption\" name=\"cohortOption\">";

for($i = 0; $i < $total; $i++) {
	$startDate = $cohorts[0][$i]->getStartDate();
	$endDate = $cohorts[0][$i]->getEndDate();

	echo "<option value=\"" . $cohorts[0][$i]->getCohortId() . "\">";
	echo $startDate->format("M Y") . " - " . $endDate->format("M Y") . ": " . $cohorts[0][$i]->getDescription();
	echo "</option>";
}

echo "	</select><br>
		<label for=\"cohortRole\">Role:</label>
		<select class=\"form-control\" id=\"cohortRole\" name=\"cohortRole\">
			<option value=\"Student\">Student</option>";
if ($canPromote === 1) {
echo "<option value=\"Instructor\">Instructor</option>";
echo "<option value=\"Admin\">Admin</option>";
}

echo "	</select><br>
	<button id=\"cohortSubmit\" class=\"btn btn-primary btn-md\" type=\"submit\" name=\"submit\">Submit</button>
</form>
<p id=\"cohortEditOutput\"></p>
</section>
</row";
