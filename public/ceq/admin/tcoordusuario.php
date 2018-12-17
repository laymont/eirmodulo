<?php
session_start();
session_name($_SESSION['variables']['usuario']);
require_once('../config.php');
require_once('../clases/class_DbPoo.php');
require_once('../clases/class_coordenadas.php');
require_once('../funciones/funciones.php');

$tc = new Coordenadas();
$tc->show_Coord();
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
<link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="../bootstrap/css/bootstrap-dialog.min.css">
<link rel="stylesheet" href="../css/estilos-2016.css">
<link rel="stylesheet" href="../bootstrap/table/bootstrap-table.css">
<link rel="stylesheet" href="../bootstrap/css/styleBootstrap.css">
<link rel="stylesheet" href="../bootstrap/table/bootstrap-table.min.css">
<!--Script-->
<script src="../bootstrap/js/jquery.min.js"></script>
<script src="../bootstrap/js/bootstrap.min.js"></script>
<script src="../bootstrap/js/bootstrap-dialog.min.js"></script>
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
          </ul>
        </div>
      </nav>
    </div>
  </div><!--Menu-->
  <?php if(isset($tc) and $tc->show_Coord() <> false){ ?>
  <div class="row bufferTop">
  	<div class="col-xs-7">
    	<h3 class="hidden-print">Tarjeta de Coordenadas</h3>
      <table class="table table-condensed table-striped table-bordered">
      	<caption>Tarjeta #<?php echo $tc->Numero; ?></caption>
      	<tr>
        	<th class="text-center">&nbsp;</th>
        	<th class="text-center">V</th>
        	<th class="text-center">A</th>
        	<th class="text-center">L</th>
        	<th class="text-center">I</th>
        	<th class="text-center">D</th>
        	<th class="text-center">E</th>
        	<th class="text-center">N</th>
        </tr>
        <?php for($i=0;$i<=4;$i++){ ?>
        <tr>
        	<th class="text-center"><?php echo $tc->Filas(); ?></th>
        	<td class="text-center"><?php echo $tc->TFC[$i][0];?></td>
        	<td class="text-center"><?php echo $tc->TFC[$i][1];?></td>
        	<td class="text-center"><?php echo $tc->TFC[$i][2];?></td>
        	<td class="text-center"><?php echo $tc->TFC[$i][3];?></td>
        	<td class="text-center"><?php echo $tc->TFC[$i][4];?></td>
        	<td class="text-center"><?php echo $tc->TFC[$i][5];?></td>
        	<td class="text-center"><?php echo $tc->TFC[$i][6];?></td>
        </tr><?php } ?>
        <tr>
        <td colspan="8"><small><?php echo $_SESSION['variables']['nomdb']." - ".$_SESSION['variables']['nombre']." ".$_SESSION['variables']['apellido']; ?></small></td>
        </tr>
      </table>
      <p class="hidden-print"><small class="text-warning">Imprima y guarde esta tarjeta, si la pierde por favor notifiquelo inmediatamente</small></p>
    </div><!--Tarjetas de coordenadas-->
  </div>
  <?php }else if(isset($tc) and $tc->show_Coord() == false){ ?>
  <div class="row bufferTop">
  	<div class="col-sm-6">
    	<h3 class="alert alert-info"><i class="glyphicon glyphicon-info-sign"></i> Ud no posee Tarjetas de Coordenadas</h3>
    </div><!--Sin Tarjeta de coordenadas-->
  </div>
  <?php } ?>
</div>
<?php //var_dump($_SESSION['variables']); ?>
</body>
</html>