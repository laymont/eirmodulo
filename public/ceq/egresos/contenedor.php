<?php 
session_start();
session_name($_SESSION['variables']['usuario']);
require_once('../config.php');
require_once('../clases/class_Conexion.php');
require_once('../funciones/funciones.php');

if(isset($_POST['contenedor'])){
	$equipo = $_POST['contenedor'];
	$sql = sprintf("SELECT contenedor, c FROM inventario WHERE contenedor ='%s';",$equipo);
	$equipo = new DBMySQL();
	$equipo->Datosconexion(UDB,PDB,USERDB);
	$equipo->Consulta($sql);
	echo $equipo->Num_resultados;
}
?>