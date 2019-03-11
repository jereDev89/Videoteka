<?php
    include 'classes/FilmClass.php';
    if($_SERVER['REQUEST_METHOD'] == 'GET') {
        if(isset($_GET['film'])) {
            $film = new FilmClass(DB_DSN, DB_USERNAME, DB_PASSWORD);
            $result = $film->deleteFilm($_GET['film'], $_SESSION['id']);


        } else {
            die('Pristup zabranjen');
        }
    } else {
        die('Pristup zabranjen');
    }

?>
