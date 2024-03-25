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
               <th>Fecha de pago</th>
               <th>Monto</th>
               <th>Foto</th>
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
              <td><?php echo $data['fecha']; ?></td>
              <td><?php echo $data['monto']; ?></td>
              <td><?php echo '<a href="#" data-toggle="modal" data-target="#imagenModal' . $data['idpago'] . '"><img src="' . $data['ruta_capturas'] . '" alt="" style="max-width: 100px;">';
               // Modal para mostrar la imagen completa
               echo '<div class="modal fade" id="imagenModal' . $data['idpago'] . '" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">';
               echo '<div class="modal-dialog" role="document">';
               echo '<div class="modal-content">';
               echo '<div class="modal-header">';
               echo '<h5 class="modal-title" id="exampleModalLabel">Imagen Completa</h5>';
               echo '<button type="button" class="close" data-dismiss="modal" aria-label="Close">';
               //echo '<span aria-hidden="true">&times;</span>';
               echo '</button>';
               echo '</div>';
               echo '<div class="modal-body">';
               echo '<img src="' . $data['ruta_capturas'] . '" alt="Imagen Completa" style="max-width: 100%; max-height: 80vh;">';
               echo '</div>';
               echo '<div class="modal-footer">';
               echo '<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>';
               echo '</div>';
               echo '</div>';
               echo '</div>';
               echo '</div>';
              
             echo'</td>';
            echo'</tr>';
            } 
            
          }else{
            ?>
          
          <tr>
                                         <td><?php  echo "No se encontraron resultados"; ?></td>
                                  <?php
                                    }
                                
                            ?>
          </tbody>
        </table>



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
  </form>

  

</body>
</html>
