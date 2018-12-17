<?php 
session_start();
session_name($_SESSION['variables']['usuario']);
require_once ('../../config.php');
require_once ('../../clases/class_Conexion.php');
require_once ('../Classes/PHPExcel/IOFactory.php');

if(!isset($_SESSION['up'])){
	$_SESSION['up'] = false;
}
$validate = 0;
	
# Linea
$lineaprecarga = new DBMySQL();
$lineaprecarga->Datosconexion(UDB,PDB,USERDB);
$lineaprecarga->Consulta("SELECT linea FROM precarga LIMIT 1;");
$NomLinea = $lineaprecarga->Filas['linea'];

$linea = new DBMySQL();
$linea->Datosconexion(UDB,PDB,USERDB);
$linea->Consulta(sprintf("SELECT id FROM lineas WHERE nombre = '%s';",$NomLinea));
if($linea->Num_resultados > 0){
	$idlinea = $linea->Filas['id'];
	$validate = $validate + 1;
}else {
	die("<h1>No se puede transformar los datos:|:Error-Linea</h1>Comuniquese con el Administrador del Sistema");
}

# Buque
$buqueprecarga = new DBMySQL();
$buqueprecarga->Datosconexion(UDB,PDB,USERDB);
$buqueprecarga->Consulta("SELECT buque FROM precarga LIMIT 1;");
$NomBuque = $buqueprecarga->Filas['buque'];

$buque = new DBMySQL();
$buque->Datosconexion(UDB,PDB,USERDB);
$buque->Consulta(sprintf("SELECT id FROM buques WHERE linea = %d AND nombre = '%s';",$idlinea,$NomBuque));

if($buque->Num_resultados > 0){
	$idbuque = $buque->Filas['id'];
	$validate = $validate + 1;
}else {
	die("<h1>No se puede transformar los datos:|:Error-Buque</h1>Comuniquese con el Administrador del Sistema");
}

# Viaje
$viajeprecarga = new DBMySQL();
$viajeprecarga->Datosconexion(UDB,PDB,USERDB);
$viajeprecarga->Consulta("SELECT buque, viaje FROM precarga LIMIT 1;");
$NomViaje = $viajeprecarga->Filas['viaje'];

$viaje = new DBMySQL();
$viaje->Datosconexion(UDB,PDB,USERDB);
$viaje->Consulta(sprintf("SELECT id FROM viajes WHERE buque = %d AND viaje = '%s'",$idbuque,$NomViaje));

if($viaje->Num_resultados > 0){
	$idviaje = $viaje->Filas['id'];
	$validate = $validate + 1;
}else {
	die("<h1>No se puede transformar los datos:|:Error-Viaje</h1>Comuniquese con el Administrador del Sistema");
}

if($validate == 3){
	$precarga = new DBMySQL();
	$precarga->Datosconexion(UDB,PDB,USERDB);
	$Qprecarga = sprintf("UPDATE precarga SET linea = %d, buque = %d, viaje = %d",$idlinea,$idbuque,$idviaje);
	$precarga->Insertar($Qprecarga);
	
	if($precarga->Afectados > 0){
		$normaliza = new DBMySQL();
		$normaliza->Datosconexion(UDB,PDB,USERDB);
		$normaliza->Procedimiento("CALL normalizaPrecarga();");
		
		$listar = new DBMySQL();
		$listar->Datosconexion(UDB,PDB,USERDB);
		$listar->Procedimiento("CALL precarga_limpia();");
		
		$borrar = new DBMySQL();
		$borrar->Datosconexion(UDB,PDB,USERDB);
		$borrar->Vaciar("precarga");
		
		$_SESSION['up'] = true;
		$vinculo = sprintf("Location: ../fin.php?b=%d&v=%d",$idbuque,$idviaje);
		header($vinculo);
		
	}else {
		die("<h1>No se pudo actualizar la precarga</h1>");
	}
}else {
	die("<h1>No se pudo actualizar la precarga</h1>");
}

?>