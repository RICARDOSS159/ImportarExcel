<?php
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
    if (isset($_POST["Nuevo"])) {
      // Acción para el Botón 2
      header("Location: registrar_pago.php");
      exit();
  }

  if(isset($_POST["Atras"])){
    header("Location:menu.php");
    exit();
  }

  if(isset($_POST["Todo"])){
    header("Location:clientes.php");
    exit();
  }
  ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de clientes</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/material-design-iconic-font/2.2.0/css/material-design-iconic-font.min.css">
  <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="../css/cargando.css">
  <link rel="stylesheet" type="text/css" href="../css/cssGenerales.css">
</head>
<h2>LISTA DE CLIENTES QUE PAGARON</h2>
<body>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
<?header("Content-Type: text/html;charset=utf-8");?>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button class="btn btn-secondary" name="Atras" href="menu.php";>VOLVER ATRÁS</button>&nbsp; &nbsp;
<button class="btn btn-success" name="Nuevo" href="registrar_pago.php">REGISTRAR PAGO</button>&nbsp;&nbsp;
<button class="btn btn-success" name="Todo" href="clientes.php">MOSTRAR TODO</button>&nbsp;&nbsp;

</form>
<br>
<form action="fpdf/Reporte_clientes.php" method="POST" target="_blank" style="margin-left:20px">
                             <!-- Campos ocultos para enviar los datos del formulario de búsqueda -->
    <input type="hidden" name="nombre" value="<?php echo isset($_POST['nombre']) ? $_POST['nombre'] : ''; ?>">
    <input type="hidden" name="mes" value="<?php echo isset($_POST['mes']) ? $_POST['mes'] : ''; ?>">
    <input type="hidden" name="anio" value="<?php echo isset($_POST['anio']) ? $_POST['anio'] : ''; ?>">
    <input type="hidden" name="from_date" value="<?php echo isset($_POST['from_date']) ? $_POST['from_date'] : ''; ?>">
    <input type="hidden" name="to_date" value="<?php echo isset($_POST['to_date']) ? $_POST['to_date'] : ''; ?>">
    
    <!-- Botón para generar el reporte PDF -->
    <button name="accion" value="Reporte" class="btn btn-success">Generar Reporte PDF</button>
