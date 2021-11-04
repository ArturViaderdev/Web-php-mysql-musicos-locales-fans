<?php
//Desarrollador: Isain 
//Comprueba si el mail esta repetido
function compruebameEmail(){
    $c = conectar();
    $select = "select * from login;";
    $resultado = mysqli_query($c, $select);
    desconectar($c);
    return $resultado;
}

//Desarrollador: Artur
//Devuelve la ruta de la foto de un usuario
function dimefoto($usuario)
{
    $c = conectar();
    $select = "select imagen from login where usuario = '$usuario';";
    $resultado = mysqli_query($c, $select);
    if($fila = mysqli_fetch_assoc($resultado)){
        extract($fila);
    }else{
        $imagen='';
    }
    
    
    desconectar($c);
    return $imagen;
}

//Desarrollado: Isain Alvaro
//Funcion que borra el voto en caso de que este
function eliminarVotoConcierto($id_usuario,$id_concierto){
    $c = conectar();
    $select = "delete from votoconcierto where fan = $id_usuario and concierto = $id_concierto;";
    if(mysqli_query($c, $select)){
        $resultado = "ok";
    }else{
        $resultado = mysqli_error($c);
    }
    desconectar($c);
    return $resultado;
}

//Desarrollado: Isain Alvaro
//Funcion que valida si el voto del concierto ya esta registrado
function verificarVotoConcierto($id_usuario,$id_concierto){
    $c = conectar();
    $select = "select * from votoconcierto where fan = $id_usuario and concierto = $id_concierto;";
    $resultado = mysqli_query($c, $select);
    if($fila = mysqli_fetch_assoc($resultado)){
        extract($fila);
        $resultado = true;
    }else{
        $resultado = false;
    }
    desconectar($c);
    return $resultado;
}

//Desarrollador: Isain Alvaro
//Obtiene el identificador de un concierto
function dimeidconcierto($nomconcierto) {
    //Conectar base de datos
    $c = conectar();
    //Consulta sql
    $select = "select id_concierto from concierto where nombre='$nomconcierto';";
    $resultado = mysqli_query($c, $select);
    desconectar($c);
    if ($fila = mysqli_fetch_assoc($resultado)) {
        //Devuelve el id de usuario
        $id_concierto = $fila['id_concierto'];
        return $id_concierto;
    } else {
        //Si el usuario no existe devuelve -1
        return -1;
    }
}
//Desarrollado: Isain Alvaro
//Funcion que da de alta un voto en concierto
function altaVotoConcierto($id_usuario,$id_concierto){
    $c = conectar();
    $select = "insert into votoconcierto values($id_usuario,$id_concierto);";
    if(mysqli_query($c, $select)){
        $resultado = "ok";
    }else{
        $resultado = mysqli_error($c);
    }
    desconectar($c);
    return $resultado;
}


//Desarrollado: Isain Alvaro
//Total votos por musico
function totalVotosPorMusico(){
    $c = conectar();
    $select = "select musico, count(musico) as totalvotos from votomusico group by musico order by count(musico) desc limit 10;";
    $resultado = mysqli_query($c, $select);
    desconectar($c);
    return $resultado;
}

//Desarrollador: Isain Alvaro
function listaMusicosMasVotados($musico){
    $c = conectar();
    $select = "select m.nombreart, g.nombre from musico m inner join genero g on m.genero = g.id_genero where id_usuario = $musico;";
    $resultado = mysqli_query($c, $select);
    desconectar($c);
    return $resultado;
}


//Desarrollado: Isain Alvaro
//Funcion que borra el voto en caso de que este
function eliminarVotoMusico($id_usuario,$id_musico){
    $c = conectar();
    $select = "delete from votomusico where fan = $id_usuario and musico = $id_musico;";
    if(mysqli_query($c, $select)){
        $resultado = "ok";
    }else{
        $resultado = mysqli_error($c);
    }
    desconectar($c);
    return $resultado;
}


//Desarrollado: Isain Alvaro
//Funcion que valida si el voto ya esta registrado
function verificarVotoMusico($id_usuario,$id_musico){
    $c = conectar();
    $select = "select * from votomusico where fan = $id_usuario and musico = $id_musico;";
    $resultado = mysqli_query($c, $select);
    if($fila = mysqli_fetch_assoc($resultado)){
        extract($fila);
        $resultado = true;
    }else{
        $resultado = false;
    }
    desconectar($c);
    return $resultado;
}



//Desarrollado: Isain Alvaro
//Funcion que da de alta un voto
function altaVotoMusico($id_usuario,$id_musico){
    $c = conectar();
    $select = "insert into votomusico values($id_usuario,$id_musico);";
    if(mysqli_query($c, $select)){
        $resultado = "ok";
    }else{
        $resultado = mysqli_error($c);
    }
    desconectar($c);
    return $resultado;
}

//Desarrollador: Artur
//Dice la provincia de una ciudad
function dimeprovinciadeciudad($ciudad)
{
     $c = conectar();
    $select = "SELECT provincia from ciudad where id_ciudad=$ciudad;";
    $resultado = mysqli_query($c, $select);
    $fila=mysqli_fetch_assoc($resultado);
    extract($fila);
    desconectar($c);
    return utf8_encode($provincia);
}
    

