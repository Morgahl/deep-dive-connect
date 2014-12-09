// open a new window with the form under scrutiny
module("tabs", {
	setup: function() {
		F.open("../../index.php");
	}
});

// global variables for form values
var VALID__TOPIC_SUBJECT	= "Lorem ipsum dolor sit amet.";
var VALID__TOPIC_BODY		= "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas et purus id metus vestibulum lobortis. Aliquam vel enim turpis. Donec hendrerit fringilla nulla at fermentum. Sed non orci venenatis, imperdiet lectus at, pulvinar mi. Quisque vitae pellentesque dui, ac mollis leo.";
var VALID__COMMENT_SUBJECT	= "Ut euismod sagittis quam.";
var VALID__COMMENT_BODY		= "Ut euismod sagittis quam, at commodo eros pretium et. Phasellus facilisis sapien at nulla lobortis, quis ultrices ipsum vestibulum.";


// define a function to perform the actual unit tests
function testValidFields() {
	// click the button once all the fields are filled in
	F("#topicCreate").visible(function() {
		this.click();
	});
	// fill in the form values
	F("#topicSubject").visible(function() {
		this.type(VALID__TOPIC_SUBJECT);
	});
	F("#topicBody").visible(function() {
		this.type(VALID__TOPIC_BODY);
	});
	F("#modTopicSubmit").visible(function() {
		this.click();
	});
	F("#newComment").visible(function() {
		this.click();
	});
	F("#commentSubject").visible(function() {
		this.type(VALID__COMMENT_SUBJECT);
	});
	F("#commentBody").visible(function() {
		this.type(VALID__COMMENT_BODY);
	});
	// click the button once all the fields are filled in
	F("#modCommentSubmit").visible(function() {
		this.click();
	});

	// in forms, we want to assert the form worked as expected
	// here, we assert we got the success message from the AJAX call
	F(".test-unit-topic").visible(function() {
		ok(F(this).html().indexOf(VALID__TOPIC_SUBJECT) >= 0, "Topic Subject successful message.");
		ok(F(this).html().indexOf(VALID__TOPIC_BODY) >= 0, "Topic Body successful message.");
	});
	F(".test-unit-comment").visible(function() {
		// the ok() function from qunit is equivalent to SimpleTest's assertTrue()
		ok(F(this).html().indexOf(VALID__COMMENT_SUBJECT) >= 0, "Comment Subject successful message.");
		ok(F(this).html().indexOf(VALID__COMMENT_BODY) >= 0, "Comment Body successful message.");
	});
}

// the test function *MUST* be called in order for the test to execute
test("test valid fields", testValidFields);