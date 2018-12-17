<?php
session_start();
session_name($_SESSION['variables']['usuario']);
require_once('../config.php');
require_once('../clases/class_Conexion.php');

if(isset($_POST)){
	$str = $_POST['cadena'];
	$nombre = new DBMySQL();
	$nombre->Datosconexion(UDB,PDB,USERDB);
	$sql = sprintf("SELECT id, nombre FROM `consignatario` WHERE nombre LIKE '%s%%';",$str);
	$nombre->Consulta($sql);
	$datos = array();
	do{
		$datos[] = array("id" => $nombre->Filas['id'], "nombre" => $nombre->Filas['id']);
	}while ($nombre->Filas = mysqli_fetch_assoc($nombre->Consulta));
}
?>