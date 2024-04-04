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
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button class="btn btn-secondary" name="Atras" href="menu.php";>VOLVER ATRÁS</button>&nbsp; &nbsp;
<button class="btn btn-success" name="Nuevo" href="registrar_pago.php">REGISTRAR PAGO</button>&nbsp;&nbsp;
<button class="btn btn-success" name="Todo" href="clientes.php">MOSTRAR TODO</button>&nbsp;&nbsp;
<a href="fpdf/Reporte_clientes.php" target="_blank" class="btn btn-success">GENERAR REPORTE PDF</a>
<br><br>
<div class="col-md-8">
<form action="" method="POST">
    
            <div class="row">
            <div class="col-md-4">
            <div class="form-group">
                <label><b>Filtrar por Nombre</b></label>
                <input type="text" name="nombre" class="form-control" placeholder="Ingrese el nombre">
            </div>
            </div>
            <!--<div class="col-md-4">
            <div class="form-group">
                <label><b>Filtrar por Mes</b></label>
                <select name="mes" class="form-control">
                    <option value="">Selecciona un mes</option>
                    <option value="1">Enero</option>
                    <option value="2">Febrero</option>
                    <option value="3">Marzo</option>
                    <option value="4">Abril</option>
                    <option value="5">Mayo</option>
                    <option value="6">Junio</option>
                    <option value="7">Julio</option>
                    <option value="8">Agosto</option>
                    <option value="9">Septiembre</option>
                    <option value="10">Octubre</option>
                    <option value="11">Noviembre</option>
                    <option value="12">Diciembre</option>
                </select>
            </div>
        </div>-->
                                
                                <div class="col-md-4">
                                    
                                    <div class="form-group">
                                        <label><b>Del Dia</b></label>
                                        <input type="date" id="desde" name="from_date" value="<?php if(isset($_POST['from_date'])){ echo $_POST['from_date']; } ?>" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label><b> Hasta  el Dia</b></label>
                                        <input type="date" id="hasta" name="to_date" value="<?php if(isset($_POST['to_date'])){ echo $_POST['to_date']; } ?>" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label><b></b></label> <br>
                                      <button type="submit" class="btn btn-primary">Buscar</button>
                                    </div>
                                </div>
                            </div>
                            <br>
                        </form>



<?php
  header("Content-Type: text/html;charset=utf-8");
  include('../modelo/filtrar_mes.php');

  
 

  
 
      echo'<h6 class="text-center">';
     echo'   Lista de Clientes <strong>'; echo $total_client;echo'</strong>';
    echo'  </h6>

        <table class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>#</th>
               <th>RUC</th>
               <th>Nombre</th>
               <th>Celular</th>
               <th>Lista de pagos</th>
            </tr>
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
              <td><a href="#" class="mostrarPago" data-ruc="<?php echo $data['ruc']; ?>">Mostrar pago</a></td>
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

<!--<script>
// Obtén el elemento de la ventana modal
var modal = document.getElementById('modalPagos');
// Obtén el elemento span que cierra la ventana modal
var spanCerrar = document.getElementsByClassName('close')[0];

// Agrega un evento de clic a cada enlace "Mostrar pago"
var enlacesMostrarPago = document.querySelectorAll('a.mostrarPago');
enlacesMostrarPago.forEach(function(enlace) {
  enlace.addEventListener('click', function(event) {
    event.preventDefault(); // Evita el comportamiento predeterminado del enlace
    var rucCliente = this.getAttribute('data-ruc'); // Obtiene el RUC del cliente del atributo de datos del enlace
    mostrarPagos(rucCliente); // Muestra los pagos del cliente en la ventana modal
  });
});

// Función para mostrar los pagos de un cliente en la ventana modal
function mostrarPagos(rucCliente) {
  // Aquí puedes realizar una petición AJAX al servidor para obtener los pagos del cliente según su RUC
  // Por ahora, se mostrará un mensaje de ejemplo
  var detallePago = 'Pagos del cliente con RUC: ' + rucCliente; // Simulación de detalles de pago
  document.getElementById('detallePago').innerHTML = detallePago; // Muestra los detalles de pago en la ventana modal
  modal.style.display = 'block'; // Muestra la ventana modal
}

// Función para cerrar la ventana modal al hacer clic en la X
spanCerrar.onclick = function() {
  modal.style.display = 'none';
}

// Función para cerrar la ventana modal al hacer clic fuera de ella
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = 'none';
  }
}
</script>-->
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
  </form>

  

</body>

</html>
