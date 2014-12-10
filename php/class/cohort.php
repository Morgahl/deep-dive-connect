<?php

/**
 * This is a container for class Cohort
 *
 * This class will identify elements of Cohort class to link to Deep Dive Coders Alumni Site
 * Created by Gerardo Medrano, adapted from template by Dylan McDonald
 *
 * Date: 11/6/2014
 * Time: 3:16 PM
 **/

//**Wrote Cohort class below; primary key is the cohortId;
class Cohort
{
   // CohortID identifies primary key for Cohort
   private $cohortId;

   // Start date from date string
   private $startDate;

   // End Date from date string
   private $endDate;

   //location of alum; string includes present city and state info
   private $location;

   //open-ended thread describing the alumnus' profile, job status, etc.
   private $description;


   /** constructor below for Cohort class
    * @param string $newCohortId    Cohort Id (or null if new object)
    * @param string $newStartDate   Start Date of Cohort
    * @param string $newEndDate     End Date of Cohort
    * @param string $newLocation    Location of Cohort
    * @param string $newDescription Description of Alumnus' activities
    * @throws UnexpectedValueException when a parameter is wrong type
    * @throws RangeException when a parameter is invalid
    **/
   public function __construct($newCohortID, $newStartDate, $newEndDate, $newLocation, $newDescription) {
      try {
         $this->setCohortID($newCohortID);
         $this->setStartDate($newStartDate);
         $this->setEndDate($newEndDate);
         $this->setLocation($newLocation);
         $this->setDescription($newDescription);
      } catch(UnexpectedValueException $unexpectedValue) {

         //creates throw statement
         throw(new UnexpectedValueException("Unable to associate with Cohort", 0, $unexpectedValue));
         //catch statement
      } catch(RangeException $range) {
         //rethrow to the caller
         throw(new RangeException("Unable to associate with Cohort", 0, $range));
      }
   }

   /** gets the value of Cohort Id
    *
    * @return mixed Cohort Id (or null if new object)
    **/

   public function getCohortId() {
      return ($this->cohortId);
   }

   /** sets the value of Cohort Id
    *
    * @param mixed $CohortId (or null if new object)
    * @throws UnexpectedValueException if not an integer or null
    * @throws RangeException if Cohort Id isn't a positive
    **/
   public function setCohortID($newCohortId) {
      // zeroth, set allow the CohortID to be null if a new object
      if($newCohortId === null) {
         $this->cohortId = null;
         return;
      }

      //first, filterVar ensures the Cohort Id is an integer
      if(filter_var($newCohortId, FILTER_VALIDATE_INT) === false) {
         throw(new UnexpectedValueException("Cohort ID $newCohortId is not numeric"));
      }

      //second, convert CohortID to an integer and enforce it's positive
      $newCohortId = intval($newCohortId);
      if($newCohortId <= 0) {
         throw(new RangeException("Cohort ID $newCohortId is not positive"));
      }

      //finally remove CohortID from quarantine and assign it
      $this->cohortId = $newCohortId;
   }

   /**
    * gets the value of startDate of Cohort
    **/
   public function getStartDate() {
      return ($this->startDate);
   }

   /** sets the value of StartDate of Cohort
    *
    * @param mixed $StartDate object or string with date created
    * @throws exception if date is not a valid date
    *
    **/
   public function setStartDate($newStartDate) {
      //zeroth, allow the date to be null if a new object
      if($newStartDate === null) {
         $this->startDate = null;
         return;
      }

      // zeroth, allow a DateTime object to be directly assigned
      if(gettype($newStartDate) === "object" && get_class($newStartDate) === "DateTime") {
         $this->startDate = $newStartDate;
         return;
      }

      // treat the StartDate as a mySQL date string
      $newStartDate = trim($newStartDate);
      if((preg_match("/^(\d{4})-(\d{2})-(\d{2}) (\d{2}):(\d{2}):(\d{2})$/", $newStartDate, $matches)) !== 1) {
         throw(new RangeException("Your Start Date is not a valid date"));
      }

      // verify the date is really a valid calendar date
      $year = intval($matches[1]);
      $month = intval($matches[2]);
      $day = intval($matches[3]);
      if(checkdate($month, $day, $year) === false) {
         throw(new RangeException(" $newStartDate is not a Gregorian date"));
      }

      //remove StartDate from quarantine below
      $newStartDate = DateTime::createFromFormat("Y-m-d H:i:s", $newStartDate);
      $this->startDate = $newStartDate;

   }

