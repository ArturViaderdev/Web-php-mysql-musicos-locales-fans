<?php

extract($_POST);
require_once 'bbdd.php';

$email1 = $email;
$email2 = compruebameEmail();
$salir = 0;

while ($salir == 0) {
    if ($fila = mysqli_fetch_assoc($email2)) {
        extract($fila);

        if ($email1 == $email) {
            $estado['estado'] = 1;
            $salir = 1;
        }
    } else {
        $estado['estado'] = 0;
        $salir = 1;
    }
}

echo json_encode($estado);
exit;
?>