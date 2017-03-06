<?php 
	if(!isset($_SESSION["userId"])) 
		header("location:/members"); 
?> 
<title>Chat-Mediawriting</title>
		<link rel="stylesheet" href="/members/Views/VA/chat/css/main.css" />
		<link rel="stylesheet" href="/members/Views/VA/chat/css/bootstrap.min.css" />
		<script src="/members/Views/VA/chat/js/bootstrap.min.js"></script>
		<script src="/members/Views/VA/chat/js/jquery.min.js"></script>
		<script src="/members/Views/VA/chat/js/main.js"></script>
	</head>
	<body style="background:#f5f5f5;">
		<div class="container" id="view_ajax" style="height:77%;overflow-y: scroll;"></div>
		<form class="form-inline" style="position: fixed;bottom: 0;background: #fff;width: 100%;border:1px solid #ccc;background:#efefef;"> 
		 <div class="form-group input-group" id="ajaxForm"> 
		  <span class='input-group-addon' style='padding:0;line-height:0;background:none;border:none;'> 
		  <input type="text" name="chatInput" id="chatInput" maxlength="40" class="form-control" id="chatInput" placeholder="Enter message" autocomplete="off" style="width:47%;" />
         <button  type="button" id="btnSend" class="btn btn-primary" style="float:left;" >Send</button> 
          </span>
        </div> 
		</form>  
		<script type="text/javascript"> 
		$('#chatInput').keypress(function(e)
		{
		 if(e.which==13)
		 {  
		 	sendChatText();
			$('#chatInput').val("");
		 	e.preventDefault(); 
		 }
		});

		var maxWords = 2;
		$('#chatInput').keypress(function(){
			var $this,wc;
			$this=$(this);
			wc=$this.val().split(/\b[\s,\.-:;]*/).length;
			if(wc>maxWords)
			{
				e.preventDefault();
				return false;
			}
		})
		</script>
	</body>
</html> 