//Desarrollador: Artur
//Lee la lista de provincias
function dimeprovincias()
{
    $c = conectar();
    $select = "SELECT distinct(provincia) from ciudad;";
    $resultado = mysqli_query($c, $select);
   
    desconectar($c);
    return $resultado;
}

//Desarrollador: Artur
//Cancela conciertos antiguos
function cancelaconciertosantiguos()
{
    $c = conectar();
    $update = "update concierto set estado=2 where estado=0 and fecha<DATE_ADD(NOW(),INTERVAL -1 DAY);";
    if (mysqli_query($c, $update)) {
        return "ok";
    } else {
        $resultado = mysqli_error($c);
    }
    desconectar($c);
    return $resultado;
}

//Desarrollador: Alvaro -- Isain
// Autocompletado buscador
function autoCompletado() {
    $c = conectar();
    $output = '';
    $query = "SELECT * FROM login WHERE usuario LIKE '%" . $_POST["query"] . "%'";
    $result = mysqli_query($c, $query);
    $output = "<ul id='autobuscador'class='list-unstyled'>";
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_array($result)) {
            $output .= "<li class='autobuscar'>" . $row['usuario'] . "</li>";
        }
    } else {
        $output .= '<li class="autobuscar">Busqueda sin éxito</li>';
    }
    $output .= '</ul>';
    echo $output;
    desconectar($c);
}

//Desarrollador: Alvaro -- Isain
// Funcion que da todos los conciertos de una ciudad en especial
function dimeCociertosPorCiudad($ciudad) {
    $c = conectar();
    $select = "select c.id_concierto, c.nombre, c.fecha, c.hora, l.ciudad, l.usuario from concierto c inner join login l on c.localm = l.id_usuario where l.ciudad = $ciudad and c.fecha>now(); ";
    $resultado = mysqli_query($c, $select);
    desconectar($c);
    return $resultado;
}

//Desarrollador: Alvaro -- Isain
//Lista Conciertos, buscados por id.
function dimeConciertosporid($id_concierto) {
    $c = conectar();
    $select = "select estado, nombre, fecha, hora from concierto where id_concierto = $id_concierto;";
    $resultado = mysqli_query($c, $select);
    desconectar($c);
    return $resultado;
}

//Desarrollador: Alvaro -- Isain
//Funcion que dice que si el concierto esta aceptado o no.
function dimeConciertosAceptados($id_usuario) {
    $c = conectar();
    // Select con errores preguntar a mar!!
//    $select = "select c.nombre, c.fecha, c.hora, p.estado, c.musico from peticion p left outer join concierto c on p.estado = c.estado where p.musico = $id_usuario and c.musico is not null;";
    $select = "select * from peticion p where musico = $id_usuario ;";
    $resultado = mysqli_query($c, $select);
    conectar($c);
    return $resultado;
}

//Desarrollador: Alvaro
//Funcion que dice que si el concierto esta aceptado o no.
function dimeConciertoAceptado($id_usuario, $id_concierto) {
    $c = conectar();
    $select = "select * from peticion where musico = $id_usuario and concierto = $id_concierto and estado = 1;";
    $resultado = mysqli_query($c, $select);
    if ($fila = mysqli_fetch_assoc($resultado)) {
        extract($fila);
        $resultado = $estado;
    } else {
        $resultado = 0;
    }
    desconectar($c);
    return $resultado;
}

//Desarrollador: Artur
//Dice cuantos conciertos aceptados hay, sirve para la paginación
function cuantosconciertosaceptados() {
    $c = conectar();
    $select = "select count(id_concierto) as cuantos from concierto c where estado=1 AND c.fecha>NOW();";
    $resultado = mysqli_query($c, $select);
    if ($dato = mysqli_fetch_assoc($resultado)) {
        return $dato['cuantos'];
    } else {
        return 0;
    }
}

//Desarrollador: Artur
//Quita músico de concierto
//No se altera la tabla de peticiones marcando los cancelados. Simplemente se ponen en 1 al ser aceptados una vez.
function quitamusicoconcierto($concierto) {
    $c = conectar();
    $update = "update concierto set estado=0,musico=null where id_concierto=$concierto;";
    if (mysqli_query($c, $update)) {
        return "ok";
    } else {
        $resultado = mysqli_error($c);
    }
    //Falta borrar la petición o cambiarla a denegada 

    desconectar($c);
    return $resultado;
}

//Desarrollador: Artur
//Cancela un concierto
function cancelaconcierto($concierto) {
    $c = conectar();
    $update = "update concierto set estado=2,musico=null where id_concierto=$concierto;";
    if (mysqli_query($c, $update)) {
        return "ok";
    } else {
        $resultado = mysqli_error($c);
    }
    desconectar($c);
    return $resultado;
}

//Desarrollador: Artur
//Obtiene el alias del músico por el id
function dimealiasmusico($musico) {
    $c = conectar();
    $select = "select nombreart from musico where id_usuario=$musico;";
    $resultado = mysqli_query($c, $select);
    if ($uno = mysqli_fetch_assoc($resultado)) {
        extract($uno);
        return $nombreart;
    } else {
        return "error";
    }
    desconectar($c);
    return $resultado;
}

