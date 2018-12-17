<?php
session_start();
session_name($_SESSION['variables']['usuario']);
require_once ("../config.php");
require_once ("../clases/class_DbPoo.php");
require_once('../funciones/funciones.php');

$test = new DBsPOO();
$test->Conectar(UDB,PDB);
$test->SelectDB(USERDB);
$test->Consultar("SELECT * FROM existenciaNew;");
$test->ResultArray();

$misDatos = array();
 
while( $test->Resultados() ) {
	#Buscar en el array y cambiar el valor
	if( isset($test->Resultados['status']) ){
		$test->Resultados['status'] = Estatus2($test->Resultados['status']);
	}
	
	if( isset($test->Resultados['condicion'])){
		$test->Resultados['condicion'] = Condiciones2($test->Resultados['condicion']);
	}
	
	$misDatos[] = $test->Resultados;
}

//var_dump($misDatos[0]);

$salida = json_encode($misDatos);
$test->Liberar();
$test->Cerrar();
//var_dump($salida);
echo($salida);
?>