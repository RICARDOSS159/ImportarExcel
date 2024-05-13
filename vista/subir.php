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

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
  <title>iMPORTADOR DE EXCEL</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/material-design-iconic-font/2.2.0/css/material-design-iconic-font.min.css">
  <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
  <!--<link rel="stylesheet" type="text/css" href="../css/cargando.css">-->
  <link rel="stylesheet" type="text/css" href="../css/cssGenerales.css">
</head>
<body>

<div class="cargando">
    <div class="loader-outter"></div>
    <div class="loader-inner"></div>
</div>


<nav class="navbar navbar-expand-lg navbar-light navbar-dark fixed-top" style="background-color: #563d7c !important;">
    <ul class="navbar-nav mr-auto collapse navbar-collapse">
      <li class="nav-item active">
        <a href="subir.php"> 
          
        </a>
      </li>
    </ul>
    <div class="my-2 my-lg-0">
      <h5 class="navbar-brand"></h5>
    </div>
</nav>


<div class="container">

<h3 class="text-center">
    Sube tu archivo excel para cargar los datos
</h3>
<hr>
<br><br>

<!--Para subir los archivos en formato txt los datos deben estar separados por ; para que
se pueda subir correctamente-->
 <div class="row">
    <div class="col-md-7">
      <form action="../controlador/recibe_excel_validando.php" method="POST" enctype="multipart/form-data" onsubmit="return validarFormulario();"/>
        <div class="file-input text-center">
        <h4>OJO:Para subir un archivo plano en bloc de notas los datos deben estar separados
                por ";" para que pueda importar los datos correctamente
              </h4>
            <input  type="file" name="dataCliente" id="file-input" class="file-input__input"/>
            <label class="file-input__label" for="file-input">
              <i class="zmdi zmdi-upload zmdi-hc-2x"></i>
              <span>Elige un archivo plano Excel en csv o archivo plano txt</span></label>
          </div>
          
      <div class="text-center mt-5">
          <input type="submit" name="subir" class="btn-enviar" value="Subir Archivo"/>
      </div>
      
      </form>
      <div class="text-center mt-3">
      <button type="button" class="btn btn-secondary" onclick="window.location.href = 'menu-plantilla.php';">VOLVER ATRÁS</button>
      </div>
    </div>
    

    <div class="col-md-5">

    


  <?php
  header("Content-Type: text/html;charset=utf-8");
  include('../modelo/conexion.php');
  include('../modelo/actualizar_cliente.php');
  $sqlClientes = ("SELECT * FROM cliente ORDER BY id ASC");
  $queryData   = mysqli_query($mysqli, $sqlClientes);
  $total_client = mysqli_num_rows($queryData);
  ?>
       <div class="text-center">
       <button class="btn btn-success" onclick="window.location.href = 'nuevo_cliente.php';">Agregar nuevo cliente</button>
       </div>
       <br><br>
      <h6 class="text-center">
        Lista de Clientes <strong>(<?php echo $total_client; ?>)</strong>
      </h6>

        <table class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>#</th>
               <th>RUC</th>
               <th>Nombre</th>
               <th>Celular</th>
               <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
            <?php 
            $i = 1;
            while ($data = mysqli_fetch_array($queryData)) { ?>
            <tr>
              <th scope="row"><?php echo $i++; ?></th>
              <td><?php echo $data['ruc']; ?></td>
              <td><?php echo $data['nombre']; ?></td>
              <td><?php echo $data['celular']; ?></td>
              <td><a href="actualizar_cliente.php?id=<?= $data['id']; ?>"class="btn btn-info">Actualizar</a>
              <form action="../modelo/eliminar_cliente.php" method="POST" style="display: inline;">
                        <input type="hidden" name="id" value="<?php echo $data['id']; ?>">
                        <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro de eliminar este cliente?')">Eliminar</button>
                    </form>
            </td>
              
            </tr>
          <?php } ?>
          </tbody>
        </table>

    </div>
  </div>

</div>


<script src="../js/jquery.min.js"></script>
<script src="'../js/popper.min.js"></script>
<script src="../js/bootstrap.min.js"></script>

<script>
    function validarFormulario() {
        var inputFile = document.getElementById('file-input');
        if (inputFile.files.length === 0) {
            alert('Por favor, elige un archivo antes de enviar.');
            return false; // Evitar que el formulario se envíe
        }
        return true; // Permitir el envío del formulario si se seleccionó un archivo
    }
</script>

<script type="text/javascript">
   function goBack() {
        window.history.back();
    }
    $(document).ready(function() {
        $(window).load(function() {
            $(".cargando").fadeOut(1000);
        });      
});
</script>

</body>
</html>