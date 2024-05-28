<?php

$servidor='localhost';
$user='root';
$contrasenia='';
$database='sistema_pagos';

$mysqli= mysqli_connect($servidor,$user,$contrasenia,$database) or die(mysqli_connect_error());



// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener el ID del cliente a eliminar
    $cliente_id = $_POST['id'];

    // Consulta para eliminar el cliente

    //$sqlEliminar = "DELETE FROM pagos WHERE idcliente=$cliente_id;
                    //DELETE FROM cliente WHERE id = $cliente_id";

    $actualizar_cliente="UPDATE cliente set estado_cliente='Inactivo' WHERE id=$cliente_id";                

    // Ejecutar la consulta
    if (mysqli_multi_query($mysqli, $actualizar_cliente)) {
        header("Location:../vista/lista_clientes.php");
    } else {
        echo "Error al realizar la accion del cliente: " . mysqli_error($mysqli);
    }
}
?>