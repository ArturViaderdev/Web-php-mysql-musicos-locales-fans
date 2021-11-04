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
        <link rel="stylesheet" href="css/estilosMusico.css">
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
                        echo"<script>alert('El usuario ya no existe')</script>";
                    }
                } else {
                    echo"<script>alert('No puedes entrar aquí')</script>";
                }
                if ($mostrar == 1) {
                    ?>
                    <img src="Imagenes/banner.jpg">
                    <div id="centro"> 
                        <p>Datos de mi perfil</p>
                        <div id="usuario">
                            <?php
                            muestradatosmusico();
                            ?>
                        </div>

                        <div id="menu">
                            <ul>
                                <li><a href="#">Perfil</a></li>
                                <li><a href="#">Fotos</a></li>
                                <li><a href="homeuser.php">Mensajes</a></li>
                                <li><a href="miperfilmusico.php">Configuración</a></li>
                                <?php cerraSession2() ?>
                            </ul>
                        </div>
                        <div id="conciertosInteres">
                        </div>
                        <div id="contenidoInteres">
                            <p class="titulo">LISTA DE TODOS LOS CONCIERTOS PROPUESTOS</p>
                            <?php
                            if (cancelaconciertosantiguos() != "ok") {
                                echo "<script>alert('Error cancelando conciertos antiguos')</script>";
                            }
                            extract($_SESSION);
                            $id_usuario = dimeidusuario($username);
                            $idgeneroMusico = dimeIdgeneroUsuario($id_usuario);

                            $listaConciertosGenero = listaConciertosporGenero($idgeneroMusico);

                            echo"<table border='1' id='tablapropuestos'>";
                            echo "<tr>";
                            echo "<td><p class='titulodatos'>Nombre</p></td>";
                            echo "<td><p class='titulodatos'>Fecha</p></td>";
                            echo "<td><p class='titulodatos'>Hora</p></td>";
                            echo "<td><p class='titulodatos'>Local</p></td>";
                            echo "</tr>";
                            while ($fila = mysqli_fetch_assoc($listaConciertosGenero)) {
                                extract($fila);
                                echo"<tr>";
                                echo"<td><p class='datos'>$nomconcierto</p></td>";
                                echo"<td><p class='datos'>$fecha</p></td>";
                                echo"<td><p class='datos'>$hora</p></td>";
                                echo"<td><p class='datos'>$nombre</p></td>";
                                echo"<td id='alta'>";
                                altaMusicoConcierto($id_concierto);
                                echo"</td>";
                                echo"<td id='baja'>";
                                bajaMusicoConcierto($id_concierto);
                                echo"</td>";
                                echo"</tr>";
                            }
                            echo"</table>";

                            insertarPeticion();
                            bajaPeticion();

                            echo"<p>BUSCAR CONCIERTOS POR CIUDAD</p>";
                            echo"<p class='titulo'>BUSCAR CONCIERTOS POR CIUDAD</p>";
                            muestraSelectCiudad();

                            echo"<p class='titulo'>ESTADO DE TUS PETICIONES</p>";
                            peticionAceptadaLocal($id_usuario);
                            ?>


                        </div>
                        <div id="titulonoticias">
                            <p>Últimas noticias</p>
                        </div>
                        <div id="noticias">
                            <?php
                            $listaCociertos = listaConciertosPropuestos();
                            while ($fila = mysqli_fetch_assoc($listaCociertos)) {
                                extract($fila);
                                echo"<div class='noti'>";
//                                echo"<p>$nomconcierto</p>";
//                                echo"<p>$fecha</p>";
                                echo"<p><a href='' <p>$nomconcierto --- $fecha</p><img id='imgconc' src='Imagenes/AFS31.jpg'></a></p>";
                                echo"</div>";
                            }
                            ?>
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
