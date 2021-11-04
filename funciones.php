<?php

require_once 'bbdd.php';

//require_once 'msgbbdd.php';
//Desarrollador: Isain Alvaro
//Control desplegable de usuario
function controlDesplegable() {
    $mostrar = 0;
    if (isset($_SESSION['username'])) {
        $username = $_SESSION['username'];
        echo "<p id='saludo'>Hola $username</p>";
        echo "<style type='text/css'>";
        echo "#saludo {"
        . "margin-left: 230px;"
        . "color: red;";
        echo "</style>";
        $_SESSION['tipo'] = dimetipousuario($username);
        extract($_SESSION);

        switch ($tipo) {
            case 1:
                echo "<a href='usuariolocal.php'>Mi Perfil</a>";
                break;
            case 2:
                echo "<a href='usuariomusico.php'>Mi Perfil</a>";
                break;
            case 3:
                echo "<a href='usuariofan.php'>Mi Perfil</a>";
                break;
            default:
        }

        $mensajessinleer = mensajeSinLeer($username);
        echo"<a href='entrada.php'>Mensajes Pendientes por leer $mensajessinleer</a>";
    } else {
        echo "<a href='login.php'>Iniciar Sesión</a>";
    }
}

//Desarrollador: Artur
//Sube una foto enviada por post al servidor.
function subefoto() {
    if (isset($_FILES['fileupload'])) {
        if (!empty($_FILES['fileupload']['name'])) {

            $target_dir = "uploads/";
            $target_file = $target_dir . basename($_FILES["fileupload"]["name"]);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));


            $check = getimagesize($_FILES["fileupload"]["tmp_name"]);
            if ($check == false) {
                echo "<script>alert('El archivo no es una imagen válida.')</script>";
                $uploadOk = 0;
            }

            // Check if file already exists

            if (file_exists($target_file)) {
                echo "<script>alert('Error. El archivo de la foto ya existe en el servidor.')</script>";
                $uploadOk = 0;
            }
            // Check file size
            if ($_FILES["fileupload"]["size"] > 500000) {
                echo "<script>alert('Error. El archivo de la foto es demasiado grande.')</script>";
                $uploadOk = 0;
            }
            // Allow certain file formats
            if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
                echo "<script>alert('Error. Solo se admiten imágenes jpg, png y gif.')</script>";
                $uploadOk = 0;
            }
            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
                echo "<script>alert('La foto no se ha enviado.')</script>";
                // if everything is ok, try to upload file
                $target_file = '';
            } else {
                if (!move_uploaded_file($_FILES["fileupload"]["tmp_name"], $target_file)) {
                    echo "<script>alert('Ha habido un error subiendo la foto.')</script>";
                    $target_file = '';
                }
            }
        } else {
            $target_file = "";
        }
    } else {
        $target_file = "";
    }

    return $target_file;
}

//Desarrolador: Isain Alvaro
function eliminarVotoConcierto1($id_concierto) {
    return "<form action='' method='POST'>" .
            "<input type='hidden' value='$id_concierto' name='id_concierto'>" .
            "<input type='submit' value='Dislike' name='deletevotoConcierto'>" .
            "</form>";
}

function eliminarVotoConcierto2() {
    if (isset($_POST['deletevotoConcierto'])) {
        extract($_SESSION);
        $id_usuario = dimeidusuario($username);
        $id_concierto = $_POST['id_concierto'];
        if (eliminarVotoConcierto($id_usuario, $id_concierto) == "ok") {
            echo"<script>alert('voto eliminado')</script>";
        } else {
            echo"<script>alert('problemas eliminando voto')</script>";
        }
        echo "<script type='text/javascript'>window.location.href='usuariofan.php';</script>";
    }
}

//Desarrollador: Isain Alvaro
//Funcion para mostrar el botón de voto
function nuevoVotoConcierto($id_concierto) {
    return "<form action='' method='POST'>" .
            "<input type='hidden' value='$id_concierto' name='id_concierto'>" .
            "<input type='submit' value='Like' name='votoconcierto'>" .
            "</form>";
}

//Desarrollador: Isain Alvaro
//Funcion para registrar el voto de un concierto
function altaVotoConcierto2() {
    if (isset($_POST['votoconcierto'])) {
        extract($_SESSION);
        $id_usuario = dimeidusuario($username);
        echo$id_usuario;
        $id_concierto = $_POST['id_concierto'];
        if (altaVotoConcierto($id_usuario, $id_concierto) == "ok") {
            echo"<script>alert('voto de concierto registrado')</script>";
        } else {
            echo"problemas con el voto de concierto";
        }
        echo "<script type='text/javascript'>window.location.href='usuariofan.php';</script>";
    }
}

