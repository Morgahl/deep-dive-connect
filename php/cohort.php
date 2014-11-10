<?php
/**
 * This is a container for class Cohort
 * This class will identify elements of Cohort class to link to
 * Deep Dive Coders Alumni
 * Created by Gerardo Medrano, adapted from template by Dylan M
 * User:  Deep Dive Connect; GM This is a hot mess!
 * Date: 11/6/2014
 * Time: 3:16 PM
 */

//Wrote Cohort class below; primary key is the cohortId;
class Cohort
{
   //this is a primary key
   private $cohortID;
   //this
   private $startDate;
   //comment!
   private $endDate;
   //comment!
   private $location;
   //comment!
   private $description;


   //** constructor below for cohort class */

   public function __construct($newCohortID, $newStartDate, $newEndDate, $newLocation, $newDescription)
   {
      try {
         $this->setCohortID($newCohortID);
         $this->setStartDate($newStartDate);
         $this->setEndDate($newEndDate);
         $this->setLocation($newLocation);
         $this->setDescription($newDescription);
      } catch(UnexpectedValueException $unexpectedValue) {
         //comment!  3d
         throw(new UnexpectedValueException("Unable to associate with Cohort", 0, $unexpectedValue));
         //comment!
      } catch(RangeException $range) {
         //rethrow to the caller
         throw(new RangeException("Unable to associate with Cohort", 0, $range));
      }
   }

   //gets value of CohortID
   public function setCohortID($newCohortID)
   {
      // zeroth, set allow the CohortID to be null if a new object
      if($newCohortID === null) {
         $this->cohortID = null;
         return;
      }

      //FilterVar here
      if(filter_var($newCohortID, FILTER_VALIDATE_INT) === false) {
         throw(new UnexpectedValueException("Cohort ID $newCohortID is not numeric"));
      }

      //convert CohortID to an integer
      $newCohortID = intval($newCohortID);
      if($newCohortID <= 0) {
         throw(new RangeException("Cohort ID $newCohortID is not positive"));
      }

      //remove CohortID from quarantine below
      $this->CohortID = $newCohortID;
   }

   //gets value of StartDate
   public function setStartDate($newStartDate)
   {
      // zeroth, set allow the StartDate to be null if a new object
      if($newStartDate === null) {
         $this->startDate = null;
         return;
      }

      //FilterVar here for StartDate
      if(filter_var($newStartDate, FILTER_VALIDATE_INT) === false) {
         throw(new UnexpectedValueException("Start Date $newStartDate is not numeric"));
      }

      //convert StartDate to an integer
      $newStartDate = intval($newStartDate);
      if($newStartDate <= 0) {
         throw(new RangeException("Start Date $newStartDate is not positive"));
      }

      //remove StartDate from quarantine below
      $this->StartDate = $newStartDate;

   }

//gets value of EndDate
   public function setEndDate($newEndDate)
   {
      // zeroth, set allow the EndDate to be null if a new object
      if($newEndDate === null) {
         $this->EndDate = null;
         return;
      }

      //FilterVar here for EndDate
      if(filter_var($newEndDate, FILTER_VALIDATE_INT) === false) {
         throw(new UnexpectedValueException("End Date $newEndDate is not numeric"));
      }

      //convert EndDate to an integer
      $newEndDate = intval($newEndDate);
      if($newEndDate <= 0) {
         throw(new RangeException("End Date $newEndDate is not positive"));
      }

      //remove EndDate from quarantine below
      $this->EndDate = $newEndDate;

   }
   //gets value of Location
   public function setLocation($newLocation)
   {
      // zeroth, set allow the Location to be null if a new object
      if($newLocation === null) {
         $this->Location = null;
         return;
      }

      //FilterVar here for Location
      if(filter_var($newLocation, FILTER_VALIDATE_INT) === false) {
         throw(new UnexpectedValueException("Location $newLocation is not numeric"));
      }

      //convert Location to an integer
      $newLocation = intval($newLocation);
      if($newLocation <= 0) {
         throw(new RangeException("Location $newLocation is not positive"));
      }

      //remove Location from quarantine below
      $this->Location = $newLocation;

   }


   //gets value of Description
   public function setDescription($newDescription)  {
      // zeroth, set allow the Location to be null if a new object
      if($newDescription === null) {
         $this->Description = null;
         return;
      }

      //FilterVar here for Description --- What should be used for throw verbiage?
      if(filter_var($newDescription, FILTER_VALIDATE_INT) === false) {
         throw(new UnexpectedValueException("Description $newDescription is not Valid"));
      }

      //convert Description to an integer
      $newDescription = intval($newDescription);
      if($newDescription <= 0) {
         throw(new RangeException("Location $newDescription is not positive"));
      }

      //remove Description from quarantine below
      $this->Description = $newDescription;

      }

   /**
    *Insert Profile Cohort to mySQL
    * @paran mysqli_sql_exception when mySql related errors occur
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

      // update the null Profile Cohort Id with Mysql output
      $this->profileCohortId = $mysqli->insert_id;












//For below see Mark's function
   public function getStartDate()
   {
      return ($this->startDate);

   }
}
?>
