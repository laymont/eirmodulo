<?php
session_start();
session_name($_SESSION['variables']['usuario']);
require_once('../config.php');
require_once('../clases/class_Conexion.php');
#Seguridad
$seguridad = new Seguridad();
$seguridad->ValidarUsuario();

if(isset($_POST)){
	#Verificar existencia
	$linea = $_POST['linea'];
	$buque = $_POST['buque'];
	$buscar = new DBMySQL();
	$buscar->Datosconexion(UDB,PDB,USERDB);
	$sql = sprintf("SELECT * FROM buques WHERE linea = %d and nombre = '%s' ORDER BY nombre;",$linea,$buque);
	$buscar->Consulta($sql);
	$datos = $buscar->Num_resultados;
}
echo json_encode($datos);
?>