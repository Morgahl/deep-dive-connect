<?php
/**
 * Created by PhpStorm.
 * User:  GM This is a hot mess!
 * Date: 11/6/2014
 * Time: 3:16 PM
 */

//Wrote Cohort class below; primary key is the cohortId;
   class Cohort  {

      private $cohortID;

      private $startDate;

      private $endDate;

      private $location;

      private $description;


//** constructor below */

   public function __construct($newCohortID, $newStartDate, $newEndDate, $newLocation, $newDescription)
   {
      try {
         $this->setCohortID($newCohortID);
         $this->setStartDate($newStartDate);
         $this->setEndDate($newEndDate);
         $this->setLocation($newLocation);
         $this->setDescription($newDescription);
      } catch(UnexpectedValueException $unexpectedValue) {
         //comment!
         throw(new UnexpectedValueException("Unable to associate with Cohort", 0, $unexpectedValue));
         //comment!
      } catch(RangeException $range) {
         //rethrow to the caller
         throw(new RangeException("Unable to associate with Cohort", 0, $range));
      }
   }

//gets value of CohortID
   public function setProductId($newCohortID) {
      // zeroth, set allow the CohortID to be null if a new object
      if($newCohortID === null) {
         $this->cohortID = null;
         return;
      }

//FilterVar here
   if(filter_var($newCohortID, FILTER_VALIDATE_INT) === false) {
      throw(new UnexpectedValueException("Cohort ID $newCohortID is not numeric"));
      }

//convert CohortID to an interger
      $newCohortID = intval($newCohortID);
      if($newCohortID <= 0) {
         throw(new RangeException("Cohort ID $newCohortID is not positive"));
      }

//remove CohortID from quarantine below
      $this->CohortID = $newCohortID;
   }
//get value of CohortID return string--what's name of field/output, and string??
   public function getStartDate()
   {
      return ($this->startDate);

   }




?>
