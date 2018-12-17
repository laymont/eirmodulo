<?php

$viajes = new DBsPOO();
$viajes->Conectar(UDB,PDB);
$viajes->SelectDB(USERDB);
$SQLstr = "SELECT buques.nombre AS `buque`, viajes.viaje, viajes.eta AS `fecha` FROM viajes, buques WHERE viajes.id IN(SELECT viaje FROM inventario WHERE fdb = '0000-00-00' AND `delete`= 0) AND eta = '0000-00-00' AND viajes.buque = buques.id;";
$viajes->Consultar($SQLstr);

$invViaje = new DBsPOO();
$invViaje->Conectar(UDB,PDB);
$invViaje->SelectDB(USERDB);
$SQLstr = "SELECT id, contenedor, fdb,fdm, frd FROM inventario WHERE fdb = '0000-00-00' AND inventario.`delete` = 0;";
$invViaje->Consultar($SQLstr);

if($viajes->TotalResultados == 0 && $invViaje->TotalResultados == 0){
	$alerta = false;
}else {
	$alerta = true;
}

?>