//Desarrollador: Artur
//Confirma un concierto
function confirmaconcierto($concierto, $musico) {
    $c = conectar();
    $update = "update concierto set estado=1,musico=$musico where id_concierto=$concierto;";
    if (mysqli_query($c, $update)) {
        $update = "update peticion set estado=1 where musico=$musico and concierto=$concierto;";
        if (mysqli_query($c, $update)) {
            $resultado = "ok";
        } else {
            $resultado = mysqli_error($c);
        }
    } else {
        $resultado = mysqli_error($c);
    }
    desconectar($c);
    return $resultado;
}

//Desarrollador: Artur
//Inserta una proposición de músico para concierto
function insproposicion($concierto, $musico) {
    $c = conectar();
    $insert = "INSERT INTO peticion (musico,concierto,estado) VALUES($musico,$concierto,0);";
    if (mysqli_query($c, $insert)) {
        $resultado = "ok";
    } else {
        $resultado = mysqli_error($c);
    }
    desconectar($c);
    return $resultado;
}

//Desarrollador: Artur
//Devuelve la lista de músicos que han propuesto actuar en un concierto
function listamusicospropuestos($concierto) {
    $c = conectar();
    $select = "select peticion.musico as musico, login.nombre as nombre, musico.nombreart as nombreart, musico.apellidoa as apellidoa, musico.apellidob as apellidob from peticion inner join musico on peticion.musico = musico.id_usuario inner join login on musico.id_usuario = login.id_usuario where peticion.concierto=$concierto and peticion.estado=0;";
    $resultado = mysqli_query($c, $select);
    desconectar($c);
    return $resultado;
}

//Desarrollador: Artur
//Información de un concierto
function infoconcierto($concierto) {
    $c = conectar();
    //Sentencia SQL. No se leen todos los campos, solo los principales.
    $select = "select nombre,fecha,hora,genero,estado from concierto where id_concierto=$concierto;";
    $resultado = mysqli_query($c, $select);
    desconectar($c);
    return $resultado;
}

//Desarrollador: Artur
//Comprueba si un concierto es realmente de un local. Función de seguridad
function compruebaconciertoesdelocal($elocal, $concierto) {
    $c = conectar();
    $select = "select localm from concierto where id_concierto=$concierto";
    $resultado = mysqli_query($c, $select);
    $numero = mysqli_fetch_assoc($resultado);
    extract($numero);
    if ($localm = $elocal) {
        return"ok";
    } else {
        return"error";
    }
    desconectar($c);
}

//Desarrollador: Artur
//Ver cuantos músicos propuestos para concierto
function cuantosmusicospropuestos($concierto) {
    $c = conectar();
    $select = "select count(estado) as cuantos from peticion where concierto=$concierto and estado=0;";
    $resultado = mysqli_query($c, $select);
    $numero = mysqli_fetch_assoc($resultado);
    extract($numero);
    desconectar($c);
    return $cuantos;
}

//Desarrollador: Isain
//funcion que da de baja la peticion a un concierto
function bajaPeticionConcierto($id_usuario, $id_concierto) {
    $c = conectar();
    $delete = "delete from peticion where musico = $id_usuario and concierto = $id_concierto;";
    if (mysqli_query($c, $delete)) {
        $resultado = "ok";
    } else {
        $resultado = mysqli_errno($c);
    }
    desconectar($c);
    return $resultado;
}

//Desarrollador: Isain
//funcion que da el id_genero de un musico desde el id_usuario.
function dimeIdgeneroUsuario($id_usuario) {
    $c = conectar();
    $select = "select genero from musico where id_usuario = $id_usuario;";
    $resultado = mysqli_query($c, $select);
    if ($fila = mysqli_fetch_assoc($resultado)) {
        extract($fila);
        $resultado = $genero;
    }
    desconectar($c);
    return $resultado;
}

//Desarrollador: Isain
//Verifica si la peticion se ha realizado o no
function verificarPeticion($id_usuario, $id_concierto) {
    $c = conectar();
    $select = "select * from peticion where musico = $id_usuario and concierto = $id_concierto;";
    $resultado = mysqli_query($c, $select);
    if ($fila = mysqli_fetch_assoc($resultado)) {
        extract($fila);
        $resultado = $musico;
    } else {
        $resultado = -1;
    }
    desconectar($c);
    return $resultado;
}

//Desarrollador: Isain
//Insertar una petición de concierto
function insertarPeticionConcierto($id_usuario, $id_concierto) {
    $c = conectar();
    $insert = "insert into peticion values ($id_usuario,$id_concierto,0);";
    if (mysqli_query($c, $insert)) {
        $resultado = "ok";
    } else {
        $resultado = mysqli_error($c);
    }
    desconectar($c);
    return $resultado;
}

