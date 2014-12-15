<?php
/**
 Associationby PhpStorm.
 * User: Steven
 * Date: 12/8/2014
 * Time: 11:53 AM
 */
require_once("php/class/cohort.php");
require_once("php/class/profileCohort.php");

if(empty($_SESSION["profile"]["profileId"]) === true) {
	header("Location: index.php");
}

$profileId = isset($_SESSION["profile"]["profileId"]) ? $_SESSION["profile"]["profileId"] : false;

$cohorts[] = Cohort::getCohorts($mysqli);


echo "<row class=\"row\">";
echo "<section class=\"col-md-12\">
			<h3>Cohort Association</h3>
		</section>";

//obtain cohorts associated with profile
$proCohort = Cohort::getCohortsByProfileId($mysqli, $profileId);

if(empty($proCohort) === false){
	foreach($proCohort as $i => $firstDem){
		foreach($firstDem as $j => $secondDem){
			echo "<section class=\"col-md-3\">";
			echo "<strong>". $i . "</strong><br>";
			echo $secondDem["cohort"]->getDescription(). "<br>";
			echo $secondDem["cohort"]->getStartDate()->format("M Y") . " - " . $secondDem["cohort"]->getEndDate()->format("M Y")."<br>";
			echo $secondDem["cohort"]->getLocation(). "<br>";
			echo "</section>";
		}
		echo "</row>";
	}
}
else{
	echo "<section><div class=\"alert alert-info\" role=\"alert\"><p>You are not associated with any cohorts.</p></div></section>";
}



// drop down of Cohorts
$total = count($cohorts[0]);

echo "<row class=\"row\">
		<section class=\"col-md-6 col-xs-12\">
		<h3>Cohort Edit</h3>
		<form id=\"cohortEditForm\" action=\"php/form-processor/cohort-edit-processor.php\" method=\"POST\">";

//radio buttons

echo "<label for=\"cohortEditOptions\">options</label><br>
		<input type=\"radio\" name=\"cohortEditOptions\" value=\"add\" checked>Add
		<input type=\"radio\" name=\"cohortEditOptions\" value=\"delete\">Delete<br><br>";

echo "<label for=\"cohortOption\">Cohorts</label>
   	<select class=\"form-control\" id=\"cohortOption\" name=\"cohortOption\">";

for($i = 0; $i < $total; $i++) {
	$startDate = $cohorts[0][$i]->getStartDate();
	$endDate = $cohorts[0][$i]->getEndDate();

	echo "<option value=\"" . $cohorts[0][$i]->getCohortId() . "\">";
	echo $startDate->format("M Y") . " - " . $endDate->format("M Y");
	echo "</option>";
}

echo "	</select><br>
	<button id=\"cohortSubmit\" class=\"btn btn-primary btn-md\" type=\"submit\" name=\"submit\">Submit</button>
</form>
<p id=\"cohortEditOutput\"></p>
</section>
</row";
