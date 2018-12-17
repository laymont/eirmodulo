<?php
session_start();
session_name($_SESSION['variables']['usuario']);
require_once ("../config.php");
require_once ("../clases/class_DbPoo.php");
require_once('../funciones/funciones.php');

$recaps20 = new DBsPOO();
$recaps20->Conectar(UDB,PDB);
$recaps20->SelectDB(USERDB);
$recaps20->Consultar("SELECT tipo, count(tipo) AS cantidad FROM existenciaNew WHERE tipo LIKE '2%'  GROUP BY tipo ORDER BY tipo;");

$recaps40 = new DBsPOO();
$recaps40->Conectar(UDB,PDB);
$recaps40->SelectDB(USERDB);
$recaps40->Consultar("SELECT tipo, count(tipo) AS cantidad FROM existenciaNew WHERE tipo LIKE '4%'  GROUP BY tipo ORDER BY tipo;");

$tabla = new DBsPOO();
$tabla->Conectar(UDB,PDB);
$tabla->SelectDB(USERDB);
$tabla->Consultar("SELECT * FROM existenciaNew LIMIT 1;");
$tabla->ResultArray();
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
<link rel="stylesheet" type="text/css" href="../bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="../bootstrap/table_v1.10.1/bootstrap-table.min.css">

<!--Scripts-->
<script src="../js/jquery-1.11.3.min.js"></script>
<script src="../bootstrap/js/bootstrap.min.js"></script>
<script src="../bootstrap/table_v1.10.1/bootstrap-table.min.js"></script>
<script src="../bootstrap/table_v1.10.1/locale/bootstrap-table-es-MX.min.js"></script>
<script src="../bootstrap/table_v1.10.1/extensions/export/bootstrap-table-export.min.js"></script>
<script src="../bootstrap/table/tableExport.js"></script>
<script src="../bootstrap/table_v1.10.1/extensions/filter-control/bootstrap-table-filter-control.js"></script>
<style>
body {
	font-family: Segoe, "Segoe UI", "DejaVu Sans", "Trebuchet MS", Verdana, sans-serif;
}
th {
	font-size: 12px;
}
td {
	font-size: 11px;
}
</style>
</head>
<body>
<nav class="navbar navbar-default" role="navigation">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1"> <span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span> </button>
          <a class="navbar-brand" href="#"><span class="text-primary">Ayaguna</span></a> </div>
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
          <ul class="nav navbar-nav">
            <li class="active"><a href="file:///C|/httpdoc/inicio.php">Regresar</a></li>
          </ul>
        </div>
      </nav>