function eliminarVotoMusico1($id_musico) {
    return "<form action='' method='POST'>" .
            "<input type='hidden' value='$id_musico' name='id_musico'>" .
            "<input type='submit' value='Dislike' name='deletevoto'>" .
            "</form>";
}

function eliminarVotoMusico2() {
    if (isset($_POST['deletevoto'])) {
        extract($_SESSION);
        $id_usuario = dimeidusuario($username);
        echo$id_usuario;
        $id_musico = $_POST['id_musico'];
        if (eliminarVotoMusico($id_usuario, $id_musico) == "ok") {
            echo"<script>alert('voto eliminado')</script>";
        } else {
            echo"<script>alert('problemas eliminando voto')</script>";
        }
        echo "<script type='text/javascript'>window.location.href='usuariofan.php';</script>";
    }
}

function nuevoVotoMusico($id_musico) {
    return "<form action='' method='POST'>" .
            "<input type='hidden' value='$id_musico' name='id_musico'>" .
            "<input type='submit' value='Like' name='voto'>" .
            "</form>";
}

//<a class="icon-thumbs-up"></a>
function altaVotoMusico2() {
    if (isset($_POST['voto'])) {
        extract($_SESSION);
        $id_usuario = dimeidusuario($username);
        echo$id_usuario;
        $id_musico = $_POST['id_musico'];
        if (altaVotoMusico($id_usuario, $id_musico) == "ok") {
            echo"<script>alert('voto registrado')</script>";
        } else {
            echo"<script>alert('problemas registrando voto')</script>";
        }
        echo "<script type='text/javascript'>window.location.href='usuariofan.php';</script>";
    }
}

//Desarrollador: Artur
function conviertearray($datos) {
    $cont = 0;
    while ($fila = mysqli_fetch_assoc($datos)) {
        $f = Array("id_ciudad" => $fila["id_ciudad"], "nombre" => utf8_encode($fila["nombre"]));
        $resultado[$cont] = $f;
        $cont++;
    }
    return $resultado;
}

//Desarrollador: Artur
//function conviertearray($datos) {
//    $cont = 0;
//    while ($fila = mysqli_fetch_assoc($datos)) {
//        $resultado[$cont] = array_map('utf8_encode', $fila);
//        $cont++;
//    }
//    return $resultado;
//}
//Desarrolador: Isain
//Funcion que crea un  boton para dar de alta el musico en un concierto.
function bajaMusicoConcierto($id_concierto) {
    echo"<form action='' method='POST'>";
    echo"<input type='hidden' value='$id_concierto' name='id_concierto'>";
    echo"<input type='submit' value='Baja' name='baja'>";
    echo"</form>";
}

function bajaPeticion() {
    if (isset($_POST['baja'])) {
        extract($_SESSION);
        $id_usuario = dimeidusuario($username);
        $id_concierto = $_POST["id_concierto"];

        if (verificarPeticion($id_usuario, $id_concierto) == $id_usuario) {
            if (dimeConciertoAceptado($id_usuario, $id_concierto) == 1) {
                echo"<script>alert('El local ya ha aceptado tu peticion, no podemos darlo de baja')</script>";
            } else {
                if (bajaPeticionConcierto($id_usuario, $id_concierto) == "ok") {
                    echo"<script>alert('Se ha dado de baja a tu peticion')</script>";
                } else {
                    echo"<script>alert('Error al dar de baja la peticion')</script>";
                }
            }
        } else {
            echo"<script>alert('No te haza dado de alta para este concierto')</script>";
        }
    }
}

//Desarrolador: Alvaro -- Isain
// Funcion que hace una tabla de todos los conciertos en que ha sido aceptado un musico en especial.
function peticionAceptadaLocal($id_usuario) {
    echo"<table id='tablapropuestos2' border='1'>";
    echo"<tr>";
    echo "<td class='titulos2'><p>Nombre</p></td>";
    echo "<td class='titulos2'><p>Fecha</p></td>";
    echo "<td class='titulos2'><p>Hora</p></td>";
    echo "<td class='titulos2'><p>Estado de petición</p></td>";
    echo "<td class='titulos2'><p>Estado del concierto</p></td>";
    echo"</tr>";
    $aceptados = dimeConciertosAceptados($id_usuario);
    while ($fila = mysqli_fetch_assoc($aceptados)) {
        extract($fila);
        $estadoP = $estado;
        $datosConcierto = dimeConciertosporid($concierto);
        while ($fila2 = mysqli_fetch_assoc($datosConcierto)) {
            extract($fila2);
            echo"<tr>";
            echo"<td><p class='datos2'>$nombre</p></td>";
            echo"<td><p class='datos2'>$fecha</p></td>";
            echo"<td><p class='datos2'>$hora</p></td>";
            echo"<td>";
            estado($estadoP, $estado);
            echo"</td>";
            echo"<td>";
            if ($estado == 2) {
                echo"<p class='datos2'>Cancelado</p>";
            } else {
                echo"<p class='datos2'>Programado</p>";
            }
            echo"</td>";
            echo"</tr>";
        }
    }
    echo"</table>";
}

