<?php
session_start();
session_name($_SESSION['variables']['usuario']);
require_once('../config.php');
require_once('../clases/class_Conexion.php');
require_once('../funciones/funciones.php');
#Seguridad
$seguridad = new Seguridad();
$seguridad->ValidarUsuario();

$consignatarios = new DBMySQL();
$consignatarios->Datosconexion(UDB,PDB,USERDB);
$sql = "SELECT id, nombre FROM consignatario WHERE nombre REGEXP '[[:alnum:]_[:digit:]]{1,50}' ORDER BY nombre;";
$consignatarios->Consulta($sql);

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title><?php echo VERSION; ?></title>
<script src="../js/jquery-1.11.1.js"></script>
<script src="../js/jquery-ui.min.js"></script>
<script src="../bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript">
<!-- Buscar consignatario -->
$(function(){
  $("#strcon, #consignatario").autocomplete({
	  minLength : 4,
	  source: "../autocompletar/autocompletar_consignatarios2.php",
	  select: function( event, ui ) {  
         $("#strcon").val( ui.item.label );
         $("#consignatario").val( ui.item.value );
         return false;
       }
  });
});
$(document).ready(function(e) {
	$("#equipo").keypress(function() {
		
		$('#equipo').css('text-transform','uppercase');
		
        $("#equipo").autocomplete({
			minLength: 4,
			source: "../autocompletar/equipo.php",
			select: function(event, ui){
				$('#equipo').val(ui.item.label);
			}
		});
    });
});

$(document).ready(function(){
	$('[data-toggle="tooltip"]').tooltip();
	
	$("nav.navbar-fixed-top").autoHidingNavbar();
	
});
</script>
<link rel="stylesheet" type="text/css" href="../bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="../bootstrap/css/bootstrap-responsive.min.css">
<link rel="stylesheet" type="text/css" href="../js/jquery-ui.css">
</head>

<body>
<div class="container">
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
    
    <div class="row">
    <div class="col-sm-6">
    <h3>Asignacion</h3>
    <form action="asignacion2.php" method="post" name="formAsig" class="form-horizontal" id="formAsigOUT" role="form">
    	<div class="row">
            <div class="col-sm-4">
            <div class="form-group">
            <label class="control-label" for="fecha">Fecha:</label>
            <input class="form-control" name="fecha" type="date" id="fecha" form="formAsigOUT" value="<?php echo AHORAC; ?>" max="<?php echo AHORAC; ?>">
            </div>
            </div>
            <div class="col-sm-4">
            <div class="form-group">
            <label class="control-label" for="booking">Booking:</label>
            <input name="booking" type="text" required class="form-control" id="booking" form="formAsigOUT">
            </div>
            </div>
            <div class="col-sm-4">
            <div class="form-group">
            <label class="control-label" for="eir">EIR:</label>
            <input class="form-control" name="eir" type="number" required id="eir" form="formAsigOUT">
            </div>
            </div>
        </div>
        <div class="row">
        <div class="col-sm-8">
            <div class="form-group">
            <label class="control-label" for="consignatario">Consignatario:</label>
            <input class="form-control" name="strcon" type="text" id="strcon" form="formAsigOUT" data-toggle="tooltip" data-placement="auto" title="<?php echo MSJCONSIG; ?>" required>
            <input name="consignatario" type="hidden" id="consignatario" value="-1">            
            </div>
            </div>
            <div class="col-sm-4">
            <div class="form-group">
            <label class="control-label" for="equipo">Contenedor:</label>
            <input class="form-control" name="equipo" type="text" required id="equipo" form="formAsigOUT" pattern="^([a-zA-Z]{3})([ujz|UJZ]{1})([0-9]{7})$">
            </div>
        </div>
        
        </div>
        
        <button name="submit" id="submit" type="submit" form="formAsigOUT" class="btn btn-primary" value="Enviar">Enviar</button>
        
</form>
    </div>
    </div>
</div>
<?php $cache->cerrar(); ?>
</body>
</html>