<?php
    include 'classes/FilmClass.php';
    //Ako je metoda POST
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        if(!empty($_POST)) {
            $notValid = [];
            $data = [];
            foreach($_POST as $key => $value) {
                if($key != 'updateFilm') {
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
                $_SESSION['error-update'] = '';
                $film = new FilmClass(DB_DSN, DB_USERNAME, DB_PASSWORD);
                $result = $film->updateFilm($data);

                if($result['type'] == 'ok') {
                    $_SESSION['error-update'] = $result['content'];
                    header('location: profile.php');
                } else {
                    $_SESSION['error-update'] = $result['content'];
                    header('location: izmjenaFilma.php?film=' .$data['film']);
                }
            } else {
                $_SESSION['error-update'] = "Molimo unesite sve podatke označene zvjezdicom";
                header('location: izmjenaFilma.php?film=' . $data['film']);
            }
        } else {
            $_SESSION['error-update'] = "Molimo ispunite sve podatke označene zvjezdicom";
            header('location: izmjenaFilma.php?film=' . $data['film']);
        }
    } else {
        die('Zapranjen pristup');
    }
?>
