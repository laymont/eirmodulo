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
$qry = "SELECT eir_contenedor, eir_estado, eir_pase_salida, eir_precinto FROM eir WHERE ideir = '0000000001'";
$exe = mysql_query($qry, $conexion) or die(mysql_error());
$row = mysql_fetch_assoc($exe);

//ARRAY DE DATOS PARA EL EIR
$ixx = 0;
while($datatmp = mysql_fetch_assoc($exe)) { 
	$ixx = $ixx+1;
	$data[] = array_merge($datatmp, array('num'=>$ixx));
}
$titles = array(
				'eir_contenedor'=>'<b>B/L</b>',
				'eir_estado'=>'<b>Embalaje</b>',
				'eir_pase_salida'=>'<b>Contenido</b>',
				'eir_precinto'=>'<b>Estado</b>'
			);
$options = array(
				'shadeCol'=>array(0.9,0.9,0.9,0.9),
				'xOrientation'=>'center',
				'width'=>500
			);
/*
$linea2 = array(
				'eir_num_chasis'=>'<b>Nº DE CHASIS</b>',
				'eir_chasisestado'=>'<b>ESTADO</b>',
				'eir_BL'=>'<b>B/L</b>',
				'eir_booking'=>'<b>BOOKING</b>'
			);

$linea3 = array(
				'eir_buque'=>'<b>Nº DE CHASIS</b>',
				'eir_viaje'=>'<b>ESTADO</b>',
				'eir_puerto'=>'<b>B/L</b>',
				'eir_hora'=>'<b>BOOKING</b>',
				'eir_fecha'=>'<b>FECHA</b>'
			);

$linea4 = array(
				'eir_cliente'=>'<b>CLIENTE</b>',
				'eir_dir_final'=>'<b>DIRECCION FINAL (DESTINO U ORIGEN EQUIPO)</b>'
			);
*/
//ARRAY DE OPCIONES PARA EL EIR
$options = array(
				'shadeCol'=>array(0.9,0.9,0.9,0.9),
				'xOrientation'=>'center',
				'width'=>500,
				'fontSize'=>7
			);
$miopt = array('justification'=>'centre');

$txttit = "<b>EIR</b>"."\n";
$txttit.= "<b>RECIBO DE INTERCAMBIO DE EQUIPO</b>\n";

/////
$pdf->ezText($txttit, 17,$miopt);
$pdf->ezText("\n",10);
$pdf->ezTable($data, $titles, '', $options);


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