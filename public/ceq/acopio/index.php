<?php
session_start();
session_name($_SESSION['variables']['usuario']);
require_once('../config.php');
require_once('../clases/class_Conexion.php');
require_once('../clases/class_Acopio.php');

$lineas = new DBMySQL();
$lineas->Datosconexion(UDB,PDB,USERDB);
$lineas->Consulta("SELECT id, nombre FROM lineas WHERE activo = 0;");

if(isset($_POST['linea']) && isset($_POST['despacho'])){
	$linea = $_POST['linea'];
	$despacho = $_POST['despacho'];
	
	$recaps20 = new DBMySQL();
	$recaps20->Datosconexion(UDB,PDB,USERDB);
	$recaps20->Consulta(sprintf("SELECT tequipos.tipo, COUNT(inventario.tcont) AS cantidad FROM inventario, tequipos, lineas WHERE inventario.linea = %d AND inventario.fdespims = '%s' AND inventario.tcont = tequipos.id AND inventario.linea = lineas.id AND DATEDIFF(inventario.fdespims,inventario.frd) + 1 > lineas.dlibres AND tequipos.tipo LIKE '2%%' GROUP BY tequipos.tipo;",$_POST['linea'],$_POST['despacho']));
	
	$recaps40 = new DBMySQL();
	$recaps40->Datosconexion(UDB,PDB,USERDB);
	$recaps40->Consulta(sprintf("SELECT tequipos.tipo, COUNT(inventario.tcont) AS cantidad FROM inventario, tequipos, lineas WHERE inventario.linea = %d AND inventario.fdespims = '%s' AND inventario.tcont = tequipos.id AND inventario.linea = lineas.id AND DATEDIFF(inventario.fdespims,inventario.frd) + 1 > lineas.dlibres AND tequipos.tipo LIKE '4%%' GROUP BY tequipos.tipo;",$_POST['linea'],$_POST['despacho']));
	
	$acopio = new DBMySQL();
	$acopio->Datosconexion(UDB,PDB,USERDB);
	$sql = sprintf("SELECT lineas.nombre AS linea, inventario.contenedor, tequipos.tipo, inventario.frd, inventario.eir_r, inventario.fdespims, DATEDIFF(inventario.fdespims,inventario.frd) + 1 AS dpatio, lineas.dlibres FROM inventario, tequipos, lineas WHERE inventario.linea = %d AND inventario.fdespims = '%s' AND inventario.tcont = tequipos.id AND inventario.linea = lineas.id AND DATEDIFF(inventario.fdespims,inventario.frd) + 1 > lineas.dlibres;",$linea,$despacho);
	$acopio->Consulta($sql);
	
}

