<?php
session_start();
session_name($_SESSION['variables']['usuario']);
require_once('../config.php');
require_once('../clases/class_Conexion.php');


if(isset($_POST)){
	$nombre = $_POST['nombre'];
	$query = sprintf("SELECT id FROM consignatario WHERE nombre = '%s'",$nombre);
	$resultado = new DBMySQL();
	$resultado->Datosconexion(UDB,PDB,USERDB);
	$resultado->Consulta($query);
	$datos = $resultado->Num_resultados;
}

echo json_encode($datos);
?>