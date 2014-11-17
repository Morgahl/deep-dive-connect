<?php
/**
 * MySQL Enabled Topic
 *
 * This is a MySQL enabled container for Topic topic and handling.
 *
 * @author Marc Hayes <marc.hayes.tech@gmail.com>
 */
class Topic {
	/**
	 * @var $topicID INT topicId for the Topic; this is the primary key
	 */
	private $topicId;
	/**
	 * @var $profileId; INT profileId for the Topic; FK to profile table
	 */
	private $profileId;
	/**
	 * @var $topicDate DATETIME topic date for the Topic; format(Y-m-d H-i-s)
	 */
	private $topicDate;
	/**
	 * @var $topicSubject STRING this is the subject for the Topic, 256 character limit
	 */
	private $topicSubject;
	/**
	 * @var $topicBody STRING this is the body for the Topic; 4096 character limit
	 */
	private $topicBody;

	/**
	 * Constructor for Topic
	 *
	 * @param $newTopicId INT topicId (or null if new object)
	 * @param $newProfileId INT profileId (profileId of creator)
	 * @param $newTopicDate STRING topic date of new Topic; format(Y-m-d H-i-s)
	 * @param $newTopicSubject STRING subject of new Topic; 256 character limit
	 * @param $newTopicBody STRING body of new Topic; 4096 character limit
	 * @throws UnexpectedValueException when a parameter is of the wrong type
	 * @throes RangeException when a parameter is invalid
	 */
	function __construct($newTopicId, $newProfileId, $newTopicDate, $newTopicSubject, $newTopicBody) {
		try{$this->setTopicId($newTopicId);
			$this->setProfileId($newProfileId);
			$this->setTopicDate($newTopicDate);
			$this->setTopicSubject($newTopicSubject);
			$this->setTopicBody($newTopicBody);
		} catch(UnexpectedValueException $unexpectedValue) {
			// rethrow to caller
			throw(new UnexpectedValueException("Unable to construct Topic", 0, $unexpectedValue));
		} catch(RangeException $range) {
			// rethrow to caller
			throw(new RangeException("Unable to construct Topic", 0, $range));
		}
	}

	/**
	 * Magic method that returns object state as a string
	 *
	 * @return STRING returns object state as a string
	 */
	function __toString()
	{
		// convert datetime object to string
		$topicDateString = $this->topicDate->format("Y-m-d H:i:s");

		// return string
		return("topicId: $this->topicId<br>" .
			"profileId: $this->profileId<br>" .
			"topicDate: $topicDateString<br>" .
			"topicSubject: $this->topicSubject<br>" .
			"topicBody: $this->topicBody<br>");
	}

	/**
	 * Returns topicId (or null if new object)
	 *
	 * @return INT or NULL if new object; topicId primary key of Topic
	 */
	public function getTopicId() {
		return $this->topicId;
	}

	/**
	 * Returns profileId
	 *
	 * @return INT profileId foreign key of Topic
	 */
	public function getProfileId() {
		return $this->profileId;
	}

	/**
	 * Returns topicDate
	 *
	 * @return DATETIME date and time of Topic
	 */
	public function getTopicDate() {
		return $this->topicDate;
	}

	/**
	 * Returns topicSubject
	 *
	 * @return STRING subject of Topic
	 */
	public function getTopicSubject() {
		return $this->topicSubject;
	}

	/**
	 * Returns topicBody
	 *
	 * @return STRING body of Topic
	 */
	public function getTopicBody() {
		return $this->topicBody;
	}

	/**
	 * Sets the value of topicId
	 *
	 * @param $newTopicId INT topic Id (or null if new object)
	 * @throws UnexpectedValueException if profileId is not an integer
	 * @throws RangeException if profileId is not positive
	 */
	public function setTopicId($newTopicId) {
		// allow the topicId to be null if a new object
		if($newTopicId === null) {
			$this->topicId = null;
			return;
		}

		// ensure that topicId is an int
		if(filter_var($newTopicId, FILTER_VALIDATE_INT) === false) {
			throw(new UnexpectedValueException("Topic ID $newTopicId is not numeric"));
		}

		// convert the topicId to int and enforce that it is positive
		$newTopicId = intval($newTopicId);
		if($newTopicId <= 0) {
			throw(new RangeException("Topic ID $newTopicId is not positive"));
		}

		// take topicId out of quarantine and assign it
		$this->topicId = $newTopicId;
	}

