<?php
    include 'classes/AuthClass.php';

    if($_SESSION['auth'] != true) {
        die('Pristup zabranjen');
    }

    //Ako je metoda slanja POST, onda provjeri podatke i proslijedi ih na izmjenu
    if($_SERVER['REQUEST_METHOD'] == 'POST') { // 1. if uvjet
        //$_POST varijabla ne smije biti prazna
        if(!empty($_POST)) { // 2. if uvjet
            $notValid = [];
            $data = [];
            foreach($_POST as $key => $value) { //1. foreach
                //Zanemari input polje koje ima name="updatePassword" i provjeri ostala input polja
                if($key != 'updatePassword') { //3. if uvjet
                    //Provjera nove lozinke i ponavljanja nove lozinke
                    if($key == 'newPassword' || $key == 'newPasswordRepeat') { //4. if uvjet
                        if($_POST['newPassword'] == $_POST['newPasswordRepeat']) {
                            $data['password'] = htmlspecialchars($value);
                        } else {
                            $notValid[] = $key;
                        }
                    } //kraj 4. if uvjet
                    else { //4. else uvjet
                        if(!empty($value)) {
                            $data[$key] = htmlspecialchars($value);
                        } else {
                            $notValid[] = $key;
                        }
                    } //kraj 4. else uvjet

                } // kraj 3. if uvjet
            } //kraj 1. foreach

            if(empty($notValid)) {
                //Sve ok
                $_SESSION['error-password'] = '';
                $auth = new AuthClass(DB_DSN, DB_USERNAME, DB_PASSWORD);
                $result = $auth->changePassword($data);

                if($result['type'] == 'ok') {
                    $_SESSION['error-password'] = $result['content'];
                    header('location: profile.php');
                } else {
                    $_SESSION['error-password'] = $result['content'];
                    header('location: izmjenaLozinke.php');
                }
            } else {
                $_SESSION['error-password'] = "Molimo unesite sve podatke označene zvjezdicom";
                header('location: izmjenaLozinke.php');
            }
        } // kraj 2. if uvjet
        else { // 2. else uvjet
            $_SESSION['error-password'] = "Molimo ispunite sve podatke označene zvjezdicom";
            header('location: izmjenaLozinke.php');
        } // kraj 2. else uvjet
    } // kraj 1. if uvjet

?>


<!doctype html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Videoteka - Izmjena lozinke</title>
		<?php include "assets/css.php"; ?>
		<link href="assets/style.css" rel="stylesheet" type="text/css" media="all"/>
		<link href="https://fonts.googleapis.com/css?family=Slabo+27px" rel="stylesheet">
    <style>
      #izmjenaLozinke-site {
        width: 1070px;
        margin: auto;
        text-align: center;}
      </style>
  </head>
  <body>

    <div id="izmjenaLozinke-site">
      <h1>videoteka</h1>

      <div id="navi">
        <?php include "assets/navi.php" ?>
      </div>

      <div>
          <h2>Videoteka - ažuriranje lozinke</h2>

          <h3>Unesite staru i novu lozinku</h3>

          <?php if(isset($_SESSION['error-password'])): ?>
              <?php if(!empty($_SESSION['error-password'])): ?>
                  <div class="alert alert-danger"><?php echo $_SESSION['error-password']; ?></div>
              <?php endif; ?>
          <?php endif; ?>

          <form action="" method="post">
              <!-- Polje u koje je spremljen ID usera -->
              <input type="hidden" name="user" value="<?php echo $_SESSION['id']; ?>" />

              <!-- Polje za ponovni unos lozinke, jer se mora prvo provjeriti ispravnost -->
              <div>
                  <label>stara lozinka*</label><br>
                  <input type="password" name="oldPassword" /><br>
              </div>

              <!-- Polje za unos nove lozinke -->
              <div>
                  <label>Nova lozinka*</label><br>
                  <input type="password" name="newPassword" /><br>
              </div>

              <!-- Polje za ponovni unos nove lozinke -->
              <div>
                  <label>Ponovi novu lozinku*</label><br>
                  <input type="password" name="newPasswordRepeat" /><br>
              </div>

              <button type="submit" name="updatePassword" value="Ažuriraj!" class="btn">Ažuriraj !</button><br>

          </form>
      </div>
      <?php include 'assets/js.php'; ?>
    </body>
    </html>
