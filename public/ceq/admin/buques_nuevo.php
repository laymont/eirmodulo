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

if(isset($_POST['linea']) and isset($_POST['buque'])){
	#Datos
	$idlinea = $_POST['linea'];
	$buque = strtoupper($_POST['buque']);
	
	#Registrar Buque
	$registro = new DBMySQL();
	$registro->Datosconexion(UDB,PDB,USERDB);
	$sql = sprintf("INSERT INTO buques(linea,nombre,activo) VALUES(%d,'%s',0);",$idlinea,$buque);
	$registro->Insertar($sql);
	if($registro->Afectados > 0){
		$mostrar = 1;
	}
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
<script src="../bootstrap/js/jquery.min.js"></script>
<script src="../bootstrap/js/bootstrap.min.js"></script>
<script src="../bootstrap/js/jquery.bootstrap-autohidingnavbar.min.js"></script>
<script src="../bootstrap/validators/validator.min.js"></script>
<script src="../bootstrap/dialog/js/bootstrap-dialog.min.js"></script>
<script>
$(document).ready(function(){
	
	$("nav.navbar-fixed-top").autoHidingNavbar();
	
	$('[data-toggle="tooltip"]').tooltip();
	
	$('#buque').css('text-transform','capitalize');
});
$(function(){
	$('#buque').on('blur', function(){
		var $linea = $('#linea').val();
		var $buque = $('#buque').val();
		$.post("../json/buquesJson.php", { linea: $linea, buque: $buque }, function(data){
			if(data > 0){
				$('#buque').val(null);
				BootstrapDialog.show({
					type: 'type-danger',
					size: 'size-small',
					title: 'ERROR',
					message: 'Buque que ya registrado!'
				})
				//return false;
			}
		})
	});
});
</script>
<!--Estilos-->
<link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="../bootstrap/css/styleBootstrap.css">
<link rel="stylesheet" href="../bootstrap/table/bootstrap-table.min.css">
<link rel="stylesheet" type="text/css" href="../bootstrap/dialog/css/bootstrap-dialog.min.css">
</head>

<body>
<div class="container"> 
  <!--Menu-->
  <div class="row">
    <div class="col-sm-12">
      <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1"> <span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span> </button>
          <a class="navbar-brand" href="#"><span class="text-primary">Ayaguna</span></a> </div>
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
  <!--Menu-->
  <div class="row">
    <div class="col-sm-4">
      <form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" name="buqueNuevo" id="buqueNuevo" role="form">
        <fieldset>
          <legend>Nuevo Buque</legend>
          <div class="form-group has-feedback" id="controlLinea">
            <label class="control-label" for="linea">Linea:</label>
            <select class="form-control" name="linea" required id="linea">
              <option value="">Seleccion</option>
              <?php do{ ?>
              <option value="<?php echo $lineas->Filas['id'];?>"><?php echo $lineas->Filas['nombre'];?></option>
              <?php } while ($lineas->Filas = mysqli_fetch_assoc($lineas->Consulta));?>
            </select>
            <span class="glyphicon form-control-feedback" aria-hidden="true"></span> <span id="lineaStatus" class="sr-only">(success)</span> 
            </div>
          <div class="form-group has-feedback" id="controlBuque">
            <label class="control-label" for="buque">Buque:</label>
            <input class="form-control" name="buque" type="text" required id="buque" placeholder="Nombre">
            <span class="glyphicon form-control-feedback" aria-hidden="true"></span> <span id="buqueStatus" class="sr-only">(success)</span> </div>
          <button class="btn btn-primary" name="submit" id="submit" value="Enviar">Enviar</button>
        </fieldset>
      </form>
    </div>

  </div>
</div>
<script>
 $('#buqueNuevo').validator({
	  feedback: {
		  success: 'glyphicon glyphicon-ok',
		  error: 'glyphicon glyphicon-remove'
	  }
  });
</script>
<?php
if(isset($_POST['submit'])){ ?>
<script>
BootstrapDialog.show({
	type: 'type-success',
	size: 'size-small',
	title: 'Nuevo Buque',
	message: 'Registro efectuado!'
});
</script>
<?php } ?>
<?php $cache->cerrar(); ?>
</body>
</html>