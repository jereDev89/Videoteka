<?php
    include 'classes/FilmClass.php';
    $isValid = false;

    if($_SESSION['auth'] != true) {
        die('Pristup zabranjen');
    }

    if(isset($_GET['film'])) {
        $isValid = true;
    }

    //Ako ne postoji get varijabla film onda prekini kod
    if($isValid != true) {
        die('Pristup zabranjen');
    }

    //Dohvat podataka o filmu
    $film = new FilmClass(DB_DSN, DB_USERNAME, DB_PASSWORD);
    $filmData = $film->filmData($_GET['film'], $_SESSION['id']);

?>

<!doctype html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Videoteka - Izmjena filma</title>
		<?php include "assets/css.php"; ?>
		<link href="assets/style.css" rel="stylesheet" type="text/css" media="all"/>
		<link href="https://fonts.googleapis.com/css?family=Slabo+27px" rel="stylesheet">
    <style>
      #izmjenaFilma-site {
        width: 1070px;
        margin: auto;
        text-align: center;}
      </style>
  </head>
  <body>

    <div id="izmjenaFilma-site">
      <h1>videoteka</h1>

      <div id="navi">
        <?php include "assets/navi.php" ?>
      </div>

            <h3 style="padding:20px;">Unesite novi film</h3>

            <?php if(isset($_SESSION['error-update'])): ?>
                <?php if(!empty($_SESSION['error-update'])): ?>
                    <div class="alert alert-danger"><?php echo $_SESSION['error-update']; ?></div>
                <?php endif; ?>
            <?php endif; ?>
            <form action="izmjena.php" method="post">
                <input type="hidden" name="user" value="<?php echo $_SESSION['id']; ?>" />
                <input type="hidden" name="film" value="<?php echo $_GET['film']; ?>" />
                <div>
                    <label>naziv filma*</label><br>
                    <input type="text" name="nazivFilma" value="<?php echo $filmData['naziv_filma']; ?>" /><br>
                </div>
                <div>
                    <label>zanr*</label><br>
                    <input type="text" name="zanr" value="<?php echo $filmData['zanr']; ?>" /><br>
                </div>
                <div>
                    <label>glumci*</label><br>
                    <textarea type="text" name="glumci" rows="4" cols="20" ><?php echo $filmData['glumci']; ?></textarea><br>
                </div>
                <div>
                    <label>redatelj</label><br>
                    <input type="text" name="redatelj" value="<?php echo $filmData['redatelj']; ?>" /><br>
                </div>
                <div>
                    <label>godina</label><br>
                    <input type="text" name="godina" value="<?php echo $filmData['godina']; ?>" /><br>
                </div>

                <button type="submit" name="updateFilm" value="Ažuriraj!" class="btn">Ažuriraj film!</button>

            </form>

    </div>
    <?php include 'assets/js.php'; ?>
  </body>
  </html>
