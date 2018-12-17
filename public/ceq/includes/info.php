<?php 
session_start();
session_name($_SESSION['variables']['usuario']);
require_once(RAIZ ."config.php");
require_once(CLASES . "class_Conexion.php");

if($_SESSION['variables']['nivel'] != 6){
	
	#Lineas
	$resumenL = new DBMySQL();
	$resumenL->Datosconexion(UDB,PDB,USERDB);
	$resumenL->Consulta("select linea, count(*) AS cantidad from existenciaNew group by linea order by linea ASC;");
	
	#Resumen linea, tipos
	$resumenLT = new DBMySQL();
	$resumenLT->Datosconexion(UDB,PDB,USERDB);
	$sql = "SELECT existenciaNew.linea, existenciaNew.tipo, COUNT(*) as cantidad FROM existenciaNew GROUP BY existenciaNew.linea, existenciaNew.tipo ORDER BY existenciaNew.linea ASC, existenciaNew.tipo ASC;";
	$resumenLT->Consulta($sql);
	
	#Resumen tipos
	$resumenT = new DBMySQL();
	$resumenT->Datosconexion(UDB,PDB,USERDB);
	$sql = "SELECT tipo, COUNT(*) AS cantidad FROM existenciaNew GROUP BY tipo ORDER BY tipo ASC;";
	$resumenT->Consulta($sql);
} else {
	$idLinea = $_SESSION['variables']['linea'];
	$linea = new DBMySQL();
	$linea->DatosConexion(UDB,PDB,USERDB);
	$sql = sprintf("SELECT nombre FROM lineas WHERE id = %d", $idLinea);
	$linea->Consulta($sql);
	
	#Lineas
	$resumenL = new DBMySQL();
	$resumenL->Datosconexion(UDB,PDB,USERDB);
	$sql = sprintf("SELECT linea, count(*) AS cantidad from existenciaNew WHERE linea = '%s' group by linea order by linea ASC;", $linea->Filas['nombre']);
	$resumenL->Consulta($sql);
	
	#Resumen linea, tipos
	$resumenLT = new DBMySQL();
	$resumenLT->Datosconexion(UDB,PDB,USERDB);
	$sql = sprintf("SELECT existenciaNew.linea, existenciaNew.tipo, COUNT(*) as cantidad FROM existenciaNew WHERE linea = '%s' GROUP BY existenciaNew.linea, existenciaNew.tipo ORDER BY existenciaNew.linea ASC, existenciaNew.tipo ASC;", $linea->Filas['nombre']);
	$resumenLT->Consulta($sql);
	
	#Resumen tipos
	$resumenT = new DBMySQL();
	$resumenT->Datosconexion(UDB,PDB,USERDB);
	$sql = sprintf("SELECT tipo, COUNT(*) AS cantidad FROM existenciaNew WHERE linea = '%s' GROUP BY tipo ORDER BY tipo ASC;", $linea->Filas['nombre']);
	$resumenT->Consulta($sql);
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title></title>
<style type="text/css">
body { font-family: "Lucida Grande", "Lucida Sans Unicode", "Lucida Sans", "DejaVu Sans", Verdana, sans-serif; }
.contenedor {
	width: 100%;
	display: inherit;
	height: auto;
	min-height: 100%;
	float: left;
	padding-top: px;
	margin-bottom: 50px;
}
h1, h2, h3, h4, h5, h6{
	color: #58B1FF;
	text-indent: 10px;
}
.recuento {
	width: 20% !important;
	margin-right: 5px;
	float: left;
	border-width: 1px;
	border-style: solid;
	margin-left: 5px;
}
.recuento caption {
	font-size: medium;
	text-align: left;
	text-indent: 20px;
	font-style: oblique;
	color: #58B1FF;
}
.recuento tr th{
	background-color: #F0F8FF;
	font-style: oblique;
}
.recuento, tr th, tr td {
	border-width: 1px;
	border-style: solid;
	border-collapse: collapse;
	padding-top: 2px;
	padding-right: 2px;
	padding-bottom: 2px;
	padding-left: 2px;
	font-size: x-small;
}
.recuento td[scope="num"]{ text-align: center; 
}
.recuento td[scope="float"]{ text-align: right; }
.recuento td[scope="strn"]{
	text-align: left;
	text-indent: 2px;
}
.recuento td[scope="strd"]{ text-align: center; 
}
.recuento td[scope="btxt"]{ text-align: left; 
}
.recuento td[scope="obs"] {
	cursor: pointer;
	width: 3%;
	color: #0900EE;
	text-align: center;
}
</style>
</head>

<body>
<h2>Informacion General</h2>
<hr>
<div class="contenedor">
<table class="recuento" id="l">
  <caption>
    Lineas
  </caption>
  <tr>
    <th scope="col">Linea</th>
    <th scope="col">Cantidad</th>
  </tr><?php do{ ?>
  <tr>
    <td scope="strn"><?php echo $resumenL->Filas['linea']; ?></td>
    <td scope="float"><?php $sumaL[] = $resumenL->Filas['cantidad']; echo $resumenL->Filas['cantidad']; ?></td>
  </tr><?php }while ($resumenL->Filas = mysqli_fetch_assoc($resumenL->Consulta)); ?>
  <tr>
    <td scope="strd">Subtotal:</td>
    <td scope="float"><?php echo array_sum($sumaL); ?></td>
  </tr>
</table>
<table class="recuento" id="lt">
  <caption>
    Lineas->Tipos
  </caption>
  <tr>
    <th scope="col">Lineas</th>
    <th scope="col">Tipos</th>
    <th scope="col">Cantidad</th>
  </tr><?php do{ ?>
  <tr>
    <td scope="strn"><?php echo $resumenLT->Filas['linea']; ?></td>
    <td scope="strn"><?php echo $resumenLT->Filas['tipo']; ?></td>
    <td scope="float"><?php $suma[] = $resumenLT->Filas['cantidad']; echo $resumenLT->Filas['cantidad']; ?></td>
  </tr><?php }while ($resumenLT->Filas = mysqli_fetch_assoc($resumenLT->Consulta));?>
  <tr>
    <td colspan="2" scope="strd">Subtotal:</td>
    <td scope="float"><?php echo array_sum($suma); ?></td>
  </tr>
  
</table>
<table class="recuento" id="t">
  <caption>
    Tipos
  </caption>
  <tr>
    <th scope="col">Tipos</th>
    <th scope="col">Cantidad</th>
  </tr><?php do{ ?>
  <tr>
    <td scope="strn"><?php echo $resumenT->Filas['tipo']; ?></td>
    <td scope="float"><?php $sumat[] = $resumenT->Filas['cantidad']; echo $resumenT->Filas['cantidad']; ?></td>
  </tr><?php } while($resumenT->Filas = mysqli_fetch_assoc($resumenT->Consulta));?>
  <tr>
    <td scope="strd">Subtotal:</td>
    <td scope="float"><?php echo array_sum($sumat); ?></td>
  </tr>
</table>
</div>
</body>
</html>