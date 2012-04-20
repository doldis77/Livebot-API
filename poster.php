<?
// poster file for Livebot API.
// NO NEED TO EDIT THIS FILE.
// JUST MAKE SURE TO EDIT THE URL OF THE POSTER IN livebot.api.class.php

$sid 	= 0 + $_REQUEST['sid'];
$tickid = 0 + $_REQUEST['tick_id'];

require_once("livebot.api.class.php");

$lbo = new LiveBot_API();

// perform ajax crossdomain post
$lbo->postToLiveBotLive($sid, $tickid);

?>