<!DOCTYPE html>
<!--
Esta es la pagina para registrar fans. 
-->
<?php
require_once 'bbdd.php';
require_once 'funciones.php';
?>
<html lang="es">
    <head>
        <title>OohMusic</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, maximum-scale=1, minimum-scale=1">
        <link rel="stylesheet" href="css/fontello.css">
        <link rel="stylesheet" href="css/estilosRfan.css">
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
                <div id="formulario"> 
                
                    <?php
                    if (isset($_POST["next"])) {
                        extract($_POST);
                        $target_file = subefoto();

                        if (usuarioexiste($username) > 0) {
                            echo "<script>alert('Este usuario ya está registrado')</script>";
                            //echo"Error..este usuario ya esta registrado";
                        } else {
                            if ($pass1 == $pass2) {
                                if (registrar_fan($username, $pass1, 3, $name, $mail, $phone, $city, $surname1, $surname2, $address, $target_file) == "ok") {
                                    //alta_usuarios($username, $pass1, $name, $surname1);
                                    echo"<script>alert('Se ha registrado el fan correctamente')</script>";
                                    header("Refresh:0; url=login.php");
                                } else {
                                    echo "<script>alert('Error al registrar fan')</script>";
                                    //echo"Error al registrar fan";
                                }
                            }
                        }
                    } else {
                        ?>
                        <div id="formulariodatos">
                            <form method="POST" onsubmit="return verificar();" enctype="multipart/form-data">
                                <table border="1">
                                    <tr class="data">
                                        <td id="izquierda"><p>Nombre</p></td>
                                        <td><p>Nombre de usuario</p></td>
                                    </tr>
                                    <tr>
                                        <td><input type="text" name="name" required></td>
                                        <td><input type="text" name="username" required></td>
                                    </tr>
                                    <tr class="data">
                                        <td><p>Primer apellido</p></td>
                                        <td><p>Email</p></td>
                                    </tr>
                                    <tr>
                                        <td><input type="text" name="surname1" required></td>
                                        <td><input type="email" name="mail" id="email" required></td>
                                    </tr>
                                    <tr class="data">
                                        <td><p>Segundo apellido</p></td>
                                        <td><p>Provincia</p></td>
                                    </tr>
                                    <tr>
                                        <td><input type="text" name="surname2" required></td>
                                        <td><select id="provincia">
                                                <?php
                                                $provincias = dimeprovincias();
                                                $cont = 0;
                                                while ($fila = mysqli_fetch_assoc($provincias)) {
                                                    extract($fila);
                                                    if ($cont == 0) {
                                                        $primeraprovincia = $provincia;
                                                        $cont++;
                                                    }
                                                    $provincia = utf8_encode($provincia);
                                                    echo "<option value='$provincia'>$provincia</option>";
                                                }
                                                ?>
                                            </select></td>
                                    </tr>
                                    <tr class="data">
                                        <td><p>Contraseña</p></td>
                                        <td><p>Ciudad</p></td>
                                    </tr>
                                    <tr>
                                        <td><input type="password" name="pass1" id="pass1" required></td>
                                        <td><select id="city" name="city" required>
                                            <?php
                                            $ciudades = leeciudades($primeraprovincia);
                                            while ($fila = mysqli_fetch_assoc($ciudades)) {
                                                extract($fila);
                                                $nombre = utf8_encode($nombre);
                                                echo "<option value='$id_ciudad'>$nombre</option>";
                                            }
                                            ?>
                                            </select></td>
                                    </tr>
                                    <tr class="data">
                                        <td><p>Repite contraseña</p></td>
                                        <td><p>Dirección</p></td>
                                    </tr>
                                    <tr>
                                        <td><input type="password" name="pass2" id="pass2" required></td>
                                        <td><input type="text" name="address" required></td>
                                    </tr>
                                    <tr class="data">
                                        <td><p>Imagen de perfil</p></td>
                                        <td><p>Teléfono</p></td>
                                    </tr>
                                    <tr>
                                       <td><input type="file" accept=".jpeg,.png" name="fileupload" id="fileupload" class="file-input"></td> 
                                       <td><input type="number" name="phone"></td>
                                    </tr>
                                    <tr>
                                        <td id="botonr" colspan="2"><input type="submit" name="next" value="Registrar Fan"></td>
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
