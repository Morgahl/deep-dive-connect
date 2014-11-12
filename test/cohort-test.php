<?php

/*** Unit Test for Cohort Class Capstone project
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
require_once("../php/cohort.php");

//require the mysqli connection object
require_once("/etc/apache2/capstone-mysql/ddconnect.php");

//the cohortTest below will be a container for all our tests
//TODO: Enter correct "global" variables-Start and end dates with correct formats
class cohortTest extends UnitTestCase {
         // variable to hold the mySQL connection
         private $mysqli = null;

         // variable to hold the test database row
         private $cohort   = null;

         // a few "global" variables for creating test data
         private $COHORTID       = null;
         private $STARTDATE      = "2014-30-09 16:16:16";
         private $ENDDATE        = "2014-30-11 16:16:16";
         private $LOCATION       = "Albuquerque";
         private $DESCRIPTION    = "I am a Deep Dive Alum";

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
         if($this->cohort !== null) {
            $this->cohort->delete($this->mysqli);
            $this->cohort = null;
         }
      }

      // Disconnect removed from previous iteration of Unit Test

      // test creating a new User and inserting it to mySQL
      public function testInsertNewCohort() {

      // first, verify mySQL connected OK
      $this->assertNotNull($this->mysqli);

      // second, create a cohort to post to mySQL
      $this->cohort = new Cohort(null,$this->STARTDATE,$this->ENDDATE,$this->LOCATION, $this->DESCRIPTION);

      // third, insert the user to mySQL
      $this->cohort->insert($this->mysqli);

      // finally, compare the fields
      $this->assertNotNull($this->cohort->getCohortId());
      $this->assertTrue($this->cohort->getCohortId() > 0);
      $this->assertIdentical($this->cohort->getStartDate(),         $this->STARTDATE);
      $this->assertIdentical($this->cohort->getEndDate(),            $this->ENDDATE);
      $this->assertIdentical($this->cohort->getLocation(),                $this->LOCATION);
      $this->assertIdentical($this->cohort->getDescription(),     $this->DESCRIPTION);
   }

   /*
   // test updating a User in mySQL
   public function testUpdateUser() {
      // first, verify mySQL connected OK
      $this->assertNotNull($this->mysqli);

      // second, create a user to post to mySQL
      $this->user = new User(null);

      // third, insert the user to mySQL
      $this->user->insert($this->mysqli);

      // fourth, update the user and post the changes to mySQL

      $this->user->setEmail($newEmail);
      $this->user->update($this->mysqli);

      // finally, compare the fields
      $this->assertNotNull($this->user->getUserId());
      $this->assertTrue($this->user->getUserId() > 0);
      $this->assertIdentical($this->user->getEmail(),               $newEmail);
      $this->assertIdentical($this->user->getPassword(),            $this->HASH);
      $this->assertIdentical($this->user->getSalt(),                $this->SALT);
      $this->assertIdentical($this->user->getAuthenticationToken(), $this->AUTH_TOKEN);
   }

   // test deleting a User
   public function testDeleteUser() {
      // first, verify mySQL connected OK
      $this->assertNotNull($this->mysqli);

      // second, create a user to post to mySQL
      $this->user = new User(null);

      // third, insert the user to mySQL
      $this->user->insert($this->mysqli);

      // fourth, verify the User was inserted
      $this->assertNotNull($this->user->getUserId());
      $this->assertTrue($this->user->getUserId() > 0);

      // fifth, delete the user
      $this->user->delete($this->mysqli);
      $this->user = null;

      // finally, try to get the user and assert we didn't get a thing
      $hopefulUser = User::getUserByEmail($this->mysqli, $this->EMAIL);
      $this->assertNull($hopefulUser);
   }

   // test grabbing a User from mySQL
   public function testGetUserByEmail() {
      // first, verify mySQL connected OK
      $this->assertNotNull($this->mysqli);

      // second, create a user to post to mySQL
      $this->user = new User(null, $this->EMAIL, $this->HASH, $this->SALT, $this->AUTH_TOKEN);

      // third, insert the user to mySQL
      $this->user->insert($this->mysqli);

      // fourth, get the user using the static method
      $staticUser = User::getUserByEmail($this->mysqli, $this->EMAIL);

      // finally, compare the fields
      //cohort
      $this->assertNotNull($staticUser->getUserId());
      $this->assertTrue($staticUser->getUserId() > 0);
      $this->assertIdentical($staticUser->getUserId(),              $this->user->getUserId());
      $this->assertIdentical($staticUser->getEmail(),               $this->EMAIL);
      $this->assertIdentical($staticUser->getPassword(),            $this->HASH);
      $this->assertIdentical($staticUser->getSalt(),                $this->SALT);
      $this->assertIdentical($staticUser->getAuthenticationToken(), $this->AUTH_TOKEN);



      //manual trash collection
      $newCohorts = null;

   } */
}
?>





