<?php
session_start();
session_name($_SESSION['variables']['usuario']);
require_once('../config.php');
require_once('../clases/class_Conexion.php');

$resultados = new DBMySQL;
$resultados->Datosconexion(UDB,PDB,USERDB);

if(isset($_GET['term'])){
	$query = $_GET['term'];
	$consulta = sprintf("SELECT id, nombre FROM consignatario WHERE nombre LIKE '%s%%' ORDER BY nombre LIMIT 0,10;",$query);
	$resultados->Consulta($consulta);
	$datos = array();
	do{
		$id = utf8_encode($resultados->Filas['id']);
		$nombre = utf8_encode($resultados->Filas['nombre']);
		$datos[] = array("label"=>$nombre,"value"=>$id);
	}while ($resultados->Filas = mysqli_fetch_assoc($resultados->Consulta));
}


/*echo "</pre>";*/
echo json_encode($datos);
?>