if(isset($_POST['linea'])){
	$cobrar = new Acopio;
	$cobrar->DefineLinea($_POST['linea']);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
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
<!--Script-->
<script src="../bootstrap/js/jquery.min.js"></script>
<script src="../bootstrap/js/bootstrap.min.js"></script>
<script src="../bootstrap/table/bootstrap-table.js"></script>
<script src="../bootstrap/table/extensions/filter-control/bootstrap-table-filter-control.min.js"></script>
<script src="../bootstrap/table/extensions/natural-sorting/bootstrap-table-natural-sorting.min.js"></script>
<script src="../bootstrap/table/extensions/multiple-sort/bootstrap-table-multiple-sort.min.js"></script>
<script src="../bootstrap/js/jquery.bootstrap-autohidingnavbar.min.js"></script>
<script>
$(document).ready(function(){
	$('[data-toggle="tooltip"]').tooltip();
});
</script>
<script language="javascript" type="text/javascript">
function validarDatos(){
	if(linea.selectedIndex == 0){
		boton.disabled = true;
		linea.focus();
		alert('Debe seleccionar la linea');
	}else {
		boton.disabled = false;
	}
}
</script>
<script>
function DAcopio(var1,var2){
	var almacen = var1.value;
	var libre = var2.value;
	var dias = almacen - libre;
	document.write(dias);
}
</script>
</head><body>
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
      <li><a href="<?php echo $_SERVER['PHP_SELF']."?exp=1"; ?>" id="exportar">Exportar</a></li>
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
 <!--  <h3>Acopio</h3>-->
 <div class="row">
  <div class="col-sm-6">
   <form class="form-inline" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" name="form1" id="form1">
    <fieldset>
     <legend>Rango</legend>
     <div class="form-group">
      <label class="control-label" for="linea">Linea:</label>
      <select class="form-control" name="linea" id="linea" onchange="boton.disabled = false;">
       <option value="0">Seleccion</option>
       <?php do{ ?>
       <option value="<?php echo $lineas->Filas['id'];?>"><?php echo $lineas->Filas['nombre'];?></option>
       <?php }while($lineas->Filas = mysqli_fetch_assoc($lineas->Consulta)); ?>
      </select>
     </div>
     <div class="form-group">
      <label class="control-label" for="despacho">Despacho:</label>
      <input class="form-control" name="despacho" type="date" id="despacho" value="<?php echo date('Y-m-d'); ?>" />
     </div>
     <button class="btn btn-default" name="boton" id="boton" type="submit" value="Enviar" onclick="validarDatos()">Enviar</button>
    </fieldset>
   </form>
  </div>
 </div>
 <?php if( isset($acopio) && $acopio->Num_resultados > 0){ ?>
 <div class="row">
  <div class="col-sm-4">
   <!--resumen20-->
   <?php if($recaps20->Num_resultados > 0){?>
   <table width="240" border="1" align="left" cellpadding="0" cellspacing="0" class="recaps">
    <tr>
     <th scope="col">Tipo</th>
     <th scope="col">Cantidad</th>
    </tr>
    <?php do{ ?>
    <tr>
     <td scope="tipo"><?php echo $recaps20->Filas['tipo']; ?></td>
     <td scope="cantidad"><?php $suma20 = $suma20 + $recaps20->Filas['cantidad']; echo $recaps20->Filas['cantidad']; ?></td>
    </tr>
    <?php }while($recaps20->Filas = mysqli_fetch_assoc($recaps20->Consulta)); ?>
    <tr>
     <td scope="total">Total:</td>
     <td scope="total"><?php echo $suma20;?></td>
    </tr>
   </table>
   <?php } ?>
  </div>
  <div class="col-sm-4">
   <!--resumen40-->
   <?php if($recaps40->Num_resultados > 0){ ?>
   <table width="240" border="1" align="left" cellpadding="0" cellspacing="0" class="recaps">
    <tr>
     <th scope="col">Tipo</th>
     <th scope="col">Cantidad</th>
    </tr>
    <?php do{ ?>
    <tr>
     <td scope="tipo"><?php echo $recaps40->Filas['tipo'];?></td>
     <td scope="cantidad"><?php $suma40 = $suma40 + $recaps40->Filas['cantidad']; echo $recaps40->Filas['cantidad'];?></td>
    </tr>
    <?php }while ($recaps40->Filas = mysqli_fetch_assoc($recaps40->Consulta));?>
    <tr>
     <td scope="total">Total:</td>
     <td scope="total"><?php echo $suma40; ?></td>
    </tr>
   </table>
   <?php } ?>
  </div>
  <div class="col-sm-4">
  </div>
 </div>
 <div class="row">
  <div class="col-xs-12">
   <!--acopio-->
   <table id="inventario" class="table table-bordered table-condensed table-hover sortable" 
               data-toggle="table"
               data-sortable="true"
               data-id-field="#"
               data-toolbar="#toolbar"
               data-show-export="true"
               data-buttons-align="left"
               data-show-refresh="true"
               data-show-reset="true"
               data-show-toggle="true"
               data-show-columns="true"
               data-pagination="true"
               data-page-size="50"
               data-search="true"
               data-search-align="left"
               data-maintain-selected="true">
    <caption>
    ACOPIO: <?php echo $acopio->Filas['linea']; ?> || Total: <?php echo $acopio->Num_resultados; ?> Equipos
    </caption>
    <thead>
     <tr>
      <th data-field="#" data-sortable="true" data-sorter="alphanum" scope="col">#</th>
      <th data-field="linea" data-sortable="true" data-sorter="alphanum" scope="col">Linea</th>
      <th data-field="contenedor" data-sortable="true" data-sorter="alphanum" scope="col">Contenedor</th>
      <th data-field="tipo" data-sortable="true" data-sorter="alphanum" scope="col">Tipo</th>
      <th data-field="frd" data-sortable="true" data-sorter="alphanum" scope="col">Frd</th>
      <th data-field="eir" data-sortable="true" data-sorter="alphanum" scope="col">EIR</th>
      <th data-field="fdesp" data-sortable="true" data-sorter="alphanum" scope="col">Fdesp</th>
      <th data-field="da" data-sortable="true" data-sorter="alphanum" scope="col">DA</th>
      <th data-field="dl" data-sortable="true" data-sorter="alphanum" scope="col">DL</th>
      <th data-field="acopio" data-sortable="true" data-sorter="alphanum" scope="col">Acopio</th>
      <th data-field="tarifa" data-sortable="true" data-sorter="alphanum" scope="col">Tarifa</th>
      <th data-field="monto" data-sortable="true" data-sorter="alphanum" scope="col">Monto</th>
     </tr>
    </thead>
    <?php do{ ?>
    <tr>
     <td scope="num"><?php echo ++$contador; ?></td>
     <td scope="linea"><?php echo $acopio->Filas['linea'];?></td>
     <td scope="contenedor"><?php echo $acopio->Filas['contenedor'];?></td>
     <td scope="tipo"><?php echo $acopio->Filas['tipo'];?></td>
     <td scope="fecha"><?php echo $acopio->Filas['frd'];?></td>
     <td scope="eir"><?php echo $acopio->Filas['eir_r'];?></td>
     <td scope="fecha"><?php echo $acopio->Filas['fdespims'];?></td>
     <td scope="num"><?php echo $acopio->Filas['dpatio'];?></td>
     <td scope="num"><?php echo $acopio->Filas['dlibres'];?></td>
     <td scope="num"><?php $cobrar->DimeDias($acopio->Filas['dpatio'] - $acopio->Filas['dlibres']); echo $cobrar->DiasAcopio; ?></td>
     <td scope="monto"><?php $cobrar->aCobrar($acopio->Filas['tipo']); echo "Bs. " . number_format($cobrar->Cobra,2); ?></td>
     <td scope="monto"><?php $total[] = $cobrar->DiasAcopio * $cobrar->Cobra; echo number_format($cobrar->DiasAcopio * $cobrar->Cobra,2); ?></td>
    </tr>
    <?php } while($acopio->Filas = mysqli_fetch_assoc($acopio->Consulta));?>
    <tfoot>
     <tr>
      <td scope="col">&nbsp;</td>
      <td scope="col">&nbsp;</td>
      <td scope="col">&nbsp;</td>
      <td scope="col">&nbsp;</td>
      <td scope="col">&nbsp;</td>
      <td scope="col">&nbsp;</td>
      <td scope="col">&nbsp;</td>
      <td scope="col">&nbsp;</td>
      <td scope="col">&nbsp;</td>
      <td scope="col">&nbsp;</td>
      <th scope="col">Total:</th>
      <td scope="monto"><?php echo number_format(array_sum($total),2);?></td>
     </tr>
    </tfoot>
   </table>
  </div>
 </div>
 <?php }else if ( isset($_POST['linea']) && isset($_POST['despacho']) && $acopio->Num_resultados = 0){ ?>
 <div class="row">
  <h1>&nbsp;</h1>
 </div>
 <div class="row">
  <div class="col-sm-4">
   <div class="alert alert-info">
    <span>Sin resultados</span>
   </div>
  </div>
 </div>
 <?php }else { ?>
 <div class="row">
  <h1>&nbsp;</h1>
 </div>
 <div class="row">
  <div class="col-sm-4">
   <div class="alert alert-info">
    <span>Informe de Acopio</span>
   </div>
  </div>
 </div>
 <?php } ?>
</div>
</body>
</html>