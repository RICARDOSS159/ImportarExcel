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
    $consulta = "SELECT C.ruc, C.nombre, C.celular,P.idpago,DATE_FORMAT(P.fecha, '%d/%m/%Y') AS fecha_form_pago, P.monto,P.ruta_capturas,
                 P.metodo_pago,P.tipo_pago,P.mes_correspon,P.boleta_generada 
                 FROM cliente AS C
                 INNER JOIN pagos AS P ON C.id = P.idcliente
                 WHERE C.ruc = '$rucCliente' ORDER BY fecha ASC";

    $resultado = mysqli_query($mysqli, $consulta);

    // Verificar si se obtuvieron resultados
    if(mysqli_num_rows($resultado) > 0) {
        // Construir la tabla HTML con los datos del cliente y sus pagos
        $tabla = '<table class="table">';
        $tabla .= '<thead><tr><th>Fecha</th><th>Monto</th><th>Foto</th><th>Metodo de pago</th><th>Tipo de pago</th><th>Mes Pagado</th>
        <th>Comprobante</th><th>Ver comprobante</th><th>Actualizar</th></tr></thead>';
        $tabla .= '<tbody>';

        while($fila = mysqli_fetch_assoc($resultado)) {
            $tabla .= '<tr>';
            $tabla .= '<td>' . $fila['fecha_form_pago'] . '</td>';
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
            $tabla .= '<td>'.$fila['mes_correspon'].'</td>';
            $tabla .= '<td><form action="fpdf/boletas_clientes.php" method="post" target="_blank">
            <input type="hidden" name="idpago" value="'.$fila['idpago'].'">
            <button type="submit" class="btn btn-primary">Generar recibo</button>
            </form></td>';
            if ($fila['boleta_generada']==1) {
                $tabla .= '<td><form action="fpdf/ver_boletas_clientes.php" method="post" target="_blank">
                     <input type="hidden" name="idpago" value="'.$fila['idpago'].'">
                     <button type="submit" class="btn btn-primary">Ver boleta</button>
                     </form></td>';
            } else {
                $tabla .= '<td></td>'; // Celda vacía si no se ha generado la boleta
            }
            $tabla .= '<td><form action="actualizar_pagos.php" method="post">
            <input type="hidden" name="idpago" value="'.$fila['idpago'].'">
            <button type="submit" class="btn btn-success">Actualizar</button>
            </form></td>';
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