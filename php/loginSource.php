<?php

/**
 * MySQL Enabled Comment
 *
 * This is a MySQL enabled container for loginSouce creation and handling.
 *
 * @author Joseph Bottone <joseph@thundermedia.com>
 */

class LoginSource
{
	/**
	 * @var $loginSourceId INT loginSourceId for the loginSource; this is the Primary Key
	 */
	private $loginSourceId;
	/**
	 * @var $sourceName VAR sourceName for the loginSource; FK to topic table
	 */
	private $sourceName;

	/**
	 * Constructor for loginSource
	 * @param $loginSourceId INT loginSourceId (or null if new object)
	 * @param $sourceName VAR (sourcename of creator)
	 * @throws UnexpectedValueException when a parameter is of the wrong type
	 * @throws RangeException when a parameter is invalid
	 */
	public function __construct($loginSourceId, $sourceName)
	{
		try {
			$this->setLoginSourceId($loginSourceId);
			$this->setSourceName($sourceName);
		} catch(UnexpectedValueException $unexpectedValue) {
			// rethrow to the seller
			throw(new UnexpectedValueException("Unable to construct loginSourceId, 0, $unexpectedValue"));
		} catch(RangeException $range) {
			// rethrow to the caller
			throw(new RangeException("Unable to construct loginSourceId", 0, $range));
		}
	}

	/**
	 * gets the value of loginSourceId
	 * @return INT user loginSourceId (or null if new object)
	 */
	public function getLoginSourceId()
	{
		return ($this->loginSourceId);
	}

	/**
	 * sets the value of loginSource
	 * @param $loginSourceId loginSourceId (or null if new object)
	 * @throws UnexpectedValueException when a parameter is of the wrong type
	 * @throws RangeException when a parameter is invalid
	 */

	public function setLoginSourceId($loginSourceId)
	{
		if($loginSourceId === null) {
			$this->loginSourceId = null;
			return;
		}
		//  ensure the loginSourceId is an integer
		if(filter_var($loginSourceId, FILTER_VALIDATE_INT) === false) {
			throw(new UnexpectedValueException("loginSourceId $loginSourceId is not valid"));
		}

		$loginSourceId = intval($loginSourceId);
		if($loginSourceId <= 0) {
			throw(new RangeException("loginSourceId $loginSourceId is not positive"));
		}

		// finally, take the loginSourceId out of quarantine and assign it
		$this->loginSourceId = $loginSourceId;
	}

	/**
	 * gets the value of sourceName
	 * @return value of sourceName
	 */

	public function getSourceName()
	{
		return ($this->sourceName);
	}

	/**
	 * sets the value of sourceName
	 * @param $sourceName sets the sourceName
	 * @throws UnexpectedValueException when a parameter is of the wrong type
	 * @throws UnexpectedValueException when a parameter is of the wrong type
	 * @throws RangeException when a parameter is invalid
	 */

	public function setSourceName($sourceName)
	{
		// sourceName should never be null
		if($sourceName === null) {
			throw(new UnexpectedValueException("sourceName must not be null"));
		}

		// sanitize string
		$sourceName = trim($sourceName);
		if(($sourceName = filter_var($sourceName, FILTER_SANITIZE_STRING)) === false) {
			throw(new UnexpectedValueException("Not a valid string"));
		}

		// enforce 256 character limit to ensure no truncation of data when inserting to database
		if(strlen($sourceName) > 256) {
			throw(new RangeException("sourceName must be 256 characters or less in length"));
		}
		// take sourceName out of quarantine and assign it
		$this->sourceName = $sourceName;

	}

	/**
	 * inserts the loginSource in mysqli
	 * @param $mysqli pointer to mySQL connection, by reference
	 * @throws mysqli_sql_exception when mySQL related errors occur
	 */

	public function insert(&$mysqli)
	{
		if(gettype($mysqli) !== "object" || get_class($mysqli) !== "mysqli") {
			throw(new mysqli_sql_exception("input is not a mysqli object"));
		}

		// enforces that the loginSourceId is null
		if($this->loginSourceId !== null) {
			throw(new mysqli_sql_exception("not a new Id"));
		}

		// creates a query template
		$query = "INSERT INTO loginSource(loginSourceId, sourceName) VALUES(?, ?)";
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

	/**
	 * deletes this loginSource from mySQL
	 * @param $mysqli pointer to mySQL connection, by referenc
	 * @throws mysqli_sql_exception when mySQL related errors occur
	 */

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

	/**
	 * updates this loginSource in mySQL
	 * @param $mysqli pointer to mySQL connection, by reference
	 * @return mixed loginSource if found or null if not found
	 * @throws mysqli_sql_exception when mySQL related errors occur
	 */

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

	/**
	 * gets the loginSource information by loginSourceId
	 * @param $mysqli pointer to mySQL connection, by reference
	 * @return loginSource|null if the user is not found
	 * @throws Exception if it did not pass the throw
	 */

	public static function getLoginSourceByLoginSourceId(&$mysqli, $loginSourceId)
	{
		// handle degenerate cases
		if(gettype($mysqli) !== "object" || get_class($mysqli) !== "mysqli") {
			throw(new mysqli_sql_exception("input is not a mysqli object"));
		}

		// sanitize the loginSourceId before searching
		if ($loginSourceId = filter_var($loginSourceId, FILTER_VALIDATE_INT)=== false) {
			throw(new Exception("$loginSourceId is not a number"));
		}

		// create query template
		$query = "SELECT loginSourceId, sourceName FROM loginSource WHERE loginSourceId = ?";
		$statement = $mysqli->prepare($query);
		if($statement === false) {
			throw(new mysqli_sql_exception("Unable to prepare statement"));
		}

		// bind the it to the place holder in the template
		$wasClean = $statement->bind_param("i", $loginSourceId);
		if($wasClean === false) {
			throw(new mysqli_sql_exception("Unable to bind parameters"));
		}

		// execute the statement
		if($statement->execute() === false) {
			throw(new mysqli_sql_exception("Not able to execute the mySQL statement"));
		}

		// get result from the SELECT query
		$result = $statement->get_result();
		if($result === false) {
			throw(new mysqli_sql_exception("Unable to get result set"));
		}

		// since this is a unique field, this will only return 0 or 1 results. So...
		// 1) if there's a result, we can make it into a the loginSource
		// 2) if there's no result, we can just return null
		$row = $result->fetch_assoc(); // fetch_assoc() returns a row as an associative array

		// convert the associative array to loginSource
		if($row !== null) {
			try {
				$loginSourceObject = new loginSource($row["loginSourceId"], $row["sourceName"]);
			} catch(Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new mysqli_sql_exception("Unable to convert row to User", 0, $exception));
			}

			// if we got here, the loginSource is good - return it
			return ($loginSourceObject);
		} else {
			// 404 User not found - return the null instead
			return (null);
		}
	}
}

?>