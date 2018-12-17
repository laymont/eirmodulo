<?php
session_start();
session_name($_SESSION['variables']['usuario']);
require_once('../config.php');
require_once('../clases/class_Conexion.php');

$resultado = new DBMySQL();
$resultado->Datosconexion(UDB,PDB,USERDB);
$resultado->Consulta("SELECT id, rif, nombre, libre, pcontacto, email, telf FROM consignatario ORDER BY nombre;");

if($resultado->Num_resultados > 0){
	$datos = array();
	do{
		$id = utf8_encode($resultado->Filas['id']);
		$rif = utf8_encode($resultado->Filas['rif']); ;
		$nombre = utf8_encode($resultado->Filas['nombre']);
		$libre = utf8_encode($resultado->Filas['libre']);;
		$pcontacto = utf8_encode($resultado->Filas['pcontacto']);;
		$email = utf8_encode($resultado->Filas['email']);;
		$telf = utf8_encode($resultado->Filas['telf']);;
		
		$datos[] = array("id"=>$id,"rif"=>$rif,"nombre"=>$nombre,"libre"=>$libre,"pcontacto"=>$pcontacto,"email"=>$email,"telf"=>$telf);
		
	}while ($resultado->Filas = mysqli_fetch_assoc($resultado->Consulta));
}

echo json_encode($datos);


?>