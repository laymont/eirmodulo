<?php
require('ean13.php');
date_default_timezone_set('America/Caracas');
session_start();

$pdf = new PDF('letter','portrait');
$pdf->selectFont('./fonts/Courier');
$pdf->ezSetCmMargins(1,1,1.5,1.5);
/////
$conexion = mysql_connect("localhost", "imssisc", "%analema.");
mysql_select_db("imssisc_overseas", $conexion);
//$impresion = $_SESSION['codbareir'];
//$eir_actual = $_SESSION['eir_actual'];
$pdf->EAN13(480,740,'1234556');
//QUERYS PARA CAPTURA DE TODOS LOS DATOS
/////
//ARRAY PARA EL EIR
$options = array(
				'shadeCol'=>array(0.9,0.9,0.9,0.9),
				'shadeCol2'=>array(0.8,0.8,0.8,0.8),
				'xOrientation'=>'center',
				'width'=>500,
				'fontSize'=>7,
				'rowGap' => 3
			);

$options2 = array(
				'shaded'=>0,
				'showLines'=>0,
				'xOrientation'=>'center',
				'width'=>500,
				'fontSize'=>8,
				'rowGap' => 3,
				'cols'=>array('VºBº'=>array('justification'=>'center'),'RECUADRO DEL EQUIPO ARRIBA ESPECIFICADO'=>array('justification'=>'center'))
			);

$data = array(
array('NUMERO DE CONTAINER'=>'Nº CONTENEDOR','ESTADO'=>'VALOR LLENO O VACIO','PASE DE SALIDA'=>'VALOR PASE DE SALIDA','Nº PRECINTO'=>'VALOR PRECINTO'));
$data2 = array(
array('NUMERO DE CHASIS   '=>'Nº CHASIS    ','ESTADO'=>'VALOR LLENO O VACIO','PUERTO        '=>'VALOR PUERTO        ','BOOKING    '=>'VALOR BOOKING '));
$data3 = array(
array('BUQUE'=>'BUQUE','VIAJE'=>'VIAJE','PUERTO'=>'PUERTO','HORA'=>'HORA','FECHA'=>'FECHA'));
$data4 = array(
array('<b>CLIENTE</b>'=>'CLIENTE','DIRECCION FINAL (DESTINO U ORIGEN EQUIPO)'=>'VALOR'));
$data5 = array(
array('TAMAÑO Y TIPO'=>'','AGENTE ADUANAL Y TELEFONO                                        '=>'VALOR'));
$data6 = array(
array(''=>'','TRANSPORTISTA '=>'VALOR'));
$data7 = array(
array('PESO           '=>' ','SOBRE PESO                  '=>' ','SOBRE ALTO           '=>' ','SOBRE LARGO  '=>' ','SOBRE ANCHO '=>' '));
$data8 = array(
array('CARGA PELIGROSA'=>' ','CALCOMANIA DE IDENTIFICACION'=>' ','FUNCIONAMIENTO GENSET'=>' ','BATERIA      '=>' ','GENSET HORAS'=>' '));
$data9 = array(array('CONDICIONES'=>''));
$data10 = array(array('VºBº'=>' ','RECUADRO DEL EQUIPO ARRIBA ESPECIFICADO'=>' '),
					  array('VºBº'=>' ','RECUADRO DEL EQUIPO ARRIBA ESPECIFICADO'=>' '),
					  array('VºBº'=>'AGENTE ADUANERO','RECUADRO DEL EQUIPO ARRIBA ESPECIFICADO'=>'AGENTE NAVIERO'));


$txttit = "<b>EIR</b>"."\n";
$txttit.= "<b>RECIBO DE INTERCAMBIO DE EQUIPO</b>\n";
$miopt = array('justification'=>'centre');
/////
$pdf->ezText($txttit, 17,$miopt);
$pdf->ezText("\n",10);
$pdf->ezTable($data,'','',$options);
$pdf->ezText("\n",2);
$pdf->ezTable($data2,'','',$options);
$pdf->ezText("\n",2);
$pdf->ezTable($data3,'','',$options);
$pdf->ezText("\n",2);
$pdf->ezTable($data4,'','',$options);
$pdf->ezText("\n",2);
$pdf->ezTable($data5,'','',$options);
$pdf->ezText("\n",2);
$pdf->ezTable($data6,'','',$options);
$pdf->ezText("\n",2);
$pdf->ezTable($data7,'','',$options);
$pdf->ezText("\n",1);
$pdf->ezTable($data8,'','',$options);
$pdf->ezText("\n",1);
$pdf->ezTable($data9,'','',$options);
$pdf->ezText("\n",1);
$pdf->ezTable($data10,'','',$options2);
$pdf->ezText("\n",1);
//$pdf->ezImage("imagen_eir.jpg", 0, 420);

//$txttit = "<b>BLOG.UNIJIMPE.NET</b>\n";
/*
$txttit = "<b>ACTA DE RECEPCION</b>"."\n";
$txttit.= "<b>OVERSEA</b>\n";
/////
$pdf->ezText($txttit, 15);
$pdf->ezText("\n",8);
/////
$pdf->ezText("<b>DATOS DEL CONDUCTOR</b>",13);
$pdf->ezText("<b>Conductor:</b> ".$row['nom_ape_chfer']."    "."<b>Cedula:</b> ".$row['cedula'],12)."\n";
$pdf->ezText("<b>Transporte:</b> ".$row['transporte']."    "."<b>Placa:</b> ".$row['placa'],12)."<br>";
$pdf->ezText("\n",8);
$pdf->ezText("<b>DATOS DE LA CARGA</b>",14)."\n";
$pdf->ezText("<b>Consignatario:</b> ".$row['consignatario'],12)."\n";
$pdf->ezText("<b>Linea:</b> ".$row['linea']."   "."<b>Buque:</b> ".$row['buque']."   "."<b>Viaje:</b> ".$row['viaje'],12)."\n";
$pdf->ezText("\n\n",8);
$pdf->ezText("<b>CONTENIDO:</b> ",15)."\n";
$pdf->ezText("\n",8);
$pdf->ezTable($data, $titles, '', $options);
$pdf->ezText("\n\n", 10);
$pdf->ezText("<b>Fecha:</b> ".date("d/m/Y"), 10);
$pdf->ezText("<b>Hora:</b> ".date("H:i:s")."\n\n", 10);
//////
*/
$pdf->stream();
?>