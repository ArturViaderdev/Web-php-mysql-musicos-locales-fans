<?php
session_start();
require_once 'bbdd.php';
require_once 'funciones.php';
?>

<!DOCTYPE html>
<!--
Pagina login
-->

<html lang="es">
    <head>
        <title>OohMusic</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, maximum-scale=1, minimum-scale=1">
        <link rel="stylesheet" href="css/fontello.css">
        <link rel="stylesheet" href="css/estilosLogin.css">
    </head>
    <body>
        <header>
            <div class="contenedor">
                <h1 class="icon-music">Ooh Music</h1>
                <!-- Segundo -->
                <input type="checkbox" id="menu-user">
                <label id="label1" class="icon-user-circle" for="menu-user"></label>
                <!-- Primero -->
                <input type="checkbox" id="menu-bar">
                <label class="icon-menu" for="menu-bar"></label>
                <nav class="menuuser">
                    <?php
                    controlDesplegable();
                    ?>
                </nav>
                <nav class="menu">
                    <ul>
                        <li><a href="index.php">Inicio</a></li>
                        <li><a href="login.php">Login</a></li>
                        <li class="submenu"><a href="">Registro <span class="icon-down-dir"></span></a>
                            <ul class="submenuu">
                                <li><a href="rmusicos.php">Regístrate como músico</a></li>
                                <li><a href="rlocales.php">Regístrate como local</a></li>
                                <li><a href="rfan.php">Regístrate como fan</a></li>
                            </ul>
                        </li>
                        <li><a href="musicos.php">Musicos</a></li>
                        <li><a href="locales.php">Locales</a></li>
                        <li><a href="fans.php">Fans</a></li>
                        <li><a href="contacto.php">Contacto</a></li>
                    </ul>
                </nav>
            </div>
        </header>       
        <main>
            <section id="banner">
                <img src="Imagenes/banner.jpg">
                <div id="formulario"> 
                    <?php
                    if (isset($_POST['username'])) {
                        $mostrar = 0;
                        extract($_POST);
                        if (compruebainicio($username, $pass) == 1) {
                            $_SESSION['username'] = $username;
                            $_SESSION['tipo'] = dimetipousuario($username);
                            extract($_SESSION);

                            switch ($tipo) {
                                case 1:
                                    header('Location: usuariolocal.php');
                                    break;
                                case 2:
                                    header('Location: usuariomusico.php');
                                    break;
                                case 3: header('Location: usuariofan.php');
                                    break;
                                default:
                            }
                        } else {
                            echo"<script>alert('Nombre de usuario o contraseña incorrectos')</script>";
                            header("Refresh:0; url=login.php");
                        }
                    } else {
                        ?>
                    <div id="formulariodatos">
                        <form method="POST">
                            <table border="1">
                                <tr class="data">
                                    <td><p>Nombre de usuario</p></td>
                                </tr>
                                <tr>
                                    <td><input type="text" name="username" required></td>
                                </tr>
                                <tr class="data">
                                    <td>Contraseña</td>
                                </tr>
                                <tr>
                                    <td><input type="password" name="pass" required></td>
                                </tr>
                                <tr>
                                    <td id="botonr"><input type="submit" value="Entrar a mi cuenta" name="boton"></td>
                                </tr>
                            </table>
                        </form>
                    </div>
    <?php
}
?>
                </div>
            </section>
        </main>
        <footer>
            <div class="contenedor">
                <p class="copy">Ooh Music &copy; 2018</p>
                <div class="sociales">
                    <a class="icon-facebook-squared" href="#"></a>
                    <a class="icon-twitter" href="#"></a>
                    <a class="icon-instagram" href="#"></a>
                    <a class="icon-gmail" href="#"></a>
                </div>
            </div>
        </footer>
    </body>
</html>
