<?php
session_start();
session_name($_SESSION['variables']['usuario']);
require_once('../config.php');
require_once('../clases/class_Conexion.php');
require_once('../funciones/funciones.php');

if(isset($_GET['patio'])){
	$patio = $_GET['patio'];
	if($_SESSION['variables']['nivel'] != 6){
		$inventario = new DBMySQL();
		$inventario->Datosconexion(UDB,PDB,USERDB);
		$cadenaSQL = sprintf("SELECT * FROM existenciaNew WHERE patio LIKE '%s';",$patio);
		$inventario->Consulta($cadenaSQL);
		
		$recaps20 = new DBMySQL();
		$recaps20->Datosconexion(UDB,PDB,USERDB);
		$sql = sprintf("SELECT tipo, count(tipo) AS cantidad FROM existenciaNew WHERE tipo LIKE '2%%' AND patio = '%s' GROUP BY tipo ORDER BY tipo;",$patio);
		$recaps20->Consulta($sql);
		
		$recaps40 = new DBMySQL();
		$recaps40->Datosconexion(UDB,PDB,USERDB);
		$sql = sprintf("SELECT tipo, count(tipo) AS cantidad FROM existenciaNew WHERE tipo LIKE '4%%' AND patio = '%s' GROUP BY tipo ORDER BY tipo;",$patio);
		$recaps40->Consulta($sql);
	}else {
		#Cliente
		$idLinea = $_SESSION['variables']['linea'];
		$linea = new DBMySQL();
		$linea->DatosConexion(UDB,PDB,USERDB);
		$sql = sprintf("SELECT nombre FROM lineas WHERE id = %d", $idLinea);
		$linea->Consulta($sql);
		$strLinea = $linea->Filas['nombre'];
		
		$inventario = new DBMySQL();
		$inventario->Datosconexion(UDB,PDB,USERDB);
		$cadenaSQL = sprintf("SELECT * FROM existenciaNew WHERE patio LIKE '%s' AND linea = '%s';",$patio, $strLinea);
		$inventario->Consulta($cadenaSQL);
		
		$recaps20 = new DBMySQL();
		$recaps20->Datosconexion(UDB,PDB,USERDB);
		$sql = sprintf("SELECT tipo, count(tipo) AS cantidad FROM existenciaNew WHERE tipo LIKE '2%%' AND patio = '%s' AND linea = '%s' GROUP BY tipo ORDER BY tipo;",$patio, $strLinea);
		$recaps20->Consulta($sql);
		
		$recaps40 = new DBMySQL();
		$recaps40->Datosconexion(UDB,PDB,USERDB);
		$sql = sprintf("SELECT tipo, count(tipo) AS cantidad FROM existenciaNew WHERE tipo LIKE '4%%' AND patio = '%s' AND linea = '%s' GROUP BY tipo ORDER BY tipo;",$patio, $strLinea);
		$recaps40->Consulta($sql);
	}
	
//exportar a excel
header('Content-type: application/vnd.ms-excel');
header("Content-Disposition: attachment; filename=inventarioPatios.xls");
header("Pragma: no-cache");
header("Expires: 0");
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title><?php echo VERSION; ?></title>
<script type="text/javascript" language="javascript" src="../js/jquery.js"></script>
<script type="text/javascript" language="javascript" src="../js/funciones.js"></script>
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
<h2>Inventario por Patio</h2>
<?php if(isset($inventario) and $inventario->Num_resultados > 0){ ?>
<!--Recuento 20 -->
<?php if($recaps20->Num_resultados > 0){?>
    <table width="240" border="1" align="left" cellpadding="0" cellspacing="0" class="recuento">
      <tr>
        <th scope="col">Tipo</th>
        <th scope="col">Cantidad</th>
      </tr><?php do{ ?>
      <tr>
        <td scope="strn"><?php echo $recaps20->Filas['tipo']; ?></td>
        <td scope="float"><?php $suma20 = $suma20 + $recaps20->Filas['cantidad']; echo $recaps20->Filas['cantidad']; ?></td>
      </tr><?php }while($recaps20->Filas = mysqli_fetch_assoc($recaps20->Consulta)); ?>
      <tr>
        <td scope="strd">Total:</td>
        <td scope="float"><?php echo $suma20;?></td>
      </tr>
    </table>
    <?php } ?>
<!--Recuento 40 -->
<?php if($recaps40->Num_resultados > 0){ ?>
<table width="240" border="1" align="left" cellpadding="0" cellspacing="0" class="recuento">
      <tr>
        <th scope="col">Tipo</th>
        <th scope="col">Cantidad</th>
      </tr><?php do{ ?>
      <tr>
        <td scope="strn"><?php echo $recaps40->Filas['tipo'];?></td>
        <td scope="float"><?php $suma40 = $suma40 + $recaps40->Filas['cantidad']; echo $recaps40->Filas['cantidad'];?></td>
      </tr><?php }while ($recaps40->Filas = mysqli_fetch_assoc($recaps40->Consulta));?>
      <tr>
        <td scope="strd">Total:</td>
        <td scope="float"><?php echo $suma40; ?></td>
      </tr>
    </table>
    <?php } ?>
<table border="1" align="center" cellpadding="0" cellspacing="0" class="listado">
  <caption>
  Listado de Equipos: <?php echo $inventario->Num_resultados; ?>
  en <?php echo $inventario->Filas['patio']; ?>
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
    <th scope="col">EIR</th>
    <th scope="col">Est.</th>
    <th scope="col">Cond.</th>
    <th scope="col">Pre.</th>
    <th scope="col">B/L</th>
    <th scope="col">Patio</th>
    <th scope="col">Consig.</th>
    <th scope="col">Obs.</th>
    <th scope="col">DA.</th>
    <th scope="col">DP.</th>
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
    <td scope="num"><?php echo $inventario->Filas['eir_r']; ?></td>
    <td scope="strd"><?php Estatus($inventario->Filas['status']); ?></td>
    <td scope="strd"><?php Condiciones($inventario->Filas['condicion']); ?></td>
    <td scope="num"><?php echo $inventario->Filas['precinto']; ?></td>
    <td scope="strn"><?php echo $inventario->Filas['bl']; ?></td>
    <td scope="strn"><?php echo $inventario->Filas['patio']; ?></td>
    <td scope="strn"><?php echo $inventario->Filas['consig']; ?></td>
    <td scope="obs"><?php echo $inventario->Filas['obs']; ?></td>
    <td scope="num"><?php FechaDif($inventario->Filas['frd'],AHORAC);?></td>
    <td scope="num"><?php FechaDif($inventario->Filas['fdb'],AHORAC);?></td>
  </tr><?php } while ($inventario->Filas = mysqli_fetch_assoc($inventario->Consulta)); ?>
</table>
<?php } ?>
</body>
</html>
<?php
if(isset($inventario)){
	$inventario->Liberar();
	$recaps20->Liberar();
	$recaps40->Liberar();
}
?>