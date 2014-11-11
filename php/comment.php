<?php
/**
 * MySQL Enabled Comment
 *
 * This is a MySQL enabled container for Comment creation and handling.
 *
 * @author Marc Hayes <marc.hayes.tech@gmail.com>
 */
class Comment {
	/**
	 * @var $commentId INT commentId for the Comment; this is the Primary Key
	 */
	private $commentId;
	/**
	 * @var $topicId INT topicId for the Comment; FK to topic table
	 */
	private $topicId;
	/**
	 * @var $profileId INT profileId for the Comment; FK to the profile table
	 */
	private $profileId;
	/**
	 * @var $commentDate DATETIME comment date for the Comment; format(Y-m-d H:i:s)
	 */
	private $commentDate;
	/**
	 * @var $commentSubject STRING this is the subject of the comment; 256 character limit
	 */
	private $commentSubject;
	/**
	 * @var $commentBody STRING this is the subject of the comment; 1024 character limit
	 */
	private $commentBody;

	/**
	 * Constructor for Comment
	 *
	 * @param $newCommentId INT commentId (or null if new object)
	 * @param $newTopicId INT topicId (topicId of creator)
	 * @param $newProfileId INT profileId (profileId of creator)
	 * @param $newCommentDate STRING date of new Topic; format(Y-m-d H-i-s)
	 * @param $newCommentSubject STRING subject of new Comment; 256 character limit
	 * @param $newCommentBody STRING subject of new Comment; 1024 character limit
	 * @throws UnexpectedValueException when a parameter is of the wrong type
	 * @throes RangeException when a parameter is invalid
	 */
	function __construct($newCommentId, $newTopicId, $newProfileId, $newCommentDate, $newCommentSubject, $newCommentBody) {
		try{
			$this->setCommentId($newCommentId);
			$this->setTopicId($newTopicId);
			$this->setProfileId($newProfileId);
			$this->setCommentDate($newCommentDate);
			$this->setCommentSubject($newCommentSubject);
			$this->setCommentBody($newCommentBody);
		} catch(UnexpectedValueException $unexpectedValue) {
			// rethrow to caller
			throw(new UnexpectedValueException("Unable to construct Comment", 0, $unexpectedValue));
		} catch(RangeException $range) {
			// rethrow to caller
			throw(new RangeException("Unable to construct Comment", 0, $range));
		}
	}

	/**
	 * Magic method that returns object state as a string
	 *
	 * @return STRING returns object state as a string
	 */
	function __toString() {
		// process dates into strings
		$commentDateString = $this->commentDate->format("Y-m-d H:i:s");

		// return string to caller
		return("commentId: $this->commentId<br>" .
			"topicId: $this->topicId<br>" .
			"profileId: $this->profileId<br>" .
			"commentDate: $commentDateString<br>" .
			"commentSubject: $this->commentSubject<br>" .
			"commentBody: $this->commentBody<br>");
	}

	/**
	 * Magic method for getting state information
	 *
	 * @param $name STRING name of instance variable
	 * @return mixed returns value of variable requested by name
	 */
	public function __get($name) {
		return($this->$name);
	}

	/**
	 * Sets the value of commentId
	 *
	 * @param $newCommentId INT commentId (or null if new object)
	 * @throws UnexpectedValueException if commentId is not an integer
	 * @throws RangeException if commentId is not positive
	 */
	public function setCommentId($newCommentId) {
		// allow the commentId to be null if a new object
		if($newCommentId === null) {
			$this->commentId = null;
			return;
		}

		// ensure that commentId is an int
		if(filter_var($newCommentId, FILTER_VALIDATE_INT) === false) {
			throw(new UnexpectedValueException("Comment ID $newCommentId is not numeric"));
		}

		// convert the commentId to int and enforce that it is positive
		$newCommentId = intval($newCommentId);
		if($newCommentId <= 0) {
			throw(new RangeException("Comment ID $newCommentId is not positive"));
		}

		// take commentId out of quarantine and assign it
		$this->commentId = $newCommentId;
	}

