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

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(!empty($_POST)) {
        $notValid = [];
        $data = [];
        foreach($_POST as $key => $value) {
            if($key != 'insertFilm') {
                if($key == 'note') {
                    $data[$key] = !empty($value) ? $value : '';
                } else {
                    if(!empty($value)) {
                        $data[$key] = $value;
                    } else {
                        $notValid[] = $key;
                    }
                }
            }
        }


        if(empty($notValid)) {
            $_SESSION['error-insert'] = '';
            $film = new FilmClass(DB_DSN, DB_USERNAME, DB_PASSWORD);
            $film->insertFilm($data);
        } else {
            $_SESSION['error-insert'] = "Molimo unesite sve podatke označene zvjezdicom";
            header('location: unosFilma.php');
        }
    } else {
        $_SESSION['error-insert'] = "Molimo unesite sve podatke označene zvjezdicom";
        header('location: unosFilma.php');
    }
}


?>


<!doctype html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Unos Filma</title>
		<?php include "assets/css.php"; ?>
		<link href="assets/style.css" rel="stylesheet" type="text/css" media="all"/>
		<link href="https://fonts.googleapis.com/css?family=Slabo+27px" rel="stylesheet">
	</head>

	<body>
    <div id="unosFilma-site">

			<h1>videoteka</h1>

      <div id="navi">
        <?php include "assets/navi.php" ?>
      </div>

      <h2>Unos filma</h2>
			<p style="margin-top: -15px; margin-bottom: 20px;">Molimo Vas da popunite sljedece podatke i kliknete na Dodaj, kako bi ste dodali novi film u vašu videoteku.</p>

      <div>
        <form method="POST" action="">

          <label>naziv filma</label><br>
          <input type="text" name="nazivFilma"/><br>

          <label>zanr</label><br>
          <input type="text" name="zanr"/><br>

          <label>glumci</label><br>
          <textarea type="text" name="glumci" rows="4" cols="20"></textarea><br>

          <label>redatelj</label><br>
          <input type="text" name="redatelj"/><br>

          <label>godina</label><br>
          <input type="text" name="godina"/><br>

          <button type="submit" name="unosFilma" value="Dodaj!" class="btn">Dodaj!</button>

        </form>
    </div>

    <?php include 'assets/js.php'; ?>
  </body>
  </html>
