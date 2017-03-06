<?php
	session_start();
        require_once("config.php");
	require_once("inc/chatClass.php");
	$id = intval( $_GET['lastTimeID'] );
	$jsonData = chatClass::getRestChatLines($id);
	print $jsonData;
?>