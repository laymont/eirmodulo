<?php
session_start();
session_name($_SESSION['variables']['usuario']);
require_once("../config.php");
require_once("../clases/class_DbPoo.php");

$fixingINV = NULL;

/* Corregir fecha fdb '0000-00-00' (For Menfel 28/06/2016) */
	/* Chequear fecha fdb = '0000-00-00' */
	$fixInv = new DBsPOO();
	$fixInv->Conectar(UDB,PDB);
	$fixInv->SelectDB(USERDB);
	$SQLstr = "select * from inventario where fdb ='0000-00-00';";
	$fixInv->Consultar($SQLstr);
	if($fixInv->TotalResultados > 0){
		$fixInv->Liberar();
		$StrFixSQL = "UPDATE inventario, viajes SET inventario.fdb = viajes.eta WHERE inventario.fdb = '0000-00-00' AND inventario.viaje = viajes.id;";
		$fixInv->Actualizar($StrFixSQL);
		if($fixInv->Afectados > 0){
			$fixingINV = $fixInv->Afectados;
		}else {
			$viajeCheck = new DBsPOO();
			$viajeCheck->Conectar(UDB,PDB);
			$viajeCheck->SelectDB(USERDB);
			$SQLstr = "SELECT COUNT(*) AS `total` FROM viajes WHERE id IN(SELECT viaje FROM inventario WHERE fdb = '0000-00-00' AND `delete`= 0) AND eta = '0000-00-00';";
			$viajeCheck->Consultar($SQLstr);
			if($viajeCheck->TotalResultados > 0){
				$fixingINV = -2;
			}else {
				$fixingINV = -1;
			}
		}
	}else {
		//NO hay registros con fdb = '0000-00-00'
		$fixingINV = 0;
	}
echo $fixingINV;
$fixInv->Cerrar();
?>