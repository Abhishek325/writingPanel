var lastTimeID = 0;

$(document).ready(function() {
	$('#btnSend').click(function(){
		sendChatText();
		$('#chatInput').val("");
	});
	startChat();
});

function startChat(){
	setInterval(function(){ getChatText(); }, 2000);
}

function getChatText(){
	$.ajax({
		type: "GET",
		url: "http://dev.mediawriting.com/members/Views/VA/chat/refresh.php?lastTimeID="+lastTimeID
	}).done(function( data )
	{
		var jsonData = JSON.parse(data);
		var jsonLength = jsonData.results.length;
		var html = "";
		for (var i = 0; i < jsonLength; i++) {
			var result = jsonData.results[i];
			html += '<div style=\"\">' + '<small style=\"font-size:8px;display:block;width:100%;text-align:'+result.align+'\">'+result.chattime+'</small>'+result.chattext+ '</div><br><br>';
			lastTimeID = result.id;
		}
		$('#view_ajax').append(html);
		var elem = document.getElementById('view_ajax');
  			elem.scrollTop = elem.scrollHeight;
	});
}

function sendChatText(){
	var chatInput = $('#chatInput').val();
	if(chatInput != ""){
		$.ajax({
			type: "GET",
			url: "http://dev.mediawriting.com/members/Views/VA/chat/submit.php?chattext=" + encodeURIComponent( chatInput )
		});
	}
}