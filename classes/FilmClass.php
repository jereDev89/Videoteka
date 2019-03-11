<?php

	require 'AuthClass.php';

	class FilmClass extends AuthClass {

		public $database;

		//funkcija konstruktora
		function __construct($dsn, $username, $password) {
			try {
				$this->database = new PDO($dsn, $username, $password);
				$this->database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			} catch (PDOException $e) {
				return $e->getMessage();
			}
		}

		//Funkcija za korisnika
		function userData($id) { //početak funkcije

			$query = "SELECT ime, email FROM korisnik WHERE id_korisnika = :id";

			$selectUser = $this->database->prepare($query);
			$selectUser->bindParam(':id', $id);

			$selectUser->execute();
			$user = $selectUser->fetch(PDO::FETCH_ASSOC);

			return $user;

		} //kraj funkcije


		//Funkcija za prikaz filmova korisnika
		function userFilms($id) { //početak funkcije

			$query = "SELECT filmovi.* ";
			$query .= "FROM filmovi ";
			$query .= "INNER JOIN korisnik ON filmovi.id_korisnika = korisnik.id_korisnika ";
			$query .= "WHERE filmovi.id_korisnika = :id";

			$selectFilmovi = $this->database->prepare($query);
			$selectFilmovi->bindParam(':id', $id);

			$selectFilmovi->execute();
			$filmovi = $selectFilmovi->fetchAll(PDO::FETCH_ASSOC);

			return $filmovi;

		} //kraj funkcije

		//Funkcija za unos filma
		function insertFilm($params) {

			$query = "INSERT INTO filmovi (naziv_filma, zanr, glumci, redatelj, godina, id_korisnika)";
			$query .= "VALUES (:nazivFilma, :zanr, :glumci, :redatelj, :godina, :user)";

			$insertFilm = $this->database->prepare($query);

			$insertFilm->bindParam(':nazivFilma', $params['nazivFilma']);
			$insertFilm->bindParam(':zanr', $params['zanr']);
			$insertFilm->bindParam(':glumci', $params['glumci']);
			$insertFilm->bindParam(':redatelj', $params['redatelj']);
			$insertFilm->bindParam(':godina', $params['godina']);
			$insertFilm->bindParam(':user', $_SESSION['id']);

			$result = $insertFilm->execute();
			if($result == true) {
				header('location: profile.php');
			} else {
				$_SESSION['error-insert'] = "Unos nije uspio, molimo pokušajte ponovo!";
				header('location: unosKontakta.php');
			}

		}

		function filmData($film, $id) {

			$query = "SELECT * FROM filmovi WHERE id_filma = :film AND id_korisnika = :id";
			$selectFilm = $this->database->prepare($query);
			$selectFilm->bindParam(':film', $film);
			$selectFilm->bindParam(':id', $id);
			$selectFilm->execute();

			$data = $selectFilm->fetch(PDO::FETCH_ASSOC);
			if(!empty($data)) {
				return $data;
			} else {
				header('location: profile.php');
			}
		}

		//Funkcija za izmjenu filma
		function updateFilm($params) {

			$query = "UPDATE filmovi SET ";
			$query .= "naziv_filma = :nazivFilma, zanr = :zanr, glumci = :glumci, redatelj = :redatelj, godina = :godina ";
			$query .= "WHERE id_filma = :film AND id_korisnika = :user";


			$updateFilm = $this->database->prepare($query);
			$updateFilm->bindParam(':nazivFilma', $params['nazivFilma']);
			$updateFilm->bindParam(':zanr', $params['zanr']);
			$updateFilm->bindParam(':glumci', $params['glumci']);
			$updateFilm->bindParam(':redatelj', $params['redatelj']);
			$updateFilm->bindParam(':godina', $params['godina']);
			$updateFilm->bindParam(':film', $params['film']);
			$updateFilm->bindParam(':user',$params['user']);

			$result = $updateFilm->execute();

			if($result == true) {
				$message = [
					'type' => 'ok',
					'content' => ''
				];
			} else {
				$message = [
					'type' => 'error',
					'content' => 'Dogodila se greška pri ažuriranju kontakta'
				];
			}

			return $message;
		}

		//Funkcija za brisanje filmova
		function deleteFilm($film, $id) {

			$query = "DELETE FROM filmovi WHERE id_filma = :film AND id_korisnika = :user";

			$deleteFilm = $this->database->prepare($query);
			$deleteFilm->bindParam(':film', $film);
			$deleteFilm->bindParam(':user', $id);

			$deleteFilm->execute();

			if($deleteFilm->rowCount() > 0) {
				header('location: profile.php');
			} else {
				$_SESSION['error-delete'] = "Dogodila se greška u brisanju kontakta";
				header('location: profile.php');
			}

		}

	//kraj klase
	}
?>
