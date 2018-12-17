<?php
session_start();
session_name($_SESSION['variables']['usuario']);
require_once('../config.php');

#Seguridad
$seguridad = new Seguridad();
$seguridad->ValidarUsuario();

/* Datos del Contenedor */
if(isset($_GET['id'])){
  $id = $_GET['id'];
  $datos = new DBMySQL();
  $datos->Datosconexion(UDB,PDB,USERDB);
  $sql = sprintf("SELECT inventario.id, UPPER(inventario.contenedor) as contenedor, tequipos.tipo, inventario.frd, inventario.eir_r, inventario.`status`, inventario.condicion FROM inventario, tequipos WHERE inventario.id = %d and inventario.tcont = tequipos.id;",$id);
  $datos->Consulta($sql);
  $contenedor = $datos->Filas['contenedor'];
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="Ayaguna, Control de Equipos">
<meta name="author" content="Laymont Arratia">
<title><?php echo VERSION; ?></title>
<!--Script-->
<script src="../bootstrap/js/bootstrap.min.js"></script>
<!--Css-->
<link rel="stylesheet" type="text/css" href="../bootstrap/css/bootstrap.min.css">
</head>

<body>
<div class="container">
	<div class="row">&nbsp;</div>
    <div class="row">
    	<div class="col-sm-6 col-xs-offset-2">
        	<h1 class="text-info text-center">Contenedor eliminado</h1>
            <p class="text-warning text-center">La ventana se cerrara en 10 seg.</p>
        </div>
    </div>
</div>
</body>
<?php
#Email->
	$destinos = "laymont@gmail.com";
	$sujeto = "AYAGUNA v2.0 - Reporte de Uso";
	$mensaje = "----------------------------------------------------"."\n";
	$mensaje .= "                   Reporte                          "."\n";
	$mensaje .= "---------------------------------------------------- "."\n";
	$mensaje .= "Fecha: ".AHORAC."\n";
	$mensaje .= "Usuario: ".$_SESSION['variables']['nombre'] ." ". $_SESSION['variables']['apellido']."\n";
	$mensaje .= "Se ha eliminado el siguiente registro: ID: ". $_GET['id'] ." Contenedor: " . $contenedor. "\n";
	$mensaje .= "---------------------------------------------------- "."\n";
	$mensaje .= "Mensaje generado automaticamente por AYAGUNA v2.0;"."\n"." por favor no responda este mensaje."."\n";
	$header = "From: soporte@appstc.net;jnavarro@gonavi.com.ve"."\r\n";
	mail($destinos,$sujeto,$mensaje,$header);
#<-Email
?>
<SCRIPT>
setTimeout("window.close()",10000);
</SCRIPT>
</html>