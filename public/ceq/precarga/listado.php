<?php
session_start();
session_name($_SESSION['variables']['usuario']);
require_once('../config.php');
require_once ('../clases/class_Conexion.php');
require_once('../funciones/funciones.php');

#Limpiar listado de equipos ya ingresados
$normaliza = new DBMySQL();
$normaliza->Datosconexion(UDB,PDB,USERDB);
$normaliza->Elimina("DELETE FROM lista WHERE id IN (SELECT id FROM (SELECT t1.id FROM lista AS t1, inventario AS t2 WHERE t1.linea = t2.linea AND t1.buque = t2.buque AND t1.viaje = t2.viaje AND t1.equipo = t2.contenedor) AS LISTADO);");

#Lineas del Listado
$lineas = new DBMySQL();
$lineas->Datosconexion(UDB,PDB,USERDB);
$qlineas = "SELECT lista.linea, lineas.nombre FROM lista, lineas WHERE lista.linea = lineas.id GROUP BY lista.linea";
$lineas->Consulta($qlineas);

if(isset($_POST['linea'])){
	$linea = $_POST['linea'];
	#Listado
	$descargas = new DBMySQL();
	$descargas->Datosconexion(UDB,PDB,USERDB);
	$consulta = sprintf("SELECT lista.id, lineas.nombre AS linea, buques.nombre AS buque, viajes.viaje, lista.equipo, tequipos.tipo, lista.precinto,consignatario.nombre AS `consignatario` FROM lista, lineas, buques, viajes, consignatario, tequipos WHERE lista.linea = lineas.id AND lista.buque = buques.id AND lista.viaje = viajes.id AND lista.consig = consignatario.id AND lista.tipo = tequipos.id AND lista.linea = %d;",$linea);
	$descargas->Consulta($consulta);
	
	#Eliminar
	$buscar = new DBMySQL();
	$buscar->Datosconexion(UDB,PDB,USERDB);
	$sql = sprintf("SELECT lista.buque AS idbuque, buques.nombre AS buque, lista.viaje AS idviaje, viajes.viaje FROM lista, buques, viajes WHERE lista.buque = buques.id AND lista.viaje = viajes.id AND lista.linea = %d GROUP BY lista.viaje ORDER BY buques.nombre, viajes.viaje;",$linea);
	$buscar->Consulta($sql);
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Listas de Descarga</title>
<!--Script-->
<script src="../js/jquery-1.11.3.min.js"></script>
<script src="../bootstrap/js/bootstrap.min.js"></script>
<script src="../bootstrap/js/jquery.bootstrap-autohidingnavbar.min.js"></script>
<script src="../bootstrap/dialog/js/bootstrap-dialog.min.js"></script>
<script src="../bootstrap/table/bootstrap-table.js"></script>
<script src="../bootstrap/table/locale/bootstrap-table-es-SP.js"></script>
<script src="../bootstrap/table/extensions/toolbar/bootstrap-table-toolbar.js"></script>
<script src="../bootstrap/table/extensions/filter-control/bootstrap-table-filter-control.min.js"></script>
<script src="../bootstrap/table/extensions/natural-sorting/bootstrap-table-natural-sorting.min.js"></script>
<!--CSS-->
<link rel="stylesheet" type="text/css" href="../bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="../bootstrap/css/bootstrap-responsive.min.css">
<link rel="stylesheet" type="text/css" href="../bootstrap/dialog/css/bootstrap-dialog.min.css">
<link rel="stylesheet" href="../bootstrap/css/styleBootstrap.css">
<link rel="stylesheet" href="../bootstrap/table/bootstrap-table.min.css">
</head>
<body>
<div class="container">
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
 <!--cuerpo html-->
 <div class="row">
  <div class="col-sm-4">
   <form class="form-inline" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" name="form1" id="form1" role="form">
    <fieldset>
     <legend>Linea/Seleccion</legend>
     <div class="form-group">
      <select class="form-control" name="linea" required id="linea">
       <option value="">Linea/Seleccion</option>
       <?php do { ?>
       <option value="<?php echo $lineas->Filas['linea']; ?>"><?php echo $lineas->Filas['nombre']; ?></option>
       <?php } while($lineas->Filas = mysqli_fetch_assoc($lineas->Consulta)); ?>
      </select>
     </div>
     <button class="btn btn-primary" id="submit" name="submit" value="enviar">Enviar</button>
    </fieldset>
   </form>
  </div>
 </div>
 <div class="row">
  <div class="col-sm-12">
   <hr>
  </div>
 </div>
 <div class="row">
  <?php if(isset($_POST['linea'])){ ?>
  <div class="col-sm-6">
   <div class="panel-group">
    <div class="panel panel-info">
     <div class="panel-heading">
      <h4 class="panel-title"> <a data-toggle="collapse" href="#collapse1">Administrar/Listas</a> </h4>
     </div>
     <div id="collapse1" class="panel-collapse collapse">
      <div class="panel-body">
       <form class="form-inline" action="listado_elimina.php" method="post" name="eliminar" id="eliminar" role="form">
        <fieldset>
         <legend>Eliminar</legend>
         <input name="linea" type="hidden" id="linea" form="eliminar" value="<?php echo $linea; ?>">
         <select class="form-control" name="elimina" required id="elimina" form="eliminar">
          <option value="">Buque/Viaje</option>
          <?php do{ ?>
          <option value="<?php echo $buscar->Filas['idbuque'].",".$buscar->Filas['idviaje']; ?>"><?php echo $buscar->Filas['buque']." - ".$buscar->Filas['viaje']; ?></option>
          <?php }while($buscar->Filas = mysqli_fetch_assoc($buscar->Consulta)); ?>
         </select>
         <button class="btn btn-primary" name="submit2" id="submit2" value="eliminar">Eliminar</button>
        </fieldset>
       </form>
      </div>
     </div>
    </div>
   </div>
  </div>
  <!--panel-->
 </div>
 <div class="row">
  <div class="col-sm-12">
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
    <caption>
    <br>
    Listados de Descarga | (<?php echo $descargas->Num_resultados; ?>)
    </caption>
    <thead>
     <tr>
      <th data-field="id" data-sortable="true" data-sorter="alphanum"  class="header" scope="col">Id</th>
      <th data-field="linea" data-sortable="true" data-searchable="true" data-sorter="alphanum"  class="header" scope="col">Linea</th>
      <th data-field="buque" data-sortable="true" data-searchable="true" data-sorter="alphanum"  class="header" scope="col">Buque</th>
      <th data-field="viaje" data-sortable="true" data-searchable="true" data-sorter="alphanum"  class="header" scope="col">Viaje</th>
      <th data-field="equipo" data-sortable="true" data-searchable="true" data-sorter="alphanum"  class="header" scope="col">Equipo</th>
      <th data-field="tipo" data-sortable="true" data-searchable="true" data-sorter="alphanum"  class="header" scope="col">Tipo</th>
      <th data-field="consignatario" data-sortable="true" data-searchable="true" data-sorter="alphanum"  class="header" scope="col">Consignatario</th>
     </tr>
    </thead>
    <tbody>
     <?php do{ ?>
     <tr>
      <td><?php echo $descargas->Filas['id']; ?></td>
      <td><?php echo $descargas->Filas['linea']; ?></td>
      <td><?php echo $descargas->Filas['buque']; ?></td>
      <td><?php echo $descargas->Filas['viaje']; ?></td>
      <td><a href="../ingresos/ingresos_vacios_pre.php?id=<?php echo $descargas->Filas['id']; ?>" ><span title="Ingresar"><?php echo $descargas->Filas['equipo']; ?></span></a></td>
      <td><?php echo $descargas->Filas['tipo']; ?></td>
      <td><?php echo $descargas->Filas['consignatario']; ?></td>
     </tr>
     <?php } while($descargas->Filas = mysqli_fetch_assoc($descargas->Consulta)); ?>
    </tbody>
   </table>
   <?php } ?>
  </div>
 </div>
</div>
<!--Contenedor--> 
<script>
$(document).ready(function() {
  //Ocultar MenuBar
  $("nav.navbar-fixed-top").autoHidingNavbar();; 
});

</script>
<?php 
if(isset($_GET['elimina']) and $_GET['elimina'] == "true"){ ?>
<script>
	BootstrapDialog.show({
		type: 'type-warning',
		size: 'size-small',
		title: 'Lista',
		message: 'Lista eliminada!'
	});
	</script>
<?php } ?>
<?php $cache->cerrar(); ?>
</body>
</html>