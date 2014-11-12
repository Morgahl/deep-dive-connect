<?php
//first require the SimpleTest framework
require_once("/usr/lib/php5/simpletest/autorun.php");
require_once("/etc/apache2/capstone-mysql/ddconnect.php");

// then require the class under scrutiny
require_once("../php/profile.php");

// require user class so you can make a new
// object to test profile properly
require_once("../php/user.php");

// the UserTest is a container for all our tests
class ProfileTest extends UnitTestCase{
	//variable to hold the mySQL connection
	private $mysqli = null;
	//variable to hold the test database row
	private $profile = null;
	private $user = null;

	//a few global variables for creating test data
	private $USERID = null;
	private $FNAME = "Jacqueline";
	private $LNAME = "Chavez";
	private $MNAME = "luna";
	private $LOCATION = "Albuquerque";
	private $DESCRIPTION = "There are three kinds of intelligence: one kind understands things for itself, the other appreciates what others can understand, the third understands neither for itself nor through others. This first kind is excellent, the second good, and the third kind useless.";
	private $FILENAME = "fileName";
	private $FILETYPE = "gif";

	// setUp() is a method that is run before each test
	public function setUp(){
		// connect to mySQL
		$this->mysqli = MysqliConfiguration::getMysqli();

		// create new user object
		$this->user = new User(null, "jack@chan.com", null, null, null, 1, 1);

		// insert user into MySQL
		$this->user->insert($this->mysqli);

		// second get userId from user object and assign it to USERID
		$this->USERID = $this->user->getUserId();

	}

	// tearDown() is a method that is run after each test
	public function tearDown(){
		// delete the profile if we can
		if($this->profile !== null){
			$this->profile->delete($this->mysqli);
			$this->profile = null;
		}

		// delete user
		if($this->user !== null){
			$this->user->delete($this->mysqli);
			$this->user = null;
		}
	}

	// test creating a new Profile and inserting it to mySQL
	public function testInsertNewProfile(){
		// first, verify mySQL connect OK
		$this->assertNotNull($this->mysqli);


		// third, create a user to post to mySQL
		$this->profile = new Profile(null, $this->USERID, $this->FNAME, $this->LNAME, $this->MNAME, $this->LOCATION, $this->DESCRIPTION, $this->FILENAME,$this->FILETYPE);

		// fourth, insert the profile to mySQL
		$this->profile->insert($this->mysqli);

		// finally, compare the fields
		$this->assertNotNull($this->profile->getProfileId());
		$this->assertTrue($this->profile->getProfileId() > 0);
		$this->assertIdentical($this->profile->getUserId(), $this->USERID);
		$this->assertIdentical($this->profile->getFirstName(), $this->FNAME);
		$this->assertIdentical($this->profile->getLastName(), $this->LNAME);
		$this->assertIdentical($this->profile->getMiddleName(), $this->MNAME);
		$this->assertIdentical($this->profile->getLocation(), $this->LOCATION);
		$this->assertIdentical($this->profile->getDescription(), $this->DESCRIPTION);
		$this->assertIdentical($this->profile->getProfilePicFileName(), $this->FILENAME);
		$this->assertIdentical($this->profile->getProfilePicFileType(), $this->FILETYPE);

	}

	// test updating a profile in mySQL
	public function testUpdateUser(){
		// first, verify mySQL connect OK
		$this->assertNotNull($this->mysqli);


		// second, create a user to post to mySQL
		$this->profile = new Profile(null, $this->USERID, $this->FNAME, $this->LNAME, $this->MNAME, $this->LOCATION, $this->DESCRIPTION, $this->FILENAME,$this->FILETYPE);

		// third insert profile to mySQL
		$this->profile->insert($this->mysqli);

		// fourth, update the user and post the changes
		$newFName = "Steven";
		$this->profile->setFirstName($newFName);
		$newLName = "Vigil";
		$this->profile->setLastName($newLName);
		$newMName = "Michael";
		$this->profile->setMiddleName($newMName);
		$newLocation = "New Mexico";
		$this->profile->setLocation($newLocation);
		$newDesc = "I'm a programmer";
		$this->profile->setDescription($newDesc);
		$newFileName = "fileName2";
		$this->profile->setProfilePicFileName($newFileName);
		$newFileType = "jpeg";
		$this->profile->setProfilePicFileType($newFileType);

		// update object
		$this->profile->update($this->mysqli);

		// finally, compare the fields
		$this->assertNotNull($this->profile->getProfileId());
		$this->assertTrue($this->profile->getProfileId() > 0);
		$this->assertIdentical($this->profile->getUserId(), $this->USERID);
		$this->assertIdentical($this->profile->getFirstName(), $newFName);
		$this->assertIdentical($this->profile->getLastName(), $newLName);
		$this->assertIdentical($this->profile->getMiddleName(), $newMName);
		$this->assertIdentical($this->profile->getLocation(), $newLocation);
		$this->assertIdentical($this->profile->getDescription(), $newDesc);
		$this->assertIdentical($this->profile->getProfilePicFileName(), $newFileName);
		$this->assertIdentical($this->profile->getProfilePicFileType(), $newFileType);
	}

	// test deleting a Profile
	public function testDeleteProfile(){
		// first, verify mySQL connect OK
		$this->assertNotNull($this->mysqli);


		// second, create a user to post to mySQL
		$this->profile = new Profile(null, $this->USERID, $this->FNAME, $this->LNAME, $this->MNAME, $this->LOCATION, $this->DESCRIPTION, $this->FILENAME,$this->FILETYPE);

		// third, insert the profile to mySQL
		$this->profile->insert($this->mysqli);

		// fourth, verify the profile was inserted
		$this->assertNotNull($this->profile->getProfileId());
		$this->assertTrue($this->profile->getProfileId() > 0);

		// fifth, delete profile
		$this->profile->delete($this->mysqli);
		$this->profile = null;

		//TODO: make getProfileByUserId

	}
}
?>







