<?php
// Inicia la sesión (si no está iniciada)
session_start();

include('../modelo/conexion.php');
  $user_id = $_SESSION['user_id'];
  $sql = "SELECT usuario FROM usuario WHERE id_usuario = $user_id";
  $result = $mysqli->query($sql);
  
  if ($result->num_rows > 0) {
      $row = $result->fetch_assoc();
      $nombreUsuario = $row['usuario'];
  } else {
      $nombreUsuario = "Usuario Desconocido";
  }

// Verifica si el usuario está autenticado o cumple con ciertos criterios
if (!isset($_SESSION['username'],$_SESSION['contrasenia']) || !$_SESSION['username'] || !$_SESSION['contrasenia']){
    // Si no está autenticado o no cumple con los criterios, redirige a la página de inicio de sesión o a otra página de acceso no autorizado
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Sistema de control de pagos</title>
 
 
 
     <!--link Jquery-->
     <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../vista/plugins/fontawesome-free/css/all.min.css">
  <!-- Bootstrap Color Picker -->
  <link rel="stylesheet" href="../vista/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="../vista/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../vista/dist/css/adminlte.min.css">
  <link rel="stylesheet" href="../vista/dist/css/adminlte.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="../vista/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="../vista/plugins/daterangepicker/daterangepicker.css">

  
  <!-- Select2 -->
  <link rel="stylesheet" href="../vista/plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="../vista/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
  <!-- Bootstrap4 Duallistbox -->
  <link rel="stylesheet" href="../vista/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
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
                        $('#direccion').val(data.direccion);
                        }
                });
            });
        });
    </script>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