//Desarrollador: Isain
//Busqueda de conciertos por genero
function conciertosPorGenero($gender) {
    $c = conectar();
    $select = "select c.id_concierto, c.nombre as nomconcierto, c.fecha, c.hora, c.pago, l.nombre as nomlocal, g.nombre as nomgenero from concierto c inner join genero g on c.genero = g.id_genero inner join login l on l.id_usuario = c.localm where c.estado = 0 and c.genero = $gender order by fecha;";
    $resultado = mysqli_query($c, $select);
    desconectar($c);
    return $resultado;
}

//Desarrollador: Isain
//Muestra id_ciudad de cada local o musico.
function muestraDatosCiudadLocalMusico() {
    $c = conectar();
    $select = "select c.id_ciudad, c.nombre, l.id_usuario  from ciudad c inner join login l on c.id_ciudad = l.ciudad where l.tipo = 1;";
    $resultado = mysqli_query($c, $select);
    desconectar($c);
    return $resultado;
}

//Desarrollador: Isain
//Lista de conciertos ya filtrados, segun sea el genero del musico que haya hecho login
function listaConciertosporGenero($idgeneroMusico) {
    $c = conectar();
    $select = "select c.id_concierto,c.nombre as nomconcierto, c.fecha, c.hora, l.nombre from concierto c inner join localm lo on lo.id_usuario = c.localm inner join login l on lo.id_usuario = l.id_usuario where c.genero = $idgeneroMusico and c.estado <> 2 and c.fecha>now()";
    $resultado = mysqli_query($c, $select);
    desconectar($c);
    return $resultado;
}

//Desarrollador: Isain
//Lista de conciertos propuestos
function listaConciertosPropuestos() {
    $c = conectar();
    $select = "select c.nombre as nomconcierto, c.fecha from concierto c inner join genero g on c.genero = g.id_genero inner join login l on l.id_usuario = c.localm where c.estado = 0 and c.fecha>now() order by fecha;";
    $resultado = mysqli_query($c, $select);
    desconectar($c);
    return $resultado;
}

//Desarrollador: Isain
//Muestra todos los conciertos ya programados
function mostrarListaConciertosAceptados($inicio, $cuantos) {
    $c = conectar();
    $select = "select c.nombre as nomconcierto, c.fecha, c.hora, c.pago, l.nombre as nomlocal, g.nombre as nomgenero from concierto c inner join genero g on c.genero = g.id_genero inner join login l on l.id_usuario = c.localm where c.estado = 1 AND c.fecha>NOW() order by fecha limit $inicio,$cuantos;";
    $resultado = mysqli_query($c, $select);
    desconectar($c);
    return $resultado;
}

//Desarrollador: Isain
//Ver el nombre del genero desde el id.
function mirarGeneroId($genero) {
    $c = conectar();
    $select = "select nombre from genero where id_genero = '$genero';";
    $resultado = mysqli_query($c, $select);
    desconectar($c);
    if ($fila = mysqli_fetch_assoc($resultado)) {
        extract($fila);
        return utf8_encode($nombre);
    } else {
        return -1;
    }
}

//Desarrollador: Isain
//Mirar conciertos en local
function mirarConciertosLocal($nombre, $id_usuario) {
    $c = conectar();
    $select = "select musico.nombreart, concierto.fecha, concierto.pago, concierto.genero from musico inner join concierto on concierto.musico = musico.id_usuario  where concierto.localm like '$id_usuario';";
    $resultado = mysqli_query($c, $select);
    desconectar($c);
    if ($fila = mysqli_fetch_assoc($resultado)) {    
        return $fila;
    } else {
        return -1;
    }
}

//Desarrollador: Isain
//Mirar conciertos en local
function mirarConciertosLocal2($id_usuario) {
    $c = conectar();
    $select = "select * from concierto where localm = $id_usuario and estado = 1;";
    $resultado = mysqli_query($c, $select);
    desconectar($c);
    return $resultado;
}

//Desarrollador: Isain
//Buscador base de datos
function buscador($buscador) {
    $c = conectar();
    $select = "select id_usuario,nombre,email,tipo from login where nombre like '$buscador';";
    $resultado = mysqli_query($c, $select);
    desconectar($c);
    if ($fila = mysqli_fetch_assoc($resultado)) {
        return $fila;
    } else {
        return -1;
    }
}

//Desarrollador:Artur
//Baja de concierto
//En el caso de no ser 0 el estado no se borrará.
function bajaconcierto($idconcierto) {
    $c = conectar();
    $delete = "DELETE FROM concierto WHERE id_concierto=$idconcierto AND estado=0;";
    if (mysqli_query($c, $delete)) {
        return "ok";
    } else {
        return mysqli_error($c);
    }
    desconectar($c);
}

//Desarrollador: Artur
//Lista los conciertos que tiene un local
function listaconciertoslocal($localm) {
    $c = conectar();
    //Sentencia SQL. No se leen todos los campos, solo los principales.
    $select = "select id_concierto,nombre,fecha,hora,genero,estado,musico from concierto where localm='$localm' order by fecha desc;";
    $resultado = mysqli_query($c, $select);
    desconectar($c);
    return $resultado;
}

