<?php
session_start();
session_name($_SESSION['variables']['usuario']);
require_once('../config.php');
require_once('../clases/class_DbPoo.php');

if( isset($_POST['submit']) && $_POST['submit'] == 'Registrar' ){
	#Verificar Contenedor
	$equipo = new DBsPOO();
	$equipo->Conectar(UDB,PDB);
	$equipo->SelectDB(USERDB);
	$strSQL = sprintf("SELECT id, contenedor, c FROM inventario WHERE contenedor ='%s' AND c = 0;",$_POST['equipo']);
	$equipo->Consultar($strSQL);
	
	if($equipo->TotalResultados > 0){
		/* Existe el contenedor */
		die('<h1>Error: <small>Contenedor en inventario</small></h1>');
	}
	
	/* No existe el contenedor */
	#Obtiene Fecha del viaje
	$idviaje = $_POST['viaje'];
	$arribo = new DBsPOO();
	$arribo->Conectar(UDB,PDB);
	$arribo->SelectDB(USERDB);
	$sql1 = sprintf("SELECT eta FROM viajes WHERE id = %d AND eta <> '0000-00-00';",$idviaje);
	$arribo->Consultar($sql1);
	
	if($arribo->TotalResultados == 0){
		/*Error con los datos del viaje*/
		die('<h1>Error: <small>Verifique los datos del viaje</small></h1>');
	}else {
		/*Se recupera la fecha del viaje*/
		$arribo->Resultados();
		$fdb = $arribo->Resultados['eta'];
	}
	
	#Verificar consignatario
	if( $_POST['consignatario'] == -1 ){
		$Nconsig = new DBsPOO();
		$Nconsig->Conectar(UDB,PDB);
		$Nconsig->SelectDB(USERDB);
		$nuevoConsig = trim(strtoupper($_POST['strcon']));
		$sql = sprintf("INSERT INTO `consignatario`(rif,nombre) VALUES('J-00000000-0','%s');",$nuevoConsig);
		$Nconsig->Registrar($sql);
		
		if($Nconsig->Afectados > 0){
			/*Se registro un nuevo consignatario*/
			$consignatario = $Nconsig->UltID;
		}else {
			/*No se pudo registrar el nuevo consignatario*/
			die("<h1>Error: <small>No se pudo registrar el nuevo consignatario.</small></h1>");
		}
		
	}else if( $_POST['consignatario'] > 0 ) {
		/*Si existe el consignatario*/
		$consignatario = $_POST['consignatario'];
	}else {
		/*Error consignatario*/
		die("<h1>Error consignatario</h1>");
	}
	/*echo $consignatario;
	die();*/
	#Registrar el nuevo contenedor
	$Newcontenedor = new DBsPOO();
	$Newcontenedor->Conectar(UDB,PDB);
	$Newcontenedor->SelectDB(USERDB);
	$sql2 = sprintf("INSERT INTO inventario(eir_r,fact,pase,linea,buque,viaje,contenedor,tcont,condicion,`status`,fdb,fdm,frd,`consignatario`,bl,patio,obs) VALUE(%d,%d,%d,%d,%d,%d,'%s',%d,%d,0,'%s','%s','%s',%d,'%s',%d,'%s');", $_POST['eir'],$_POST['factura'],$_POST['pase'],$_POST['linea'],$_POST['buque'],$_POST['viaje'],$_POST['equipo'],$_POST['tipo'],$_POST['condicion'],$fdb,$_POST['fdm'],$_POST['frd'],$consignatario,$_POST['bl'],$_POST['ubicacion'],$_POST['observacion']);
	$Newcontenedor->Registrar($sql2);
	if( $Newcontenedor->Afectados == 0 ){
		die("<h1>Error: <small>No se registro el contenedor.</small></h1>");
	}
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="Ayaguna, Control de Equipos">
<meta name="author" content="Laymont Arratia">
<meta http-equiv="refresh" content="5; URL=ingresos_vacios.php">
<title><?php echo VERSION; ?></title>
<!--Script-->
<script src="../bootstrap/js/bootstrap.min.js"></script>
<!--Css-->
<link rel="stylesheet" type="text/css" href="../bootstrap/css/bootstrap.min.css">
</head>

<body>
<div class="container-fluid">
 <div class="row">
  &nbsp;
 </div>
 <div class="row">
  <div class="col-sm-4 col-xs-offset-4">
   <div class="alert alert-success">
    <h1>Registro realizado</h1>
    <p>Espere sera redirigido en 5 seg.</p>
   </div>
  </div>
 </div>
</div>
</body>
</html>