<?php
session_start();
session_name($_SESSION['variables']['usuario']);
require_once('../config.php');
require_once('../clases/class_Conexion.php');
require_once('../funciones/funciones.php');
#Seguridad
$seguridad = new Seguridad();
$seguridad->ValidarUsuario();

$inventario = new DBMySQL();
$inventario->Datosconexion(UDB,PDB,USERDB);
$cadenaSQL = "SELECT * FROM existenciaNew;";
$inventario->Consulta($cadenaSQL);

$recaps20 = new DBMySQL();
$recaps20->Datosconexion(UDB,PDB,USERDB);
$recaps20->Consulta("SELECT tipo, count(tipo) AS cantidad FROM existenciaNew WHERE tipo LIKE '2%'  GROUP BY tipo ORDER BY tipo;");

$recaps40 = new DBMySQL();
$recaps40->Datosconexion(UDB,PDB,USERDB);
$recaps40->Consulta("SELECT tipo, count(tipo) AS cantidad FROM existenciaNew WHERE tipo LIKE '4%'  GROUP BY tipo ORDER BY tipo;");
?>
<?php

//Exportar
header('Content-type: application/vnd.ms-excel');
header("Content-Disposition: attachment; filename=inventarioGral.xls");
header("Pragma: no-cache");
header("Expires: 0");

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Inventario General</title>
<script type="text/javascript" language="javascript" src="../js/jquery.js"></script>
<script>
</script>
<style type="text/css">
body {
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
	margin-left: 0px;
	font-family: "Lucida Grande", "Lucida Sans Unicode", "Lucida Sans", "DejaVu Sans", Verdana, sans-serif;
	font-size: x-small;
}
#wrapper {
	margin-right: auto;
	margin-left: auto;
	width: auto;
}
.recuento{
	margin-left: 5px;
	margin-bottom: 5px;
	border: 1px solid #EBEBEB;
	width: 20%;
	clear: none;
	float: left;
	border-collapse: collapse;
}
.recuento thead tr th ,  tr th{
	background-color: #EBEBEB;
	border: 1px solid #EBEBEB;
}
.recuento tr td {
	border: 1px solid #EBEBEB;
	border-collapse: collapse;
}
.listado {
	margin-left: auto;
	margin-bottom: 5px;
	border: 1px solid #EBEBEB;
	clear: both;
	border-collapse: collapse;
	width: auto;
	margin-right: auto;
}
.listado thead tr th ,  tr th{
	background-color: #EBEBEB;
	border: 1px solid #EBEBEB;
}
.listado tr td {
	border: 1px solid #EBEBEB;
	border-collapse: collapse;
}
</style>
</head>
<body>
<div id="wrapper"> 
  <h2>Inventario General  </h2>
  <table  class="recuento" id="r20">
    <tr>
    <th scope="col">Tipo</th>
    <th scope="col">Cantidad</th>
  </tr>
  <?php do{ ?>
  <tr>
    <td scope="strn"><?php echo $recaps20->Filas['tipo']; ?></td>
    <td scope="float"><?php $suma20 = $suma20 + $recaps20->Filas['cantidad']; echo $recaps20->Filas['cantidad']; ?></td>
  </tr>
  <?php }while($recaps20->Filas = mysqli_fetch_assoc($recaps20->Consulta)); ?>
  <tr>
    <td scope="strd">Total:</td>
    <td scope="float"><?php echo $suma20;?></td>
  </tr>
</table>
<table class="recuento" id="r40">
  <tr>
    <th scope="col">Tipo</th>
    <th scope="col">Cantidad</th>
  </tr>
  <?php do{ ?>
  <tr>
    <td scope="strn"><?php echo $recaps40->Filas['tipo'];?></td>
    <td scope="float"><?php $suma40 = $suma40 + $recaps40->Filas['cantidad']; echo $recaps40->Filas['cantidad'];?></td>
  </tr>
  <?php }while ($recaps40->Filas = mysqli_fetch_assoc($recaps40->Consulta));?>
  <tr>
    <td scope="strd">Total:</td>
    <td scope="float"><?php echo $suma40; ?></td>
  </tr>
