// open a new window with the form under scrutiny
module("tabs", {
	setup: function() {
		F.open("../../profile-edit.php");
	}
});

// global variables for form values
var VALID_FIRSTNAME   = "Homer";
var VALID_MIDDLENAME  = "Jay";
var VALID_LASTNAME    = "Simpson";
var VALID_LOCATION    = "Springfield, NT";
var VALID_DESCRIPTION = "Leader of the Stone Cutters";

// define a function to perform the actual unit tests
function testValidFields() {
	// fill in the form values
	F("#firstName").visible(function() {
		this.type(VALID_FIRSTNAME);
	});
	F("#middleName").visible(function() {
		this.type(VALID_MIDDLENAME);
	});
	F("#lastName").visible(function() {
		this.type(VALID_LASTNAME);
	});
	F("#location").visible(function() {
		this.type(VALID_LOCATION);
	});
	F("#description").visible(function() {
		this.type(VALID_DESCRIPTION);
	});

	// click the button once all the fields are filled in
	F("#profileSubmit").visible(function() {
		this.click();
	});

	// in forms, we want to assert the form worked as expected
	// here, we assert we got the success message from the AJAX call
	F(".alert").visible(function() {
		// the ok() function from qunit is equivalent to SimpleTest's assertTrue()
		ok(F(this).hasClass("alert-success"), "successful alert CSS");
		ok(F(this).html().indexOf("Updated Successful") >= 0, "successful message");
	});
}

// the test function *MUST* be called in order for the test to execute
test("test valid fields", testValidFields);