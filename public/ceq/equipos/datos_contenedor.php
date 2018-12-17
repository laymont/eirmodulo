<?php
session_start();
session_name($_SESSION['variables']['usuario']);
require_once('../config.php');
require_once('../clases/class_Conexion.php');
require_once('../clases/class_Contenedor.php');
require_once('../funciones/funciones.php');
#Seguridad
$seguridad = new Seguridad();
$seguridad->ValidarUsuario();

#Condicion
$cond = array('DMG'=>4,'OPR1'=>1,'OPR2'=>2,'OPR3'=>3);

if(isset($_GET['id'])){
	$id = $_GET['id'];
	$datos = new Contenedor();
	$datos->EditarEquipo($id);
	if($datos->Datos['c'] == 0){
		$mostrar = 1;
		#Linea
	$linea = new DBMySQL();
	$linea->Datosconexion(UDB,PDB,USERDB);
	$linea->Consulta(sprintf("SELECT id, nombre FROM lineas WHERE id = %d AND activo = 0;",$datos->Datos['linea']));
	
	#Buque
	$buque = new DBMySQL();
	$buque->Datosconexion(UDB,PDB,USERDB);
	$buque->Consulta(sprintf("SELECT id, nombre FROM buques WHERE id = %d AND activo = 0;",$datos->Datos['buque']));
	
	#Viaje
	$viaje = new DBMySQL();
	$viaje->Datosconexion(UDB,PDB,USERDB);
	$viaje->Consulta(sprintf("SELECT id, buque, viaje FROM viajes WHERE buque = %d AND activo = 0;",$datos->Datos['buque']));

	#tipo contenedor
	$tipo = new DBMySQL();
	$tipo->Datosconexion(UDB,PDB,USERDB);
	$tipo->Consulta("SELECT id, tipo FROM tequipos where id NOT IN(13,14,16,17);");
	
	#Patios
	$patios = new DBMySQL();
	$patios->Datosconexion(UDB,PDB,USERDB);
	$patios->Consulta("SELECT * FROM patios;");
	
	#Consignatarios
	$consignatarios = new DBMySQL();
	$consignatarios->Datosconexion(UDB,PDB,USERDB);
	$consignatarios->Consulta("SELECT id, nombre FROM consignatario WHERE nombre REGEXP '[[:alnum:]_[:digit:]]{1,50}' ORDER BY nombre;");
	}else if($datos->Datos['c'] == 1){
		$mostrar = 2;
		#Buque
		$buque = new DBMySQL();
		$buque->Datosconexion(UDB,PDB,USERDB);
		$buque->Consulta(sprintf("SELECT id,linea, nombre FROM buques WHERE id = %d AND linea = linea AND activo = 0;",$datos->Datos['buqued']));
		$linea = $buque->Filas['linea'];
		#Completar el SELECT
		$select = new DBMySQL();
		$select->Datosconexion(UDB,PDB,USERDB);
		$sql = sprintf("SELECT id, nombre FROM buques WHERE linea = %d AND id <> %d;",$linea,$datos->Datos['buqued']);
		$select->Consulta($sql);

		#tipo contenedor
		$tipo = new DBMySQL();
		$tipo->Datosconexion(UDB,PDB,USERDB);
		$tipo->Consulta("SELECT id, tipo FROM tequipos where id NOT IN(13,14,16,17);");
	
	}
	
	
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="Ayaguna, Control de Equipos">
<meta name="author" content="Laymont Arratia">
<title><?php echo VERSION; ?></title>
<!--Script-->
<script src="../js/jquery-1.11.3.min.js"></script>
<script src="../js/jquery-ui.min.js"></script>
<script src="../bootstrap/js/bootstrap.min.js"></script>
<script src="../bootstrap/dialog/js/bootstrap-dialog.min.js"></script>
<script src="../bootstrap/js/jquery.bootstrap-autohidingnavbar.min.js"></script>
<script src="../bootstrap/validators/validator.min.js"></script>
<script>
$(document).ready(function() {
  var fechaBuque = $("#fdb");
	var fechaMuelle = $("#fdm");
	var fdmDefault = fechaMuelle.val();
	var fechaRecep = $("#frd");
	var frdDefault = fechaRecep.val();
	
	function comparaFechas(str1,str2){
		var ini = Date.parse(str1.val());
		var fin = Date.parse(str2.val());
		if(ini > fin){
			return false;
		}else {
			return true;
		}
	}
	
	fechaMuelle.change(function(){
		if(comparaFechas(fechaBuque,fechaMuelle) != true){
			$("#fdm").val(fdmDefault);
			alert('error');
		}
	});
	
	fechaRecep.change(function(){
		if(comparaFechas(fechaBuque,fechaRecep) != true){
			$("#frd").val(frdDefault);
			alert('error');
		}else if(comparaFechas(fechaMuelle,fechaRecep) != true){
			$("#frd").val(frdDefault);
			alert('error');
		}
	});
	
});
</script>
<!--Css-->
<link rel="stylesheet" type="text/css" href="../bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="../bootstrap/dialog/css/bootstrap-dialog.min.css">
<link rel="stylesheet" type="text/css" href="../js/jquery-ui.min.css">
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
      <!--<li><a href="inventarioExp.php" id="exportar">Exportar</a></li>-->
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
 <?php if($mostrar == 1){ ?>
 <div class="row">
  <h3>Datos Contenedor</h3>
  <div class="col-sm-6">
   <form role="form" action="datos_contenedor_in.php" method="post" enctype="application/x-www-form-urlencoded" name="formEditIN" id="formEditIN" data-toggle="validator">
    <input class="form-control" type="hidden" name="id" id="id" value="<?php echo $_GET['id']; ?>">
    <div class="row">
     <div class="form-group col-sm-4">
      <label class="control-label" for="linea">Linea:</label>
      <select class="form-control" name="linea" id="linea">
       <option value="<?php echo $linea->Filas['id']; ?>"><?php echo $linea->Filas['nombre']; ?></option>
      </select>
      <span class="text-danger">* No editable</span>
     </div>
     <div class="form-group col-sm-4">
      <label class="control-label" for="buque">Buque:</label>
      <select class="form-control" name="buque" id="buque">
       <option value="<?php echo $buque->Filas['id']; ?>"><?php echo $buque->Filas['nombre']; ?></option>
      </select>
      <span class="text-danger">* No editable</span>
     </div>
     <div class="form-group col-sm-4">
      <label class="control-label" for="viaje">Viaje:</label>
      <select class="form-control" name="viaje" id="viaje" required>
       <?php do{ ?>
       <?php if($viaje->Filas['id'] == $datos->Datos['viaje']){?>
       <option value="<?php echo $viaje->Filas['id']; ?>" selected><?php echo $viaje->Filas['viaje']; ?></option>
       <?php }else { ?>
       <option value="<?php echo $viaje->Filas['id']; ?>"><?php echo $viaje->Filas['viaje']; ?></option>
       <?php } ?>
       <?php } while($viaje->Filas = mysqli_fetch_assoc($viaje->Consulta)); ?>
      </select>
     </div>
    </div>
    <div class="row">
     <div class="form-group col-sm-4">
      <label class="control-label" for="contenedor">Contenedor:</label>
      <input class="form-control" name="contenedor" type="text" id="contenedor" value="<?php echo $datos->Datos['contenedor']; ?>" readonly>
      <span class="text-danger">* No editable</span>
     </div>
     <div class="form-group col-sm-4">
      <label class="control-label" for="tcont">Tipo:</label>
      <select class="form-control" name="tcont" id="tcont" required>
       <?php do{ ?>
       <?php if($datos->Datos['tcont'] == $tipo->Filas['id']){ ?>
       <option value="<?php echo $tipo->Filas['id']; ?>" selected><?php echo $tipo->Filas['tipo']; ?></option>
       <?php }else { ?>
       <option value="<?php echo $tipo->Filas['id']; ?>"><?php echo $tipo->Filas['tipo']; ?></option>
       <?php } ?>
       <?php } while ($tipo->Filas = mysqli_fetch_assoc($tipo->Consulta)); ?>
      </select>
     </div>
    </div>
    <div class="row">
     <div class="form-group col-sm-4">
      <label class="control-label" for="fdb">Fdb:</label>
      <input class="form-control" type="date" name="fdb" id="fdb" value="<?php echo $datos->Datos['fdb']; ?>" readonly>
      <span class="text-danger">* No editable</span>
     </div>
     <div class="form-group col-sm-4">
      <label class="control-label" for="fdm">Fdm:</label>
      <input class="form-control" type="date" name="fdm" id="fdm" value="<?php echo $datos->Datos['fdm']; ?>" required>
     </div>
     <div class="form-group col-sm-4">
      <label class="control-label" for="frd">Frd:</label>
      <input class="form-control" type="date" name="frd" id="frd" value="<?php echo $datos->Datos['frd']; ?>" required>
     </div>
    </div>
    <div class="row">
     <div class="form-group col-sm-4">
      <label class="control-label" for="eir_r">EIR:</label>
      <input class="form-control" type="number" name="eir_r" id="eir_r" value="<?php echo $datos->Datos['eir_r']; ?>" required>
     </div>
     <div class="form-group col-sm-4">
      <label class="control-label" for="fact">Fact:</label>
      <input class="form-control" type="number" name="fact" id="fact"  value="<?php echo $datos->Datos['fact']; ?>">
     </div>
     <div class="form-group col-sm-4">
      <label class="control-label" for="paset">Pase:</label>
      <input class="form-control" type="number" name="paset" id="paset" value="<?php echo $datos->Datos['paset']; ?>">
     </div>
    </div>
    <div class="row">
     <div class="form-group col-sm-4">
      <label class="control-label" for="status">Estatus:</label>
      <select class="form-control" name="status" id="status" required>
       <?php if($datos->Datos['status'] == 0){ ?>
       <option value="0" selected>EMPTY</option>
       <option value="1">FULL</option>
       <?php }else if($datos->Datos['status'] == 1){ ?>
       <option value="0">EMPTY</option>
       <option value="1" selected>FULL</option>
       <?php } ?>
      </select>
     </div>
     <div class="form-group col-sm-4">
      <label class="control-label" for="condicion">Condicion:</label>
      <select class="form-control" name="condicion" id="condicion" required>
       <?php foreach($cond as $indice => $valor){ ?>
       <?php if($datos->Datos['condicion'] == $valor){ ?>
       <option value="<?php echo $valor;?>" selected><?php echo $indice;?></option>
       <?php }else { ?>
       <option value="<?php echo $valor;?>"><?php echo $indice;?></option>
       <?php } ?>
       <?php } ?>
      </select>
     </div>
     <div class="form-group col-sm-4">
      <label class="control-label" for="precinto">Precinto:</label>
      <input class="form-control" type="number" name="precinto" id="precinto" value="<?php echo $datos->Datos['precinto']; ?>">
     </div>
    </div>
    <div class="row">
     <div class="form-group col-sm-4">
      <label class="control-label" for="bl">B/L:</label>
      <input class="form-control" type="text" name="bl" id="bl" value="<?php echo $datos->Datos['bl']; ?>">
     </div>
     <div class="form-group col-sm-4">
      <label class="control-label" for="patio">Patio:</label>
      <select class="form-control" name="patio" id="patio" required>
       <?php do{ ?>
       <?php if($datos->Datos['patio'] == $patios->Filas['id']){ ?>
       <option value="<?php echo $patios->Filas['id']; ?>" selected><?php echo $patios->Filas['patio']; ?></option>
       <?php }else { ?>
       <option value="<?php echo $patios->Filas['id']; ?>"><?php echo $patios->Filas['patio']; ?></option>
       <?php } ?>
       <?php } while ($patios->Filas = mysqli_fetch_assoc($patios->Consulta)); ?>
      </select>
     </div>
    </div>
    <div class="row">
     <div class="form-group col-sm-10">
      <label class="control-label" for="consignatario">Consignatario:</label>
      <select class="form-control" name="consignatario" id="consignatario" required>
       <?php do{ ?>
       <?php if($datos->Datos['consignatario'] == $consignatarios->Filas['id']){ ?>
       <option value="<?php echo $consignatarios->Filas['id']; ?>" selected><?php echo $consignatarios->Filas['nombre']; ?></option>
       <?php }else { ?>
       <option value="<?php echo $consignatarios->Filas['id']; ?>"><?php echo $consignatarios->Filas['nombre']; ?></option>
       <?php } ?>
       <?php } while($consignatarios->Filas = mysqli_fetch_assoc($consignatarios->Consulta)); ?>
      </select>
     </div>
    </div>
    <div class="row">
     <div class="form-group col-sm-8">
      <label class="control-label" for="obs">Observación:</label>
      <textarea class="form-control" name="obs" cols="60" rows="5" id="obs"><?php echo $datos->Datos['obs']; ?></textarea>
     </div>
    </div>
    <input class="btn btn-primary" type="submit" name="submit" id="submit" value="Enviar">
   </form>
  </div>
 </div>
 <!--primera fila, primer formulario-->
 <?php }else if($mostrar == 2){ ?>
 <div class="row">
  <div class="col-sm-6">
   <form role="form" action="datos_contenedor_out.php" method="post" enctype="application/x-www-form-urlencoded" name="formEditOUT" id="formEditOUT">
    <input class="form-control" type="hidden" name="id" id="id" value="<?php echo $_GET['id']; ?>">
    <div class="row">
     <div class="col-sm-4 form-group">
      <label class="control-label" for="contenedor">Contenedor:</label>
      <input class="form-control" name="contenedor" type="text" id="contenedor" value="<?php echo $datos->Datos['contenedor']; ?>" readonly>
      <span class="alerta">* No editable</span>
     </div>
     <div class="col-sm-4 form-group">
      <label class="control-label" for="estatus">Estatus:</label>
      <select class="form-control" name="estatus" id="estatus">
       <?php if($datos->Datos['status'] == 0){ ?>
       <option value="0" selected>EMPTY</option>
       <option value="1">FULL</option>
       <?php }else if($datos->Datos['status'] == 1){ ?>
       <option value="0">EMPTY</option>
       <option value="1" selected>FULL</option>
       <?php } ?>
      </select>
     </div>
     <div class="col-sm-4 form-group">
      <label class="control-label" for="condicion">Condicion:</label>
      <select class="form-control" name="condicion" id="condicion">
       <?php foreach($cond as $indice => $valor){ ?>
       <?php if($datos->Datos['condicion'] == $valor){ ?>
       <option value="<?php echo $valor;?>" selected><?php echo $indice;?></option>
       <?php }else { ?>
       <option value="<?php echo $valor;?>"><?php echo $indice;?></option>
       <?php } ?>
       <?php } ?>
      </select>
     </div>
    </div>
    <div class="row">
     <div class="col-sm-8">
      <label class="control-label" for="obs">Observación:</label>
      <textarea class="form-control" name="obs" cols="60" rows="5" id="obs"><?php echo $datos->Datos['obs']; ?></textarea>
     </div>
    </div>
    <div class="row">
     <div class="col-sm-4 form-group">
      <label class="control-label" for="fdespims">F.Desp:</label>
      <input class="form-control" type="date" name="fdespims" id="fdespims" value="<?php echo $datos->Datos['fdespims']; ?>">
     </div>
     <div class="col-sm-4 form-group">
      <label class="control-label" for="eir_d">EIR:</label>
      <input class="form-control" type="number" name="eir_d" id="eir_d" value="<?php echo $datos->Datos['eir_d']; ?>">
     </div>
    </div>
    <div class="row">
     <div class="col-sm-4 form-group">
      <label class="control-label" for="buque_d">Buque:</label>
      <select class="form-control" name="buque_d" id="buque_d">
       <option value="<?php echo $buque->Filas['id'];?>"><?php echo $buque->Filas['nombre'];?></option>
       <?php do{ ?>
       <option value="<?php echo $select->Filas['id']; ?>"><?php echo $select->Filas['nombre']; ?></option>
       <?php } while($select->Filas = mysqli_fetch_assoc($select->Consulta)); ?>
      </select>
     </div>
     <div class="col-sm-4 form-group">
      <label class="control-label" for="viajed">Viaje:</label>
      <input class="form-control" type="text" name="viajed" id="viajed" value="<?php echo $datos->Datos['viajed']; ?>">
     </div>
    </div>
    <input class="btn btn-primary" type="submit" name="submit" id="submit" value="Enviar">
   </form>
  </div>
 </div>
 <?php } ?>
</div>
<!--container-->
</body>
<script>
$(document).ready(function() {
  //Ocultar MenuBar
  $("nav.navbar-fixed-top").autoHidingNavbar();
  //Tooltip
	$('[data-toggle="tooltip"]').tooltip();
});
<!--Validador-->
$(function(){
	$('#formEditIN').validator({
		feedback: {
			success: 'glyphicon glyphicon-ok',
			error: 'glyphicon glyphicon-remove'
		}
	}) 
});
$("#viaje").change(function() {
  var Viaje = $(this).val();
	var Buque = $("#buque").val();
	$.post("../json/viajes_editContenedor.php", { buque: Buque, viaje: Viaje }, function(data){
		var fecha = data.toString();
		$("#fdb").val(fecha);
		console.info(data);
	});
});
</script>
</html>