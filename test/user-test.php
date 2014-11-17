<?php
//first require the SimpleTest framework
require_once("/usr/lib/php5/simpletest/autorun.php");
require_once("/etc/apache2/capstone-mysql/ddconnect.php");

// then require the class under scrutiny
require_once("../php/user.php");
require_once("../php/loginSource.php");

// the UserTest is a container for all our tests
class UserTest extends UnitTestCase {
	//variable to hold the mySQL connection
	private $mysqli = null;
	//variable to hold the test database row
	//todo: make place holder for security and login so you can make objects.
	private $user = null;

	//TODO: APPLY ONCE SECURITY AND LOGINSOURCE OBJECTS CAN BE CREATED
	//private $securtiy = null;
	//private $loginSource = null;

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

		//Todo: create foreign key objects



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
		$this->assertNotNull($this->user->getUserId());
		$this->assertTrue($this->user->getUserId() >0);
		$this->assertIdentical($this->user->getEmail(), 				$this->EMAIL);
		$this->assertIdentical($this->user->getPasswordHash(), 	$this->HASH);
		$this->assertIdentical($this->user->getSalt(), 				$this->SALT);
		$this->assertIdentical($this->user->getAuthKey(),			$this->AUTHKEY);
		$this->assertIdentical($this->user->getSecurityId(), 		$this->SECURITYID);
		$this->assertIdentical($this->user->getLoginSourceId(),	$this->LOGINSOURCEID);
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
		$this->assertNotNull($this->user->getUserId());
		$this->assertTrue($this->user->getUserId() > 0);
		$this->assertIdentical($this->user->getEmail(), $newEmail);
		$this->assertIdentical($this->user->getPasswordHash(), 	$this->HASH);
		$this->assertIdentical($this->user->getSalt(), 				$this->SALT);
		$this->assertIdentical($this->user->getAuthKey(),			$this->AUTHKEY);
		$this->assertIdentical($this->user->getSecurityId(), 		$this->SECURITYID);
		$this->assertIdentical($this->user->getLoginSourceId(),	$this->LOGINSOURCEID);

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
		$this->assertNotNull($this->user->getUserId());
		$this->assertTrue($this->user->getUserId() > 0);

		// fifth, delete the user
		$this->user->delete($this->mysqli);
		$this->user = null;

		//finally, try to get the user and assert we didn't get a thing
		$hopefulUser = User::getUserByEmail($this->mysqli, $this->EMAIL);
		$this->assertNull($hopefulUser);
	}

	// test grabbing a User from mySQL
	public function testGetUserByEmail() {
		// first, verify mySQL connected OK
		$this->assertNotNull($this->mysqli);

		// second, create a user to post to mySQL
		$this->user = new User(null, $this->EMAIL, $this->HASH, $this->SALT, $this->AUTHKEY, $this->SECURITYID, $this->LOGINSOURCEID);

		// third, insert the user to mySQL
		$this->user->insert($this->mysqli);

		// fourth, get the user using the static method
		$staticUser = User::getUserByEmail($this->mysqli, $this->EMAIL);

		// finally, compare the fields
		$this->assertNotNull($staticUser->getUserId());
		$this->assertTrue($staticUser->getUserId() > 0);
		$this->assertIdentical($staticUser->getUserId(),              $this->user->getUserId());
		$this->assertIdentical($staticUser->getEmail(),  $this->EMAIL);
		$this->assertIdentical($staticUser->getPasswordHash(), 	$this->HASH);
		$this->assertIdentical($staticUser->getSalt(), 				$this->SALT);
		$this->assertIdentical($staticUser->getAuthKey(),			$this->AUTHKEY);
		$this->assertIdentical($staticUser->getSecurityId(), 		$this->SECURITYID);
		$this->assertIdentical($staticUser->getLoginSourceId(),	$this->LOGINSOURCEID);
	}

	// test get user by userId
	public function testGetUserByUserId(){
		// first, verify mySQL connected OK
		$this->assertNotNull($this->mysqli);

		// second, create a user to post to mySQL
		$this->user = new User(null, $this->EMAIL, $this->HASH, $this->SALT, $this->AUTHKEY, $this->SECURITYID, $this->LOGINSOURCEID);

		// third, insert the user to mySQL
		$this->user->insert($this->mysqli);

		// fourth, get the user using the static method
		$staticUser = User::getUserByUserId($this->mysqli, $this->user->getUserId());

		// finally, compare the fields
		$this->assertNotNull($staticUser->getUserId());
		$this->assertTrue($staticUser->getUserId() > 0);
		$this->assertIdentical($staticUser->getUserId(),              $this->user->getUserId());
		$this->assertIdentical($staticUser->getEmail(),  $this->EMAIL);
		$this->assertIdentical($staticUser->getPasswordHash(), 	$this->HASH);
		$this->assertIdentical($staticUser->getSalt(), 				$this->SALT);
		$this->assertIdentical($staticUser->getAuthKey(),			$this->AUTHKEY);
		$this->assertIdentical($staticUser->getSecurityId(), 		$this->SECURITYID);
		$this->assertIdentical($staticUser->getLoginSourceId(),	$this->LOGINSOURCEID);
	}
}
?>




