</form>
<br><br>
<div class="col-md-8">
<form action="" method="POST">
            <div class="row">
            <div class="col-md-4">
            <div class="form-group">
                <label><b>Filtrar por Nombre</b></label>
                <input id="inputNombre" type="text" name="nombre" class="form-control" placeholder="Ingrese el nombre" value="<?php if(isset($_POST['nombre'])){ echo $_POST['nombre']; } ?>"> 
            </div>
            </div>
            <div class="col-md-4">
            <div class="form-group">
                <label><b>Filtrar por Mes y Año</b></label>
                <select id="selectMes"name="mes" class="form-control">
                    <option value="">Selecciona un mes</option>
                    <option value="1"<?php if (isset($_POST['mes']) && $_POST['mes'] == '1') echo 'selected'; ?>>Enero</option>
                    <option value="2"<?php if (isset($_POST['mes']) && $_POST['mes'] == '2') echo 'selected'; ?>>Febrero</option>
                    <option value="3"<?php if (isset($_POST['mes']) && $_POST['mes'] == '3') echo 'selected'; ?>>Marzo</option>
                    <option value="4"<?php if (isset($_POST['mes']) && $_POST['mes'] == '4') echo 'selected'; ?>>Abril</option>
                    <option value="5"<?php if (isset($_POST['mes']) && $_POST['mes'] == '5') echo 'selected'; ?>>Mayo</option>
                    <option value="6"<?php if (isset($_POST['mes']) && $_POST['mes'] == '6') echo 'selected'; ?>>Junio</option>
                    <option value="7"<?php if (isset($_POST['mes']) && $_POST['mes'] == '7') echo 'selected'; ?>>Julio</option>
                    <option value="8"<?php if (isset($_POST['mes']) && $_POST['mes'] == '8') echo 'selected'; ?>>Agosto</option>
                    <option value="9"<?php if (isset($_POST['mes']) && $_POST['mes'] == '9') echo 'selected'; ?>>Septiembre</option>
                    <option value="10"<?php if (isset($_POST['mes']) && $_POST['mes'] == '10') echo 'selected'; ?>>Octubre</option>
                    <option value="11"<?php if (isset($_POST['mes']) && $_POST['mes'] == '11') echo 'selected'; ?>>Noviembre</option>
                    <option value="12"<?php if (isset($_POST['mes']) && $_POST['mes'] == '12') echo 'selected'; ?>>Diciembre</option>
                    
                </select>
                <br>
                <select id="selectAnio"name="anio" class="form-control">
                    <option value="">Selecciona un anio</option>
                    <option value="2024"<?php if (isset($_POST['anio']) && $_POST['anio'] == '2024') echo 'selected'; ?>>2024</option>
                    <option value="2023"<?php if (isset($_POST['anio']) && $_POST['anio'] == '2023') echo 'selected'; ?>>2023</option>
                    <option value="2022"<?php if (isset($_POST['anio']) && $_POST['anio'] == '2022') echo 'selected'; ?>>2022</option> 
                </select>
            </div>
        </div>
                                
                                <div class="col-md-4">
                                    
                                    <div class="form-group">
                                        <label><b>Del Dia</b></label>
                                        <input type="date" id="desde" name="from_date" value="<?php if(isset($_POST['from_date'])){ echo $_POST['from_date']; } ?>" class="form-control">
                                        <br>
                                        <label><b> Hasta  el Dia</b></label>
                                        <input type="date" id="hasta" name="to_date" value="<?php if(isset($_POST['to_date'])){ echo $_POST['to_date']; } ?>" class="form-control">
                                        
                                    </div>
                                    <div class="col-md-3">
                                    <div class="form-group">
                                        <label><b></b></label> <br>
                                      <button type="submit" class="btn btn-primary" name="accion" value="Buscar">Buscar</button>
                                      
                                    </div>
                                </div>
                                </div>
                                
                            </div>
                            <br>
                        </form>
                       

                       <?php if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['accion'])) {
        $accion = $_POST['accion'];
        
        if ($accion === "buscar") {
            // Procesar la búsqueda por nombre
            $nombre = $_POST['nombre'];
            // Realizar la consulta o la acción correspondiente utilizando el nombre
        } elseif ($accion === "informe") {
            // Generar el informe utilizando el nombre
            $nombre = $_POST['nombre'];
            $anio=$_POST['anio'];
            // Generar el informe utilizando el nombre proporcionado
        } else {
            // Manejar otros casos o mostrar un mensaje de error
        }
    }
}
         ?>               
<?php
  
  include('../modelo/filtrar_mes.php');

  // Verifica si se está filtrando por mes
$filtro_por_mes = !empty($_POST['mes']);
$filtro_por_mes = !empty($_POST['anio']);
$filtro_por_nombre=!empty($_POST['nombre']);
$filtro_por_rango=!empty($_POST['from_date']) && !empty($_POST['to_date']);
$sin_filtro=!$filtro_por_mes && !$filtro_por_rango && !$filtro_por_nombre;
$solo_filtro_rango=!$filtro_por_nombre && !$filtro_por_mes;

