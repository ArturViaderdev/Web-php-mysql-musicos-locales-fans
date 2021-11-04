<?php
session_start();
require_once 'bbdd.php';
require_once 'funciones.php';
extract($_SESSION);
?>
<html lang="es">
    <head>
        <title>OohMusic</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, maximum-scale=1, minimum-scale=1">
        <link rel="stylesheet" href="css/fontello.css">
        <link rel="stylesheet" href="css/estiloslistaConciertosLocal.css">
    </head>
    <body>
        <?php
        if (isset($_POST['nombre'])) {
            extract($_POST);
            extract($_SESSION);
            $id_usuario = dimeidusuario($username);
            if (anadeconcierto($nombre, $fecha, $hora, $pago, $id_usuario, $gender)) {
                echo "<script>alert('Alta realizada con éxito')</script>";
            } else {
                echo "<script>alert('Error añadiendo el concierto')</script>";
            }
        } else {
            ?>
            <header>
                <div class="contenedor">
                    <h1 class="icon-music">Ooh Music</h1>
                    <input type="checkbox" id="menu-user">
                    <label id="label1" class="icon-user-circle" for="menu-user"></label>
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
                            <li class="submenu"><a href="">Registro <span class="icon-sort-down"></span></a>
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
                    <img  id='fotobanner' src="Imagenes/banner.jpg">
                    <div id="centro"> 
                        <p></p>
                        <div id="usuario">
                            <?php
                            muestradatoslocal();
                            ?>
                        </div>
                        <nav class="menuLocal">
                            <ul>
                                <li><a href="usuariolocal.php">Perfil</a></li>
                                <li><a href="#">Fotos</a></li>
                                <li><a class="concierto" href="#" id="boton1">Conciertos</a>
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
                        if (isset($_SESSION['username'])) {
                            $id_usuario = dimeidusuario($username);
                            $conciertos = listaconciertoslocal($id_usuario);
                            echo "<table id='tabladedatos' border=1>";
                            echo "<tr>";
                            echo "<td id='titulotabla'><p>Conciertos de tu local</p></td>";
                            echo "</tr>";
                            echo "<tr id='titulostd'>";
                            echo "<td><p>Nombre</p></td>";
                            echo "<td><p>Fecha</p></td>";
                            echo "<td><p>Hora</p></td>";
                            echo "<td><p>Género</p></td>";
                            echo "<td><p>Estado</p></td>";
                            echo "<td><p></p></td>";
                            if (cancelaconciertosantiguos() != "ok") {
                                echo "<script>alert('Error cancelando conciertos antiguos')</script>";
                            }
                            while ($fila = mysqli_fetch_assoc($conciertos)) {
                                extract($fila);
                                $ngenero = dimenombregenero($genero);
                                $estadop = cualestado($estado);
                                echo "<tr class='sintitulo'>";
                                echo "<td><p>$nombre</p></td>";
                                echo "<td><p>$fecha</p></td>";
                                echo "<td><p>$hora</p></td>";
                                $ngenero = utf8_encode($ngenero);
                                echo "<td><p>$ngenero</p></td>";
                                echo "<td><p>$estadop</p></td>";
                                if ($estado == 0) {
                                    $musicospropuestos = cuantosmusicospropuestos($id_concierto);
                                    if ($musicospropuestos > 0) {
                                        echo"<td class='conciertop'><a href='cancelarconcierto.php?id=$id_concierto'>Cancelar</a></td>";
                                        echo "<td class='conciertop'><a href='confirmarconcierto.php?id=$id_concierto'>Hay $musicospropuestos"
                                        . "músicos propuestos.</a></td>";
                                    } else {
                                        echo"<td class='conciertop'><a href='borraconcierto.php?id=$id_concierto'><span class='icon-trash'></span></a></td>";
                                    }
                                } else {
                                    if ($estado == 1) {
                                        $elmusico = dimealiasmusico($musico);
                                        echo "<td class='conciertop'><p>$elmusico</p></td>";
                                    } else {
                                        echo "<td class='conciertop'>Ninguno</td>";
                                    }
                                }
                                echo"</tr>";
                            }
                            echo"</table>";
                        } else {
                            echo"Sesión no iniciada.";
                        }
                        ?>
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
