<?php
$servidor='localhost';
$user='root';
$contrasenia='';
$database='sistema_pagos';

$mysqli= mysqli_connect($servidor,$user,$contrasenia,$database) or die(mysqli_connect_error());



/*if(isset($_POST['from_date']) && isset($_POST['to_date']))
{
    $from_date = $_POST['from_date'];
    $to_date = $_POST['to_date'];

    $query = "SELECT C.id, C.ruc, C.nombre, C.celular, P.idpago, P.fecha, P.monto, P.ruta_capturas 
    FROM cliente as C 
    INNER JOIN pagos as P on C.id = P.idcliente WHERE P.fecha BETWEEN '$from_date' AND '$to_date'
    ";
}else{
    // Consulta sin filtrar por fecha
    $query = "SELECT C.id, C.ruc, C.nombre, C.celular, P.idpago, P.fecha, P.monto, P.ruta_capturas 
              FROM cliente as C 
              INNER JOIN pagos as P on C.id = P.idcliente GROUP BY C.ruc";

}*/

 // Si no se proporcionó un nombre, pero sí un rango de fechas
 if (isset($_POST['from_date']) && isset($_POST['to_date'])) {
    $from_date = $_POST['from_date'];
    $to_date = $_POST['to_date'];
    
    // Consulta solo para filtrar por el rango de fechas
    $query = "SELECT C.id, C.ruc, C.nombre, C.celular, P.idpago, P.fecha, P.monto, P.ruta_capturas,
              P.metodo_pago,P.tipo_pago,P.mes_correspon 
              FROM cliente AS C 
              INNER JOIN pagos AS P ON C.id = P.idcliente 
              WHERE P.fecha BETWEEN '$from_date' AND '$to_date' order by P.fecha ";
}else{
    // Si no se proporcionó ni un nombre ni un rango de fechas, mostrar todos los datos
    $query = "SELECT C.id, C.ruc, C.nombre, C.celular, P.idpago, P.fecha, P.monto, P.ruta_capturas,
              P.metodo_pago 
              FROM cliente AS C 
              INNER JOIN pagos AS P ON C.id = P.idcliente group by c.ruc order by C.nombre";
}




// Verificar si se ha seleccionado un mes desde el formulario
/*if(isset($_POST['mes']) && !empty($_POST['mes'])) {
    $mes = $_POST['mes'];
    // Consulta filtrada por mes
    $query = "SELECT C.id, C.ruc, C.nombre, C.celular, P.idpago, P.fecha, P.monto, P.ruta_capturas,
              P.metodo_pago     
              FROM cliente AS C 
              INNER JOIN pagos AS P ON C.id = P.idcliente 
              WHERE MONTH(P.fecha) = $mes 
              GROUP BY C.ruc";
                
    
}*/

// Verificar si se ha seleccionado un mes desde el formulario
if(isset($_POST['mes']) && !empty($_POST['mes'])&& isset($_POST['anio']) && !empty($_POST['anio'])) {
    $mes = $_POST['mes'];
    $anio = $_POST['anio'];
    // Consulta filtrada por mes
    $query = "SELECT C.id, C.ruc, C.nombre, C.celular, P.idpago, P.fecha, P.monto, P.ruta_capturas,
              P.metodo_pago,P.tipo_pago,P.mes_correspon     
              FROM cliente AS C 
              INNER JOIN pagos AS P ON C.id = P.idcliente 
              WHERE MONTH(P.fecha) = $mes AND YEAR(P.fecha) =$anio
              ";
                
    
}elseif(isset($_POST['anio']) && !empty($_POST['anio'])){
    $anio = $_POST['anio'];
    $query = "SELECT C.id, C.ruc, C.nombre, C.celular, P.idpago, P.fecha, P.monto, P.ruta_capturas,
              P.metodo_pago,P.tipo_pago,P.mes_correspon     
              FROM cliente AS C 
              INNER JOIN pagos AS P ON C.id = P.idcliente 
              WHERE YEAR(P.fecha) =$anio order by C.nombre
              ";
}

if(isset($_POST['nombre']) && !empty($_POST['nombre']) && empty($_POST['from_date']) && empty($_POST['to_date']) && empty($_POST['anio'])) {
    $nombre = $_POST['nombre'];
    // Consulta para filtrar por nombre
    $query = "SELECT DISTINCT id, ruc, nombre, celular 
              FROM cliente 
              WHERE nombre LIKE '%$nombre%'";
 
}elseif(isset($_POST['nombre']) && !empty($_POST['nombre']) && isset($_POST['from_date']) && isset($_POST['to_date']) && empty($_POST['anio'])) {
    $nombre=$_POST['nombre'];
    $from_date = $_POST['from_date'];
    $to_date = $_POST['to_date'];
    //Consulta para filtrar por nombre
    $query="SELECT C.id, C.ruc, C.nombre, C.celular, P.idpago, P.fecha,P.metodo_pago,P.tipo_pago
    ,P.mes_correspon
    FROM cliente AS C 
    INNER JOIN pagos AS P ON C.id = P.idcliente 
    WHERE C.nombre = '$nombre' and P.fecha BETWEEN '$from_date' AND '$to_date'";
 
}elseif(isset($_POST['nombre']) && !empty($_POST['nombre']) && isset($_POST['anio'])){
    $nombre=$_POST['nombre'];
    $anio = $_POST['anio'];
    //Consulta para filtrar por nombre
    $query="SELECT C.id, C.ruc, C.nombre,P.monto, C.celular, P.idpago, P.fecha,P.metodo_pago,P.tipo_pago,
    P.mes_correspon
    FROM cliente AS C 
    INNER JOIN pagos AS P ON C.id = P.idcliente 
    WHERE C.nombre='$nombre' and YEAR(P.fecha)=$anio";
}



$query_run = mysqli_query($mysqli, $query);
$total_client = mysqli_num_rows($query_run);

    

?>