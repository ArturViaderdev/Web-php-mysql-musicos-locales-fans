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
        <link rel="stylesheet" href="css/estilosanadirLocal.css">
        <script src="jquery.min.js"></script>
        <script type="text/javascript" src="funciones.js"></script>
        <script type="text/javascript"></script>
    </head>
    <body>
        <?php
        if (isset($_SESSION['username'])) {
            if (isset($_POST['nombre'])) {
                extract($_POST);
                extract($_SESSION);
                $id_usuario = dimeidusuario($username);
                if (anadeconcierto($nombre, $fecha, $hora, $pago, $id_usuario, $gender)) {
                    echo "<script>alert('Alta realizada con éxito')</script>";
                } else {
                    echo "<script>alert('Error añadiendo el concierto')</script>";
                }
                header("Location:usuariolocal.php");
            } else {
                ?>
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
                        <div id="centro"> 
                            <p>Datos de mi perfil</p>
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
                            <div id="miperfil">
                                <div id="crearconcierto">
                                    <form method="POST" onsubmit="return verifech()">
                                        <table border="1">
                                            <tr id="titulo">
                                                <td><p>Organizar un concierto</p></td>
                                            </tr>
                                            <tr class="data">
                                                <td><p>Nombre</p></td>
                                            </tr>
                                            <tr>
                                                <td><input type="text" name="nombre" id="nombre" required></td>
                                            </tr>
                                            <tr class="data">
                                                <td><p>Fecha</p></td>
                                            </tr>
                                            <tr>
                                                <?php
                                                echo"<td><input type='date' name='fecha' id='fecha' value='" . date('Y-m-d') . "'" . "required></td>";
                                                ?>
                                            </tr>
                                            <tr class="data">
                                                <td><p>Hora</p></td>
                                            </tr>
                                            <tr>
                                                <td><input type="time" name="hora" required></td>
                                            </tr>
                                            <tr class="data">
                                                <td><p>Género</p></td>
                                            </tr>
                                            <tr>
                                                <?php
                                                echo "<td><select id='select' name='gender'>";
                                                $generos = muestrageneros();
                                                while ($fila = mysqli_fetch_assoc($generos)) {
                                                    extract($fila);
                                                    $nombre = utf8_encode($nombre);
                                                    echo "<option value='$id_genero'>$nombre</option>";
                                                }
                                                echo "</select></td>";
                                                ?>
                                            </tr>
                                            <tr class="data">
                                                <td><p>Precio de entradas</p></td>
                                            </tr>
                                            <tr>
                                                <td><input type="number" name="pago" required placeholder="en euros..."></td>
                                            </tr>
                                            <tr class="boton">
                                                <td><input type="submit" value="Crear concierto"></td>
                                            </tr>
                                        </table>
                                    </form>
                                </div>
                            </div>
                            <?php
                        }
                    } else {
                        echo "Sesion no iniciada";
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