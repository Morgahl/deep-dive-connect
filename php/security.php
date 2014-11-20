<?php

/**
 * Author Joseph Bottone
 * http://josephmichaelbottone.com
 * bottone.joseph@gmail.
 * http://thundermedia.com
 **/

class Security
{
	/**
	 * INT this is the primary key
	 */
	private $securityId;
	/**
	 * VAR this is the decription
	 */
	private $description;
	/**
	 * VAR this is isDefault
	 */
	private $isDefault;
	/**
	 * VAR this is createTopic
	 */
	private $createTopic;
	/**
	 * VAR this is createTopic
	 */
	private $canEditOther;
	/**
	 * VAR this is canEditOther
	 */
	private $canPromote;
	/**
	 * VAR this is canPromote
	 */
	private $siteAdmin;
	/**
	 * Constructor of User
	 *
	 *
	 * @param int $securityId
	 * @param string $description
	 * @param string $isDefault
	 * @param string $canEditOther
	 * @param string $canPromote
	 * @param int $siteAdmin
	 */
	public function __construct($securityId, $description, $isDefault, $createTopic, $canEditOther, $canPromote,
										 $siteAdmin)
	{
		try {
			$this->setSecurityId($securityId);
			$this->setDescription($description);
			$this->setIsDefault($isDefault);
			$this->setCreateTopic($createTopic);
			$this->setCanEditOther($canEditOther);
			$this->setCanPromote($canPromote);
			$this->setSiteAdmin($siteAdmin);
		} catch(UnexpectedValueException $unexpectedValue) {
			// rethrow to the seller
			throw(new UnexpectedValueException("Unable to construct securityId, 0, $unexpectedValue"));
		} catch(RangeException $range) {
			// rethrow to the caller
			throw(new RangeException("Unable to construct securityId", 0, $range));
		}
	}
	/**
	 * gets value of securityId
	 *
	 */
	public function getSecurityId()
	{
		return ($this->securityId);
	}

	/**
	 * sets the value of securityId
	 *
	 */

	public function setSecurityId($securityId)
	{
		if($securityId === null) {
			$this->securityId = null;
			return;
		}

		//  ensure the securityId is an integer
		if(filter_var($securityId, FILTER_VALIDATE_INT) === false) {
			throw(new UnexpectedValueException("securityId $securityId is not valid"));
		}

		$securityId = intval($securityId);
		if($securityId <= 0) {
			throw(new RangeException("securityId $securityId is not positive"));
		}

		// finally, take the securityId out of quarantine and assign it
		$this->securityId = $securityId;
	}
	/**
	 * gets value of $description
	 *
	 */

	public function getDescription()
	{
		return ($this->description);
	}

	/**
	 * sets the value of description
	 *
	 */

	public function setDescription($description)
	{
		// description should never be null
		if($description === null) {
			throw(new UnexpectedValueException("Topic Body must not be null"));
		}
// sanitize string
		$description = trim($description);
		if(($description = filter_var($description, FILTER_SANITIZE_STRING)) === false) {
			throw(new UnexpectedValueException("Not a valid string"));
		}

		// enforce 256 character limit to ensure no truncation of data when inserting to database
		if(strlen($description) > 256) {
			throw(new RangeException("Description must be 256 characters or less in length"));
		}
		// take description out of quarantine and assign it
		$this->description = $description;

	}
	/**
	 * gets the value of isDefault
	 *
	 */
	public function getIsDefault()
	{
		return ($this->isDefault);
	}

	/**
	 * sets the value of isDefault
	 *
	 */

	public function setIsDefault($isDefault)
	{
		// allow the isDefault to be null if a new object

		if($isDefault === null) {
			$this->isDefault = null;
			return;
		}

		//  ensure the isDefault is an integer

		if(filter_var($isDefault, FILTER_VALIDATE_INT) === false) {
			throw(new UnexpectedValueException("description $isDefault is not numeric"));
		}

		$isDefault = intval($isDefault);
		if($isDefault < 0 || $isDefault > 1) {
			throw(new RangeException("isDefault $isDefault is not a 1 or 0"));
		}

		// take isDefault out of quarantine and assign it
		$this->isDefault = $isDefault;

	}

	/**
	 * gets the value of createTopic
	 *
	 */

	public function getCreateTopic()
	{
		return ($this->createTopic);
	}

