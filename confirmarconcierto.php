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
                    <a href="#">Mi perfil</a>
                    <a href="index.php">Cerrar sesión</a>
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
                        <p>Datos de mi concierto</p>
                        <div id="usuario">
                            <?php
                            muestradatoslocal();
                            ?>
                        </div>
                        <nav class="menuLocal">
                            <ul>
                                <li><a href="usuariolocal.php">Perfil</a></li>
                                <li><a href="#">Fotos</a></li>
                                <li><a class="concierto" href="" id="boton1">Conciertos</a>
                                    <ul>
                                        <div id="submenudiv">
                                            <li><a href="conciertosdelocal.php" id="uno">Mis conciertos</a></li>
                                            <li><a href="anadirconcierto.php" id="dos">Organizar un concierto</a></li>
                                        </div>
                                    </ul>
                                </li>
                                <li><a href="#">Mensajes</a></li>
                                <li><a href="miperfillocal.php">Configuración</a></li>
                                <?php cerraSession2() ?>
                            </ul>
                        </nav>    
                        <?php
                        extract($_SESSION);
                        $error = 0;
                        if (isset($_SESSION['username'])) {
                            if (isset($_POST['concierto'])) {
                                if (compruebaconciertoesdelocal($_SESSION['username'], $_POST['concierto']) == "ok") {
                                    extract($_POST);
                                    if (confirmaconcierto($concierto, $musico) == "ok") {
                                        echo"<script>alert('Concierto confirmado')</script>";
                                    } else {
                                        echo"Error confirmando el concierto. Verifica que no se haya confirmado antes.<br>";
                                    }
                                } else {
                                    $error = 1;
                                }
                            } else {
                                if (isset($_GET['id'])) {
                                    if (compruebaconciertoesdelocal($_SESSION['username'], $_GET['id']) == "ok") {
                                        $datosconcierto = infoconcierto($_GET['id']);
                                        if ($datos = mysqli_fetch_assoc($datosconcierto)) {
                                            extract($datos);
                                            echo"<div id='datosconciertos'>";
                                            echo"<div id='datoos'>";
                                            echo"<p>Nombre:$nombre</p>";
                                            echo"<p>Fecha:$fecha</p>";
                                            echo"<p>Hora:$hora</p>";
                                            $ngenero = dimenombregenero($genero);
                                            $estadop = cualestado($estado);
                                            echo"<p>Género:$ngenero<p>";
                                            echo"<p class='estado'>Estado del concierto:</p><p class='estado'>$estadop</p>";
                                            echo"</div>";
                                            echo"<div id='musicoos'>";
                                            if ($estado == 0) {
                                                echo"<div id='titulolista'>";
                                                echo"<p>Músicos que han propuesto su actuación.</p>";
                                                echo"</div>";
                                                $listamusicos = listamusicospropuestos($_GET['id']);
                                                echo"<form method='post'>";
                                                $conta = 0;
                                                while ($lista = mysqli_fetch_assoc($listamusicos)) {
                                                    extract($lista);
                                                    if ($conta == 0) {
                                                        echo"<p class='radio'><input type='radio' class='botonradio' name='musico' value=$musico checked>$nombreart $nombre $apellidoa $apellidob</p>";
                                                    } else {
                                                        echo"<p class='radio'><input type='radio' class='botonradio' name='musico' value=$musico>$nombreart $nombre $apellidoa $apellidob</p>";
                                                    }
                                                    $conta++;
                                                }
                                                $concierto = $_GET['id'];
                                                echo"<input type='hidden' value=$concierto name='concierto'>";
                                                echo"<input type='submit' id='boton' value='Confirmar músico y concierto'></form>";
                                                echo "</div>";
                                                echo"</div>";
                                            } else {
                                                echo"El concierto ya no está por confirmar.<br>";
                                            }
                                        } else {
                                            echo"Concierto eliminado.<br>";
                                        }
                                    } else {
                                        $error = 1;
                                    }
                                } else {
                                    $error = 1;
                                }
                            }
                        } else {
                            $error = 1;
                        }
                        if ($error == 1) {
                            echo"No puedes entrar aquí.<br>";
                        }
                        ?>
                        </ul>
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

