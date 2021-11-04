<?php
session_start();
require_once 'bbdd.php';
require_once 'funciones.php';
?>
<!DOCTYPE html>
<!--
Pagina de locales.
-->
<html lang="es">
    <head>
        <title>OohMusic</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, maximum-scale=1, minimum-scale=1">
        <link rel="stylesheet" href="css/fontello.css">
        <link rel="stylesheet" href="css/estilosMiperfilLocal.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script type="text/javascript" src="funciones.js"></script>
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
                <div id="centro"> 
                    <p>Datos de mi perfil</p>
                    <div id="usuario">
                        <?php
                        muestradatosfan();
                        ?>
                    </div>

                    <div id="menu">
                        <ul>
                            <li><a href="usuariofan.php">Perfil</a></li>
                            <li><a href="#">Fotos</a></li>
                            <li><a href="#">Mensajes</a></li>
                            <li><a href="miperfilfan.php">Configuración</a></li>
                            <?php cerraSession2() ?>
                        </ul>
                    </div>
                    <script>
                        function abrirParametros() {
                            var ventana = open('', '', 'status=yes,width=400,height=250,menubar=yes');
                            ventana.document.write("<style type='text/css'>");
                            ventana.document.write("* {text-align: center; background: rgba(55,55,55,.21); color:#fff;}");
                            ventana.document.write("input {border: none; border-radius: 15px; background: rgba(255,255,255,.8);}");
                            ventana.document.write("input[type=submit]{color: black; cursor: pointer;}");
                            ventana.document.write("input[type=submit]:hover {background: rgba(55,55,55,.3); color: #fff;}");
                            ventana.document.write("</style>");
                            ventana.document.write("\x3Cscript type='text/javascript' src='funciones.js'>\x3C/script>");
                            ventana.document.write("<form method='post' action='modipass.php' onsubmit='return verificapass();'>");
                            ventana.document.write("<p>Introduce tu contraseña actual:</p>");
                            ventana.document.write("<p><input type='password' name='passactual' required></p>");
                            ventana.document.write("<p>Introduce la nueva contraseña:</p>");
                            ventana.document.write("<p><input type='password' name='pass1' id='pass1' required></p>");
                            ventana.document.write("<p>Repite tu nueva contraseña:</p>");
                            ventana.document.write("<p><input type='password' name='pass2' id='pass2' required></p>");
                            ventana.document.write("<p><input type='submit' value='Cambiar contraseña'></p>");
                            ventana.document.write("</form>");
                        }
                    </script>
                    <?php
                    if (isset($_POST['name'])) {
                        extract($_POST);
                        extract($_SESSION);
                        //Hacer la modificación.

                        if ($_FILES['fileupload']['name'] == "") {
                            $foto = dimefoto($username);
                        } else {
                            $foto = subefoto();
                            if (empty($foto)) {
                                $foto = dimefoto($username);
                            }
                        }

                        if (modificarperfilfan($username, $name, $email, $phone, $city, $surname1, $surname2, $address, $foto) == "ok") {
                            echo "<script>alert('Modificación realizada.')</script>";
                        } else {
                            echo"<script>alert('Error modficando perfil de Fan')</script>";
                        }
                    }
                    ?>
                    <div id="miperfil">

                        <div id="formulariodatos">
                            <form method="post" enctype="multipart/form-data">
                                <table border="1">
                                    <?php
                                    if (isset($_SESSION['username'])) {
                                        extract($_SESSION);
                                        $perfil = leerperfilfan($username);
                                        if ($datos = mysqli_fetch_assoc($perfil)) {
                                            extract($datos);
                                            echo "<tr class='data'>";
                                            echo "<td><p>Nombre:</p></td>";
                                            echo "<td><p>Email:</p></td>";
                                            echo "</tr>";
                                            echo "<tr>";
                                            echo "<td><input type='text' id='nombre' name='name' value='$nombre' required></td>";
                                            echo "<td><input type='email' id='email' name='email' value='$email' required></td>";
                                            echo "</tr>";
                                            echo "<tr class='data'>";
                                            echo "<td><p>Primer apellido:</p></td>";
                                            echo "<td><p>Provincia:</p></td>";
                                            echo "</tr>";
                                            echo "<tr>";
                                            echo "<td><input type='text' name='surname1' value='$apellidoa' required></td>";
                                            echo "<td><select id='provincia'>";
                                            $laprovincia = dimeprovinciadeciudad($ciudad);
                                            $provincias = dimeprovincias();
                                            while ($fila = mysqli_fetch_assoc($provincias)) {
                                                extract($fila);
                                                $p = utf8_encode($provincia);
                                                if (($laprovincia == $provincia)) {
                                                    echo "<option value='$p' selected>$p</option>";
                                                } else {
                                                    echo "<option value='$p'>$p</option>";
                                                }
                                            }
                                            echo "</select></td>";
                                            echo "</tr>";
                                            echo "<tr class='data'>";
                                            echo "<td><p>Segundo apellido:</p></td>";
                                            echo "<td><p>Ciudad:</p></td>";
                                            echo "</tr>";
                                            echo "<tr>";
                                            echo "<td><input type='text' name='surname2' value='$apellidob' required></td>";
                                            echo "<td><select id='city' name='city'>";
                                            $ciudades = leeciudades($laprovincia);
                                            while ($fila = mysqli_fetch_assoc($ciudades)) {
                                                extract($fila);
                                                $nombre = utf8_encode($nombre);
                                                if ($id_ciudad == $ciudad) {
                                                    echo "<option value='$id_ciudad' selected>$nombre</option>";
                                                } else {
                                                    echo "<option value='$id_ciudad'>$nombre</option>";
                                                }
                                            }
                                            echo "</select></td>";
                                            echo "</tr>";
                                            echo "<tr class='data'>";
                                            echo "<td><p>Teléfono:</p></td>";
                                            echo "<td><p>Direccion:</p></td>";
                                            echo "</tr>";
                                            echo "<tr>";
                                            echo "<td><input type='tel' name='phone' value='$telefono' required></td>";
                                            echo "<td><input type='text' name='address' value=$direccion>";
                                            echo "</tr>";
                                            echo "<tr class='data'>";
                                            echo "<td colspan='2'><p>Imagen</p></td>";
                                            echo "</tr>";
                                            echo "<tr>";
                                            echo "<td colspan='2'><input type='file' accept='.jpeg,.png' name='fileupload' id='fileupload'></td>";
                                            echo "</tr>";
                                            echo "<tr id='botones'>";
                                            echo "<td><p><input type='button' value='Cambiar contraseña' id='contaseña' class='boton' onClick='abrirParametros()'></p></td>";
                                            echo "<td><p><input type='submit' value='Modificar datos de perfil' id='button' class='boton'></p></td>";
                                            echo "</tr>";
                                        } else {
                                            echo "<script>alert('El usuario se ha eliminado')</script>";
                                        }
                                    } else {
                                        echo "<script>alert('No puedes entrar aquí')</script>";
                                    }
                                    ?>
                                </table>
                            </form>
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
