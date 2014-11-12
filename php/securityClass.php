<?php

// Author Joseph Bottone
// http://josephmichaelbottone.com
// bottone.joseph@gmail.com

class SecurityClass
{
	// assigns the primary key
	private $securityId;
	// names the description
	private $description;
	// assigns the isDefault
	private $isDefault;
	// name of createTopic
	private $createTopic;
	// name of canEditOther
	private $canEditOther;
	// name of canPromote
	private $canPromote;
	// name of siteAdmin
	private $siteAdmin;

	// here is the constructor
	public function __construct($newSecurityId, $IsDefault, $newDescription, $newCreateTopic, $newCanEditOther, $newCanPromote,
										 $newSiteAdmin)
	{
		try {
			$this->setsecurityId($newSecurityId);
			$this->setdescription($newDescription);
			$this->setIsDefault($newIsDefault);
			$this->setcreateTopic($newCreateTopic);
			$this->setcanEditOther($newCanEditOther);
			$this->setcanPromote($newCanPromote);
			$this->setsiteAdmin($newSiteAdmin);
		} catch(UnexpectedValueException $unexpectedValue) {
			// rethrow to the seller
			throw(new UnexpectedValueException("Unable to construct securityId, 0, $unexpectedValue"));
		} catch(RangeException $range) {
			// rethrow to the caller
			throw(new RangeException("Unable to construct securityId", 0, $range));
		}
	}

	// gets the value of the securityId
	public function getSecurityId()
	{
		return ($this->securityId);
	}

	public function setSecurityId($newSecurityId)
	{
		//  ensure the securityId is an integer
		if(filter_var($newSecurityId, FILTER_SANITIZE_STRING) === false) {
			throw(new UnexpectedValueException("securityId $newSecurityId is not valid"));
		}

		// finally, take the securityId out of quarantine and assign it
		$this->securityId = $newSecurityId;
	}


	public function getDescription()
	{
		return ($this->description);
	}

	public function setDescription($newDescription)
	{
		// allow the description to be null if a new object

		if($newDescription === null) {
			$this->description = null;
			return;
		}

		//  ensure the description is an integer
		if(filter_var($newDescription, FILTER_VALIDATE_INT) === false) {
			throw(new UnexpectedValueException("description $newDescription is not numeric"));
		}

		$newDescription = intval($newDescription);
		if($newDescription <= 0) {
			throw(new RangeException("securityId $newDescription is not positive"));
		}

		$this->description = $newDescription;

	}


	public function getisDefault()
	{
		return ($this->isDefault);
	}

	public function setIsDefault($newIsDefault)
	{
		// allow the isDefault to be null if a new object

		if($newIsDefault === null) {
			$this->isDefault = null;
			return;
		}

		//  ensure the isDefault is an integer

		if(filter_var($newIsDefault, FILTER_VALIDATE_INT) === false) {
			throw(new UnexpectedValueException("description $newIsDefault is not numeric"));
		}

		$newIsDefault = intval($newIsDefault);
		if($newIsDefault <= 0) {
			throw(new RangeException("isDefault $newIsDefault is not positive"));
		}

		$this->isDefault = $newIsDefault;

	}


	public function getcreateTopic()
	{
		return ($this->CreateTopic);
	}

	public function setCreateTopic($newCreateTopic)
	{
		// allow the createTopic to be null if a new object

		if($newCreateTopic === null) {
			$this->CreateTopic = null;
			return;
		}

		//  ensure the createTopic is an integer

		if(filter_var($newCreateTopic, FILTER_VALIDATE_INT) === false) {
			throw(new UnexpectedValueException("description $newCreateTopic is not numeric"));
		}

		$newCreateTopic = intval($newCreateTopic);
		if($newCreateTopic <= 0) {
			throw(new RangeException("createTopic $newCreateTopic is not positive"));
		}

		$this->createTopict = $newCreateTopic;
	}




	public function getcanEditOther()
	{
		return ($this->canEditOther);
	}

	public function setCanEditOther($newCanEditOther)
	{
		// allow the canEditOther to be null if a new object

		if($newCanEditOther === null) {
			$this->canEditOther = null;
			return;
		}

		//  ensure the canEditOther is an integer

		if(filter_var($newCanEditOther, FILTER_VALIDATE_INT) === false) {
			throw(new UnexpectedValueException("description $newCanEditOther is not numeric"));
		}

		$newCanEditOther = intval($newCanEditOther);
		if($newCanEditOther <= 0) {
			throw(new RangeException("canEditOther $newCanEditOther is not positive"));
		}

		$this->canEditOther = $newCanEditOther;

	}






	public function getCanPromote()
	{
		return ($this->canCanPromote);
	}