	/**
	 * Sets the value of topicId (topicId of creator)
	 *
	 * @param $newTopicId INT topicId (topicId of creator)
	 * @throws UnexpectedValueException if topicId is not an integer
	 * @throws RangeException if topicId is not positive
	 */
	public function setTopicId($newTopicId) {
		// topicId should never be null
		if($newTopicId === null) {
			throw(new UnexpectedValueException("Topic ID must not be null"));
		}

		// ensure that topicId is an int
		if(($newTopicId = filter_var($newTopicId, FILTER_VALIDATE_INT)) === false) {
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
	 * @param $newProfileId INT profileId (profileId of creator)
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
	 * Sets the value of commentDate from a valid date string in Y-m-d H:i:s format
	 *
	 * @param $newCommentDate STRING Y-m-d H:i:s format
	 * @throws UnexpectedValueException when a parameter is not a valid date string in Y-m-d H:i:s format
	 */
	public function setCommentDate($newCommentDate) {
		// Sanitize Date input to Y-m-d H:i:s MySQL standard
		// this fails for badly formed strings and nulls
		$newCommentDate = trim($newCommentDate);
		if (($newCommentDate = DateTime::createFromFormat("Y-m-d H:i:s", $newCommentDate)) === false) {
			throw(new UnexpectedValueException("Start date is not valid. Please use Y-m-d H:i:s format"));
		}

		// take commentDate out of quarantine and assign it
		$this->commentDate = $newCommentDate;
	}

	/**
	 * Sets the value of commentSubject
	 *
	 * @param $newCommentSubject STRING 256 character maximum length
	 * @throws UnexpectedValueException when a parameter is of the wrong type
	 * @throes RangeException when a parameter length is invalid
	 */
	public function setCommentSubject($newCommentSubject) {
		// commentSubject can be null when inheriting from topic
		if($newCommentSubject === null) {
			return(null);
		}

		// sanitize string
		$newCommentSubject = trim($newCommentSubject);
		if(($newCommentSubject = filter_var($newCommentSubject, FILTER_SANITIZE_STRING)) === false) {
			throw(new UnexpectedValueException("Not a valid string"));
		}

		// enforce 256 character limit to ensure no truncation of data when inserting to database
		if(strlen($newCommentSubject) > 256) {
			throw(new RangeException("Comment Subject must be 256 characters or less in length"));
		}

		// take commentSubject out of quarantine and assign it
		$this->commentSubject = $newCommentSubject;
	}

	/**
	 * Sets the value of commentBody
	 *
	 * @param $newCommentBody STRING 1024 character maximum length
	 * @throws UnexpectedValueException when a parameter is of the wrong type
	 * @throes RangeException when a parameter length is invalid
	 */
	public function setCommentBody($newCommentBody) {
		// commentBody should never be null
		if($newCommentBody === null) {
			throw(new UnexpectedValueException("Comment Body must not be null"));
		}

		// sanitize string
		$newCommentBody = trim($newCommentBody);
		if(($newCommentBody = filter_var($newCommentBody, FILTER_SANITIZE_STRING)) === false) {
			throw(new UnexpectedValueException("Not a valid string"));
		}

		// enforce 1024 character limit to ensure no truncation of data when inserting to database
		if(strlen($newCommentBody) > 1024) {
			throw(new RangeException("Comment Body must be 1024 characters or less in length"));
		}

		// take commentBody out of quarantine and assign it
		$this->commentBody = $newCommentBody;
	}

	/**
	 * Inserts this Comment into mySQL
	 *
	 * @param $mysqli OBJECT mySQL connection object
	 * @throws mysqli_sql_exception when a MySQL error occurs
	 */
	public function insert(&$mysqli) {
		// handle degenerate cases
		if(gettype($mysqli) !== "object" || get_class($mysqli) !== "mysqli") {
			throw(new mysqli_sql_exception("Input is not a valid mysqli object"));
		}

		// enforce commentId is null
		if($this->commentId !== null) {
			throw(new mysqli_sql_exception("Not a new comment."));
		}

		// enforce topicId is NOT null
		if($this->topicId === null) {
			throw(new mysqli_sql_exception("topicId cannot be null."));
		}

		// enforce profileId is NOT null
		if($this->profileId === null) {
			throw(new mysqli_sql_exception("profileId cannot be null."));
		}

		// enforce commentBody is NOT null
		if($this->commentBody === null) {
			throw(new mysqli_sql_exception("commentBody cannot be null."));
		}

		// create query template
		$query = "INSERT INTO comment (topicId, profileId, commentDate, commentSubject, commentBody)
					VALUES (?, ?, NOW(), ?, ?)";

		$statement = $mysqli->prepare($query);
		if($statement === false) {
			throw(new mysqli_sql_exception("Unable to prepare statement"));
		}

		// bind the variables to the place holders in the template
		$wasClean = $statement->bind_param("iiss", $this->topicId, $this->profileId, $this->commentSubject, $this->commentBody);
		if($wasClean === false) {
			throw(new mysqli_sql_exception("Unable to bind parameters"));
		}

		// execute the statement
		$result = $statement->execute();
		if($result === false) {
			throw(new mysqli_sql_exception("Unable to execute mySQL statement"));
		}

		// update the null commentId
		$this->commentId = $mysqli->insert_id;
	}

	/**
	 * Updates this Comment in mySQL
	 *
	 * @param $mysqli OBJECT mySQL connection object
	 * @throws mysqli_sql_exception when a MySQL error occurs
	 */
	public function update(&$mysqli) {
		// handle degenerate cases
		if(gettype($mysqli) !== "object" || get_class($mysqli) !== "mysqli") {
			throw(new mysqli_sql_exception("Input is not a valid mysqli object"));
		}

		// enforce commentId is NOT null
		if($this->commentId === null) {
			throw(new mysqli_sql_exception("Not a new comment."));
		}

		// enforce topicId is NOT null
		if($this->topicId === null) {
			throw(new mysqli_sql_exception("topicId cannot be null."));
		}

		// enforce profileId is NOT null
		if($this->profileId === null) {
			throw(new mysqli_sql_exception("profileId cannot be null."));
		}

		// enforce commentBody is NOT null
		if($this->commentBody === null) {
			throw(new mysqli_sql_exception("commentBody cannot be null."));
		}

		// create query template
		$query = "UPDATE comment
					SET topicId = ?, profileId = ?, commentSubject = ?, commentBody = ?
					WHERE commentId = ?";

		$statement = $mysqli->prepare($query);
		if($statement === false) {
			throw(new mysqli_sql_exception("Unable to prepare statement"));
		}

		// bind the variables to the place holders in the template
		$wasClean = $statement->bind_param("iiss", $this->topicId, $this->profileId, $this->commentSubject, $this->commentBody);
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
	 * Deletes this Comment from mySQL
	 *
	 * @param $mysqli OBJECT mySQL connection object
	 * @throws mysqli_sql_exception when a MySQL error occurs
	 */
	public function delete(&$mysqli) {
		// handle degenerate cases
		if(gettype($mysqli) !== "object" || get_class($mysqli) !== "mysqli") {
			throw(new mysqli_sql_exception("Input is not a valid mysqli object"));
		}

		// enforce commentId is NOT null
		if($this->commentId === null) {
			throw(new mysqli_sql_exception("topicId cannot be null."));
		}

		// create query template
		$query = "DELETE FROM comment
					WHERE commentId = ?";

		$statement = $mysqli->prepare($query);
		if($statement === false) {
			throw(new mysqli_sql_exception("Unable to prepare statement"));
		}

		// bind the variables to the place holders in the template
		$wasClean = $statement->bind_param("i", $this->commentId);
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
	 * Creates a new Comment Object from mySQL base on passed commentId
	 *
	 * @param $mysqli OBJECT mySQL connection object
	 * @param $newCommentId INT commentId to retrieve from mySQL
	 * @throws mysqli_sql_exception when a MySQL error occurs
	 * @return OBJECT new Comment is returned or null if id specified is not found
	 */
	public static function getCommentByCommentId(&$mysqli, $newCommentId) {
		// handle degenerate cases
		if(gettype($mysqli) !== "object" || get_class($mysqli) !== "mysqli") {
			throw(new mysqli_sql_exception("Input is not a valid mysqli object"));
		}

		// enforce that newCommentId is NOT null
		if($newCommentId === null) {
			throw(new UnexpectedValueException("commentId must not be null"));
		}

		// ensure that newCommentId is an int
		if(filter_var($newCommentId, FILTER_VALIDATE_INT) === false) {
			throw(new UnexpectedValueException("Comment ID $newCommentId is not numeric"));
		}

		// convert the newCommentId to int and enforce that it is positive
		$newCommentId = intval($newCommentId);
		if($newCommentId <= 0) {
			throw(new RangeException("Comment ID $newCommentId is not positive"));
		}

		// create query template
		$query = "SELECT commentId, topicId, profileId, commentDate, commentSubject, commentBody
					FROM comment
					WHERE commentId = ?";

		$statement = $mysqli->prepare($query);
		if($statement === false) {
			throw(new mysqli_sql_exception("Unable to prepare statement"));
		}

		// bind the variables to the place holders in the template
		$wasClean = $statement->bind_param("i", $newCommentId);
		if($wasClean === false) {
			throw(new mysqli_sql_exception("Unable to bind parameters"));
		}

		// execute the statement
		$result = $statement->execute();
		if($result === false) {
			throw(new mysqli_sql_exception("Unable to execute mySQL statement"));
		}

		// get result from the SELECT
		$result = $statement->get_result();
		if($result === false) {
			throw(new mysqli_sql_exception("Unable to get result set"));
		}

		// since this is unique this will return only 1 row
		$row = $result->fetch_assoc();

		//convert assoc array to Comment object
		if($row !== null) {
			try {
				$comment = new Comment($row["commentId"], $row["topicId"], $row["profileId"], $row["commentDate"], $row["commentSubject"], $row["commentBody"]);
			} catch(Exception $exception) {
				// if the row could not be converted throw it
				throw(new mysqli_sql_exception("Unable to process result set"));
			}
			// if we got here, the Comment is good
			return($comment);
		} else {
			// no result found return null
			return(null);
		}
	}

	/**
	 * Returns an array of Comment object based on passed topicId objects.
	 *
	 * @param $mysqli OBJECT mySQL connection object
	 * @param $newTopicId INT topicId to retrieve comments for from mySQL
	 * @param $limit INT top N records returned based on this int
	 * @param $page INT page of records being sought
	 * @return ARRAY of Comment objects or null if no records found
	 */
	public static function getCommentsByTopicId(&$mysqli, $newTopicId, $limit, $page) {
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

		// enforce that limit is NOT null
		if($limit === null) {
			throw(new UnexpectedValueException("limit must not be null"));
		}

		// ensure that limit is an int
		if(filter_var($limit, FILTER_VALIDATE_INT) === false) {
			throw(new UnexpectedValueException("Limit $limit is not numeric"));
		}

		// convert the limit to int and enforce that it is positive
		$limit = intval($limit);
		if($limit <= 0) {
			throw(new RangeException("Limit $limit is not positive"));
		}

		// enforce that page is NOT null
		if($page === null) {
			throw(new UnexpectedValueException("page must not be null"));
		}

		// ensure that page is an int
		if(filter_var($page, FILTER_VALIDATE_INT) === false) {
			throw(new UnexpectedValueException("Page $page is not numeric"));
		}

		// convert the page to int and enforce that it is positive
		$page = intval($page);
		if($page <= 0) {
			throw(new RangeException("page $page is not positive"));
		}

		// create query template
		$query = "SELECT commentId, topicId, profileId, commentDate, commentSubject, commentBody
					FROM comment
					WHERE topicId = ?
					ORDER BY commentDate
					LIMIT ?
					OFFSET ?";

		$statement = $mysqli->prepare($query);
		if($statement === false) {
			throw(new mysqli_sql_exception("Unable to prepare statement"));
		}

		// prep offset from page and limit values
		$offset = ($page - 1) * $limit;

		// bind the variables to the place holders in the template
		$wasClean = $statement->bind_param("iii", $newTopicId, $limit, $offset);
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

		// get results
		$results = $statement->get_result();
		if($results->num_rows > 0) {
			// retrieve results in bulk into an array
			$results = $results->fetch_all(MYSQL_ASSOC);
			if($results === false) {
				throw(new mysqli_sql_exception("Unable to process result set"));
			}

			// step through results array and convert to Comment objects
			foreach ($results as $index => $row) {
				$results[$index] = new Comment($row["commentId"], $row["topicId"], $row["profileId"], $row["commentDate"], $row["commentSubject"], $row["commentBody"]);
			}

			// return resulting array of Comment objects
			return($results);
		} else {
			return(null);
		}
	}

	/**
	 * Returns an array of Comment object based on passed profileId objects.
	 *
	 * @param $mysqli OBJECT mySQL connection object
	 * @param $newProfileId INT profileId to retrieve comments for from mySQL
	 * @param $limit INT top N records returned based on this int
	 * @param $page INT page of records being sought
	 * @return ARRAY of Comment objects or null if no records found
	 */
	public static function getCommentsByProfileId(&$mysqli, $newProfileId, $limit, $page) {
		// handle degenerate cases
		if(gettype($mysqli) !== "object" || get_class($mysqli) !== "mysqli") {
			throw(new mysqli_sql_exception("Input is not a valid mysqli object"));
		}

		// enforce that profileId is NOT null
		if($newProfileId === null) {
			throw(new UnexpectedValueException("profileId must not be null"));
		}

		// ensure that profileId is an int
		if(filter_var($newProfileId, FILTER_VALIDATE_INT) === false) {
			throw(new UnexpectedValueException("Profile ID $newProfileId is not numeric"));
		}

		// convert the profileId to int and enforce that it is positive
		$newProfileId = intval($newProfileId);
		if($newProfileId <= 0) {
			throw(new RangeException("Profile ID $newProfileId is not positive"));
		}

		// enforce that limit is NOT null
		if($limit === null) {
			throw(new UnexpectedValueException("limit must not be null"));
		}

		// ensure that limit is an int
		if(filter_var($limit, FILTER_VALIDATE_INT) === false) {
			throw(new UnexpectedValueException("Limit $limit is not numeric"));
		}

		// convert the limit to int and enforce that it is positive
		$limit = intval($limit);
		if($limit <= 0) {
			throw(new RangeException("Limit $limit is not positive"));
		}

		// enforce that page is NOT null
		if($page === null) {
			throw(new UnexpectedValueException("page must not be null"));
		}

		// ensure that page is an int
		if(filter_var($page, FILTER_VALIDATE_INT) === false) {
			throw(new UnexpectedValueException("Page $page is not numeric"));
		}

		// convert the page to int and enforce that it is positive
		$page = intval($page);
		if($page <= 0) {
			throw(new RangeException("page $page is not positive"));
		}

		// create query template
		$query = "SELECT commentId, topicId, profileId, commentDate, commentSubject, commentBody
					FROM comment
					WHERE profileId = ?
					ORDER BY commentDate
					LIMIT ?
					OFFSET ?";

		$statement = $mysqli->prepare($query);
		if($statement === false) {
			throw(new mysqli_sql_exception("Unable to prepare statement"));
		}

		// prep offset from page and limit values
		$offset = ($page - 1) * $limit;

		// bind the variables to the place holders in the template
		$wasClean = $statement->bind_param("iii", $newProfileId, $limit, $offset);
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

		// get results
		$results = $statement->get_result();
		if($results->num_rows > 0) {
			// retrieve results in bulk into an array
			$results = $results->fetch_all(MYSQL_ASSOC);
			if($results === false) {
				throw(new mysqli_sql_exception("Unable to process result set"));
			}

			// step through results array and convert to Comment objects
			foreach ($results as $index => $row) {
				$results[$index] = new Comment($row["commentId"], $row["topicId"], $row["profileId"], $row["commentDate"], $row["commentSubject"], $row["commentBody"]);
			}

			// return resulting array of Comment objects
			return($results);
		} else {
			return(null);
		}
	}
}