//Desarrollador: Artur
//Da de alta un concierto
//Hemos añadido el campo nombre a la tabla concierto
function anadeconcierto($nombre, $fecha, $hora, $pago, $localm, $genero) {
    $c = conectar();
    //Sentencia SQL. Al dar de alta el músico se pone en -1 porque no se ha seleccionado y el estado en 0.
    $insert = "INSERT INTO concierto (nombre,fecha,hora,pago,localm,genero,musico,estado) VALUES ('$nombre','$fecha','$hora',$pago,$localm,$genero, null,0);";
    if (mysqli_query($c, $insert)) {
        $resultado = "ok";
    } else {
        $resultado = mysqli_error($c);
    }
    desconectar($c);
    return $resultado;
}

//Desarrolador: Isain
//Muestra Datos de locales
function muestraDatosLocal2() {
    $c = conectar();
    $select = "select lm.id_usuario, l.nombre from localm lm inner join login l on lm.id_usuario = l.id_usuario;";
    $resultado = mysqli_query($c, $select);
    desconectar($c);
    return $resultado;
}

//Desarrolador: Isain
////Muestra Datos de los generos
function muestrageneros() {
    $c = conectar();
    $select = "select nombre,id_genero from genero;";
    $resultado = mysqli_query($c, $select);
    desconectar($c);
    return $resultado;
}

//Desarrollador: Álvaro
//Modifica los datos de un perfil fan
function modificarperfilfan($usuario, $nombre, $email, $telefono, $ciudad, $apellidoa, $apellidob, $direccion, $imagen) {
    //Conectamos con la base de datos
    $c = conectar();
    //Obtenemos el id del usuario
    $id_usuario = dimeidusuario($usuario);
    //Actualizamos los campos de la tabla login
    $update = "update login set nombre='$nombre', email='$email', telefono='$telefono', ciudad=$ciudad, imagen='$imagen' where id_usuario=$id_usuario;";
    if (mysqli_query($c, $update)) {
        //Actualizamos los campos de la tabla fan
        $update = "update fan set apellidoa='$apellidoa', apellidob='$apellidob', direccion='$direccion' where id_usuario='$id_usuario';";
        if (mysqli_query($c, $update)) {
            $resultado = "ok";
        } else {
            $resultado = mysqli_error($c);
        }
    } else {
        $resultado = mysqli_error($c);
    }
    desconectar($c);
    return $resultado;
}

//Desarrollador: Alvaro
function leerperfilfan($usuario) {
    //Conectamos con la base de datos
    $c = conectar();
    $select = "select login.tipo as tipo, login.nombre as nombre, login.email as email, login.telefono as telefono, login.ciudad as ciudad, fan.apellidoa as apellidoa, fan.apellidob as apellidob, fan.direccion as direccion from login inner join fan on login.id_usuario=fan.id_usuario where login.usuario='$usuario';";
    $resultado = mysqli_query($c, $select);
    desconectar($c);
    return $resultado;
}

//Desarrollador:Isain Alvaro
//Ordenar Musicos ordenados por genero musical
function ordenarMusicosPorGenero() {
    $c = conectar();
    $select = "select genero.nombre,musico.nombreart from musico inner join genero on musico.genero = genero.id_genero order by genero.id_genero desc;";
    $resultado = mysqli_query($c, $select);
    desconectar($c);
    return $resultado;
}

//Desarrollador:Isain
//Registrar un musico
function dimeidgenero($gender) {
    $c = conectar();
    $select = "select id_genero from genero where nombre='$gender'";
    $resultado = mysqli_query($c, $select);
    desconectar($c);
    if ($fila = mysqli_fetch_assoc($resultado)) {
        extract($fila);
        return $id_genero;
    } else {
        // sino no encuentra nada devuelve -1
        return -1;
    }
}

//Desarrollador:Isain
//Registrar un musico
function registrar_musico($usuario, $pass, $tipo, $nombre, $email, $telefono, $ciudad, $surname1, $surname2, $web, $nickname, $components, $gender,$imagen) {
    //llamamos a la funcion de registrar_login para obtener el idusuario
    $idusuario = registrar_login($usuario, $pass, $tipo, $nombre, $email, $telefono, $ciudad,$imagen);
    if ($idusuario != -1) {
        $c = conectar();
        $insert = "INSERT INTO `musico` (`id_usuario`, `apellidoa`, `apellidob`, `web`, `nombreart`, `componentes`, `destacado`,`genero`) VALUES ('$idusuario', '$surname1', '$surname2', '$web', '$nickname', '$components', '0','$gender')";
        if (mysqli_query($c, $insert)) {
            $resultado = "ok";
        } else {
            $resultado = mysqli_error($c);
            borralogin($usuario);
        }
        desconectar($c);
        return $resultado;
    } else {
        echo "<script>alert('Error al crear id')</script>";
        echo"Error añadiendo el musico";
        $resultado = -1;
    }
}

