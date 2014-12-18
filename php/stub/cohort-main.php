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
   echo "<div class=\"col-sm-4 col-xs-6\">";
	echo "<a href=\"cohort.php?cohort=" . $element->getCohortId() . "\"><p><strong>" . $element->getDescription() . "</strong><br>";
	echo "" . $element->getStartDate()->format("M Y") . " - " . $element->getEndDate()->format("M Y") . "<br>";
	echo $element->getLocation() . "</p></a></div>";
}
echo "</div>";