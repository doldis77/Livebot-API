<?

require_once("livebot.api.class.php");

$lb = new LiveBot_API();
$lb->api_key = 'YOUR_API_KEY_HERE';


// Check for server, ip and port. We also want the return 
// id of the newly added server, therfor we have "true"
$lbres = (int) $lb->checkAddServer('88.198.24.14',28111,true);

// load live content with id from above add-line..
echo $lb->loadLiveContent($lbres);
?>