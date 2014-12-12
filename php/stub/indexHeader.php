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
		<title>Deep Dive Connect</title>
		<link type=\"text/css\" href=\"//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css\" rel=\"stylesheet\" />
		<script type=\"text/javascript\" src=\"//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js\"></script>
		<script type=\"text/javascript\" src=\"//cdnjs.cloudflare.com/ajax/libs/jquery.form/3.51/jquery.form.min.js\"></script>
		<script type=\"text/javascript\" src=\"//ajax.aspnetcdn.com/ajax/jquery.validate/1.12.0/jquery.validate.min.js\"></script>
		<script type=\"text/javascript\" src=\"//ajax.aspnetcdn.com/ajax/jquery.validate/1.12.0/additional-methods.min.js\"></script>
		<style>
		header{
		background-color: #000000;
		}
		aside{
		background-color: #f0f0f0;
		}
		.btn-right{
		float: right;
		}
		</style>
	</head>
	<body>
		<header class=\"container-fluid\">
			<nav class=\"container\">
				<div class=\"row\">
					<div class=\"col-sm-3 hidden-xs\">
						<img class=\"img-responsive center-block\" src=\"resources/stemuluslogo.png\" />
					</div>
					";

require_once("php/stub/navstub.php");

echo
"		</div>
	</nav>
</header>
<main class=\"container\">
	<section class=\"row\">";

//if $_session["profileId"] is set call aside.php
//if not call login
if(@isset($_SESSION["profile"]) === false){
	require_once("login-stub.php");
}
else{
	require_once("aside.php");
}

echo	"<article id=\"content\" class=\"col-sm-9 col-sm-offset-0 col-xs-10 col-xs-offset-1\">";