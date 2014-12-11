<?php
/**
 * Created by PhpStorm.
 * User: Steven
 * Date: 12/10/2014
 * Time: 9:56 AM
 */
session_start();

//path to mysqli class
require_once("/etc/apache2/capstone-mysql/ddconnect.php");
require_once("../lib/csrf.php");
require_once("../class/security.php");

try{
	$csrfName = isset($_POST["csrfName"]) ? $_POST["csrfName"] : false;
	$csrfToken = isset($_POST["csrfToken"]) ? $_POST["csrfToken"] : false;

// verify CSRF tokens
	if(verifyCsrf($_POST["csrfName"], $_POST["csrfToken"]) === false){
		throw (new RuntimeException("External call made."));
	}

	$mysqli = MysqliConfiguration::getMysqli();

//catch option value form select tab from post
	$securityId = isset($_POST["securityOption"]) ? $_POST["securityOption"] : false;
	$isDefault = isset($_POST["isDefault"]) ? $_POST["isDefault"] : false;
	$createTopic = isset($_POST["createTopic"]) ? $_POST["createTopic"]	: false;
	$canEditOther = isset($_POST["canEditOther"]) ? $_POST["canEditOther"] : false;
	$canPromote = isset($_POST["canPromote"]) ? $_POST["canPromote"] : false;
	$siteAdmin = isset($_POST["siteAdmin"]) ? $_POST["siteAdmin"] : false;

	if($securityId === "new"){
		$newPermission = $_POST["newPermission"];

		$security = new Security(null, $newPermission, $isDefault, $createTopic, $canEditOther, $canPromote, $siteAdmin);

		$security->insert($mysqli);
		header("Location: ../../admin.php");
	}
	elseif($securityId === "delete"){
		$deletePermission = $_POST["deletePermission"];
		$deletePermission = filter_var($deletePermission, FILTER_VALIDATE_INT);
		$deletePermission = intval($deletePermission);
		//var_dump($deletePermission);
		$security = Security::getSecurityBySecurityId($mysqli, $deletePermission);
		$security->delete($mysqli);
		header("Location: ../../admin.php");
	}
	else{
		$security = Security::getSecurityBySecurityId($mysqli, $securityId);

		$security->setIsDefault($isDefault);
		$security->setCreateTopic($createTopic);
		$security->setCanEditOther($canEditOther);
		$security->setCanPromote($canPromote);
		$security->setSiteAdmin($siteAdmin);

		$security->update($mysqli);
		header("Location: ../../admin.php");
	}
}
catch (Exception $exception){
	$_SESSION[$csrfName] = $csrfToken;
	echo "<div class=\"alert alert-danger\" role=\"alert\">Unable to change permissions: " . $exception->getMessage() . "</div>";
}