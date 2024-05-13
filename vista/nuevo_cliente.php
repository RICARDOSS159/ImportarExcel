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

<?php 
    

  if(isset($_POST["Atras"])){
    header("Location:clientes.php");
    exit();
  }
  ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | Advanced form elements</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../vista/plugins/fontawesome-free/css/all.min.css">
  <!-- Bootstrap Color Picker -->
  <link rel="stylesheet" href="../vista/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css">

  <!-- Theme style -->
  <link rel="stylesheet" href="../vista/dist/css/adminlte.min.css">
  <link rel="stylesheet" href="../vista/dist/css/adminlte.css">

   <!-- Tempusdominus Bootstrap 4 -->
   <link rel="stylesheet" href="../vista/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">


</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
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
        <a class="nav-link" data-widget="navbar-search" href="#" role="button">
          <i class="fas fa-search"></i>
        </a>
        <div class="navbar-search-block">
          <form class="form-inline">
            <div class="input-group input-group-sm">
              <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
              <div class="input-group-append">
                <button class="btn btn-navbar" type="submit">
                  <i class="fas fa-search"></i>
                </button>
                <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
          </form>
        </div>
      </li>

      
     
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="menu-plantilla.php" class="brand-link">
      <img src="logo.jpg" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">DYF CONTADORES</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->
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
              <i class="nav-icon fas fa-edit"></i>
              <p>
                Menú
                <i class="fas fa-angle-left right"></i>
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
                  <p>Lista de pagos realizados</p>
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
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Sistema de control de pagos</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>


        <form action="../modelo/guardar_cliente.php" method="post" enctype="multipart/form-data">
        <div class="row">
          <div class="col-md-12">

            <div class="card card-success">
              <div class="card-header">
                <h3 class="card-title">Formulario para agregar un nuevo cliente</h3>
              </div>
              <div class="card-body">
              <div class="form-group">
                    <label for="exampleInputEmail1">Ingrese el RUC</label>
                    <input type="text" class="form-control" id="Ruc" name="Ruc" placeholder="RUC">
                  </div>
              <div class="form-group">
                    <label for="exampleInputEmail1">Ingrese la empresa</label>
                    <input type="text" class="form-control" id="Empresa" name="Empresa" placeholder="Empresa">
              </div>
              <div class="form-group">
                    <label for="exampleInputEmail1">Ingrese la direccion</label>
                    <input type="text" class="form-control" id="Direccion" name="Direccion" placeholder="Direccion">
              </div>
              <div class="form-group">
                    <label for="exampleInputEmail1">Ingrese el celular</label>
                    <input type="text" class="form-control" id="Celular" name="Celular" placeholder="Celular">
              </div>
                <!-- Date dd/mm/yyyy -->
                <div class="form-group">
                  <label>Fecha de Ingreso:</label>
                    <div class="input-group date"  id="reservationdate" data-target-input="nearest">
                        <input type="text" id="fecha_ingreso" name="fecha_ingreso" class="form-control1 datetimepicker-input" data-target="#reservationdate"/>
                        <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                        </div>
                    </div>
                </div>
                  <!-- /.input group -->
                

                <div class="form-group">
                  <label>Fecha de activación sunat:</label>

                  <div class="input-group date"  id="reservationdate2" data-target-input="nearest">
                        <input type="text" id="fecha_activacion" name="fecha_activacion" class="form-control1 datetimepicker-input" data-target="#reservationdate2"/>
                        <div class="input-group-append" data-target="#reservationdate2" data-toggle="datetimepicker">
                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                        </div>
                    </div>
                  <!-- /.input group -->
                </div>
                <br>
                <div class="container">
                  <button type="submit" class="btn btn-primary">Registrar cliente</button>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
</form>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="../vista/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../vista/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- InputMask para las fechas -->
<script src="../vista/plugins/moment/moment.min.js"></script>
<script src="../vista/plugins/inputmask/jquery.inputmask.min.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="../vista/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- AdminLTE App -->
<script src="../vista/dist/js/adminlte.min.js"></script>
<!-- script js para colocar el calendario de fecha hacia la derecha-->
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
      var fechaIngreso = $('#reservationdate input').val();
      var fechaActivacion = $('#reservationdate2 input').val();
      // Convierte la fecha al formato deseado (YYYY-MM-DD)
      var fechaIngresoFormateada = moment(fechaIngreso, 'DD/MM/YYYY').format('YYYY-MM-DD');
      var fechaActivacionFormateada = moment(fechaActivacion, 'DD/MM/YYYY').format('YYYY-MM-DD');

      // Asigna la fecha formateada de vuelta al campo de fecha
      $('#reservationdate input').val(fechaIngresoFormateada);
      $('#reservationdate2 input').val(fechaActivacionFormateada);
      // Envía el formulario
      this.submit();
    });
  });
 </script>

</body>
</html>
