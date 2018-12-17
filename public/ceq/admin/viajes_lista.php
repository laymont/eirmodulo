<?php
session_start();
session_name($_SESSION['variables']['usuario']);
require_once('../config.php');
require_once('../clases/class_Conexion.php');
require_once('../clases/class_DbPoo.php');
#Seguridad
$seguridad = new Seguridad();
$seguridad->ValidarUsuario();

#Lineas
$lineas = new DBMySQL();
$lineas->Datosconexion(UDB,PDB,USERDB);
$lineas->Consulta("SELECT id, nombre FROM lineas WHERE activo = 0 ORDER BY nombre ASC;");

if(isset($_POST['buque'])){
	$id = $_POST['buque'];
	#Viajes
	$viajes = new DBMySQL();
	$viajes->Datosconexion(UDB,PDB,USERDB);
	$sql = sprintf("SELECT id, viaje, eta FROM viajes where buque = %d ORDER BY eta DESC;",$id);
	$viajes->Consulta($sql);
	$mostrar = $viajes->Num_resultados;
}
//Datos viaje a editar
if(isset($_GET['edit'])){
	$id = $_GET['edit'];
	$editar = new DBMySQL();
	$editar->Datosconexion(UDB,PDB,USERDB);
	$sql = sprintf("SELECT * FROM viajes WHERE id = %d;",$id);
	$editar->Consulta($sql);
}
//editar viaje
if(isset($_POST['idreg']) && isset($_POST['fecha'])){
	$idreg = $_POST['idreg'];
	$fecha = $_POST['fecha'];
	$sql = sprintf("UPDATE viajes SET eta = '%s' WHERE id = %d;",$fecha,$idreg);
	$actuliza = new DBsPOO();
	$actuliza->Conectar(UDB,PDB);
	$actuliza->SelectDB(USERDB);
	$actuliza->Actualizar($sql);
	if($actuliza->Afectados > 0){
		//Actualizar fechas en el inventario
		$sql = sprintf("UPDATE inventario SET fdb = '%s' WHERE viaje = %d;",$fecha,$idreg);
		$inventario = new DBsPOO();
		$inventario->Conectar(UDB,PDB);
		$inventario->SelectDB(USERDB);
		$inventario->Actualizar($sql);
		if($inventario->Afectados > 0){
			echo "<script>var inveact = ".$inventario->Afectados.";</script>";
		}else {
			echo "<script>var inveact = 0;</script>";
		}
		echo "<script>var actualizado = true;</script>";
	}else {
		echo "<script>var actualizado = false;</script>";
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
<link rel="stylesheet" href="../bootstrap/css/styleBootstrap.css">
<link rel="stylesheet" href="../bootstrap/table/bootstrap-table.min.css">
<link rel="stylesheet" type="text/css" href="../bootstrap/dialog/css/bootstrap-dialog.min.css">
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
<script src="../bootstrap/dialog/js/bootstrap-dialog.min.js"></script>
<script>
$(document).ready(function(){
	
	$("nav.navbar-fixed-top").autoHidingNavbar();
	
	$('[data-toggle="tooltip"]').tooltip();
	
});
</script>
<script>
$(document).ready(function(){
     $("#linea").change(function () {
        $("#linea option:selected").each(function () {
           elegido=$(this).val();
           $.post("buques.php", { elegido: elegido }, function(data){
              $("#buque").html(data);
              $("#viaje").html("");
           });
        });
     })
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
      <li><a href="viajes_nuevo.php">Nuevo Viaje</a></li>
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
  <div class="col-sm-6">
   <form class="form-inline" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" name="formViajes" id="formViajes">
    <fieldset>
     <legend>Indique Línea y Buque</legend>
     <div class="form-group">
      <label class="control-label" for="linea">Linea:</label>
      <select class="form-control" name="linea" id="linea">
       <option value="">Seleccion</option>
       <?php do { ?>
       <option value="<?php echo $lineas->Filas['id']; ?>"><?php echo $lineas->Filas['nombre']; ?></option>
       <?php } while ($lineas->Filas = mysqli_fetch_assoc($lineas->Consulta)); ?>
      </select>
     </div>
     <div class="form-group">
      <label class="control-label" for="buque">Buque:</label>
      <select class="form-control" name="buque" required id="buque">
      </select>
     </div>
     <button class="btn btn-default" name="submit" id="submit" value="Enviar">Enviar</button>
    </fieldset>
   </form>
  </div>
 </div>
 <br>
 <div class="row">
  <div class="col-sm-6">
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
      <th data-field="viaje" data-sortable="true" data-searchable="true" data-sorter="alphanum" scope="col">Viaje</th>
      <th data-field="fecha" data-sortable="true" data-searchable="true" data-sorter="alphanum" scope="col">Fecha</th>
     </tr>
    </thead>
    <tbody>
     <?php do{ ?>
     <tr>
      <td scope="num"><?php echo $viajes->Filas['id']; ?></td>
      <td scope="str"><?php echo $viajes->Filas['viaje']; ?></td>
      <td scope="fecha"><a href="<?php echo $_SERVER['PHP_SELF']."?edit=".$viajes->Filas['id'];?>" title="editar"><?php echo $viajes->Filas['eta']; ?></a></td>
     </tr>
     <?php } while ($viajes->Filas = mysqli_fetch_assoc($viajes->Consulta)); ?>
    </tbody>
   </table>
   <?php }else if($mostrar == 0 and !isset($_POST)){ }else { "<h2>No hay viajes Registrados</h2>"; } ?>
  </div>
 </div>
 <?php if(isset($editar->Num_resultados)){ ?>
 <div class="row">
  <div class="col-sm-2">
   <form action="<?php echo $_SERVER['PHP_SELF'];?>" enctype="multipart/form-data" method="post">
    <div class="form-group">
     <label for="id" class="control-label">ID</label>
     <p class="form-control-static"><?php echo $editar->Filas['id'];?></p>
     <input type="hidden" value="<?php echo $editar->Filas['id'];?>" name="idreg">
    </div>
    <div class="form-group">
     <label for="viaje" class="control-label">Viaje</label>
     <p class="form-control-static"><?php echo $editar->Filas['viaje'];?></p>
    </div>
    <div class="form-group">
     <label for="fecha" class="control-label">Fecha</label>
     <input type="date" class="form-control" name="fecha" id="fecha" value="<?php echo $editar->Filas['eta'];?>">
    </div>
    <button class="btn btn-primary" type="submit" value="1" name="submit">Actualizar</button>
   </form>
  </div>
 </div>
 <?php } ?>
</div>
<script>
var $table = $('#table');
$(function () {
	$table.on('click-row.bs.table', function (e, row, $element) {
		$('.success').removeClass('success');
		$($element).addClass('success');
	});
});
$(function(){
	if(actualizado == true){
		BootstrapDialog.show({
			title: 'Info',
			message: 'Viaje Actualizado. <br>Registro de inventario Actualizados ' + inveact,
			type: BootstrapDialog.TYPE_SUCCESS,
			size : BootstrapDialog.SIZE_SMALL
		});
	}else {
		BootstrapDialog.show({
			title: 'Info',
			message: 'Ningun registro actualizado',
			type: 'type-warning',
			size : BootstrapDialog.SIZE_SMALL
		});
	}
});
</script>
</body>
</html>