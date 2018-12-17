<?php
session_start();
session_name($_SESSION['variables']['usuario']);
require_once('../config.php');
require_once('../clases/class_Conexion.php');
require_once('../funciones/funciones.php');
#Seguridad
$seguridad = new Seguridad();
$seguridad->ValidarUsuario();

if(!isset($_GET['id'])){
	#Listado
	$listado = new DBMySQL();
	$listado->Datosconexion(UDB,PDB,USERDB);
	$listado->Consulta("SELECT inventario.id, tequipos.tipo, inventario.contenedor, inventario.eir_r, inventario.condicion FROM inventario, tequipos WHERE condicion IN(0,4) AND inventario.tcont = tequipos.id AND c = 0;");
	$mostrar = $listado->Num_resultados;
}else if(isset($_GET['id'])){
	$id = $_GET['id'];
	#Datos reparacion
	$equipo = new DBMySQL();
	$equipo->Datosconexion(UDB,PDB,USERDB);
	$sql = sprintf("SELECT id, linea, contenedor, condicion, obs FROM existencia WHERE id = %d;",$id);
	$equipo->Consulta($sql);
	
	#Linea
	$idLinea = $equipo->Filas['linea'];
	$linea = new DBMySQL();
	$linea->Datosconexion(UDB,PDB,USERDB);
	$sql = sprintf("SELECT id, nombre FROM lineas WHERE id = %d;",$idLinea);
	$linea->Consulta($sql);
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
     <a class="navbar-brand" href="#"><span class="text-primary">Ayaguna</span></a>
    </div>
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
     <ul class="nav navbar-nav">
      <li class="active"><a href="../inicio.php">Regresar</a></li>
      <!--<li><a href="inventarioExp.php" id="exportar">Exportar</a></li>-->
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
 <?php if($mostrar > 0){ ?>
 <div class="row">
  <div class="col-sm-10">
   <table id="table" class="table table-bordered table-condensed table-hover sortable bootstrap-table" 
               data-toggle="table"
               data-show-columns="true"
               data-show-toggle="true"
               data-search="true"
               data-key-events="true"
               data-sortable="true"
               data-sort-name="#"
               data-sort-order="asc"
               data-toolbar="#toolbar"
               data-search-align="left"
               data-buttons-align="left"
               data-toolbar-align="right"
               data-locale="es-SP">
    <caption>
    Listado
    </caption>
    <thead>
     <tr>
      <th data-field="#" data-sortable="true" data-sorter="alphanum" scope="col">#</th>
      <th data-field="contenedor" data-sortable="true" data-searchable="true" data-sorter="alphanum" scope="col">Contenedor</th>
      <th data-field="tipo" data-sortable="true" data-searchable="true" data-sorter="alphanum" scope="col">Tipo</th>
      <th data-field="eir" data-sortable="true" data-searchable="true" data-sorter="alphanum" scope="col">EIR</th>
     </tr>
    </thead>
    <tfoot>
     <tr>
      <th scope="col">&nbsp;</th>
      <th scope="col">&nbsp;</th>
      <th scope="col">&nbsp;</th>
      <th scope="col">&nbsp;</th>
     </tr>
    </tfoot>
    <?php do{ ?>
    <tr>
     <td scope="num"><?php echo ++$contador; ?></td>
     <td scope="contenedor"><a href="<?php echo $_SERVER['PHP_SELF'] ."?id=".$listado->Filas['id']; ?>"><?php echo $listado->Filas['contenedor']; ?></a></td>
     <td scope="tipo"><?php echo $listado->Filas['tipo']; ?></td>
     <td scope="eir"><?php echo $listado->Filas['eir_r']; ?></td>
    </tr>
    <?php }while ($listado->Filas = mysqli_fetch_assoc($listado->Consulta)); ?>
   </table>
  </div>
 </div>
 <?php } ?>
 <?php if(isset($_GET['id'])){?>
 <div class="row">
  <div class="col-sm-4 col-xs-offset-1">
   <form role="form" class="form-horizontal" action="reparar_reg.php" method="post" enctype="multipart/form-data" name="formRepUp" id="formRepUp"  onKeyPress="Noenter();">
    <div class="form-group">
     <div class="input-group">
      <label class="input-group-addon">ID</label>
      <input class="form-control" name="id" type="number" id="id" value="<?php echo $equipo->Filas['id']; ?>" readonly>
     </div>
    </div>
    <div class="form-group">
     <div class="input-group">
      <label class="input-group-addon" for="linea">Linea:</label>
      <input class="form-control" name="nlinea" type="text" id="nlinea"  value="<?php echo $linea->Filas['nombre']; ?>" readonly>
      <input type="hidden" id="linea" name="linea" value="<?php echo $equipo->Filas['linea']; ?>">
     </div>
    </div>
    <div class="form-group">
     <div class="input-group">
      <label class="input-group-addon" for="contenedor">Contenedor:</label>
      <input class="form-control" name="contenedor" type="text" id="contenedor" value="<?php echo $equipo->Filas['contenedor']; ?>" readonly>
     </div>
    </div>
    <div class="form-group">
     <div class="input-group">
      <label class="input-group-addon" for="strcondicion">Condición:</label>
      <input class="form-control" name="strcondicion" type="text" id="strcondicion" readonly value="DMG">
      <input type="hidden" id="condicion" name="condicion" value="<?php echo $equipo->Filas['condicion'];?>">
     </div>
    </div>
    <div class="form-group">
     <div class="input-group">
      <label class="input-group-addon" for="obs">Observación:</label>
      <textarea name="observacion" rows="4" readonly class="form-control" id="observacion"><?php echo $equipo->Filas['obs']; ?></textarea>
     </div>
    </div>
    <div class="form-group">
     <div class="input-group">
      <label class="input-group-addon" for="frep">Fecha Rep.:</label>
      <input class="form-control" name="frep" type="date" required id="frep" max="<?php echo AHORAC; ?>" value="<?php echo AHORAC; ?>">
      <span class="encabezadoAlerta"><i class="fa fa-pencil-square-o" title="Editable"></i></span>
     </div>
    </div>
    <div class="form-group">
     <div class="input-group">
      <label class="input-group-addon" for="accion">Acción Correctiva:</label>
      <textarea class="form-control" name="accion" required id="accion"></textarea>
      <span class="encabezadoAlerta"><i class="fa fa-pencil-square-o" title="Editable"></i></span>
     </div>
    </div>
    <div class="form-group">
     <div class="input-group">
      <label class="input-group-addon" for="accion2">Condición:</label>
      <select class="form-control" name="accion2" id="accion2" required>
       <option value="" selected="selected">Seleccion</option>
       <option value="4">DMG</option>
       <option value="1">OPR1</option>
       <option value="2">OPR2</option>
       <option value="3">OPR3</option>
      </select>
      <span class="encabezadoAlerta"><i class="fa fa-pencil-square-o"  title="Editable"></i></span>
     </div>
    </div>
    <div class="form-group">
     <div class="input-group">
      <label class="input-group-addon" for="monto">Monto:</label>
      <input class="form-control" name="monto" type="number" required="required" id="monto" step="any" value="0">
      <span class="encabezadoAlerta"><i class="fa fa-pencil-square-o" title="Editable"></i></span>
     </div>
    </div>
    <div class="form-group">
     <div class="input-group">
      <input class="checkbox" name="incluir" type="checkbox" id="incluir" value="1">
      <span class="encabezadoAlerta"><i class="fa fa-exclamation-triangle"></i> </span><span class="alerta">Si desea incluir imagenes por favor tilde el checkbox. </span>
      <label class="control-label" for="incluir">Incluir Imagenes </label>
     </div>
    </div>
    <div class="form-group">
     <div class="input-group">
      <label class="input-group-addon" for="img[]">Imagenes:</label>
      <input class="form-control" name="img[]" type="file" multiple id="img[]">
     </div>
    </div>
    <button class="btn btn-default" type="submit" name="submit" id="submit" value="Enviar">Enviar</button>
   </form>
  </div>
 </div>
 <?php }else { ?>
 <div class="row">
 	<div class="col-sm-6">
  	<div class="alert alert-info">
    	<h3>Reparaciones</h3>
      <p class="text-info">Actualmente no hay Equipos dañados (DMG) en el inventario</p>
    </div>
  </div>
 </div>
 <?php } ?>
</div>
<?php $cache->cerrar(); ?>
</body>
</html>