</table>
<table class="listado" id="lista">
  <caption>
  Listado de Equipos: <?php echo $inventario->Num_resultados; ?>
  </caption>
  <thead>
  <tr>
    <th scope="col">#</th>
    <th scope="col">Linea</th>
    <th scope="col">Buque</th>
    <th scope="col">Viaje</th>
    <th scope="col">Contenedor</th>
    <th scope="col">Tipo</th>
    <th scope="col">Fdb</th>
    <th scope="col">Fdm</th>
    <th scope="col">Fdr</th>
    <th scope="col">Fact.</th>
    <th scope="col">Pase</th>
    <th scope="col">EIR</th>
    <th scope="col">Est.</th>
    <th scope="col">Cond.</th>
    <th scope="col">Pre.</th>
    <th scope="col">B/L</th>
    <th scope="col">Patio</th>
    <th scope="col">Consig.</th>
    <th scope="col">Obs.</th>
    <th scope="col">DA</th>
    <th scope="col">DP</th>
  </tr>
  </thead>
  <tfoot>
  <tr>
    <th scope="col">&nbsp;</th>
    <th scope="col">&nbsp;</th>
    <th scope="col">&nbsp;</th>
    <th scope="col">&nbsp;</th>
    <th scope="col">&nbsp;</th>
    <th scope="col">&nbsp;</th>
    <th scope="col">&nbsp;</th>
    <th scope="col">&nbsp;</th>
    <th scope="col">&nbsp;</th>
    <th scope="col">&nbsp;</th>
    <th scope="col">&nbsp;</th>
    <th scope="col">&nbsp;</th>
    <th scope="col">&nbsp;</th>
    <th scope="col">&nbsp;</th>
    <th scope="col">&nbsp;</th>
    <th scope="col">&nbsp;</th>
    <th scope="col">&nbsp;</th>
    <th scope="col">&nbsp;</th>
    <th scope="col">&nbsp;</th>
    <th scope="col">&nbsp;</th>
    <th scope="col">&nbsp;</th>
  </tr>
  </tfoot>
  <?php do { ?>
  <tr>
    <td scope="num"><?php echo ++$contador; ?></td>
    <td scope="strn"><?php echo $inventario->Filas['linea']; ?></td>
    <td scope="strn"><?php echo $inventario->Filas['buque']; ?></td>
    <td scope="strd"><?php echo $inventario->Filas['viaje']; ?></td>
    <td scope="strn"><?php echo $inventario->Filas['contenedor']; ?></td>
    <td scope="strd"><?php echo $inventario->Filas['tipo']; ?></td>
    <td scope="strd"><?php echo $inventario->Filas['fdb']; ?></td>
    <td scope="strd"><?php echo $inventario->Filas['fdm']; ?></td>
    <td scope="strd"><?php echo $inventario->Filas['frd']; ?></td>
    <td scope="num"><?php echo $inventario->Filas['fact']; ?></td>
    <td scope="num"><?php echo $inventario->Filas['pase']; ?></td>
    <td scope="num"><?php echo $inventario->Filas['eir_r']; ?></td>
    <td scope="strd"><?php Estatus($inventario->Filas['status']); ?></td>
    <td scope="strd"><?php Condiciones($inventario->Filas['condicion']); ?></td>
    <td scope="num"><?php echo $inventario->Filas['precinto']; ?></td>
    <td scope="strn"><?php echo $inventario->Filas['bl']; ?></td>
    <td scope="strn"><?php echo $inventario->Filas['patio']; ?></td>
    <td scope="btxt"><?php echo $inventario->Filas['consig']; ?></td>
    <td><?php echo $inventario->Filas['obs']; ?></td>
    <td scope="num"><?php FechaDif($inventario->Filas['frd'],AHORAC);?></td>
    <td scope="num"><?php FechaDif($inventario->Filas['fdb'],AHORAC);?></script></td>
  </tr>
  <?php } while ($inventario->Filas = mysqli_fetch_assoc($inventario->Consulta)); ?>
</table>
</div>
</body>
<script type="text/javascript" language="javascript" src="../js/funciones.js"></script>
</html>
<?php
$inventario->Liberar();
$recaps20->Liberar();
$recaps40->Liberar();
?>