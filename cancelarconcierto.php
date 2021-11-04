<?php

require_once 'bbdd.php';
session_start();
if (isset($_GET['id'])) {
    $correcto = 0;
    if (isset($_SESSION['username'])) {
        extract($_SESSION);
        $tipousuario = dimetipousuario($username);
        if ($tipousuario == 1 && compruebaconciertoesdelocal($_SESSION['username'], $_GET['id']) == "ok") {
            $correcto = 1;
            if (cancelaconcierto($_GET['id']) == "ok") {
                echo"Concierto cancelado.<br>";
            } else {
                echo"Error cancelando concierto.";
            }
        }
    }
    if ($correcto == 0) {
        echo"No puedes entrar aquí.<br>";
    }
}
?>