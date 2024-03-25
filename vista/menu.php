<?php
// Inicia la sesión (si no está iniciada)
session_start();

// Verifica si el usuario está autenticado o cumple con ciertos criterios
if (!isset($_SESSION['username'],$_SESSION['contrasenia']) || !$_SESSION['username'] || !$_SESSION['contrasenia']){
    // Si no está autenticado o no cumple con los criterios, redirige a la página de inicio de sesión o a otra página de acceso no autorizado
    header("Location: login.php");
    exit();
}

include('../controlador/menu-controller.php');
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/menu.css">
    <style>
        body, html {
            height: 100%;
            margin: 0;
        }
        
       

    </style>   

    <title>Menú</title>
</head>
<body>
<section class="h-100 gradient-form" style="background-color:#0F1F52;">
  <div class="container py-5 h-100" >
    <div class="row d-flex justify-content-center align-items-center h-100" >
      <div class="col-xl-10">
        <div class="card rounded-3 text-black">
          <div class="row g-1">
            <div class="col-lg-6">
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
              <div class="card-body p-md-5 mx-md-4" style="height:80vh;">
                        <button class="btn btn-primary" name="subir" style="font-size: 1.7em;">Subir documento excel</button>
                        <br><br><br><br><br>
                        <button class="btn btn-success" name="clientes" style="font-size: 1.7em;">Lista de clientes que pagaron</button>
                        <br><br><br><br><br>
                        <button class="btn btn-danger" name="cerrar_sesion" style="font-size: 1.7em;">Cerrar sesión</button>
              </div>
            </form>  
            </div>
            <div class="col-lg-6 d-flex align-items-center">
            <div class="text-center">
                  <img src="logo.png"
                    style="width: 185px;" alt="logo">
                  
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<div>



</div>
</body>
</html>



