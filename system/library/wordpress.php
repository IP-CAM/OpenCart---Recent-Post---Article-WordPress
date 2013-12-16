<?php
class WordPressPosts {
	
	private $query;
	
	function __construct($query_url=""){
		if( isset($query_url) && !empty($query_url) ){
			$this->query= $query_url;
		}
	}
	
	function get($query_url=""){
		if( isset($query_url) && !empty($query_url) ){
			$this->query= $query_url;
		}	
		
		$ch= curl_init();
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_VERBOSE, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_FAILONERROR, 0);
		curl_setopt($ch, CURLOPT_URL, $this->query);
		$curl_dt= curl_exec($ch);
		curl_close($ch);
		
		return $curl_dt;
	}
}
?>