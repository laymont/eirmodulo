<?php
session_start();
session_name($_SESSION['variables']['usuario']);
require_once('../config.php');
require_once('../clases/class_Conexion.php');
#Seguridad
$seguridad = new Seguridad();
$seguridad->ValidarUsuario();

#Linea
$linea = new DBMySQL();
$linea->Datosconexion(UDB,PDB,USERDB);
$sql = "SELECT id, nombre FROM lineas WHERE activo = 0 ORDER BY nombre ASC;";
$linea->Consulta($sql);


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
$(document).ready(function() {
	$('#submit').click(function(e) {
            $('#linea option:selected').each(function() {
                seleccion = $(this).val();
				
				$.post( "../json/listaprecargaJson.php").done(function() {
					$('#table').bootstrapTable('refresh',{
						silent : true,
						query: { term: seleccion },
						url: '../json/listaprecargaJson.php'
					});
				});
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
  </div>
  <!--Menu-->
  <div class="row">
    <div class="col-sm-6"> 
      <!--Formulario-->
      <form class="form-inline" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" name="buscar" id="buscar">
        <fieldset>
          <legend>Seleccione la Linea</legend>
          <div class="form-group">
            <label class="control-label" for="linea">Linea:</label>
            <select name="linea" id="linea" class="form-control">
              <option>Seleccion</option>
              <?php do { ?>
              <?php if(isset($_POST['linea']) and $_POST['linea'] == $linea->Filas['id']){  ?>
              <option value="<?php echo $linea->Filas['id']; ?>" selected><?php echo $linea->Filas['nombre']; ?></option>
              <?php }else { ?>
              <option value="<?php echo $linea->Filas['id']; ?>"><?php echo $linea->Filas['nombre']; ?></option>
              <?php } ?>
              <?php } while ($linea->Filas = mysqli_fetch_assoc($linea->Consulta)); ?>
            </select>
          </div>
          <button class="btn btn-default" type="button" id="submit" value="enviar"><span class="glyphicon glyphicon-search"></span></button>
        </fieldset>
      </form>
      <!--Formulario--> 
    </div>
  </div>
  <div class="row"> 
    <!--Resultados-->
    <div class="col-sm-10">
      
      <h3>Precargados</h3>
      <?php ?>
      <table id="table" class="table table-bordered table-condensed table-hover sortable bootstrap-table" 
               data-toggle="table"
               
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
        Listado de Equipos: <?php echo $lista->Num_resultados; ?>
        </caption>
        <thead>
          <tr>
            <th data-field="#" data-sortable="true" data-searchable="true" data-sorter="alphanum" scope="col">#</th>
            <th data-field="buque" data-sortable="true" data-searchable="true" data-sorter="alphanum" scope="col">Buque</th>
            <th data-field="viaje" data-sortable="true" data-searchable="true" data-sorter="alphanum" scope="col">Viaje</th>
            <th data-field="contenedor" data-sortable="true" data-searchable="true" data-sorter="alphanum" scope="col">Contenedor</th>
            <th data-field="tipo" data-sortable="true" data-searchable="true" data-sorter="alphanum" scope="col">Tipo</th>
            <th data-field="consignatario" data-sortable="true" data-searchable="true" data-sorter="alphanum" scope="col">Consig.</th>
          </tr>
        </thead>
        
      </table>

    </div>
    <!--Resultados--> 
  </div>
</div>
<script>
$(document).ready(function() {
	$('[data-toggle="tooltip"]').tooltip();
	
	$("nav.navbar-fixed-top").autoHidingNavbar();
});
</script>
</body>
</html>