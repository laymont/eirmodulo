<?php
session_start();
session_name($_SESSION['variables']['usuario']);
require_once('../config.php');
require_once('../clases/class_Conexion.php');
#Seguridad
$seguridad = new Seguridad();
$seguridad->ValidarUsuario();

#Lineas
$lineas = new DBMySQL();
$lineas->Datosconexion(UDB,PDB,USERDB);
$lineas->Consulta("SELECT id, nombre FROM lineas WHERE activo = 0 ORDER BY nombre ASC;");

if(isset($_POST['linea'])){
	$id = $_POST['linea'];
	#Buques
	$buques = new DBMySQL();
	$buques->Datosconexion(UDB,PDB,USERDB);
	$sql = sprintf("SELECT id, nombre FROM buques where nombre REGEXP '[[:alnum:]_[:digit:]]{1,50}' and linea = %d and activo = 0 ORDER BY nombre ASC;",$id);
	$buques->Consulta($sql);
	$mostrar = $buques->Num_resultados;
	
	/* Buque Duplicado */
	$duplicado = new DBMySQL();
	
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
<div class="container-fluid">
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
      <li><a href="buques_nuevo.php">Nuevo Buque</a></li>
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
 <!--Formulario-->
 <div class="row">
  <div class="col-sm-4">
   <form class="form-inline" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" name="form1" id="formLinea" onKeyPress="Noenter();">
    <fieldset>
     <legend>Buques/Lista</legend>
     <div class="form-group">
      <select required aria-required="true" class="form-control" name="linea" id="linea">
       <option>Linea/Seleccion</option>
       <?php do { ?>
       <?php if(isset($_POST['linea']) and $_POST['linea'] == $lineas->Filas['id']){ ?>
       <option value="<?php echo $lineas->Filas['id']; ?>" selected><?php echo $lineas->Filas['nombre']; ?></option>
       <?php }else { ?>
       <option value="<?php echo $lineas->Filas['id']; ?>"><?php echo $lineas->Filas['nombre']; ?></option>
       <?php } ?>
       <?php } while ($lineas->Filas = mysqli_fetch_assoc($lineas->Consulta)); ?>
      </select>
     </div>
     <button class="btn btn-default" type="submit" name="submit" id="submit" value="1">Ver</button>
    </fieldset>
   </form>
  </div>
 </div>
 <!--Formulario--> 
 <br>
 <div class="row">
  <div class="col-sm-6 col-xs-offset-1">
   <?php if($mostrar > 0){ ?>
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
               data-locale="es-SP">
    <caption>
    Lista
    </caption>
    <thead>
     <tr>
      <th data-field="id" data-sortable="true" data-sorter="alphanum" scope="col">Id</th>
      <th data-field="nombre" data-sortable="true" data-searchable="true" data-sorter="alphanum" scope="col">Nombre</th>
     </tr>
    </thead>
    <tbody>
     <?php do{ ?>
     <tr>
      <td scope="num"><?php echo $buques->Filas['id']; ?></td>
      <td scope="str"><?php echo $buques->Filas['nombre']; ?></td>
     </tr>
     <?php } while ($buques->Filas = mysqli_fetch_assoc($buques->Consulta)); ?>
    </tbody>
   </table>
   <?php } ?>
  </div>
 </div>
</div>
<script>
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