<?php
  header("Content-Type: text/html;charset=utf-8");
  include('../modelo/conexion.php');
  include('../modelo/actualizar_cliente.php');
  $sqlClientes= ("SELECT * FROM cliente ORDER BY id ASC");
  $queryData= mysqli_query($mysqli, $sqlClientes);
  $total_client= mysqli_num_rows($queryData);
  ?>
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="menu-plantilla.php" class="nav-link">Menu</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="lista_clientes.php" class="nav-link">Lista de clientes</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="lista_pagos.php" class="nav-link">Lista de pagos</a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Navbar Search -->
      

      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="../controlador/cerrar_sesion.php" role="button">
          <i class="fas fa-sign-out-alt"></i>
        </a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="menu_platilla.php" class="brand-link">
      <img src="dist/img/logo.jpg" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">DYF CONTADORES</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="info">
          <a href="#" class="d-block">BIENVENIDO: <?php echo $nombreUsuario; ?></a>
        </div>
      </div>

      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item menu-open">
            <a href="#" class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Menú
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="lista_clientes.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Lista de clientes</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="lista_pagos.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Lista de pagos</p>
                </a>
              </li>
            </ul>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Actualiza el pagos de los clientes</h1>
          </div><!-- /.col -->
         
        </div><!-- /.row -->
    </div>

    <?php
  include('../modelo/conexion.php');
  include('../modelo/actualizar_pagos.php');

  $idPago = $_GET['idpago'];
  $sqlPagos = ("SELECT c.id,c.ruc,c.nombre,c.celular,c.direccion,p.idpago,p.fecha,p.monto,p.ruta_capturas,p.metodo_pago,p.tipo_pago,p.mes_correspon
   FROM cliente as c inner join pagos as p on C.id=p.idcliente where p.idpago=$idPago");
  $queryData   = mysqli_query($mysqli, $sqlPagos);
  $pagos = mysqli_fetch_array($queryData);
  ?>
    
    <form action="../modelo/actualizar_pagos.php" method="post" enctype="multipart/form-data">
        <div class="row">
          <div class="col-md-12">

            <div class="card card-success">
              
              <div class="card-body">
              <input type="hidden" name="idpagoAct" value="<?= $pagos['idpago']; ?>">
              <div class="form-group">
                    <label for="exampleInputEmail1">RUC</label>
                    <input type="text" id="ruc"  class="form-control" name="rucAct" value="<?= $pagos['ruc']; ?>" readonly>
              </div>
              <div class="form-group">
                    <label for="exampleInputEmail1">Empresa</label>
                    <input type="text" id="nombre"  class="form-control" name="nombreAct" value="<?= $pagos['nombre']; ?>" readonly>
              </div>
              
              <div class="form-group">
                    <label for="exampleInputEmail1">Direccion</label>
                    <input type="text" id="direccion"  class="form-control" name="direccionAct" value="<?= $pagos['direccion']; ?>" readonly>
              </div>
              <div class="form-group">
                    <label for="exampleInputEmail1">Celular</label>
                    <input type="text" id="celular"  class="form-control" name="celularAct" value="<?= $pagos['celular']; ?>" readonly>
              </div>
              <div class="form-group">
                    <label for="exampleInputEmail1">Monto</label>
                    <input type="number" class="form-control" id="monto" name="montoAct" value="<?= $pagos['monto']; ?>" placeholder="Monto">
              </div>
                <!-- Date dd/mm/yyyy -->
                <div class="form-group">
                  <label>Fecha de Pago:</label>
                    <div class="input-group date"  id="reservationdate" data-target-input="nearest" >
                    <?php
                    // Suponiendo que $data['fecha_ingreso'] contiene la fecha en formato yyyy/mm/dd
                    // Convertimos la fecha al formato dd/mm/yyyy
                    $fecha_pago_dd_mm_yyyy = date("d-m-Y", strtotime($pagos['fecha']));
                    ?>
                         <input type="text" id="fecha_pago" name="fecha_pagoAct" class="form-control1 datetimepicker-input" data-target="#reservationdate" value="<?= $fecha_pago_dd_mm_yyyy; ?>"/>
                        <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Foto</label>
                    <input class="form-control" type="file" name="imagenAct" id="imagen" accept=".jpg,.png">
              </div>
              
              <div class="form-group">
              <label for="">Metodo de pago</label>
              <?php
                  $metodos_pago = ["Tarjeta", "Efectivo", "Yape"];
                  $metodo_pago_seleccionado = $pagos['metodo_pago']; // Suponiendo que esto contiene el método de pago desde la base de datos
                ?>

        <select name="met_pagoAct" class="form-control" id="met_pago">
        <?php foreach ($metodos_pago as $metodo): ?>
        <option value="<?= $metodo; ?>" <?= $metodo == $metodo_pago_seleccionado ? 'selected' : ''; ?>>
            <?= $metodo; ?>
        </option>
    <?php endforeach; ?>
        </select>
        <br>
        <label for="">Tipo de Pago</label>
        <?php
        $tipo_pago = [
            'Mensual','Anual'
        ];
        $tipo_pago_seleccionado = $pagos['tipo_pago']; // Suponiendo que esto contiene el mes correspondiente desde la base de datos
        ?>
        <select name="tip_pagoAct" class="form-control" id="tip_pago">
        <?php foreach ($tipo_pago as $tip_pago): ?>
        <option value="<?= $tip_pago; ?>" <?= $tip_pago == $tipo_pago_seleccionado ? 'selected' : ''; ?>>
            <?= $tip_pago; ?>
        </option>
        <?php endforeach; ?>
        </select>
        <br>
        <label for="">Mes correspondiente</label>
        <?php
        $meses = [
            'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 
            'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
        ];
        $mes_seleccionado = $pagos['mes_correspon']; // Suponiendo que esto contiene el mes correspondiente desde la base de datos
        ?>
        <select name="mes_pagoAct" class="form-control" id="mes_pago">
        <?php foreach ($meses as $mes): ?>
        <option value="<?= $mes; ?>" <?= $mes == $mes_seleccionado ? 'selected' : ''; ?>>
            <?= $mes; ?>
        </option>
    <?php endforeach; ?>
        </select>
        </div>  
                  <!-- /.input group -->
                <br>
                <div class="container">
                  <button type="submit" class="btn btn-primary">Actualizar pago</button>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
</form>

    

    
  </div>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="../vista/plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="../vista/plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="../vista/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- jQuery Knob Chart -->
<script src="../vista/plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- Select2 para las fechas-->
<script src="../vista/plugins/select2/js/select2.full.min.js"></script>
<!-- InputMask para las fechas -->
<script src="../vista/plugins/moment/moment.min.js"></script>
<script src="../vista/plugins/inputmask/jquery.inputmask.min.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="../vista/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>

<!-- AdminLTE App -->
<script src="../vista/dist/js/adminlte.js"></script>
<script>
  $(function () {
    $('#reservationdate').datetimepicker({
        format: 'DD/MM/YYYY',
        // Configurar la opción placement para que el calendario aparezca a la derecha
        widgetPositioning: {
            horizontal: 'right'
        }
    });

     // Inicialización del DateTimePicker para el segundo campo de fecha
     $('#reservationdate2').datetimepicker({
        format: 'DD/MM/YYYY',  // Formato de fecha
        // Configuración adicional si es necesaria
        widgetPositioning: {
            horizontal: 'right'
        }
    });
});


</script>

<!-- Page specific script -->
<script>
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()

    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })

    //Datemask dd/mm/yyyy
    /*$('#datemask').inputmask('dd-mm-yyyy', { 'placeholder': 'dd-mm-yyyy' })
    //Datemask2 mm/dd/yyyy
    $('#datemask2').inputmask('yyyy/mm/dd', { 'placeholder': 'mm/dd/yyyy' })*/
    //Money Euro
    $('[data-mask]').inputmask()

    //Date picker
    $('#reservationdate').datetimepicker({
        format: 'L'
    });



  })

  // Captura el evento de envío del formulario
  $(function() {
    $('form').submit(function(event) {
      // Evita el envío del formulario por defecto
      event.preventDefault();

      // Obtiene el valor del campo de fecha de ingreso
      var fechaPago = $('#reservationdate input').val();
      // Convierte la fecha al formato deseado (YYYY-MM-DD)
      var fechaIngresoFormateada = moment(fechaPago, 'DD/MM/YYYY').format('YYYY-MM-DD');

      // Asigna la fecha formateada de vuelta al campo de fecha
      $('#reservationdate input').val(fechaIngresoFormateada);
      // Envía el formulario
      this.submit();
    });
  });
 

  // Get the template HTML and remove it from the doumenthe template HTML and remove it from the doument
  var previewNode = document.querySelector("#template")
  previewNode.id = ""
  var previewTemplate = previewNode.parentNode.innerHTML
  previewNode.parentNode.removeChild(previewNode)
  
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        flatpickr("#fechaInput", {
            enableTime: false, // Si quieres incluir la hora, cámbialo a true
            dateFormat: "Y-m-d", // Formato de fecha
        });
    });
