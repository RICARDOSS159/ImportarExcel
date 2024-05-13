<?php

$servidor='localhost';
$user='root';
$contrasenia='';
$database='sistema_pagos';

$mysqli= mysqli_connect($servidor,$user,$contrasenia,$database) or die(mysqli_connect_error());

// Obtener el ID del usuario seleccionado desde la solicitud POST
$userId = isset($_POST['id']) && is_numeric($_POST['id']) ? $_POST['id'] : null;

// Consulta SQL para obtener los datos del usuario
$recibirdatos = "SELECT nombre,celular,direccion FROM cliente WHERE id = '$userId'";
$resultadoRecibido = $mysqli->query($recibirdatos);



// Verificar si se obtuvieron resultados
if ($resultadoRecibido->num_rows > 0) {
    $row = $resultadoRecibido->fetch_assoc();

    // Crear un array con los datos del usuario
    $DatosUsuario = array(
        'nombre' => $row['nombre'],
        'celular' => $row['celular'],
        'direccion'=>$row['direccion']
    );

    // Devolver los datos en formato JSON
    echo json_encode($DatosUsuario);
} else {
    // Enviar respuesta vacía si no se encontraron datos
    //echo json_encode(array());
}

?>