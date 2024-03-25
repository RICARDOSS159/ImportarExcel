<?php
require '../modelo/conexion.php';

// Inicializar la variable para almacenar el mensaje de error
/*$error_message = "";*/




?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/login.css"> 
    <title>Login</title>
</head>
<body>
<section class="h-100 gradient-form" style="background-color: #eee;">
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-xl-10">
        <div class="card rounded-3 text-black">
          <div class="row g-0">
            <div class="col-lg-6">
              <div class="card-body p-md-5 mx-md-4">

                <div class="text-center">
                  <img src="logo.png"
                    style="width: 185px;" alt="logo">
                  <h4 class="mt-1 mb-5 pb-1">Invoice facil</h4>
                </div>

                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                  <p class="Titulo">Iniciar sesión</p>

                 <?php
                    session_start();
                    //VERIFICAR QUE LOS CAMPOS NO ESTEN VACIOS
                    if(!empty($_POST['btningresar'])){
                      if(empty($_POST['username']) and empty($_POST['contrasenia'])){
                      echo '<div class="alert alert-danger">LOS CAMPOS ESTAN VACIOS</div>';
                      }else{
                          // Recuperar las credenciales del formulario
                            $username = $_POST['username'];
                            $password = $_POST['contrasenia'];
                            //$sql =$mysqli->query( "SELECT * FROM usuario WHERE usuario = '$username' AND contrasenia = '$password'");
                            $sql = "SELECT * FROM usuario WHERE BINARY usuario = '$username' AND BINARY contrasenia = '$password'";
                            $result = $mysqli->query($sql);
                            if($datos=$result->fetch_object()){
                              $_SESSION['username']=$datos->usuario;
                              $_SESSION['contrasenia']=$datos->contrasenia;
                              header("Location:menu.php");
                             
                            }else{
                              echo '<div class="alert alert-danger">CREDENCIALES INVALIDAS O CAMPOS INCOMPLETOS</div>';
                            }
                      }
                  }
                  

                  ?>

                  <label class="form-label" for="form2Example11">Nombre de usuario</label>
                  <div class="form-outline mb-4">
                    <input type="text" id="form2Example11" class="form-control"
                      placeholder="Ingrese su nombre de usuario" name="username" />
                    
                  </div>
                  <label class="form-label" for="form2Example22">Contraseña</label>
                  <div class="form-outline mb-4">
                    <input type="password" id="form2Example22" class="form-control" name="contrasenia" />
                    
                  </div>

                  <div class="text-center pt-1 mb-5 pb-1">
                    <input name="btningresar" class="btn btn-primary btn-block fa-lg gradient-custom-1 mb-3" type="submit" value="Ingresar" >
                      <br>
                    <!--<a class="text-muted" href="#!">¿Olvidastes tu contraseña?</a>-->
                  </div>
                  

                 <!--<div class="d-flex align-items-center justify-content-center pb-4">
                <p class="mb-0 me-2">Don't have an account?</p>
                    <button type="button" class="btn btn-outline-danger">Create new</button>
                  </div>-->

                </form>

              </div>
            </div>
            <div class="col-lg-6 d-flex align-items-center gradient-custom-2">
              <div class="text-black px-3 py-4 p-md-5 mx-md-4">
                <h4 class="mb-4">Control de pagos y reportes en pdf</h4>
                <p class="small mb-0">En este sistema puedes gestionar los pagos de los clientes por cada mes y
                    decargar un reporte en formato PDF.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
</body>
</html>