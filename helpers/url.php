<?php
    //URL Helper
    function base_url() {	
		return APP_URL.'/'.APP_PATH;
	}
	
	function site_url($url) {	
		return APP_URL.'/'.APP_PATH.$url;
	}
	
	function redirect($url) {
	    header('Location:'.APP_URL.'/'.APP_PATH.$url);
	}
?>