//Desarrollador: Alvaro -- Isain
//Funcion que transforma en aceptado o no un numero
//Desarrollador: Alvaro -- Isain
// Funcion que transforma en aceptado o no un numero
function estado($estadoP, $estado) {
    switch ($estadoP) {
        case 0:
            echo"<p class='datos2'>Pendiente</p>";
            break;
        case 1:
            echo "<p class='datos2'>Aceptado</p>";
            break;
        case 2:
            echo"<p class='datos2'>Rechazado</p>";
            break;
    }
}

//Desarrolador: Isain
//Funcion que crea un  boton para dar de alta el musico en un concierto.
function altaMusicoConcierto($id_concierto) {
    echo"<form action='' method='POST'>";
    echo"<input type='hidden' value='$id_concierto' name='id_concierto'>";
    echo"<input type='submit' value='Peticion' name='peticion'>";
    echo"</form>";
}

function insertarPeticion() {
    if (isset($_POST['peticion'])) {
        extract($_SESSION);
        $id_usuario = dimeidusuario($username);
        $id_concierto = $_POST["id_concierto"];

        if (verificarPeticion($id_usuario, $id_concierto) == $id_usuario) {
            echo"<script>alert('Ya has realizado una peticion')</script>";
        } else {
            if (insertarPeticionConcierto($id_usuario, $id_concierto) == "ok") {
                echo"<script>alert('La peticion se ha realizado satisfactoriamente')</script>";
            } else {
                echo"<script>alert('Error al realizar la petición')</script>";
            }
        }
    }
}

//Desarrolador: Isain
//Esta función muestra un select con todos los locales y regresa el id_local elegido.
function muestraSelectCiudad() {
    $datosCiudad = muestraDatosCiudadLocalMusico();
    echo"<form id='formulario' action='' method='POST'>";
    echo"<p>Ciudad<select name = 'ciudad'>";
    if (isset($_POST['buscar3'])) {
        extract($_POST);
    }
    while ($fila = mysqli_fetch_assoc($datosCiudad)) {
        extract($fila);
        if (isset($_POST['buscar3']) && $id_ciudad == $ciudad) {

            echo"<option value='$id_ciudad' selected>$nombre</option>";
        } else {
            echo"<option value='$id_ciudad'>$nombre</option>";
        }
    }
    echo"</select></p>";

    echo"<input type='submit' name='buscar3' value='Buscar'>";
    echo"</form>";

    if (isset($_POST['buscar3'])) {
        extract($_POST);
        $listaPorCiudad = dimeCociertosPorCiudad($ciudad);
        echo"<table border='1' id='tablapropuestos'>";
        while ($fila = mysqli_fetch_assoc($listaPorCiudad)) {
            extract($fila);
            echo"<tr>";
            echo"<td><p class='datos'>$nombre</p></td>";
            echo"<td><p class='datos'>$fecha</p></td>";
            echo"<td><p class='datos'>$hora</p></td>";
            echo"<td><p class='datos'>$usuario<p></td>";
            echo"<td id='alta'>";
            altaMusicoConcierto($id_concierto);
            echo"</td>";
            echo"<td id='baja'>";
            bajaMusicoConcierto($id_concierto);
            echo"</td>";
            echo"</tr>";
        }
        echo"</table>";
    }
}

//Desarrolador: Isain
//Esta función muestra un select con todos los locales y regresa el id_local elegido.
function muestraSelectLocal() {
    $datosLocales = muestraDatosLocal2();

    echo"<form action='' method='POST'>";
    echo"<p>Local<select name = 'local'>";
    while ($fila = mysqli_fetch_assoc($datosLocales)) {
        extract($fila);
        echo"<option value = '$id_usuario'>$nombre</option>";
    }
    echo"</select></p>";

    echo"<input type='submit' name='buscar2' value='buscar'>";
    echo"</form>";

    if (isset($_POST['buscar2'])) {
        extract($_POST);
        return $local;
    }
}

