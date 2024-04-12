<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Actualizar Cliente</title>
    <link rel="stylesheet" type="text/css" href="../css/actualizar_cliente.css">
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
</head>
<body>

 <?php include('../modelo/conexion.php');
 include('../modelo/actualizar_cliente.php');



    // Obtener el ID del cliente de la URL
    $id = $_GET['id'];
    
    // Consulta para obtener los datos del cliente
    $sqlCliente = "SELECT * FROM cliente WHERE id = $id";
    $queryCliente = mysqli_query($mysqli, $sqlCliente);
    $data = mysqli_fetch_array($queryCliente);

    
    
        ?>
    <form action="subir.php" method="POST">
        <h3 class="Titulo">Actualizar cliente</h3>
        <input type="hidden" name="id" value="<?= $data['id']; ?>">
        <div class="Datos">
        <label for="">RUC</label>
        <input type="text" name="ruc" value="<?= $data['ruc']; ?>">
        <label for="">Nombre</label>
        <input type="text" name="nombre" value="<?= $data['nombre']; ?>">
        <label for="">Celular</label>
        <input type="text" name="celular" value="<?= $data['celular']; ?>">
        <input type="submit" class="btn btn-success"></input>
        </div>
    
    </form>
    
    
</body>
</html>