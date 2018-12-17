<?php
session_start();
session_name($_SESSION['variables']['usuario']);
require_once('../config.php');
require_once('../clases/class_Conexion.php');

if(isset($_POST['elegido'])){
	$buque = $_POST['elegido'];
	$viajes = new DBMySQL();
	$viajes->Datosconexion(UDB,PDB,USERDB);
	$sql = sprintf("SELECT id, viaje FROM viajes WHERE activo = 0 AND buque = %d ORDER BY viaje DESC;",$buque);
	$viajes->Consulta($sql);
	echo "<option value=''>Seleccion</option>";
	do {
		echo "<option value=".$viajes->Filas['id'].">".$viajes->Filas['viaje']."</option>";
	}while($viajes->Filas = mysqli_fetch_assoc($viajes->Consulta));
	$viajes->Liberar();
}
?>