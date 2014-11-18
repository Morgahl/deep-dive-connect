<?php

/*** Unit Test for ProfileCohort Class Capstone project
 *
 * Created by Gerardo Medrano adapted from Steven Chavez, Marc Hayes,
 *  et al.
 * @author G Medrano
 * Date: 11/12/2014
 * Time: 2:26 PM
 **/

//require the SimpleTest Framework;
require_once("/usr/lib/php5/simpletest/autorun.php");

//require the class under scrutiny
require_once("../php/profileCohort.php");

//require the mysqli connection object
require_once("/etc/apache2/capstone-mysql/ddconnect.php");

//the ProfileCohortTest below will be a container for all our tests
class ProfileCohortTest extends UnitTestCase {
   // variable to hold the mySQL connection
   private $mysqli = null;

   // variable to hold the test database row
   private $cohort   = null;

   // a few "global" variables for creating test data
   private $PROFILEID      = null;
   private $COHORTID     	= null;
   private $ROLE       		= "Student";


   // setUp() is a method that is run before each test
   public function setUp(){

      // connect to mySQLi

      $this->mysqli = MysqliConfiguration::getMysqli();
   }

   // If randomization were needed, would appear as per sample below:
   // $this->SALT       = bin2hex(openssl_random_pseudo_bytes(32));


   // tearDown() is a method that is run after each test
   // here, we use it to delete the test record and disconnect from mySQL
   public function tearDown() {
      // delete the user if we can
      if($this->profileCohort !== null) {
         $this->profileCohort->delete($this->mysqli);
         $this->profileCohort = null;
      }
   }

   // Disconnect removed from previous iteration of Unit Test


   // test creating a new User and inserting it to mySQL
   public function testInsertNewProfileCohort() {

      // first, verify mySQL connected OK
      $this->assertNotNull($this->mysqli);

      // second, create a ProfileCohort to post to mySQL
      $this->profileCohort = new ProfileCohort(null,$this->PROFILEID,$this->COHORTID,$this->ROLE);

      // third, insert the user to mySQL
      $this->profileCohort->insert($this->mysqli);

      // finally, compare the fields   
      $this->assertNotNull($this->profileCohort->getProfileCohortId());
      $this->assertTrue($this->profileCohort->getProfileCohortId() > 0);
      $this->assertIdentical($this->cohort->getProfileId(),       	$this->PROFILEID);
      $this->assertIdentical($this->cohort->getCohortId(),        $this->COHORTID);
      $this->assertIdentical($this->cohort->getRole(),       	 $this->ROLE);
      
   }

   //test updating profileCohort in mySQL
   public function testUpdateProfileCohort() {
      // first, verify mySQL connected OK
      $this->assertNotNull($this->mysqli);

      //second, create a ProfileCohort to post to mySQL
      $this->profileCohort = new ProfileCohort(null,$this->PROFILEID,$this->COHORTID,$this->ROLE);

      //third, insert the ProfileCohort to mySQL
      $this->profileCohort->insert($this->mysqli);

      //fourth, update the ProfileCohort and post the changes to mySQL
      //using the Role field
      $newRole = "Bohemian";
      $this->profiileCohort->setRole($newRole);
      $this->profileCohort->update($this->mysqli);


      //finally, compare the fields
      $this->assertNotNull($this->profileProfileCohort->getProfileCohortId());
      $this->assertTrue($this->profileProfileCohort->getProfileCohortId() > 0);
      $this->assertIdentical($this->profileCohort->getProfileId(),         $this->PROFILEID);
      $this->assertIdentical($this->profileCohort->getCohortId(),     	   $this->COHORTID);
      $this->assertIdentical($this->cohort->getRole(),        		         $newRole);


   }

   //test deleting a profileCohort
   public function testDeleteProfileCohort() {
      //first, verify mySQL connected OK
      $this->assertNotNull($this->mysqli);

      //second, create a cohort to post to mySQL
      $this->profileCohort = new ProfileCohort(null,$this->PROFILEID,$this->COHORTID,$this->ROLE);

      //third, insert the user to mySQL
      $this->profileCohort->insert($this->mysqli);

      //fourth, verify the profileCohort was inserted
      $this->assertNotNull($this->profileCohort->getProfileCohortId());
      $this->assertTrue($this->profileCohort->getProfileCohortId() > 0);

      //fifth, delete the profileCohort
      $this->profileCohort->delete($this->mysqli);
      $this->profileCohort = null;

      //finally, get the cohort and assert for a null
      $hopefulProfileCohort = ProfileCohort::getProfileCohortByRole($this->mysqli, $this->ROLE);
      $this->assertNull($hopefulCohort);
   }

   //test grabbing cohort from mySQL
   public function testGetCohortByRole() {
      //first, verify mySQL connected OK
      $this->assertNotNull($this->mysqli);

      //second, create a profileCohort to post to mySQL
      $this->profileCohort = new ProfileCohort(null,$this->PROFILEID,$this->COHORTID,$this->ROLE);

      //third, insert the profileCohort to mySQL
      $this->profileCohort->insert($this->mysqli);

      //fourth, get the profileCohort using the static method
      $staticProfileCohort = ProfileCohort::getProfileCohortByRole ($this->mysqli, $this->ROLE);

      //finally, compare the fields
      $this->assertNotNull($staticProfileCohort->getProfileCohortId());
      $this->assertTrue($this->profileCohort->getProfileCohortId() > 0);
      $this->assertIdentical($this->profileCohort->getProfileId(),       $this->PROFILEID);
      $this->assertIdentical($this->cohort->getCohortId(),         	$this->COHORTID);
      $this->assertIdentical($this->cohort->getRole(),        		$this->ROLE);

      //manual trash collection
      $newCohorts = null;

   }
}

?>





