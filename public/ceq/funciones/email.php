<?php
session_start();
session_name($_SESSION['variables']['usuario']);
require_once('../config.php');
//function contenedorEliminado($numero){
	#Email->
	$destinos = "laymont@gmail.com";
	$sujeto = "AYAGUNA v2.0 - Reporte de Uso";
	$mensaje = "----------------------------------------------------"."\n";
	$mensaje .= "                   Reporte                          "."\n";
	$mensaje .= "---------------------------------------------------- "."\n";
	$mensaje .= "Fecha: ".AHORAC."\n";
	$mensaje .= "Usuario: ".$_SESSION['variables']['nombre'] ." ". $_SESSION['variables']['apellido']."\n";
	$mensaje .= "Se ha eliminado el siguiente registro: ".'MSKU1234565'."\n";
	$mensaje .= "---------------------------------------------------- "."\n";
	$mensaje .= "Mensaje generado automaticamente por AYAGUNA v2.0;"."\n"." por favor no responda este mensaje."."\n";
	$header = "From: soporte@appstc.net"."\r\n";
	mail($destinos,$sujeto,$mensaje,$header);
	#<-Email
//}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Documento sin título</title>
</head>

<body>
<pre>
<?php 
echo $mensaje;
?>
</pre>
</body>
</html>