   /**
    * gets the value of EndDate of Cohort
    **/

   public function getEndDate() {
      return ($this->endDate);
    }

   /** sets the value of EndDate of Cohort
    *
    * @param mixed $newEndDate object or string with date created
    * @throws exception if date is not a valid date
    *
    **/
   public function setEndDate($newEndDate) {
      //zeroth, allow the date to be null if a new object
      if($newEndDate === null) {
         $this->endDate = null;
         return;
      }

      // zeroth, allow a DateTime object to be directly assigned
      if(gettype($newEndDate) === "object" && get_class($newEndDate) === "DateTime") {
         $this->endDate = $newEndDate;
         return;
      }

      // treat the StartDate as a mySQL date string
      $newEndDate = trim($newEndDate);
      if((preg_match("/^(\d{4})-(\d{2})-(\d{2}) (\d{2}):(\d{2}):(\d{2})$/", $newEndDate, $matches)) !== 1) {
         throw(new RangeException("Your Start Date is not a valid date"));
      }

      // verify the date is really a valid calendar date
      $year = intval($matches[1]);
      $month = intval($matches[2]);
      $day = intval($matches[3]);
      if(checkdate($month, $day, $year) === false) {
         throw(new RangeException(" End Date is not a Gregorian date"));
      }

      //create end date from format
      $newEndDate = DateTime::createFromFormat("Y-m-d H:i:s", $newEndDate);

      //remove StartDate from quarantine below
      $this->endDate = $newEndDate;

   }

   /**
    * updates Cohort Start and End Dates in mySQL
    *
    * @param $mysqli pointer to mySQL connection, by reference
    * @throws mysqli_sql_exception when mySQL related errors occur
    **/
   public function update(&$mysqli) {
      // handle degenerate cases
      if(gettype($mysqli) !== "object" || get_class($mysqli) !== "mysqli") {
         throw(new mysqli_sql_exception("input is not a mysqli object"));
      }

      // convert start and end dates to strings
      if($this->startDate === null) {
         $startDate = null;
      } else {
         $startDate = $this->startDate->format("Y-m-d H:i:s");
      }

      if($this->endDate === null) {
         $endDate = null;
      } else {
         $endDate = $this->endDate->format("Y-m-d H:i:s");
      }

      // create query template
      $query = "UPDATE cohort SET startDate = ?, endDate = ?, location = ?, description = ? WHERE cohortId = ?";
      $statement = $mysqli->prepare($query);

      if($statement === false) {
         throw(new mysqli_sql_exception("Unable to prepare statement"));
      }

      // bind the member variables to the place holders in the template
      $wasClean = $statement->bind_param("ssssi", $startDate, $endDate, $this->location, $this->description, $this->cohortId);
      if($wasClean === false) {
         throw(new mysqli_sql_exception("Unable to bind parameters"));
      }

      // execute the statement
      if($statement->execute() === false) {
         throw(new mysqli_sql_exception("Unable to execute mySQL statement"));
      }
   }

   /**
    * gets the value of Location
    *
    * @return string Location
    **/
   public function getLocation() {
      return ($this->location);
   }

   /**
    * sets the value of Location
    *
    * @return string Location
    **/
   public function setLocation($newLocation) {
      // filter the location as a generic string
      $newLocation = trim($newLocation);
      $newLocation = filter_var($newLocation, FILTER_SANITIZE_STRING);

      //remove Location from quarantine below
      $this->location = $newLocation;

   }

   /**
    * gets the value of Description
    *
    * @return string Description
    **/

   public function getDescription() {
      return ($this->description);
   }

   /**
    * sets the value of Description
    *
    * @return string Description
    **/
   public function setDescription($newDescription) {
      // filter the location as a generic string
      $newDescription = trim($newDescription);
      $newDescription = filter_var($newDescription, FILTER_SANITIZE_STRING);

      //remove Description from quarantine below
      $this->description = $newDescription;
   }

