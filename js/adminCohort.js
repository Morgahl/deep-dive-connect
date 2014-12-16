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
