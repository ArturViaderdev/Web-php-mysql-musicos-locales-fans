<!DOCTYPE html>
<!--
Pagina de contacto.
-->
<?php
session_start();
require_once 'bbdd.php';
require_once 'funciones.php';
?>

<html lang="es">
    <head>
        <title>OohMusic</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, maximum-scale=1, minimum-scale=1">
        <link rel="stylesheet" href="css/fontello.css">
        <link rel="stylesheet" href="css/estilosContacto.css">
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
                <img id="im" src="Imagenes/banner.jpg">
                <div id="centro"> 
                    <p>Contacto</p>
                    <div id="informulariodatos">
                        <form method="POST">
                            <table border="1">
                                <tr class="data">
                                    <td><p class="pe">Nombre</p></td>
                                    <td><p class="pe">Comentario:</p></td>
                                </tr>
                                <tr>
                                    <td><input type="text" name="name" required></td>
                                    <td rowspan="9"><textarea id="textarea" name="coment">
                                        
                                        </textarea></td>
                                </tr>
                                <tr class="data">
                                    <td><p class="pe">Apellidos</p></td>
                                </tr>
                                <tr>
                                    <td><input type="text" name="surnames" required></td>
                                </tr>
                                <tr class="data">
                                    <td><p class="pe">Email</p></td>
                                </tr>
                                <tr>
                                    <td><input type="email" name="mail" required></td>
                                </tr>
                                <tr class="data">
                                    <td><p class="pe">Teléfono</p></td>
                                </tr>
                                <tr>
                                    <td><input type="tel" name="phone" required></td>
                                </tr>
                                <tr class="data">
                                    <td><p class="pe">¿Cómo nos has conocido?</p></td>
                                </tr>
                                <tr>
                                    <td>
                                        <select name="conocer">
                                            <option value="1">Ubicación</option>
                                            <option value="2">Cliente-Excliente</option>
                                            <option value="3">Recomendación</option>
                                            <option value="4">Internet</option>
                                            <option value="5">Otro</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td id="botonr" colspan="2"><input type="submit" value="Enviar"></td>
                                </tr>
                            </table>
                            <div class='content-all'>
                                <div class='content-carrousel'>
                                    <figure><img src="Imagenes/07.jpg"></figure>
                                    <figure><img src="Imagenes/03.jpg"></figure>
                                    <figure><img src="Imagenes/04.jpg"></figure>
                                    <figure><img src="Imagenes/05.jpg"></figure>
                                    <figure><img src="Imagenes/06.jpg"></figure>
                                    <figure><img src="Imagenes/07.jpg"></figure>
                                    <figure><img src="Imagenes/04.jpg"></figure>
                                    <figure><img src="Imagenes/03.jpg"></figure>
                                    <figure><img src="Imagenes/05.jpg"></figure>

                                </div>
                            </div>
                        </form>
                        <div id="informacion">
                            <p id="titulo">Ooh Music</p>
                            <p class="infoo">Teléfono: 93 301 25 68</p>
                            <p class="infoo">Fax: 93 301 25 68</p>
                            <p class="infoo">E-Mail: info@oohmusic.com</p>
                            <p></p>
                            <p class="infoo">C/. Pelai, 8</p>
                            <p class="infoo">08001</p>
                            <p></p>
                            <p></p>
                            <p class="infoo">Horario: Lunes a viernes de 7:45 a 20:30</p>
                        </div>
                    </div>
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