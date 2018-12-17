<?php
session_start();
session_name($_SESSION['variables']['usuario']);
require_once('../config.php');
require_once('../clases/class_Conexion.php');
require_once('../funciones/funciones.php');
#Seguridad
$seguridad = new Seguridad();
$seguridad->ValidarUsuario();

if(isset($_GET['f1']) and isset($_GET['f2']) and isset($_GET['linea'])){
	
	$inicio = $_GET['f1'];
	$fin = $_GET['f2'];
	$linea = $_GET['linea'];
	
	$inventario = new DBMySQL();
	$inventario->Datosconexion(UDB,PDB,USERDB);
	$cadenaSQL = sprintf("SELECT lineas.nombre AS linea, buques.nombre AS buque, viajes.viaje, tequipos.tipo, inventario.contenedor, inventario.fdb, inventario.fdm, inventario.frd, inventario.eir_r, inventario.fact, inventario.`status`, inventario.condicion, inventario.precinto, inventario.bl, patios.patio, consignatario.nombre AS consig, inventario.obs FROM inventario, lineas, buques, viajes, tequipos, patios, consignatario WHERE inventario.`delete` = 0 AND inventario.linea = lineas.id AND inventario.buque = buques.id AND inventario.viaje = viajes.id AND inventario.tcont = tequipos.id AND inventario.patio = patios.id AND inventario.`consignatario` = consignatario.id AND inventario.frd BETWEEN '%s' AND '%s' AND inventario.linea = %d ORDER BY inventario.frd ASC;",$inicio,$fin,$linea);
	$inventario->Consulta($cadenaSQL);
	if($inventario->Num_resultados > 0){
		$mostrar = true;
	}
	
	$recaps20 = new DBMySQL();
	$recaps20->Datosconexion(UDB,PDB,USERDB);
	$sql = sprintf("SELECT tequipos.tipo, count(inventario.tcont) AS cantidad FROM inventario, tequipos WHERE inventario.tcont = tequipos.id AND inventario.`delete` = 0 AND tequipos.tipo LIKE '2%%' AND inventario.frd BETWEEN '%s' AND '%s' AND inventario.linea = %d GROUP BY inventario.tcont ORDER BY tequipos.tipo ASC;",$inicio,$fin,$linea);
	$recaps20->Consulta($sql);
	
	$recaps40 = new DBMySQL();
	$recaps40->Datosconexion(UDB,PDB,USERDB);
	$sql = sprintf("SELECT tequipos.tipo, count(inventario.tcont) AS cantidad FROM inventario, tequipos WHERE inventario.tcont = tequipos.id AND inventario.`delete` = 0 AND tequipos.tipo LIKE '4%%' AND inventario.frd BETWEEN '%s' AND '%s' AND inventario.linea = %d GROUP BY inventario.tcont ORDER BY tequipos.tipo ASC;",$inicio,$fin,$linea);
	$recaps40->Consulta($sql);
	
//exportar a excel
header('Content-type: application/vnd.ms-excel');
header("Content-Disposition: attachment; filename=ingresoLineas.xls");
header("Pragma: no-cache");
header("Expires: 0");

}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Ingresos</title>
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
<!--  -->
<h2>Ingresos - Lineas | <?php echo $inventario->Filas['linea']; ?></h2>
<p><?php if($mostrar == true) { ?></p>
<!--Recuento 20-->
<?php if($recaps20->Num_resultados > 0){ ?>
    <table class="recuento">
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
<!--Recuento 40-->
<?php if($recaps40->Num_resultados > 0){ ?>
    <table class="recuento">
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
<table class="listado">
  <caption>
  Listado de Equipos: <?php echo $inventario->Num_resultados; ?>
  ingresados
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
    <td><?php echo $inventario->Filas['obs']; ?></td>
    <td scope="num"><?php FechaDif($inventario->Filas['frd'],AHORAC);?></td>
    <td scope="num"><?php FechaDif($inventario->Filas['fdb'],AHORAC);?></td>
  </tr>
  <?php } while ($inventario->Filas = mysqli_fetch_assoc($inventario->Consulta)); ?>
</table>
<?php } ?>
</body>
</html>
<?php
if(isset($_POST['ini']) and isset($_POST['fin'])){
	$inventario->Liberar();
	$recaps20->Liberar();
	$recaps40->Liberar();
}
?>