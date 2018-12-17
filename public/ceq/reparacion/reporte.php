<?php
session_start();
session_name($_SESSION['variables']['usuario']);
require_once('../config.php');
require_once('../clases/class_Conexion.php');
require_once('../funciones/funciones.php');
#Seguridad
$seguridad = new Seguridad();
$seguridad->ValidarUsuario();

if(isset($_POST['inicio']) and isset($_POST['fin'])){
	$ini = $_POST['inicio'];
	$fin = $_POST['fin'];

	$reporte = new DBMySQL();
	$reporte->Datosconexion(UDB,PDB,USERDB);

	if($_SESSION['variables']['nivel'] != 6){
		$sql = sprintf("SELECT lineas.nombre AS linea, reparaciones.id, reparaciones.idcontenedor, inventario.contenedor, tequipos.tipo, reparaciones.fecha, reparaciones.condicion, reparaciones.antobs, reparaciones.monto FROM reparaciones, inventario, tequipos, lineas WHERE reparaciones.idcontenedor = inventario.id AND inventario.tcont = tequipos.id AND reparaciones.fecha BETWEEN '%s' AND '%s' AND inventario.linea = lineas.id ORDER BY reparaciones.fecha ASC",$ini,$fin);
	}else {
		#Cliente
		$sql = sprintf("SELECT lineas.nombre AS linea, reparaciones.id, reparaciones.idcontenedor, inventario.contenedor, tequipos.tipo, reparaciones.fecha, reparaciones.condicion, reparaciones.antobs, reparaciones.monto FROM reparaciones, inventario, tequipos, lineas WHERE reparaciones.idcontenedor = inventario.id AND inventario.tcont = tequipos.id AND reparaciones.fecha BETWEEN '%s' AND '%s' AND inventario.linea = lineas.id AND inventario.linea = %d ORDER BY reparaciones.fecha ASC",$ini,$fin,$_SESSION['variables']['linea']);
	}
	$reporte->Consulta($sql);
	$mostrar = $reporte->Num_resultados;
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
<title><?php echo VERSION; ?></title>
<!--Estilos-->
<link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="../bootstrap/table/bootstrap-table.css">
<link rel="stylesheet" href="../bootstrap/css/styleBootstrap.css">
<link rel="stylesheet" href="../bootstrap/table/bootstrap-table.min.css">
<!--Script-->
<script src="../bootstrap/js/jquery.min.js"></script>
<script src="../bootstrap/js/bootstrap.min.js"></script>
<script src="../bootstrap/table/bootstrap-table.js"></script>
<script src="../bootstrap/table/locale/bootstrap-table-es-SP.js"></script>
<script src="../bootstrap/table/extensions/toolbar/bootstrap-table-toolbar.js"></script>
<script src="../bootstrap/table/extensions/filter-control/bootstrap-table-filter-control.min.js"></script>
<script src="../bootstrap/table/extensions/natural-sorting/bootstrap-table-natural-sorting.min.js"></script>
<script src="../bootstrap/table/extensions/export/bootstrap-table-export.js"></script>
<script type="text/javascript" src="../bootstrap/table/tableExport.js"></script>
<script src="../bootstrap/js/jquery.bootstrap-autohidingnavbar.min.js"></script>
<script>
$(document).ready(function(){
	$('[data-toggle="tooltip"]').tooltip();
});
</script>
</head>

<body>
<div class="container-fluid">
 <div class="row">
  <div class="col-sm-12">

   <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
    <div class="navbar-header">
     <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1"> <span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span> </button>
     <a class="navbar-brand" href="#"><span class="text-primary">Ayaguna</span></a>
    </div>
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
     <ul class="nav navbar-nav">
      <li class="active"><a href="../inicio.php">Regresar</a></li>
      <li><a href="#" id="exportar">Exportar</a></li>
      <p class="navbar-text navbar-right"> <small class="text-info"><?php echo $_SESSION['variables']['nomdb']; ?></small></p>
     </ul>
    </div>
   </nav>

  </div>
 </div>
 <div class="row">
  <div class="col-md-12">
   <h3>&nbsp; </h3>
  </div>
 </div>
 <div class="row">
  <div class="col-sm-6">
   <form class="form-inline" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" name="formRep" id="formRep"  onKeyPress="Noenter();">
    <fieldset>
     <legend>Indique un rango de Fecha</legend>
     <div class="form-group">
      <label class="control-label" for="inicio">Inicio:</label>
      <input class="form-control" name="inicio" type="date" id="inicio" max="<?php echo AHORAC; ?>" value="<?php echo AHORAC; ?>">
     </div>
     <div class="form-group">
      <label class="control-label" for="fin">Fin:</label>
      <input class="form-control" type="date" name="fin" id="fin" max="<?php echo AHORAC; ?>" value="<?php echo AHORAC; ?>">
     </div>
     <button class="btn btn-default" type="submit" name="submit" id="submit" value="Enviar">Enviar</button>
    </fieldset>
   </form>
  </div>
 </div>

 <?php if($mostrar > 0){ ?>
 <div class="row">
  <h3>Reparaciones</h3>
  <div class="col-xs-12">
   <table id="table" class="table table-bordered table-condensed table-hover sortable bootstrap-table"
               data-toggle="table"
               data-show-columns="true"
               data-show-toggle="true"
               data-show-export="true"
               data-search="true"
               data-pagination="true"
               data-key-events="true"
               data-sortable="true"
               data-sort-name="id"
               data-sort-order="asc"
               data-show-pagination-switch="true"
               data-pagination-v-align="both"
               data-page-size="50"
               data-pagination-first-text="Inicio"
               data-pagination-pre-text="Previo"
               data-pagination-next-text="Siguiente"
               data-pagination-last-text="Ultimo"
               data-maintain-selected="true"
               data-toolbar="#toolbar"
               data-search-align="left"
               data-buttons-align="left"
               data-toolbar-align="right"
               data-locale="es-SP">
    <caption>
    Listado
    entre <?php echo $ini . " y " . $fin; ?>
    </caption>
    <thead>
     <tr>
      <th data-field="id" data-sortable="true" data-sorter="alphanum" scope="col">Id</th>
      <th data-field="linea" data-sortable="true" data-searchable="true" data-sorter="alphanum" scope="col">Linea</th>
      <th data-field="contenedor" data-sortable="true" data-searchable="true" data-sorter="alphanum" scope="col">Contenedor</th>
      <th data-field="tipo" data-sortable="true" data-searchable="true" data-sorter="alphanum" scope="col">Tipo</th>
      <th data-field="cond" data-sortable="true" data-searchable="true" data-sorter="alphanum" scope="col">Cond.</th>
      <th data-field="fecha" data-sortable="true" data-searchable="true" data-sorter="alphanum" scope="col">Fecha</th>
      <th data-field="ant. obs." data-sortable="true" data-searchable="true" data-sorter="alphanum" scope="col">Ant. Obs.</th>
      <th data-field="monto" data-align="right" data-sortable="true" data-searchable="true" data-sorter="alphanum" scope="col">Monto</th>
     </tr>
    </thead>
    <?php do{ ?>
    <tr>
     <td scope="num"><?php echo ++$contador; ?></td>
     <td scope="strn"><?php echo $reporte->Filas['linea']; ?></td>
     <td scope="strn"><?php echo $reporte->Filas['contenedor']; ?>&nbsp; <a href="verdmg.php?id=<?php echo $reporte->Filas['idcontenedor']; ?>" target="_blank"><i class="fa fa-wrench">&nbsp;</i></a></td>
     <td scope="strd"><?php echo $reporte->Filas['tipo']; ?></td>
     <td scope="strd"><?php Condiciones($reporte->Filas['condicion']); ?></td>
     <td scope="strd"><?php echo $reporte->Filas['fecha']; ?></td>
     <td><a href="#" data-toggle="tooltip" data-placement="auto" title="<?php echo $reporte->Filas['antobs']; ?>"><small>Ver</small></a></td>
     <td scope="float"><?php Monto($reporte->Filas['monto']); ?></td>
    </tr>
    <?php } while($reporte->Filas = mysqli_fetch_assoc($reporte->Consulta)); ?>
   </table>
  </div>
 </div>
 <?php } ?>
</div>
<script>
$("nav.navbar-fixed-top").autoHidingNavbar();

var $table = $('#table');
$(function () {
	$table.on('click-row.bs.table', function (e, row, $element) {
		$('.success').removeClass('success');
		$($element).addClass('success');
	});
});
</script>
</body>
</html>