<?php
session_start();
session_name($_SESSION['variables']['usuario']);
require_once('../config.php');
require_once('../clases/class_Conexion.php');

if(isset($_POST['linea']) and isset($_POST['buque'])){
	$idlinea = $_POST['linea'];
	$strbuque = $_POST['buque'];
	$buque = new DBMySQL();
	$buque->Datosconexion(UDB,PDB,USERDB);
	$sql = sprintf("SELECT id, nombre FROM buques WHERE activo = 0 AND nombre = '%s' AND linea = %d;",$strbuque, $idlinea);
	$buque->Consulta($sql);
	echo $buque->Num_resultados;
}
?>
