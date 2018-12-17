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

#Usuario
$usuarios = new DBsPOO();
$usuarios->Conectar('appstc','5G4eSBA~AEJ7');
$usuarios->SelectDB('appstc_ayaguna_mastertable');
$SQLstr = sprintf("SELECT id, nombre, apellido, usuario FROM usuarios WHERE usuarios.datos = %d and nivel < 6 and usuarios.habilitado = 0;",$_SESSION['variables']['datos']);
$usuarios->Consultar($SQLstr);

$registrado = false;

if(isset($_POST['usuario'])){
	$USUARIOID = $_POST['usuario'];
	$card = new Coordenadas();
	$card->Tarjetas();

	$tarjetaNumero = $card->NumTar();
	#Verificar anterior
	$unreg = new DBsPOO();
	$unreg->Conectar('appstc','5G4eSBA~AEJ7');
	$unreg->SelectDB('appstc_ayaguna_mastertable');
	$SQLstr = sprintf("SELECT * FROM coordenadas WHERE usuario = %d",$USUARIOID);
	$unreg->Consultar($SQLstr);
	if($unreg->TotalResultados > 0){
		$unreg->Liberar();
		$SQLstr = sprintf("UPDATE coordenadas SET activa = 'N' WHERE usuario = %d;",$USUARIOID);
		$unreg->Registrar($SQLstr);
	}

	#Registrar nueva tarjeta de accesos
	$registrar = new DBsPOO();
	$registrar->Conectar('appstc','5G4eSBA~AEJ7');
	$registrar->SelectDB('appstc_ayaguna_mastertable');
	$SQLstr = sprintf("INSERT INTO coordenadas(id,datos,usuario,filas,activa) VALUES(%d,%d,%d,'%s','Y');",
										$tarjetaNumero,
										$_SESSION['variables']['datos'],
										$USUARIOID,
										$card->StrDB);

	$registrar->Registrar($SQLstr);
	$registrar->Afectados();
	if($registrar->Afectados > 0){
		$registrado = true;
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

	$('#usuario').change(function() {
		$('#uname').val( $('#usuario option:selected').text() );
  });

	<!--Impedir F5-->
 function disableF5(e) { if ((e.which || e.keyCode) == 116 || (e.which || e.keyCode) == 82) e.preventDefault(); };
 $(document).ready(function(){
	 $(document).on("keydown", disableF5);
 });
 <!--Impedir F5-->

 $('#usuario').change(function(){
	 var $usuario = $('#usuario').val();
	 $.post("cardpass_exist.php", { usuario : $usuario }, function(respuesta){
		 if(respuesta == 1){
			 BootstrapDialog.show({
			 type: 'type-danger',
			 size: 'size-small',
			 title: 'Advertencia',
			 message: 'El usuario ya posee una tarjeta de coordenadas asignada.'
		 });
		 }
	 });
 });

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
  	<div class="col-sm-6 hidden-print">
    	<!--Seleccion de Usuario-->
      <form name="listuser" id="listuser" action="<?php $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data" role="form" class="form-inline">
      	<div class="form-group">
        	<label for="almacen">Almacen</label>
          <p class="form-control-static"><?php echo $_SESSION['variables']['nomdb'] ?></p>
        </div>
        <div class="form-group">
        	<label for="Usuario" class="control-label">Usuario</label>
          <select class="form-control" name="usuario" id="usuario">
          	<option value="-1">Seleccione</option>
            <?php while($usuarios->Resultados()){ ?>
            <option value="<?php echo $usuarios->Resultados['id']; ?>"><?php echo $usuarios->Resultados['nombre']." ".$usuarios->Resultados['apellido']; ?></option>
            <?php } ?>
          </select>
        </div>
        <input type="hidden" name="uname" id="uname">
        <button class="btn btn-default" type="submit" value="1"> Crear </button>
      </form>
      <br>
      <p class="alert alert-warning"><small class="text-warning">Si el usuario ya tiene una tarjeta asignada y se crea otra la anterior quedara deshabilitada.</small></p>
    </div>
  </div>
  <hr class="divider hidden-print">
  <?php if(isset($card)){ ?>
  <div class="row">
    <div class="col-xs-6 container">
      <table class="table table-condensed table-bordered table-striped table-responsive">
      <caption>Tarjeta de Coordenadas <?php echo '#'.$tarjetaNumero; ?></caption>
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
        <?php for($f=0;$f<=count($card->Tarjeta)-1;$f++){  ?>
        <tr>
          <th class="text-center"><?php echo $card->Filas(); ?></th>
          <td class="text-center"><?php echo $card->Tarjeta[$f][0];  ?></td>
          <td class="text-center"><?php echo $card->Tarjeta[$f][1]; ?></td>
          <td class="text-center"><?php echo $card->Tarjeta[$f][2]; ?></td>
          <td class="text-center"><?php echo $card->Tarjeta[$f][3]; ?></td>
          <td class="text-center"><?php echo $card->Tarjeta[$f][4]; ?></td>
          <td class="text-center"><?php echo $card->Tarjeta[$f][5]; ?></td>
          <td class="text-center"><?php echo $card->Tarjeta[$f][6]; ?></td>
        </tr>
        <?php }  ?>
        <tr>
        <td colspan="8"><small><?php echo $_SESSION['variables']['nomdb']." - ".$_POST['uname']; ?></small></td>
        </tr>
      </table>
      <h4 class="alert alert-success">Tarjeta de Coordenadas Creada y Registrada</h4>
      <h4 class="alert alert-danger hidden-print">No actualice la página</h4>
      <script>
       $(window).bind('beforeunload', function(e) {
    return "Unloading this page may lose data. What do you want to do..."
    e.preventDefault();
});
      </script>
    </div>
  </div>
  <?php } ?>
</div>
<?php if(isset($card)){
//var_dump($card->StrDB);
}
//var_dump($_SESSION['variables']);
?>
</body>
</html>