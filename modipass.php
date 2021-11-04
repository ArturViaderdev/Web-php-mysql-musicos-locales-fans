<?php
session_start();
require_once 'bbdd.php';
if(isset($_POST['passactual']) && isset($_SESSION['username']))
{
    extract($_POST);
    extract($_SESSION);
    if(compruebainicio($username,$passactual)>0)
    {
        if(modificarpassword($username,$pass1)=='ok')
        {
            echo"Password modificado.<br>";
        }
        else
        {
            echo"Error modificando password.<br>";
        }  
    }
    else
    {
        echo"Password incorrecto.<br>";
    }
}
else
{
    echo"No puedes entrar aquí.<br>";
}

?>