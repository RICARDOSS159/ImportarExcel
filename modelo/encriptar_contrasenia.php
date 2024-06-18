<?php
require('conexion.php');

$consulta_datos=$mysqli->query("SELECT id_usuario,contrasenia from usuario");

while ($row = $consulta_datos->fetch_assoc()) {
    $id = $row['id_usuario'];
    $password = $row['contrasenia'];

    // Encripta la contraseña
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Actualiza la contraseña encriptada en la base de datos
    $stmt = $mysqli->prepare("UPDATE usuario SET contrasenia = ? WHERE id_usuario = ?");
    $stmt->bind_param("si", $hashed_password, $id);
    $stmt->execute();
    $stmt->close();

   

    echo "Todas las contraseñas han sido encriptadas.";
}




?>