	public function setCanPromote($newCanPromote)
	{
		// allow the canPromote to be null if a new object

		if($newCanPromote === null) {
			$this->CanPromote = null;
			return;
		}

		//  ensure the canPromote is an integer

		if(filter_var($newCanPromote, FILTER_VALIDATE_INT) === false) {
			throw(new UnexpectedValueException("description $newCanPromote is not numeric"));
		}

		$newCanPromote = intval($newCanPromote);
		if($newCanPromote <= 0) {
			throw(new RangeException("CanPromote $newCanPromote is not positive"));
		}

		$this->canCanPromote = $newCanPromote;

	}




	public function getSiteAdmin()
	{
		return ($this->canSiteAdmin);
	}

	public function setSiteAdmin($newSiteAdmin)
	{
		// allow the SiteAdmin to be null if a new object

		if($newSiteAdmin === null) {
			$this->canSiteAdmin = null;
			return;
		}

		//  ensure the siteAdmin is an integer

		if(filter_var($newSiteAdmin, FILTER_VALIDATE_INT) === false) {
			throw(new UnexpectedValueException("description $newSiteAdmin is not numeric"));
		}

		$newSiteAdmin = intval($newSiteAdmin);
		if($newSiteAdmin <= 0) {
			throw(new RangeException("siteAdmin $newSiteAdmin is not positive"));
		}

		$this->canSiteAdmin = $newSiteAdmin;

	}







	public function insert(&$mysqli) {
		if(gettype($mysqli) !== "object" || get_class($mysqli) !== "mysqli") {
			throw(new mysqli_sql_exception("input is not a mysqli object"));
		}

		// enforces that the securityId is null
		if($this->securityId !== null) {
			throw(new mysqli_sql_exception("not a new Id"));
		}

		// creates a query template
		$query     = "INSERT INTO SecurityClass(description, isDefault, createTopic, canEditOther, canPromote, siteAdmin) VALUES(?, ?, ?, ?, ?, ?)";
		$statement = $mysqli->prepare($query);
		if($statement === false) {
			throw(new mysqli_sql_exception("Unable to prepare statement"));
		}

		// just bind the member variables to the place holders in the template
		$wasClean = $statement->bind_param("ssss", $this->description, $this->isDefault, $this->createTopic, $this->canEditOther, $this->canPromote, $this->siteAdmin);
		if($wasClean === false) {
			throw(new mysqli_sql_exception("Unable to bind parameters"));
		}

		// execute the statement
		if($statement->execute() === false) {
			throw(new mysqli_sql_exception("Unable to execute mySQL statement"));
		}

		// update the null securityId with what mySQL just gave us
		$this->authorId = $mysqli->insert_id;
	}

// deletes this author from mySQL
	public function delete(&$mysqli) {
		// handle degenerate cases
		if(gettype($mysqli) !== "object" || get_class($mysqli) !== "mysqli") {
			throw(new mysqli_sql_exception("input is not a mysqli object"));
		}

		// enforce the securityId is not null
		if($this->securityId === null) {
			throw(new mysqli_sql_exception("Unable to delete a author that does not exist"));
		}

		// create query template
		$query     = "DELETE FROM author WHERE securityId = ?";
		$statement = $mysqli->prepare($query);
		if($statement === false) {
			throw(new mysqli_sql_exception("Unable to prepare statement"));
		}

		// bind the member variables to the place holder in the template
		$wasClean = $statement->bind_param("i", $this->securityId);
		if($wasClean === false) {
			throw(new mysqli_sql_exception("Unable to bind parameters"));
		}

		// execute the statement
		if($statement->execute() === false) {
			throw(new mysqli_sql_exception("Unable to execute mySQL statement"));
		}
	}
// updates this SecurityClass in mySQL

	public function update(&$mysqli) {
		// handle degenerate cases
		if(gettype($mysqli) !== "object" || get_class($mysqli) !== "mysqli") {
			throw(new mysqli_sql_exception("input is not a mysqli object"));
		}

		// enforce the SecurityId is not null (i.e., don't update a author that hasn't been inserted)
		if($this->securityId === null) {
			throw(new mysqli_sql_exception("Unable to update a author that does not exist"));
		}

		// create query template
		$query     = "UPDATE SecurityClass SET department = ? WHERE securityId = ?";
		$statement = $mysqli->prepare($query);
		if($statement === false) {
			throw(new mysqli_sql_exception("Unable to prepare statement"));
		}

		// bind the member variables to the place holders in the template
		$wasClean = $statement->bind_param("ssssi", $this->siteAdmin, $this->canPromote, $this->canEditOther,
			$this->createTopic, $this->isDefault, $this->description, $this->securityId);
		if($wasClean === false) {
			throw(new mysqli_sql_exception("Unable to bind parameters"));
		}

		// execute the statement
		if($statement->execute() === false) {
			throw(new mysqli_sql_exception("Unable to execute mySQL statement"));
		}
	}


}

?>