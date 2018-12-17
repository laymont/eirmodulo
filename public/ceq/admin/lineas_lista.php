<?php
session_start();
session_name($_SESSION['variables']['usuario']);
require_once('../config.php');
require_once('../clases/class_Conexion.php');
#Seguridad
$seguridad = new Seguridad();
$seguridad->ValidarUsuario();

#Lineas Activas
$lineasActivas = new DBMySQL();
$lineasActivas->Datosconexion(UDB,PDB,USERDB);
$sql = "SELECT id, rif, nombre, agencia, dlibres FROM lineas WHERE lineas.activo = 0;";
$lineasActivas->Consulta($sql);

#Lineas Inactivas
$lineasInactivas = new DBMySQL();
$lineasInactivas->Datosconexion(UDB,PDB,USERDB);
$sql = "SELECT id, rif, nombre, agencia, dlibres FROM lineas WHERE lineas.activo = 1;";
$lineasInactivas->Consulta($sql);
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
	
	$("nav.navbar-fixed-top").autoHidingNavbar();
	
	$('[data-toggle="tooltip"]').tooltip();
	
});
</script>
</head>
<body>
<div class="container">
<div class="row">
    <div class="col-sm-12">
      <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1"> <span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span> </button>
          <a class="navbar-brand" href="#"><span class="text-primary">Ayaguna</span></a> </div>
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
          <ul class="nav navbar-nav">
            <li class="active"><a href="../inicio.php">Regresar</a></li>
            <!--<li><a href="inventarioExp.php" id="exportar">Exportar</a></li>-->
          </ul>
        </div>
      </nav>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <h3>&nbsp; </h3>
    </div>
  </div><!--Menu-->
  <div class="row">
  <div class="col-sm-8">
    <div class="panel-heading">
      <ul class="nav nav-tabs">
        <li class="active"><a href="#tab1default" data-toggle="tab">Lineas Activas</a></li>
        <li><a href="#tab2default" data-toggle="tab">Lineas Desactivadas</a></li>
        </li>
      </ul>
    </div>
    <div class="panel-body">
      <div class="tab-content">
        <div class="tab-pane fade in active" id="tab1default">
          <h2>Activas</h2>
          <table id="activas" class="table table-bordered table-condensed table-hover sortable bootstrap-table" 
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
            <thead>
            <tr>
              <th data-field="id" data-sortable="true" data-sorter="alphanum" scope="col">Id</th>
              <th data-field="rif" data-sortable="true" data-searchable="true" data-sorter="alphanum" scope="col">RIF</th>
              <th data-field="nombre" data-sortable="true" data-searchable="true" data-sorter="alphanum" scope="col">Nombre</th>
              <th data-field="agencia" data-sortable="true" data-searchable="true" data-sorter="alphanum" scope="col">Agencia</th>
              <th data-field="libres" data-sortable="true" data-searchable="true" data-sorter="alphanum" scope="col">D. libres</th>
            </tr>
            </thead>
            <tbody>
            <?php do{ ?>
            <tr>
              <td scope="num"><?php echo $lineasActivas->Filas['id']; ?></td>
              <td scope="str"><?php echo $lineasActivas->Filas['rif']; ?></td>
              <td scope="str"><?php echo $lineasActivas->Filas['nombre']; ?></td>
              <td scope="str"><?php echo $lineasActivas->Filas['agencia']; ?></td>
              <td scope="num"><?php echo $lineasActivas->Filas['dlibres']; ?></td>
            </tr>
            <?php } while ($lineasActivas->Filas = mysqli_fetch_assoc($lineasActivas->Consulta)); ?>
            </tbody>
          </table>
        </div>
        <div class="tab-pane fade" id="tab2default">
          <h2>Inactivas</h2>
          <table id="inactivas" class="table table-bordered table-condensed table-hover sortable bootstrap-table" 
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
            <thead>
            <tr>
              <th data-field="id" data-sortable="true" data-sorter="alphanum" scope="num">Id</th>
              <th data-field="rif" data-sortable="true" data-searchable="true" data-sorter="alphanum" scope="str">RIF</th>
              <th data-field="nombre" data-sortable="true" data-searchable="true" data-sorter="alphanum" scope="str">Nombre</th>
              <th data-field="agencia" data-sortable="true" data-searchable="true" data-sorter="alphanum" scope="str">Agencia</th>
              <th data-field="libres" data-sortable="true" data-searchable="true" data-sorter="alphanum" scope="num">D. libres</th>
            </tr>
            </thead>
            <tbody>
            <?php do{ ?>
            <tr>
              <td scope="num"><?php echo $lineasInactivas->Filas['id']; ?></td>
              <td scope="str"><?php echo $lineasInactivas->Filas['rif']; ?></td>
              <td scope="str"><?php echo $lineasInactivas->Filas['nombre']; ?></td>
              <td scope="str"><?php echo $lineasInactivas->Filas['agencia']; ?></td>
              <td scope="num"><?php echo $lineasInactivas->Filas['dlibres']; ?></td>
            </tr>
            <?php } while ($lineasInactivas->Filas = mysqli_fetch_assoc($lineasInactivas->Consulta)); ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
</div><!--Container-->
<script>
var $table = $('.table');
$(function () {
	$table.on('click-row.bs.table', function (e, row, $element) {
		$('.success').removeClass('success');
		$($element).addClass('success');
	});
});
</script>
</body>
</html>