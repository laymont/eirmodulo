<?php
session_start();
session_name($_SESSION['variables']['usuario']);
require_once('../config.php');
require_once('../clases/class_Conexion.php');

if(isset($_POST['buque']) and isset($_POST['viaje']) and isset($_POST['fecha'])){
	$idbuque = $_POST['buque'];
	$strviaje = $_POST['viaje'];
	$fecha = $_POST['fecha'];
	$viaje = new DBMySQL();
	$viaje->Datosconexion(UDB,PDB,USERDB);
	$sql = sprintf("SELECT * FROM viajes WHERE buque = %d AND viaje = '%s' AND eta = '%s';",$idbuque, $strviaje, $fecha);
	$viaje->Consulta($sql);
	echo $viaje->Num_resultados;
}
?>
