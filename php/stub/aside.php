<?php
/**
 * Created by PhpStorm.
 * User: Steven
 * Date: 12/4/2014
 * Time: 4:11 PM
 */
try {

	//TODO: check to make sure $_POST variables are set if not throw exception


	//If session is new or session timed out show login if not show profile
	$firstName = isset($_SESSION["firstName"]) ? $_SESSION["firstName"] : false;
	$lastName = isset($_SESSION["lastName"]) ? $_SESSION["lastName"] : false;
	$location = isset($_SESSION["location"]) ? $_SESSION["location"] : false;
	$description = isset($_SESSION["description"]) ? $_SESSION["description"] : false;
	$fileName = isset($_SESSION["profilePicFilename"]) ? $_SESSION["profilePicFilename"] : false;

	//name
	echo "<p><h4><strong>" . $firstName . " " . $lastName . "</strong></h4></p>";

	//profile pic
	if ($fileName !== false) {
		echo "<div class=\"row\"><div class=\"col-md-6\"><img id=\"profilePic\" class=\"img-responsive\" src=\"/ddconnect/avatars/" .
			$fileName . "\" /></div></div><br>";
	} else {
		echo "<div class=\"row\"><div class=\"col-md-6\"><img id=\"profilePic\" class=\"img-responsive\" src=\"resources/avatar-default.png\" /></div></div><br>";
	}

	//Always visible
	echo "<p><a href=\"../../profile-edit.php\">edit-profile</a></p>";

	//location
	echo "<p><strong>Location:</strong></p>";
	if($location === false) {
		echo "<p><a href=\"../../profile-edit.php\">edit-profile</a></p>";
	} else {
		echo "<p>" . $location . "</p>";
	}


	//Description
	echo "<p><strong>Description:</strong></p>";
	if($description === false) {
		echo "<p><a href=\"../../profile-edit.php\">edit-profile</a></p>";
	} else {
		echo "<p>" . $description . "</p>";
	}

	//Cohort
	echo "<p><strong>Cohort:</strong></p>";
	echo "<div class=\"alert alert-warning\" role=\"alert\">Under Construction</div>";
}
catch (Exception $exception){

}