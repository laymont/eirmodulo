<?php
session_start();
session_name($_SESSION['variables']['usuario']);
require_once('../config.php');
require_once('../clases/class_DbPoo.php');
require_once('../funciones/funciones.php');

if(isset($_POST['usuario'])){
	#Verificar si existe tarjeta de coordenadas
	$existe = new DBsPOO();
	$existe->Conectar('appstc','5G4eSBA~AEJ7');
	$existe->SelectDB('appstc_ayaguna_mastertable');
	$SQLstr = sprintf("SELECT * FROM coordenadas WHERE usuario = %d;",$_POST['usuario']);
	$existe->Consultar($SQLstr);

	if($existe->TotalResultados > 0){
		echo 1;
	}else {
		echo 0;
	}

}
?>