<?php
	if($_SERVER['REQUEST_METHOD'] == 'POST') { //početak 1. uvjeta
		include 'classes/AuthClass.php';
		if(!empty($_POST)) { // 2. uvjet
			if(!empty($_POST['username']) && !empty($_POST['password'])) { // 3. uvjet

				$_SESSION['error-login'] = '';
				$data = [
					'username' => htmlspecialchars($_POST['username']),
					'password' => htmlspecialchars($_POST['password'])
				];

				$auth = new AuthClass(DB_DSN, DB_USERNAME, DB_PASSWORD);
				$auth->userLogin($data);


			}// kraj 3. uvjeta
			else { // 3. else uvjet
				$_SESSION['error-login'] = 'Molimo popunite sve podatke';
				header('location: index.php');
			} // kraj 3. else uvjeta
		} // kraj 2. uvjeta
		else { // 2. else uvjet
			$_SESSION['error-login'] = 'Molimo unesite sve podatke';
			header('location: index.php');
		} //kraj 2. else uvjeta
	} //kraj 1. uvjeta
	else
	{ // početak 1. else uvjeta
		header('location: index.php');
		//die("Nemate pravo pristupa!");
	} //kraj 1. else uvjeta


?>
