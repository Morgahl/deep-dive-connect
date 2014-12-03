/**
 * Created by Steven on 12/2/2014.
 */
$(document).ready(function()
{
	$("#imgUploadForm").validate(
		{
			debug: true,

			rules:
			{

			},
			messages:
			{

			},
			submitHandler: function(form)
			{
				$(form).ajaxSubmit(
					{
						type: "POST",
						url: "php/form-processor/do-upload.php",
						success: function(ajaxOutput)
						{
							$("#imgUploadOutput").html(ajaxOutput);
						}
					});
			}
		});
});