//Desarrollador: Isain
//Esta función muestra un select con todos los generos y regresa el id_genero elegido.
function muestraSelectGenero($id_usuario) {
    $datosGeneros = muestrageneros();

    echo"<form action='' method='POST'>";
    echo"<p>Genero<select name = 'gender'>";
    while ($fila = mysqli_fetch_assoc($datosGeneros)) {
        extract($fila);
        $nombre = utf8_encode($nombre);
        echo"<option value = '$id_genero'>$nombre</option>";
    }
    echo"</select></p>";

    echo"<input type='submit' name='buscar' value='buscar'>";
    echo"</form>";

    if (isset($_POST['buscar'])) {
        extract($_POST);
        $listaConcierto = conciertosPorGenero($gender);
        echo"<table border='1'>";

        while ($fila = mysqli_fetch_assoc($listaConcierto)) {
            extract($fila);
            echo"<tr>";
            echo"<td>$nomconcierto </td><td>$fecha</td><td>$hora</td><td>$pago</td><td>$nomlocal</td><td>$nomgenero</td>";
            echo"<td>";
            altaMusicoConcierto($id_concierto);
            echo"</td><br>";
            echo"</tr>";
        }

        echo"</table>";
    }

    insertarPeticion();
}

//Desarrollador: Isain
//Muestra Usuario segun tipo
function muestraUsuariosTipo($tipo) {
    switch ($tipo) {
        case 1:
            echo"<p>Tipo: Local</p>";
            break;
        case 2:
            echo"<p>Tipo: Musico</p>";
            break;
        case 3:
            echo"<p>Tipo: Fan</p>";
            break;
        default;
    }
}

//Desarrollador:Artur
//Devuelve el nombre de un género por el id
function dimenombregenero($idgenero) {
    $c = conectar();
    //Sentencia SQL. No se leen todos los campos, solo los principales.
    $select = "select nombre from genero where id_genero=$idgenero;";
    $resultado = mysqli_query($c, $select);
    if ($fila = mysqli_fetch_assoc($resultado)) {
        $salida = $fila['nombre'];
    } else {
        $salida = "no";
    }
    desconectar($c);
    return $salida;
}

//Desarrollador: Artur
//Muestra cual es el estado del concierto según el código
function cualestado($num) {
    switch ($num) {
        case 0:$cual = "Propuesto sin músico";
            break;
        case 1:$cual = "Programado";
            break;
        case 2:$cual = "Cancelado";
            break;
        default:
    }
    return $cual;
}

//Desarrollador: Álvaro
//Muestra los datos de perfil de fan
function muestradatosfan() {
    if (isset($_SESSION['tipo'])) {
        extract($_SESSION);
        if ($tipo == 3) {
            echo "Fan<br>";
            imprimenombreyfoto($username);
        }
    }
}

//Desarrolador Isain
//Muestra los datos del perfil del musico
function muestradatosmusico() {
    if (isset($_SESSION['tipo'])) {
        extract($_SESSION);
        if ($tipo == 2) {
            echo"Musicos";
        }

        imprimenombreyfoto($username);
    }
}

//Desarrollador Artur
//Muestra los datos del perfil del local en los campos informativos.
function muestradatoslocal() {
    if (isset($_SESSION['tipo'])) {
        extract($_SESSION);
        switch ($tipo) {
            case 0:
                echo"Usuario Administador.<br>";
                break;
            case 1:
                echo"Local musical<br>";
                break;
            case 2:
                echo"Músico<br>";
                break;
            case 3:
                echo"Fan<br>";
                break;
        }

        imprimenombreyfoto($username);
    }
}

//Desarrollador: Artur
//Muestra el nombre y la foto de un usuario
function imprimenombreyfoto($username) {
    $nombre = dimenombre($username);

    echo"<p>$nombre</p>";
    echo"<hr>";
    echo"<div id='info'>";
    $ruta = dimefoto($username);
    if (empty($ruta)) {
        $ruta = "Imagenes/sinimagen.jpg";
    }
    echo"<img src='$ruta' id='fotoperfil'>";
    echo "<style type='text/css'>";
    echo "#info #fotoperfil {"
    . "border-radius: 100px;"
    . "margin-top: -20px;"
    . "width: 129px;"
    . "height: 129px;"
    . "margin-left: -20px;";
    echo "</style>";
    echo"</div>";
}

//funcion para cerrar session
function cerraSession() {
    session_destroy();
    echo"Sesión cerrada";
}

function cerraSession2() {
    echo"<form action='' method='POST'>";
    echo"<input id='botoncerrar' type='submit' name='cerrar' value='CERRAR SESSION'>";
    echo"</form>";

    if (isset($_POST["cerrar"])) {
        session_destroy();
//      header("Location: index.php");
        echo"<script>alert('sesion cerrada')</script>";
        header("Refresh:1; url=index.php");
        exit;
    }
}

?>