//Desarrollador:Isain
//Registrar un fan
function registrar_fan($usuario, $pass, $tipo, $nombre, $email, $telefono, $ciudad, $surname1, $surname2, $address, $imagen) {
    // con la funcionregistrar_login obtenemos el id de usuario, despues damos de alta el fan en su respectiva tabla.
    $idusuario = registrar_login($usuario, $pass, $tipo, $nombre, $email, $telefono, $ciudad,$imagen);
    if ($idusuario != -1) {
        $c = conectar();
        $addressok = mysqli_escape_string($c, $address);
        $insert = "insert into fan(id_usuario,apellidoa,apellidob,direccion) values ('$idusuario','$surname1','$surname2','$addressok')";
        if (mysqli_query($c, $insert)) {
            $resultado = "ok";
        } else {
            $resultado = mysqli_error($c);
            borralogin($usuario);
        }
        desconectar($c);
        return $resultado;
    } else {
        echo"Error añadiendo el fan";
        $resultado = -1;
    }
}

//Desarrollador:Artur
//Destacar o des-destacar un local
function destacalocal($usuario, $destacado) {
    //Conectar base de datos
    $c = conectar();
    if ($destacado) {
        $valor = "true";
    } else {
        $valor = "false";
    }
    //Sentencia sql
    $update = "update localm set destacado=$valor where usuario='$usuario';";
    if (mysqli_query($c, $update)) {
        $resultado = "ok";
    } else {
        $resultado = mysqli_error($c);
    }
    desconectar($c);
    return $resultado;
}

//Desarrollador:Artur
//Modifica el password de un usuario
//Se necesita el password antiguo por seguridad
function modificarpassword($usuario, $pass) {
    $c = conectar();
    $pasc = password_hash($pass, PASSWORD_DEFAULT);
    $update = "update login set pass='$pasc' where usuario='$usuario';";
    if (mysqli_query($c, $update)) {
        $resultado = "ok";
    } else {
        $resultado = mysqli_error($c);
    }
    desconectar($c);
    return $resultado;
}

//Desarrollado:Artur
//Obtiene la lista de locales ordenados por ciudad
function listalocalesordenadosporciudad() {
    $c = conectar();
    $select = "select login.nombre as nombre, ciudad.nombre as ciudad from login inner join ciudad on login.ciudad = ciudad.id_ciudad where login.tipo = 1 order by ciudad.nombre;";
    $resultado = mysqli_query($c, $select);
    desconectar($c);
    return $resultado;
}

//Desarrollador:Artur
//Obtiene el identificador de un usuario
function dimeidusuario($usuario) {
    //Conectar base de datos
    $c = conectar();
    //Consulta sql
    $select = "select id_usuario from login where usuario='$usuario';";
    $resultado = mysqli_query($c, $select);
    desconectar($c);
    if ($fila = mysqli_fetch_assoc($resultado)) {
        //Devuelve el id de usuario
        $id_usuario = $fila['id_usuario'];
        return $id_usuario;
    } else {
        //Si el usuario no existe devuelve -1
        return -1;
    }
}

function modificarperfilmusico($usuario, $nombre, $email, $telefono, $ciudad, $surname1, $surname2, $web, $nickname, $components, $gender, $imagen) {
    $c = conectar();
    $id_usuario = dimeidusuario($usuario);
    $update = "update login set nombre='$nombre', email='$email', telefono='$telefono',ciudad=$ciudad, imagen='$imagen' where id_usuario=$id_usuario;";
    if (mysqli_query($c, $update)) {
        $update = "update musico set apellidoa='$surname1', apellidob='$surname2', web='$web', nombreart='$nickname', componentes='$components', genero='$gender' where id_usuario='$id_usuario';";
        if (mysqli_query($c, $update)) {
            $resultado = "ok";
        } else {
            $resultado = mysqli_error($c);
        }
    } else {
        $resultado = mysqli_error($c);
    }
    desconectar($c);
    return $resultado;
}

//Desarrollador:Artur
//Modifica los datos de un perfil de local
function modificaperfillocal($usuario, $nombre, $email, $telefono, $ciudad, $ubicacion, $imagen, $aforo) {
    //Conectar base de datos
    $c = conectar();
    //Obtengo el id del usuario
    $id_usuario = dimeidusuario($usuario);
    //Actualizo los campos de la tabla login
    $update = "update login set nombre='$nombre', email='$email', telefono='$telefono',ciudad=$ciudad,imagen='$imagen' where id_usuario=$id_usuario;";
    if (mysqli_query($c, $update)) {
        //Actualizo los campos de la tabla localm
        $update = "update localm set ubicacion='$ubicacion', aforo = $aforo where id_usuario='$id_usuario';";
        if (mysqli_query($c, $update)) {
            $resultado = "ok";
        } else {
            $resultado = mysqli_error($c);
        }
    } else {
        $resultado = mysqli_error($c);
    }
    desconectar($c);
    return $resultado;
}

//Desarrollador:Isain
//Lee todos los datos del perfil de musico
function leerPerfilMusico($usuario) {
    $c = conectar();
    $select = "select login.tipo as tipo,login.nombre as nombre,login.email as email,login.telefono as telefono, login.ciudad as ciudad, musico.apellidoa as apellidoa, musico.apellidob as apellidob, musico.web as web, musico.nombreart as nombreart, musico.componentes as componentes, musico.genero as genero from login inner join musico on login.id_usuario=musico.id_usuario where login.usuario='$usuario';";
    $resultado = mysqli_query($c, $select);
    desconectar($c);
    return $resultado;
}

