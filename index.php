<?php
	ob_start();
	if(!session_id()) {
		session_start();
	}
	
	define ('DS', DIRECTORY_SEPARATOR);
	
	require_once (__DIR__ . DS . 'vendor/autoload.php');
	require_once (__DIR__ . DS . 'lib/fb.php');
	
	$facebook = new Facebook();
	
	require_once (__DIR__ . DS . 'login.php');
?>