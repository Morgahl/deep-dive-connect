<?php
/**
 * Created in collaboration by:
 *
 * Gerardo Medrano <GMedranoCode@gmail.com>
 * Marc Hayes <Marc.Hayes.Tech@gmail.com>
 * Steven Chavez <schavez256@yahoo.com>
 * Joseph Bottone <hi@oofolio.com>
 *
 */
$admin = isset($_SESSION["security"]["siteAdmin"]) ? $_SESSION["security"]["siteAdmin"] : false;
$profileId = isset($_SESSION["profile"]["profileId"]) ? $_SESSION["profile"]["profileId"] : false;

echo "<!DOCTYPE html>
<html>
	<head lang=\"en\">
		<meta charset=\"UTF-8\">
		<meta name=\"viewport\" content=\"width=device-width, initial-scale=0.8\">
		<title>Deep Dive Connect</title>
		<link type=\"text/css\" href=\"//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css\" rel=\"stylesheet\" />
		<link rel=\"stylesheet\" href=\"//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css\">
		<script type=\"text/javascript\" src=\"//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js\"></script>
		<script type=\"text/javascript\" src=\"//cdnjs.cloudflare.com/ajax/libs/jquery.form/3.51/jquery.form.min.js\"></script>
		<script type=\"text/javascript\" src=\"//ajax.aspnetcdn.com/ajax/jquery.validate/1.12.0/jquery.validate.min.js\"></script>
		<script type=\"text/javascript\" src=\"//ajax.aspnetcdn.com/ajax/jquery.validate/1.12.0/additional-methods.min.js\"></script>
		 <script src=\"//code.jquery.com/ui/1.11.2/jquery-ui.js\"></script>
		<link href=\"css/stylesheet.css\" rel=\"stylesheet\">
		<!-- this is to auto scroll a nav bar height up when following a link onto a page's id anchor link due to fixed nav bar at the top -->
		<script>
			var shiftWindow = function() { scrollBy(0, -54) };
			window.addEventListener(\"hashchange\", shiftWindow);
			function load() { if (window.location.hash) shiftWindow(); }
		</script>
	</head>
	<body onload=\"load();\">
		<header class=\"container-fluid navbar-fixed-top\">
			<nav class=\"container\">
				<div class= \"col-sm-3 hidden-xs\">
					<img class=\"img-responsive\" src=\"resources/stemuluslogo.png\"/>
				</div>
				<div class=\"col-sm-9 col-xs-12\">
					<div class=\"btn-group btn-group-justified\">
						<a href=\"index.php\" class=\"btn btn-default\"><h4><strong>Home</strong></h4></a>";

if($profileId !== false) {
	echo "<a href=\"profile.php\" class=\"btn btn-default\"><h4><strong>Profile</strong></h4></a>";
}

echo "<a href=\"cohort-main.php\" class=\"btn btn-default\"><h4><strong>Cohort</strong></h4></a>";

if ($admin === 1){
	echo "<a href=\"dashboard.php\" class=\"btn btn-default\"><h4><strong>Admin</strong></h4></a>";
}
if($profileId !== false) {
	echo "<a href=\"php/form-processor/sessionDestroy.php\" class=\"btn btn-default\"><h4><strong>Sign Out</strong></h4></a>";
}

echo "
					</div>
				</div>
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

echo	"<article id=\"content\" class=\"col-sm-9 col-xs-12\">";