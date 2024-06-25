<?php

require('./fpdf.php');
setlocale(LC_TIME, 'spanish');
ob_end_clean();

class PDF extends FPDF
{

   // Cabecera de página
   function Header()
   {
      
      $this->Image('../logo.jpg', 185, 5, 20); //logo de la empresa,moverDerecha,moverAbajo,tamañoIMG
      $this->SetFont('Arial', 'B', 19); //tipo fuente, negrita(B-I-U-BIU), tamañoTexto
      $this->Cell(45); // Movernos a la derecha
      $this->SetTextColor(0, 0, 0); //color
    
      $ruc = $_POST['ruc'];
      $mes=isset($_POST['mes']) ? intval($_POST['mes']) : null;
      $anio=$_POST['anio'];
      $desde=$_POST['from_date'];
      $hasta=$_POST['to_date'];

      // Formatear la fecha al formato "DD/MM/YYYY"
      $fecha_form_desde = date('d/m/Y', strtotime($desde));
      $fecha_form_hasta = date('d/m/Y', strtotime($hasta));  

      if ($mes !== null && $mes >= 1 && $mes<= 12) {
         // Convertir el número del mes en su nombre correspondiente en español
         $mes_nombre = strftime("%B", mktime(0, 0, 0, $mes, 1));
     } else {
         $mes_nombre = ''; // Opcional: definir un valor predeterminado si el mes no está definido
     }
     $titulo="Reporte de pagos";
     if (!empty($desde) && !empty($hasta)) {
      $titulo .= " desde $fecha_form_desde hasta $fecha_form_hasta";
     }
     if(!empty($ruc)){
      $titulo .= " de $ruc";
     }
     if (!empty($mes_nombre) && !empty($anio)) {
      $titulo .= " de $mes_nombre $anio";
     }elseif (!empty($anio)) {
      $titulo .= " del año $anio";
     }
     
      /* TITULO DE LA TABLA */
      //color
      $this->SetTextColor(21, 129, 191);
      $this->Cell(8); // mover a la derecha
      $this->SetFont('Arial', 'B', 15);
      $this->Cell(70, 10, utf8_decode($titulo), 0, 1, 'C', 0);
      $this->Ln(7);

      /* CAMPOS DE LA TABLA */
      //color
      $this->SetFillColor(21, 129, 191); //colorFondo
      $this->SetTextColor(255, 255, 255); //colorTexto
      $this->SetDrawColor(163, 163, 163); //colorBorde
      $this->SetFont('Arial', 'B', 11);
      if ($ruc !== null && !empty($ruc)) {
        
         $this->Cell(18, 10, utf8_decode('N°'), 1, 0, 'C', 1);
         $this->Cell(35, 10, utf8_decode('FECHA DE PAGO'), 1, 0, 'C', 1); // Ajuste del ancho y alineación
         $this->Cell(28, 10, utf8_decode('MONTO'), 1, 0, 'C', 1); // Ajuste del ancho y alineación
         $this->Cell(45, 10, utf8_decode('METODO DE PAGO'), 1, 0, 'C', 1); // Ajuste del ancho y alineación
         $this->Cell(29, 10, utf8_decode('TIPO DE PAGO'), 1, 0, 'C', 1); // Ajuste del ancho y alineación
         $this->Cell(34, 10, utf8_decode('MES DE PAGO'), 1, 1, 'C', 1);
      }
      else{
      $this->Cell(18, 10, utf8_decode('N°'), 1, 0, 'C', 1);
      $this->Cell(40, 10, utf8_decode('EMPRESA'), 1, 0, 'C', 1);
      $this->Cell(28, 10, utf8_decode('MONTO'), 1, 0, 'C', 1);
      $this->Cell(35, 10, utf8_decode('FECHA DE PAGO'), 1, 0, 'C', 1);
      $this->Cell(29, 10, utf8_decode('TIPO DE PAGO'), 1, 0, 'C', 1);
      $this->Cell(34, 10, utf8_decode('MES DE PAGO'), 1, 1, 'C', 1);
      }
   }

