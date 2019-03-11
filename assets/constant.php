<?php
	define('DB_DSN', 'mysql:host=localhost;dbname=videoteka;charset=utf8');
	define('DB_USERNAME', 'root');
	define('DB_PASSWORD', '');

	//Definiranje sesija za korisnika
	$_SESSION['auth'] = isset($_SESSION['auth']) ? $_SESSION['auth']: false;
	$_SESSION['username'] = isset($_SESSION['username']) ? $_SESSION['username'] : '';
	$_SESSION['id'] = isset($_SESSION['id']) ? $_SESSION['id'] : '';
	
	//Definirane sesije za greške ili obavijesti
	$_SESSION['error-login'] = isset($_SESSION['error-login']) ? $_SESSION['error-login'] : '';
	$_SESSION['error-register'] = isset($_SESSION['error-register']) ? $_SESSION['error-register'] : '';
	$_SESSION['error-logout'] = isset($_SESSION['error-logout']) ? $_SESSION['error-logout'] : '';


?>
