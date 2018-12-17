<?php
session_start();
session_name($_SESSION['variables']['usuario']);
require_once('../config.php');
require_once('../clases/class_Conexion.php');

$strCon = $_GET['term'];
$resultado = new DBMySQL();
$resultado->Datosconexion(UDB,PDB,USERDB);
$resultado->Consulta("SELECT id, contenedor FROM inventario WHERE contenedor LIKE '%$strCon%' ORDER BY contenedor");

if($resultado->Num_resultados > 0){
	$datos = array();
	do{
		$contenedor = utf8_encode($resultado->Filas['contenedor']);
		$id = utf8_encode($resultado->Filas['id']);
		$datos[] = array('label'=>$contenedor, 'value' =>$id);
	}while ($resultado->Filas = mysqli_fetch_assoc($resultado->Consulta));
}

echo json_encode($datos);
//flush();
?>