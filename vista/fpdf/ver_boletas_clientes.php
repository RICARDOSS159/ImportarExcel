<?php

	# Incluyendo librerias necesarias #
	require "./code128.php";
	include '../../modelo/conexion.php';
	// Evitar salida antes de generar el PDF
    ob_start();

	$servidor='localhost';
	$user='root';
	$contrasenia='';
	$database='sistema_pagos';

	$mysqli= mysqli_connect($servidor,$user,$contrasenia,$database) or die(mysqli_connect_error());

	// Obtener el ID del pago desde la solicitud GET
	$payment_id = isset($_POST['idpago']) ? $_POST['idpago'] : 0;

	//Query para buscar por id
	$BuscarxId="SELECT c.id, p.idpago,p.num_boleta,c.ruc,c.nombre,c.celular,c.direccion,p.tipo_pago,p.mes_correspon,p.monto
	FROM cliente as c INNER JOIN pagos as p on c.id=p.idcliente WHERE p.idpago=?";

	$stmt = $mysqli->prepare($BuscarxId);
	$stmt->bind_param("i", $payment_id);
	$stmt->execute();
	$resultado = $stmt->get_result();
	$payment = $resultado->fetch_assoc();


	// Obtener el número de recibo actual desde la base de datos
	$queryRecibo = "SELECT nro_recibo FROM recibo WHERE id = 1";
	$resultadoRecibo = $mysqli->query($queryRecibo);
	$row = $resultadoRecibo->fetch_assoc();
	$numero_recibo_actual = $row['nro_recibo'];

	

    // Obtener el número de recibo actual desde la base de datos
	$queryNumBoleta = "SELECT num_boleta FROM pagos WHERE idpago = ?";
	$campoBoleta = $mysqli->prepare($queryNumBoleta);
	$campoBoleta ->bind_param("i", $payment_id);
    $campoBoleta->execute();
    $numero_boleta=$campoBoleta->get_result();
    $boleta_recibida = $numero_boleta->fetch_assoc();
    $numero_recibo_estatico = $boleta_recibida['num_boleta'];

            // Verificar si num_boleta ya tiene un valor asignado
            if (empty($numero_recibo_estatico)) {
                // num_boleta está vacío, generar un nuevo número de boleta
                $queryMaxBoleta = "SELECT MAX(num_boleta) AS max_boleta FROM pagos";
                $resultMaxBoleta = $mysqli->query($queryMaxBoleta);
                $rowMaxBoleta = $resultMaxBoleta->fetch_assoc();
                $max_boleta = $rowMaxBoleta['max_boleta'];

                // Incrementar el número de boleta
                //$numero_recibo_nuevo = $max_boleta + 1;
                $numero_formateado = sprintf('%06d', $numero_recibo_actual);

                // Actualizar el número de boleta en la base de datos
                $queryActualizar = "UPDATE pagos SET num_boleta = ? WHERE idpago = ?";
                $stmtActualizar = $mysqli->prepare($queryActualizar);
                $stmtActualizar->bind_param("ii", $numero_recibo_actual, $payment_id);
                $stmtActualizar->execute();
                $stmtActualizar->close();

            } else {
                // num_boleta ya tiene un valor asignado
                $numero_formateado = sprintf('%06d', $numero_recibo_estatico);
            }

  

	$pdf = new PDF_Code128('P','mm','Letter');
	$pdf->SetMargins(17,17,17);
	$pdf->AddPage();

	# Logo de la empresa formato png #
	$pdf->Image('logodyf.png',10,12,100,35,'PNG');

	# Encabezado y datos de la empresa #
	$pdf->SetFont('Arial','B',16);
	$pdf->SetTextColor(32,100,210);
	$pdf->Cell(150,68,iconv("UTF-8", "ISO-8859-1",strtoupper("DYF CONTADORES & ABOGADOS")),0,0,'L');

// Definir el margen superior y derecho
$top_margin = 15; // Margen superior
$right_margin = 28; // Margen derecho

// Definir el ancho y la altura de los rectángulos
$width = 50; // Ancho del rectángulo
$height_text = 10; // Altura del rectángulo para el texto
$height_number = 10; // Altura del rectángulo para el número

// Calcular la posición X del rectángulo (ancho de la página - ancho del rectángulo - margen derecho)
$x = $pdf->GetPageWidth() - $right_margin - $width;
$y_text = $top_margin;

