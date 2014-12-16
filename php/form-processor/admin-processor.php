<?php
/**
 * Form processor for admin-stub.php
 *
 * Acquires values from form and updates, deletes, or inserts values
 * depending on Admin input and if csrf if valid and if successfully filtered
 * entered into the database
 *
 * @author Steven Chavez <schavez256@yahoo.com>
 */
session_start();

// path to mysqli class
require_once("/etc/apache2/capstone-mysql/ddconnect.php");

// require files needed
require_once("../lib/csrf.php");
require_once("../lib/status-message.php");
require_once("../class/security.php");

try{
	// verify csrf tokens are set
	$csrfName = isset($_POST["csrfName"]) ? $_POST["csrfName"] : false;
	$csrfToken = isset($_POST["csrfToken"]) ? $_POST["csrfToken"] : false;

	// verify CSRF tokens
	if(verifyCsrf($csrfName, $csrfToken) === false){
		throw (new RuntimeException("External call made."));
	}

	// connect to mysqli
	$mysqli = MysqliConfiguration::getMysqli();

	var_dump($_POST);

	//acquire option values from form and see if they are set
	$securityId = filter_input(INPUT_POST,"securityOption",FILTER_SANITIZE_STRING);
	$isDefault = filter_input(INPUT_POST,"isDefault",FILTER_VALIDATE_INT);
	$createTopic = filter_input(INPUT_POST,"createTopic",FILTER_VALIDATE_INT);
	$canEditOther = filter_input(INPUT_POST,"canEditOther",FILTER_VALIDATE_INT);
	$canPromote = filter_input(INPUT_POST,"canPromote",FILTER_VALIDATE_INT);
	$siteAdmin = filter_input(INPUT_POST,"siteAdmin",FILTER_VALIDATE_INT);
	$newPermission = filter_input(INPUT_POST,"newPermission",FILTER_SANITIZE_STRING);
	$deletePermission = filter_input(INPUT_POST,"deletePermission",FILTER_VALIDATE_INT);

	// process depending on $securityId
	if($securityId === "new"){
		// creates new security object with new name and values
		$security = new Security(null, $newPermission, $isDefault, $createTopic, $canEditOther, $canPromote, $siteAdmin);

		// inserts new security object into database and redirects
		$security->insert($mysqli);
		setStatusMessage("admin","success",$newPermission . " created!");
		header("Location: ../../admin.php");
	}
	elseif($securityId === "delete"){
		$array = Security::getSecurityObjects($mysqli);
		$idExist = false;



		foreach($array as $i =>$element){
			if($array[$i]->getSecurityId() === $deletePermission){
				$idExist = true;
			}
		}

		if($idExist === true){
			// gets object by id
			$security = Security::getSecurityBySecurityId($mysqli, $deletePermission);

			// deletes object from the database and redirects
			$security->delete($mysqli);
			setStatusMessage("admin", "success", " security option deleted!");
			header("Location: ../../admin.php");
		}
		else{
			setStatusMessage("admin", "fail", " id does not exist!");
			header("Location: ../../admin.php");
		}



	}
	else{
		// acquire security object by Id associated with description
		$security = Security::getSecurityBySecurityId($mysqli, $securityId);
		$securityDesc = $security->getDescription();

		// Sets values inputted by Admin
		$security->setIsDefault($isDefault);
		$security->setCreateTopic($createTopic);
		$security->setCanEditOther($canEditOther);
		$security->setCanPromote($canPromote);
		$security->setSiteAdmin($siteAdmin);

		// updates security object and redirects
		$security->update($mysqli);
		setStatusMessage("admin", "success", $securityDesc . " values updated!");
		header("Location: ../../admin.php");
	}
}
catch (Exception $exception){
	$_SESSION[$csrfName] = $csrfToken;
	echo "<div class=\"alert alert-danger\" role=\"alert\">Unable to change permissions: " . $exception->getMessage() . "</div>";
}