<?php
require('conexion.php');


if ($_SERVER["REQUEST_METHOD"] == "POST") {
// Manejo de la subida de la imagen
$target_dir = "../imagenes_subidas/";
$target_file = $target_dir . basename($_FILES["imagenAct"]["name"]);
$imagen_subida = isset($_FILES["imagenAct"]) && $_FILES["imagenAct"]["error"] == UPLOAD_ERR_OK;
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

// Verificar si el archivo es una imagen real
/*$check = getimagesize($_FILES["imagen"]["tmp_name"]);
if ($check === false) {
    die("El archivo no es una imagen.");
}

// Verificar si el archivo ya existe
//if (file_exists($target_file)) {
//    die("Lo siento, el archivo ya existe.");
//}

// Limitar el tamaño del archivo (por ejemplo, 5MB)
if ($_FILES["imagen"]["size"] > 5000000) {
    die("Lo siento, tu archivo es demasiado grande.");
}*/


 // Si hay una imagen subida, realizar las verificaciones pertinentes
 if ($imagen_subida) {
    // Verificar si el archivo es una imagen real
    $check = getimagesize($_FILES["imagenAct"]["tmp_name"]);
    if ($check === false) {
        die("El archivo no es una imagen.");
    }

    // Limitar el tamaño del archivo (por ejemplo, 5MB)
    if ($_FILES["imagenAct"]["size"] > 5000000) {
        die("Lo siento, tu archivo es demasiado grande.");
    }
}

$id_pago=isset($_POST['idpagoAct']) ? $_POST['idpagoAct'] : '';
$monto = isset($_POST['montoAct']) ? $_POST['montoAct'] : '';
$fecha_pago = isset($_POST['fecha_pagoAct']) ? $_POST['fecha_pagoAct'] : '';
//$imagen = isset($_POST['imagen']) ? $_POST['imagen'] : '';
$metodo_pago=isset($_POST['met_pagoAct']) ? $_POST['met_pagoAct'] : '';
$tipo_pago=isset($_POST['tip_pagoAct']) ? $_POST['tip_pagoAct'] : '';
$mes_pago=isset($_POST['mes_pagoAct']) ? $_POST['mes_pagoAct'] : '';

$fecha_pago_formato = date("Y-m-d", strtotime($fecha_pago));

if ($imagen_subida) {
    // Intentar subir el archivo
    if (move_uploaded_file($_FILES["imagenAct"]["tmp_name"], $target_file)) {
        // Obtener la ruta de la imagen anterior para eliminarla
        $sql = "SELECT ruta_capturas FROM pagos WHERE idpago = ?";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("i", $id_pago);
        $stmt->execute();
        $stmt->bind_result($ruta_imagen_anterior);
        $stmt->fetch();
        $stmt->close();

        // Eliminar la imagen anterior del servidor
        if ($ruta_imagen_anterior && file_exists($ruta_imagen_anterior)) {
            unlink($ruta_imagen_anterior);
        }

        // Actualizar la base de datos con la nueva ruta de la imagen
        $sqlActualizar = "UPDATE pagos SET monto='$monto', fecha='$fecha_pago_formato', ruta_capturas='$target_file', metodo_pago='$metodo_pago', tipo_pago='$tipo_pago', mes_correspon='$mes_pago' WHERE idpago='$id_pago'";
    }
} else {
    // Actualizar la base de datos sin cambiar la ruta de la imagen
    $sqlActualizar = "UPDATE pagos SET monto='$monto', fecha='$fecha_pago_formato', metodo_pago='$metodo_pago', tipo_pago='$tipo_pago', mes_correspon='$mes_pago' WHERE idpago='$id_pago'";
}

// Ejecutar la consulta de actualización
$queryActualizar = mysqli_query($mysqli, $sqlActualizar);

if($queryActualizar){
    header("Location:../vista/lista_pagos.php");
}

}


?>