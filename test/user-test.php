<?php
//first require the SimpleTest framework
require_once("/usr/lib/php5/simpletest/autorun.php");
require_once("/etc/apache2/capstone-mysql/ddconnect.php");

// then require the class under scrutiny
require_once("../php/user.php");

// the UserTest is a container for all our tests
class UserTest extends UnitTestCase {
	//variable to hold the mySQL connection
	private $mysqli = null;
	//variable to hold the test database row
	private $user = null;

	// a few "global" variables for the creating test data
	private $EMAIL	= "unit@test.com";
	private $PASSWORD = "ABCDEFG";
	private $SALT = null;
	private $AUTHKEY = null;
	private $HASH = null;
	private $SECURITYID = 1;
	private $LOGINSOURCEID = null;

	//setUp() is a method that is run before each test
	//here, we use it to connect to mySQL and to calc the salt, hash, and authkey
	public function setUp() {
		// connect to mySQL
		$this->mysqli = MysqliConfiguration::getMysqli();

		// randomize the salt, hash, and authkey
		$this->SALT		= bin2hex(openssl_random_pseudo_bytes(32));
		$this->AUTHKEY = bin2hex(openssl_random_pseudo_bytes(16));
		$this->HASH 	= hash_pbkdf2("sha512", $this->PASSWORD, $this->SALT, 2048, 128);
	}

	// tearDown() is a method that is run after each test
	// hear, we use it to delete the test record and disconnect from mySQL
	public function tearDown(){
		//delete the user if we can
		if($this->user !== null) {
			$this->user->delete($this->mysqli);
			$this->user = null;
		}

		// disconnect from mySQL
		/*
		if($this->mysqli !== null){
			$this->mysqli->close();
		}
		*/
	}

	//test creating a new User and inserting it to mySQL
	public function testInsertNewUser() {
		//first, verify mySQL connect OK
		$this->assertNotNull($this->mysqli);

		//second, create a user to post to mySQL
		$this->user = new User(null, $this->EMAIL, $this->HASH, $this->SALT, $this->AUTHKEY, $this->SECURITYID, $this->LOGINSOURCEID);

		//third, insert the user to mySQL
		$this->user->insert($this->mysqli);

		// finally compare the fields
		$this->assertNotNull($this->user-> __get("userId"));
		$this->assertTrue($this->user-> __get("userId") >0);
		$this->assertIdentical($this->user-> __get("email"), 				$this->EMAIL);
		$this->assertIdentical($this->user-> __get("passwordHash"), 	$this->HASH);
		$this->assertIdentical($this->user-> __get("salt"), 				$this->SALT);
		$this->assertIdentical($this->user-> __get("authKey"),			$this->AUTHKEY);
		$this->assertIdentical($this->user-> __get("securityId"), 		$this->SECURITYID);
		$this->assertIdentical($this->user-> __get("loginSourceId"),	$this->LOGINSOURCEID);
	}

	//test updating a User in mySQL
	public function testUpdateUser(){
		// first, verify mySQL connected OK
		$this->assertNotNull($this->mysqli);

		//second, create a user to post to mySQL
		$this->user = new User(null, $this->EMAIL, $this->HASH, $this->SALT, $this->AUTHKEY, $this->SECURITYID, $this->LOGINSOURCEID);

		//third, insert the user to mySQL
		$this->user->insert($this->mysqli);

		//fourth, update the user and post the changes to mySQL
		$newEmail = "jack@chan.com";
		$this->user->setEmail($newEmail);
		$this->user->update($this->mysqli);

		// finally, compare the fields
		$this->assertNotNull($this->user-> __get("userId"));
		$this->assertTrue($this->user-> __get("userId") > 0);
		$this->assertIdentical($this->user-> __get("email"), $newEmail);
		$this->assertIdentical($this->user-> __get("passwordHash"), 	$this->HASH);
		$this->assertIdentical($this->user-> __get("salt"), 				$this->SALT);
		$this->assertIdentical($this->user-> __get("authKey"),			$this->AUTHKEY);
		$this->assertIdentical($this->user-> __get("securityId"), 		$this->SECURITYID);
		$this->assertIdentical($this->user-> __get("loginSourceId"),	$this->LOGINSOURCEID);

	}

	//test deleting a User
	public function testDeleteUser(){
		//first, verify mySQL connect OK
		$this->assertNotNull($this->mysqli);

		//second, create a user to post to mySQL
		$this->user = new User(null, $this->EMAIL, $this->HASH, $this->SALT, $this->AUTHKEY, $this->SECURITYID, $this->LOGINSOURCEID);

		//third, insert the user to mySQL
		$this->user->insert($this->mysqli);

		// fourth, verify the User was inserted
		$this->assertNotNull($this->user-> __get("userId"));
		$this->assertTrue($this->user->__get("userId") > 0);

		// fifth, delete the user
		$this->user->delete($this->mysqli);
		$this->user = null;

		//finally, try to get the user and assert we didn't get a thing
		//TODO: get user by email
	}
}
?>




















