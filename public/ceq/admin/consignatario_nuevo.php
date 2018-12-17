<?php
session_start();
session_name($_SESSION['variables']['usuario']);
require_once('../config.php');
require_once('../clases/class_Conexion.php');
#Seguridad
$seguridad = new Seguridad();
$seguridad->ValidarUsuario();

if(isset($_POST['submit']) and $_POST['submit'] == 'guardar' ){
	$rif = $_POST['rif'];
	$nombre = strtoupper($_POST['nombre']);
	$libres = $_POST['dlibres'];
	$contacto = $_POST['pcontacto'];
	$email = $_POST['email'];
	$tel = $_POST['tel'];
	
	$registrar = new DBMySQL();
	$registrar->Datosconexion(UDB,PDB,USERDB);
	$strSQL = sprintf("INSERT INTO consignatario(rif,nombre,libre,pcontacto,email,telf,auditoria) VALUES('%s','%s',%d,'%s','%s','%s',%d);",$rif,$nombre,$libres,$contacto,$email,$tel,IDUSER);
	$registrar->Insertar($strSQL);
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
<!--Script-->
<script src="../js/jquery-1.11.3.min.js"></script>
<script src="../bootstrap/js/bootstrap.min.js"></script>
<script src="../bootstrap/validators/validator.min.js"></script>
<script src="../bootstrap/dialog/js/bootstrap-dialog.min.js"></script>
<script src="../bootstrap/js/jquery.bootstrap-autohidingnavbar.min.js"></script>
<script>
$(document).ready(function(){
	
	$("nav.navbar-fixed-top").autoHidingNavbar();
	
	$('[data-toggle="popover"]').popover();
	$('#nombre').css('text-transform','uppercase');
	
});
</script>
<script>

$(function(){
	$('#nombre').on('blur', function(){
		var $nombre = $('#nombre').val();
		$.post("../json/consignatarioSearch_Json.php", { nombre: $nombre }, function(data){
			if(data > 0){
				$('#nombre').val(null);
				BootstrapDialog.show({
					type: 'type-danger',
					size: 'size-small',
					title: 'ERROR',
					message: 'Consignatario ya registrado!'
				})
			}
		})
	})
});

</script>
<!--Estilos-->
<link rel="stylesheet" type="text/css" href="../bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="../bootstrap/dialog/css/bootstrap-dialog.min.css">
<link rel="stylesheet" type="text/css" href="../bootstrap/css/bootstrap-responsive.min.css">
</head>

<body>
<div class="container">
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
  <div class="col-sm-4">
   <form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" name="consigNew" id="consigNew">
    <fieldset>
     <legend>Nuevo Consignatario</legend>
     <div class="input-group form-group">
      <label class="input-group-addon" for="rif">RIF:</label>
      <input class="form-control" name="rif" type="text" required id="rif" tabindex="1" value="J-00000000-0" size="10">
      <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
      <div class="help-block with-errors">
      </div>
     </div>
     <div class="input-group form-group">
      <label class="input-group-addon" for="nombre">Nombre:</label>
      <input class="form-control" size="44" name="nombre" type="text" required id="nombre" placeholder="Denominacion Comercial" tabindex="2" >
      <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
     </div>
     <div class="input-group form-group">
      <label class="input-group-addon" for="dlibres">D/Libres:</label>
      <input class="form-control" name="dlibres" type="number" required id="dlibres" value="3650" data-toggle="popover" data-trigger="focus" title="Dias Libres" data-content="No modifique la cantidad si no va a asignar dias libres al Consignatario">
      <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
     </div>
     <div class="input-group form-group">
      <label class="input-group-addon" for="pcontacto">Contacto:</label>
      <input class="form-control" name="pcontacto" type="text" id="pcontacto" placeholder="Persona Contacto" tabindex="3">
     </div>
     <div class="input-group form-group">
      <label class="input-group-addon" for="email">Email:</label>
      <input class="form-control" name="email" type="email" id="email" placeholder="buzon@dominio.com" tabindex="4">
     </div>
     <div class="input-group form-group">
      <label class="input-group-addon" for="tel">Telefono:</label>
      <input class="form-control" name="tel" type="tel" id="tel" tabindex="5" placeholder="0000-000 00 00">
     </div>
     <button class="btn btn-primary" type="submit" name="submit" id="submit" value="guardar" tabindex="6">Guardar</button>
    </fieldset>
   </form>
  </div>
 </div>
</div>
<script>
$(function(){
	$('#consigNew').validator();
});
</script>
<?php
if(isset($_POST) && isset($registrar) && $registrar->Afectados > 0){ ?>
<script>
BootstrapDialog.show({
	type: 'type-success',
	size: 'size-small',
	title: 'Nuevo Consignatario',
	message: 'Registro efectuado!'
});
</script>
<?php } ?>
<?php $cache->cerrar(); ?>
</body>
</html>