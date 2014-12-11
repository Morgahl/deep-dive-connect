<?php

//calls the databases
require_once("/etc/apache2/capstone-mysql/ddconnect.php");
require_once("php/class/cohort.php");

//gets MySqli information
$mysqli = MysqliConfiguration::getMysqli();
$cohorts = Cohort::getCohorts($mysqli);

//Output to user
echo "<div class=\"row\">";
echo "";
foreach($cohorts as $index => $element) {
   echo "<div class=\"col-xs-4\">";
	echo "<a href=\"cohort.php?cohort=" . $element->getCohortId() . "\"><p>" . $element->getDescription() . "<br>";
	echo "" . $element->getStartDate()->format("M Y") . " - " . $element->getEndDate()->format("M Y") . "<br>";
	echo $element->getLocation() . "</p></a></div>";
}
echo "</div>";