	/**
	 * sets the value of CreateTopic
	 *
	 */

	public function setCreateTopic($createTopic)
	{
		// allow the createTopic to be null if a new object

		if($createTopic === null) {
			$this->createTopic = null;
			return;
		}

		//  ensure the createTopic is an integer

		if(filter_var($createTopic, FILTER_VALIDATE_INT) === false) {
			throw(new UnexpectedValueException("description $createTopic is not numeric"));
		}

		$createTopic = intval($createTopic);
		if($createTopic <= 0) {
			throw(new RangeException("createTopic $createTopic is not positive"));
		}

		// take createTopic out of quarantine and assign it
		$this->createTopic = $createTopic;
	}

	/**
	 * gets the value of canEditOthe
	 *
	 */

	public function getCanEditOther()
	{
		return ($this->canEditOther);
	}

	/**
	 * sets the value of canEditOther
	 *
	 */

	public function setCanEditOther($canEditOther)
	{
		// allow the canEditOther to be null if a new object

		if($canEditOther === null) {
			$this->canEditOther = null;
			return;
		}

		//  ensure the canEditOther is an integer

		if(filter_var($canEditOther, FILTER_VALIDATE_INT) === false) {
			throw(new UnexpectedValueException("description $canEditOther is not numeric"));
		}

		$canEditOther = intval($canEditOther);
		if($canEditOther <= 0) {
			throw(new RangeException("canEditOther $canEditOther is not positive"));
		}

		// take canEditOther out of quarantine and assign it
		$this->canEditOther = $canEditOther;

	}

	/**
	 * gets the value of canPromote
	 *
	 */

	public function getCanPromote()
	{
		return ($this->canPromote);
	}

	/**
	 * sets the value of canPromote
	 *
	 */

	public function setCanPromote($canPromote)
	{
		// allow the canPromote to be null if a new object

		if($canPromote === null) {
			$this->canPromote = null;
			return;
		}

		//  ensure the canPromote is an integer

		if(filter_var($canPromote, FILTER_VALIDATE_INT) === false) {
			throw(new UnexpectedValueException("description $canPromote is not numeric"));
		}

		$canPromote = intval($canPromote);
		if($canPromote <= 0) {
			throw(new RangeException("canPromote $canPromote is not positive"));
		}

		// take canPromote out of quarantine and assign it
		$this->canPromote = $canPromote;

	}

	/**
	 * gets the value of siteAdmin
	 *
	 */

	public function getSiteAdmin()
	{
		return ($this->siteAdmin);
	}

	/**
	 * sets the value of siteAdmin
	 *
	 */

	public function setSiteAdmin($siteAdmin)
	{
		// allow the siteAdmin to be null if a new object

		if($siteAdmin === null) {
			$this->siteAdmin = null;
			return;
		}

		//  ensure the siteAdmin is an integer

		if(filter_var($siteAdmin, FILTER_VALIDATE_INT) === false) {
			throw(new UnexpectedValueException("description $siteAdmin is not numeric"));
		}

		$siteAdmin = intval($siteAdmin);
		if($siteAdmin <= 0) {
			throw(new RangeException("siteAdmin $siteAdmin is not positive"));
		}

		// take siteAdmin out of quarantine and assign it
		$this->siteAdmin = $siteAdmin;

	}

	/**
	 * insert this User to mySQL
	 *
	 */

