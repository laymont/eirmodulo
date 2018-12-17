<?php
session_start();
session_name($_SESSION['variables']['usuario']);
require_once('../config.php');
require_once('../clases/class_DbPoo.php');
/* 
Para cambiar la fecha del viaje cuando se modifican los datos del contenedor 
datos_contenedor.php
*/

$eta = NULL;
if( isset($_POST['buque']) && isset($_POST['viaje']) ){
	$buque = $_POST['buque'];
	$viaje = $_POST['viaje'];
	$fecha = new DBsPOO(); //Fecha del viaje
	$fecha->Conectar(UDB,PDB);
	$fecha->SelectDB(USERDB);
	$SQLstr = sprintf("SELECT eta FROM viajes WHERE buque = %d AND id = %d AND activo = 0 ;",$buque,$viaje);
	$fecha->Consultar($SQLstr);
	if($fecha->TotalResultados > 0){
		$fecha->Resultados();
		$eta = $fecha->Resultados['eta'];
		echo $eta;
	}
}
?>