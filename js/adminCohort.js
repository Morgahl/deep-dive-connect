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
