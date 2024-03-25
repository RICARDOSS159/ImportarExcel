<?php
$servidor='localhost';
$user='root';
$contrasenia='';
$database='sistema_pagos';

$mysqli= mysqli_connect($servidor,$user,$contrasenia,$database) or die(mysqli_connect_error());

// Lógica de filtrado por mes
/*if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["fecha"])) {
    $mesSeleccionado = $_POST["fecha"];
    // Realizar la consulta SQL filtrando por mes
    $sqlClientes = "SELECT C.id, C.ruc, C.nombre, C.celular, P.idpago, P.fecha, P.monto, P.ruta_capturas 
                    FROM cliente as C 
                    INNER JOIN pagos as P on C.id = P.idcliente 
                    WHERE MONTH(P.fecha) = $mesSeleccionado 
                    ORDER BY P.idpago ASC";
} else {
    // Consulta sin filtrar por mes
    $sqlClientes = "SELECT C.id, C.ruc, C.nombre, C.celular, P.idpago, P.fecha, P.monto, P.ruta_capturas 
                    FROM cliente as C 
                    INNER JOIN pagos as P on C.id = P.idcliente 
                    ORDER BY P.idpago ASC";
}

// Realizar la consulta SQL
$queryData = mysqli_query($mysqli, $sqlClientes);
$total_client = mysqli_num_rows($queryData);
*/

if(isset($_POST['from_date']) && isset($_POST['to_date']))
{
    $from_date = $_POST['from_date'];
    $to_date = $_POST['to_date'];

    $query = "SELECT C.id, C.ruc, C.nombre, C.celular, P.idpago, P.fecha, P.monto, P.ruta_capturas 
    FROM cliente as C 
    INNER JOIN pagos as P on C.id = P.idcliente WHERE P.fecha BETWEEN '$from_date' AND '$to_date' ";
    $query_run = mysqli_query($mysqli, $query);
    $total_client = mysqli_num_rows($query_run);

}else
{
    // Consulta sin filtrar por fecha
    $query = "SELECT C.id, C.ruc, C.nombre, C.celular, P.idpago, P.fecha, P.monto, P.ruta_capturas 
              FROM cliente as C 
              INNER JOIN pagos as P on C.id = P.idcliente";
    $query_run = mysqli_query($mysqli, $query);
    $total_client = mysqli_num_rows($query_run);
}


?>