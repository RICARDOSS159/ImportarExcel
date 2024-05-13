<?php

$servidor='localhost';
$user='root';
$contrasenia='';
$database='sistema_pagos';

$mysqli= mysqli_connect($servidor,$user,$contrasenia,$database) or die(mysqli_connect_error());

// Llamar al procedimiento almacenado
$sql = "CALL ActualizarEstadoPago()"; // Reemplaza 'nombre_del_procedimiento' con el nombre de tu procedimiento almacenado
$resultado = $mysqli->query($sql);

// Verificar si la llamada al procedimiento fue exitosa
if ($resultado) {
    header("Location: ../vista/lista_clientes.php");
} else {
    echo "Error al llamar al procedimiento almacenado: " . $mysqli->error;
}

// Cerrar la conexión
$mysqli->close();

            
        
    

?>