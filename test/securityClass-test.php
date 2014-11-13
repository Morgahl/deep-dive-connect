<?php

// Author Joseph Bottone
// http://josephmichaelbottone.com
// bottone.joseph@gmail.com
// thundermedia.com
// Unit test for SecurityClass


// require mysqli connection object
require_once("/etc/apache2/capstone-mysql/ddconnect.php");
// first require the SimpleTest framework
require_once("/usr/lib/php5/simpletest/autorun.php");

// then require the class under scrutiny
require_once("../php/securityClass.php");

// the UserTest is a container for all our tests
class UserTest extends UnitTestCase {
	// variable to hold the mySQL connection
	private $mysqli = null;
	// variable to hold the test database row
	private $security   = null;

	// a few "global" variables for creating test data
	private $SECURITYID = null;
	private $DESCRIPTION = "ChedGeek5";
	private $ISDEFAULT       = 0;
	private $CREATETOPIC = 1;
	private $CANEDITOTHER       = 1;
	private $CANPROMOTE = 1;
	private $SITEADMIN       = 1;

	// setUp() is a method that is run before each test
	// here, we use it to connect to mySQL and to calculate the salt, hash, and authenticationToken
	public function setUp() {
		// connect to mySQL

		$this->mysqli =  MysqliConfiguration::getMysqli();
	}

	// tearDown() is a method that is run after each test
	// here, we use it to delete the test record and disconnect from mySQL
	public function tearDown() {
		// delete the user if we can
		if($this->security !== null) {
			$this->security->delete($this->mysqli);
			$this->security = null;
		}

	}

	// test creating a new User and inserting it to mySQL
	public function testInsertNewUser() {
		// first, verify mySQL connected OK
		$this->assertNotNull($this->mysqli);

		// second, create a user to post to mySQL
		$this->security = new SecurityClass(null, $this->DESCRIPTION, $this->ISDEFAULT, $this->CREATETOPIC, $this->CANEDITOTHER, $this->CANPROMOTE, $this->SITEADMIN);

		// third, insert the user to mySQL
		$this->security->insert($this->mysqli);

		// finally, compare the fields
		$this->assertNotNull($this->security->getSecurityId());
		$this->assertTrue($this->security->getSecurityId() > 0);
		$this->assertIdentical($this->security->getDescription(), $this->DESCRIPTION);
		$this->assertIdentical($this->security->getIsDefault(),   $this->ISDEFAULT);
		$this->assertIdentical($this->security->getcanEditOther(), $this->CANEDITOTHER);
		$this->assertIdentical($this->security->canPromote(), $this->CANPROMOTE);
		$this->assertIdentical($this->security->siteAdmin(), $this->SITEADMIN);
	}