	/**
	 * Sets the value of profileId (profileId of creator)
	 *
	 * @param $newProfileId INT
	 * @throws UnexpectedValueException if profileId is not an integer
	 * @throws RangeException if profileId is not positive
	 */
	public function setProfileId($newProfileId) {
		// profileId should never be null
		if($newProfileId === null) {
			throw(new UnexpectedValueException("Profile ID must not be null"));
		}

		// ensure that profileId is an int
		if(($newProfileId = filter_var($newProfileId, FILTER_VALIDATE_INT)) === false) {
			throw(new UnexpectedValueException("Profile ID $newProfileId is not numeric"));
		}

		// convert the profileId to int and enforce that it is positive
		$newProfileId = intval($newProfileId);
		if($newProfileId <= 0) {
			throw(new RangeException("Profile ID $newProfileId is not positive"));
		}

		// take profileId out of quarantine and assign it
		$this->profileId = $newProfileId;
	}

	/**
	 * Sets the value of topicDate from a valid date string in Y-m-d H:i:s format
	 *
	 * @param $newTopicDate OBJECT or STRING Y-m-d H:i:s format
	 * @throws UnexpectedValueException when a parameter is not a valid date string in Y-m-d H:i:s format
	 */
	public function setTopicDate($newTopicDate) {
		// allow topicDate to be null
		if($newTopicDate === null) {
			$this->topicDate = null;
			return;
		}

		// allow passed date to be in datetime format
		if(gettype($newTopicDate) !== "object" || get_class($newTopicDate) !== "DateTime") {
			$this->topicDate = $newTopicDate;
			return;
		}

		// Sanitize Date input to Y-m-d H:i:s MySQL standard
		// this fails for badly formed strings and nulls
		$newTopicDate = trim($newTopicDate);
		if (($newTopicDate = DateTime::createFromFormat("Y-m-d H:i:s", $newTopicDate)) === false) {
			throw(new UnexpectedValueException("Start date is not valid. Please use Y-m-d H:i:s format"));
		}

		// take topicDate out of quarantine and assign it
		$this->topicDate = $newTopicDate;
	}

	/**
	 * Sets the value of topicSubject
	 *
	 * @param $newTopicSubject STRING 256 character maximum length
	 * @throws UnexpectedValueException when a parameter is of the wrong type
	 * @throes RangeException when a parameter length is invalid
	 */
	public function setTopicSubject($newTopicSubject) {
		// topicSubject should never be null
		if($newTopicSubject === null) {
			throw(new UnexpectedValueException("Topic Subject must not be null"));
		}

		// sanitize string
		$newTopicSubject = trim($newTopicSubject);
		if(($newTopicSubject = filter_var($newTopicSubject, FILTER_SANITIZE_STRING)) === false) {
			throw(new UnexpectedValueException("Not a valid string"));
		}

		// enforce 256 character limit to ensure no truncation of data when inserting to database
		if(strlen($newTopicSubject) > 256) {
			throw(new RangeException("Topic Subject must be 256 characters or less in length"));
		}

		// take topicSubject out of quarantine and assign it
		$this->topicSubject = $newTopicSubject;
	}

	/**
	 * Sets the value of topicBody
	 *
	 * @param $newTopicBody STRING 4096 character maximum length
	 * @throws UnexpectedValueException when a parameter is of the wrong type
	 * @throes RangeException when a parameter length is invalid
	 */
	public function setTopicBody($newTopicBody) {
		// topicBody should never be null
		if($newTopicBody === null) {
			throw(new UnexpectedValueException("Topic Body must not be null"));
		}

		// sanitize string
		$newTopicBody = trim($newTopicBody);
		if(($newTopicBody = filter_var($newTopicBody, FILTER_SANITIZE_STRING)) === false) {
			throw(new UnexpectedValueException("Not a valid string"));
		}

		// enforce 4096 character limit to ensure no truncation of data when inserting to database
		if(strlen($newTopicBody) > 4096) {
			throw(new RangeException("Topic Body must be 4096 characters or less in length"));
		}

		// take topicBody out of quarantine and assign it
		$this->topicBody = $newTopicBody;
	}