// Output the filtered data (in whatever format you prefer, JSON is commonly used)
json_encode(['data' => $query_run, 'filtro_por_mes' => $filtro_por_mes]);
 

  
 
      echo'<h6 class="text-center">';
     echo'   Lista de Clientes <strong>'; echo $total_client;echo'</strong>';
    echo'  </h6>

        <table class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>#</th>
               <th>RUC</th>
               <th>Nombre</th>
               <th>Celular</th>';
               if($filtro_por_mes){
                echo '<th>Fecha</th>';
                echo '<th>Metodo de Pago</th>';
               }
               /*if(ISSET($filtro_por_mes) && ISSET($filtro_por_nombre)){
                echo '<th>Lista de pagos</th>';
               }*/
               if($filtro_por_rango&&!$filtro_por_nombre){
                echo '<th>Fecha</th>';
               }
               // Verificar si no se está filtrando por mes para incluir la columna "Mostrar pago"
               if ($filtro_por_nombre &&!$filtro_por_rango||$sin_filtro) {
                   echo '<th>Lista de pagos</th>';
               }elseif($filtro_por_nombre && $filtro_por_rango){
                echo '<th>Fecha</th>';
               }
               if($solo_filtro_rango){
                
               }
              
            echo '</tr>
          </thead>
          <tbody>';
          
          
          if(mysqli_num_rows($query_run) > 0)
          {
            $i=1;
              foreach($query_run as $data)
              { ?>
              <tr>
              <th scope="row"><?php echo $i++; ?></th>
              <td><?php echo $data['ruc']; ?></td>
              <td><?php echo $data['nombre']; ?></td>
              <td><?php echo $data['celular']; ?></td>
              <?php if ($filtro_por_mes) {
              echo '<td>'.$data['fecha'].'</td>';
              echo '<td>'.$data['metodo_pago'].'</td>';
               }?>
              <?php if ($filtro_por_rango) {
              echo '<td>'.$data['fecha'].'</td>';
               }?>
              <?php if ($filtro_por_nombre &&!$filtro_por_rango || $sin_filtro) {
              echo '<td><a href="#" class="mostrarPago" data-ruc="' . $data['ruc'] . '">Mostrar pago</a></td>';
               }?>
               <?php
                if ($filtro_por_rango && !$filtro_por_nombre) {
                   
                }
               ?>
               
              </tr>
              <?php }
          }else{
            ?>
          <td><?php  echo "No se encontraron resultados"; ?></td>
           <?php }?>


          
          </tbody>
        </table>
                      
        


    </div>
  </div>

</div>
<!-- Ventana modal para mostrar detalles del pago -->
<div class="modal fade" id="modalPagos" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detalles del Pago</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="detallePago">
                <!-- Contenido del detalle del pago -->
            </div>
        </div>
    </div>
</div>


<script src="../js/jquery.min.js"></script>
<script src="'../js/popper.min.js"></script>
<script src="../js/bootstrap.min.js"></script>


<script type="text/javascript">
   function goBack() {
        window.history.back();
    }
   
</script>
<script>
// Obtener el elemento de entrada de fecha
var inputFecha = document.getElementById("desde");

// Obtener la fecha actual
var fechaActual = new Date().toISOString().split('T')[0];

// Establecer la fecha máxima como la fecha actual
inputFecha.max = fechaActual;

    // Obtener el elemento de entrada de fecha
    var inputFecha = document.getElementById("hasta");



    // Establecer la fecha máxima como la fecha actual
    inputFecha.max = fechaActual;
</script>

