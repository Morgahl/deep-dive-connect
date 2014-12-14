<?php
/**
 * signup form processor
 *
 * @author Joseph Bottone <bottone.joseph@gmail.com>
 * @author Marc Hayes <marc.hayes.tech@gmail.com>
 */

session_start();
require_once("/etc/apache2/capstone-mysql/ddconnect.php");
require_once("../lib/csrf.php");
require_once("../class/profile.php");
require_once("../class/user.php");
require_once("Mail.php");

try{
	$mysqli = MysqliConfiguration::getMysqli();
	//verify the form was submitted properly

	// store CSRF tokens
	$csrfName = isset($_POST["csrfName"]) ? $_POST["csrfName"] : false;
	$csrfToken = isset($_POST["csrfToken"]) ? $_POST["csrfToken"] : false;

	// verify CSRF tokens
	if(verifyCsrf($csrfName, $csrfToken) === false){
		throw (new RuntimeException("External call made."));
	}

	$email = filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL);
	$password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_STRING);
	$confPassword = filter_input(INPUT_POST, "confPassword", FILTER_SANITIZE_STRING);
	$firstName = filter_input(INPUT_POST, "firstName", FILTER_SANITIZE_STRING);
	$lastName = filter_input(INPUT_POST, "lastName", FILTER_SANITIZE_STRING);

	// ensure that all fields filled out
	if ($email === null || $password === null || $confPassword === null || $firstName === null || $lastName === null)
	{
		throw(new RuntimeException("Form variables incomplete or missing."));
	}

	// ensure that all fields passed the filters
	if ($email === false || $password === false || $confPassword === false || $firstName === false || $lastName === false)
	{
		throw(new RuntimeException("Form variables are malformed."));
	}

	//ensures that passwords are identical
	if($password !== $confPassword) {
		throw(new RuntimeException("Passwords do not match."));
	} elseif(User::getUserByEmail($mysqli, $email) !== null) {
		throw(new RuntimeException("Email already exist please try again."));
	} else {

		//create a new object and insert it to mySQL
		$salt = bin2hex(openssl_random_pseudo_bytes(32));
		$authToken = bin2hex(openssl_random_pseudo_bytes(16));
		$passwordHash = hash_pbkdf2("sha512", $password, $salt, 2048, 128);

		// get default security group
		$security = Security::getIdForDefault($mysqli);

		// create user object and insert
		$signupUser = new User(null, $email, $passwordHash, $salt, $authToken, $security->getSecurityId(), null);
		$signupUser->insert($mysqli);

		// create profile object and insert
		$signupProfile = new Profile(null, $signupUser->getUserId(), $firstName, $lastName, null, null, null, null, null);
		$signupProfile->insert($mysqli);

		// email the user with an activation message
		$to = $signupUser->getEmail();
		$from = "mhayes15@cnm.edu";

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
		$url = str_replace($pageName, "activate.php", $url);
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
		var_dump($status);
		if(PEAR::isError($status) === true) {
			echo "<div class=\"alert alert-danger\" role=\"alert\"><strong>Nope!</strong> Unable to send mail message:" . $status->getMessage() . "</div>";
		} else {
			echo "<div class=\"alert alert-success\" role=\"alert\"><strong>Yay!</strong> Please check your Email to complete the signup process.</div>";
		}
	}
}
catch(Exception $exception){
	$_SESSION[$csrfName] = $csrfToken;
	echo "<div class=\"alert alert-danger\" role=\"alert\"><strong>Nope!</strong> Unable to sign up: " . $exception->getMessage() . "</div>";
}
?>