// Dibujar el rectángulo para "Recibo Nro."
$pdf->Rect($x, $y_text, $width, $height_text); // Rect(x, y, width, height) - Dibuja un rectángulo

// Posicionar el texto "Recibo Nro." dentro del rectángulo
$pdf->SetFont('Arial', 'B', 10);
$pdf->SetTextColor(39, 39, 51);
$pdf->SetXY($x, $y_text + 3); // Posiciona el cursor dentro del rectángulo
$pdf->Cell($width, $height_text, iconv("UTF-8", "ISO-8859-1", strtoupper("Recibo Nro.")), 0, 0, 'C'); // Ajusta la posición del texto según sea necesario

// Calcular la posición Y del rectángulo para el número
$y_number = $y_text + $height_text ; // Añadir un pequeño espacio entre los rectángulos

// Dibujar el rectángulo para el número de recibo
$pdf->Rect($x, $y_number, $width, $height_number); // Rect(x, y, width, height) - Dibuja un rectángulo

// Posicionar el número de recibo dentro del rectángulo
$pdf->SetXY($x, $y_number + 3); // Posiciona el cursor dentro del rectángulo
$pdf->Cell($width, $height_number, iconv("UTF-8", "ISO-8859-1", strtoupper($numero_formateado)), 0, 0, 'C'); // Ajusta la posición del texto según sea necesario
	

	$pdf->Ln(20);

	$pdf->SetFont('Arial','',10);
	$pdf->SetTextColor(39,39,51);
	$pdf->Cell(150,20,iconv("UTF-8", "ISO-8859-1","RUC: 20554526447"),0,0,'L');

	$pdf->Ln(5);

	$pdf->Cell(150,20,iconv("UTF-8", "ISO-8859-1","Calle las Camelias 657 - San Isidro"),0,0,'L');

	$pdf->Ln(7);

	$pdf->Cell(150,17,iconv("UTF-8", "ISO-8859-1","Teléfono: 970333599"),0,0,'L');

	//$pdf->Ln(5);

	//$pdf->Cell(150,9,iconv("UTF-8", "ISO-8859-1","Email: correo@ejemplo.com"),0,0,'L');

	$pdf->Ln(30);
    date_default_timezone_set('America/Lima');
    $hoy = date('Y-m-d');
     // Actualizar la fecha de emisión en la base de datos
     $queryActualizarFecha = "UPDATE pagos SET fecha_emision = ? WHERE idpago = ?";
     $stmtActualizarFecha = $mysqli->prepare($queryActualizarFecha);
     $stmtActualizarFecha->bind_param("si", $hoy, $payment_id);
     $stmtActualizarFecha->execute();
     $stmtActualizarFecha->close();

     // Obtener la fecha de emisión desde la base de datos
        $queryFechaEmision = "SELECT DATE_FORMAT(fecha_emision, '%d/%m/%Y') AS fecha_form_pago FROM pagos WHERE idpago = ?";
        $stmtFechaEmision = $mysqli->prepare($queryFechaEmision);
        $stmtFechaEmision->bind_param("i", $payment_id);
        $stmtFechaEmision->execute();
        $stmtFechaEmision->bind_result($hoy);
        $stmtFechaEmision->fetch();
        $stmtFechaEmision->close();



	$pdf->SetFont('Arial','',10);
	$pdf->Cell(30,0,iconv("UTF-8", "ISO-8859-1","Fecha de emisión:"),0,0,);
	$pdf->SetTextColor(97,97,97);
	$pdf->Cell(116,0,iconv("UTF-8", "ISO-8859-1",$hoy),0,0,'L');
	
	

	/*$pdf->Ln(7);

	$pdf->SetFont('Arial','',10);
	/*$pdf->Cell(12,7,iconv("UTF-8", "ISO-8859-1","Cajero:"),0,0,'L');
	$pdf->SetTextColor(97,97,97);
	$pdf->Cell(134,7,iconv("UTF-8", "ISO-8859-1","Carlos Alfaro"),0,0,'L');
	$pdf->SetFont('Arial','B',10);
	$pdf->SetTextColor(97,97,97);
	$pdf->Cell(170,7,iconv("UTF-8", "ISO-8859-1",strtoupper($numero_formateado)),0,0,'R');*/

	$pdf->Ln(10);

	$pdf->SetFont('Arial','',10);
	$pdf->SetTextColor(39,39,51);
	$pdf->Cell(18,7,iconv("UTF-8", "ISO-8859-1","Señor(es):"),0,0);
	$pdf->SetTextColor(97,97,97);
	$pdf->Cell(60,7,iconv("UTF-8", "ISO-8859-1",$payment['nombre']),0,0,'L');
	$pdf->SetTextColor(39,39,51);
	$pdf->Cell(10,7,iconv("UTF-8", "ISO-8859-1","RUC:"),0,0,'L');
	$pdf->SetTextColor(97,97,97);
	$pdf->Cell(60,7,iconv("UTF-8", "ISO-8859-1",$payment['ruc']),0,0,'L');
	$pdf->SetTextColor(39,39,51);
	$pdf->Cell(10,7,iconv("UTF-8", "ISO-8859-1","Telef:"),0,0,'L');
	$pdf->SetTextColor(97,97,97);
	$pdf->Cell(35,7,iconv("UTF-8", "ISO-8859-1",$payment['celular']),0,0);
	$pdf->SetTextColor(39,39,51);

	$pdf->Ln(7);

	$pdf->SetTextColor(39,39,51);
	$pdf->Cell(6,7,iconv("UTF-8", "ISO-8859-1","Direccion:"),0,0);
	$pdf->SetTextColor(97,97,97);
	$pdf->SetX(33);
	$pdf->Cell(0,7,iconv("UTF-8", "ISO-8859-1",$payment['direccion']),0,0);

	$pdf->Ln(20);

	# Tabla de productos #
	$pdf->SetFont('Arial','',8);
	$pdf->SetFillColor(21, 129, 191 );
	$pdf->SetDrawColor(21, 129, 191 );
	$pdf->SetTextColor(255,255,255);
	// Celda vacía para el margen izquierdo
