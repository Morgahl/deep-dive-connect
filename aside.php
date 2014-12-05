<?php
/**
 * Created by PhpStorm.
 * User: Steven
 * Date: 12/4/2014
 * Time: 4:11 PM
 */
try{
	if(isset($_POST[profileId]) === false){
		echo "<button>Login</button>";
	}
	else{
		//name
		echo "<p>" . $firstName . " " . $lastName . "</p>";

		//profile pic
		echo "<img id=\"profilePic\" src=\"/ddconnect/avatars/" .
				$fileName . "\" /><br>";

		//location
		if(isset($description) === false){
			echo "<p><a href=\"\">edit-profile</a></p>";
		}
		else{
			echo "<p>" . $location . "</p>";
		}


		//Description
		echo "<p><strong>Description:</strong></p>";
		if(isset($description) === false){
			echo "<p><a href=\"\">edit-profile</a></p>";
		}
		else{
			echo "<p>" . $description . "</p>";
		}

		//Cohort
		echo "<p><strong>Cohort:</strong></p>";
		echo "<div class=\"alert alert-warning\" role=\"alert\">Under Construction</div>";
}
}
catch (Exception $exception){

}