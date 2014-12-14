<?php

/**
 * LoginSource test
 *
 * @author Joseph Bottone <bottone.joseph@gmail.com>
 */

// require mysqli connection object
require_once("/etc/apache2/capstone-mysql/ddconnect.php");
// first require the SimpleTest framework
require_once("/usr/lib/php5/simpletest/autorun.php");

// then require the class under scrutiny
require_once("../php/class/loginSource.php");

// the securityClassTest is a container for all our tests
class LoginSourceTest extends UnitTestCase
{
	// variable to hold the mySQL connection
	private $mysqli = null;
	// variable to hold the test database row
	private $loginSource = null;

	// a few "global" variables for creating test data

	private $sourceName = "Working?";
	private $apiKey = "e77edf6dce3efd9e03c24718200bca859f560b2ab1a69650ef568e160dd4d1c1";

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
		if($this->loginSource !== null) {
			$this->loginSource->delete($this->mysqli);
			$this->loginSource = null;
		}

	}

	// test creating a new LoginSource and inserting it to mySQL
	public function testInsertLoginSource()
	{
		// first, verify mySQL connected OK
		$this->assertNotNull($this->mysqli);

		// second, create a LoginSource to post to mySQL
		$this->loginSource = new LoginSource(null, $this->sourceName, $this->apiKey);

		// third, insert the LoginSource to mySQL
		$this->loginSource->insert($this->mysqli);

		// finally, compare the fields

		$this->assertNotNull($this->loginSource->getLoginSourceId());
		$this->assertTrue($this->loginSource->getLoginSourceId() > 0);
		$this->assertNotNull($this->loginSource->getSourceName());
		$this->assertIdentical($this->loginSource->getSourceName(), $this->sourceName);
		$this->assertNotNull($this->loginSource->getApiKey());
		$this->assertIdentical($this->loginSource->getApiKey(), $this->apiKey);
	}


// test updating a variable in LoginSource
	public function testUpdateLoginSource()
	{
		// first, verify mySQL connected OK
		$this->assertNotNull($this->mysqli);

		// second, create a LoginSource to post to mySQL
		$this->loginSource = new LoginSource(null, $this->sourceName, $this->apiKey);

		// third, insert the LoginSource to mySQL
		$this->loginSource->insert($this->mysqli);

		// fourth, update the LoginSource and post the changes to mySQL
		$sourceName = "Quit busting my chops";
		$this->loginSource->setSourceName($sourceName);
		$this->loginSource->update($this->mysqli);


		// finally, compare the fields
		$this->assertNotNull($this->loginSource->getLoginSourceId());
		$this->assertTrue($this->loginSource->getLoginSourceId() > 0);
		$this->assertNotNull($this->loginSource->getSourceName());
		$this->assertIdentical($this->loginSource->getSourceName(), $sourceName);
		$this->assertNotNull($this->loginSource->getApiKey());
		$this->assertIdentical($this->loginSource->getApiKey(), $this->apiKey);
	}

	// test deleting a variable in LoginSource
	public function deleteFromLoginSourceId()
	{
		// first, verify mySQL connected OK
		$this->assertNotNull($this->mysqli);

		// second, create a loginSource to post to mySQL
		$this->loginSource = new LoginSource(null, $this->sourceName, $this->apiKey);

		// third, insert the loginSource to mySQL
		$this->loginSource->insert($this->mysqli);

		// fourth, verify the loginSourceId was inserted
		$this->assertNotNull($this->loginSource->getLoginSourceId());
		$this->assertTrue($this->loginSource->getLoginSourceId() > 0);

		// fifth, delete the class
		$this->loginSource->delete($this->mysqli);
		$this->loginSource = null;

		// finally, try to get the LoginSource and say we didn't get it
		$hopefulLoginSource = loginSource::getLoginSourceByloginSourceId($this->mysqli, $this->loginSource->loginSourceId);
		$this->assertNull($hopefulLoginSource);

	}

	// test grabbing the LoginSource from mySQL
	public function testGetLoginSource()
	{
		// first, verify mySQL connected OK
		$this->assertNotNull($this->mysqli);

		// second, create a LoginSource to post to mySQL
		$this->loginSource = new LoginSource(null, $this->sourceName, $this->apiKey);

		// third, insert the loginSource to mySQL
		$this->loginSource->insert($this->mysqli);

		// fourth, get the class by the static method
		$staticUser = LoginSource::getLoginSourceByLoginSourceId($this->mysqli, $this->loginSource->getLoginSourceId());

		// compare the fields

		$this->assertNotNull($staticUser->getLoginSourceId());
		$this->assertTrue($staticUser->getLoginSourceId() > 0);
		$this->assertNotNull($staticUser->getSourceName());
		$this->assertIdentical($staticUser->getSourceName(), $this->sourceName);
		$this->assertNotNull($staticUser->getApiKey());
		$this->assertIdentical($staticUser->getApiKey(), $this->apiKey);
	}
}

