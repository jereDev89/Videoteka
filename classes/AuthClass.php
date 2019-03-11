<?php
	session_start();
	include 'assets/constant.php';

	class AuthClass {

		private $databaseConnection;

		//Definiranje konstruktora klase za spajanje na bazu podataka
		function __construct($dsn, $username, $password) {
			//Pokukušaj spajanja na bazu
			try {

				$this->databaseConnection = new PDO($dsn, $username, $password);
				$this->databaseConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			} catch(PDOException $e) {
				echo $e->getMessage();
			}
		}


		//Funkcija za registraciju novog korisnika
		function userRegistration($params) {

			$query1 = "SELECT username FROM korisnik WHERE username = :username";

			$selectKorisnik = $this->databaseConnection->prepare($query1);
			$selectKorisnik->bindParam(':username', $params['username']);
			$selectKorisnik->execute();

			$result = $selectKorisnik->fetchAll();

			if(count($result) > 0) { // 1. uvjet
				$_SESSION['error-register'] = 'Korisnicko ime vec postoji. Izaberite neko drugo!';
				header('location: register.php');
				return;
			}


			$hash = password_hash($params['password'], PASSWORD_BCRYPT);

			$query = 'INSERT INTO korisnik(ime, email, username, password) VALUES(:ime, :email, :username, :password)';

			$unosKorisnika = $this->databaseConnection->prepare($query);

			$unosKorisnika->bindParam(':ime', $params['nameSurname'], PDO::PARAM_STR, 60);
			$unosKorisnika->bindParam(':email', $params['email'], PDO::PARAM_STR, 60);
			$unosKorisnika->bindParam(':username', $params['username'], PDO::PARAM_STR, 50);
			$unosKorisnika->bindParam(':password', $hash, PDO::PARAM_STR, 100);

 //kraj 1. uvjeta
			//početak 1. else uvjeta

			try {
				$result = $unosKorisnika->execute();
				if($result == true) {
					header('location: index.php');
				} else {
					header('location: register.php');
				}

			} catch(PDOException $e) {
				echo $e->getMessage();
			}

		}

		//Funkcija za prijavu korisnika
		function userLogin($params) { //početak funkcije

			$query = "SELECT id_korisnika, username, password FROM korisnik WHERE username = :username";

			$selectKorisnik = $this->databaseConnection->prepare($query);
			$selectKorisnik->bindParam(':username', $params['username']);

			try { // početake try iznimke
				$selectKorisnik->execute();
				$result = $selectKorisnik->fetchAll();
				if(count($result) === 0) { // 1. uvjet
					$_SESSION['auth'] = false;
					$_SESSION['error-login'] = 'Korisnik ne postoji!';
					header('location: index.php');
				} //kraj 1. uvjeta
				else { //početak 1. else uvjeta

					//hash unesene lozinke
					$password = $params['password'];
					$hash = $result[0]['password'];



					if(password_verify($password, $hash)) { // 2. uvjet
						$_SESSION['auth'] = true;
						$_SESSION['user'] = $result[0]['username'];
						$_SESSION['id'] = $result[0]['id_korisnika'];
						header('location: profile.php');

					} // kraj 2. uvjeta
					else { // 2. else uvjet
						$_SESSION['auth'] = false;
						$_SESSION['error-login'] = 'Prijava nije uspješna!';
						header('location: index.php');
					} // kraj 2. else uvjeta

				} //kraj 1. else uvjeta


			} //kraj try iznimke
			catch(PDOException $e) { //početak catch iznimke
				echo $e->getMessage();
			} //kraj catch iznimke


		} //kraj funkcije

		// Funkcija za odjavu korisnika
		function userLogout() {
			session_unset();
			session_destroy();
			header('location: index.php');
		}

		//Funkcija za izmjenu lozinke
		function changePassword($params) { // početak funkcije

			$query = "SELECT id_korisnika, password FROM korisnik WHERE id_korisnika = :id_korisnika";

			$checkUser = $this->databaseConnection->prepare($query);
			$checkUser->bindParam(':id_korisnika', $params['user'], PDO::PARAM_STR, 100);
			$checkUser->execute();

			$userData = $checkUser->fetch(PDO::FETCH_ASSOC);

			//Prije izmjene lozinke potrebno je provjeriti da li je hash lozinki identičan
			if(password_verify($params['oldPassword'], $userData['password'])) {


				//Ako se stara lozinka iz baze podataka i stara lozinka iz HTML forme podudaraju

				//Hash za novu lozinku
				$newPasswordHash = password_hash($params['password'], PASSWORD_BCRYPT);

				//Priprema SQL upita
				$queryPassword = "UPDATE korisnik SET ";
				$queryPassword .= "password = :newPassword WHERE id_korisnika = :id_korisnika";
				//Priprema, povezivanje parametara i izvršavanje upita
				$updatePassword = $this->databaseConnection->prepare($queryPassword);
				$updatePassword->bindParam(':newPassword', $newPasswordHash);
				$updatePassword->bindParam(':id_korisnika', $params['user']);

				$result = $updatePassword->execute();
				if($result == true) {
					//Ako je update uspio
					$message = [
						'type' => 'ok',
						'content' => 'Ažuriranje lozinke je uspješno izvršeno!'
					];
				} else {
					//Ako update nije uspio
					$message = [
						'type' => 'error',
						'content' => 'Ažuriranje lozinke nije uspjelo!'
					];
				}

			} else {
				//Ako se lozinke ne podudaraju
				$message = [
					'type' => 'error',
					'content' => 'Stara lozinka nije ispravna!'
				];
			}

			return $message;
		} // kraj funkcije


		// kraj klase
	}

?>
