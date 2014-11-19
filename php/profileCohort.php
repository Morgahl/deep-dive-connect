<?php

/**
 * This a container for profileCohort class
 *
 * This class will identify elements of profileCohort class to link to Deep Dive Coders Alumni Site
 * @author G Medrano, adapted from template by Dylan McDonald
 *
 * Date: 11/9/2014
 * Time: 4:12 PM
 **/

class profileCohort {
   //profileCohortID is the private key
   private $profileCohortId;

   //names cohortId for alum
   private $cohortId;

   //names ProfileId for alum
   private $profileId;

   //names role of alum
   private $role;

   /**
    * constructor for ProfileCohort below
    *
      @param string $newProfileCohortId Profile Cohort Id integer/number
    * @param string $newCohortId Cohort Id integer/number
    * @param string $newProfileId Profile Id integer/number
    * @param string $newRole indicates current job role or status of alum
    * @throws UnexpectedValueException when a parameter is wrong type
    * @throws RangeException when a parameter is invalid
    */
   public function __construct($newProfileCohortId, $newProfileId, $newCohortId, $newRole) {
      try {
         $this->setProfileCohortId($newProfileCohortId);
         $this->setProfileId($newProfileId);
         $this->setCohortId($newCohortId);
         $this->setRole($newRole);

      } catch(UnexpectedValueException $unexpectedValue) {
         // rethrow to the seller
         throw(new UnexpectedValueException("Unable to construct Profile Cohort", 0, $unexpectedValue));

      } catch(RangeException $range) {
         // rethrow to the caller
         throw(new RangeException("Unable to construct Profile Cohort", 0, $range));
      }
   }

   //gets value of ProfileCohortId
   //returns mixed ProfileCohortId
   public function getProfileCohortId() {
      return ($this->profileCohortId);
   }
   //set ProfileCohortId
   /**
    * @param $newProfileCohortId
    */
   public function setProfileCohortId($newProfileCohortId) {
      if($newProfileCohortId === null) {
         $this->profileCohortId = null;
         return;
      }
      //filter_var for ProfileCohortId
      if(filter_var($newProfileCohortId, FILTER_VALIDATE_INT) === false) {
         throw(new UnexpectedValueException("Profile Cohort Id $newProfileCohortId is not numeric"));
      }
      //convert the ProfileCohortId to an integer and enforce it is positive
      $newProfileCohortId = intval($newProfileCohortId);
      if($newProfileCohortId <= 0) {
         throw(new RangeException("Profile Cohort Id $newProfileCohortId is not positive"));
      }
      //take the Profile Cohort Id out of quarantine
      $this->profileCohortId = $newProfileCohortId;
   }


   //gets value of ProfileId
   //returns mixed ProfileId
   public function getProfileId() {
      return ($this->profileId);
   }
   //**set the value of ProfileId**/
   public function setProfileId($newProfileId) {
      if($newProfileId === null) {
         $this->profileId = null;
         return;
      }

      //filter_var for ProfileId
      if(filter_var($newProfileId, FILTER_VALIDATE_INT) === false) {
         throw(new UnexpectedValueException("Profile Id $newProfileId is not numeric"));
      }

      //convert the ProfileCohortId to an integer and enforce it is positive
      $newProfileId = intval($newProfileId);
      if($newProfileId <= 0) {
         throw(new RangeException("Profile Id $newProfileId is not positive"));
      }

      //take the Profile Cohort Id out of quarantine
      $this->profileId = $newProfileId;
   }

   //gets value of CohortId
   public function getCohortId() {
      return ($this->cohortId);
   }
   //set CohortId
   public function setCohortId($newCohortId) {
      if($newCohortId === null) {
         $this->cohortId = null;
         return;
      }
      //filter_var for CohortId
      if(filter_var($newCohortId, FILTER_VALIDATE_INT) === false) {
         throw(new UnexpectedValueException("Cohort Id $newCohortId is not numeric"));
      }
      //convert the CohortId to an integer and enforce it is positive
      $newCohortId = intval($newCohortId);
      if($newCohortId <= 0) {
         throw(new RangeException("Profile Id $newCohortId is not positive"));
      }
         //take the Profile CohortId out of quarantine
         $this->cohortId = $newCohortId;
   }


   //Get and Set for role
   public function getRole() {
      return ($this->role);
   }
   public function setRole($newRole) {
      $newRole = trim($newRole);
      // filter the role as a generic string
      $newRole = filter_var($newRole, FILTER_SANITIZE_STRING);

      // then just take the role out of quarantine

      $this->role = $newRole;
   }

