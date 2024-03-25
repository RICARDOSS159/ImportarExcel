<?php
require('../modelo/conexion.php');
$tipo       = $_FILES['dataCliente']['type'];
$tamanio    = $_FILES['dataCliente']['size'];
$archivotmp = $_FILES['dataCliente']['tmp_name'];
$lineas     = file($archivotmp);

$i = 0;

foreach ($lineas as $linea) {
    $cantidad_registros = count($lineas);
    //Esto es pare cuando se agrega un titulo a cada dato
    $cantidad_regist_agregados =  ($cantidad_registros - 1);


    if ($i != 0) {

        $datos = explode(";", $linea);
       
        $ruc               = !empty($datos[0])  ? ($datos[0]) : '';
		$nombre            = !empty($datos[1])  ? ($datos[1]) : '';
        $celular           = !empty($datos[2])  ? ($datos[2]) : '';
       
if( !empty($ruc) ){
    $checkemail_duplicidad = ("SELECT ruc FROM cliente WHERE ruc='".($ruc)."' ");
            $ca_dupli = mysqli_query($mysqli, $checkemail_duplicidad);
            $cant_duplicidad = mysqli_num_rows($ca_dupli);
        }   

//No existe Registros Duplicados
if ( $cant_duplicidad == 0 ) { 

$insertarData = "INSERT INTO cliente( 
   ruc,
   nombre,
   celular
    
) VALUES(
    '$ruc',
    '$nombre',
    '$celular'
)";
mysqli_query($mysqli, $insertarData);
        
} 
/**Caso Contrario actualizo el o los Registros ya existentes*/
else{
    $updateData =  ("UPDATE cliente SET 
        ruc='" .$ruc. "',
		nombre='" .$nombre. "',
        celular='" .$celular. "'  
        WHERE ruc='".$ruc."'
    ");
    $result_update = mysqli_query($mysqli, $updateData);
    } 
  }

 $i++;
}

header("Location:../vista/subir.php");
?>
 