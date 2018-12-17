<?php
session_start();
session_name($_SESSION['variables']['usuario']);
require_once('../config.php');
require_once('../clases/class_DbPoo.php');
require_once('../funciones/funciones.php');

#Seguridad
$seguridad = new Seguridad();
$seguridad->ValidarUsuario();

#Lineas
$lineas = new DBsPOO(); 
$lineas->Conectar(UDB,PDB); 
$lineas->SelectDB(USERDB); 

if($_SESSION['variables']['nivel'] != 6){
	$lineas->Consultar("SELECT nombre AS linea FROM lineas WHERE activo = 0;");
}else {
	$idLinea = $_SESSION['variables']['linea'];
	$sql = sprintf("SELECT nombre AS linea FROM lineas WHERE id = %d AND activo = 0;", $idLinea);
	$lineas->Consultar($sql);
}


if(isset($_POST['lineas']) and isset($_POST['cond'])){
  /* Fix xDebug */
  $condicion = implode(",",$_POST['cond']);
  /* Fix xDebug */
	$linea = $_POST['lineas'];
	$condiciones = implode(',',$_POST['cond']);
	$cadenaSQL = sprintf("SELECT * FROM existenciaNew WHERE linea = '%s' AND condicion IN(%s);",$linea,$condiciones);
	
	$inventario = new DBsPOO();
	$inventario->Conectar(UDB,PDB);
	$inventario->SelectDB(USERDB);
	$inventario->Consultar($cadenaSQL);
	if($inventario->TotalResultados > 0){
		$mostrar = true;
	}
	
	$recaps20 = new DBsPOO();
	$recaps20->Conectar(UDB,PDB);
	$recaps20->SelectDB(USERDB);
	$recaps20->Consultar(sprintf("SELECT tipo, count(tipo) AS cantidad FROM existenciaNew WHERE tipo LIKE '2%%' AND linea = '%s' AND condicion IN(%s) GROUP BY tipo ORDER BY tipo;",$linea,$condiciones));
	
	$recaps40 = new DBsPOO();
	$recaps40->Conectar(UDB,PDB);
	$recaps40->SelectDB(USERDB);
	$recaps40->Consultar(sprintf("SELECT tipo, count(tipo) AS cantidad FROM existenciaNew WHERE tipo LIKE '4%%' AND linea = '%s' AND condicion IN(%s) GROUP BY tipo ORDER BY tipo;",$linea,$condiciones));
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
<div class="container-fluid">
  <div class="row">
    <h3>&nbsp;</h3>
  </div>
  <!--Nav-->
  <div class="row">
    <div class="col-sm-12">
      <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1"> <span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span> </button>
          <a class="navbar-brand" href="#"><span class="text-primary">Ayaguna</span></a> </div>
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
          <ul class="nav navbar-nav">
            <li class="active"><a href="../inicio.php">Regresar</a></li>
            <?php if(isset($inventario->TotalResultados)){?>
            <li><a href="inventario_condicionExp.php?linea=<?php echo $_POST['lineas']; ?>&cond=<?php echo $condicion; ?>" id="exportar">Exportar</a></li><?php } ?>
            <p class="navbar-text navbar-right"> <small class="text-info"><?php echo $_SESSION['variables']['nomdb']; ?></small></p>
          </ul>
        </div>
      </nav>
    </div>
  </div>
  <div class="row">
    <div class="col-sm-6">
      <form class="form-inline" method="post" name="form1" id="form1" onKeyPress="Noenter();" role="form">
        <fieldset>
          <legend>Indique Línea y Condición</legend>
          <div class="form-group">
            <select class="form-control" name="lineas" required id="lineas">
              <option value="">Seleccion/Linea</option>
              <?php while($lineas->Resultados()){;?>
              <option value="<?php echo $lineas->Resultados['linea'];?>"><?php echo $lineas->Resultados['linea']; ?></option>
              <?php } ?>
            </select>
          </div>
          <div class="checkbox">
            <input class="form-control" type="checkbox" name="cond[]" id="cond[]" value="1,2,3">
            <label class="control-label" for="checkbox">OPR's </label>
          </div>
          <div class="checkbox">
            <input class="form-control" type="checkbox" name="cond[]" id="cond[]" value="0,4">
            <label class="control-label" for="checkbox2">DMG </label>
          </div>
          <button type="submit" class="btn btn-primary" value="Enviar">&nbsp;<span class="glyphicon glyphicon-search"></span>&nbsp;</button>
        </fieldset>
      </form>
    </div>
  </div>
  <?php if($mostrar == true){ ?>
  <div class="row">
    <div class="col-sm-12">
    </div>
  </div>
  <div class="row">
  <h3>Inventario por condicion</h3>
    <div class="col-sm-4"><!--recaps20--> 
      <!--Resumen 20 -->
      <?php if($recaps20->TotalResultados > 0){?>
      <table class="table table-bordered table-hover table-striped table-condensed">
        <tr>
          <th scope="col">Tipo</th>
          <th scope="col">Cantidad</th>
        </tr>
        <?php while($recaps20->Resultados()){ ?>
        <tr>
          <td scope="strn"><?php echo $recaps20->Resultados['tipo']; ?></td>
          <td scope="float"><?php $suma20 = $suma20 + $recaps20->Resultados['cantidad']; echo $recaps20->Resultados['cantidad']; ?></td>
        </tr>
        <?php } ?>
        <tr>
          <td scope="strd">Total:</td>
          <td scope="float"><?php echo $suma20;?></td>
        </tr>
      </table>
      <?php } ?>
    </div>
    <div class="col-sm-4"><!--recaps40--> 
      <!--Resumen 40 -->
      <?php if($recaps40->TotalResultados > 0){ ?>
      <table class="table table-bordered table-hover table-striped table-condensed">
        <tr>
          <th scope="col">Tipo</th>
          <th scope="col">Cantidad</th>
        </tr>
        <?php while($recaps40->Resultados()){ ?>
        <tr>
          <td scope="strn"><?php echo $recaps40->Resultados['tipo'];?></td>
          <td scope="float"><?php $suma40 = $suma40 + $recaps40->Resultados['cantidad']; echo $recaps40->Resultados['cantidad'];?></td>
        </tr>
        <?php } ?>
        <tr>
          <td scope="strd">Total:</td>
          <td scope="float"><?php echo $suma40; ?></td>
        </tr>
      </table>
      <?php } ?>
    </div>
  </div>
  <div class="row">
    <div class="col-xs-12"><!--Inventario-->
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
            <th scope="col" data-field="#" data-sortable="true" data-searchable="true" data-sorter="alphanum" class="header">#</th>
            <th scope="col" data-field="linea" data-sortable="true" data-searchable="true" data-sorter="alphanum" class="header">Linea</th>
            <th scope="col" data-field="buque" data-sortable="true" data-searchable="true" data-sorter="alphanum" class="header">Buque</th>
            <th scope="col"  data-field="viaje" data-sortable="true" data-searchable="true" data-sorter="alphanum" class="header">Viaje</th>
            <th scope="col" data-field="contenedor" data-sortable="true" data-searchable="true" data-sorter="alphanum" class="header">Contenedor</th>
            <th scope="col" data-field="tipo" data-sortable="true" data-searchable="true" data-sorter="alphanum" class="header">Tipo</th>
            <th scope="col" data-field="fdb" data-sortable="true" data-searchable="true" data-sorter="alphanum" class="header">Fdb</th>
            <th scope="col" data-field="fdm" data-sortable="true" data-searchable="true" data-sorter="alphanum" class="header">Fdm</th>
            <th scope="col" data-field="fdr" data-sortable="true" data-searchable="true" data-sorter="alphanum" class="header">Fdr</th>
            <th scope="col" data-field="fact" data-sortable="true" data-searchable="true" data-sorter="alphanum" class="header">Fact.</th>
            <th scope="col" data-field="eir" data-sortable="true" data-searchable="true" data-sorter="alphanum" class="header">EIR</th>
            <th scope="col" data-field="est" data-sortable="true" data-searchable="true" data-sorter="alphanum" class="header">Est.</th>
            <th scope="col" data-field="cond" data-sortable="true" data-searchable="true" data-sorter="alphanum" class="header">Cond.</th>
            <th scope="col" data-field="pre" data-sortable="true" data-searchable="true" data-sorter="alphanum" class="header">Pre.</th>
            <th scope="col" data-field="b/l" data-sortable="true" data-searchable="true" data-sorter="alphanum" class="header">B/L</th>
            <th scope="col" data-field="patio" data-sortable="true" data-searchable="true" data-sorter="alphanum" class="header">Patio</th>
            <th scope="col" data-field="consig" data-sortable="true" data-searchable="true" data-sorter="alphanum" class="header">Consig.</th>
            <th scope="col" data-field="obs" data-sortable="true" data-searchable="true" data-sorter="alphanum" class="header">Obs.</th>
            <th scope="col" data-field="da" data-sortable="true" data-searchable="true" data-sorter="alphanum" class="header">DA.</th>
            <th scope="col" data-field="dp" data-sortable="true" data-searchable="true" data-sorter="alphanum" class="header">DP.</th>
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
        <?php while ($inventario->Resultados()){ ?>
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
          <td scope="num"><?php echo $inventario->Resultados['eir_r']; ?></td>
          <td scope="strd"><?php Estatus($inventario->Resultados['status']); ?></td>
          <td scope="strd"><?php Condiciones($inventario->Resultados['condicion']); ?></td>
          <td scope="num"><?php echo $inventario->Resultados['precinto']; ?></td>
          <td scope="strn"><?php echo $inventario->Resultados['bl']; ?></td>
          <td scope="strn"><small><?php echo $inventario->Resultados['patio']; ?></small></td>
          <td scope="strn"><small><?php echo $inventario->Resultados['consig']; ?></small></td>
          <td><a href="#" data-toggle="tooltip" data-placement="auto" title="<?php echo $inventario->Resultados['obs']; ?>"><small>Ver</small></a></td>
          <td scope="num" data-align="right"><span id="da"><?php FechaDif($inventario->Resultados['frd'],AHORAC); ?></span></td>
          <td scope="num" data-align="right"><span id="dp"><?php FechaDif($inventario->Resultados['fdb'],AHORAC);?></span></td>
        </tr>
        <?php } ?>
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
<?php if(isset($inventario)){?>
<small><?php echo "Segundos: " . round($inventario->TiempoEjecucion(),4); ?></small>
<?php } ?>
<?php $cache->cerrar(); ?>
</body>
</html>
<?php
if($mostrar == true){
	$inventario->Liberar();
	$recaps20->Liberar();
	$recaps40->Liberar();
	//cerrar
	$inventario->Cerrar();
	$recaps20->Cerrar();
	$recaps40->Cerrar();
}
?>