	/**
	 * Inserts this Topic into mySQL
	 *
	 * @param $mysqli OBJECT mySQL connection object
	 * @throws mysqli_sql_exception when a MySQL error occurs
	 */
	public function insert(&$mysqli) {
		// handle degenerate cases
		if(gettype($mysqli) !== "object" || get_class($mysqli) !== "mysqli") {
			throw(new mysqli_sql_exception("Input is not a valid mysqli object"));
		}

		// enforce topicId is null
		if($this->topicId !== null) {
			throw(new mysqli_sql_exception("Not a new topic"));
		}

		// enforce profileId is NOT null
		if($this->profileId === null) {
			throw(new mysqli_sql_exception("profileId cannot be null."));
		}

		// enforce topicSubject is NOT null
		if($this->topicSubject === null) {
			throw(new mysqli_sql_exception("topicSubject cannot be null."));
		}

		// enforce topicBody is NOT null
		if($this->topicBody === null) {
			throw(new mysqli_sql_exception("topicBody cannot be null."));
		}

		// create query template
		$query = "INSERT INTO topic (profileId, topicDate, topicSubject, topicBody)
					VALUES (?, NOW(), ?, ?)";

		$statement = $mysqli->prepare($query);
		if($statement === false) {
			throw(new mysqli_sql_exception("Unable to prepare statement"));
		}

		// bind the variables to the place holders in the template
		$wasClean = $statement->bind_param("iss", $this->profileId, $this->topicSubject, $this->topicBody);
		if($wasClean === false) {
			throw(new mysqli_sql_exception("Unable to bind parameters"));
		}

		// execute the statement
		$result = $statement->execute();
		if($result === false) {
			throw(new mysqli_sql_exception("Unable to execute mySQL statement"));
		}

		// update the null topicId
		$this->topicId = $mysqli->insert_id;
	}

	/**
	 * Updates this Topic in mySQL
	 *
	 * @param $mysqli OBJECT mySQL connection object
	 * @throws mysqli_sql_exception when a MySQL error occurs
	 */
	public function update(&$mysqli) {
		// handle degenerate cases
		if(gettype($mysqli) !== "object" || get_class($mysqli) !== "mysqli") {
			throw(new mysqli_sql_exception("Input is not a valid mysqli object"));
		}

		// enforce topicId is NOT null
		if($this->topicId === null) {
			throw(new mysqli_sql_exception("topicId cannot be null."));
		}

		// enforce profileId is NOT null
		if($this->profileId === null) {
			throw(new mysqli_sql_exception("profileId cannot be null."));
		}

		// enforce topicSubject is NOT null
		if($this->topicSubject === null) {
			throw(new mysqli_sql_exception("topicSubject cannot be null."));
		}

		// enforce topicBody is NOT null
		if($this->topicBody === null) {
			throw(new mysqli_sql_exception("topicBody cannot be null."));
		}

		// create query template
		$query = "UPDATE topic
					SET profileId = ?, topicSubject = ?, topicBody = ?
					WHERE topicId = ?";

		$statement = $mysqli->prepare($query);
		if($statement === false) {
			throw(new mysqli_sql_exception("Unable to prepare statement"));
		}

		// prep date for mySQL entry
		$topicDate = $this->topicDate->format("Y-m-d H:i:s");

		// bind the variables to the place holders in the template
		$wasClean = $statement->bind_param("issi", $this->profileId, $this->topicSubject, $this->topicBody, $this->topicId);
		if($wasClean === false) {
			throw(new mysqli_sql_exception("Unable to bind parameters"));
		}

		// execute the statement
		$result = $statement->execute();
		if($result === false) {
			throw(new mysqli_sql_exception("Unable to execute mySQL statement"));
		}
	}

	/**
	 * Deletes this Topic from mySQL
	 *
	 * @param $mysqli OBJECT mySQL connection object
	 * @throws mysqli_sql_exception when a MySQL error occurs
	 */
	public function delete(&$mysqli) {
		// handle degenerate cases
		if(gettype($mysqli) !== "object" || get_class($mysqli) !== "mysqli") {
			throw(new mysqli_sql_exception("Input is not a valid mysqli object"));
		}

		// enforce topicId is NOT null
		if($this->topicId === null) {
			throw(new mysqli_sql_exception("topicId cannot be null."));
		}

		// create query template
		$query = "DELETE FROM topic
					WHERE topicId = ?";

		$statement = $mysqli->prepare($query);
		if($statement === false) {
			throw(new mysqli_sql_exception("Unable to prepare statement"));
		}

		// bind the variables to the place holders in the template
		$wasClean = $statement->bind_param("i", $this->topicId);
		if($wasClean === false) {
			throw(new mysqli_sql_exception("Unable to bind parameters"));
		}

		// execute the statement
		$result = $statement->execute();
		if($result === false) {
			throw(new mysqli_sql_exception("Unable to execute mySQL statement"));
		}
	}

