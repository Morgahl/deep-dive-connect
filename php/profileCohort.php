<?php
/**
 * This a container for profileCohort class
 *
 * This class will identify elements of profileCohort class to link to Deep Dive Coders Alumni Site
 * Created by Gerardo Medrano, adapted from template by Dylan McDonald
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

   //names location of alum
   private $location;

   //names role of alum
   private $role;
   /**
    * constructor for ProfileCohort below
    *
      @param string $newProfileCohortId Profile Cohort Id integer/number
    * @param string $newCohortId Cohort Id integer/number
    * @param string $newProfileId Profile Id integer/number
    * @param string $newLocation Location string gives alum address info
    * @throws UnexpectedValueException when a parameter is wrong type
    * @throws RangeException when a parameter is invalid
    */
   public function __construct($newProfileCohortId, $newProfileId, $newCohortId, $newLocation, $newRole)
   {
      try {
         $this->setProfileCohortId($newProfileCohortId);
         $this->setProfileId($newProfileId);
         $this->setCohortId($newCohortId);
         $this->setLocation($newLocation);
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
   /**set the value of ProfileId**/
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
   //returns mixed CohortId
   public function getCohortId() {
      return ($this->CohortId);
   }

   //set CohortId
   public function setCohortId($newCohortId)
   {
      if($newCohortId === null) {
         $this->CohortId = null;
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
         //take the Profile Cohort Id out of quarantine
         $this->CohortId = $newCohortId;
      }
   }

   //Get and Set for location
   public function getLocation()
   {
      return ($this->location);
   }

   public function setLocation($newLocation)
   {
      // filter the location as a generic string
      $newLocation = trim($newLocation);
      $newLocation = filter_var($newLocation, FILTER_SANITIZE_STRING);

      // then just take the location out of quarantine
      $this->Location = $newLocation;
   }

   //Get and Set for role
   public function getRole(){
      return ($this->role);
   }
   public function setRole($newRole)
   {
      $newRole = trim($newRole);
      // filter the role as a generic string
      $newRole = filter_var($newRole, FILTER_SANITIZE_STRING);

      // then just take the role out of quarantine

      $this->role = $newRole;

   }
   /**
    *Insert Profile Cohort to mySQL
    * @paran mysqli_sql_exception when mySql related errors occur
    *
    **/
   public function insert(&$mysqli) {
   }

if(gettype(mysqli) !== "object" || get_class($mysqli) !== "mysqli") {
throw(new mysqli_sql_exception("input is not a mysqli object"));
}

//enforce the Profile Cohort ID is null

if($this->profileCohortId !== null) {
   throw(new mysqli_sql_exception("input is not a mysqli object"));
}


//create a query template Profile Cohort ID
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


}

/**
 * deletes CohortId from mySQL
 *
 * @param resource $mysqli pointer to mySQL connection, by reference
 * @throws mysqli_sql_exception when mySQL related errors occur
 *
 **/
public function insert(&$mysqli) {
}

if(gettype(mysqli) !== "object" || get_class($mysqli) !== "mysqli") {
   throw(new mysqli_sql_exception("input is not a mysqli object"));
}

//enforce Cohort ID is null

if($this->CohortId !== null) {
   throw(new mysqli_sql_exception("input is not a mysqli object"));
}


//create a query template for Cohort ID
$query      =  "INSERT INTO CohortId (XXXXPROFILeCOHORtFIELDsHEREXXX) VALUES?";
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

// update the null Cohort Id with Mysql output
$this->CohortId = $mysqli->insert_id;


/**
 * deletes CohortId from mySQL
 *
 * @param resource $mysqli pointer to mySQL connection, by reference
 * @throws mysqli_sql_exception when mySQL related errors occur
 *
 **/
public function insert(&$mysqli) {
}

if(gettype(mysqli) !== "object" || get_class($mysqli) !== "mysqli") {
   throw(new mysqli_sql_exception("input is not a mysqli object"));
}

//enforce Cohort ID is null

if($this->CohortId !== null) {
   throw(new mysqli_sql_exception("input is not a mysqli object"));
}


//create a query template for Cohort ID
$query      =  "INSERT INTO CohortId (XXXXPROFILeCOHORtFIELDsHEREXXX) VALUES?";
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

// update the null Cohort Id with Mysql output
$this->CohortId = $mysqli->insert_id;


/**
 * deletes ProfileId from mySQL
 *
 * @param resource $mysqli pointer to mySQL connection, by reference
 * @throws mysqli_sql_exception when mySQL related errors occur
 *
 **/
public function insert(&$mysqli) {
}

if(gettype(mysqli) !== "object" || get_class($mysqli) !== "mysqli") {
   throw(new mysqli_sql_exception("input is not a mysqli object"));
}

//enforce ProfileID is null

if($this->ProfileId !== null) {
   throw(new mysqli_sql_exception("input is not a mysqli object"));
}


//create a query template for Profile ID
$query      =  "INSERT INTO ProfileId (XXXXPROFILeCOHORtFIELDsHEREXXX) VALUES?";
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

// update the null Profile Id with Mysql output
$this->ProfileId = $mysqli->insert_id;


/**
 * gets the Product by name
 *
 * @param resource $mysqli pointer to mySQL connection, by reference
 * @param string $productName name to search for
 * @return mixed array of Products found, Product found, or null if not found
 * @throws mysqli_sql_exception when mySQL related errors occur
 **/
public static function getCohortByName(&$mysqli, $CohortName) {
   // handle degenerate cases
   if(gettype($mysqli) !== "object" || get_class($mysqli) !== "mysqli") {
      throw(new mysqli_sql_exception("input is not a mysqli object"));
   }

   // sanitize the description before searching
   $cohortName = trim($cohortName);
   $productName = filter_var($productName, FILTER_SANITIZE_STRING);

//primary key should allow a null
//set the value at the end
//allow null
//filter string from Topic table
//data sanitize
