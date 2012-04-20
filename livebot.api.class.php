<?
// LIVEBOT.eu API class

error_reporting(E_ALL);
ini_set('display_errors','On');

class LiveBot_API {
	
	
	
	public		$api_key 	= '';
	public		$css_url	= '';
	private		$error		= false;
	private		$errormsg	= '';
	public		$post_url	= '/api_test/poster.php';
	
	
	
		
	
	public function checkAddServer($server_ip, $server_port, $returnid = false)
	{
		// post to LB api and check for server
		if(!$server_ip || !$server_port)
			self::raiseError( 'Bad serverip and/or port.' );
		else
		{
			$check = self::postToAPI('checkAddServer&ip=' . $server_ip . '&port=' . $server_port . '&returnid=' . ($returnid ? '1' : '0'));
			
			if($check !== false)
			{
				if(strpos($check,"ERROR") !== FALSE)
					self::raiseError( $check );
				
				if(!$this->error AND $returnid)
					return $check;
			}
			else
				self::raiseError( "UNKNOWN ERROR OCCURED" );
		}
	}
	
	
	
	public function getLiveURL($server_id)
	{
		if($server_id > 0 AND $server_id < 9999999999999)
			return 'http://www.livebot.eu/live.php?id=' . $server_id;
		else
			self::raiseError( 'Invalid Server-ID' );
	}
	
	
	
	public function loadLiveContent($server_id)
	{
		$check = self::postToAPI('loadLiveContent&sid=' . $server_id . '&css=' . $this->css_url . '&poster=' . $this->post_url);
		if($check !== false)
		{
			if(strpos($check,"ERROR") !== FALSE)
				self::raiseError( $check );
			else
				return $check;
		}
		else
			self::raiseError( "Could not load live content" );
	}
	
	
	public function postToLiveBotLive($sid,$tickid)
	{
		// for crossdomain shit... now post to livebot host live file...
		
			$tco = curl_init();
			curl_setopt($tco, CURLOPT_URL, "http://www.livebot.eu/js/live.php");
			curl_setopt($tco, CURLOPT_PORT , 80);
			curl_setopt($tco, CURLOPT_VERBOSE, 0);
			curl_setopt($tco, CURLOPT_HEADER, 0); 
			curl_setopt($tco, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($tco, CURLOPT_POST, 1);
			curl_setopt($tco, CURLOPT_POSTFIELDS, "api_key=" . $this->api_key . "&sid=" . $sid . "&tick_id=" . $tickid);
			curl_setopt($tco, CURLOPT_CONNECTTIMEOUT, 5);
			
			$cres = curl_exec($tco);
			curl_close($tco);
			
			echo $cres;
	}
	
	
	
	private function postToAPI($action)
	{
		if(!$this->api_key)
			self::raiseError( 'No API-key defined.' );
		
		if(!$action)
			self::raiseError( 'No action' );
		
			if(!$this->error)
			{
			
			$tc = curl_init();
			curl_setopt($tc, CURLOPT_URL, "http://www.livebot.eu/api/" . "?&action=" . $action);
			curl_setopt($tc, CURLOPT_PORT , 80);
			curl_setopt($tc, CURLOPT_VERBOSE, 0);
			curl_setopt($tc, CURLOPT_HEADER, 0); 
			curl_setopt($tc, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($tc, CURLOPT_POST, 1);
			curl_setopt($tc, CURLOPT_POSTFIELDS, "api_key=" . $this->api_key);
			curl_setopt($tc, CURLOPT_CONNECTTIMEOUT, 5);
			
			$cres = curl_exec($tc);
			curl_close($tc);
			
			if(!$cres)
				return false;
			else
			{
				return $cres;	
			}
			
			}
	}
	
	private function raiseError($error)
	{
		$this->error = true;
		echo $error;
	}
}

?>