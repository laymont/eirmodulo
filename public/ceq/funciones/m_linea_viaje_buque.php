<?php
session_start();
session_name($_SESSION['variables']['usuario']);
#Funcion Menu 3 niveles
require_once('../clases/class_Conexion.php');
#MenuLineas
function MLineas(){
	$lineas = new DBMySQL();
	$lineas->Datosconexion(UDB,PDB,USERDB);
	$sql = "SELECT id, nombre AS linea FROM lineas WHERE activo = 0 ORDER BY nombre;";
	$lineas->Consulta($sql);
	if($lineas->Num_resultados > 0){
		echo "<label for='linea'>Lineas: </label>";
		echo "<select name='linea' id='linea' required='required'>";
		echo "<option value='-1'>Seleccion</option>";
		do {
			echo "<option value='". $lineas->Filas['id'] ."'>". $lineas->Filas['linea'] ."</option>";
		} while ($lineas->Filas = mysqli_fetch_assoc($lineas->Consulta));
		echo "</select>";
	}
}

function MBuques($varLinea){
	$buques = new DBMySQL();
	$buques->Datosconexion(UDB,PDB,USERDB);
	$sql = sprintf("SELECT id, nombre AS buque FROM buques WHERE activo = 0 and nombre REGEXP '[[:alnum:]_[:digit:]]{1,50}' AND linea = %d ORDER BY nombre ASC;",$varLinea);
	$buques->Consulta($sql);
	if($buques->Num_resultados > 0){
		echo "<label for='buque'>Lineas: </label>";
		echo "<select name='buque' id='buque' required='required'>";
		echo "<option value='-1'>Seleccion</option>";
		do {
			echo "<option value='". $buques->Filas['id'] ."'>". $buques->Filas['linea'] ."</option>";
		} while ($buques->Filas = mysqli_fetch_assoc($buques->Consulta));
		echo "</select>";
	}
}
?>
