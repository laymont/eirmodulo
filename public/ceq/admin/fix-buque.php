<?php
session_start();
session_name($_SESSION['variables']['usuario']);
require_once("../config.php");
require_once("../clases/class_DbPoo.php");
/* Reparar buques duplicados */
/*
Buscar nombre duplicados de buque de la misma linea,
buscar Viajes relacionados con el buque,
buscar registros en inventario vinculados con el buque.
*/

$duplicado = new DBsPOO();
$duplicado->Conectar(UDB,PDB);
$duplicado->SelectDB(USERDB);

$SQLstr ="SELECT id, linea, nombre from buques group by linea, nombre having count(nombre) > 1;";
$duplicado->Consultar($SQLstr);

if($duplicado->TotalResultados > 0){
	while($duplicado->Resultados()){
		#Buscar los ID de los buques y lineas en tabla BUQUES duplicados
		$Lineas[] = $duplicado->Resultados['linea'];
		$NombreBuques[] = $duplicado->Resultados['nombre'];
		
		$SQLstr2[] = sprintf("SELECT id from buques where nombre = '%s' AND linea = %d;",$duplicado->Resultados['nombre'],$duplicado->Resultados['linea']);
	}
	$SQLstrViajes = NULL;
	$SQLstrInventario = NULL;
	$SQLstrBUQUES = NULL;
	foreach($SQLstr2 as $index => $SQL){
		$i=0;
		$duplicado->Consultar($SQL);
		while($duplicado->Resultados()){
			$test[$index][$i++] = $duplicado->Resultados['id'];
			$test2[$index] = implode(",",$test[$index]);

			/*$SQLstrViajes .= sprintf("UPDATE viajes SET buque = %d WHERE buque IN(%s);",$test[$index][0],$test2[$index])."<br>";
			$SQLstrInventario .= sprintf("UPDATE inventario SET buque = %d WHERE buque IN(%s);",$test[$index][0],$test2[$index]);
			$SQLstrBUQUES .= sprintf("UPDATE buques SET activo = 1 WHERE nombre ='%s' AND linea = %d AND id <> %d;",$NombreBuques[$index],$Lineas[$index],$test[$index][0]);*/
			
			$SQLstr3[$index] = sprintf("UPDATE viajes SET buque = %d WHERE buque IN(%s);",$test[$index][0],$test2[$index]);
			$SQLstrViajes = implode(";",$SQLstr3).";";
			$SQLstr4[$index] = sprintf("UPDATE inventario SET buque = %d WHERE buque IN(%s);",$test[$index][0],$test2[$index]);
			$SQLstrInventario = implode(";",$SQLstr4).";";
			$SQLstr5[$index] = sprintf("UPDATE buques SET activo = 1 WHERE nombre ='%s' AND linea = %d AND id <> %d",$NombreBuques[$index],$Lineas[$index],$test[$index][0]);
			$SQLstrBUQUES = implode(";",$SQLstr5).";";

		}
	}
			
}else {
	echo 0;
}

$fixbuque = new DBsPOO();
$fixbuque->Conectar(UDB,PDB);
$fixbuque->SelectDB(USERDB);
$fixbuque->MultiConsultaUPDATE($SQLstrBUQUES . $SQLstrViajes . $SQLstrInventario); 
echo "<pre>";
echo "Registros Actualizados: ";
print_r( array_sum($fixbuque->Afectados) );
echo "</pre>";
exit();
?>