   /**
    * Insert Profile Cohort to mySQL
    * @param resource $mysqli pointer to mySQL connection by reference
    *                         mysqli_sql_exception as mySql related errors occur
    **/
   public function insert(&$mysqli) {

      if(gettype($mysqli) !== "object" || get_class($mysqli) !== "mysqli") {
         throw(new mysqli_sql_exception("input is not a mysqli object"));
      }

      //enforce the CohortId is null

      if($this->cohortId !== null) {
         throw(new mysqli_sql_exception("input is not a mysqli object"));
      }

      //convert date time objects prior to insert, converts dates to strings

      if($this->startDate === null) {
         $startDate = null;
      } else {
         $startDate = $this->startDate->format("Y-m-d H:i:s");
      }

      if($this->endDate === null) {
         $endDate = null;
      } else {
         $endDate = $this->endDate->format("Y-m-d H:i:s");
      }

      //creates a query template Profile Cohort

      $query = "INSERT INTO cohort(startDate, endDate, location, description) VALUES (?,?,?,?)";
      $statement = $mysqli->prepare($query);
      if($statement === false) {
         throw(new mysqli_sql_exception("Unable to prepare statement"));
      }

      //bind the member variables to placeholders in template
      $wasClean = $statement->bind_param("ssss", $startDate, $endDate, $this->location, $this->description);
      if($wasClean === false) {
         throw(new mysqli_sql_exception("Unable to bind parameters"));
      }

      //execute the statement
      if($statement->execute() === false) {
         throw(new mysqli_sql_exception("Unable to execute mySQL statement"));
      }

      // update the null cohortId with what mySQL just gave us
      $this->cohortId = $mysqli->insert_id;
   }

   /**
    * deletes cohort from mySQL
    *
    * @param resource $mysqli pointer to mySQL connection, by reference
    * @throws mysqli_sql_exception when mySQL related errors occur
    **/
   public function delete(&$mysqli) {
      // handle degenerate cases
      if(gettype($mysqli) !== "object" || get_class($mysqli) !== "mysqli") {
         throw(new mysqli_sql_exception("input is not a mysqli object"));
      }

      // enforce the cohortId is not null (i.e., don't delete a cohort that hasn't been inserted)
      if($this->cohortId === null) {
         throw(new mysqli_sql_exception("Unable to delete a user that does not exist"));
      }

      // create query template
      $query = "DELETE FROM cohort WHERE cohortId = ?";
      $statement = $mysqli->prepare($query);
      if($statement === false) {
         throw(new mysqli_sql_exception("Unable to prepare statement"));
      }

      // bind the member variables to the place holder in the template
      $wasClean = $statement->bind_param("i", $this->cohortId);
      if($wasClean === false) {
         throw(new mysqli_sql_exception("Unable to bind parameters"));
      }

      // execute the statement
      if($statement->execute() === false) {
         throw(new mysqli_sql_exception("Unable to execute mySQL statement"));
      }
   }

