/**
 * Created by Steven on 12/10/2014.
 */

$(document).ready(function(){

	$("#securityOption").bind('change', function(){
		var val = document.getElementById("securityOption").value;
		if(val == "new"){
			var string = "<h3>Enter Name for New Permission</h3>"+
					"<input type=\"text\" id=\"newPermission\" name=\"newPermission\">";
			document.getElementById("newOutput").innerHTML = string;
		}
		else{
			document.getElementById("newOutput").innerHTML = "";
		}
	});

});
