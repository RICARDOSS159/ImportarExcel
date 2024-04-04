<?php

// Conexión a la base de datos
$servidor = 'localhost';
$user = 'root';
$contrasenia = '';
$database = 'sistema_pagos';

$mysqli = mysqli_connect($servidor, $user, $contrasenia, $database) or die(mysqli_connect_error());

// Verificar si se recibió el RUC del cliente
if(isset($_POST['ruc'])) {
    $rucCliente = $_POST['ruc'];

    // Consulta SQL para obtener los datos del cliente y sus pagos
    $consulta = "SELECT C.ruc, C.nombre, C.celular,P.idpago,P.fecha, P.monto,P.ruta_capturas,
                 P.metodo_pago,P.tipo_pago 
                 FROM cliente AS C
                 INNER JOIN pagos AS P ON C.id = P.idcliente
                 WHERE C.ruc = '$rucCliente' ORDER BY fecha ASC";

    $resultado = mysqli_query($mysqli, $consulta);

    // Verificar si se obtuvieron resultados
    if(mysqli_num_rows($resultado) > 0) {
        // Construir la tabla HTML con los datos del cliente y sus pagos
        $tabla = '<table class="table">';
        $tabla .= '<thead><tr><th>Fecha</th><th>Monto</th><th>Foto</th><th>Metodo de pago</th><th>Tipo de pago</th></tr></thead>';
        $tabla .= '<tbody>';

        while($fila = mysqli_fetch_assoc($resultado)) {
            $tabla .= '<tr>';
            $tabla .= '<td>' . $fila['fecha'] . '</td>';
            $tabla .= '<td>' . $fila['monto'] . '</td>';
            $tabla .= '<td><a href="#" data-toggle="modal" data-target="#imagenModal' . $fila['idpago'] . '"><img src="' . $fila['ruta_capturas'] . '" alt="" style="max-width: 100px;"></a></td>';
            // Modal para mostrar la imagen completa
            $tabla .= '<div class="modal fade" id="imagenModal' . $fila['idpago'] . '" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">';
            $tabla .= '<div class="modal-dialog" role="document">';
            $tabla .= '<div class="modal-content">';
            $tabla .= '<div class="modal-header">';
            $tabla .= '<h5 class="modal-title" id="exampleModalLabel">Imagen Completa</h5>';
            //$tabla .= '<button type="button" class="close cerrarImagenCompleta" data-dismiss="modal" aria-label="Close">';
            $tabla .= '<span aria-hidden="true">&times;</span>';
            $tabla .= '</button>';
            $tabla .= '</div>';
            $tabla .= '<div class="modal-body">';
            $tabla .= '<img src="' . $fila['ruta_capturas'] . '" alt="Imagen Completa" style="max-width: 100%;">';
            $tabla .= '</div>';
            $tabla .= '<div class="modal-footer">';
            //$tabla .= '<button type="button" class="btn btn-secondary cerrarImagenCompleta" data-dismiss="modal">Cerrar</button>';
            $tabla .= '</div>';
            $tabla .= '</div>';
            $tabla .= '</div>';
            $tabla .= '</div>';
            $tabla .= '<td>'.$fila['metodo_pago'].'</td>';
            $tabla .= '<td>'.$fila['tipo_pago'].'</td>';
            $tabla .= '</tr>';
        }

        $tabla .= '</tbody></table>';

        echo $tabla;
    } else {
        echo 'No se encontraron pagos para este cliente.';
    }
} else {
    echo 'Error: No se recibió el RUC del cliente.';
}

// Cerrar la conexión
mysqli_close($mysqli);

?>