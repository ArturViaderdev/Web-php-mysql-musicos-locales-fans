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
                                <li><a href="usuariofan.php">Perfil</a></li>
                                <li><a href="#">Fotos</a></li>
                                <li><a href="homeuser.php">Mensajes</a></li>
                                <li><a href="miperfilfan.php">Configuración</a></li>
                                <?php cerraSession2() ?>
                            </ul>
                        </div>
                        <div id="conciertosInteres">
                            <p>Votos</p>
                        </div>
                        <div id="contenidoInteres">

                            <?php
                            extract($_SESSION);
                            $id_usuario = dimeidusuario($username);

                            echo"<table id='tabla1' border='1'>";
                            echo"<tr>";
                            echo"<td>NOMBRE</td><td>GENERO</td>";
                            echo"</tr>";
                            $listamusicos = ordenarMusicosPorGenero();
                            while ($musicos = mysqli_fetch_assoc($listamusicos)) {
                                extract($musicos);
                                echo"<tr>";
                                $id_musico = dimeidusuario($nombreart);
                                    
                                $nombre = utf8_encode($nombre);
                                if(verificarVotoMusico($id_usuario, $id_musico)){
                                    echo"<td>$nombreart</td><td>$nombre</td><td>". eliminarVotoMusico1($id_musico)."</td>";
                                    
                                }else{
                                    echo"<td>$nombreart</td><td>$nombre</td><td>". nuevoVotoMusico($id_musico)."</td>";
                                    
                                }
                                echo"</tr>";
                            }
                            echo"</table>";

                            altaVotoMusico2();
                            eliminarVotoMusico2();
                            //-------------------------------------------------------------------------------------------------------------------
                            echo "<hr>";
                            echo"<table id='tabla2' border='1'>";
                            echo"<tr>";
                            echo"<td>Nombre del concierto</td>";
                            echo"<td>Genero</td>";
                            echo"<td>Organizador</td>";
                            echo"</tr>";

                            if (isset($_GET['pagina'])) {
                                extract($_GET);
                            } else {
                                $pagina = 1;
                            }
                            $elementospagina = 4;
                            $inicio = ($pagina - 1) * $elementospagina;
                            $cuantosconciertos = cuantosconciertosaceptados();
                            $totalpaginas = ceil(($cuantosconciertos) / $elementospagina);
                            $listaConciertosAceptados = mostrarListaConciertosAceptados($inicio, $elementospagina);

                            while ($lista = mysqli_fetch_assoc($listaConciertosAceptados)) {                            
                                extract($lista);
                                  $nomgenero= utf8_encode($nomgenero);
                                echo "<tr>";
                                $id_concierto = dimeidconcierto($nomconcierto);
//                                echo "<td>$nomconcierto</td>";
//                                echo "<td>$nomgenero</td>";
//                                echo "<td>$nomlocal</td>";
//                                echo "<td>".nuevoVotoConcierto($id_concierto)."</td>";
                                if (verificarVotoConcierto($id_usuario, $id_concierto)) {
                                    echo"<td>$nomconcierto</td><td>$nomgenero</td><td>$nomlocal</td><td>". eliminarVotoConcierto1($id_concierto)."</td>";
                                } else {
                                    echo"<td>$nomconcierto</td><td>$nomgenero</td><td>$nomlocal</td><td>". nuevoVotoConcierto($id_concierto)."</td>";
                                }
                                echo "</tr>";
                            }
                            echo "</table>";
                            
                            altaVotoConcierto2();
                            eliminarVotoConcierto2();
                            
                            //echo"Página $pagina de $totalpaginas, Hay $cuantosconciertos conciertos aceptados.<br>";
                            echo "<p id='paginado'>$pagina/$totalpaginas</p>";
                            if ($pagina > 1) {
                                echo"<a href='usuariofan.php?pagina=1' id='primera'><span class='icon-to-start'></span></a>";
                                $anterior = $pagina - 1;
                                echo" <a href='usuariofan.php?pagina=$anterior' id='anterior'><span class='icon-left-dir'></span></a>";
                            }

                            if ($pagina < $totalpaginas) {
                                $siguiente = $pagina + 1;
                                echo" <a href='usuariofan.php?pagina=$siguiente' id='siguiente'><span class='icon-right-dir'></span></a>";
                                echo" <a href='usuariofan.php?pagina=$totalpaginas' id='ultima'><span class='icon-to-end'></span></a>";
                            }
                            ?>
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