	public function insert(&$mysqli)
	{
		if(gettype($mysqli) !== "object" || get_class($mysqli) !== "mysqli") {
			throw(new mysqli_sql_exception("input is not a mysqli object"));
		}

		// enforces that the securityId is null
		if($this->securityId !== null) {
			throw(new mysqli_sql_exception("not a new Id"));
		}

		// creates a query template
		$query = "INSERT INTO security(description, isDefault, createTopic, canEditOther, canPromote, siteAdmin) VALUES(?, ?, ?, ?, ?, ?)";
		$statement = $mysqli->prepare($query);
		if($statement === false) {
			throw(new mysqli_sql_exception("Unable to prepare statement"));

		}

		// just bind the member variables to the place holders in the template
		$wasClean = $statement->bind_param("siiiii", $this->description, $this->isDefault, $this->createTopic, $this->canEditOther, $this->canPromote, $this->siteAdmin);
		if($wasClean === false) {
			throw(new mysqli_sql_exception("Unable to bind parameters"));
		}

		// execute the statement
		if($statement->execute() === false) {
			throw(new mysqli_sql_exception("Unable to execute mySQL statement"));
		}

		// update the null securityId with what mySQL just gave us
		$this->securityId = $mysqli->insert_id;
	}
	/**
	 * deletes this from mySQL
	 *.
	 */
	public function delete(&$mysqli)
	{
		// handle degenerate cases
		if(gettype($mysqli) !== "object" || get_class($mysqli) !== "mysqli") {
			throw(new mysqli_sql_exception("input is not a mysqli object"));
		}

		// enforce the securityId is not null
		if($this->securityId === null) {
			throw(new mysqli_sql_exception("Unable to delete a securityId that does not exist"));
		}

		// create query template
		$query = "DELETE FROM security WHERE securityId = ?";
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
	/**
	updates this securityClass in mySQL
	**/

	public function update(&$mysqli)
	{
		// handle degenerate cases
		if(gettype($mysqli) !== "object" || get_class($mysqli) !== "mysqli") {
			throw(new mysqli_sql_exception("input is not a mysqli object"));
		}

		// enforce the securityId is not null (i.e., don't update a author that hasn't been inserted)
		if($this->securityId === null) {
			throw(new mysqli_sql_exception("Unable to update a securityId that does not exist"));
		}

		// create query template
		$query = "UPDATE security SET description = ?, isDefault = ?, createTopic = ?, canEditOther = ?, canPromote = ?, siteAdmin = ? WHERE securityId = ?";
		$statement = $mysqli->prepare($query);
		if($statement === false) {
			throw(new mysqli_sql_exception("Unable to prepare statement"));
		}

		// bind the member variables to the place holders in the template
		$wasClean = $statement->bind_param("siiiiii", $this->description, $this->isDefault, $this->createTopic,
			$this->canEditOther, $this->canPromote, $this->siteAdmin, $this->securityId);
		if($wasClean === false) {
			throw(new mysqli_sql_exception("Unable to bind parameters"));
		}

		// execute the statement
		if($statement->execute() === false) {
			throw(new mysqli_sql_exception("Unable to execute mySQL statement"));

		}
	}

	/**
	 * gets the security information by securityId
	 * @param $mysqli
	 * @param $securityId
	 * @return null|Security
	 * @throws Exception
	 */

	public static function getSecurityBySecurityId(&$mysqli, $securityId)
	{
		// handle degenerate cases
		if(gettype($mysqli) !== "object" || get_class($mysqli) !== "mysqli") {
			throw(new mysqli_sql_exception("input is not a mysqli object"));
		}

		// sanitize the securityId before searching
		if ($securityId = filter_var($securityId, FILTER_VALIDATE_INT)=== false) {
			throw(new Exception("$securityId is not a number"));
		}



		// create query template
		$query = "SELECT securityId, description, isDefault, createTopic, canEditOther, canPromote, siteAdmin FROM security WHERE securityId = ?";
		$statement = $mysqli->prepare($query);
		if($statement === false) {
			throw(new mysqli_sql_exception("Unable to prepare statement"));
		}

		// bind the description to the place holder in the template
		$wasClean = $statement->bind_param("i", $securityId);
		if($wasClean === false) {
			throw(new mysqli_sql_exception("Unable to bind parameters"));
		}

		// execute the statement
		if($statement->execute() === false) {
			throw(new mysqli_sql_exception("Unable to execute mySQL statement"));
		}

		// get result from the SELECT query
		$result = $statement->get_result();
		if($result === false) {
			throw(new mysqli_sql_exception("Unable to get result set"));
		}

		// since this is a unique field, this will only return 0 or 1 results. So...
		// 1) if there's a result, we can make it into a the Security
		// 2) if there's no result, we can just return null
		$row = $result->fetch_assoc(); // fetch_assoc() returns a row as an associative array

		// convert the associative array to Security
		if($row !== null) {
			try {
				$securityObject = new Security($row["securityId"], $row["description"], $row["isDefault"], $row["createTopic"], $row["canEditOther"], $row["canPromote"], $row["siteAdmin"]);
			} catch(Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new mysqli_sql_exception("Unable to convert row to User", 0, $exception));
			}

			// if we got here, the Security is good - return it
			return ($securityObject);
		} else {
			// 404 User not found - return null instead
			return (null);
		}
	}
}

?>