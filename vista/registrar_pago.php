<?php
require '../modelo/conexion.php';

// Inicializar la variable para almacenar el mensaje de error
/*$error_message = "";*/
// Inicia la sesión (si no está iniciada)
session_start();

// Verifica si el usuario está autenticado o cumple con ciertos criterios
if (!isset($_SESSION['username'],$_SESSION['contrasenia']) || !$_SESSION['username'] || !$_SESSION['contrasenia']){
    // Si no está autenticado o no cumple con los criterios, redirige a la página de inicio de sesión o a otra página de acceso no autorizado
    header("Location: login.php");
    exit();
}
?>

<?php 
    

  if(isset($_POST["Atras"])){
    header("Location:clientes.php");
    exit();
  }
  ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/registrar_pago.css"> 
    <title>Registra el pago </title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
 
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <!--link Jquery-->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    

    <script>
        $(document).ready(function() {
            // Al cambiar el valor del select
            $('#cliente').change(function() {
                // Obtener el valor seleccionado
                var selectedUserId = $(this).val();

                // Realizar una petición AJAX para obtener los datos asociados al usuario
                $.ajax({
                    type: 'POST',
                    url: '../modelo/llamar_datos.php',
                    data: { id: selectedUserId }, // Enviar el ID del usuario seleccionado
                    dataType: 'json',
                    success: function(data) {
                        // Actualizar los campos con los datos recibidos
                        $('#nombre').val(data.nombre);
                        $('#celular').val(data.celular);
                        }
                });
            });
        });
    </script>

</head>

<body>
    <!--<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
    <button  class="btn btn-primary" name="Atras">VOLVER ATRÁS</button>
    </form>-->
  <form action="../modelo/guardar_datos.php" method="post" enctype="multipart/form-data">
    <div class="file-input text-center">
    <span>REGISTRA AQUI EL PAGO DE TUS CLIENTES</span>
    </div>
        <label>RUC:</label>
        <select name="cliente" id="cliente">
        <option value="default" selected>Selecciona un ruc</option>
        <?php
            // Iterar sobre los resultados y llenar el elemento select
            while ($row = $result->fetch_assoc()) {
                echo "<option value='{$row["id"]}'>{$row["ruc"]}</option>";
                print_r($row);
            }
            ?>
        </select>
            <br>
        <label for="telefono">Nombre:</label>
        <input type="text" id="nombre"  class="form-control" name="nombre" readonly>
            <br>
        <label for="email">Celular:</label>
        <input type="text" id="celular"  class="form-control" name="celular" readonly>
            <br>
        <label for="">Monto</label>
        <input type="number" class="form-control"  name="monto">
            <br>
        <label for="">Fecha</label>
        <input type="text" id="fechaInput"  name="fecha" placeholder="Selecciona una fecha">
        <br>
        <label for="">Foto</label>
        <input class="form-control" type="file" name="imagen" id="imagen" accept=".jpg,.png">
            <br>
        <label for="">Metodo de pago</label>
        <select name="met_pago" id="met_pago">
        <option value="Efectivo">Efectivo</option>
        <option value="Yape">Yape</option>
        <option value="Tarjeta">Tarjeta</option>  
        </select>
        <br><br>
        <label for="">Tipo de Pago</label>
        <select name="tip_pago" id="tip_pago">
        <option value="Mensual">Mensual</option>
        <option value="Anual">Anual</option>
        </select>
        <br><br>
        <label for="">Mes correspondiente</label>
        <select name="mes_pago" id="mes_pago">
        <option value="Enero">Enero</option>
        <option value="Febrero">Febrero</option>
        <option value="Marzo">Marzo</option>
        <option value="Abril">Abril</option>
        <option value="Mayo">Mayo</option>
        <option value="Junio">Junio</option>
        <option value="Julio">Julio</option>
        <option value="Agosto">Agosto</option>
        <option value="Septiembre">Septiembre</option>
        <option value="Octubre">Octubre</option>
        <option value="Noviembre">Noviembre</option>
        <option value="Diciembre">Diciembre</option>
        </select>  
        <br><br>
        <button type="button" onclick="window.location.href = 'clientes.php';">VOLVER ATRÁS</button>
        <br><br>
        <input type="submit" class="registrar" value="Registrar pago">

  </form>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
        flatpickr("#fechaInput", {
            enableTime: false, // Si quieres incluir la hora, cámbialo a true
            dateFormat: "Y-m-d", // Formato de fecha
        });
    });
</script>

</body>
</html>