$margin_left = 20; // Ajusta este valor para mover la tabla a la derecha
$pdf->Cell($margin_left, 8, '', 0, 0, 'C', false);
$pdf->Cell(94,8,iconv("UTF-8", "ISO-8859-1","Descripción"),1,0,'C',true);
$pdf->Cell(20,8,iconv("UTF-8", "ISO-8859-1","Cantidad"),1,0,'C',true);
//$pdf->Cell(25,8,iconv("UTF-8", "ISO-8859-1","Precio"),1,0,'C',true);
//$pdf->Cell(19,8,iconv("UTF-8", "ISO-8859-1","Desc."),1,0,'C',true);
$pdf->Cell(28,8,iconv("UTF-8", "ISO-8859-1","Importe"),1,0,'C',true);

$pdf->Ln(8);

$pdf->SetTextColor(39,39,51);

// Celda vacía para el margen izquierdo
$margin_left = 20; // Ajusta este valor para mover la tabla a la derecha
$pdf->Cell($margin_left, 7, '', 0, 0, 'C', false);
$total = 1 * $payment['monto'];

/*----------  Detalles de la tabla  ----------*/
$pdf->Cell(94,7,iconv("UTF-8", "ISO-8859-1","Pago de sistema de facturación $payment[tipo_pago] $payment[mes_correspon]"),1,0,'C');
$pdf->Cell(20,7,iconv("UTF-8", "ISO-8859-1","1"),1,0,'C');
//$pdf->Cell(25,7,iconv("UTF-8", "ISO-8859-1",$payment['monto']),'L',0,'C');
//$pdf->Cell(19,7,iconv("UTF-8", "ISO-8859-1","$0.00 USD"),'L',0,'C');
$pdf->Cell(28,7,iconv("UTF-8", "ISO-8859-1","$total.00"),1,0,'C');

$pdf->Ln(7);
/*----------  Fin Detalles de la tabla  ----------*/

$pdf->SetFont('Arial','B',9);



// Definir la posición y tamaño del cuadro
$boxX = $margin_left + 91 + 20; // Ajusta la posición en X
$boxY = $pdf->GetY(); // Ajusta la posición en Y
$boxWidth = 48; // Ancho del cuadro
$boxHeight = 10; // Altura del cuadro

// Dibujar el cuadro
$pdf->Rect($boxX, $boxY, $boxWidth, $boxHeight);

