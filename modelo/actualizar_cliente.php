<?php
require('conexion.php');



$id=isset($_POST['id']) ? $_POST['id'] : '';
$ruc = isset($_POST['ruc']) ? $_POST['ruc'] : '';
$nombre = isset($_POST['nombre']) ? $_POST['nombre'] : '';
$celular = isset($_POST['celular']) ? $_POST['celular'] : '';
$direccion = isset($_POST['direccion']) ? $_POST['direccion'] : '';
$fecha_ingreso = isset($_POST['fecha_ingreso']) ? $_POST['fecha_ingreso'] : '';
$fecha_activacion = isset($_POST['fecha_activacion']) ? $_POST['fecha_activacion'] : '';
$estado_pago=isset($_POST['estado_pago']) ? $_POST['estado_pago'] : '';
$fecha_pendiente=isset($_POST['fecha_tiempo_pendiente']) ? $_POST['fecha_tiempo_pendiente'] : '';

$fecha_ingreso_formato = date("Y-m-d", strtotime($fecha_ingreso));
$fecha_activa_formato = date("Y-m-d", strtotime($fecha_activacion));

$sqlActualizar="UPDATE cliente set ruc='$ruc',nombre='$nombre',celular='$celular',direccion='$direccion',
fecha_ingreso='$fecha_ingreso_formato',fecha_activacion='$fecha_activa_formato',estado_pago='$estado_pago',
fecha_tiempo_pendiente='$fecha_pendiente'
WHERE id='$id'";
$queryActualizar=mysqli_query($mysqli,$sqlActualizar);





?>