<?php 
session_start();
session_name($_SESSION['variables']['usuario']);
require_once('../config.php');
require_once('../clases/class_Conexion.php');
require_once('../funciones/funciones.php');
#Seguridad
$seguridad = new Seguridad();
$seguridad->ValidarUsuario();

if(isset($_GET['equipo'])){
	$equipo = $_GET['equipo'];
	$sql = sprintf("SELECT contenedor, c FROM inventario WHERE contenedor ='%s' AND c = 0;",$equipo);
	$equipo = new DBMySQL();
	$equipo->Datosconexion(UDB,PDB,USERDB);
	$equipo->Consulta($sql);
	$datos = $equipo->Num_resultados;
	if($datos > 0){
		http_response_code(418);
	}else {
		http_response_code(200); // no existe en inventario
	}
}
echo json_encode($datos);
?>