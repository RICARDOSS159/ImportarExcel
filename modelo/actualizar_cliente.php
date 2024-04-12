<?php
require('conexion.php');



$id=isset($_POST['id']);
$ruc=isset($_POST['ruc']);
$nombre=isset($_POST['nombre']);
$celular=isset($_POST['celular']);

$sqlActualizar="UPDATE cliente set ruc='$ruc',nombre='$nombre',celular='$celular' WHERE id='$id'";
$queryActualizar=mysqli_query($mysqli,$sqlActualizar);

if($queryActualizar){
   
};

?>