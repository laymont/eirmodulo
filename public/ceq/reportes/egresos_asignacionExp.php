<?php
session_start();
session_name($_SESSION['variables']['usuario']);
require_once('../config.php');
require_once('../clases/class_Conexion.php');
require_once('../funciones/funciones.php');
#Seguridad
$seguridad = new Seguridad();
$seguridad->ValidarUsuario();

#Linea
$lineas = new DBMySQL();
$lineas->Datosconexion(UDB,PDB,USERDB);
$lineas->Consulta("SELECT id, nombre FROM lineas WHERE activo = 0;");

if(isset($_GET['linea']) and isset($_GET['f1']) and isset($_GET['f2'])){
	$linea = $_GET['linea'];
	$inicio = $_GET['f1'];
	$fin = $_GET['f2'];
	$asignados = new DBMySQL();
	$asignados->Datosconexion(UDB,PDB,USERDB);
	$sql = sprintf("SELECT nlinea, buque, viaje, contenedor, tipo, estatus, condicion, fdb, fdm, frd, eir_r, fdespims, eir_d, booking, cliente FROM asignados WHERE linea = %d AND fdespims BETWEEN '%s' AND '%s';",$linea,$inicio,$fin);
	$asignados->Consulta($sql);
	$mostrar = $asignados->Num_resultados;

	//exportar a excel
	header('Content-type: application/vnd.ms-excel');
	header("Content-Disposition: attachment; filename=egresosLinea.xls");
	header("Pragma: no-cache");
	header("Expires: 0");
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Egresos Asignacion</title>
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
<h2>Reporte Asignaciones</h2>
<?php if($mostrar > 0){ ?>
<!--Recuento 20-->
<!--Recuento 40-->
<!--Inventario-->
<table class="listado">
  <caption>
    Listado <?php echo $asignados->Filas['nlinea']; ?>
  </caption>
  <thead>
  <tr>
    <th scope="col">#</th>
    <th scope="col">Buque</th>
    <th scope="col">Viaje</th>
    <th scope="col">Contenedor</th>
    <th scope="col">Tipo</th>
    <th scope="col">Estatus</th>
    <th scope="col">Cond.</th>
    <th scope="col">EIR</th>
    <th scope="col">Fdb</th>
    <th scope="col">Fdm</th>
    <th scope="col">Frd</th>
    <th scope="col">Fdesp</th>
    <th scope="col">Eir</th>
    <th scope="col">Booking</th>
    <th scope="col">Cliente</th>
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
  </tr>
  </tfoot><?php do{ ?>
  <tr>
    <td scope="num"><?php echo ++$contador; ?></td>
    <td scope="strn"><?php echo $asignados->Filas['buque']; ?></td>
    <td scope="strd"><?php echo $asignados->Filas['viaje']; ?></td>
    <td scope="strn"><?php echo $asignados->Filas['contenedor']; ?></td>
    <td scope="strd"><?php echo $asignados->Filas['tipo']; ?></td>
    <td scope="strd"><?php echo $asignados->Filas['estatus']; ?></td>
    <td scope="strd"><?php echo $asignados->Filas['condicion']; ?></td>
    <td scope="num"><?php echo $asignados->Filas['eir_r']; ?></td>
    <td scope="strd"><?php echo $asignados->Filas['fdb']; ?></td>
    <td scope="strd"><?php echo $asignados->Filas['fdm']; ?></td>
    <td scope="strd"><?php echo $asignados->Filas['frd']; ?></td>
    <td scope="strd"><?php echo $asignados->Filas['fdespims']; ?></td>
    <td scope="num"><?php echo $asignados->Filas['eir_d']; ?></td>
    <td scope="strn"><?php echo $asignados->Filas['booking']; ?></td>
    <td scope="strn"><?php echo $asignados->Filas['cliente']; ?></td>
  </tr><?php } while($asignados->Filas = mysqli_fetch_assoc($asignados->Consulta)); ?>
</table>
<?php } ?>
</body>
</html>