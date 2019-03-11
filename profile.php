<?php
	include 'classes/FilmClass.php';
	$isAuth = false;

	if(isset($_SESSION['auth'])) { // 1. uvjet
		if($_SESSION['auth'] == true) { // 2. uvjet
			$isAuth = $_SESSION['auth'];
		} // kraj 2. uvjeta
		else
		{ // 2. else uvjet
			header('location: index.php');
		} // keaj 2. else uvjeta
	} // kraj 1. uvjeta

	if($isAuth == false) {
		die('Pristup zabranjen');
	}

  //Kreiranje instance objekta klase FilmClass
	$film = new FilmClass(DB_DSN, DB_USERNAME, DB_PASSWORD);

  //Pozivanje funkcije za podatke o filmu
	$userData = $film->userData($_SESSION['id']);

  //Pozivanje funkcije za filmove korisnika
	$userFilms = $film->userFilms($_SESSION['id']);


?>

<!doctype html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Videoteka - Profil</title>
		<?php include "assets/css.php"; ?>
		<link href="assets/style.css" rel="stylesheet" type="text/css" media="all"/>
		<link href="https://fonts.googleapis.com/css?family=Slabo+27px" rel="stylesheet">
    <style>
			body {
				font-size: 20px;
			}
      #profil-site {
        width: 1070px;
        margin: auto;
        text-align: center;
				background-color: rgba(160, 21, 38, 0.2);
			}
      #podaci {
        float:left;
        width: 270px;
        text-align: left;
				background-color: rgba(160, 21, 38, 0.2);
      }
      #filmovi {
        float: right;
        width: 800px;
        text-align: left;
				background-color: rgba(160, 21, 38, 0.2);
      }
			th{
				width: 200px;
				font-size: 22px;
				text-align: center;
				padding:5px;
				border: 1px solid #FFF;
				border-radius: 10px;
			}
			.naslov {
				font-size: 26px;
			}
			label {
				font-weight: normal;
			}
			table{
				margin-top: 30px;
				border: 1px solid #FFF;
				border-radius: 10px;

			}
			td{
				padding:5px;
				border: 1px solid #FFF;
				border-radius: 10px;
			}
    </style>
	</head>

	<body>
    <div id="profil-site">

			<h1>videoteka</h1>

			<div id="navi">
        <?php include "assets/navi.php" ?>
      </div>

      <h2>Dobro došli <?php echo $userData['ime']; ?></h2>

      <div id="podaci">
        <h3 class="naslov">Osobni podaci</h3>
        <hr>
        <label>Ime i prezime:<br> <?php echo $userData['ime']; ?></label><br>
        <label style="padding-bottom:30px;">Email:<br> <?php echo $userData['email']; ?></label><br>
        <a>Ažuriraj lozinku</a>
      </div>

      <div id="filmovi" style="float:right">
        <h3 class="naslov">filmovi</h3>
        <hr>
        <a href="unosFilma.php">Unos Filma</a>
        <?php if(!empty($userFilms)): ?>
          <table>
            <tr>
              <th>naziv filma</th>
              <th>zanr</th>
              <th>glumci</th>
              <th>redatelj</th>
              <th>godina</th>
							<th></th>
							<th></th>
            </tr>
            <?php foreach($userFilms as $film): ?>
              <tr>
                <td><?php echo $film['naziv_filma']; ?></td>
                <td><?php echo $film['zanr']; ?></td>
                <td><?php echo $film['glumci']; ?></td>
                <td><?php echo $film['redatelj']; ?></td>
                <td><?php echo $film['godina']; ?></td>
                <td><a href="izmjenaFilma.php?film=<?php echo $film['id_filma']; ?>">Izmjena</a></td>
                <td><a href="brisanjeFilma.php?film=<?php echo $film['id_filma']; ?>">Brisanje</a></td>
              </tr>
            <?php endforeach; ?>
          </table>
        <?php endif; ?>
      </div>

    </div>

		<?php include 'assets/js.php'; ?>
  </body>
  </html>
