<?php include 'classes/AuthClass.php'; ?>

<!doctype html>
<html>
  <head>
    <title>Dobrodošli u Videoteku</title>
    <meta charset="utf-8"/>
    <?php include "assets/css.php"; ?>
    <link href="https://fonts.googleapis.com/css?family=Slabo+27px" rel="stylesheet">
    <link href="assets/style.css" rel="stylesheet" type="text/css" media="all"/>
    <style>
      a, a:visited , a:link{
        text-decoration: none;
        color: #FFF;
      }
      a:hover{
        text-decoration: none;
        font-weight: bold;
        text-shadow: 1px 1px #FFF;
      }
    </style>
  </head>
  <body>
    <div id="container">
      <h1>videoteka</h1>

      <?php if($_SESSION['auth'] != true): ?>

      <div id="navi">
        <?php include "assets/navi.php" ?>
      </div>

      <div id="content">
        <div id="content1">
          <p>Dobrodošli na Videoteku - aplikaciju gdje mozete na jednom mjestu imati popis vaših najdražih filmova.</p>
        </div>

        <div id="registracija">
          <p>Ako niste član, molimo Vas da se registrirate na link</p>
          <a href="register.php"><button type="submit" value="posalji" class="btn">Registracija</button></a>
        </div>

        <?php if(isset($_SESSION['error-login'])): //1. uvjet ?>
          <?php if(!empty($_SESSION['error-login'])): //2. uvjet ?>
            <div class="alert alert-danger"><?php echo $_SESSION['error-login']; ?></div>
          <?php endif; // kraj 2. uvjeta ?>
        <?php endif; // kraj 1. uvjeta ?>

        <div>
          <form method="POST" action="login.php">
            <label>username</label><br>
            <input type="text" name="username"/><br>
            <label>password</label><br>
            <input type="password" name="password"/><br>
            <button type="submit" name="login" value="Pošalji" class="btn">Ulaz</button>
          </form>
        </div>

      </div>
      <?php endif; ?>
    </div>



    <?php include "assets/js.php"; ?>
  </body>
</html>
