<?php

$carpeta_destino = "../imagenes_subidas/";

$servidor='localhost';
$user='root';
$contrasenia='';
$database='sistema_pagos';

$mysqli= mysqli_connect($servidor,$user,$contrasenia,$database) or die(mysqli_connect_error());

$ruc=$_POST['Ruc'];
$nombre=$_POST['Empresa'];
$celular=$_POST['Celular'];
$direccion=$_POST['Direccion'];
$fecha_ingre=$_POST['fecha_ingreso'];
$fecha_acti=$_POST['fecha_activacion'];

 // Guardar la ruta en la base de datos
 
 $consulta = $mysqli->prepare("INSERT INTO cliente (ruc,nombre,celular,direccion,fecha_ingreso,fecha_activacion,estado_cliente) 
 VALUES (?, ?, ?, ?, ?,?,'Activo')");
 $consulta->bind_param("ssdsss", $ruc,$nombre,$celular, $direccion,$fecha_ingre,$fecha_acti);

 // Ejecutar la consulta
 if ($consulta->execute()) {
            
    header("Location:../vista/lista_clientes.php");
} else {
    echo "Error al subir la imagen: " . $consulta->error;
}

 // Redirige al usuario a la página de lista de clientes
 //pARA VERIFICAR QUE FECHA SE GUARDA AGREGAR DESPUES DE .PHP ?mensaje=Fecha guardada: $fecha_ingre y Fecha Acti: $fecha_acti
 header("Location: ../vista/lista_clientes.php");
 exit; // Importante: asegúrate de terminar la ejecución del script después de la redirección


// Cerrar la consulta
$consulta->close();


?>