   // Pie de página
   function Footer()
   {
      $this->SetY(-15); // Posición: a 1,5 cm del final
      $this->SetFont('Arial', 'I', 8); //tipo fuente, negrita(B-I-U-BIU), tamañoTexto
      $this->Cell(0, 10, utf8_decode('Página ') . $this->PageNo() . '/{nb}', 0, 0, 'C'); //pie de pagina(numero de pagina)

      $this->SetY(-15); // Posición: a 1,5 cm del final
      $this->SetFont('Arial', 'I', 8); //tipo fuente, cursiva, tamañoTexto
      $hoy = date('d/m/Y');
      $this->Cell(355, 10, utf8_decode($hoy), 0, 0, 'C'); // pie de pagina(fecha de pagina)
   }
}

include '../../modelo/conexion.php';
include '../../modelo/filtrar_mes.php';
$pdf = new PDF();
$pdf->AddPage(); /* aqui entran dos para parametros (horientazion,tamaño)V->portrait H->landscape tamaño (A3.A4.A5.letter.legal) */
$pdf->AliasNbPages(); //muestra la pagina / y total de paginas

$i = 0;
$pdf->SetFont('Arial', '', 12);
$pdf->SetDrawColor(163, 163, 163); //colorBorde

$ruc = isset($_POST['ruc']) ? $mysqli->real_escape_string($_POST['ruc']) : '';
$mes = isset($_POST['mes']) ? $mysqli->real_escape_string($_POST['mes']) : '';
$anio = isset($_POST['anio']) ? $mysqli->real_escape_string($_POST['anio']) : '';
$desde = isset($_POST['from_date']) ? $mysqli->real_escape_string($_POST['from_date']) : '';
$hasta=isset($_POST['to_date']) ? $mysqli->real_escape_string($_POST['to_date']) : '';

