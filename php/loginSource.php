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
			$this->setSecurityId($loginSourceId);
			$this->setDescription($sourceName);
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

	public function loginSourceId($loginSourceId)
	{
		//  ensure the loginSourceId is an integer
		if(filter_var($loginSourceId, FILTER_SANITIZE_STRING) === false) {
			throw(new UnexpectedValueException("loginSourceId $loginSourceId is not valid"));
		}

		// finally, take the loginSourceId out of quarantine and assign it
		$this->loginSourceId = $loginSourceId;
	}


	public function getSourceName()
	{
		return ($this->sourceName);
	}

	public function setSourceName($sourceName)
	{
		// allow the sourceName to be null if a new object

		if($sourceName === null) {
			$this->sourceName = null;
			return;
		}

		//  ensure the sourceName is an integer
		if(filter_var($sourceName, FILTER_VALIDATE_INT) === false) {
			throw(new UnexpectedValueException("sourceName $sourceName is not numeric"));
		}

		$sourceName = intval($sourceName);
		if($sourceName <= 0) {
			throw(new RangeException("sourceName $sourceName is not positive"));
		}

		$this->sourceName = $sourceName;

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
		$wasClean = $statement->bind_param("is", $this->loginSourceId, $this->sourceName);
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
			throw(new mysqli_sql_exception("Unable to delete a sourceId that does not exist"));
		}

		// create query template
		$query     = "DELETE FROM loginSource WHERE loginSourceId = ?";
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

		// enforce the loginSourceId is not null (i.e., don't update a loginSource that hasn't been inserted)
		if($this->loginSourceId === null) {
			throw(new mysqli_sql_exception("Unable to update a loginSourceId that does not exist"));
		}

		// create query template
		$query     = "UPDATE loginSource SET sourceName = ? WHERE loginSourceId = ?";
		$statement = $mysqli->prepare($query);
		if($statement === false) {
			throw(new mysqli_sql_exception("Unable to prepare statement"));
		}

		// bind the member variables to the place holders in the template
		$wasClean = $statement->bind_param("is", $this->loginSourceId, $this->sourceName);
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