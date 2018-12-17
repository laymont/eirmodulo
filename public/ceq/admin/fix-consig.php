<?php
session_start();
session_name($_SESSION['variables']['usuario']);
require_once("../config.php");
require_once("../clases/class_DbPoo.php");
/* Reparar consignatario duplicados */

set_time_limit(300);
/* Numero maximo de consultas + 1 */
$NumSQL = 11;

$duplicado = new DBsPOO();
$duplicado->Conectar(UDB,PDB);
$duplicado->SelectDB(USERDB);

$SQLstr ="SELECT id, nombre, COUNT(nombre) AS `total` FROM consignatario WHERE activo = 0 GROUP BY nombre HAVING COUNT(nombre) > 1;";
$duplicado->Consultar($SQLstr);

if($duplicado->TotalResultados > 0){
	while($duplicado->Resultados()){
		#Obtener id y nombre de los Consignatarios
		$nombre[] = $duplicado->Resultados['nombre'];	
		$SQLstr2[] = sprintf("SELECT id from consignatario where nombre = '%s';",$duplicado->Resultados['nombre']);
	}
	
	foreach($SQLstr2 as $index => $SQL){
		$i=0;
		$duplicado->Consultar($SQL);
		while($duplicado->Resultados()){
			$test[$index][$i++] = $duplicado->Resultados['id'];
			$test2[$index] = implode(",",$test[$index]);
			#Actualizar Tabla Consignatario
			$SQLstr3[$index] = sprintf("UPDATE consignatario SET activo = 1 WHERE id <> %d AND id IN(%s)",$test[$index][0],$test2[$index]);
			$SQLstrConsigDisable = implode(";",$SQLstr3).";";			
			$SQLstr4[$index] = sprintf("UPDATE inventario SET consignatario = %d WHERE consignatario IN(%s)",$test[$index][0],$test2[$index]);
			//$SQLstrUPDATEINV = implode(";",$SQLstr4).";";
		}
	}
			
}else {
	die(0);
}
if(count($SQLstr3) > $NumSQL){
	for($i=0;$i<$NumSQL;++$i){
		$consignatarios[$i] = $SQLstr3[$i];
		$inventario[$i] = $SQLstr4[$i];
	}
	$SQLstrConsigDisable = implode(";",$consignatarios).";";
	$SQLstrUPDATEINV = implode(";",$inventario).";";
	
	$fixConsig = new DBsPOO();
	$fixConsig->Conectar(UDB,PDB);
	$fixConsig->SelectDB(USERDB);
	$fixConsig->MultiConsultaUPDATE($SQLstrConsigDisable);
	
	
	$fixInv = new DBsPOO();
	$fixInv->Conectar(UDB,PDB);
	$fixInv->SelectDB(USERDB);
	$fixInv->MultiConsultaUPDATE($SQLstrUPDATEINV);
	
	
	$restan = new DBsPOO();
	$restan->Conectar(UDB,PDB);
	$restan->SelectDB(USERDB);
	$restan->Consultar($SQLstr);
	if($restan->TotalResultados > 0){
		echo "<pre>";
		echo "Aun hay Registros pendientes: ";
		print_r($restan->TotalResultados);
		echo "</pre>";
	}else {
		echo "<pre>";
		echo "Registros Actualizados: ";
		print_r( array_sum($fixConsig->Afectados) );
		echo "</pre>";
		
		echo "<pre>";
		echo "Registros Actualizados: ";
		print_r( array_sum($fixInv->Afectados) );
		echo "</pre>";
		
		echo "Correcciones pendientes: " . $restan->TotalResultados;
	}
	
}else {
	$SQLstrConsigDisable = implode(";",$SQLstr3).";";
	$SQLstrUPDATEINV = implode(";",$SQLstr4).";";
	
	$fixConsig = new DBsPOO();
	$fixConsig->Conectar(UDB,PDB);
	$fixConsig->SelectDB(USERDB);
	$fixConsig->MultiConsultaUPDATE($SQLstrConsigDisable);
	echo "<pre>";
	echo "Registros Actualizados: ";
	print_r( array_sum($fixConsig->Afectados) );
	echo "</pre>";
	
	$fixInv = new DBsPOO();
	$fixInv->Conectar(UDB,PDB);
	$fixInv->SelectDB(USERDB);
	$fixInv->MultiConsultaUPDATE($SQLstrUPDATEINV);
	echo "<pre>";
	echo "Registros Actualizados: ";
	print_r( array_sum($fixInv->Afectados) );
	echo "Correcciones pendientes: 0";
	echo "</pre>";
	
}

exit();
?>