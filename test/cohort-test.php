<?php

/*** Unit Test for Cohort Class Capstone project
 *
 * Created by Gerardo Medrano adapted from Steven Chavez, Marc Hayes,
 *  et al.
 * @author G Medrano gmedranocode@gmail.com
 * Date: 11/12/2014
 * Time: 2:26 PM
 **/

//require the SimpleTest Framework;
require_once("/usr/lib/php5/simpletest/autorun.php");

//require the class under scrutiny
require_once("../php/cohort.php");

//require the mysqli connection object
require_once("/etc/apache2/capstone-mysql/ddconnect.php");

//the cohortTest below will be a container for all our tests
//TODO: Enter correct "global" variables-Start and end dates with correct formats
class cohortTest extends UnitTestCase {
   // variable to hold the mySQL connection
   private $mysqli = null;

   // variable to hold the test database row
   private $cohort = null;

   // a few "global" variables for creating test data
   private $STARTDATE = "2014-09-30 16:16:16";
   private $ENDDATE = "2014-11-30 16:16:16";
   private $LOCATION = "Albuquerque";
   private $DESCRIPTION = "I am a Deep Dive Alum";

   // setUp() is a method that is run before each test
   public function setUp() {

      // connect to mySQLi

      $this->mysqli = MysqliConfiguration::getMysqli();
   }

   // If randomization were needed, would appear as per sample below:
   // $this->SALT       = bin2hex(openssl_random_pseudo_bytes(32));


   // tearDown() is a method that is run after each test
   // here, we use it to delete the test record and disconnect from mySQL
   public function tearDown() {
      // delete the cohort if we can
      if($this->cohort !== null) {
         $this->cohort->delete($this->mysqli);
         $this->cohort = null;
      }
   }

   // Disconnect removed from previous iteration of Unit Test


   // test creating a new Cohort and inserting it to mySQL
   public function testInsertNewCohort() {

      // first, verify mySQL connected OK
      $this->assertNotNull($this->mysqli);

      // second, create a cohort to post to mySQL
      $this->cohort = new Cohort(null, $this->STARTDATE, $this->ENDDATE, $this->LOCATION, $this->DESCRIPTION);

      // third, insert the cohort to mySQL
      $this->cohort->insert($this->mysqli);

      //convert date time objects prior to assertion, converts dates to strings

      if($this->STARTDATE === null) {
         $startDate = null;
      } else {
         $startDate = DateTime::createFromFormat("Y-m-d H:i:s", $this->STARTDATE);
      }

      if($this->ENDDATE === null) {
         $endDate = null;
      } else {
         $endDate = DateTime::createFromFormat("Y-m-d H:i:s", $this->ENDDATE);
      }

      // finally, compare the fields
      $this->assertNotNull($this->cohort->getCohortId());
      $this->assertTrue($this->cohort->getCohortId() > 0);
      $this->assertIdentical($this->cohort->getStartDate(), $startDate);
      $this->assertIdentical($this->cohort->getEndDate(), $endDate);
      $this->assertIdentical($this->cohort->getLocation(), $this->LOCATION);
      $this->assertIdentical($this->cohort->getDescription(), $this->DESCRIPTION);
   }

   //test updating Cohort in mySQL
   public function testUpdateCohort() {
      // first, verify mySQL connected OK
      $this->assertNotNull($this->mysqli);

      //second, create a cohort to post to mySQL
      $this->cohort = new Cohort(null, $this->STARTDATE, $this->ENDDATE, $this->LOCATION, $this->DESCRIPTION);

      //third, insert the cohort to mySQL
      $this->cohort->insert($this->mysqli);

      //fourth, update the cohort and post the changes to mySQL
      //using the location field
      $newLocation = "Romulus";
      $this->cohort->setLocation($newLocation);
      $this->cohort->update($this->mysqli);

      //convert date time objects prior to assertion, converts dates to strings

      if($this->STARTDATE === null) {
         $startDate = null;
      } else {
         $startDate = DateTime::createFromFormat("Y-m-d H:i:s", $this->STARTDATE);
      }

      if($this->ENDDATE === null) {
         $endDate = null;
      } else {
         $endDate = DateTime::createFromFormat("Y-m-d H:i:s", $this->ENDDATE);
      }

      //finally, compare the fields
      $this->assertNotNull($this->cohort->getCohortId());
      $this->assertTrue($this->cohort->getCohortId() > 0);
      $this->assertIdentical($this->cohort->getStartDate(), $startDate);
      $this->assertIdentical($this->cohort->getEndDate(), $endDate);
      $this->assertIdentical($this->cohort->getLocation(), $newLocation);
      $this->assertIdentical($this->cohort->getDescription(), $this->DESCRIPTION);

   }

