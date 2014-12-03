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

	$('#imgUpload').bind('change', function() {

		//this.files[0].size gets the size of your file.
		fileSize = this.files[0].size;



		if(fileSize > 3000000){
			$("#imgUploadOutput").empty().append("<div class=\"alert alert-danger\" role=\"alert\"><p><strong>Stop!</strong> File To Large</p></div>");
		}
		else{
			$("#imgUploadOutput").empty().append("<div class=\"alert alert-success\" role=\"alert\"><p><strong>Proceed!</strong> File Size Is Good</p></div>");
		}


	});
});

function checkFileSize(){
	imgUp = "hey";
	alert(imgUp);
	//sizeImg = imgUp.size;
	//$("#imgUploadOutput").append();
}