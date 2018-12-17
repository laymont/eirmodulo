<?php
session_start();
session_name($_SESSION['variables']['usuario']);
require_once('../config.php');
require_once('../clases/class_Conexion.php');
require_once('../funciones/funciones.php');
#Seguridad
$seguridad = new Seguridad();
$seguridad->ValidarUsuario();

#Linea
if($_SESSION['variables']['nivel'] != 6){
	$lineas = new DBMySQL();
	$lineas->Datosconexion(UDB,PDB,USERDB);
	$lineas->Consulta("SELECT id, nombre FROM lineas WHERE activo = 0;");
	if(isset($_POST['linea']) and isset($_POST['inicio']) and isset($_POST['fin'])){
		$linea = $_POST['linea'];
		$inicio = $_POST['inicio'];
		$fin = $_POST['fin'];
		$asignados = new DBMySQL();
		$asignados->Datosconexion(UDB,PDB,USERDB);
		$sql = sprintf("SELECT * FROM asignados WHERE linea = %d AND fdespims BETWEEN '%s' AND '%s';",$linea,$inicio,$fin);
		$asignados->Consulta($sql);
		$mostrar = $asignados->Num_resultados;	
	}
}else {
	$idLinea = $_SESSION['variables']['linea'];
	$lineas = new DBMySQL();
	$lineas->Datosconexion(UDB,PDB,USERDB);
	//$lineas->Consulta("SELECT id, nombre FROM lineas WHERE activo = 0;");
	$sql = sprintf("SELECT id, nombre FROM lineas WHERE id = %d AND activo = 0;", $idLinea);
	$lineas->Consulta($sql);
	
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
          <a class="navbar-brand" href="#"><span class="text-primary">Ayaguna</span></a> </div>
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
          <ul class="nav navbar-nav">
            <li class="active"><a href="../inicio.php">Regresar</a></li>
            <?php if(isset($asignados)){ ?>
            <li><a href="egresos_asignacionExp.php?linea=<?php echo $_POST['linea'];?>&f1=<?php echo $_POST['inicio'];?>&f2=<?php echo $_POST['fin'];?>" id="exportar">Exportar</a></li>
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
    <!--form-->
    <div class="col-sm-10">
      <form class="form-inline" method="post" name="formAsig" id="formAsig" onKeyPress="Noenter();" role="form">
        <fieldset>
          <legend>Defina Línea y rango de Fecha</legend>
          <div class="form-group">
          <select class="form-control" name="linea" required id="linea">
            <option value="">Seleccion/Linea</option>
            <?php do{ ?>
            <option value="<?php echo $lineas->Filas['id']; ?>"><?php echo $lineas->Filas['nombre']; ?></option>
            <?php } while ($lineas->Filas = mysqli_fetch_assoc($lineas->Consulta)); ?>
          </select>
          </div>
          <div class="form-group input-group">
          <label class="input-group-addon" for="inicio">Inicio:</label>
          <input class="form-control" type="date" name="inicio" id="inicio" value="<?php echo AHORAC; ?>" max="<?php echo AHORAC; ?>">
          </div>
          <div class="form-group input-group">
          <label class="input-group-addon" for="fin">Fin:</label>
          <input class="form-control" type="date" name="fin" id="fin" value="<?php echo AHORAC; ?>" max="<?php echo AHORAC; ?>">
          </div>
          <button class="btn btn-primary" type="submit" name="submit" id="submit" value="Enviar">&nbsp;<span class="glyphicon glyphicon-search"></span>&nbsp;</button>
        </fieldset>
      </form>
    </div>
  </div>
  <?php if($mostrar > 0){ ?>
  <div class="row">
    <h3>Reporte Asignaciones</h3>
    <!--Resumen--> 
  </div>
  <div class="row"> 
    <!--tabla-->
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
        Listado <?php echo $asignados->Filas['nlinea'] .' Total: ' . $asignados->Num_resultados;; ?>
        </caption>
        <thead>
          <tr>
            <th data-field="#" data-sortable="true" data-sorter="alphanum" scope="col" class="header">#</th>
            <th data-field="buque" data-sortable="true" data-searchable="true" data-sorter="alphanum" scope="col" class="header">Buque</th>
            <th data-field="viaje" data-sortable="true" data-searchable="true" data-sorter="alphanum" scope="col" class="header">Viaje</th>
            <th data-field="contenedor" data-sortable="true" data-searchable="true" data-sorter="alphanum" scope="col" class="header">Contenedor</th>
            <th data-field="tipo" data-sortable="true" data-searchable="true" data-sorter="alphanum" scope="col" class="header">Tipo</th>
            <th data-field="estatus" data-sortable="true" data-searchable="true" data-sorter="alphanum" scope="col" class="header">Estatus</th>
            <th data-field="cond" data-sortable="true" data-searchable="true" data-sorter="alphanum" scope="col" class="header">Cond.</th>
            <th data-field="eir_r" data-sortable="true" data-searchable="true" data-sorter="alphanum" scope="col" class="header">EIR</th>
            <th data-field="fdb" data-sortable="true" data-searchable="true" data-sorter="alphanum" scope="col" class="header">Fdb</th>
            <th data-field="fdm" data-sortable="true" data-searchable="true" data-sorter="alphanum" scope="col" class="header">Fdm</th>
            <th data-field="frd" data-sortable="true" data-searchable="true" data-sorter="alphanum" scope="col" class="header">Frd</th>
            <th data-field="fdesp" data-sortable="true" data-searchable="true" data-sorter="alphanum" scope="col" class="header">Fdesp</th>
            <th data-field="eir_d" data-sortable="true" data-searchable="true" data-sorter="alphanum" scope="col" class="header">Eir</th>
            <th data-field="booking" data-sortable="true" data-searchable="true" data-sorter="alphanum" scope="col" class="header">Booking</th>
            <th data-field="cliente" data-sortable="true" data-searchable="true" data-sorter="alphanum" scope="col" class="header">Cliente</th>
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
          </tr>
        </tfoot>
        <?php do{ ?>
        <tr>
          <td scope="num"><?php echo ++$contador; ?></td>
          <td scope="strn"><?php echo $asignados->Filas['buque']; ?></td>
          <td scope="strd"><?php echo $asignados->Filas['viaje']; ?></td>
          <td scope="strn"><?php echo $asignados->Filas['contenedor']; ?></td>
          <td scope="strd"><?php echo $asignados->Filas['tipo']; ?></td>
          <td scope="strd"><?php echo $asignados->Filas['estatus']; ?></td>
          <td scope="strd"><?php echo $asignados->Filas['condicion']; ?></td>
          <td scope="num"><?php echo $asignados->Filas['eir_r']; ?></td>
          <td scope="strd"><?php echo $asignados->Filas['fdb']; ?></td>
          <td scope="strd"><?php echo $asignados->Filas['fdm']; ?></td>
          <td scope="strd"><?php echo $asignados->Filas['frd']; ?></td>
          <td scope="strd"><?php echo $asignados->Filas['fdespims']; ?></td>
          <td scope="num"><?php echo $asignados->Filas['eir_d']; ?></td>
          <td scope="strn"><?php echo $asignados->Filas['booking']; ?></td>
          <td scope="strn"><?php echo $asignados->Filas['cliente']; ?></td>
        </tr>
        <?php } while($asignados->Filas = mysqli_fetch_assoc($asignados->Consulta)); ?>
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
<?php $cache->cerrar(); ?>
</html>
<?php
$lineas->Liberar();
if(isset($asignados)){
	$asignados->Liberar();
	$asignados->Cerrar();
}
$lineas->Cerrar();

?>