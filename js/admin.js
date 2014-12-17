/**
 * Created in collaboration by:
 *
 * Gerardo Medrano GMedranoCode@gmail.com
 * Marc Hayes <Marc.Hayes.Tech@gmail.com>
 * Steven Chavez <schavez256@yahoo.com>
 * Joseph Bottone hi@oofolio.com
 *
 */

$(document).ready(function(){

	$("#securityOption").bind('change', function(){
		var val = document.getElementById("securityOption").value;
		if(val == "new"){
			var string = "<h3>Enter Name for New Permission</h3>"+
					"<input type=\"text\" id=\"newPermission\" name=\"newPermission\">";
			document.getElementById("newOutput").innerHTML = string;
		}
		else if(val == "delete"){
			var string = "<h3>Delete</h3><p>Enter id below and press submit</p>"+
				"<input type=\"text\" id=\"deletePermission\" name=\"deletePermission\" size=\"3\">";
			document.getElementById("newOutput").innerHTML = string;
		}
		else{
			document.getElementById("newOutput").innerHTML = "";
		}
	});

	$('table tr:odd').addClass('stripedTable');

});
