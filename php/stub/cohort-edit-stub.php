<?php
/**
 * Created by PhpStorm.
 * User: Steven
 * Date: 12/8/2014
 * Time: 11:53 AM
 */
require_once("php/class/cohort.php");

//declare variables
//$cohort[] = array();
//$cohortBool = true;
//$id = 1;
//
////catch all the cohort objects in $cohort array
//while($cohortBool){
//if(($cohort[] = Cohort::getCohortByCohortId($mysqli, $id)) !== null){
//		$id++;
//	}
//	else{
//		$cohortBool = false;
//	}
//}
//
////get total number of elements in array
//$total = count($cohort);

$cohorts[] = Cohort::getCohorts($mysqli);

//var_dump($cohorts);
//for($i = 0; $i <6; $i++){
//	echo $cohorts[0][$i]->getStartDate()->format("M Y");
//}
$total = count($cohorts[0]);


echo "<h3>Cohort Edit</h3>
		<form id=\"cohortEditForm\" action=\"php/form-processor/cohort-edit-processor.php\" method=\"POST\">
			<select id=\"cohortOption\" name=\"cohortOption\">";

for($i = 0; $i < 6; $i++) {
	$startDate = $cohorts[0][$i]->getStartDate();
	$endDate = $cohorts[0][$i]->getEndDate();

	echo "<option value=\"" . $cohorts[0][$i]->getCohortId() . "\">";
	echo $startDate->format("M Y") . " - " . $endDate->format("M Y");
	echo "</option>";
}

echo "	</select>
	<button id=\"cohortSubmit\" type=\"submit\" name=\"submit\">Submit</button>
</form>
<p id=\"cohortEditOutput\"></p>";