	/**
	 * Creates a new Topic Object from mySQL based on passed topicId
	 *
	 * @param $mysqli OBJECT mySQL connection object
	 * @param $newTopicId INT topicId to retrieve from mySQL
	 * @throws mysqli_sql_exception when a MySQL error occurs
	 * @return OBJECT new Topic is returned or null if id specified is not found
	 */
	public static function getTopicByTopicId(&$mysqli, $newTopicId) {
		// handle degenerate cases
		if(gettype($mysqli) !== "object" || get_class($mysqli) !== "mysqli") {
			throw(new mysqli_sql_exception("Input is not a valid mysqli object"));
		}

		// enforce that topicId is NOT null
		if($newTopicId === null) {
			throw(new UnexpectedValueException("topicId must not be null"));
		}

		// ensure that topicId is an int
		if(filter_var($newTopicId, FILTER_VALIDATE_INT) === false) {
			throw(new UnexpectedValueException("Topic ID $newTopicId is not numeric"));
		}

		// convert the topicId to int and enforce that it is positive
		$newTopicId = intval($newTopicId);
		if($newTopicId <= 0) {
			throw(new RangeException("Topic ID $newTopicId is not positive"));
		}

		// create query template
		$query = "SELECT topicId, profileId, topicDate, topicSubject, topicBody
					FROM topic
					WHERE topicId = ?";

		$statement = $mysqli->prepare($query);
		if($statement === false) {
			throw(new mysqli_sql_exception("Unable to prepare statement"));
		}

		// bind the variables to the place holders in the template
		$wasClean = $statement->bind_param("i", $newTopicId);
		if($wasClean === false) {
			throw(new mysqli_sql_exception("Unable to bind parameters"));
		}

		// execute the statement
		$results = $statement->execute();
		if($results === false) {
			throw(new mysqli_sql_exception("Unable to execute mySQL statement"));
		}

		// get result from the SELECT
		$results = $statement->get_result();
		if($results === false) {
			throw(new mysqli_sql_exception("Unable to get result set"));
		}

		// since this is unique this will return only 1 row
		$row = $results->fetch_assoc();

		//convert assoc array to Topic object
		if($row !== null) {
			try {
				$topics = new Topic($row["topicId"], $row["profileId"], $row["topicDate"], $row["topicSubject"], $row["topicBody"]);
			} catch(Exception $exception) {
				// if the row could not be converted throw it
				throw(new mysqli_sql_exception("Unable to process result set"));
			}
			// if we got here, the Topic is good
			return($topics);
		} else {
			// no result found return null
			return(null);
		}
	}

	/**
	 * Returns an array of the N most recent Topic objects based on most
	 * recent commentDate in topic or topicDate if no commentDate is assoc.
	 *
	 * @param $mysqli OBJECT mySQL connection object
	 * @param $limit INT top N records returned based on this int
	 * @throws mysqli_sql_exception when a MySQL error occurs
	 * @return ARRAY new array of Topics is returned or null if none are found
	 */
	public static function getRecentTopics(&$mysqli, $limit) {
		// handle degenerate cases
		if(gettype($mysqli) !== "object" || get_class($mysqli) !== "mysqli") {
			throw(new mysqli_sql_exception("Input is not a valid mysqli object"));
		}

		// enforce that limit is NOT null
		if($limit === null) {
			throw(new UnexpectedValueException("Limit must not be null"));
		}

		// ensure that limit is an int
		if(filter_var($limit, FILTER_VALIDATE_INT) === false) {
			throw(new UnexpectedValueException("Limit $limit is not numeric"));
		}

		// convert the limit to int and enforce that it is positive
		$limit = intval($limit);
		if($limit <= 0) {
			throw(new RangeException("Limit ID $limit is not positive"));
		}

		// create query template
		$query = "SELECT t.topicId,
 						t.profileId,
 						COALESCE(MAX(c.commentDate), t.topicDate) AS topicDate,
 						t.topicSubject,
 						t.topicBody
					FROM topic t
					LEFT JOIN comment c ON t.topicId = c.topicId
					GROUP BY t.topicId
					ORDER BY COALESCE(MAX(c.commentDate), t.topicDate) DESC, t.topicId DESC
					LIMIT ?;";

		$statement = $mysqli->prepare($query);
		if($statement === false) {
			throw(new mysqli_sql_exception("Unable to prepare statement"));
		}

		// bind the variable to the place holder for the template
		$wasClean = $statement->bind_param("i", $limit);
		if($wasClean === false) {
			throw(new mysqli_sql_exception("Unable to bind parameters"));
		}

		// execute the statement
		$results = $statement->execute();
		if($results === false) {
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

			// step through results array and convert to Topic objects
			foreach ($results as $index => $row) {
				$results[$index] = new Topic($row["topicId"], $row["profileId"], $row["topicDate"], $row["topicSubject"], $row["topicBody"]);
			}

			// return resulting array of Topic objects
			return($results);
		} else {
			return(null);
		}
	}
}