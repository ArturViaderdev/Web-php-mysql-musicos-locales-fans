<?php

require_once 'bbdd.php';
session_start();
if (isset($_GET['id'])) {
    $correcto = 0;
    if (isset($_SESSION['username'])) {
        extract($_SESSION);
        $tipousuario = dimetipousuario($username);
        if ($tipousuario == 1) {
            $correcto = 1;
            if (bajaconcierto($_GET['id']) == "ok") {
                echo "<script>alert('Concierto eliminado')</script>";
                header("Refresh:1; url=conciertosdelocal.php");
            }
        }
    }
    if ($correcto == 0) {
        echo"No puedes entrar aquí.<br>";
    }
}
?>
