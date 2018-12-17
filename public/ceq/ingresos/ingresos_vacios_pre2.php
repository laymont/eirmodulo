<?php
session_start();
session_name($_SESSION['variables']['usuario']);

require_once('../config.php');
require_once('../clases/class_Conexion.php');
require_once('../funciones/funciones.php');
#Mostrar errores
// Motrar todos los errores de PHP
error_reporting(E_ALL);
#Mostrar errores
#Seguridad
$seguridad = new Seguridad();
$seguridad->ValidarUsuario();

if(isset($_POST)){
	$idpre = $_POST['id'];
	$precarga = new DBMySQL();
	$precarga->Datosconexion(UDB,PDB,USERDB);
	$sql = sprintf("SELECT lista.id, lista.linea, lista.buque, lista.viaje, viajes.eta, lista.equipo, lista.tipo, lista.bl, lista.consig FROM lista, viajes WHERE lista.viaje = viajes.id AND lista.id = %d;",$idpre);
	$precarga->Consulta($sql);
	
	#fecha viaje
	$eta = new DBMySQL();
	$eta->Datosconexion(UDB,PDB,USERDB);
	$sql = sprintf("SELECT eta FROM viajes WHERE id = %d;",$precarga->Filas['viaje']);
	$eta->Consulta($sql);
	
	#Ingres 2016-07-13
	$ingreso = new DBMySQL();
	$ingreso->Datosconexion(UDB,PDB,USERDB);
	$sql = sprintf("INSERT INTO inventario(linea,buque,viaje,fdb,contenedor,tcont,`status`,condicion,eir_r,bl,fact,pase,fdm,frd,consignatario,patio,obs,c)
		 VALUES(%d,%d,%d,'%s','%s',%d,%d,%d,%d,'%s',%d,%d,'%s','%s','%s',%d,'%s',0);",
		 $precarga->Filas['linea'],
		 $precarga->Filas['buque'],
		 $precarga->Filas['viaje'],
		 $eta->Filas['eta'],
		 $precarga->Filas['equipo'],
		 $precarga->Filas['tipo'],
		 0,
		 $_POST['condicion'],
		 $_POST['eir'],
		 $precarga->Filas['bl'],
		 $_POST['factura'],
		 $_POST['pase'],
		 $_POST['fdm'],
		 $_POST['frd'],
		 $precarga->Filas['consig'],
		 $_POST['ubicacion'],
		 $_POST['observacion'],
		 0);
		 if( $ingreso->Insertar($sql) ){
			 header('Location: ../inicio.php');
		 }else {
			 die('<h1>Error</h1><p>No se pudo realizar el ingreso</p>');
		 }
}

?>