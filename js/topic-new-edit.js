$(document).ready(function() {
	$("#topic").validate(
		{
			rules: {
				city: {
					pattern: /^[^";@#\$&\\\*]+$/
				}
			},

			messages: {
				city: {
					pattern : "Illegal characters detected",
					required: "Please enter a city"
				}
			},

			submitHandler: function(form) {
				$(form).ajaxSubmit(
					{
						type   : "POST",
						url    : "../php/weather.php",
						success: function(ajaxOutput) {
							$("#outputArea").html(ajaxOutput);
						}
					});
			}
		});
});