<?php
session_start();
session_name($_SESSION['variables']['usuario']);
require_once('../config.php');
require_once('../clases/class_Conexion.php');
#Seguridad
$seguridad = new Seguridad();
$seguridad->ValidarUsuario();

#Lista de consignatario
$consig = new DBMySQL();
$consig->Datosconexion(UDB,PDB,USERDB);
$sql = "SELECT id, rif, nombre, libre, pcontacto, email, telf FROM consignatario ORDER BY nombre;";
$consig->Consulta($sql);
$mostrar = $consig->Num_resultados;
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
	var $table = $('#table');
	
	$("nav.navbar-fixed-top").autoHidingNavbar();	
	
	$(function () {
		$table.on('click-row.bs.table', function (e, row, $element) {
			$('.success').removeClass('success');
			$($element).addClass('success');
		});
	});
});
</script>
</head>

<body>
<div class="container">
 <!--Menu-->
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
 <!--Menu-->
 <div class="row">
  <div class="col-sm-10">
   <h3>Consignatarios</h3>
   <table id="table" class="table table-bordered table-condensed table-hover sortable bootstrap-table table-responsive" 
               data-toggle="table"
               data-url='../json/consignatarioJson.php'
               data-side-pagination="client"
               data-show-columns="true"
               data-show-toggle="true"
               data-show-export="true"
               data-search="true"
               data-pagination="true"
               data-key-events="true"
               data-sortable="true"
               data-sort-name="nombre"
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
               data-locale="es-SP"
               data-height="470">
    <caption>
    Listado
    | Cantidad: <?php echo $mostrar; ?>
    </caption>
    <thead>
     <tr>
      <th data-field="id" data-sortable="true" data-searchable="true" data-sorter="alphanum" scope="col">ID</th>
      <th data-field="rif" data-sortable="true" data-searchable="true" data-sorter="alphanum" scope="col">RIF</th>
      <th data-field="nombre" data-sortable="true" data-searchable="true" data-sorter="alphanum" scope="col">Nombre</th>
      <th data-field="libre" data-sortable="true" data-searchable="true" data-sorter="alphanum" scope="col">Libre</th>
      <th data-field="contacto" data-sortable="true" data-searchable="true" data-sorter="alphanum" scope="col">P.Contacto</th>
      <th data-field="correo" data-sortable="true" data-searchable="true" data-sorter="alphanum" scope="col">Correo</th>
      <th data-field="telf" data-sortable="true" data-searchable="true" data-sorter="alphanum" scope="col">Telf.</th>
     </tr>
    </thead>
   </table>
  </div>
 </div>
</div>
<script>
$(function () {
	$table.bootstrapTable('showLoading');

        $button2.click(function () {
            $table.bootstrapTable('hideLoading');
        });
    });
</script>
</body>
</html>