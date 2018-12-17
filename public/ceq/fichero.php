<?php
session_start();
session_name($_SESSION['variables']['usuario']);
require_once('config.php');
require_once('clases/class_Conexion.php');

$lista = new DBMySQL();
$lista->Datosconexion(UDB,PDB,USERDB);
$lista->Consulta("SELECT contenedor FROM inventario WHERE `delete` = 0 ORDER BY contenedor ASC LIMIT 0,50;");

$rawdata = array();
while($lista->Filas = mysqli_fetch_array($lista->Consulta)){
	$i++;
	$rawdata[$i] = $lista->Filas;
}

echo $json = json_encode($rawdata);
?>