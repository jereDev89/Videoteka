<?php
	include 'classes/AuthClass.php';

	if(isset($_POST['register'])) {
		$errors = [];
		$data = [];

		foreach($_POST as $key => $value) {
			if($key != 'register') {
				if(!empty($value)) {
					if($key == 'password' || $key == 'passwordRepeat') {
						if($_POST['password'] == $_POST['passwordRepeat']) {
							$data['password'] = htmlspecialchars($value);
						} else {
							$errors[] = $key;
						}
					} else {
						$data[$key] = htmlspecialchars($value);
					}
				} else {
					$errors[] = $key;
				}
			}
		}

		if(empty($errors)) {
			$_SESSION['error-register'] = '';
			$auth = new AuthClass(DB_DSN, DB_USERNAME, DB_PASSWORD);
			$auth->userRegistration($data);
		} else {
			$_SESSION['error-register'] = "Molimo unesite sva polja";
		}
	}

?>


<!doctype html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Registracija</title>
		<?php include "assets/css.php"; ?>
		<link href="assets/style.css" rel="stylesheet" type="text/css" media="all"/>
		<link href="https://fonts.googleapis.com/css?family=Slabo+27px" rel="stylesheet">
	</head>

	<body>
		<div id="registracija-site">

			<h1>videoteka</h1>

			<div id="navi">
        <?php include "assets/navi.php" ?>
      </div>

			<h2>Registracija</h2>
			<p style="margin-top: -15px; margin-bottom: 20px;">Molimo Vas da popunite sljedece podatke i kliknete na Registriraj me.</p>

			<?php if(isset($_SESSION['error-register'])): ?>
				<?php if(!empty($_SESSION['error-register'])): ?>
					<div class="alert alert-danger"><?php echo $_SESSION['error-register']; ?></div>
				<?php endif; ?>
			<?php endif; ?>


			<div>
				<form method="POST" action="">

						<label>ime i prezime*</label><br>
						<input type="text" name="nameSurname"/><br>

						<label>email*</label><br>
						<input type="email" name="email"/><br>

						<label>korisničko ime*</label><br>
						<input type="text" name="username"/><br>

						<label>lozinka*</label><br>
						<input type="password" name="password"/><br>

						<label>ponovi lozinku*</label><br>
						<input type="password" name="passwordRepeat"/><br>

					<button type="submit" name="register" value="registriraj me!" class="btn">Registriraj me !</button>

				</form>
			</div>


		</div>

		<?php include "assets/js.php"; ?>
	</body>
</html>
