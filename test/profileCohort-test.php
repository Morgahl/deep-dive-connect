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

//require the classes under scrutiny
require_once("../php/profileCohort.php");
require_once("../php/profile.php");
require_once("../php/cohort.php");
require_once("../php/user.php");

//require the mysqli connection object
require_once("/etc/apache2/capstone-mysql/ddconnect.php");

//the ProfileCohortTest below will be a container for all our tests
class ProfileCohortTest extends UnitTestCase {
   // variable to hold the mySQL connection
   private $mysqli = null;

   // variables to hold the test database row
   private $cohort   = null;
   private $profileCohort = null;
   private $profile = null;
   private $user = null;

   // a few "global" variables for creating test data
   private $USERID         = null;
   private $PROFILEID      = null;
   private $COHORTID     	= null;
   private $ROLE       		= "Student";


   // setUp() is a method that is run before each test
   public function setUp(){

      // connect to mySQLi
      $this->mysqli = MysqliConfiguration::getMysqli();

      // create new user object, including profile
      $this->user = new User(null, "jack@chan.com", null, null, null, 1, 1);
      $this->user->insert($this->mysqli);
      $this->USERID = $this->user->getUserId();
      $this->profile = new Profile(null,$this->USERID,"Sancho","Ming",null,"Hull","Hull","Hull","jpeg");
      $this->profile->insert($this->mysqli);
      $this->PROFILEID =$this->profile->getProfileId();
      $this->cohort = new Cohort(null,"2014-09-30 16:16:16", "2014-11-30 16:16:16",null, null);
      $this->cohort->insert($this->mysqli);
      $this->COHORTID = $this->cohort->getCohortId();
   }



   // If randomization were needed, would appear as per sample below:
   // "$this->SALT       = bin2hex(openssl_random_pseudo_bytes(32));"



   // tearDown() is a method that is run after each test
   // here, we use it to delete the test record and disconnect from mySQL
   public function tearDown() {
      // delete the profile Cohort if we can
      if($this->profileCohort !== null) {
         $this->profileCohort->delete($this->mysqli);
         $this->profileCohort = null;
      }

      //delete the cohort
      if($this->cohort !== null) {
         $this->cohort->delete($this->mysqli);
         $this->cohort = null;
      }

      //delete the profile
      if($this->profile !== null) {
         $this->profile->delete($this->mysqli);
         $this->profile = null;

      }

      //delete the user
      if($this->user !== null) {
         $this->user->delete($this->mysqli);
         $this->user = null;

      }

      //resetting back to null
      $this->USERID        = null;
      $this->PROFILEID     = null;
      $this->COHORTID      = null;
   }

   // Disconnect function removed from previous iteration of Unit Test template

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
      $this->assertIdentical($this->profileCohort->getProfileId(),       	$this->PROFILEID);
      $this->assertIdentical($this->profileCohort->getCohortId(),          $this->COHORTID);
      $this->assertIdentical($this->profileCohort->getRole(),       	      $this->ROLE);
      
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
      $this->profileCohort->setRole($newRole);
      $this->profileCohort->update($this->mysqli);

      //finally, compare the fields
      $this->assertNotNull($this->profileCohort->getProfileCohortId());
      $this->assertTrue($this->profileCohort->getProfileCohortId() > 0);
      $this->assertIdentical($this->profileCohort->getProfileId(),         $this->PROFILEID);
      $this->assertIdentical($this->profileCohort->getCohortId(),     	   $this->COHORTID);
      $this->assertIdentical($this->profileCohort->getRole(),        		$newRole);


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
      $hopefulProfileCohort = ProfileCohort::getAttendeesByRole($this->mysqli, $this->ROLE);
      $this->assertNull($hopefulProfileCohort);
   }





   //test grabbing cohort by ProfileId from mySQL
   public function testGetCohortByProfileId() {
      //first, verify mySQL connected OK
      $this->assertNotNull($this->mysqli);

      //second, create a profileCohort to post to mySQL
      $this->profileCohort = new ProfileCohort(null,$this->PROFILEID,$this->COHORTID,$this->ROLE);

      //third, insert the profileCohort to mySQL
      $this->profileCohort->insert($this->mysqli);

      //fourth, get the profileCohortId using the static method
      $staticProfileCohort = ProfileCohort::getCohortByProfileId ($this->mysqli, $this->PROFILEID);

      //finally, compare the fields
      $this->assertNotNull($staticProfileCohort[0]->getProfileCohortId());
      $this->assertTrue($staticProfileCohort[0]->getProfileCohortId() > 0);
      $this->assertIdentical($staticProfileCohort[0]->getProfileId(),       $this->PROFILEID);
      $this->assertIdentical($staticProfileCohort[0]->getCohortId(),         	$this->COHORTID);
      $this->assertIdentical($staticProfileCohort[0]->getRole(),        		$this->ROLE);
   }

   //test grabbing Cohort Attendees by Role
   public function testGetAttendeesByRole() {
      //first, verify mySQL connected OK
      $this->assertNotNull($this->mysqli);

      //second, create a profileCohort to post to mySQL
      $this->profileCohort = new ProfileCohort(null,$this->PROFILEID,$this->COHORTID,$this->ROLE);

      //third, insert the profileCohort to mySQL
      $this->profileCohort->insert($this->mysqli);

      //fourth, get attendees using the static method
      $staticProfileCohort = ProfileCohort::getAttendeesByRole($this->mysqli, $this->ROLE);

      //finally, compare the fields
      $this->assertNotNull($staticProfileCohort[0]->getProfileCohortId());
      $this->assertTrue($staticProfileCohort[0]->getProfileCohortId() > 0);
      $this->assertIdentical($staticProfileCohort[0]->getProfileId(),       $this->PROFILEID);
      $this->assertIdentical($staticProfileCohort[0]->getCohortId(),         	$this->COHORTID);
      $this->assertIdentical($staticProfileCohort[0]->getRole(),        		$this->ROLE);
   }

   //test grabbing Cohort attendees by Cohort
   public function testGetAttendeesByCohort() {
      //first, verify mySQL connected OK
      $this->assertNotNull($this->mysqli);

      //second, create a profileCohort to post to mySQL
      $this->profileCohort = new ProfileCohort(null,$this->PROFILEID,$this->COHORTID,$this->ROLE);

      //third, insert the profileCohort to mySQL
      $this->profileCohort->insert($this->mysqli);

      //fourth, get the Attendees by Cohort using the static method
      $staticProfileCohort = ProfileCohort::getAttendeesByCohort($this->mysqli, $this->COHORTID);

      //finally, compare the fields
      $this->assertNotNull($staticProfileCohort[0]->getProfileCohortId());
      $this->assertTrue($staticProfileCohort[0]->getProfileCohortId() > 0);
      $this->assertIdentical($staticProfileCohort[0]->getProfileId(),       $this->PROFILEID);
      $this->assertIdentical($staticProfileCohort[0]->getCohortId(),         	$this->COHORTID);
      $this->assertIdentical($staticProfileCohort[0]->getRole(),        		$this->ROLE);
   }

}

?>





