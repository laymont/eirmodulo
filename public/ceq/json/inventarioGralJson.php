<?php
session_start();
session_name($_SESSION['variables']['usuario']);
require_once('../config.php');
require_once('../clases/class_Conexion.php');
require_once('../funciones/funciones.php');
#Seguridad
$seguridad = new Seguridad();
$seguridad->ValidarUsuario();

/*Inventaro Json*/
if($_SESSION['variables']['nivel'] != 6){
	$inventario = new DBMySQL();
	$inventario->Datosconexion(UDB,PDB,USERDB);
	$cadenaSQL = "SELECT * FROM existenciaNew;";
	$inventario->Consulta($cadenaSQL);
	do{
		
		$datos[] = array($inventario->Filas);
		
	}while($inventario->Filas = mysqli_fetch_assoc($inventario->Consulta));
	
}else {
	$idLinea = $_SESSION['variables']['linea'];
	$linea = new DBMySQL();
	$linea->DatosConexion(UDB,PDB,USERDB);
	$sql = sprintf("SELECT nombre FROM lineas WHERE id = %d", $idLinea);
	$linea->Consulta($sql);
	$linea->Filas['nombre'];
	
	$inventario = new DBMySQL();
	$inventario->Datosconexion(UDB,PDB,USERDB);
	$cadenaSQL = sprintf("SELECT * FROM existenciaNew WHERE linea = '%s';",$linea->Filas['nombre']);
	$inventario->Consulta($cadenaSQL);
	do{
		
		$datos[] = array($inventario->Filas);
		
	}while($inventario->Filas = mysqli_fetch_assoc($inventario->Consulta));
	
}

echo json_encode($datos);

?>