<?php
	session_start();
	$_SESSION = array();
	if (ini_get('session.use_cookies')) {
		$params = session_get_cookie_params();
		setcookie(
			session_name(),
			'',
			time() - 42000,
			$params['path'],
			$params['domain'],
			$params['secure"'],
			$params['httponly']
		);
	}
	session_destroy();
	if (!empty($_SERVER['QUERY_STRING'])){
	$redirect = substr ($_SERVER['QUERY_STRING'], 9);
		header ('Location: '.$redirect.'');
	} else {
	 header ('Location: http://' . $_SERVER['HTTP_HOST'] . '');}
?>
