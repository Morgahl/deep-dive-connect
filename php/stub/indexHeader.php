<?php
//path to mysqli class
require_once("/etc/apache2/capstone-mysql/ddconnect.php");

//require the files needed
require_once("php/class/user.php");
require_once("php/class/profile.php");

//CSRF path
require_once("php/lib/csrf.php");

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
		<meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">
		<title>Home</title>
		<link type=\"text/css\" href=\"//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css\" rel=\"stylesheet\" />
		<script type=\"text/javascript\" src=\"//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js\"></script>
		<script type=\"text/javascript\" src=\"//cdnjs.cloudflare.com/ajax/libs/jquery.form/3.51/jquery.form.min.js\"></script>
		<script type=\"text/javascript\" src=\"//ajax.aspnetcdn.com/ajax/jquery.validate/1.12.0/jquery.validate.min.js\"></script>
		<script type=\"text/javascript\" src=\"//ajax.aspnetcdn.com/ajax/jquery.validate/1.12.0/additional-methods.min.js\"></script>
	</head>
	<body>
		<main class=\"container\">
			<nav class=\"row\">";

require_once("php/stub/navstub.php");

echo
	"</nav>
	<section class=\"row\">
		<aside class=\"col-md-4 col-sm-4\">";

//if $_session["profileId"] is set call aside.php
//if not call login
if(@isset($_SESSION["profile"]) === false){
	require_once("login-stub.php");
}
else{
	require_once("aside.php");
}

echo	"</aside>
		<article id=\"content\" class=\"col-md-8 col-sm-8 col-xs-12\">";