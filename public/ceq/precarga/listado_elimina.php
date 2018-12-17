<?php
session_start();
session_name($_SESSION['variables']['usuario']);
require_once('../config.php');
require_once ('../clases/class_Conexion.php');
require_once('../funciones/funciones.php');

if(isset($_POST)){
	$linea = $_POST['linea'];
	$datos = explode(",",$_POST['elimina']);
	$buque = $datos[0];
	$viaje = $datos[1];
	$sql = sprintf("DELETE FROM lista WHERE linea = %d AND buque = %d AND viaje = %d;",$linea,$buque,$viaje);
	$eliminar = new DBMySQL();
	$eliminar->Datosconexion(UDB,PDB,USERDB);
	$eliminar->Insertar($sql);
	if($eliminar->Afectados > 0){
		header("Location: listado.php?elimina=true");
	}else {
		die("<h1>ERROR</h1><p>No se pudo eliminar la lista indicada</p>");
	}
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title></title>
<link href="../css/estilo.css" rel="stylesheet" type="text/css">
</head>

<body>

</body>
</html>