// Posicionar el texto dentro del cuadro
$pdf->SetXY($boxX, $boxY + 3); // Posiciona el cursor dentro del cuadro
$pdf->Cell($boxWidth, $boxHeight / 2, iconv("UTF-8", "ISO-8859-1", "TOTAL A PAGAR S/.$total.00"), 0, 2, 'C');
	
	$pdf->Ln(7);
	/*----------  Fin Detalles de la tabla  ----------*/


	
	$pdf->SetFont('Arial','B',9);
	
	# Impuestos & totales #
	/*$pdf->Cell(100,7,iconv("UTF-8", "ISO-8859-1",''),'T',0,'C');
	$pdf->Cell(15,7,iconv("UTF-8", "ISO-8859-1",''),'T',0,'C');
	$pdf->Cell(32,7,iconv("UTF-8", "ISO-8859-1","SUBTOTAL"),'T',0,'C');
	$pdf->Cell(34,7,iconv("UTF-8", "ISO-8859-1","+ $70.00 USD"),'T',0,'C');*/

	/*$pdf->Ln(7);

	$pdf->Cell(100,7,iconv("UTF-8", "ISO-8859-1",''),'',0,'C');
	$pdf->Cell(15,7,iconv("UTF-8", "ISO-8859-1",''),'',0,'C');
	$pdf->Cell(32,7,iconv("UTF-8", "ISO-8859-1","IVA (13%)"),'',0,'C');
	$pdf->Cell(34,7,iconv("UTF-8", "ISO-8859-1","+ $0.00 USD"),'',0,'C');*/
 

	/*$pdf->Ln(7);

	$pdf->Cell(100,7,iconv("UTF-8", "ISO-8859-1",''),'',0,'C');
	$pdf->Cell(15,7,iconv("UTF-8", "ISO-8859-1",''),'',0,'C');

	
	$pdf->Cell(34,7,iconv("UTF-8", "ISO-8859-1","$70.00 USD"),'T',0,'C');
	$pdf->Cell(22,7,iconv("UTF-8", "ISO-8859-1","TOTAL A PAGAR"),'T',0,'C');*/


$stmt->close();
$mysqli->close();

	/*$pdf->Ln(7);

	$pdf->Cell(100,7,iconv("UTF-8", "ISO-8859-1",''),'',0,'C');
	$pdf->Cell(15,7,iconv("UTF-8", "ISO-8859-1",''),'',0,'C');
	$pdf->Cell(32,7,iconv("UTF-8", "ISO-8859-1","TOTAL PAGADO"),'',0,'C');
	$pdf->Cell(34,7,iconv("UTF-8", "ISO-8859-1","$100.00 USD"),'',0,'C');

	$pdf->Ln(7);

	$pdf->Cell(100,7,iconv("UTF-8", "ISO-8859-1",''),'',0,'C');
	$pdf->Cell(15,7,iconv("UTF-8", "ISO-8859-1",''),'',0,'C');
	$pdf->Cell(32,7,iconv("UTF-8", "ISO-8859-1","CAMBIO"),'',0,'C');
	$pdf->Cell(34,7,iconv("UTF-8", "ISO-8859-1","$30.00 USD"),'',0,'C');

	$pdf->Ln(7);

	$pdf->Cell(100,7,iconv("UTF-8", "ISO-8859-1",''),'',0,'C');
	$pdf->Cell(15,7,iconv("UTF-8", "ISO-8859-1",''),'',0,'C');
	$pdf->Cell(32,7,iconv("UTF-8", "ISO-8859-1","USTED AHORRA"),'',0,'C');
	$pdf->Cell(34,7,iconv("UTF-8", "ISO-8859-1","$0.00 USD"),'',0,'C');*/

	/*$pdf->Ln(12);

	$pdf->SetFont('Arial','',9);

	$pdf->SetTextColor(39,39,51);
	$pdf->MultiCell(0,9,iconv("UTF-8", "ISO-8859-1","*** Precios de productos incluyen impuestos. Para poder realizar un reclamo o devolución debe de presentar esta factura ***"),0,'C',false);

	$pdf->Ln(9);

	# Codigo de barras #
	$pdf->SetFillColor(39,39,51);
	$pdf->SetDrawColor(23,83,201);
	$pdf->Code128(72,$pdf->GetY(),"COD000001V0001",70,20);
	$pdf->SetXY(12,$pdf->GetY()+21);
	$pdf->SetFont('Arial','',12);
	$pdf->MultiCell(0,5,iconv("UTF-8", "ISO-8859-1","COD000001V0001"),0,'C',false);*/

	# Nombre del archivo PDF #
	$pdf->Output("I","Boleta_Pago".$payment['nombre'].".pdf",true);