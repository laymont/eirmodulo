<?php
session_start();

require_once('../config.php');
require_once('../clases/class_DbPoo.php');
require_once('../clases/class_coordenadas.php');
require_once('../funciones/funciones.php');

session_name();

#Seguridad
$seguridad = new Seguridad();
$seguridad->ValidarUsuario();

#Verificar si posee tarjeta de coordenadas
$tco = new Coordenadas();
$tco->get_Coord();

#Comparar POST
$edicion = false;
if(isset($_SESSION['tablacoord']['celda1']) and isset($_SESSION['tablacoord']['celda2'])){
	if(isset($_POST['coord1']) and isset($_POST['coord2'])){
		if( $_POST['coord1'] == $_SESSION['tablacoord']['celda1'] and $_POST['coord2'] == $_SESSION['tablacoord']['celda2'] ){
			$edicion = true;
		}else {
			$edicion = false;
		}
	}
}

#Buscar equipo
if(isset($_POST['equipo'])){
	$equipo = $_POST['equipo'];
	$inventario = new DBsPOO();
	$inventario->Conectar(UDB,PDB);
	$inventario->SelectDB(USERDB);
	$SQLStr = sprintf("SELECT id,contenedor,frd, eir_r, fdespims, obs FROM inventario WHERE contenedor ='%s' AND c = 1",$equipo);
	$inventario->Consultar($SQLStr);
  $inventario->Resultados();
  if($inventario->TotalResultados > 0){
    $idequi = $inventario->Resultados['id'];
    $asignado = new DBsPOO();
    $asignado->Conectar(UDB,PDB);
    $asignado->SelectDB(USERDB);
    $SQLStr = sprintf("SELECT * FROM asignaciones WHERE equinv = %d;",$idequi);
    $asignado->Consultar($SQLStr);
    if($asignado->TotalResultados > 0){
     $asignado->Resultados();
     $booking = $asignado->Resultados['booking'];
   }else {
     $booking = NULL;
   }
 }

}


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
  <link rel="stylesheet" href="../css/estilos-2016.css">
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
  <div id="contenedor" class="container-fluid">
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
      <?php
      $tco->TC = 1; $edicion = true;
      ?>
      <?php if($tco->TC == 1 and $edicion == false){ ?>
      <div class="row bufferTop">
       <div class="container">
         <div class="row">
           <div class="col-sm-6 alert alert-info">
             <h3>Coordenadas</h3>
             <p>Indique el numero de coordenadas que se requieren para proseguir la operación</p>
             <hr class="divider">
             <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data" role="form">
              <div class="form-group-lg">
                <div class="input-group col-sm-3">
                  <label for="coord1" class="input-group-addon"><?php echo $_SESSION['tablacoord']['columna1'] ?></label>
                  <input type="number" class="form-control" name="coord1" id="coord1">
                </div>
              </div>
              <br>
              <div class="form-group-lg">
                <div class="input-group col-sm-3">
                  <label for="coord2" class="input-group-addon"><?php echo $_SESSION['tablacoord']['columna2'] ?></label>
                  <input type="text" class="form-control" name="coord2" id="coord2">
                </div>
              </div>
              <br>
              <button class="btn btn-lg btn-success" type="submit" value="1">Validar</button>
            </form>
          </div><!--indicar coordenadas-->
        </div>
      </div>
    </div>
    <?php } ?>
    <div class="row bufferTop">
      <?php if(isset($_GET['dev'])){ echo "<h3>Devuelto al inventario</h3>"; } ?>
      <?php if($edicion == true){ ?>
      <div class="col-sm-4">
       <form name="search" class="form-inline" action="<?php echo $_SERVER['PHP_SELF']; ?>" role="form" method="post" enctype="multipart/form-data">
         <div class="form-group">
           <label for="equipo" class="control-label">Equipo</label>
           <input type="text" class="form-control" id="equipo" name="equipo">
         </div>
         <button class="btn btn-default" type="submit"> Buscar </button>
       </form>
     </div>
     <?php } ?>
   </div>
   <div class="row">
    <?php if (isset($inventario->TotalResultados) && $inventario->TotalResultados > 0) { ?>
    <form action="asigdevgo.php" method="post" accept-charset="utf-8">
      <div class="col-md-3">
        <div class="form-group">
          <label class="control-label">Id</label>
          <input type="number" name="id" value="<?php echo $inventario->Resultados['id'];?>" class="form-control">
        </div>
        <div class="form-group">
          <label class="control-label">Contenedor</label>
          <input type="text" name="contenedor" value="<?php echo $inventario->Resultados['contenedor']; ?>" class="form-control">
        </div>
        <div class="form-group">
          <label class="control-label">EIR</label>
          <input type="number" name="eir" value="<?php echo $inventario->Resultados['eir_r']; ?>" class="form-control">
        </div>
        <div class="form-group">
          <label>Recepción</label>
          <input type="date" name="frd" value="<?php echo $inventario->Resultados['frd']; ?>" class="form-control">
        </div>
        <div class="form-group">
          <label>Despacho</label>
          <input class="form-control" type="date" name="fdespims" value="<?php echo $inventario->Resultados['fdespims']; ?>">
        </div>
        <div class="form-group">
          <label>Booking</label>
          <input class="form-control" type="text" name="booking" value="<?php echo $booking; ?>">
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group">
          <p class="text-warning"><i class="glyphicon glyphicon-exclamation-sign"></i> <small>Devolver el equipo al inventario; si fue asignado para exportación se eliminara ese registro.</small></p>
        </div>
        <div class="form-group">
          <label class="control-label" for="frdd">Fecha de Devolución</label>
          <input class="form-control" type="date" name="frdd" value="<?php echo AHORAC; ?>" placeholder="">
        </div>
        <div class="form-group">
          <label for="obs">Razón del Reintegro</label>
          <input type="hidden" name="obs" value="<?php echo $inventario->Resultados['obs']; ?>">
          <textarea class="form-control" name="razon" cols="30" rows="3" placeholder="Razon de la devolucion"></textarea>
          <span class="text-danger"><small><strong>Por favor agrege la razón del reintegro a inventario</strong></small></span>
        </div>
        <div class="form-group">
          <button class="btn btn-warning btn-sm" type="submit">Devolver</button>
        </div>
      </div>
    </form>
    <?php } ?>
  </div>

  <?php if(isset($inventario)){ if($inventario->TotalResultados == 0){ ?>
  <div class="row">
  	<div class="col-sm-4">
     <h4 class="text-warning">Sin Resultados</h4>
   </div>
 </div>
 <?php } } ?>
</div>
<script>
  $("nav.navbar-fixed-top").autoHidingNavbar();

</script>
<?php //var_dump($tco); ?>
</body>
<?php $cache->cerrar(); ?>
</html>
<?php

?>