//Desarrollador:Artur
//Lee todos los datos del perfil de un local de la base de datos.
function leeperfillocal($usuario) {
    //Conectar con la base de datos
    $c = conectar();
    //Consulta sql con dos inner join evita código.
    $select = "select login.tipo as tipo,login.nombre as nombre,login.email as email,login.telefono as telefono, login.ciudad as ciudad, localm.ubicacion as ubicacion, localm.aforo as aforo, localm.destacado as destacado from login inner join localm on login.id_usuario=localm.id_usuario where login.usuario='$usuario';";
    $resultado = mysqli_query($c, $select);
    desconectar($c);
    //Se devuelve el resultado de la consulta.
    return $resultado;
}

//Desarrollador:Artur
//Elimina un usuario de la tabla principal login
function borralogin($usuario) {
    $c = conectar();
    $delete = "DELETE FROM login WHERE usuario='$usuario';";
    desconectar($c);
    if (mysqli_query($c, $delete)) {
        return "ok";
    } else {
        return mysqli_error($c);
    }
}

//Desarrollador:Artur
//Devuelve el nombre de un usuario
function dimenombre($usuario) {
    //Conectar con la base de datos
    $c = conectar();
    $select = "select nombre from login where usuario='$usuario';";
    $resultado = mysqli_query($c, $select);
    desconectar($c);
    //Si existe el usuario entra en el if
    if ($fila = mysqli_fetch_assoc($resultado)) {
        extract($fila);
        //La función devuelve el nombre del usuario.
        return $nombre;
    } else {
        //Si no existe el usuario devuelve -1. Este caso no debería cumplirse.
        return -1;
    }
}

//Desarrollador: Artur
//Devuelve el tipo de un usuario
function dimetipousuario($usuario) {
    //Conexión base de datos
    $c = conectar();
    //Consulta sql
    $select = "select tipo from login where usuario='$usuario';";
    $resultado = mysqli_query($c, $select);
    //Enrtra en el if si existe el usuario
    desconectar($c);
    if ($fila = mysqli_fetch_assoc($resultado)) {
        extract($fila);
        //Devuelve el tipo del usuario
        return $tipo;
    } else {
        //Devuelve -1 si no existe
        return -1;
    }
}

//Desarrollador: Artur
//Comprueba si el usuario y password son correctos
function compruebainicio($usuario, $pass) {
    //Conectar base de datos
    $c = conectar();
    //Consulta sql cuantos usuarios hay con ese usuario y password.

    $select = "select pass as pasc from login where usuario='$usuario';";
    $resultado = mysqli_query($c, $select);
    if ($fila = mysqli_fetch_assoc($resultado)) {
        extract($fila);
        if (password_verify($pass, $pasc)) {
            return 1;
        } else {
            return -1;
        }
    } else {
        return -1;
    }
    //Devuelve el número de usuarios con ese usuario y password que pueden ser 0 o 1.
    extract($fila);
    desconectar($c);
    return $cuantos;
}

//Desarrollador: Artur
//Detecta si un usuario existe en la base de datos
function usuarioexiste($usuario) {
    //Conectar base de datos
    $c = conectar();
    //Consulta sql cuantos usuarios hay con es nombre de usuario.
    $select = "select count(id_usuario) as cuantos from login where usuario='$usuario';";
    $resultado = mysqli_query($c, $select);
    $fila = mysqli_fetch_assoc($resultado);
    //Devuelve 0 si el usuario no existe o 1 si existe. No pueden haber más de 1.
    extract($fila);
    desconectar($c);
    return $cuantos;
}

//Desarrollador: Artur
//Devuelve la lista de ciudades de una provincia en concreto.
function leeciudades($provincia) {
    //Conectar base de datos.
    $c = conectar();
    //Consulta sql ciudades de provincia concreta
    $select = "select id_ciudad,nombre from ciudad where provincia='$provincia';";
    $resultado = mysqli_query($c, $select);
    desconectar($c);
    return $resultado;
}

//Desarrollador: Artur
//Devuelve el ID de una ciudad especificando el nombre.
function dimeidciudad($ciudad) {
    //Conectar base de datos
    $c = conectar();
    //Consulta sql
    $select = "select id_ciudad from ciudad where nombre='$ciudad';";
    $resultado = mysqli_query($c, $select);
    //Entra en el if si se encuentra la ciudad
    desconectar($c);
    if ($fila = mysqli_fetch_assoc($resultado)) {
        extract($fila);
        return $id_ciudad;
        //Devuelve id ciudad
    } else {
        //Si no se encuentra la ciudad devuelve -1
        return -1;
    }
}

