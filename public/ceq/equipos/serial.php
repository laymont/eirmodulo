<?php
session_start();
session_name($_SESSION['variables']['usuario']);
require_once('../config.php');
require_once('../clases/class_DbPoo.php');
require_once('../clases/class_coordenadas.php');
require_once('../funciones/funciones.php');

#Seguridad
$seguridad = new Seguridad();
$seguridad->ValidarUsuario();

/*Proceso de edicion del contenedor*/
if(isset($_POST['editcont']) && isset($_POST['numcont']) && isset($_POST['id'])){
	if($_POST['editcont'] == 1 && $_POST['numcont'] <> $_POST['err'] ){
		/*edit true*/
		$numero_old = $_POST['err'];
		$numero = $_POST['numcont'];
		$id = $_POST['id'];
		$update = new DBsPOO();
		$update->Conectar(UDB,PDB);
		$update->SelectDB(USERDB);
		$SQLUpdate = sprintf("UPDATE inventario SET contenedor = '%s' WHERE contenedor = '%s' AND id = %d", $numero, $numero_old, $id);
		$update->Actualizar($SQLUpdate);
		$update->Afectados();
		if( $update->Afectados > 0 ){
			$edicion = true;
			$msj = true;
			header("Location: ../inicio.php");
		}
	}else {
		/*edit false*/
		$msj = false;
		
	}
}

#Verificar si posee tarjeta de coordenadas
$tc = new Coordenadas();
$tc->get_Coord();

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

#Contenedor
if(isset($_POST['serial'])){
	if(isset($_POST['edicion']) and $_POST['edicion'] == true){
		$edicion = true;
	}
	$num = $_POST['serial'];
	$contenedor = new DBsPOO();
	$contenedor->Conectar(UDB,PDB);
	$contenedor->SelectDB(USERDB);
	$SQLstr = sprintf("SELECT id, contenedor, fdb, fdm, frd FROM inventario WHERE c = 0 and contenedor = '%s';", $num);
	$contenedor->Consultar($SQLstr);
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
	<div class="row bufferTop">
  <div class="container">
  	
		<?php if(isset($edicion) and $edicion == false and $tc->TC == 1 ){ ?>
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
    <?php } ?>
    
  </div>
  </div>
  <?php if(isset($tc) and $tc->TC <> -1 and $edicion == true){ ?>    
  <div class="row">
  	<div class="col-sm-12">
    	<h4 class="text-warning">Editar Serial del Contenedor</h4>
      <p class="text-warning"> <i class="glyphicon glyphicon-fire text-danger"></i> Esta por comenzar el proceso de edición del serial de contenedor; la edición del serial puede truncar registros anteriores del contenedor.</p>
    </div>
  </div>
  <div class="row">
  	<div class="col-sm-6">
    	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data" class="form-inline">
      	<div class="form-group">
          <label for="serial" class="control-label">Contenedor</label>
          <input name="serial" id="serial" type="text" class="form-control">
        </div>
        	<input type="hidden" name="edicion" id="edicion" value="true">
        <button class="btn btn-default" type="submit" value="1" name="submit" id="submit">Buscar</button>
      </form><!--buscar serial-->
    </div>
  </div>
  <hr>
  <div class="row">
  <?php if(isset($contenedor->TotalResultados) and $contenedor->TotalResultados > 0 ){ ?>
  	<div class="col-sm-6">
    	<table class="table table-bordered table-condensed table-responsive">
    		<tr>
    			<th>Id</th>
    			<th>Contenedor</th>
    			<th>FDB</th>
    			<th>FDM</th>
    			<th>FRD</th>
    		</tr>
        <?php while($contenedor->Resultados()){ ?>
        <tr><form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data" class="form-inline">
        	<td><?php echo $contenedor->Resultados['id']; ?></td>
        	<td>
          <!--Form para editar start-->
          <input type="text" name="numcont" id="numcont" class="form-control text-uppercase" value="<?php echo $contenedor->Resultados['contenedor']; ?>"><br>
          <input type="hidden" name="err" id="err" value="<?php echo $contenedor->Resultados['contenedor']; ?>">
          <input type="hidden" name="id" id="id" value="<?php echo $contenedor->Resultados['id']; ?>">
          <input type="hidden" name="editcont" id="editcont" value="1">
          <button class="btn btn-danger" type="submit" value="1"> Editar </button>
          <!--Form para editar end-->
          </td>
        	<td><?php echo $contenedor->Resultados['fdb']; ?></td>
        	<td><?php echo $contenedor->Resultados['fdm']; ?></td>
        	<td><?php echo $contenedor->Resultados['frd']; ?></td>
        </tr></form><?php } ?>
    	</table>
    </div>
  <?php }else if(isset($contenedor->TotalResultados) and $contenedor->TotalResultados == 0){ echo "<h4>Sin Resultados</h4>"; } ?>
  <?php if( isset($update->Afectados) and isset($msj) ){ ?>
  	<div class="row">
    	<div class="col-sm-4">
      	
				<?php if($msj == true){?>
        <div class="alert alert-success">
        	<p>Se realizo la modificación</p>
        </div>
        <?php }else if($msj == false){ ?>
        <div class="alert alert-success">
        	<p>No realizo ninguna modificación</p>
        </div>
        <?php } ?>
        
      </div>
    </div>
  <?php } ?>
  </div>
  <?php }else if($tc->TC == -1) { ?>
  <div class="row bufferTop">
  	<div class="col-sm-6">
    	<h1 class="text-info">Información</h1>
      <p>Ud no posee tarjeta de coordenas asignada.</p>
    </div>
  </div>
  <?php } ?>
</div>
</body>
</html>