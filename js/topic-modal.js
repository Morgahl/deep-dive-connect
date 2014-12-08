function populateTopicModal(){
	$('#topicModal').show();
}

function dePopulateTopicModal(){
	$('#topicModal').hide();
}

function populateCommentModal(btnId){
	document.getElementById('commentSubject').value = document.getElementById('subject'.concat(btnId)).value;
	document.getElementById('commentBody').value = document.getElementById('body'.concat(btnId)).value;
	document.getElementById('commentTopicId').value = document.getElementById('topicId'.concat(btnId)).value;
	document.getElementById('commentCommentId').value = document.getElementById('commentId'.concat(btnId)).value;
	$('#commentModal').show();
}

function dePopulateCommentModal(){
	$('#commentModal').hide();
}