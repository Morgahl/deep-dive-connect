<?php

/**
 * Author Joseph Bottone
 * http://josephmichaelbottone.com
 * bottone.joseph@gmail.
 * thundermedia.com
 **/

class LoginSource
{
	// assigns the primary key
	private $loginSourceId;
	// names the sourceName
	private $sourceName;


	// here is the constructor
	public function __construct($loginSourceId, $sourceName)
	{
		try {
			$this->setsecurityId($loginSourceId);
			$this->setdescription($sourceName);
		} catch(UnexpectedValueException $unexpectedValue) {
			// rethrow to the seller
			throw(new UnexpectedValueException("Unable to construct securityId, 0, $unexpectedValue"));
		} catch(RangeException $range) {
			// rethrow to the caller
			throw(new RangeException("Unable to construct securityId", 0, $range));
		}
	}

	// gets the value of the loginSourceId
	public function getLoginSourceId()
	{
		return ($this->loginSourceId);
	}

	public function loginSourceId($newLoginSourceId)
	{
		//  ensure the loginSourceId is an integer
		if(filter_var($newLoginSourceId, FILTER_SANITIZE_STRING) === false) {
			throw(new UnexpectedValueException("loginSourceId $newLoginSourceId is not valid"));
		}

		// finally, take the loginSourceId out of quarantine and assign it
		$this->loginSourceId = $newLoginSourceId;
	}


	public function getsourceName()
	{
		return ($this->sourceName);
	}

	public function setSourceName($newSourceName)
	{
		// allow the sourceName to be null if a new object

		if($newSourceName === null) {
			$this->sourceName = null;
			return;
		}

		//  ensure the sourceName is an integer
		if(filter_var($newSourceName, FILTER_VALIDATE_INT) === false) {
			throw(new UnexpectedValueException("sourceName $newSourceName is not numeric"));
		}

		$newSourceName = intval($newSourceName);
		if($newSourceName <= 0) {
			throw(new RangeException("sourceName $newSourceName is not positive"));
		}

		$this->sourceName = $newSourceName;

	}




	public function insert(&$mysqli) {
		if(gettype($mysqli) !== "object" || get_class($mysqli) !== "mysqli") {
			throw(new mysqli_sql_exception("input is not a mysqli object"));
		}

		// enforces that the loginSourceId is null
		if($this->loginSourceId !== null) {
			throw(new mysqli_sql_exception("not a new Id"));
		}

		// creates a query template
		$query     = "INSERT INTO LoginSource(loginSourceId, sourceName) VALUES(?, ?)";
		$statement = $mysqli->prepare($query);
		if($statement === false) {
			throw(new mysqli_sql_exception("Unable to prepare statement"));
		}

		// just bind the member variables to the place holders in the template
		$wasClean = $statement->bind_param("ssss", $this->loginSourceId, $this->sourceName);
		if($wasClean === false) {
			throw(new mysqli_sql_exception("Unable to bind parameters"));
		}

		// execute the statement
		if($statement->execute() === false) {
			throw(new mysqli_sql_exception("Unable to execute mySQL statement"));
		}

		// update the null loginSourceId with what mySQL just gave us
		$this->loginSourceId = $mysqli->insert_id;
	}

// deletes this LoginSource from mySQL
	public function delete(&$mysqli) {
		// handle degenerate cases
		if(gettype($mysqli) !== "object" || get_class($mysqli) !== "mysqli") {
			throw(new mysqli_sql_exception("input is not a mysqli object"));
		}

		// enforce the loginSourceId is not null
		if($this->loginSourceId === null) {
			throw(new mysqli_sql_exception("Unable to delete a author that does not exist"));
		}

		// create query template
		$query     = "DELETE FROM author WHERE loginSourceId = ?";
		$statement = $mysqli->prepare($query);
		if($statement === false) {
			throw(new mysqli_sql_exception("Unable to prepare statement"));
		}

		// bind the member variables to the place holder in the template
		$wasClean = $statement->bind_param("i", $this->loginSourceId);
		if($wasClean === false) {
			throw(new mysqli_sql_exception("Unable to bind parameters"));
		}

		// execute the statement
		if($statement->execute() === false) {
			throw(new mysqli_sql_exception("Unable to execute mySQL statement"));
		}
	}
// updates this LoginSource in mySQL

	public function update(&$mysqli) {
		// handle degenerate cases
		if(gettype($mysqli) !== "object" || get_class($mysqli) !== "mysqli") {
			throw(new mysqli_sql_exception("input is not a mysqli object"));
		}

		// enforce the loginSourceId is not null (i.e., don't update a author that hasn't been inserted)
		if($this->securityId === null) {
			throw(new mysqli_sql_exception("Unable to update a author that does not exist"));
		}

		// create query template
		$query     = "UPDATE loginSource SET department = ? WHERE loginSourceId = ?";
		$statement = $mysqli->prepare($query);
		if($statement === false) {
			throw(new mysqli_sql_exception("Unable to prepare statement"));
		}

		// bind the member variables to the place holders in the template
		$wasClean = $statement->bind_param("ssssi", $this->loginSourceId, $this->sourceName);
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