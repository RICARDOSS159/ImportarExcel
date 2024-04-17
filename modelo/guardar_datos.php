<?php

$carpeta_destino = "../imagenes_subidas/";

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



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar si se ha seleccionado una imagen
    if (isset($_FILES["imagen"]) && $_FILES["imagen"]["error"] == 0) {
        $nombre = $_FILES["imagen"]["name"];
        $tipo = $_FILES["imagen"]["type"];
        $tamanio = $_FILES["imagen"]["size"];
        $ruta_temporal = $_FILES["imagen"]["tmp_name"];

        // Generar un nombre único para la imagen
        $nombre_unico = uniqid() . "_" . $nombre;

        // Mover la imagen a la carpeta de destino
        $ruta_destino = $carpeta_destino . $nombre_unico;
        move_uploaded_file($ruta_temporal, $ruta_destino);

        // Datos adicionales
        $userId=$_POST['cliente'];
        $monto = $_POST["monto"];
        $fecha=$_POST["fecha"];
        $met_pago=$_POST["met_pago"];
        $tip_pago=$_POST["tip_pago"];
        $mes_pago=$_POST["mes_pago"];


        // Guardar la ruta en la base de datos
        $consulta = $mysqli->prepare("INSERT INTO pagos (idcliente,fecha,monto, ruta_capturas,metodo_pago,tipo_pago,mes_correspon) 
        VALUES (?, ?, ?, ?, ?, ?, ?)");
        $consulta->bind_param("isdssss", $userId,$fecha,$monto, $ruta_destino,$met_pago,$tip_pago,$mes_pago);

        // Ejecutar la consulta
        if ($consulta->execute()) {
            
            header("Location:../vista/clientes.php");
        } else {
            echo "Error al subir la imagen: " . $consulta->error;
        }

        // Cerrar la consulta
        $consulta->close();
    } else {
        echo "Selecciona una imagen válida o rellene todo los campos.";
    }
}

// Cerrar la conexión a la base de datos
$mysqli->close();

?>