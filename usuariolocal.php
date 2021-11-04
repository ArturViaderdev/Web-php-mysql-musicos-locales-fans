<?php
require_once 'bbdd.php';
require_once 'funciones.php';
session_start();
?>
<html lang="es">
    <head>
        <title>OohMusic</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, maximum-scale=1, minimum-scale=1">
        <link rel="stylesheet" href="css/fontello.css">
        <link rel="stylesheet" href="css/estilosLocal.css">
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
                <?php
                $mostrar = 0;
                if (isset($_SESSION['username'])) {
                    //por seguridad compruebo si el usuario existe
                    if (usuarioexiste($_SESSION['username']) > 0) {
                        $mostrar = 1;
                    } else {
                        echo"El usuario ya no existe.<br>";
                    }
                } else {
                    echo"No puedes entrar aquí.<br>";
                }
                if ($mostrar == 1) {
                    ?>
                    <img src="Imagenes/banner.jpg">
                    <div id="centro"> 
                        <p>Datos de mi perfil</p>
                        <div id="usuario">
                            <?php
                            muestradatoslocal();
                            ?>
                        </div>
                        <nav class="menuLocal">
                            <ul>
                                <li><a href="">Perfil</a></li>
                                <li><a href="#">Fotos</a></li>
                                <li><a class="concierto" href="" id="boton1">Conciertos</a>
                                    <ul>
                                        <div id="submenudiv">
                                            <li><a href="conciertosdelocal.php" id="uno">Mis conciertos</a></li>
                                            <li><a href="anadirconcierto.php" id="dos">Organizar un concierto</a></li>
                                        </div>
                                    </ul>
                                </li>
                                <li><a href="homeuser.php">Mensajes</a></li>
                                <li><a href="miperfillocal.php">Configuración</a></li>
                                <?php cerraSession2() ?>
                            </ul>

                        </nav>    

                        </ul>
                    </div>
                    <div id="titulonoticias">
                        <p>Últimas noticias</p>
                    </div>
                    <div id="noticias">
                    </div>
                    </div>  
                    <?php
                }
                ?>
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
