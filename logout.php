<?php
	//Ako se ne definira metoda slanja, ona je uvijek GET
	include 'classes/AuthClass.php';
	if($_SERVER['REQUEST_METHOD'] == 'GET') {
		$_SESSION['error-logout'] = '';
		$auth = new AuthClass(DB_DSN, DB_USERNAME, DB_PASSWORD);
		$auth->userLogout();
	} else {
		$_SESSION['error-logout'] = "Greška kod odjave korisnika!";
		header('location: index.php');
	}
?>
