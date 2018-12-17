<?php
session_start();
session_name($_SESSION['variables']['usuario']);
require_once('../config.php');
require_once('../clases/class_Conexion.php');

if(isset($_POST['elegido'])){
	$linea = $_POST['elegido'];
	$buques = new DBMySQL();
	$buques->Datosconexion(UDB,PDB,USERDB);
	$sql = sprintf("SELECT id, nombre FROM buques WHERE activo = 0 AND nombre !='' AND linea = %d ORDER BY nombre ASC;",$linea);
	$buques->Consulta($sql);
	echo "<option>Seleccion</option>";
	do {
		echo "<option value=".$buques->Filas['id'].">".$buques->Filas['nombre']."</option>";
	}while($buques->Filas = mysqli_fetch_assoc($buques->Consulta));
	$buques->Liberar();
}
?>