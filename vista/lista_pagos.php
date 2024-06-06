<?php
// Inicia la sesión (si no está iniciada)
session_start();
// Verifica si el usuario está autenticado o cumple con ciertos criterios
if (!isset($_SESSION['username'],$_SESSION['contrasenia']) || !$_SESSION['username'] || !$_SESSION['contrasenia']){
  // Si no está autenticado o no cumple con los criterios, redirige a la página de inicio de sesión o a otra página de acceso no autorizado
  header("Location: login.php");
  exit();
}


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


  

?>


<?php 
    if (isset($_POST["Nuevo"])) {
      // Acción para el Botón 2
      header("Location: nuevo_registro_pago.php");
      exit();
  }

  if(isset($_POST["Todo"])){
    header("Location:lista_pagos.php");
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
        <a href="lista_clientes.php" class="nav-link">Lista de clientes</a>
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
                <a href="lista_clientes.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Lista de clientes</p>
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
            <h1 class="m-0">Lista de pagos</h1>
          </div><!-- /.col -->
            <!-- Main content -->
    <div class="text-center d-flex justify-content-center">
    
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
    
    <?header("Content-Type: text/html;charset=utf-8");?>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button class="btn btn-success" name="Nuevo" href="registrar_pago.php">REGISTRAR PAGO</button>&nbsp;&nbsp;
    <button class="btn btn-success" name="Todo" href="lista_pagos.php">MOSTRAR TODO</button>&nbsp
    
    </form>
    <br>
    <form action="fpdf/Reporte_clientes.php" method="POST" target="_blank" style="margin-left:10px">
                                 <!-- Campos ocultos para enviar los datos del formulario de búsqueda -->
        <input type="hidden" name="ruc" value="<?php echo isset($_POST['ruc']) ? $_POST['ruc'] : ''; ?>">
        <input type="hidden" name="mes" value="<?php echo isset($_POST['mes']) ? $_POST['mes'] : ''; ?>">
        <input type="hidden" name="anio" value="<?php echo isset($_POST['anio']) ? $_POST['anio'] : ''; ?>">
        <input type="hidden" name="from_date" value="<?php echo isset($_POST['from_date']) ? $_POST['from_date'] : ''; ?>">
        <input type="hidden" name="to_date" value="<?php echo isset($_POST['to_date']) ? $_POST['to_date'] : ''; ?>">
        
        <!-- Botón para generar el reporte PDF -->
        <button name="accion" value="Reporte" class="btn btn-success">Generar Reporte PDF</button>
    </form>
    </div>
        </div><!-- /.row -->
    </div>

<div class="">
<section class="content">
<form action="" method="POST">
            <div class="row">
            <div class="col-md-4">
            <div class="form-group" style="margin-left:10px">
                <!--<label><b>Filtrar por Nombre</b></label>
                <input id="inputNombre" type="text" name="nombre" class="form-control" placeholder="Ingrese el nombre" value="">-->
                <label><b>Filtrar por RUC</b></label>
                <input id="inputRuc" type="text" name="ruc" class="form-control" placeholder="Ingrese el ruc" value="<?php if(isset($_POST['ruc'])){ echo $_POST['ruc']; } ?>"> 
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
                                    
                                    <div class="form-group" style="margin-right:10px">
                                        <label><b>Del Dia</b></label>
                                        <input type="date" id="desde" name="from_date" value="<?php if(isset($_POST['from_date'])){ echo $_POST['from_date']; } ?>" class="form-control">
                                        
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
                            
</form>
                       

                             
 <?php 
 include('../modelo/filtrar_mes.php');
// Verifica si se está filtrando por me
  $filtro_por_ruc_rango=!empty($_POST['ruc'])&& !empty($_POST['from_date']) && !empty($_POST['to_date']);
  $filtro_por_mes = !empty($_POST['mes']);
  $filtro_por_anio = !empty($_POST['anio']);
  $filtro_por_ruc=!empty($_POST['ruc']);
  $filtro_por_rango=!empty($_POST['from_date']) && !empty($_POST['to_date']);
  $filtro_por_ruc_anio=!empty($_POST['ruc']) && !empty($_POST['anio']);
  $sin_filtro=!$filtro_por_mes && !$filtro_por_rango && !$filtro_por_ruc &&!$filtro_por_anio &&!$filtro_por_ruc_anio;
  
  
  // Output the filtered data (in whatever format you prefer, JSON is commonly used)
  json_encode(['data' => $query_run, 'filtro_por_mes' => $filtro_por_mes]);

            echo '<div class="card" style="margin-right: 10px; margin-left: 10px;">
              <div class="card-header">
                <h3 class="card-title">Tabla con la lista de clientes que realizaron sus pagos</h3>
              </div>
            
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>';
                  if($filtro_por_mes||$filtro_por_anio && !$filtro_por_ruc_anio){
                    echo '<th>#</th>
                   <th>RUC</th>
                   <th>Nombre</th>
                   <th>Fecha</th>';
                    echo '<th>Metodo de Pago</th>';
                    echo '<th>Tipo de Pago</th>';
                    echo '<th>Mes Pagado</th>';
                   }
                   if($filtro_por_ruc_anio){
                    echo '<th>#</th>
                    <th>Fecha</th>
                    <th>Monto</th>
                    <th>Metodo de Pago</th>
                    <th>Tipo de Pago</th>
                    <th>Mes Pagado</th>';
                    
                   }
                   /*if(ISSET($filtro_por_mes) && ISSET($filtro_por_nombre)){
                    echo '<th>Lista de pagos</th>';
                   }*/
                   if($filtro_por_rango&&!$filtro_por_ruc){
                    echo'<th>#</th>
                   <th>RUC</th>
                   <th>Nombre</th>
                   <th>Fecha</th>';
                    echo '<th>Metodo Pago</th>
                    <th>Tipo de Pago</th>
                   <th>Mes Pagado</th>';
                   }
                   if($filtro_por_ruc_rango){
                    echo'<th>#</th>
                     <th>Fecha</th>
                     <th>Monto</th>
                    <th>Metodo Pago</th>
                   <th>Tipo Pago</th>
                   <th>Mes Pagado</th>';
                   }
                   // Verificar si no se está filtrando por mes para incluir la columna "Mostrar pago"
                   if ($filtro_por_ruc &&!$filtro_por_rango && !$filtro_por_ruc_anio||$sin_filtro) {
                    echo '<th>#</th>
                    <th>RUC</th>
                    <th>Nombre</th>
                    <th>Celular</th>';
                       echo '<th class="exclude">Lista de pagos</th>';
                   }
                  echo'</tr>
                  <tbody>';
           
          
                  if(mysqli_num_rows($query_run) > 0)
                  {
                    $i=1;
                      foreach($query_run as $data)
                      { ?>
                      <tr>
                      <th scope="row"><?php echo $i++; ?></th>
                      
                      <!--Este es solo para que filtre por mes o anio y no sea por filtro de nombre y año-->
                      <?php if ($filtro_por_mes||$filtro_por_anio &&!$filtro_por_ruc_anio) {?>
                        <td><?php echo $data['ruc']; ?></td>
                        <td><?php echo $data['nombre']; ?></td>
                        <td><?php echo $data['fecha_form_pago']; ?></td>
                      <?php echo '<td>'.$data['metodo_pago'].'</td>';
                      echo '<td>'.$data['tipo_pago'].'</td>';
                      echo '<td>'.$data['mes_correspon'].'</td>';
                       }?>
                       <?php if ($filtro_por_ruc_anio) {?>
                        <?php echo '<td>'.$data['fecha_form_pago'].'</td>';
                        echo '<td>'.$data['monto'].'</td>';  
                        echo '<td>'.$data['metodo_pago'].'</td>';
                      echo '<td>'.$data['tipo_pago'].'</td>';
                      echo '<td>'.$data['mes_correspon'].'</td>';
                       }?>
        
                      <?php if ($filtro_por_rango && !$filtro_por_ruc) {?>
                        <td><?php echo $data['ruc']; ?></td>
                        <td><?php echo $data['nombre']; ?></td>
                      <?php echo '<td>'.$data['fecha_form_pago'].'</td>';
                      echo '<td>'.$data['metodo_pago'].'</td>';
                      echo '<td>'.$data['tipo_pago'].'</td>';
                      echo '<td>'.$data['mes_correspon'].'</td>';
                       }?>
                       <?php if ($filtro_por_ruc_rango) {?>
                        
                      <?php echo '<td>'.$data['fecha_form_pago'].'</td>';
                      echo '<td>'.$data['monto'].'</td>';
                      echo '<td>'.$data['metodo_pago'].'</td>';
                      echo '<td>'.$data['tipo_pago'].'</td>';
                      echo '<td>'.$data['mes_correspon'].'</td>';
                       }?>
                      <?php if ($filtro_por_ruc &&!$filtro_por_rango &&!$filtro_por_ruc_anio|| $sin_filtro ) {?>
                         <td><?php echo $data['ruc']; ?></td>
                         <td><?php echo $data['nombre']; ?></td>
                         <td><?php echo $data['celular']; ?></td>
                      <?PHP echo '<td><a href="#" class="mostrarPago" data-ruc="' . $data['ruc'] . '">Mostrar pago</a></td>';
                       }?>
                       
                       
                       
                      </tr>
                      <?php }
                  }else{
                    ?>
                  <td><?php  echo "No se encontraron resultados"; ?></td>
          <?php } ?>
          </tbody>
                  </thead>
                  
                 
                  </tbody>

                </table>
              </div>
    </section>

  <!-- Ventana modal para mostrar detalles del pago -->
<div class="modal fade" id="modalPagos" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
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

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->
<script src="../js/jquery.min.js"></script>
<script src="'../js/popper.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
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
<!-- ChartJS -->
<script src="../vista/plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="../vista/plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="../vista/plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="../vista/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="../vista/plugins/jquery-knob/jquery.knob.min.js"></script>
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
<!-- daterangepicker -->
<script src="../vista/plugins/moment/moment.min.js"></script>
<script src="../vista/plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="../vista/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="../vista/plugins/summernote/summernote-bs4.min.js"></script>
<!-- AdminLTE App -->
<script src="../vista/dist/js/adminlte.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="../vista/dist/js/pages/dashboard.js"></script>
<!-- Page specific script -->
<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      //"buttons": ["csv", "excel","pdf","colvis"], //"csv", "excel", "pdf", "print",
      "buttons": [
      /*{
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
      },*/
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
<script>

    var ultimoModalAbierto = null;
    $(document).ready(function() {
    // Función para mostrar los pagos de un cliente en la ventana modal
    $(document).on('click', '.mostrarPago', function(e) {
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
    var inputRuc = document.getElementById("inputRuc");
    // Selecciona el select de mes
    var selectMes = document.getElementById("selectMes");
    var selectAnio = document.getElementById("selectAnio");
    // Agrega un listener para el evento de entrada en el campo de entrada del nombre
    inputRuc.addEventListener("input", limpiarFiltroMes);
    // Función para limpiar el filtro por mes cuando se escribe un nombre
    function limpiarFiltroMes() {
        // Restablece el valor del select de mes a la opción predeterminada
        selectMes.value = "";
        selectAnio.value= "";
    }
});
</script>

<!-- Script de JavaScript para limpiar el filtro por nombre cuando se filtre por mes y anio -->
<script>
document.addEventListener("DOMContentLoaded", function() {
    // Selecciona el campo de entrada del nombre
    var selectMes = document.getElementById("selectMes");
    // Selecciona el select de nombre y rango de fechas
    var inputRuc = document.getElementById("inputRuc");
    var desde = document.getElementById("desde");
    var hasta = document.getElementById("hasta");
    // Agrega un listener para el evento de entrada en el campo de entrada del nombre
    selectMes.addEventListener("input", limpiarFiltroNombre);
    // Función para limpiar el filtro por mes cuando se escribe un nombre
    function limpiarFiltroNombre() {
        // Restablece el valor del select de mes a la opción predeterminada
        inputRuc.value = "";
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
