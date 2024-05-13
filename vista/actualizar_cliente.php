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

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../vista/plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="../vista/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../vista/dist/css/adminlte.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="../vista/plugins/daterangepicker/daterangepicker.css">
  <link rel="stylesheet" type="text/css" href="../css/actualizar_cliente.css">
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
    <!-- Theme style -->
  <link rel="stylesheet" href="../vista/dist/css/adminlte.min.css">
  <link rel="stylesheet" href="../vista/dist/css/adminlte.css">
</head>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

<?php
  header("Content-Type: text/html;charset=utf-8");
  include('../modelo/conexion.php');
  include('../modelo/actualizar_cliente.php');
  $sqlClientes = ("SELECT * FROM cliente ORDER BY id ASC");
  $queryData   = mysqli_query($mysqli, $sqlClientes);
  $total_client = mysqli_num_rows($queryData);
  ?>

  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="dist/img/logo.jpg" alt="AdminLTELogo" height="60" width="60">
  </div>

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="menu-plantilla.php" class="nav-link">Menú</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="importar.php" class="nav-link">Importar clientes</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="lista_pagos.php" class="nav-link">Lista de pagos</a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
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
    <a href="index3.html" class="brand-link">
      <img src="dist/img/logo.jpg" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">DYF CONTADORES</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block"><?php echo $nombreUsuario; ?></a>
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
                <a href="importar.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Importar</p>
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
            <h1 class="m-0">Lista de clientes</h1>
          </div><!-- /.col -->
         
        </div><!-- /.row -->
    </div>
  
    <!-- /.content-header -->

    <!-- Content Wrapper. Contains page content -->
 

<?php 
    include('../modelo/conexion.php');
    include('../modelo/actualizar_cliente.php');
    // Obtener el ID del cliente de la URL
    $id = $_GET['id'];
    
    // Consulta para obtener los datos del cliente
    $sqlCliente = "SELECT * FROM cliente WHERE id = $id";
    $queryCliente = mysqli_query($mysqli, $sqlCliente);
    $data = mysqli_fetch_array($queryCliente);

?>
    <form action="lista_clientes.php" method="POST">
        
        <div class="card card-success">
              <div class="card-header">
                <h3 class="card-title">Actualizar cliente</h3>
              </div>
              <div class="card-body">
              <input type="hidden" name="id" value="<?= $data['id']; ?>">
              <div class="form-group">
                    <label for="exampleInputEmail1">Ingrese el RUC</label>
                    <input type="text" class="form-control" id="Ruc" name="ruc" placeholder="RUC" value="<?= $data['ruc']; ?>">
                  </div>
              <div class="form-group">
                    <label for="exampleInputEmail1">Ingrese la empresa</label>
                    <input type="text" class="form-control" id="Empresa" name="nombre" placeholder="Empresa" value="<?= $data['nombre']; ?>">
              </div>
              <div class="form-group">
                    <label for="exampleInputEmail1">Ingrese el celular</label>
                    <input type="text" class="form-control" id="Celular" name="celular" placeholder="Celular" value="<?= $data['celular']; ?>">
              </div>
              <div class="form-group">
                    <label for="exampleInputEmail1">Ingrese la direccion</label>
                    <input type="text" class="form-control" id="Direccion" name="direccion" placeholder="Direccion" value="<?= $data['direccion']; ?>">
              </div>
                <!-- Date dd/mm/yyyy -->
                <div class="form-group">
                  <label>Fecha de ingreso:</label>

                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                    </div>
                    <?php
                    // Suponiendo que $data['fecha_ingreso'] contiene la fecha en formato yyyy/mm/dd
                    // Convertimos la fecha al formato dd/mm/yyyy
                    $fecha_ingreso_dd_mm_yyyy = date("d-m-Y", strtotime($data['fecha_ingreso']));
                    ?>
                    <input type="text" id="fecha_ingreso" name="fecha_ingreso" class="form-control1" data-inputmask-alias="datetime" data-inputmask-inputformat="yyyy/mm/dd" data-mask value="<?= $fecha_ingreso_dd_mm_yyyy; ?>">
                  </div>
                  <!-- /.input group -->
                </div>

                <div class="form-group">
                  <label>Fecha de activación sunat:</label>

                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                    </div>
                    <?php
                        // Suponiendo que $data['fecha_ingreso'] contiene la fecha en formato yyyy/mm/dd
                        // Convertimos la fecha al formato dd/mm/yyyy
                        $fecha_activacion_dd_mm_yyyy = date("d-m-Y", strtotime($data['fecha_activacion']));
                    ?>
                    <input type="text" id="fecha_activacion" name="fecha_activacion" class="form-control1" data-inputmask-alias="datetime" data-inputmask-inputformat="yyyy/mm/dd" data-mask value="<?= $fecha_activacion_dd_mm_yyyy; ?>">
                  </div>
                  <!-- /.input group -->
                </div>
                <div class="form-group">
                <label for="estado_pago">Estado de pago</label>
                <select class="form-control" id="estado_pago" name="estado_pago">
                <option value="Pagos al dia" <?= ($data['estado_pago'] == 'Pagos al dia') ? 'selected' : ''; ?>>Pagos al dia</option>
                <option value="Pago pendiente" <?= ($data['estado_pago'] == 'Pago pendiente') ? 'selected' : ''; ?>>Pago pendiente</option>
        
              
        </select>

                <br>
                <div class="container">
                <input type="submit" class="btn btn-success" value="Actualizar"></input>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    
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
<!-- Tempusdominus Bootstrap 4 -->
<script src="../vista/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- AdminLTE App -->
<script src="../vista/dist/js/adminlte.js"></script>
</body>
</html>
