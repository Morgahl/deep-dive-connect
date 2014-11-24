<?php

/**
 * Author Joseph Bottone
 * http://josephmichaelbottone.com
 * bottone.joseph@gmail.
 * thundermedia.com
 * Unit test for Security
 **/

// require mysqli connection object
require_once("/etc/apache2/capstone-mysql/ddconnect.php");
// first require the SimpleTest framework
require_once("/usr/lib/php5/simpletest/autorun.php");

// then require the class under scrutiny
require_once("../php/class/security.php");

// the securityClassTest is a container for all our tests
class SecurityClassTest extends UnitTestCase
{
	// variable to hold the mySQL connection
	private $mysqli = null;
	// variable to hold the test database row
	private $security = null;

	// a few "global" variables for creating test data

	private $DESCRIPTION = "Bada Bing!";
	private $ISDEFAULT = 0;
	private $CREATETOPIC = 1;
	private $CANEDITOTHER = 1;
	private $CANPROMOTE = 1;
	private $SITEADMIN = 1;

	// setUp() is a method that is run before each test
	// here, we use it to connect to mySQL and to calculate the salt, hash, and authenticationToken
	public function setUp()
	{
		// connect to mySQL

		$this->mysqli = MysqliConfiguration::getMysqli();
	}

	// tearDown() is a method that is run after each test
	// here, we use it to delete the test record and disconnect from mySQL
	public function tearDown()
	{
		// delete the user if we can
		if($this->security !== null) {
			$this->security->delete($this->mysqli);
			$this->security = null;
		}

	}

	// test creating a new Security Class and inserting it to mySQL
	public function testInsertSecurityClass()
	{
		// first, verify mySQL connected OK
		$this->assertNotNull($this->mysqli);

		// second, create a Security Class to post to mySQL
		$this->security = new Security(null, $this->DESCRIPTION, $this->ISDEFAULT, $this->CREATETOPIC, $this->CANEDITOTHER, $this->CANPROMOTE, $this->SITEADMIN);

		// third, insert the Security Class to mySQL
		$this->security->insert($this->mysqli);

		// finally, compare the fields
		//securityId
		$this->assertNotNull($this->security->getSecurityId());
		$this->assertTrue($this->security->getSecurityId() > 0);
		// description
		$this->assertNotNull($this->security->getDescription());
		$this->assertIdentical($this->security->getDescription(), $this->DESCRIPTION);
		// isDefault
		$this->assertNotNull($this->security->getIsDefault());
		$this->assertIdentical($this->security->getIsDefault(), $this->ISDEFAULT);
		// canEditOther
		$this->assertNotNull($this->security->getCanEditOther());
		$this->assertIdentical($this->security->getCanEditOther(), $this->CANEDITOTHER);
		// canPromote
		$this->assertNotNull($this->security->getCanPromote());
		$this->assertIdentical($this->security->getCanPromote(), $this->CANPROMOTE);
		// siteAdmin
		$this->assertNotNull($this->security->getSiteAdmin());
		$this->assertIdentical($this->security->getSiteAdmin(), $this->SITEADMIN);
	}




// test updating a variable in Security Class
	public function testUpdateSecurityClass()
	{
		// first, verify mySQL connected OK
		$this->assertNotNull($this->mysqli);

		// second, create a Security Class to post to mySQL
		$this->security = new Security(null, $this->DESCRIPTION, $this->ISDEFAULT, $this->CREATETOPIC, $this->CANEDITOTHER, $this->CANPROMOTE, $this->SITEADMIN);

		// third, insert the Security Class to mySQL
		$this->security->insert($this->mysqli);

		// fourth, update the Security Class and post the changes to mySQL
		$description = "some random asdfasdf text";
		$this->security->setDescription($description);
		$this->security->update($this->mysqli);


		// finally, compare the fields
		$this->assertNotNull($this->security->getSecurityId());
		$this->assertTrue($this->security->getSecurityId() > 0);
		// description
		$this->assertNotNull($this->security->getDescription());
		$this->assertIdentical($this->security->getDescription(), $description);
		// isDefault
		$this->assertNotNull($this->security->getIsDefault());
		$this->assertIdentical($this->security->getIsDefault(), $this->ISDEFAULT);
		// canEditOther
		$this->assertNotNull($this->security->getCanEditOther());
		$this->assertIdentical($this->security->getCanEditOther(), $this->CANEDITOTHER);
		// canPromote
		$this->assertNotNull($this->security->getCanPromote());
		$this->assertIdentical($this->security->getCanPromote(), $this->CANPROMOTE);
		// siteAdmin
		$this->assertNotNull($this->security->getSiteAdmin());
		$this->assertIdentical($this->security->getSiteAdmin(), $this->SITEADMIN);
	}




	// test deleting a variable in Security Class
	public function deleteFromSecurityId()
	{
		// first, verify mySQL connected OK
		$this->assertNotNull($this->mysqli);

		// second, create a Security Class to post to mySQL
		$this->security = new Security(null, $this->DESCRIPTION, $this->ISDEFAULT, $this->CREATETOPIC, $this->CANEDITOTHER, $this->CANPROMOTE, $this->SITEADMIN);

		// third, insert the Security Class to mySQL
		$this->security->insert($this->mysqli);

		// fourth, verify the securityId was inserted
		$this->assertNotNull($this->security->getSecurityId());
		$this->assertTrue($this->security->getSecurityId() > 0);

		// fifth, delete the class
		$this->security->delete($this->mysqli);
		$this->security = null;

		// finally, try to get the Security and say we didn't get it
		$hopefulSecurityClass = Security::getSecurityBySecurityId($this->mysqli, $this->security->getSecurityId);
		$this->assertNull($hopefulSecurityClass);

	}

	// test grabbing the Security Class from mySQL
	public function testGetSecurityClass()
	{
		// first, verify mySQL connected OK
		$this->assertNotNull($this->mysqli);

		// second, create a Security Class to post to mySQL
		$this->security = new Security(null, $this->DESCRIPTION, $this->ISDEFAULT, $this->CREATETOPIC, $this->CANEDITOTHER, $this->CANPROMOTE, $this->SITEADMIN);

		// third, insert the Security Class to mySQL
		$this->security->insert($this->mysqli);

		// fourth, get the class by the static method
		$staticUser = Security::getSecurityBySecurityId($this->mysqli, $this->security->getSecurityId());

		// compare the fields

		$this->assertNotNull($this->security->getSecurityId());
		$this->assertTrue($this->security->getSecurityId() > 0);
		// description
		$this->assertNotNull($this->security->getDescription());
		$this->assertIdentical($this->security->getDescription(), $this->DESCRIPTION);
		// isDefault
		$this->assertNotNull($this->security->getIsDefault());
		$this->assertIdentical($this->security->getIsDefault(), $this->ISDEFAULT);
		// canEditOther
		$this->assertNotNull($this->security->getCanEditOther());
		$this->assertIdentical($this->security->getCanEditOther(), $this->CANEDITOTHER);
		// canPromote
		$this->assertNotNull($this->security->getCanPromote());
		$this->assertIdentical($this->security->getCanPromote(), $this->CANPROMOTE);
		// siteAdmin
		$this->assertNotNull($this->security->getSiteAdmin());
		$this->assertIdentical($this->security->getSiteAdmin(), $this->SITEADMIN);
	}


}

