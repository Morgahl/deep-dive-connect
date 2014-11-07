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


	function __construct() {
		// TODO: Implement __construct() method.
	}

	function __toString() {
		// TODO: Implement __toString() method.
		return("Fix Me");
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
		// TODO: Implement setCommentId() method.
	}

	/**
	 * @param mixed $newTopicId
	 */
	public function setTopicId($newTopicId) {
		// TODO: Implement setTopicId() method.
	}

	/**
	 * @param mixed $newProfileId
	 */
	public function setProfileId($newProfileId) {
		// TODO: Implement setProfileId() method.
	}

	/**
	 * @param mixed $newCommentDate
	 */
	public function setCommentDate($newCommentDate) {
		// TODO: Implement setCommentDate() method.
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