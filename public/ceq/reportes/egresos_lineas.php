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
	$lineas->Consultar("SELECT id, nombre AS linea FROM lineas WHERE activo = 0;");
}else {
	$idLinea = $_SESSION['variables']['linea'];
	$sql = sprintf("SELECT id, nombre AS linea FROM lineas WHERE id = %d AND activo = 0;", $idLinea);
	$lineas->Consultar($sql);
}

if(isset($_POST['ini']) and isset($_POST['fin']) and isset($_POST['lineas'])){
	
	$inicio = $_POST['ini'];
	$fin = $_POST['fin'];
	$linea = $_POST['lineas'];
	
	$inventario = new DBsPOO();
	$inventario->Conectar(UDB,PDB);
	$inventario->SelectDB(USERDB);
	$cadenaSQL = sprintf("SELECT lineas.nombre AS linea, buques.nombre AS buque, viajes.viaje, tequipos.tipo, inventario.contenedor, inventario.fdb, inventario.fdm, inventario.frd, inventario.fdespims, buques.nombre AS buquedesp, inventario.viajed, inventario.eir_r, inventario.fact, inventario.pase, inventario.`status`, inventario.condicion, inventario.precinto, inventario.bl, patios.patio, consignatario.nombre AS consig, inventario.obs FROM inventario, lineas, buques, viajes, tequipos, patios, consignatario WHERE inventario.`delete` = 0 AND inventario.linea = lineas.id AND inventario.buque = buques.id AND inventario.buqued = buques.id AND inventario.viaje = viajes.id AND inventario.tcont = tequipos.id AND inventario.patio = patios.id AND inventario.`consignatario` = consignatario.id AND inventario.fdespims BETWEEN '%s' AND '%s' AND inventario.linea = %d ORDER BY inventario.frd ASC;",$inicio,$fin,$linea);
	$inventario->Consultar($cadenaSQL);
	if($inventario->TotalResultados > 0){
		$mostrar = true;
	}
	
	$recaps20 = new DBsPOO();
	$recaps20->Conectar(UDB,PDB);
	$recaps20->SelectDB(USERDB);
	$sql = sprintf("SELECT tequipos.tipo, count(inventario.tcont) AS cantidad FROM inventario, tequipos WHERE inventario.tcont = tequipos.id AND inventario.`delete` = 0 AND tequipos.tipo LIKE '2%%' AND inventario.fdespims BETWEEN '%s' AND '%s' AND inventario.linea = %d GROUP BY inventario.tcont ORDER BY tequipos.tipo ASC;",$inicio,$fin,$linea);
	$recaps20->Consultar($sql);
	
	$recaps40 = new DBsPOO();
	$recaps40->Conectar(UDB,PDB);
	$recaps40->SelectDB(USERDB);
	$sql = sprintf("SELECT tequipos.tipo, count(inventario.tcont) AS cantidad FROM inventario, tequipos WHERE inventario.tcont = tequipos.id AND inventario.`delete` = 0 AND tequipos.tipo LIKE '4%%' AND inventario.fdespims BETWEEN '%s' AND '%s' AND inventario.linea = %d GROUP BY inventario.tcont ORDER BY tequipos.tipo ASC;",$inicio,$fin,$linea);
	$recaps40->Consultar($sql);
	
	if(isset($_GET['exp']) and $_GET['exp'] == 1){
		//exportar a excel
		header('Content-type: application/vnd.ms-excel');
		header("Content-Disposition: attachment; filename=inventarioGral.xls");
		header("Pragma: no-cache");
		header("Expires: 0");
	}
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
  <!--Ini-->
  <div class="row">
    <div class="col-sm-12">
      <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1"> <span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span> </button>
          <a class="navbar-brand" href="#"><span class="text-primary">Ayaguna</span></a> </div>
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
          <ul class="nav navbar-nav">
            <li class="active"><a href="../inicio.php">Regresar</a></li>
            <?php if(isset($inventario)){?>
            <li><a href="egresos_lineasExp.php?linea=<?php echo $_POST['lineas'];?>&f1=<?php echo $_POST['ini'];?>&f2=<?php echo $_POST['fin'];?>" id="exportar">Exportar</a></li>
            <?php } ?>
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
    <div class="col-sm-10"> 
      <!--form-->
      <form class="form-inline" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" name="rangofecha" id="rangofecha" onKeyPress="Noenter();">
        <fieldset>
          <legend>Linea y rango de Fecha</legend>
          <div class="form-group">
            <select class="form-control" name="lineas" required id="lineas">
              <option value="">Seleccion/Linea</option>
              <?php while($lineas->Resultados()){ ?>
              <?php if($lineas->Resultados['linea'] == $_POST['linea']){ ?>
              <option value="<?php echo $lineas->Resultados['id']; ?>" selected><?php echo $lineas->Resultados['linea']; ?></option>
              <?php }else { ?>
              <option value="<?php echo $lineas->Resultados['id']; ?>"><?php echo $lineas->Resultados['linea']; ?></option>
              <?php } ?>
              <?php } ?>
            </select>
          </div>
          <div class="form-group input-group">
            <label class="input-group-addon" for="ini">Inicio:</label>
            <?php if(isset($_POST['ini'])){ $ini = $_POST['ini']; }else { $ini = AHORAC; } ?>
            <input class="form-control" name="ini" type="date" required id="ini" value="<?php echo $ini; ?>" max="<?php echo AHORAC; ?>">
          </div>
          <div class="form-group input-group">
            <label class="input-group-addon" for="fin">Final:</label>
            <?php if(isset($_POST['fin'])){ $final = $_POST['fin']; }else { $final = AHORAC; } ?>
            <input class="form-control" name="fin" type="date" required="required" id="fin" value="<?php echo $final; ?>" max="<?php echo AHORAC; ?>">
          </div>
          <button class="btn btn-primary" type="submit" name="submit" id="submit" value="Enviar">&nbsp;<span class="glyphicon glyphicon-search"></span>&nbsp;</button>
        </fieldset>
      </form>
    </div>
  </div>
  <?php if($mostrar == true) { ?>
  <div class="row">
    <h3>Egresos - Lineas</h3>
    <div class="col-sm-4"> 
      <!--Recento 20-->
      <?php if($recaps20->TotalResultados > 0){ ?>
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
    <div class="col-sm-4"> 
      <!--Recento 40-->
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
    <div class="col-sm-4"> </div>
  </div>
  <div class="row">
    <div class="col-xs-12"> 
      <!--Inventario-->
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
        Listado de Equipos: <?php echo $inventario->TotalResultados; ?> ingresados
        </caption>
        <thead>
          <tr>
            <th data-field="#" data-sortable="true" data-sorter="alphanum" scope="col" class="header">#</th>
            <th data-field="linea" data-sortable="true" data-searchable="true" data-sorter="alphanum" scope="col" class="header">Linea</th>
            <th data-field="buque" data-sortable="true" data-searchable="true" data-sorter="alphanum" scope="col" class="header">Buque</th>
            <th data-field="viaje" data-sortable="true" data-searchable="true" data-sorter="alphanum" scope="col" class="header">Viaje</th>
            <th data-field="contenedor" data-sortable="true" data-searchable="true" data-sorter="alphanum" scope="col" class="header">Contenedor</th>
            <th data-field="tipo" data-sortable="true" data-searchable="true" data-sorter="alphanum" scope="col" class="header">Tipo</th>
            <th data-field="fdb" data-sortable="true" data-searchable="true" data-sorter="alphanum" scope="col" class="header">Fdb</th>
            <th data-field="fdm" data-sortable="true" data-searchable="true" data-sorter="alphanum" scope="col" class="header">Fdm</th>
            <th data-field="fdr" data-sortable="true" data-searchable="true" data-sorter="alphanum" scope="col" class="header">Fdr</th>
            <th data-field="fdes" data-sortable="true" data-searchable="true" data-sorter="alphanum" scope="col" class="header">Fdes</th>
            
            <th data-field="buquedesp" data-sortable="true" data-searchable="true" data-sorter="alphanum" scope="col" class="header">Buque</th>
            <th data-field="viajed" data-sortable="true" data-searchable="true" data-sorter="alphanum" scope="col" class="header">Viaje</th>
            
            <th data-field="fact" data-sortable="true" data-searchable="true" data-sorter="alphanum" scope="col" class="header">Fact.</th>
            <!-- Requerimiento INTERCONTAINERS -->
            <th data-field="pase" data-sortable="true" data-searchable="true" data-sorter="alphanum" scope="col" class="header">Pase</th>
            <!-- Requerimiento INTERCONTAINERS -->
            <th data-field="eir" data-sortable="true" data-searchable="true" data-sorter="alphanum" scope="col" class="header">EIR</th>
            <th data-field="est" data-sortable="true" data-searchable="true" data-sorter="alphanum" scope="col" class="header">Est.</th>
            <th data-field="cond" data-sortable="true" data-searchable="true" data-sorter="alphanum" scope="col" class="header">Cond.</th>
            <th data-field="pre" data-sortable="true" data-searchable="true" data-sorter="alphanum" scope="col" class="header">Pre.</th>
            <th data-field="b/l" data-sortable="true" data-searchable="true" data-sorter="alphanum" scope="col" class="header">B/L</th>
            <th data-field="patio" data-sortable="true" data-searchable="true" data-sorter="alphanum" scope="col" class="header">Patio</th>
            <th data-field="consig" data-sortable="true" data-searchable="true" data-sorter="alphanum" scope="col" class="header">Consig.</th>
            <th data-field="obs" data-sortable="true" data-searchable="true" data-sorter="alphanum" scope="col" class="header">Obs.</th>
            <th data-field="da" data-sortable="true" data-searchable="true" data-sorter="alphanum" scope="col" class="header">DA.</th>
            <th data-field="dp" data-sortable="true" data-searchable="true" data-sorter="alphanum" scope="col" class="header">DP.</th>
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
            <th colspan="2" scope="col">&nbsp;</th>
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
          <td scope="strd"><?php echo $inventario->Resultados['fdespims']; ?></td>
          <td scope="strd"><?php echo $inventario->Resultados['buquedesp']; ?></td>
          <td scope="strd"><?php echo $inventario->Resultados['viajed']; ?></td>
          <td scope="num"><?php echo $inventario->Resultados['fact']; ?></td>
          <td scope="num"><?php echo $inventario->Resultados['pase']; ?></td>
          <td scope="num"><?php echo $inventario->Resultados['eir_r']; ?></td>
          <td scope="strd"><?php Estatus($inventario->Resultados['status']); ?></td>
          <td scope="strd"><?php Condiciones($inventario->Resultados['condicion']); ?></td>
          <td scope="strd"><?php echo $inventario->Resultados['precinto']; ?></td>
          <td scope="strn"><?php echo $inventario->Resultados['bl']; ?></td>
          <td scope="strn"><small><?php echo $inventario->Resultados['patio']; ?></small></td>
          <td scope="btxt"><small><?php echo $inventario->Resultados['consig']; ?></small></td>
          <td><a href="#" data-toggle="tooltip" data-placement="auto" title="<?php echo $inventario->Resultados['obs']; ?>"><small>Ver</small></a></td>
          <td scope="num" data-align="right"><span id="da">
            <?php FechaDif($inventario->Resultados['frd'],$inventario->Resultados['fdespims']); ?>
            </span></td>
          <td scope="num" data-align="right"><span id="dp">
            <?php FechaDif($inventario->Resultados['fdb'],$inventario->Resultados['fdespims']);?>
            </span></td>
        </tr>
        <?php } ?>
      </table>
    </div>
  </div>
  <?php } ?>
  <!--Fin--> 
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
<small><?php if(isset($inventario)){ echo "Segundos: " . round($inventario->TiempoEjecucion(),4); } ?></small>
</body>
<?php $cache->cerrar(); ?>
</html>
<?php
if(isset($_POST['ini']) and isset($_POST['fin'])){
	//Liberar
	$inventario->Liberar();
	$recaps20->Liberar();
	$recaps40->Liberar();
	//cerrar
	$inventario->Cerrar();
	$recaps20->Cerrar();
	$recaps40->Cerrar();
}
?>