<p>
	<!-- Lista za kretanje po stranici -->
	<ul>

		<?php if($_SESSION['auth'] == false): ?>
			<li><a href="index.php">Početna</a></li>
			<li><a href="register.php">Registracija</a></li>
		<?php endif; ?>
		<?php if($_SESSION['auth'] == true): ?>
			<li><a href="profile.php">Profil</a></li>
			<li><a href="logout.php">Odjava</a></li>
		<?php endif; ?>
	</ul>
</p>