   /**
    * Insert profileCohort to mySQL
    * @param mysqli_sql_exception-mySql related errors occur
    *
    **/
   public function insert(&$mysqli) {

      if(gettype($mysqli) !== "object" || get_class($mysqli) !== "mysqli") {
         throw(new mysqli_sql_exception("input is not a mysqli object"));
      }

      //enforce the Profile Cohort ID is null
      if($this->profileCohortId !== null) {
         throw(new mysqli_sql_exception("input is not a mysqli object"));
      }

      //create a query template - into ProfileCohort
      $query = "INSERT INTO profileCohort(profileCohortId,cohortId, profileId, role) VALUES(?,?,?,?)";
      $statement = $mysqli->prepare($query);
      if($statement === false) {
         throw(new mysqli_sql_exception("Unable to prepare statement"));
      }

      //bind the member variables to place holders in template
      $wasClean = $statement->bind_param("iiis",$this->profileCohortId, $this->profileId, $this->cohortId, $this->role);
      if($wasClean === false) {
         throw(new mysqli_sql_exception("Unable to bind parameters"));
      }

      //execute the statement
      if($statement->execute() === false) {
         var_dump($statement);
         throw(new mysqli_sql_exception("Unable to execute mySQL statement"));
      }

      // update the null Profile Cohort Id with Mysql output
      $this->profileCohortId = $mysqli->insert_id;
}

   /**
    * deletes ProfileCohort from mySQL
    *
    * @param resource $mysqli pointer to mySQL connection, by reference
    * @throws mysqli_sql_exception when mySQL related errors occur
    *
    **/

   public function delete(&$mysqli) {
      //handle degenerate cases
      if(gettype($mysqli) !== "object" || get_class($mysqli) !== "mysqli") {
         throw(new mysqli_sql_exception("input is not a mysqli object"));
      }

      //enforce profileCohort Id is null
      if($this->profileCohortId === null) {
         throw(new mysqli_sql_exception("Unable to prepare a cohortId"));
      }


      //create a query template for Cohort ID
      $query      =  "DELETE FROM profileCohort where profileCohortId = ?";
      $statement  =  $mysqli ->prepare($query);
      if($statement === false) {
         throw(new mysqli_sql_exception("Unable to prepare statement"));
      }

      //bind the member variables to place holders in template
      $wasClean = $statement->bind_param("i", $this->profileCohortId);
      if($wasClean === false) {
         throw(new mysqli_sql_exception("Unable to bind parameters"));
      }


      //execute the statement
      if($statement->execute() === false) {
         throw(new mysqli_sql_exception("Unable to execute mySQL statement"));
      }
   }

   /**
   * updates nulls with Mysql output
   *
   * @param resource $mysqli pointer to mySQL connection, by reference
   * @throws mysqli_sql_exception when mySQL related errors occur
   *
   **/
      public function update(&$mysqli) {

         // handle degenerate class
         if(gettype($mysqli) !== "object" || get_class($mysqli) !== "mysqli") {
            throw(new mysqli_sql_exception("input is not a mysqli object"));
         }

      //enforce Cohort ID is not null
         if($this->cohortId === null) {
            throw(new mysqli_sql_exception("unable to update cohort information that does not exist"));
         }

      //create a query template for cohortId
      $query      =  "UPDATE profileCohort SET profileId = ?, cohortId = ?,role = ? WHERE profileCohortId = ?";
      $statement  =  $mysqli ->prepare($query);
         if($statement === false) {
            throw(new mysqli_sql_exception("Unable to prepare statement"));
         }

      //bind the member variables to place holders in template profileCohortId, profileId, cohortId, role
      $wasClean = $statement->bind_param("iisi",$this->profileId, $this->cohortId,
                                                $this->role, $this->profileCohortId);
         if($wasClean === false) {
            throw(new mysqli_sql_exception("Unable to bind parameters"));

         }

      //execute the statement
      if($statement->execute() === false) {
         throw(new mysqli_sql_exception("Unable to execute mySQL statement"));
         }

}

   /**
    * gets List of Cohort by ProfileId
    *
    * @param resource $mysqli pointer to mySQL connection, by reference
    * @return null
    * @throws mysqli_sql_exception when mySQL related errors occur
    *
    **/
   public static function getCohortByProfileId(&$mysqli, $profileId) {
      // handle degenerate cases
      if(gettype($mysqli) !== "object" || get_class($mysqli) !== "mysqli") {
         throw(new mysqli_sql_exception("input is not a mysqli object"));
      }

      // sanitize the description before searching
      $profileId = trim($profileId);
      $profileId = filter_var($profileId, FILTER_SANITIZE_NUMBER_INT);

      // create query template for profileId
      $query     =   "SELECT profileCohortId, profileId, cohortId, role FROM profileCohort WHERE profileId = ?";
      $statement =   $mysqli->prepare($query);
      if($statement === false) {
         throw(new mysqli_sql_exception("Unable to prepare statement"));
      }

      // bind the member variables to the place holders in the template
      $wasClean = $statement->bind_param("i",$profileId);
      if($wasClean === false) {
         throw(new mysqli_sql_exception("Unable to bind parameters"));
      }

      // execute the statement
      if($statement->execute() === false) {
         throw(new mysqli_sql_exception("Unable to execute mySQL statement"));
      }

      // get results
      $results = $statement->get_result();
      if($results->num_rows > 0) {
         // retrieve results in bulk into an array
         $results = $results->fetch_all(MYSQL_ASSOC);
         if($results === false) {
            throw(new mysqli_sql_exception("Unable to process result set"));
         }

         // step through results array and convert to ProfileCohort objects
         foreach ($results as $index => $row) {
            $results[$index] = new ProfileCohort($row["profileCohortId"], $row["profileId"], $row["cohortId"], $row["role"]);
         }

         // return resulting array of ProfileCohort objects
         return($results);
      } else {
         return(null);
      }
   }

