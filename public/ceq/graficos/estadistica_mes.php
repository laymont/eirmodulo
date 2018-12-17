<?php
session_start();
session_name($_SESSION['variables']['usuario']);
require_once('../config.php');
require_once('../clases/class_Conexion.php');

if(!isset($_POST['mes'])){
	$mes = date('n');;
}else {
	$mes = $_POST['mes'];
}

#Mes Array
$arrayMes = array(
				1=>'Enero',
				2=>'Febrero',
				3=>'Marzo',
				4=>'Abril',
				5=>'Mayo',
				6=>'Junio',
				7=>'Julio',
				8=>'Agosto',
				9=>'Septiembre',
				10=>'Octubre',
				11=>'Noviembre',
				12=>'Diciembre'
				);
#Mes en DB
$meses = new DBMySQL();
$meses->Datosconexion(UDB,PDB,USERDB);
$meses->Consulta("SELECT MONTH(frd) as numes FROM inventario WHERE YEAR(frd) = YEAR(CURRENT_DATE()) GROUP BY MONTH(frd);");

$recuento = new DBMySQL();
$recuento->Datosconexion(UDB,PDB,USERDB);
$sqlRe = sprintf("SELECT tequipos.tipo AS tipo, COUNT(inventario.tcont) AS cantidad FROM inventario, tequipos WHERE MONTH(inventario.frd) = %d AND YEAR(inventario.frd) = YEAR(CURRENT_DATE()) AND inventario.tcont = tequipos.id GROUP BY inventario.tcont ORDER BY tequipos.tipo;",$mes);
$recuento->Consulta($sqlRe);
do{
	$tipos[] = $recuento->Filas['tipo'];
	$cantidades[] = $recuento->Filas['cantidad'];
}while ($recuento->Filas = mysqli_fetch_assoc($recuento->Consulta));
$ti = '"'.implode('","',$tipos).'"';
$can = '"'.implode('","',$cantidades).'"';

$datos = new DBMySQL();
$datos->Datosconexion(UDB,PDB,USERDB);
$sqlInv = sprintf("SELECT lineas.nombre AS linea, COUNT(inventario.contenedor) AS cantidad FROM inventario, lineas WHERE inventario.linea = lineas.id AND MONTH(inventario.frd) = %d AND YEAR(inventario.frd) = YEAR(CURRENT_DATE()) GROUP BY inventario.linea ORDER BY lineas.nombre;",$mes);

$datos->Consulta($sqlInv);
do{
	$lineas[]=$datos->Filas['linea'];
	$cantidad[]=$datos->Filas['cantidad'];
}while ($datos->Filas = mysqli_fetch_assoc($datos->Consulta));
$li = '"'.implode('","',$lineas).'"';
$ca = '"'.implode('","',$cantidad).'"';

$condiciones = new DBMySQL();
$condiciones->Datosconexion(UDB,PDB,USERDB);
$sqlCond = sprintf('SELECT CASE condicion WHEN 0 THEN "DMG" WHEN 1 THEN "OPR1" WHEN 2 THEN "OPR2" WHEN 3 THEN "OPR3" WHEN 4 THEN "DMG" END AS cond, COUNT(condicion) AS cantidad FROM inventario WHERE month(frd) = %d AND YEAR(inventario.frd) = YEAR(CURRENT_DATE()) GROUP BY cond ORDER BY cond;',$mes);

$condiciones->Consulta($sqlCond);
do{
	$condicion[] = $condiciones->Filas['cond'];
	$cant[] = $condiciones->Filas['cantidad'];
}while ($condiciones->Filas = mysqli_fetch_assoc($condiciones->Consulta));
$condicion = '"'.implode('","',$condicion).'"';
$cant = '"'.implode('","',$cant).'"';

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Inventario General - Grafico</title>
<script src="Chart.js"></script>
<link href="../css/estilo.css" rel="stylesheet" type="text/css">
<style type="text/css">
.pie {
	display: none;
}
.titulo {
	display: inherit;
}
@media print{
	.titulo {
		display: none;
	}
	.saltoPag {
		page-break-after: always;
	}
	.pie {
		text-align: center;
		display: inherit;
	}
}
</style>
</head>

<body>
<h1>Inventario <?php echo $arrayMes[$mes] ?></h1>
<h2 class="titulo"><?php echo EMPRE; ?></h2>
<p class="titulo"><a href="#" onClick="window.print();">Imprimir</a></p>
<div class="titulo">
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" name="form1" class="formulariosBusca" id="form1">
  <fieldset>
  <legend>Indique el Mes</legend>
  <label for="mes">Mes:</label>
  <select name="mes" id="mes">
      <option value="-1" selected>Seleccion</option>
      <?php do{ ?>
      <option value="<?php echo $meses->Filas['numes'];?>"><?php echo $arrayMes[$meses->Filas['numes']] ?></option>
	  <?php }while ($meses->Filas = mysqli_fetch_assoc($meses->Consulta)); ?>
  </select>
  <input type="submit" name="submit" id="submit" value="Enviar">
  </fieldset>
</form>
</div>
<h2 align="center">Tipos</h2>
<h3 class="pie"><?php echo EMPRE; ?></h3>  	  
<p>
  <canvas id="recuento" width="600" height="230"></canvas>
</p>
<p class="saltoPag">&nbsp;</p>
<h2 align="center">Condicion</h2>
<h3 class="pie"><?php echo EMPRE; ?></h3>
<p>
  <canvas id="condiciones" width="600" height="230"></canvas>
</p>
<p class="saltoPag">&nbsp;</p>
<h2 align="center">Inventario</h2>
<h3 class="pie"><?php echo EMPRE; ?></h3>
<p>
  <canvas id="gbarras" width="600" height="230"></canvas>
</p>
<script>
var datosRecuentos = {
	labels : [<?php echo $ti; ?>],
	datasets : [{
		fillColor : "#6b9dfa",
		strokeColor : "#020591",
		highlightFill: "#FCF300",
		highlightStroke: "#020591",
		data : [<?php echo $can; ?>]
	}]
}
var datosCondiciones = {
	labels : [<?php echo $condicion; ?>],
	datasets : [{
		fillColor : "#6b9dfa",
		strokeColor : "#020591",
		highlightFill: "#FCF300",
		highlightStroke: "#020591",
		data : [<?php echo $cant; ?>]
	}]
}
var datosGraficos = {
	labels : [<?php echo $li; ?>],
	datasets : [{
		fillColor : "#6b9dfa",
		strokeColor : "#020591",
		highlightFill: "#FCF300",
		highlightStroke: "#020591",
		data : [<?php echo $ca; ?>]
	}]
}
var graficoR = document.getElementById("recuento").getContext("2d");
window.myRec = new Chart(graficoR).Bar(datosRecuentos, {responsive:true});
var graficoC = document.getElementById("condiciones").getContext("2d");
window.myCon = new Chart(graficoC).Bar(datosCondiciones, {responsive:true});
var grafico = document.getElementById("gbarras").getContext("2d");
window.myPie = new Chart(grafico).Bar(datosGraficos, {responsive:true});
  </script>
</body>
</html>