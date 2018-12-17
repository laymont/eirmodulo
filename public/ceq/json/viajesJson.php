<?php
session_start();
session_name($_SESSION['variables']['usuario']);
require_once('../config.php');
require_once('../clases/class_Conexion.php');
#Seguridad
$seguridad = new Seguridad();
$seguridad->ValidarUsuario();

if(isset($_POST)){
	$strBuque = $_POST['buque'];
	$strViaje = $_POST['viaje'];
	$viajesJson = new DBMySQL();
	$viajesJson->Datosconexion(UDB,PDB,USERDB);
	$queryStr = sprintf("SELECT id, buque, viaje, eta FROM viajes WHERE buque = %d and viaje = %d;",$strBuque, $strViaje);
	$viajesJson->Consulta($queryStr);
	$datos = $viajesJson->Num_resultados;
}
echo json_encode($datos);
?>