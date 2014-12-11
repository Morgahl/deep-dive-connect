<?php
/**
 * signup and login form processor
 *
 * @author Joseph Bottone <bottone.joseph@gmail.com>
 */

session_start();
require_once("/etc/apache2/capstone-mysql/ddconnect.php");
require_once("../lib/csrf.php");
require_once("../class/profile.php");
require_once("../class/user.php");
require_once("Mail.php");

try{
	//verify the form was submitted properly
			if (@isset($_POST["email"]) === false || @isset($_POST["passwordHash"]) === false ||
					  		@isset($_POST["firstName"]) === false || @isset($_POST["lastName"]) === false ||
	@isset($_POST["passwordHash"]) === false)
			{
					throw(new RuntimeException("Form variables incomplete or missing."));
				}

				//ensures that passwords are identical
				$password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_STRING);
				$confPassword = filter_input(INPUT_POST, "confPassword", FILTER_SANITIZE_STRING);
				if($password !== $confPassword) {
					throw(new RuntimeException("Passwords do not match."));
				} else {
					if(User::getUserByEmail($mysqli, $_POST["email"]) !== null) ;
					throw(new RuntimeException("Email already exist please try again."));
				}


						//create a new object and insert it to mySQL

					$salt = bin2hex(openssl_random_pseudo_bytes(32));
		$authToken = bin2hex(openssl_random_pseudo_bytes(16));
		$passwordHash = hash_pbkdf2("sha512", $_POST["password"], $salt, 2048, 128);


$mysqli = MysqliConfiguration::getMysqli();
		$signupUser = new User(null, $_POST["email"], $passwordHash, $salt, $authKey, 2, 1);
 		$signupUser->insert($mysqli);
 		$signupProfile = new Profile(null, $signupUser->getUserId(), $_POST["firstName"], $_POST["lastName"], null, null, null,
			null, null);
 		$signupProfile->insert($mysqli);

	// email the user with an activation message
	$to = $signupUser->getEmail();
	$from = "noreply@deepdiveconnect.com";

	// build headers
	$headers = array();
	$headers["To"] = $to;
	$headers["From"] = $from;
	$headers["Reply-To"] = $from;
	$headers["Subject"] = $signupProfile->getFirstName() . " " . $signupProfile->getLastName() . ",
		Activate your DeepDiveConnect Login";
	$headers["MIME-Version"] = "1.0";
	$headers["Content-Type"] = "text/html; charset=UTF-8";

	// build message
	$pageName = end(explode("/", $_SERVER["PHP_SELF"]));
	$url = "https://" . $_SERVER["SERVER_NAME"] . $_SERVER["PHP_SELF"];
	$url = str_replace($pageName, "../../validation/activate.php", $url);
	$url = "$url?authToken=$authToken";
	$message = <<< EOF
<html>
    <body>
        <h1>Welcome to DeepDiveConnect.com!</h1>
        <hr />
        <p>Thank you for registering for the Alumni of Deep Diver Coders! Visit the following URL to complete your registration process: <a href="$url">$url</a>.</p>
    </body>
</html>
EOF;

	// send the email
	error_reporting(E_ALL & ~E_STRICT);
	$mailer =& Mail::factory("sendmail");
	$status = $mailer->send($to, $headers, $message);
	if(PEAR::isError($status) === true) {
		echo "<div class=\"alert alert-danger\" role=\"alert\"><strong>Nope!</strong> Unable to send mail message:" . $status->getMessage() . "</div>";
	} else {
		echo "<div class=\"alert alert-success\" role=\"alert\"><strong>Yay!</strong> Please check your Email to complete the signup process.</div>";
	}

	}
			catch
				(Exception $exception){
				} catch(Exception $exception){
					echo "<div class=\"alert alert-danger\" role=\"alert\"><strong>Nope!</strong> Unable to sign up: " . $exception->getMessage() . "</div>";

}
?>