//Desarrollador: Artur
//Da de alta un local en la base de datos con todos sus campos.
function registrar_local($usuario, $pass, $nombre, $email, $telefono, $ciudad, $ubicacion, $imagen, $aforo) {
    //Se da de alta el usuario en la tabla principal de login
    //El método registrar_login devuelve el identificador del alta.
    $tipo = 1;
    $idusuario = registrar_login($usuario, $pass, $tipo, $nombre, $email, $telefono, $ciudad, $imagen);
    if ($idusuario != -1) {
        //Conectar base de datos
        $c = conectar();
        //Insert para añadir los datos específicos de local en la tabla localm
        $insert = "insert into localm (id_usuario,ubicacion,aforo,destacado) values ($idusuario,'$ubicacion',$aforo,0);";
        if (mysqli_query($c, $insert)) {
            //Si todo ha ido bien se devuelve ok
            $resultado = "ok";
        } else {
            //Caso de error insertando el local
            $resultado = mysqli_error($c);
            //Por seguridad borro el registro principal ya que no se ha podido añadir el relacionado.
            borralogin($usuario);
        }
        desconectar($c);
    } else {
        //Caso en que ha habido un problema añadiendo el usuario.
        echo"Error añadiendo login.<br>";
        $resultado = -1;
    }
    return $resultado;
}

//Desarrollador: Artur
//Función que da de alta un usuario, sirve tanto para local, como para músico y fan.
//Se añaden los campos comunes.
function registrar_login($usuario, $pass, $tipo, $nombre, $email, $telefono, $ciudad,$imagen) {
    //Conectar base de datos
    $c = conectar();
    //Insert sql registro tabla login
    $pasc = password_hash("$pass", PASSWORD_DEFAULT);
    $insert = "insert into login (usuario,pass,tipo,nombre,email,telefono,ciudad,imagen) values ('$usuario','$pasc',$tipo,'$nombre','$email','$telefono','$ciudad','$imagen');";
    if (mysqli_query($c, $insert)) {
        //Si el insert ha ido bien se devuelve el id autonumérico generado en el alta.
        $resultado = mysqli_insert_id($c);
    } else {
        //Caso de error en el alta  
        echo"Error añadiendo login.";
        $resultado = -1;
    }
    desconectar($c);
    return $resultado;
}

//Desarrollador: Artur
// Función que conecta a la base de datos 
function conectar() {
    include('mysqlpass.php');
    $conexion = mysqli_connect("localhost", $userbd, $passbd, "musica");
    // Si no ha ido bien la conexión
    if (!$conexion) {
        die("No se ha podido establecer la conexión");
    }
    return $conexion;
}

//Desarrollador: Artur
// Función que cierra una conexión con la base de datos
function desconectar($conexion) {
    mysqli_close($conexion);
}

//Funcion para ver cuantos mensaje estan pendientes por leer.
function mensajeSinLeer($username){
    $c = conectar();
    $select = "select count(*) as sinleer from message where message.read = 0 and receiver like '$username';";
    $resultado = mysqli_query($c, $select);
    if($fila = mysqli_fetch_assoc($resultado)){
        extract($fila);
        $resultado = $sinleer;
    }else{
        $resultado = mysqli_error($c);
    }
    desconectar($c);
    return $resultado;
    
}

//Funcion que muestra los mensajes enviados del usuario logeado.
function selectMessageSender($username){
    $c = conectar();
    $select = "select idmessage,sender,receiver,date,message.read,subject from message where sender='$username' order by date desc;";
    $resultado = mysqli_query($c, $select);
    desconectar($c);
    return $resultado;
}
//Function que cambia el estado del mensaje:
function cambiarEstadomensaje($estadomensaje,$idmessage){
    $c = conectar();
    $update = "update message set message.read=$estadomensaje where idmessage=$idmessage;";
    if(mysqli_query($c, $update)){
        $resultado = "ok";
    }else{
        $resultado = mysqli_error($c);
    }
    desconectar($c);
    return $resultado;
}

//Funcion que muestra el mensaje segun usuario;
function Mensaje($idmessage){
    $c = conectar();
    $select = "select body from message where idmessage=$idmessage;";
    $resultado = mysqli_query($c, $select);
    $fila = mysqli_fetch_assoc($resultado);
    desconectar($c);
    return $fila['body'];
}

//Funcion que muestra los mensajes recibidos del usuario logeado.
function selectMessage($username){
    $c = conectar();
    $select = "select idmessage,sender,date,message.read,subject from message where receiver='$username' order by date desc;";
    $resultado = mysqli_query($c, $select);
    desconectar($c);
    return $resultado;
}

//Funcion para dar de alta un evento
function alta_evento($username,$tipoevento){
    $c = conectar();
    $insert = "insert into event (user, date, type) values('$username',now(),'$tipoevento')";
    if(mysqli_query($c, $insert)){
        $resultado = "ok";
    }else{
        $resultado = mysqli_error($c);
    }
    desconectar($c);
    return $resultado;
    
} 

//Funcion que inserta el envio de mensaje en la base de datos
function insertarMensaje($username,$remitente,$asunto,$texto){
    $c = conectar();
    $insert = "insert into message (sender,receiver,date,message.read,subject,body) values ('$username','$remitente',now(),0,'$asunto','$texto')";
    if(mysqli_query($c, $insert)){
        $resultado = "ok";
    }else{
        $resultado = mysqli_error($c);
    }
    desconectar($c);
    return $resultado;
    
}

//Funcion que muestra todos los usuarios de la base de datos
function selectNameuser(){
    $c = conectar();
    $select = "select usuario as username from login";
    $resultado = mysqli_query($c, $select);
    desconectar($c);
    return $resultado;
}


?>