</script>

<script>
   document.getElementById('tip_pago').addEventListener('change', function() {
        var tipoPago = this.value;
        var mesPagoSelect = document.getElementById('mes_pago');

        if (tipoPago === 'Anual') {
            // Limpiar opciones y agregar una única opción para todo el año
            mesPagoSelect.innerHTML = '';
            var option = document.createElement('option');
            option.text = 'Un año completo';
            option.value = 'Un año completo';
            mesPagoSelect.appendChild(option);
        } else {
            // Restablecer las opciones mensuales
            mesPagoSelect.innerHTML = `
                <?php foreach ($meses as $mes): ?>
                    <option value="<?= $mes; ?>"><?= $mes; ?></option>
                <?php endforeach; ?>
            `;
        }
    });

    // Al cargar la página, verifica el tipo de pago y actualiza las opciones del mes correspondiente
    window.onload = function() {
        var tipoPago = document.getElementById('tip_pago').value;
        var mesPagoSelect = document.getElementById('mes_pago');

        if (tipoPago === 'Anual') {
            // Limpiar opciones y agregar una única opción para todo el año
            mesPagoSelect.innerHTML = '';
            var option = document.createElement('option');
            option.text = 'Un año completo';
            option.value = 'Un año completo';
            mesPagoSelect.appendChild(option);
        }
    };
</script>


</body>
</html>