<script>

    var ultimoModalAbierto = null;
    $(document).ready(function() {
    // Función para mostrar los pagos de un cliente en la ventana modal
    $('.mostrarPago').click(function(e) {
        e.preventDefault();
        var rucCliente = $(this).data('ruc');
        $.ajax({
            url: '../modelo/obtener_datosxruc.php',
            type: 'POST',
            data: { ruc: rucCliente },
            success: function(response) {
                $('#detallePago').html(response);
                ultimoModalAbierto = '#modalPagos';
                $('#modalPagos').modal('show'); // Mostrar el modal utilizando Bootstrap
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    });
});

 // Función para cerrar el modal de imagen completa
 $('.cerrarImagenCompleta').click(function(e) {
        e.preventDefault();
        $(ultimoModalAbierto).modal('show'); // Vuelve a abrir el último modal abierto
    });
</script>
<!-- Agrega un script de JavaScript para limpiar la selección del mes cuando cambian las fechas -->
<script>
document.addEventListener("DOMContentLoaded", function() {
    // Selecciona el elemento del select de los meses
    var selectMes = document.getElementById("selectMes");
    var selectAnio= document.getElementById("selectAnio");
    // Agrega listeners para los eventos de cambio en los campos de fecha
    document.getElementById("desde").addEventListener("change", limpiarFiltroMes);
    document.getElementById("hasta").addEventListener("change", limpiarFiltroMes);
    // Función para limpiar la selección del mes
    function limpiarFiltroMes() {
        // Restablece el valor del select de los meses a la opción predeterminada
        selectMes.value = "";
        selectAnio.value = "";
    }
});
</script>
<!-- Script de JavaScript para limpiar el filtro por mes cuando se escribe un nombre -->
<script>
document.addEventListener("DOMContentLoaded", function() {
    // Selecciona el campo de entrada del nombre
    var inputNombre = document.getElementById("inputNombre");
    // Selecciona el select de mes
    var selectMes = document.getElementById("selectMes");
    // Agrega un listener para el evento de entrada en el campo de entrada del nombre
    inputNombre.addEventListener("input", limpiarFiltroMes);
    // Función para limpiar el filtro por mes cuando se escribe un nombre
    function limpiarFiltroMes() {
        // Restablece el valor del select de mes a la opción predeterminada
        selectMes.value = "";
    }
});
</script>

<!-- Script de JavaScript para limpiar el filtro por nombre cuando se filtre por mes y anio -->
<script>
document.addEventListener("DOMContentLoaded", function() {
    // Selecciona el campo de entrada del nombre
    var selectMes = document.getElementById("selectMes");
    // Selecciona el select de nombre y rango de fechas
    var inputNombre = document.getElementById("inputNombre");
    var desde = document.getElementById("desde");
    var hasta = document.getElementById("hasta");
    // Agrega un listener para el evento de entrada en el campo de entrada del nombre
    selectMes.addEventListener("input", limpiarFiltroNombre);
    // Función para limpiar el filtro por mes cuando se escribe un nombre
    function limpiarFiltroNombre() {
        // Restablece el valor del select de mes a la opción predeterminada
        inputNombre.value = "";
        desde.value="";
        hasta.value="";
    }
});
</script>
<script>

// Success function for AJAX request
success: function(response) {
    var tablaHtml = '<table class="table table-bordered table-striped">';
    tablaHtml += '<thead><tr><th>#</th><th>RUC</th><th>Nombre</th><th>Celular</th>';
    if (!response.filtro_por_mes) {
        tablaHtml += '<th>Lista de pagos</th>';
    }
    tablaHtml += '</tr></thead><tbody>';
    if(response.data.length > 0) {
        $.each(response.data, function(index, data) {
            tablaHtml += '<tr>';
            tablaHtml += '<td>' + (index + 1) + '</td>';
            tablaHtml += '<td>' + data.ruc + '</td>';
            tablaHtml += '<td>' + data.nombre + '</td>';
            tablaHtml += '<td>' + data.celular + '</td>';
            if (!response.filtro_por_mes) {
                tablaHtml += '<td><a href="#" class="mostrarPago" data-ruc="' + data.ruc + '">Mostrar pago</a></td>';
            }
            tablaHtml += '</tr>';
        });
    } else {
        tablaHtml += '<tr><td colspan="' + (response.filtro_por_mes ? 4 : 5) + '">No se encontraron resultados</td></tr>';
    }
    tablaHtml += '</tbody></table>';

    // Update the div with id "tabla-datos-filtrados"
    $('#tabla-datos-filtrados').html(tablaHtml);
}

</script>



  

  

</body>

</html>
