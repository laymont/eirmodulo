<?php
session_start();
session_name($_SESSION['variables']['usuario']);
require_once('../config.php');
require_once('../clases/class_DbPoo.php');

#Seguridad
$seguridad = new Seguridad();
$seguridad->ValidarUsuario();

#Buques duplicados
$buques = new DBsPOO();
$buques->Conectar(UDB,PDB);
$buques->SelectDB(USERDB);
$SQLstr = "SELECT id, linea, nombre, count(nombre) as `total` from buques WHERE activo = 0 group by linea, nombre having count(nombre) > 1;";
$buques->Consultar($SQLstr);

#errores en viajes
$errors = new DBsPOO();
$errors->Conectar(UDB,PDB);
$errors->SelectDB(USERDB);
$SQLstr = "SELECT lineas.nombre AS `lines`, buques.nombre AS `vessel`, viajes.viaje, viajes.eta FROM viajes, buques, lineas WHERE eta = '0000-00-00' AND buques.id = viajes.buque AND buques.linea = lineas.id;";
$errors->Consultar($SQLstr);

#Consignatarios duplicados
$duplicados = new DBsPOO();
$duplicados->Conectar(UDB,PDB);
$duplicados->SelectDB(USERDB);
$SQLstr = "SELECT id, nombre, COUNT(nombre) AS `total` FROM consignatario WHERE activo = 0 GROUP BY nombre HAVING COUNT(nombre) > 1;";
$duplicados->Consultar($SQLstr);
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
  <div class="col-sm-8 col-xs-push-1">
   <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
    <div class="panel panel-info">
     <div class="panel-heading" role="tab" id="headingOne">
      <h4 class="panel-title"> <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne"> <i class="glyphicon glyphicon-info-sign"></i> Importante </a> </h4>
     </div>
     <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
      <div class="panel-body">
       <p class="text-info">Nos mantenemos en constante desarrollo de mejoras para <abbr class="initialism" title="Control de Equipos">Ayaguna</abbr>; en este mismo sentido en estamos en fase de normalización de la Base de datos; y para realizar esta tarea necesitamos de su colaboración.<br>
        Por favor continue hacia abajo y presta atención a los listado, donde se muestran los datos que se deben normalizar.</p>
      </div>
     </div>
    </div>
    <?php if(isset($buques->TotalResultados) && $buques->TotalResultados == 0){ $class = 'panel-info';}else{ $class = 'panel-warning';} ?>
    <div class="panel <?php echo $class ?>">
     <div class="panel-heading" role="tab" id="headingTwo">
      <h4 class="panel-title"> <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo"> <i class="glyphicon glyphicon-info-sign"></i> Buques </a> </h4>
     </div>
     <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
      <div class="panel-body">
       <?php if(isset($buques->TotalResultados) && $buques->TotalResultados > 0){ ?>
       <div class="panel panel-warning">
        <div class="panel-heading">
         Buques duplicados <span class="badge"><?php echo $buques->TotalResultados; ?></span>
        </div>
        <div class="panel-body">
         <p class="text-warning">El listado de buques que se muestra a continuación, contiene nombres (Linea->Buques) duplicados.</p>
        </div>
        <table class="table table-bordered table-condensed table-responsive table-striped"
        data-toggle="table"
              data-show-columns="true"
              data-show-toggle="true"
              data-show-export="true"
              data-search="true"
              data-pagination="true"
              data-key-events="true"
              data-sortable="true"
              data-sort-name="buque"
              data-sort-order="asc"
              data-show-pagination-switch="true"
              data-pagination-v-align="both"
              data-page-size="10"
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
         <thead>
          <tr>
           <th data-field="id" data-sortable="true" data-searchable="true" data-sorter="alphanum" scope="col">Id</th>
           <th data-field="linea" data-sortable="true" data-searchable="true" data-sorter="alphanum" scope="col">Linea</th>
           <th data-field="buque" data-sortable="true" data-searchable="true" data-sorter="alphanum" scope="col">Buque</th>
           <th data-field="total" data-sortable="true" data-searchable="true" data-sorter="alphanum" scope="col">Total</th>
          </tr>
         </thead>
         <tbody>
          <?php while($buques->Resultados()){ ?>
          <tr>
           <td><?php echo $buques->Resultados['id']; ?></td>
           <td><?php echo $buques->Resultados['linea']; ?></td>
           <td><?php echo $buques->Resultados['nombre']; ?></td>
           <td><?php echo $buques->Resultados['total']; ?></td>
          </tr>
          <?php } ?>
         </tbody>
         </caption>
        </table>
       </div>
       <?php }else { echo "<h3 class='text-success'>Buques <i class='glyphicon glyphicon-ok-sign'></i></h3>"; } ?>
      </div>
     </div>
    </div>
    <?php if(isset($errors->TotalResultados) && $errors->TotalResultados == 0){ $class = 'panel panel-info'; }else{ $class = 'panel panel-warning'; } ?>
    <div class="<?php echo $class; ?>">
     <div class="panel-heading" role="tab" id="headingThree">
      <h4 class="panel-title"> <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree"> <i class="glyphicon glyphicon-info-sign"></i> Viajes </a> </h4>
     </div>
     <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
      <div class="panel-body">
       <?php if(isset($errors->TotalResultados) && $errors->TotalResultados > 0){ ?>
       <div class="panel panel-danger">
        <!-- Default panel contents -->
        <div class="panel-heading">
         Viajes Errados <span class="badge"><?php echo $errors->TotalResultados; ?></span>
        </div>
        <div class="panel-body">
         <p>El listado de registros que se muestra a continuacion contiene errores; por favor tome las acciones correctivas necesarias para solventar este error.<br>
          Los registros errados pueden ser <strong><abbr class="initialism" title="Solo los registros sin vinculos con el inventario">eliminados</abbr></strong>, siempre y cuando no mantengan vinculos con los registros de inventario.<br>
          Para mas información comuniquese con el administrador de la aplicación.</p>
        </div>
        <!-- Table -->
        <table class="table table-bordered table-condensed table-striped table-responsive"
        			data-toggle="table"
              data-show-columns="true"
              data-show-toggle="true"
              data-show-export="true"
              data-search="true"
              data-pagination="true"
              data-key-events="true"
              data-sortable="true"
              data-sort-name="linea"
              data-sort-order="asc"
              data-show-pagination-switch="true"
              data-pagination-v-align="both"
              data-page-size="10"
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
         Listado
         </caption>
         <thead>
          <tr>
           <th data-field="linea" data-sortable="true" data-searchable="true" data-sorter="alphanum" scope="col">Linea</th>
           <th data-field="buque" data-sortable="true" data-searchable="true" data-sorter="alphanum" scope="col">Buque</th>
           <th data-field="viaje" data-sortable="true" data-searchable="true" data-sorter="alphanum" scope="col">Viaje</th>
           <th data-field="fecha" data-sortable="true" data-searchable="true" data-sorter="alphanum" scope="col">Fecha</th>
          </tr>
         </thead>
         <tbody>
          <?php while($errors->Resultados()){; ?>
          <tr>
           <td><?php echo $errors->Resultados['lines']; ?></td>
           <td><?php echo $errors->Resultados['vessel']; ?></td>
           <td><?php echo $errors->Resultados['viaje']; ?></td>
           <td><?php echo $errors->Resultados['eta']; ?></td>
          </tr>
          <?php } ?>
         </tbody>
        </table>
       </div>
       <?php } else { echo '<h3 class="text-success">Viajes <i class="glyphicon glyphicon-ok-sign"></i></h3>'; } ?>
      </div>
     </div>
    </div>
    <?php if(isset($duplicados->TotalResultados) && $duplicados->TotalResultados > 0){ $class = 'panel panel-warning';}else {$class = 'panel panel-info'; } ?>
    <div class="<?php echo $class; ?>">
     <div class="panel-heading" role="tab" id="headingThree">
      <h4 class="panel-title"> <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFour" aria-expanded="false" aria-controls="collapseFour"> <i class="glyphicon glyphicon-info-sign"></i> Consignatarios </a> </h4>
     </div>
     <div id="collapseFour" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFour">
      <div class="panel-body">
       <?php if(isset($duplicados->TotalResultados) && $duplicados->TotalResultados > 0){ ?>
       <div class="panel panel-danger">
        <!-- Default panel contents -->
        <div class="panel-heading">
         Viajes Errados <span class="badge"><?php echo $errors->TotalResultados; ?></span>
        </div>
        <div class="panel-body">
        </div>
        <!-- Table -->
        <div class="panel panel-warning">
         <div class="panel-heading">
          Duplicados <span class="badge"><?php echo $duplicados->TotalResultados; ?></span>
         </div>
         <div class="panel-body">
          <p class="text-warning">El listado de consignatario que se muestra a continuación, presenta una muestra de nombre que se encuentran duplicados en los registros.</p>
         </div>
         <table class="table table-bordered table-condensed table-responsive table-striped"
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
              data-page-size="10"
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
          Consignatarios
          </caption>
          <thead>
           <tr>
            <th data-field="id" data-sortable="true" data-searchable="true" data-sorter="alphanum" scope="col">Id</th>
            <th data-field="nombre" data-sortable="true" data-searchable="true" data-sorter="alphanum" scope="col">Nombre</th>
            <th data-field="total" data-sortable="true" data-searchable="true" data-sorter="alphanum" scope="col">Total</th>
           </tr>
          </thead>
          <tbody>
           <?php while($duplicados->Resultados()){ ?>
           <tr>
            <td><?php echo $duplicados->Resultados['id']; ?></td>
            <td><?php echo $duplicados->Resultados['nombre']; ?></td>
            <td><?php echo $duplicados->Resultados['total']; ?></td>
           </tr>
           <?php } ?>
          </tbody>
         </table>
        </div>
       </div>
       <?php }else { echo '<h3 class="text-success">Consignatarios <i class="glyphicon glyphicon-ok-sign"></i></h3>'; } ?>
      </div>
     </div>
    </div>
   </div>
  </div>
 </div>
</div>
</body>
</html>