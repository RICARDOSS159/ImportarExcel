<?php

require('./fpdf.php');

class PDF extends FPDF
{

   // Cabecera de página
   function Header()
   {
      
      $this->Image('../logo.jpg', 170, 5, 20); //logo de la empresa,moverDerecha,moverAbajo,tamañoIMG
      $this->SetFont('Arial', 'B', 19); //tipo fuente, negrita(B-I-U-BIU), tamañoTexto
      $this->Cell(45); // Movernos a la derecha
      $this->SetTextColor(0, 0, 0); //color
      

      /* TITULO DE LA TABLA */
      //color
      $this->SetTextColor(21, 129, 191);
      $this->Cell(8); // mover a la derecha
      $this->SetFont('Arial', 'B', 15);
      $this->Cell(100, 10, utf8_decode("REPORTE DE CLIENTES DEUDORES"), 0, 1, 'C', 0);
      $this->Ln(7);

      /* CAMPOS DE LA TABLA */
      //color
      $this->SetFillColor(21, 129, 191); //colorFondo
      $this->SetTextColor(255, 255, 255); //colorTexto
      $this->SetDrawColor(163, 163, 163); //colorBorde
      $this->SetFont('Arial', 'B', 11);
      $this->Cell(18, 10, utf8_decode('N°'), 1, 0, 'C', 1);
      $this->Cell(28, 10, utf8_decode('RUC'), 1, 0, 'C', 1);
      $this->Cell(35, 10, utf8_decode('EMPRESA'), 1, 0, 'C', 1);
      $this->Cell(25, 10, utf8_decode('CELULAR'), 1, 0, 'C', 1);
      $this->Cell(40, 10, utf8_decode('FECHA DE INGRESO'), 1, 0, 'C', 1);
      $this->Cell(50, 10, utf8_decode('MESES QUE DEBE'), 1, 1, 'C', 1);
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

$pdf = new PDF();
$pdf->AddPage(); /* aqui entran dos para parametros (horientazion,tamaño)V->portrait H->landscape tamaño (A3.A4.A5.letter.legal) */
$pdf->AliasNbPages(); //muestra la pagina / y total de paginas

$i = 0;
$pdf->SetFont('Arial', '', 12);
$pdf->SetDrawColor(163, 163, 163); //colorBorde

$consulta_reporte_clientes = $mysqli->query("SELECT id, ruc, nombre,celular,direccion,fecha_activacion,fecha_tiempo_pendiente
FROM cliente WHERE estado_pago='Pago pendiente' and estado_cliente='Activo'");

while ($datos_reporte = $consulta_reporte_clientes->fetch_object()) {      
   // Suponiendo que $datos_reporte->fecha_activacion contiene la fecha en formato YYYY-MM-DD
$fecha_activacion = $datos_reporte->fecha_activacion;

// Formatear la fecha al formato "DD/MM/YYYY"
$fecha_formateada = date('d/m/Y', strtotime($fecha_activacion));
$i = $i + 1;
/* TABLA */
$pdf->Cell(18, 10, utf8_decode($i), 1, 0, 'C', 0);
$pdf->Cell(28, 10, utf8_decode($datos_reporte->ruc), 1, 0, 'C', 0);
$pdf->Cell(35, 10, utf8_decode($datos_reporte->nombre), 1, 0, 'C', 0);
$pdf->Cell(25, 10, utf8_decode($datos_reporte->celular), 1, 0, 'C', 0);
$pdf->Cell(40, 10, utf8_decode($fecha_formateada), 1, 0, 'C', 0);
$pdf->Cell(50, 10, utf8_decode($datos_reporte->fecha_tiempo_pendiente), 1, 1, 'C', 0);
}

$pdf->Output('Reporte_clientes_deudores.pdf', 'I');//nombreDescarga, Visor(I->visualizar - D->descargar)