if (!empty($ruc) && !empty($desde) && !empty($hasta) && empty($anio) && empty($mes)) {
   $consulta_reporte_clientes=$mysqli->query("SELECT C.id, C.ruc, C.nombre, C.celular, P.idpago, P.fecha, P.monto, P.ruta_capturas,
   P.metodo_pago,P.tipo_pago,P.mes_correspon     
   FROM cliente AS C 
   INNER JOIN pagos AS P ON C.id = P.idcliente 
   WHERE C.ruc = '$ruc' and P.fecha BETWEEN '$desde' AND '$hasta' order by P.fecha ");


}elseif(!empty($ruc) && !empty($anio)&& empty($desde) && empty($hasta)&& empty($mes)){
   $consulta_reporte_clientes=$mysqli->query("SELECT C.id, C.ruc, C.nombre, C.celular, P.idpago, P.fecha, P.monto, P.ruta_capturas,
   P.metodo_pago,P.tipo_pago,P.mes_correspon     
   FROM cliente AS C 
   INNER JOIN pagos AS P ON C.id = P.idcliente 
   WHERE C.ruc = '$ruc' and YEAR(P.fecha)=$anio order by P.fecha ");

}elseif(!empty($desde) && !empty($hasta)&& empty($ruc) && empty($mes)&& empty($anio)){
   $consulta_reporte_clientes=$mysqli->query("SELECT C.id, C.ruc, C.nombre, C.celular, P.idpago, P.fecha, P.monto, P.ruta_capturas,
   P.metodo_pago,P.tipo_pago,P.mes_correspon     
   FROM cliente AS C 
   INNER JOIN pagos AS P ON C.id = P.idcliente 
   WHERE P.fecha BETWEEN '$desde' AND '$hasta' order by P.fecha ");

}elseif (!empty($anio) && empty($mes)) {
   // Si se proporciona una fecha, ejecuta la consulta para obtener los pagos realizados en esa fecha
   $consulta_reporte_clientes = $mysqli->query("SELECT C.id, C.ruc, C.nombre, P.idpago, P.fecha, P.monto, P.tipo_pago, P.metodo_pago,P.mes_correspon
    FROM cliente as C INNER JOIN pagos as P on C.id = P.idcliente
    WHERE YEAR(P.fecha)='$anio' order by C.nombre");
}elseif(!empty($anio) && !empty($mes) && empty($ruc)){
  $consulta_reporte_clientes=$mysqli->query("SELECT C.id, C.ruc, C.nombre, C.celular, P.idpago, P.fecha, P.monto, P.ruta_capturas,
 P.metodo_pago,P.tipo_pago,P.mes_correspon     
 FROM cliente AS C 
 INNER JOIN pagos AS P ON C.id = P.idcliente 
 WHERE MONTH(P.fecha) = $mes AND YEAR(P.fecha) =$anio");
 
}elseif(!empty($ruc) && empty($mes) && empty($anio)){
   $consulta_reporte_clientes = $mysqli->query("SELECT C.id, C.ruc, C.nombre, P.idpago, P.fecha, P.monto,
P.tipo_pago,P.metodo_pago,P.mes_correspon FROM cliente as C 
INNER JOIN pagos as P on C.id = P.idcliente
WHERE C.ruc='$ruc' and estado_cliente='Activo' order by P.fecha");
}else{
   $consulta_reporte_clientes=$mysqli->query("SELECT C.id, C.ruc, C.nombre, C.celular, P.idpago, P.fecha, P.monto, P.ruta_capturas,
   P.metodo_pago,P.tipo_pago,P.mes_correspon     
   FROM cliente AS C 
   INNER JOIN pagos AS P ON C.id = P.idcliente ORDER BY C.nombre");
}

if ($consulta_reporte_clientes->num_rows > 0) {
while ($datos_reporte = $consulta_reporte_clientes->fetch_object()) {      
   $fecha = $datos_reporte->fecha;

   // Formatear la fecha al formato "DD/MM/YYYY"
   $fecha_formateada = date('d/m/Y', strtotime($fecha));   
$i = $i + 1;
/* TABLA */
if ($ruc !== null && !empty($ruc)) {
$pdf->Cell(18, 10, utf8_decode($i), 1, 0, 'C', 0);
$pdf->Cell(35, 10, utf8_decode($fecha_formateada), 1, 0, 'C', 0);
$pdf->Cell(28, 10, utf8_decode($datos_reporte->monto), 1, 0, 'C', 0);
$pdf->Cell(45, 10, utf8_decode($datos_reporte->metodo_pago), 1, 0, 'C', 0);
$pdf->Cell(29, 10, utf8_decode($datos_reporte->tipo_pago), 1, 0, 'C', 0);
$pdf->Cell(34, 10, utf8_decode($datos_reporte->mes_correspon), 1, 1, 'C', 0);
}else{
$pdf->Cell(18, 10, utf8_decode($i), 1, 0, 'C', 0);
$pdf->Cell(40, 10, utf8_decode($datos_reporte->nombre), 1, 0, 'C', 0);
$pdf->Cell(28, 10, utf8_decode($datos_reporte->monto), 1, 0, 'C', 0);
$pdf->Cell(35, 10, utf8_decode($fecha_formateada), 1, 0, 'C', 0);
$pdf->Cell(29, 10, utf8_decode($datos_reporte->tipo_pago), 1, 0, 'C', 0);
$pdf->Cell(34, 10, utf8_decode($datos_reporte->mes_correspon), 1, 1, 'C', 0);
}
}

}else{
   $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(0, 10, utf8_decode('No se encontraron resultados'), 0, 1, 'C');
}



$pdf->Output('Reporte_clientes.pdf', 'I');//nombreDescarga, Visor(I->visualizar - D->descargar)

?>