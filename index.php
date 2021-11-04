<html lang="es">
    <head>
        <title>Ooh Music</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, maximum-scale=1, minimum-scale=1">
        <link rel="stylesheet" href="css/fontello.css">
        <link rel="stylesheet" href="css/estilos.css">
        <script src="jquery.min.js"></script>
        <script type="text/javascript" src="funciones.js"></script>
    </head>
    <body>
        <?php
        session_start();
        require_once 'bbdd.php';
        require_once 'funciones.php';
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
                <div class="contenedor">
                    <h2>Música para todos</h2>
                    <p>Nuevos conciertos en tu ciudad</p>
                    <a href="login.php">Leer más</a>
                </div>
            </section>
            <section id="bienvenidos">
                <h2>Bienvenidos</h2>
                <p>En nuestra página podrás disfrutar de todos los conciertos de tu ciudad con solo un clik, apoyar a tus artistas favoritos o hacerte fan.</p>
            </section>
            <section id="blog">
                <h3>Aquí tienes a nuestros locales y músicos ¡Échales un ojo!</h3>
                <div id="busc">
                    <form method="POST">  
                        <p>Buscar: <input id="buscador" type="text" name="buscador" autocomplete="off" placeholder="Busca aquí" required>
                            <input type="submit" value="GO" name="buscar2" id="auto" ></p>
                    </form>
                </div>
                <div id="autobuscador">
                </div>
                <?php
                if (isset($_POST["buscar2"])) {
                    extract($_POST);
                    $resuBusqueda = buscador($buscador);
                    if ($resuBusqueda == -1) {
                        echo "<div id='descripcion' class='recuadro'>";
                        echo "<br>";
                        echo"<br><h1>¡Lástima, no se ha encontrado ningún resultado de tu busqueda!</h1><br>";
                        echo "</div>";
                    } else {
                        echo"<div id='descripcion' class='recuadro'>";
                        extract($resuBusqueda);
                        muestraUsuariosTipo($tipo);
                        echo"<br>";
                        echo"<p>Nombre: $nombre</p>";
                        echo"<p><br>Email: $email<br></p>";
                        if ($tipo == 1) {
                            $r = mirarConciertosLocal2($id_usuario);
                            echo "<table border='1' id='tablabuscador'>";
                            echo"<tr><td><p>PROXIMOS CONCIERTOS</p></td></tr>";
                            echo "<tr id='tituloss'>";
                            echo "<td><p>Nombre</p></td>";
                            echo "<td><p>Fecha</p></td>";
                            echo "<td><p>Hora</p></td>";
                            echo "</tr>";

                            while ($fila = mysqli_fetch_assoc($r)) {
                                extract($fila);
                                echo "<tr>";
                                echo"<td><p>$nombre</p></td><td><p>$fecha</p></td> <td><p>$hora</p></td>";
                                echo "</tr>";
                            }
                            echo "</table>";
                        }
                        echo "</div>";
                    }
                }
                ?>
                <div class='content-all'>
                    <div class='content-carrousel'>
                        <figure><img src="Imagenes/img1.jpg"></figure>
                        <figure><img src="Imagenes/img2.jpg"></figure>
                        <figure><img src="Imagenes/img3.jpg"></figure>
                        <figure><img src="Imagenes/img4.jpg"></figure>
                        <figure><img src="Imagenes/img5.jpg"></figure>
                        <figure><img src="Imagenes/img6.jpg"></figure>
                        <figure><img src="Imagenes/img7.jpg"></figure>
                        <figure><img src="Imagenes/img8.jpg"></figure>
                        <figure><img src="Imagenes/img9.jpg"></figure>
                        <figure><img src="Imagenes/img10.jpg"></figure>
                    </div>
                </div>
                <br><br><br><br><br><br><br><br>
                <div class="contenedor">                       
                    <article>

                    </article>
                    <article>
                        <h4 id="vot">Musicos mas votados</h4>
                        <div class="listas" id="votos">
                            <table border="1">
                                <tr id="titulosvotos">
                                    <td>Nombre artístico</td>
                                    <td>Genero</td>
                                    <td>Votos de sus fans</td>
                                </tr>
                                <?php
                                $tendencias = totalVotosPorMusico();
                                while ($fila = mysqli_fetch_assoc($tendencias)) {
                                    extract($fila);
                                    echo "<tr id='datosvotos'>";
                                    $tendenciasMusico = listaMusicosMasVotados($musico);
                                    while ($fila2 = mysqli_fetch_assoc($tendenciasMusico)) {
                                        extract($fila2);
                                        $nombre = utf8_encode($nombre);
                                        echo "<td><p>$nombreart</p></td>";
                                        echo "<td><p>$nombre</p></td>";
                                        echo "<td><p>$totalvotos</p></td>";
                                    }
                                    echo "</tr>";
                                }
                                echo "</table>";
                                ?> 
                        </div>
                    </article>
                    <article id="prueba">
                        <h4 id="conc">Conciertos</h4>
                        <div class="listas" id="conciertos">
                            <table border="1">
                                <tr id="titulos">
                                    <td>Nombre del concierto</td>
                                    <td>Genero</td>
                                    <td>Organizador</td>
                                    <td>Fecha</td>
                                    <td>Hora</td>
                                    <td>Pago</td>
                                </tr>
                                <?php
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

                                    echo "<tr id='datos'>";
                                    echo "<td><p>$nomconcierto</p></td>";
                                    $nomgenero = utf8_encode($nomgenero);
                                    echo "<td><p>$nomgenero</p></td>";
                                    echo "<td><p>$nomlocal</p></td>";
                                    echo "<td><p>$fecha</p></td>";
                                    echo "<td><p>$hora</p></td>";
                                    echo "<td><p>$pago</p></td>";
                                    echo "</tr>";
                                }
                                echo "</table>";

                                //echo"Página $pagina de $totalpaginas, Hay $cuantosconciertos conciertos aceptados.<br>";
                                echo "<p id='paginado'>$pagina/$totalpaginas</p>";
                                if ($pagina > 1) {
                                    echo"<a href='index.php?pagina=1' id='primera'><span class='icon-to-start'></span></a>";
                                    $anterior = $pagina - 1;
                                    echo" <a href='index.php?pagina=$anterior' id='anterior'><span class='icon-left-dir'></span></a>";
                                }

                                if ($pagina < $totalpaginas) {
                                    $siguiente = $pagina + 1;
                                    echo" <a href='index.php?pagina=$siguiente' id='siguiente'><span class='icon-right-dir'></span></a>";
                                    echo" <a href='index.php?pagina=$totalpaginas' id='ultima'><span class='icon-to-end'></span></a>";
                                }
                                ?>
                        </div>
                    </article>
                </div>
            </section>
            <section id="info">
                <h3>¡Vívelo! No solo es música...</h3>
                <div class="contenedor">
                    <div class="info-music">
                        <img src="Imagenes/clasica.jpg">
                        <h4>Música clásica</h4>
                    </div>
                    <div class="info-music">
                        <img src="Imagenes/hiphop.jpg">
                        <h4>Musica Hip Hop</h4>
                    </div>
                    <div class="info-music">
                        <img src="Imagenes/rock.jpg">
                        <h4>Música Rock</h4>
                    </div>
                    <div class="info-music">
                        <img src="Imagenes/electronica.jpg">
                        <h4>Música electrónica</h4>
                    </div>
                </div>
            </section>
            <?php
            if (isset($_GET['cerrar'])) {
                cerraSession();
            }
            ?>
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