<?php
session_start();
session_name($_SESSION['variables']['usuario']);
require_once('../config.php');
require_once('../clases/class_Conexion.php');

$strCon = $_GET['term'];
$resultado = new DBMySQL();
$resultado->Datosconexion(UDB,PDB,USERDB);
$resultado->Consulta("SELECT contenedor FROM existencianew WHERE contenedor LIKE '%$strCon%' ORDER BY contenedor");

$datos = $resultado->Num_resultados;
echo json_encode($datos);
//flush();
?>