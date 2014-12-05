<?php
//path to mysqli class
require_once("/etc/apache2/capstone-mysql/ddconnect.php");

//require the files needed
require_once("../class/user.php");
require_once("../class/profile.php");

//CSRF path
require_once("../lib/csrf.php");

try{
	// connect to mySQL
	$mysqli = MysqliConfiguration::getMysqli();


}
catch (Exception $exception){

}

echo "<!DOCTYPE html>
<html>
	<head lang=\"en\">
		<meta charset=\"UTF-8\">
		<title>Home</title>
		<link type=\"text/css\" href=\"//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css\" rel=\"stylesheet\" />
<script type=\"text/javascript\" src=\"//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js\"></script>
		<script type=\"text/javascript\" src=\"//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js\"></script>
	</head>
	<body>
		<main class=\"container\">
			<nav class=\"row\">";

echo "<div class=\"alert alert-danger\" role=\"alert\"><strong>Nav goes here</strong></div>";

echo
	"</nav>
	<section class=\"row\">
		<aside class=\"col-md-4\">";

//if $_session is set call aside.php
//if not call login
if(isset($_SESSION) === false){
	//TODO: Add login here
}
else{
	require_once("aside.php");
}

echo	"</aside>
		<article id=\"content\" class=\"col-md-8 col-xs-12\">";