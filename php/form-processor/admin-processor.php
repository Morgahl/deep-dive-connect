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
require_once("../class/security.php");

try{
	// verify that csrfName and csrfToken are set
	$csrfName = isset($_POST["csrfName"]) ? $_POST["csrfName"] : false;
	$csrfToken = isset($_POST["csrfToken"]) ? $_POST["csrfToken"] : false;

	// verify CSRF tokens
	if(verifyCsrf($_POST["csrfName"], $_POST["csrfToken"]) === false){
		throw (new RuntimeException("External call made."));
	}

	// connect to mysqli
	$mysqli = MysqliConfiguration::getMysqli();

	//acquire option values from form and see if they are set
	$securityId = isset($_POST["securityOption"]) ? $_POST["securityOption"] : false;
	$isDefault = isset($_POST["isDefault"]) ? $_POST["isDefault"] : false;
	$createTopic = isset($_POST["createTopic"]) ? $_POST["createTopic"]	: false;
	$canEditOther = isset($_POST["canEditOther"]) ? $_POST["canEditOther"] : false;
	$canPromote = isset($_POST["canPromote"]) ? $_POST["canPromote"] : false;
	$siteAdmin = isset($_POST["siteAdmin"]) ? $_POST["siteAdmin"] : false;

	// process depending on $securityId
	if($securityId === "new"){
		// acquires value from jQuery input which is only available if Admin selects *create*
		$newPermission = $_POST["newPermission"];

		// creates new security object with new name and values
		$security = new Security(null, $newPermission, $isDefault, $createTopic, $canEditOther, $canPromote, $siteAdmin);

		// inserts new security object into database and redirects
		$security->insert($mysqli);
		header("Location: ../../admin.php");
	}
	elseif($securityId === "delete"){
		// acquires value from jQuery input which is only available if Admin selects *delete*
		$deletePermission = $_POST["deletePermission"];

		// ensures variable is an int
		$deletePermission = filter_var($deletePermission, FILTER_VALIDATE_INT);
		$deletePermission = intval($deletePermission);

		// gets object by id
		$security = Security::getSecurityBySecurityId($mysqli, $deletePermission);

		// deletes object from the database and redirects
		$security->delete($mysqli);
		header("Location: ../../admin.php");
	}
	else{
		// acquire security object by Id associated with description
		$security = Security::getSecurityBySecurityId($mysqli, $securityId);

		// Sets values inputted by Admin
		$security->setIsDefault($isDefault);
		$security->setCreateTopic($createTopic);
		$security->setCanEditOther($canEditOther);
		$security->setCanPromote($canPromote);
		$security->setSiteAdmin($siteAdmin);

		// updates security object and redirects
		$security->update($mysqli);
		header("Location: ../../admin.php");
	}
}
catch (Exception $exception){
	$_SESSION[$csrfName] = $csrfToken;
	echo "<div class=\"alert alert-danger\" role=\"alert\">Unable to change permissions: " . $exception->getMessage() . "</div>";
}