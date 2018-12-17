<?php
session_start();
session_name($_SESSION['variables']['usuario']);
/* Consulta de viaje para verificar que la FDM sea mayor que el atraque del buque */
require_once('../config.php');
require_once('../clases/class_Conexion.php');
#Seguridad
$seguridad = new Seguridad();
$seguridad->ValidarUsuario();

if( isset($_POST['buque']) and isset($_POST['viaje']) ){
	$strBuque = $_POST['buque'];
	$strViaje = $_POST['viaje'];
	$viajesJson = new DBMySQL();
	$viajesJson->Datosconexion(UDB,PDB,USERDB);
	$queryStr = sprintf("SELECT id, viaje, eta FROM viajes WHERE buque = %d and id = %d;",$strBuque, $strViaje);
	$viajesJson->Consulta($queryStr);
	$datos = $viajesJson->Filas['eta'];


}
echo json_encode($datos);

?>