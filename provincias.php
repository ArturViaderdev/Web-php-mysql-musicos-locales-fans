<?php
    require_once 'bbdd.php';
    require_once 'funciones.php';
     if(isset($_POST['provincia']))
     {
            $ciudades = leeciudades(utf8_decode($_POST['provincia']));
            $arrayciudades = conviertearray($ciudades);
//            $arrayciudades = mysqli_fetch_all($ciudades);
            echo json_encode($arrayciudades);
            exit();
    }
        
?>