      /**
       * gets List of Cohort Attendees by cohortId
       *
       * @param resource $mysqli pointer to mySQL connection, by reference
       * @return null
       * @throws mysqli_sql_exception when mySQL related errors occur
       *
       **/
         public static function getAttendeesByCohort(&$mysqli, $cohortId) {
            // handle degenerate cases
            if(gettype($mysqli) !== "object" || get_class($mysqli) !== "mysqli") {
               throw(new mysqli_sql_exception("input is not a mysqli object"));
         }

         // sanitize the description before searching
         $cohortId = trim($cohortId);
         $cohortId = filter_var($cohortId, FILTER_SANITIZE_NUMBER_INT);

         // create query template for cohortId
         $query     =   "SELECT profileCohortId, profileId, cohortId, role FROM profileCohort WHERE cohortId = ?";
         $statement =   $mysqli->prepare($query);
         if($statement === false) {
            throw(new mysqli_sql_exception("Unable to prepare statement"));
         }

         // bind the member variables to the place holders in the template
         $wasClean = $statement->bind_param("i",$cohortId);
         if($wasClean === false) {
            throw(new mysqli_sql_exception("Unable to bind parameters"));
         }

         // execute the statement
         if($statement->execute() === false) {
            throw(new mysqli_sql_exception("Unable to execute mySQL statement"));
         }

         // get results
         $results = $statement->get_result();
         if($results->num_rows > 0) {
            // retrieve results in bulk into an array
            $results = $results->fetch_all(MYSQL_ASSOC);
            if($results === false) {
               throw(new mysqli_sql_exception("Unable to process result set"));
         }

            // step through results array and convert to ProfileCohort objects
            foreach ($results as $index => $row) {
               $results[$index] = new ProfileCohort($row["profileCohortId"], $row["profileId"], $row["cohortId"], $row["role"]);
         }

            // return resulting array of ProfileCohort objects
            return($results);
         } else {
            return(null);
         }
   }

         /**
          * gets List of Cohort Attendees by role
          *
          * @param resource $mysqli pointer to mySQL connection, by reference
          * @return null
          * @throws mysqli_sql_exception when mySQL related errors occur
          *
          **/
         public static function getAttendeesByRole(&$mysqli, $role) {
            // handle degenerate cases
            if(gettype($mysqli) !== "object" || get_class($mysqli) !== "mysqli") {
               throw(new mysqli_sql_exception("input is not a mysqli object"));
            }

            // sanitize the role before searching
            $role = trim($role);
            $role = filter_var($role, FILTER_SANITIZE_STRING);

            // create query template for role
            $query     =   "SELECT profileCohortId, profileId, cohortId, role FROM profileCohort WHERE role = ?";
            $statement =   $mysqli->prepare($query);
            if($statement === false) {
               throw(new mysqli_sql_exception("Unable to prepare statement"));
            }

            // bind the member variables to the place holders in the template
            $wasClean = $statement->bind_param("s", $role);
            if($wasClean === false) {
               throw(new mysqli_sql_exception("Unable to bind parameters"));
            }

            // execute the statement
            if($statement->execute() === false) {
               throw(new mysqli_sql_exception("Unable to execute mySQL statement"));
            }

            // get results
            $results = $statement->get_result();
            if($results->num_rows > 0) {

               // retrieve results in bulk into an array
               $results = $results->fetch_all(MYSQL_ASSOC);
               if($results === false) {
                  throw(new mysqli_sql_exception("Unable to process result set"));
               }

               // step through results array and convert to ProfileCohort objects
               foreach ($results as $index => $row) {
                  $results[$index] = new ProfileCohort($row["profileCohortId"], $row["profileId"], $row["cohortId"], $row["role"]);
               }

               // return resulting array of ProfileCohort objects
               return($results);
            } else {
               return(null);
            }

      }
}




