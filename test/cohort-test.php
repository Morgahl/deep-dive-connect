<?php
/**
 * Unit Test for Cohort Class
 *
 * Created by Gerardo Medrano adapted from Steven Chavez, Marc Hayes,
 *  et al.
 * User:  G Medrano
 * Date: 11/12/2014
 * Time: 2:26 PM
 **/


/**
 *
 *
 *
 **/

//require the SimpleTest Framework
require_once("/usr/lib/php5/simpletest/autorun.php");
require_once("/etc/apache2/capstone-mysql/ddconnect.php");


//require the class under scrutiny; TO DO fill in second require once below if needed
require_once("../php/cohort.php");
require_once(" needed???");

//the UserTest is a container for all our tests
class UserTest extends UnitTestCase {
         // variable to hold the mySQL connection
         private $mysqli = null;
         // variable to hold the test database row
         private $user   = null;

         // a few "global" variables for creating test data
         private $COHORTID       = "unit-test@example.net";
         private $STARTDATE      = "ChedGeek5";
         private $ENDDATE        = null;
         private $LOCATION       = null;
         private $DESCRPTION     = null;

   // setUp() is a method that is run before each test
   // here, we use it to connect to mySQL and to calculate the salt, hash, and authenticationToken
   public function setUp() {
      // connect to mySQL
      mysqli_report(MYSQLI_REPORT_STRICT);
      $this->mysqli = new mysqli("localhost", "store_dylan", "deepdive", "store_dylan");

      // randomization needed???
      //$this->SALT       = bin2hex(openssl_random_pseudo_bytes(32));

      // tearDown() is a method that is run after each test
      // here, we use it to delete the test record and disconnect from mySQL
      public function tearDown() {
         // delete the user if we can
         if($this->user !== null) {
            $this->user->delete($this->mysqli);
            $this->user = null;
         }

         // disconnect from mySQL
         if($this->mysqli !== null) {
            $this->mysqli->close();
         }
      }

   }






}