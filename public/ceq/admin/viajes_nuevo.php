<?php
session_start();
session_name($_SESSION['variables']['usuario']);
require_once('../config.php');
require_once('../clases/class_Conexion.php');
#Seguridad
$seguridad = new Seguridad();
$seguridad->ValidarUsuario();

#Lineas
$lineas = new DBMySQL();
$lineas->Datosconexion(UDB,PDB,USERDB);
$lineas->Consulta("SELECT id, nombre FROM lineas WHERE activo = 0 ORDER BY nombre ASC;");

if(isset($_POST['viaje']) && isset($_POST['buque']) && isset($_POST['fecha'])){
	$viaje = $_POST['viaje'];
	$buque = $_POST['buque'];
	$fecha = $_POST['fecha'];
	$registrar = new DBMySQL();
	$registrar->Datosconexion(UDB,PDB,USERDB);
	$sql = sprintf("INSERT INTO viajes(viaje,buque,eta) VALUES('%s',%d,'%s');",$viaje,$buque,$fecha);
	$registrar->Insertar($sql);
	if($registrar->Afectados > 0){
		$mostrar = 1;
	}
}

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Viajes</title>
<script src="../js/jquery-1.11.1.min.js"></script>
<script src="../js/jquery-ui.js"></script>
<script src="../bootstrap/js/bootstrap.min.js"></script>
<script src="../bootstrap/validators/validator.min.js"></script>
<script src="../bootstrap/dialog/js/bootstrap-dialog.min.js"></script>
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



$(document).ready(function(e) {
	if(/chrom(e|ium)/.test(navigator.userAgent.toLowerCase())){
		 //Nada
	}else {
		$('#fecha').datepicker({
			 maxDate: new Date(),
		 });
		 $( "#fecha" ).datepicker( "option", "dateFormat", "yy-mm-dd" );
	}
});

$(function(){
	$('#viaje').css('text-transform','uppercase');
	$('#viaje').on('blur', function(){
		var $buque = $('#buque').val();
		var $viaje = $('#viaje').val();
		$.post("../json/viajesJson.php", { buque: $buque, viaje: $viaje }, function(data){
			if(data > 0){
				$('#viaje').val(null);
				BootstrapDialog.show({
					type: 'type-danger',
					size: 'size-small',
					title: 'ERROR',
					message: 'Viaje que ya registrado!'
				})
			}
		})
	})
});
</script>
<link rel="stylesheet" type="text/css" href="../bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="../bootstrap/css/bootstrap-responsive.min.css">
<link rel="stylesheet" type="text/css" href="../bootstrap/dialog/css/bootstrap-dialog.min.css">
<link rel="stylesheet" type="text/css" href="../js/jquery-ui.min.css">
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
 <div class="row">
  <div class="col-sm-4">
   <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" name="formViajesIn" class="form-horizontal" id="formViajesIn" role="form" data-toggle="validator">
    <fieldset>
     <legend>Nuevo Viaje</legend>
     <div class="input-group form-group">
      <label class="input-group-addon" for="linea">Linea:</label>
      <select name="linea" required class="form-control" id="linea" tabindex="1" data-error="Seleccione la Linea">
       <option value="" selected>Seleccion</option>
       <?php do { ?>
       <option value="<?php echo $lineas->Filas['id']; ?>"><?php echo $lineas->Filas['nombre']; ?></option>
       <?php } while ($lineas->Filas = mysqli_fetch_assoc($lineas->Consulta)); ?>
      </select>
      <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
      <div class="help-block with-errors">
      </div>
     </div>
     <div class="input-group form-group">
      <label class="input-group-addon" for="buque">Buque:</label>
      <select name="buque" required class="form-control" id="buque" tabindex="2">
      </select>
      <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
      <div class="help-block with-errors">
      </div>
     </div>
     <div class="input-group form-group">
      <label class="input-group-addon" for="viaje">Viaje:</label>
      <input class="form-control" name="viaje" type="text" required id="viaje" placeholder="000/W">
      <!-- pattern="^([a-zA-Z0-9]{1,3})([\/|-]{1})([a-zA-Z]{1,2})$" -->
     </div>
     <div class="input-group form-group">
      <label class="input-group-addon" for="fecha">Fecha:</label>
      <input type="date" class="form-control" name="fecha" id="fecha" max="<?php echo AHORAC; ?>" required>
     </div>
     <button type="submit" class="btn btn-primary" value="guardar">Guardar</button>
    </fieldset>
   </form>
  </div>
 </div>
</div>
<script>
$(document).ready(function() {
  //Ocultar MenuBar
  $("nav.navbar-fixed-top").autoHidingNavbar();
  //Tooltip
  $('[data-toggle="tooltip"]').tooltip();

  $('#formViajesIn').validator({
	  feedback: {
		  success: 'glyphicon glyphicon-ok',
		  error: 'glyphicon glyphicon-remove'
	  }
  });
});

</script>
<?php
if(isset($_POST['submit'])){ ?>
<script>
BootstrapDialog.show({
	type: 'type-success',
	size: 'size-small',
	title: 'Nuevo Viaje',
	message: 'Registro efectuado!'
});
</script>
<?php } ?>
<?php $cache->cerrar(); ?>
</body>
<?php
//Liberar memoria
$lineas->Liberar();

//Cerrar conexion
$lineas->Cerrar();
if(isset($_POST['value'])){
	$registrar->Liberar();
	$registrar->Cerrar();
}
?>
</html>