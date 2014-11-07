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
	 * @var $commentId INT
	 */
	private $commentId;
	/**
	 * @var $topicId INT
	 */
	private $topicId;
	/**
	 * @var $profileId INT
	 */
	private $profileId;
	/**
	 * @var $commentDate DATETIME
	 */
	private $commentDate;
	/**
	 * @var $commentSubject STRING
	 */
	private $commentSubject;
	/**
	 * @var $commentBody STRING
	 */
	private $commentBody;

	/**
	 * @param $newCommentId
	 * @param $newTopicId
	 * @param $newProfileId
	 * @param $newCommentDate
	 * @param $newCommentSubject
	 * @param $newCommentBody
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
	 * @return string
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
	 * @param mixed $newCommentId
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
	 * @param mixed $newTopicId
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
	 * @param mixed $newProfileId
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
	 * @param mixed $newCommentDate
	 */
	public function setCommentDate($newCommentDate) {
		// Sanitize Date input to Y-m-d H:i:s MySQL standard
		// this fails for badly formed strings and nulls
		$newCommentDate = trim($newCommentDate);
		if (($newCommentDate = DateTime::createFromFormat("Y-m-d H:i:s", $newCommentDate)) === false) {
			throw(new UnexpectedValueException("Start date is not valid. Please use Y-m-d H:i:s format"));
		}

		// take topicDate out of quarantine and assign it
		$this->commentDate = $newCommentDate;
	}

	/**
	 * @param mixed $newCommentSubject
	 */
	public function setCommentSubject($newCommentSubject) {
		// commentSubject should never be null
		if($newCommentSubject === null) {
			throw(new UnexpectedValueException("Comment Subject must not be null"));
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

		// take topicSubject out of quarantine and assign it
		$this->commentSubject = $newCommentSubject;
	}

	/**
	 * @param mixed $newCommentBody
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
		// TODO: implement mySQL insert of validated object
	}

	/**
	 * Updates this Comment in mySQL
	 *
	 * @param $mysqli OBJECT mySQL connection object
	 * @throws mysqli_sql_exception when a MySQL error occurs
	 */
	public function update(&$mysqli) {
		// TODO: implement mySQL update of validated object
	}

	/**
	 * Deletes this Comment from mySQL
	 *
	 * @param $mysqli OBJECT mySQL connection object
	 * @throws mysqli_sql_exception when a MySQL error occurs
	 */
	public function delete(&$mysqli) {
		// TODO: implement mySQL deletion of validated object
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
		// TODO: implement mySQL select and creation of validated object based on passed commentId
	}

	/**
	 * @param $mysqli
	 * @param $newTopicId
	 */
	public static function getCommentsByTopicId(&$mysqli, $newTopicId) {
		// TODO: implement mySQL select and creation of validated array of Comment objects based on passed topicId
	}

	/**
	 * @param $mysqli
	 * @param $newProfileId
	 */
	public static function getCommentsByProfileId(&$mysqli, $newProfileId) {
		// TODO: implement mySQL select and creation of validated array of Comment objects based on passed profileId
	}

}