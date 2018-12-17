<?php
session_start();
session_name($_SESSION['variables']['usuario']);
require_once('../config.php');
require_once('../clases/class_Conexion.php');

$strConsig = $_GET['term'];
$resultado = new DBMySQL();
$resultado->Datosconexion(UDB,PDB,USERDB);
$resultado->Consulta("SELECT id, nombre FROM `consignatario` WHERE nombre LIKE '$strConsig%' ORDER BY nomre");

if($resultado->Num_resultados > 0){
	$datos = array();
	do{
		$id = utf8_encode($resultado->Filas['nombre']);
		$nombre = utf8_encode($resultado->Filas['nombre']);
		$datos[] = array('label'=>$nombre,'value'=>$id);
	}while ($resultado->Filas = mysqli_fetch_assoc($resultado->Consulta));
}

json_encode($datos);
//flush();
?>