<?php

$servidor='localhost';
$user='root';
$contrasenia='';
$database='sistema_pagos';

$mysqli= mysqli_connect($servidor,$user,$contrasenia,$database) or die(mysqli_connect_error());

/*if ($mysqli->connect_error) {
    die("Error de conexión: " . $mysqli->connect_error);
}else{
    echo('Conexion exitosa');
}*/
$sql = "SELECT id,ruc,nombre,celular FROM cliente";
$result = $mysqli->query($sql);

?>