<?php
session_start();
session_name($_SESSION['variables']['usuario']);
require_once('../config.php');
require_once('../clases/class_Conexion.php');

if(isset($_POST['term'])){
	$term = $_POST['term'];
	$resultado = new DBMySQL();
	$resultado->Datosconexion(UDB,PDB,USERDB);
	
	/*$strQuery = "SELECT lista.id, lista.linea, buques.nombre AS buque, viajes.viaje, lista.equipo, 
					tequipos.tipo, consignatario.nombre AS `consignatario` FROM lista, consignatario, 
					tequipos, viajes, buques WHERE lista.consig = consignatario.id 
					AND lista.tipo = tequipos.id AND lista.viaje = viajes.id 
					AND lista.buque = buques.id AND lista.linea = 26 ORDER BY lista.id DESC;";*/
	
	$strQuery = sprintf("SELECT lista.id, lista.linea, buques.nombre AS buque, viajes.viaje, lista.equipo, 
					tequipos.tipo, consignatario.nombre AS `consignatario` FROM lista, consignatario, 
					tequipos, viajes, buques WHERE lista.consig = consignatario.id 
					AND lista.tipo = tequipos.id AND lista.viaje = viajes.id 
					AND lista.buque = buques.id AND lista.linea = %d ORDER BY lista.id DESC;",$term);
					
	$resultado->Consulta($strQuery);
	if($resultado->Num_resultados > 0){
		$datos = array();
		$i = 0;
		while($resultado->Filas = mysqli_fetch_array($resultado->Consulta)){
			$datos[$i] = $resultado->Filas;
			$i++;
		}
	}
}

echo json_encode($datos);

?>