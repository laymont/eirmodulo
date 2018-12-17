<?php
session_start();
if(isset($_SESSION)){
	session_name($_SESSION['variables']['usuario']);
}

require_once('config.php');
require_once('clases/class_Conexion.php');
require_once('funciones/funciones.php');
require_once("clases/class_Seguridad.php");

echo '<pre>';
echo "Session Name: " . session_name();
var_dump($_SESSION);
var_dump(http_response_code());
var_dump(headers_sent());
echo '</pre>';
?>