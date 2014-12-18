/**
 * Created in collaboration by:
 *
 * @author Gerardo Medrano <GMedranoCode@gmail.com>
 * @author Marc Hayes <Marc.Hayes.Tech@gmail.com>
 * @author Steven Chavez <schavez256@yahoo.com>
 * @author Joseph Bottone <hi@oofolio.com>
 *
 */

$(document).ready(function(){

	$('table tr:odd').addClass('stripedTable');

	$("#cohortAdd").show();
	$("#cohortDelete").hide();

	$("#addBtn").click(function(){
		$("#cohortAdd").show();
		$("#cohortDelete").hide();
	});

	$("#deleteBtn").click(function(){
		$("#cohortAdd").hide();
		$("#cohortDelete").show();
	});

	$(function() {
		$( "#endDate" ).datepicker();
		$( "#startDate" ).datepicker();
	});
});
