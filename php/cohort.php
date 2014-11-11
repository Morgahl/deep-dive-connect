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
class Cohort {
   // CohortID identifies primary key for Cohort
   private $cohortID;

   // Start date from date string
   private $startDate;

   // End Date from date string
   private $endDate;

   //location of alum; string includes present city and state info
   private $location;

   //open-ended thread describing the alumnus' profile, job status, etc.
   private $description;


   /** constructor below for Cohort class
    * @param string $newCohortId Cohort Id (or null if new object)
    * @param string $newStartDate Start Date of Cohort
    * @param string $newEndDate End Date of Cohort
    * @param string $newLocation Location of Cohort
    * @param string $newDescription Description of Alumnus' activities
    * @throws UnexpectedValueException when a parameter is wrong type
    * @throws RangeException when a parameter is invalid
    **/
   public function __construct($newCohortID, $newStartDate, $newEndDate, $newLocation, $newDescription)
   {
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
      return ($this->cohortID);

}

/** sets the value of Cohort Id
 *
 * @param mixed $newCohortId (or null if new object)
 * @throws UnexpectedValueException if not an integer or null
 * @throws RangeException if Cohort Id isn't a positive
 **/
   public function setCohortID($newCohortID)
   {
      // zeroth, set allow the CohortID to be null if a new object
      if($newCohortID === null) {
         $this->cohortID = null;
         return;
      }

      //first, filterVar ensures the Cohort Id is an integer
      if(filter_var($newCohortID, FILTER_VALIDATE_INT) === false) {
         throw(new UnexpectedValueException("Cohort ID $newCohortID is not numeric"));
      }

      //second, convert CohortID to an integer and enforce it's positive
      $newCohortID = intval($newCohortID);
      if($newCohortID <= 0) {
         throw(new RangeException("Cohort ID $newCohortID is not positive"));
      }

      //finally remove CohortID from quarantine and assign it
      $this->CohortID = $newCohortID;
   }

   /**
    * gets the value of StartDate of Cohort
    **/
    public function getStartDate () {
         return($this->startDate);
   }

   /** sets the value of StartDate of Cohort
   *
   * @param mixed $StartDate object or string with date created
   * @throws exception if date is not a valid date
   *
   **/
   public function setStartDate($newStartDate) {
      //zeroth, allow the date to be null if a new object
      if ($newStartDate === null) {
            $this->startDate = null;
            return;
      }

      // zeroth, allow a DateTime object to be directly assigned
      if(gettype($newStartDate) === "object" && get_class($newStartDate) === "DateTime") {
         $this->startDate = $newStartDate;
         return;
      }

      // treat the StartDate as a mySQL date string
      $newDateCreated = trim($newStartDate);
      if((preg_match("/^(\d{4})-(\d{2})-(\d{2}) (\d{2}):(\d{2}):(\d{2})$/", $newStartDate, $matches)) !== 1) {
         throw(new RangeException("Your Start Date is not a valid date"));
      }

      // verify the date is really a valid calendar date
      $year  = intval($matches[1]);
      $month = intval($matches[2]);
      $day   = intval($matches[3]);
      if(checkdate($month, $day, $year) === false) {
         throw(new RangeException(" $newStartDate is not a Gregorian date"));
      }

      //remove StartDate from quarantine below
      $this->StartDate = $newStartDate;

   }

   /**
   * gets the value of EndDate of Cohort
   **/
      public function getEndDate () {
         return($this->EndDate);
}

/** sets the value of EndDate of Cohort
 *
 * @param mixed $EndDate object or string with date created
 * @throws exception if date is not a valid date
 *
 **/
public function setEndDate($newEndDate) {
   //zeroth, allow the date to be null if a new object
   if ($newEndDate === null) {
      $this->EndDate = null;
      return;
   }

   // zeroth, allow a DateTime object to be directly assigned
   if(gettype($newEndDate) === "object" && get_class($newEndDate) === "DateTime") {
      $this->startDate = $newEndDate;
      return;
   }

   // treat the StartDate as a mySQL date string
   $newDateCreated = trim($newEndDate);
   if((preg_match("/^(\d{4})-(\d{2})-(\d{2}) (\d{2}):(\d{2}):(\d{2})$/", $newEndDate, $matches)) !== 1) {
      throw(new RangeException("Your Start Date is not a valid date"));
   }

   // verify the date is really a valid calendar date
   $year  = intval($matches[1]);
   $month = intval($matches[2]);
   $day   = intval($matches[3]);
   if(checkdate($month, $day, $year) === false) {
      throw(new RangeException(" End Date is not a Gregorian date"));
   }

   //remove StartDate from quarantine below
   $this->EndDate = $newEndDate;

}
   /**
    * updates this Signup in mySQL
    *
    * @param resource $mysqli pointer to mySQL connection, by reference
    * @throws mysqli_sql_exception when mySQL related errors occur
    **/
   public function update(&$mysqli) {
      // handle degenerate cases
      if(gettype($mysqli) !== "object" || get_class($mysqli) !== "mysqli") {
         throw(new mysqli_sql_exception("input is not a mysqli object"));
      }

      // convert dates to strings
      if($this->startDate === null) {
         $startDate = null;
      } else {
         $startDate = $this->startDate->format("Y-d-m H:i:s");
      }
      if($this->endDate === null) {
         $endDate = null;
      } else {
         $endDate = $this->endDate->format("Y-d-m H:i:s");
      }

      // create query template -- !!!TO DO Change fields or adapt query!!!!!
      $query     = "UPDATE cohort SET StartDate = ?, EndDate = ?, WHERE cohort = ?";
      $statement = $mysqli->prepare($query);

      if($statement === false) {
         throw(new mysqli_sql_exception("Unable to prepare statement"));
      }

      // bind the member variables to the place holders in the template
      $wasClean = $statement->bind_param("Place Holders",  $StartDate, $EndDate);
      if($wasClean === false) {n
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
      return ($this->Location);
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
      $this->Location = $newLocation;

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
      $newLocation = trim($newDescription);
      $newLocation = filter_var($newDescription, FILTER_SANITIZE_STRING);

   //remove Description from quarantine below
   $this->Description = $newDescription;



   /**
    *Insert Profile Cohort to mySQL
    *                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           @param mysqli_sql_exception as mySql related errors occur
    *
    **/
   public function insert(&$mysqli) {


      if(gettype(mysqli) !== "object" || get_class($mysqli) !== "mysqli") {
         throw(new mysqli_sql_exception("input is not a mysqli object"));
      }

      //enforce the Profile Cohort ID is null

      if($this->profileCohortId !== null) {
         throw(new mysqli_sql_exception("input is not a mysqli object"));
      }


      //create a query template Profile Cohort ID
      //To do: Insert Field names for $query
      $query      =  "INSERT INTO profileCohortId (XXXXPROFILeCOHORtFIELDsHEREXXX) VALUES?";
      $statement  =  $mysqli ->prepare($query);
         if($statement === false) {
            throw(new mysqli_sql_exception("Unable to prepare statement"));
      }

      //bind the member variables to place holders in template
      $wasClean = $statement->bind_param("ssd", $this->XXXXFIELD1,$this->XXXXFIELD1,etc);
         if($wasClean === false) {
            throw(new mysqli_sql_exception("Unable to bind parameters"));
      }

      //execute the statement
         if($statement->execute() === false) {
            throw(new mysqli_sql_exception("Unable to execute mySQL statement"));
      }

   }
}




?>