<div class="container-fluid">
  <dir class="row">
  <div class="col-sm-3">
    <table class="table table-bordered table-condensed table-responsive">
    <caption>Resumen 20</caption>
      <thead>
        <tr>
          <th>Tipo</th>
          <th>Cantidad</th>
        </tr>
      </thead>
      <tbody>
        <?php while($recaps20->Resultados()){ ?>
        <tr>
          <td><?php echo $recaps20->Resultados['tipo'] ?></td>
          <td align="right"><?php $suma20 = $suma20 + $recaps20->Resultados['cantidad']; echo $recaps20->Resultados['cantidad']; ?></td>
        </tr>
        <?php } ?>
      </tbody>
      <tfoot>
        <tr>
          <td>Total:</td>
          <td align="right"><?php echo $suma20;?></td>
        </tr>
      </tfoot>
    </table>
  </div>
  <div class="col-sm-3">
    <table class="table table-bordered table-condensed table-hover">
    <caption>Resumen 40</caption>
      <thead>
        <tr>
          <th>Tipo</th>
          <th>Cantidad</th>
        </tr>
      </thead>
      <tbody>
        <?php while($recaps40->Resultados()){ ?>
        <tr>
          <td><?php echo $recaps40->Resultados['tipo'] ?></td>
          <td align="right"><?php $suma40 = $suma40 + $recaps40->Resultados['cantidad']; echo $recaps40->Resultados['cantidad']; ?></td>
        </tr>
        <?php } ?>
      </tbody>
      <tfoot>
        <tr>
          <td>Total:</td>
          <td align="right"><?php echo $suma40;?></td>
        </tr>
      </tfoot>
    </table>
  </div>
  <div class="col-sm-3 col-sm-offset-3">
    <div class="collapse" id="collapseExample">
      <div class="panel-body">
        <ul class="list-group">
          <li class="list-group-item"><span class="glyphicon glyphicon-collapse-down"></span> Paginación On/Off </li>
          <li class="list-group-item"><span class="glyphicon glyphicon-refresh"></span> Refresh </li>
          <li class="list-group-item"><span class="glyphicon glyphicon-th"></span> Seleccionar campos </li>
          <li class="list-group-item"><span class="glyphicon glyphicon-export"></span> Exportar </li>
        </ul>
      </div>
    </div>
  
  </div>
  </dir>
  <div class="row">
    <div class="col-sm-12">
      <div id="toolbar">
        <button id="button" class="btn btn-default"><span class="glyphicon glyphicon-eye-open"></span> Obs</button>
        <button id="button2" class="btn btn-default"><span class="glyphicon glyphicon-eye-close"></span> Obs</button>
        <button id="filtros" class="btn btn-default"><span class="glyphicon glyphicon-filter"></span> Filtrar </button>
        <button id="filtros2" class="btn btn-default"><span class="glyphicon glyphicon-filter"></span> No Filtrar </button>
        <button class="btn btn-default" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample"><span class="glyphicon glyphicon-list-alt"></span> Leyenda </button>
      </div>
      <table id="table" class="table table-bordered table-condensed table-responsive table-striped" 
      	data-toggle="table"
        data-toolbar="#toolbar" 
        data-url="prueba_query.php"
        data-sortable="true"
        data-sort-name="id" 
        data-sort-order="desc"
        data-search="true"
        data-pagination="true"
        data-pagination-v-align="both"
        data-show-pagination-switch="true"
        data-page-size="50"
        data-height="570"
        data-show-export="true"
        data-show-columns="true"
        data-show-refresh="true"
        data-key-events="true"
        data-mobile-responsive="true"
        data-check-on-init="true"
        data-pagination-first-text="Inicio"
        data-pagination-pre-text="Previo"
        data-pagination-next-text="Siguiente"
        data-pagination-last-text="Ultimo"
        data-maintain-selected="true"
        data-locale="es-MX">
        <?php echo $tabla->Thead(); ?>
      </table>
    </div>
    <script>
    var $table = $('#table'),
        $button = $('#button'),
        $button2 = $('#button2'),
				$button3 = $('#filtros'),
				$button4 =$('#filtros2');
				
    $(function () {
			$('thead').addClass('bg-info');
			$('tfoot').addClass('bg-success');
			
			$table.on('click-row.bs.table', function (e, row, $element) {
				$('.success').removeClass('success');
				$($element).addClass('success');
			});
			
			
			$table.bootstrapTable('hideColumn', 'id');
			$table.bootstrapTable('hideColumn', 'precinto');
			$table.bootstrapTable('hideColumn', 'obs');
			
        $button.click(function () {
            $table.bootstrapTable('showColumn', 'obs');
        });
        $button2.click(function () {
            $table.bootstrapTable('hideColumn', 'obs');
        });
				$button3.click(function () {
					$table.bootstrapTable('destroy');
					$table.data('filter-control',true);
					$table.bootstrapTable();
					$table.bootstrapTable('hideColumn', 'id');
					$table.bootstrapTable('hideColumn', 'precinto');
					$table.bootstrapTable('hideColumn', 'obs');
				});
				$button4.click(function () {
					$table.bootstrapTable('destroy');
					$table.data('filter-control',false);
					$table.bootstrapTable();
					$table.bootstrapTable('hideColumn', 'id');
					$table.bootstrapTable('hideColumn', 'precinto');
					$table.bootstrapTable('hideColumn', 'obs');
				});
    });
</script> 
  </div>
</div>
<?php 
$cache->cerrar();
$recaps20->Liberar();
$recaps20->Cerrar();
$recaps40->Liberar();
$recaps40->Cerrar(); 
?>
</body>
</html>