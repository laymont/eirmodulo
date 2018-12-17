<?php
session_start();
session_name($_SESSION['variables']['usuario']);
require_once('../config.php');
require_once('../clases/class_DbPoo.php');
require_once('../funciones/funciones.php');

#Seguridad
$seguridad = new Seguridad();
$seguridad->ValidarUsuario();


if($_SESSION['variables']['nivel'] != 6){
	$inventario = new DBsPOO();
	$inventario->Conectar(UDB,PDB);
	$inventario->SelectDB(USERDB);
	$cadenaSQL = "SELECT * FROM existenciaNew;";
	$inventario->Consultar($cadenaSQL);
	
	$recaps20 = new DBsPOO();
	$recaps20->Conectar(UDB,PDB);
	$recaps20->SelectDB(USERDB);
	$recaps20->Consultar("SELECT tipo, count(tipo) AS cantidad FROM existenciaNew WHERE tipo LIKE '2%'  GROUP BY tipo ORDER BY tipo;");
	
	$recaps40 = new DBsPOO();
	$recaps40->Conectar(UDB,PDB);
	$recaps40->SelectDB(USERDB);
	$recaps40->Consultar("SELECT tipo, count(tipo) AS cantidad FROM existenciaNew WHERE tipo LIKE '4%'  GROUP BY tipo ORDER BY tipo;");
}else {
	$idLinea = $_SESSION['variables']['linea'];
	$linea = new DBsPOO();
	$linea->Conectar(UDB,PDB);
	$linea->SelectDB(USERDB);
	$sql = sprintf("SELECT nombre FROM lineas WHERE id = %d", $idLinea);
	$linea->Consultar($sql);
	$linea->Resultados['nombre'];
	
	$inventario = new DBsPOO();
	$inventario->Conectar(UDB,PDB);
	$inventario->SelectDB(USERDB);
	$cadenaSQL = sprintf("SELECT * FROM existenciaNew WHERE linea = '%s';",$linea->Filas['nombre']);
	$inventario->Consultar($cadenaSQL);
	
	$recaps20 = new DBsPOO();
	$recaps20->Conectar(UDB,PDB);
	$sql = sprintf("SELECT tipo, count(tipo) AS cantidad FROM existenciaNew WHERE tipo LIKE '2%%' AND linea = '%s' GROUP BY tipo ORDER BY tipo;",$linea->Resultados['nombre']);
	$recaps20->Consultar($sql);
	
	$recaps40 = new DBsPOO();
	$recaps40->Conectar(UDB,PDB);
	$recaps40->SelectDB(USERDB);
	$sql = sprintf("SELECT tipo, count(tipo) AS cantidad FROM existenciaNew WHERE tipo LIKE '4%%' AND linea = '%s' GROUP BY tipo ORDER BY tipo;",$linea->Resultados['nombre']);
	$recaps40->Consultar($sql);
}
?>
<!doctype html>
<html lang="es">
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
<div id="contenedor" class="container-fluid">
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
      <li><a href="inventarioExp.php" id="exportar">Exportar</a></li>
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
  <h3>Inventario General</h3>
  <div class="col-sm-4">
   <table border="1" cellpadding="1" cellspacing="1"  class="table table-bordered table-hover table-striped table-condensed" id="r20">
    <thead>
     <tr>
      <th scope="col">Tipo</th>
      <th scope="col">Cantidad</th>
     </tr>
    </thead>
    <tbody>
     <?php while($recaps20->Resultados()) { ?>
     <tr>
      <td scope="strn"><?php echo $recaps20->Resultados['tipo']; ?></td>
      <td scope="float"><?php $suma20 = $suma20 + $recaps20->Resultados['cantidad']; echo $recaps20->Resultados['cantidad']; ?></td>
     </tr>
     <?php } ?>
    </tbody>
    <tfoot>
     <tr>
      <td scope="strd">Total:</td>
      <td scope="float"><?php echo $suma20;?></td>
     </tr>
    </tfoot>
   </table>
  </div>
  <div class="col-sm-4">
   <table class="table table-bordered table-hover table-striped table-condensed">
    <thead>
     <tr>
      <th scope="col">Tipo</th>
      <th scope="col">Cantidad</th>
     </tr>
    </thead>
    <tbody>
     <?php while($recaps40->Resultados()){ ?>
     <tr>
      <td scope="strn"><?php echo $recaps40->Resultados['tipo'];?></td>
      <td scope="float"><?php $suma40 = $suma40 + $recaps40->Resultados['cantidad']; echo $recaps40->Resultados['cantidad'];?></td>
     </tr>
     <?php } ?>
    </tbody>
    <tfoot>
     <tr>
      <td scope="strd">Total:</td>
      <td scope="float"><?php echo $suma40; ?></td>
     </tr>
    </tfoot>
   </table>
  </div>
  <div class="col-sm-4">
  </div>
 </div>
 <div class="row">
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
               data-sort-name="#"
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
    Listado de Equipos: <?php echo $inventario->TotalResultados; ?>
    </caption>
    <thead>
     <tr>
      <th data-field="#" data-sortable="true" data-searchable="true" data-sorter="alphanum"  class="header" scope="col">#</th>
      <th data-field="linea" data-sortable="true" data-searchable="true" data-sorter="alphanum"  class="header" scope="col" >Linea</th>
      <th data-field="buque" data-sortable="true" data-searchable="true" data-sorter="alphanum"  class="header" scope="col">Buque</th>
      <th data-field="viaje" data-sortable="true" data-searchable="true" data-sorter="alphanum" class="header" scope="col">Viaje</th>
      <th data-field="contenedor" data-sortable="true" data-searchable="true" data-sorter="alphanum"  class="header" scope="col">Contenedor</th>
      <th data-field="tipo" data-sortable="true" data-searchable="true" data-sorter="alphanum"  class="header" scope="col">Tipo</th>
      <th data-field="fdb" data-sortable="true" data-searchable="true" data-sorter="alphanum"  class="header" scope="col">Fdb</th>
      <th data-field="fdm" data-sortable="true" data-searchable="true" data-sorter="alphanum"  class="header" scope="col">Fdm</th>
      <th data-field="fdr" data-sortable="true" data-searchable="true" data-sorter="alphanum"  class="header" scope="col">Fdr</th>
      <th data-field="fact" data-sortable="true" data-searchable="true" data-sorter="alphanum"  class="header" scope="col">Fact.</th>
      <!-- Requerimiento INTERCONTAINERS -->
       <th data-field="pase" data-sortable="true" data-searchable="true" data-sorter="alphanum"  class="header" scope="col">Pase</th>
       <!-- Requerimiento INTERCONTAINERS -->
      <th data-field="eir" data-sortable="true" data-searchable="true" data-sorter="alphanum"  class="header" scope="col">EIR</th>
      <th data-field="est" data-sortable="true" data-searchable="true" data-sorter="alphanum"  class="header" scope="col">Est.</th>
      <th data-field="cond" data-sortable="true" data-searchable="true" data-sorter="alphanum"  class="header" scope="col">Cond.</th>
      <th data-field="pre" data-sortable="true" data-searchable="true" data-sorter="alphanum"  class="header" scope="col">Pre.</th>
      <th data-field="b/l" data-sortable="true" data-searchable="true" data-sorter="alphanum"  class="header" scope="col">B/L</th>
      <th data-field="patio" data-sortable="true" data-searchable="true" data-sorter="alphanum"  class="header" scope="col">Patio</th>
      <th data-field="consig" data-sortable="true" data-searchable="true" data-sorter="alphanum"  class="header" scope="col">Consig.</th>
      <th data-field="obs" data-sortable="true" data-searchable="true" data-sorter="alphanum"  class="header" scope="col">Obs.</th>
      <th data-field="da" data-sortable="true" data-searchable="true" data-sorter="alphanum" data-align="right"  class="header" scope="col">D.A.</th>
      <th data-field="dp" data-sortable="true" data-searchable="true" data-sorter="alphanum" data-align="right"  class="header" scope="col">D.P.</th>
     </tr>
    </thead>
    <?php while($inventario->Resultados()) { ?>
    <tr>
     <td scope="num"><?php echo ++$contador; ?></td>
     <td scope="strn"><?php echo $inventario->Resultados['linea']; ?></td>
     <td scope="strn"><?php echo $inventario->Resultados['buque']; ?></td>
     <td scope="strd"><?php echo $inventario->Resultados['viaje']; ?></td>
     <td scope="strn"><?php echo $inventario->Resultados['contenedor']; ?></td>
     <td scope="strd"><?php echo $inventario->Resultados['tipo']; ?></td>
     <td scope="strd"><?php echo $inventario->Resultados['fdb']; ?></td>
     <td scope="strd"><?php echo $inventario->Resultados['fdm']; ?></td>
     <td scope="strd"><?php echo $inventario->Resultados['frd']; ?></td>
     <td scope="num"><?php echo $inventario->Resultados['fact']; ?></td>
     <td scope="num"><?php echo $inventario->Resultados['pase']; ?></td>
     <td scope="num"><?php echo $inventario->Resultados['eir_r']; ?></td>
     <td scope="strd"><?php Estatus($inventario->Resultados['status']); ?></td>
     <td scope="strd"><?php Condiciones($inventario->Resultados['condicion']); ?></td>
     <td scope="num"><?php echo $inventario->Resultados['precinto']; ?></td>
     <td scope="strn"><?php echo $inventario->Resultados['bl']; ?></td>
     <td scope="strn"><small><?php echo $inventario->Resultados['patio']; ?></small></td>
     <td scope="btxt"><small><?php echo $inventario->Resultados['consig']; ?></small></td>
     <td scope="obs"><?php echo $inventario->Resultados['obs']; ?></td>
     <td scope="num" data-align="right"><span id="da">
      <?php FechaDif($inventario->Resultados['frd'],AHORAC); ?>
      </span></td>
     <td scope="num" data-align="right"><span id="dp">
      <?php FechaDif($inventario->Resultados['fdb'],AHORAC);?>
      </span></td>
    </tr>
    <?php } ?>
   </table>
  </div>
 </div>
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
<small><?php echo "Segundos: " . round($inventario->TiempoEjecucion(),4); ?></small>
</body>
<?php $cache->cerrar(); ?>
</html>
<?php
//Liberar memoria
$inventario->Liberar();
$recaps20->Liberar();
$recaps40->Liberar();
//Cerrar conexion
$inventario->Cerrar();
$recaps20->Cerrar();
$recaps40->Cerrar();
?>