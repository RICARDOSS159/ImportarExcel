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
  <!-- DataTables -->
  <link rel="stylesheet" href="../vista/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="../vista/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="../vista/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../vista/dist/css/adminlte.min.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

<?php
  header("Content-Type: text/html;charset=utf-8");
  include('../modelo/conexion.php');
  include('../modelo/actualizar_cliente.php');
  $sqlClientes = ("SELECT id,ruc,nombre,celular,DATE_FORMAT(fecha_ingreso, '%d/%m/%Y') AS fecha_form_ingreso,
  DATE_FORMAT(fecha_activacion, '%d/%m/%Y') AS fecha_form_acti,direccion,estado_pago
   FROM cliente ORDER BY id ASC");
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
    <a href="menu-plantilla.php" class="brand-link">
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
 
    <!-- Content Header (Page header) -->
    <section class="content-header">
   
    </section>

    <!-- Main content -->
<section class="content">
    <?php
// Verifica si se ha pasado un mensaje
/*if (isset($_GET['mensaje'])) {
    $mensaje = $_GET['mensaje'];
    // Muestra el mensaje al usuario
    echo "<p>$mensaje</p>";
}*/
?>

<div class="card">
              <div class="card-header">
                <h3 class="card-title">Tabla con la lista de clientes</h3>
              </div>
              <br>
              <div class="text-center d-flex justify-content-center">
                  <button class="btn btn-warning" onclick="window.location.href = '../modelo/actualizar_estado_anual.php';">Actualizar estado de pagos Anual</button>
                  <button class="btn btn-warning" onclick="window.location.href = '../modelo/actualizar_estado_mensual.php';" style="margin-left:10px">Actualizar estado de pagos Mensual </button>
                  <button class="btn btn-success" onclick="window.location.href = 'nuevo_cliente.php';" style="margin-left:10px">Agregar nuevo cliente</button>
                  <form action="fpdf/Reporte_clientes_con_deuda.php" method="POST" target="_blank" style="margin-left:10px">
                  <button name="accion" value="Reporte" class="btn btn-info float-right">Generar Reporte de clientes con pago pendiente</button>
                </form>
                <form action="fpdf/Reporte_clientes_sin_deuda.php" method="POST" target="_blank" style="margin-left:10px">
                  <button name="accion" value="Reporte" class="btn btn-info">Generar Reporte de clientes con pagos al dia</button>
                </form>
                </div>
              <br>
              <div class="text-center">
                
              </div>
              <br>
              <div class="text-center">
                
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>#</th>
                    <th>Ruc</th>
                    <th>Nombre</th>
                    <th>Celular</th>
                    <th>Direccion</th>
                    <th>Fecha ingreso</th>
                    <th>Fecha activación</th>
                    <th>Estado de pago</th>
                    <th class="exclude">Acciones</th>
                  </tr>
                  <tbody>
            <?php 
            $i = 1;
            while ($data = mysqli_fetch_array($queryData)) { ?>
            <tr>
              <th scope="row"><?php echo $i++; ?></th>
              <td><?php echo $data['ruc']; ?></td>
              <td><?php echo $data['nombre']; ?></td>
              <td><?php echo $data['celular']; ?></td>
              <td><?php echo $data['direccion']; ?></td>
              <td><?php echo $data['fecha_form_ingreso']; ?></td>
              <td><?php echo $data['fecha_form_acti']; ?></td>
              <td><?php echo $data['estado_pago']; ?></td>
              <td><a href="actualizar_cliente.php?id=<?= $data['id']; ?>"class="btn btn-info" class="exclude">Actualizar</a>
                    <form action="../modelo/eliminar_cliente.php" method="POST" style="display: inline;">
                        <input type="hidden" name="id" value="<?php echo $data['id']; ?>">
                        <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro de eliminar este cliente?')">Eliminar</button>
                    </form>
              </td>
              
            </tr>
          <?php } ?>
                  </tbody>
                  </thead>
                </table>
              </div>
        
</div>
      <!-- /.container-fluid -->
</section>
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

<!-- DataTables  & Plugins -->
<script src="../vista/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../vista/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="../vista/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="../vista/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="../vista/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="../vista/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="../vista/plugins/jszip/jszip.min.js"></script>
<script src="../vista/plugins/pdfmake/pdfmake.min.js"></script>
<script src="../vista/plugins/pdfmake/vfs_fonts.js"></script>
<script src="../vista/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="../vista/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="../vista/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="../vista/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="../vista/plugins/summernote/summernote-bs4.min.js"></script>
<!-- AdminLTE App -->
<script src="../vista/dist/js/adminlte.js"></script>
<!-- Page specific script -->
<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      //"buttons": ["csv", "excel","pdf","colvis"], //"csv", "excel", "pdf", "print",
      "buttons": [
      {
        extend: 'csv',
        text: 'CSV',
        exportOptions: {
          columns: ':visible:not(.exclude)' // Excluye las columnas con la clase 'exclude'
        }
      },
      {
        extend: 'excel',
        text: 'Excel',
        exportOptions: {
          columns: ':visible:not(.exclude)' // Excluye las columnas con la clase 'exclude'
        }
      },
      {
        extend: 'pdfHtml5',
        text: 'PDF',
        exportOptions: {
          columns: ':visible:not(.exclude)' // Excluye las columnas con la clase 'exclude'
        }
      },
      {
        extend: 'colvis',
        text: 'Visibilidad de columnas'
      }
    ],
      // Cambiar el texto del campo de búsqueda
      "language": {
        "search": "Buscar:",
        "paginate": {
        "previous": "Anterior", // Cambiar el texto del botón 'Previous' aquí
        "next": "Siguiente"    // Cambiar el texto del botón 'Next' aquí
      },
      "info": "Mostrando _START_ a _END_ de _TOTAL_ registros" // Cambiar este texto según lo necesites
    
      }
     
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script>

</body>
</html>