   //test deleting a cohort
   public function testDeleteCohort() {
      //first, verify mySQL, connected OK
      $this->assertNotNull($this->mysqli);

      //second, create a cohort to post to mySQL
      $this->cohort = new Cohort(null, $this->STARTDATE, $this->ENDDATE, $this->LOCATION, $this->DESCRIPTION);

      //third, insert the cohort to mySQL
      $this->cohort->insert($this->mysqli);

      //fourth, verify the cohort was inserted
      $this->assertNotNull($this->cohort->getCohortId());
      $this->assertTrue($this->cohort->getCohortId() > 0);

      //fifth, delete the cohort
      $this->cohort->delete($this->mysqli);

      //finally, get the cohort and assert for a null
      $hopefulCohort = Cohort::getCohortByCohortId($this->mysqli, $this->cohort->getCohortId());
      $this->assertNull($hopefulCohort);
   }


   //test grabbing cohortId from mySQL
   public function testGetCohortByCohortId() {
      //first, verify mySQL connected OK
      $this->assertNotNull($this->mysqli);

      //second, create a cohort to post to mySQL
      $this->cohort = new Cohort(null, $this->STARTDATE, $this->ENDDATE, $this->LOCATION, $this->DESCRIPTION);

      //third, insert the cohort to mySQL
      $this->cohort->insert($this->mysqli);

      //fourth, get the cohort using the static method
      $staticCohort = Cohort::getCohortByCohortId($this->mysqli, $this->cohort->getCohortId());

      //convert date time objects prior to assertion, converts dates to strings

      if($this->STARTDATE === null) {
         $startDate = null;
      } else {
         $startDate = DateTime::createFromFormat("Y-m-d H:i:s", $this->STARTDATE);
      }

      if($this->ENDDATE === null) {
         $endDate = null;
      } else {
         $endDate = DateTime::createFromFormat("Y-m-d H:i:s", $this->ENDDATE);
      }

      //finally, compare the fields
      $this->assertNotNull($staticCohort[0]->getCohortId());
      $this->assertTrue($staticCohort[0]->getCohortId() > 0);
      $this->assertIdentical($staticCohort[0]->getStartDate(), $startDate);
      $this->assertIdentical($staticCohort[0]->getEndDate(), $endDate);
      $this->assertIdentical($staticCohort[0]->getDescription(), $this->DESCRIPTION);
      $this->assertIdentical($staticCohort[0]->getLocation(), $this->LOCATION);

   }

      //test grabbing Start Date from mySQL
      public function testGetCohortStartDate() {
         //first, verify mySQL connected OK
         $this->assertNotNull($this->mysqli);

         //second, create a cohort to post to mySQL
         $this->cohort = new Cohort(null, $this->STARTDATE, $this->ENDDATE, $this->LOCATION, $this->DESCRIPTION);

         //third, insert the cohort to mySQL
         $this->cohort->insert($this->mysqli);

         //fourth, get the cohort using the static method
         $staticCohort = Cohort::getCohortStartDate($this->mysqli, $this->STARTDATE);

         //fifth, convert date time objects, start date and end date, prior to assertion, converts dates to strings
         if($this->STARTDATE === null) {
            $startDate = null;
         } else {
            $startDate = DateTime::createFromFormat("Y-m-d H:i:s", $this->STARTDATE);
         }

         if($this->ENDDATE === null) {
            $endDate = null;
         } else {
            $endDate = DateTime::createFromFormat("Y-m-d H:i:s", $this->ENDDATE);
         }

         //finally, compare the fields
         $this->assertNotNull($staticCohort[0]->getCohortId());
         $this->assertTrue($staticCohort[0]->getCohortId() > 0);
         $this->assertIdentical($staticCohort[0]->getStartDate(), $startDate);
         $this->assertIdentical($staticCohort[0]->getEndDate(), $endDate);
         $this->assertIdentical($staticCohort[0]->getDescription(), $this->DESCRIPTION);
         $this->assertIdentical($staticCohort[0]->getLocation(), $this->LOCATION);


         }
   }

?>





