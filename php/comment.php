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
	 * @var
	 */
	private $commentId;
	/**
	 * @var
	 */
	private $topicId;
	/**
	 * @var
	 */
	private $profileId;
	/**
	 * @var
	 */
	private $commentDate;
	/**
	 * @var
	 */
	private $commentSubject;
	/**
	 * @var
	 */
	private $commentBody;


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
		// TODO: Implement setCommentSubject() method.
	}

	/**
	 * @param mixed $newCommentBody
	 */
	public function setCommentBody($newCommentBody) {
		// TODO: Implement setCommentBody() method.
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
	public function getCommentByCommentId(&$mysqli, $newCommentId) {
		// TODO: implement mySQL select and creation of validated object based on passed commentId
	}
}