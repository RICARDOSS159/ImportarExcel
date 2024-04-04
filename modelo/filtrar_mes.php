<?php
$servidor='localhost';
$user='root';
$contrasenia='';
$database='sistema_pagos';

$mysqli= mysqli_connect($servidor,$user,$contrasenia,$database) or die(mysqli_connect_error());


if(isset($_POST['from_date']) && isset($_POST['to_date']))
{
    $from_date = $_POST['from_date'];
    $to_date = $_POST['to_date'];

    $query = "SELECT C.id, C.ruc, C.nombre, C.celular, P.idpago, P.fecha, P.monto, P.ruta_capturas 
    FROM cliente as C 
    INNER JOIN pagos as P on C.id = P.idcliente WHERE P.fecha BETWEEN '$from_date' AND '$to_date'
    GROUP BY C.ruc ";
  

}else
{
    // Consulta sin filtrar por fecha
    $query = "SELECT C.id, C.ruc, C.nombre, C.celular, P.idpago, P.fecha, P.monto, P.ruta_capturas 
              FROM cliente as C 
              INNER JOIN pagos as P on C.id = P.idcliente GROUP BY C.ruc";

}

// Verificar si se ha seleccionado un mes desde el formulario
/*if(isset($_POST['mes']) && !empty($_POST['mes'])) {
    $mes = $_POST['mes'];
    // Consulta filtrada por mes
    $query = "SELECT C.id, C.ruc, C.nombre, C.celular, P.idpago, P.fecha, P.monto, P.ruta_capturas 
              FROM cliente AS C 
              INNER JOIN pagos AS P ON C.id = P.idcliente 
              WHERE MONTH(P.fecha) = $mes 
              GROUP BY C.ruc";
}*/

if(isset($_POST['nombre'])&& !empty($_POST['nombre'])){
    $nombre=$_POST['nombre'];
    //Consulta para filtrar por nombre
    $query="SELECT C.id, C.ruc, C.nombre, C.celular, P.idpago, P.fecha, P.monto, P.ruta_capturas 
    FROM cliente AS C 
    INNER JOIN pagos AS P ON C.id = P.idcliente 
    WHERE nombre like '%$nombre%'
    GROUP BY C.ruc";

}

$query_run = mysqli_query($mysqli, $query);
    $total_client = mysqli_num_rows($query_run);
?>