   /**
    * Selects Cohort by CohortId
    *
    * @param resource $mysqli pointer to mySQL connection, by reference
    * @return null
    * @throws mysqli_sql_exception when mySQL related errors occur
    *
    **/
   public static function getCohortByCohortId(&$mysqli, $cohortId) {
      // handle degenerate cases
      if(gettype($mysqli) !== "object" || get_class($mysqli) !== "mysqli") {
         throw(new mysqli_sql_exception("input is not a mysqli object"));
      }

      // sanitize the cohortId before searching
      $cohortId = trim($cohortId);
      $cohortId = filter_var($cohortId, FILTER_SANITIZE_NUMBER_INT);

      // create query template for role
      $query = "SELECT cohortId, startDate, endDate, location, description FROM cohort WHERE cohortId = ?";
      $statement = $mysqli->prepare($query);
      if($statement === false) {
         throw(new mysqli_sql_exception("Unable to prepare statement"));
      }

      // bind the member variables to the place holders in the template
      $wasClean = $statement->bind_param("i", $cohortId);
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

         // step through results array and convert to Cohort objects
         foreach($results as $index => $row) {
            $results[$index] = new Cohort($row["cohortId"], $row["startDate"], $row["endDate"], $row["location"], $row["description"]);
         }

         // return resulting array of Cohort objects
         return ($results);
         } else {
         return (null);
      }
   }

	/**
	 * Selects ALL Cohorts
	 *
	 * @param resource $mysqli pointer to mySQL connection, by reference
	 * @return null
	 * @throws mysqli_sql_exception when mySQL related errors occur
	 *
	 **/
	public static function getCohorts(&$mysqli) {
		// handle degenerate cases
		if(gettype($mysqli) !== "object" || get_class($mysqli) !== "mysqli") {
			throw(new mysqli_sql_exception("input is not a mysqli object"));
		}

		// create query template for role
		$query = "SELECT cohortId, startDate, endDate, location, description FROM cohort ORDER BY startDate DESC";
		$statement = $mysqli->prepare($query);
		if($statement === false) {
			throw(new mysqli_sql_exception("Unable to prepare statement"));
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

			// step through results array and convert to Cohort objects
			foreach($results as $index => $row) {
				$results[$index] = new Cohort($row["cohortId"], $row["startDate"], $row["endDate"], $row["location"], $row["description"]);
			}

			// return resulting array of Cohort objects
			return ($results);
		} else {
			return (null);
		}
	}

   /**
    * Selects Cohort by StartDate
    *
    * @param resource $mysqli pointer to mySQL connection, by reference
    * @return null
    * @throws mysqli_sql_exception when mySQL related errors occur
    *
    **/
   public static function getCohortStartDate(&$mysqli, $startDate) {
      // handle degenerate cases
      if(gettype($mysqli) !== "object" || get_class($mysqli) !== "mysqli") {
         throw(new mysqli_sql_exception("input is not a mysqli object"));
      }

      //converts date time object to string, sanitizes
      if(gettype($startDate) === "object" && get_class($startDate) === "DateTime") {
         $startDate = format("Y-m-d H:i:s");
      } elseif($startDate !== null) {
         $startDate = trim($startDate);
         $startDate = filter_var($startDate, FILTER_SANITIZE_STRING);
      } else {

      }

      // create query template for role
      $query = "SELECT cohortId, startDate, endDate, location, description FROM cohort WHERE startDate = ?";
      $statement = $mysqli->prepare($query);
      if($statement === false) {
         throw(new mysqli_sql_exception("Unable to prepare statement"));
      }

      // bind the member variables to the place holders in the template
      $wasClean = $statement->bind_param("s", $startDate);
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

         // step through results array and convert to Cohort objects
         foreach($results as $index => $row) {
            $results[$index] = new Cohort($row["cohortId"], $row["startDate"], $row["endDate"], $row["location"], $row["description"]);
         }

         // return resulting array of Cohort objects
         return ($results);
      } else {
         return (null);
      }
   }

	/**
	 * Selects ALL Cohorts
	 *
	 * @param resource $mysqli pointer to mySQL connection, by reference
	 * @return null
	 * @throws mysqli_sql_exception when mySQL related errors occur
	 *
	 **/
	public static function getCohortsByProfileId(&$mysqli, $profileId) {
		// handle degenerate cases
		if(gettype($mysqli) !== "object" || get_class($mysqli) !== "mysqli") {
			throw(new mysqli_sql_exception("input is not a mysqli object"));
		}

		// sanitize the cohortId before searching
		$profileId = trim($profileId);
		$profileId = filter_var($profileId, FILTER_SANITIZE_NUMBER_INT);

		// create query template for role
		$query = 	"SELECT cohort.cohortId, startDate, endDate, location, description
						FROM cohort
						INNER JOIN profileCohort ON cohort.cohortId = profileCohort.cohortId
						WHERE profileId = ?
						ORDER BY startDate DESC";
		$statement = $mysqli->prepare($query);
		if($statement === false) {
			throw(new mysqli_sql_exception("Unable to prepare statement"));
		}

		// bind the member variables to the place holders in the template
		$wasClean = $statement->bind_param("i", $profileId);
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

			// step through results array and convert to Cohort objects
			foreach($results as $index => $row) {
				$results[$index] = new Cohort($row["cohortId"], $row["startDate"], $row["endDate"], $row["location"], $row["description"]);
			}

			// return resulting array of Cohort objects
			return ($results);
		} else {
			return (null);
		}
	}
}



