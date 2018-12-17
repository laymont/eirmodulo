<?php 
session_start();
session_name($_SESSION['variables']['usuario']);
require_once('../config.php');
require_once('../clases/class_Conexion.php');
#Seguridad
$seguridad = new Seguridad();
$seguridad->ValidarUsuario();


$viewUser = new DBMySQL();
$viewUser->Datosconexion('appstc','nVgXi3HT40','appstc_ayaguna_mastertable');
$strSQL = sprintf("SELECT * FROM usuarios WHERE habilitado = 0 AND id = %d",$_SESSION['variables']['id']);
$viewUser->Consulta($strSQL);

if( isset( $_POST['pswd'] ) ){
	$clave = md5( $_POST['pswd'] );
	$nuevaClave = new DBMySQL();
	$nuevaClave->Datosconexion('appstc','nVgXi3HT40','appstc_ayaguna_mastertable');
	$strNC = sprintf("UPDATE usuarios SET clave = '%s' WHERE id = %d;",$clave, $viewUser->Filas['id']);
	$nuevaClave->Insertar($strNC);
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
<!--Estilos-->
<link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="../bootstrap/css/styleBootstrap.css">
<!--Script-->
<script src="../js/jquery-1.11.3.js"></script>
<script src="../bootstrap/js/bootstrap.min.js"></script>
<script src="../bootstrap/js/jquery.bootstrap-autohidingnavbar.min.js"></script>
<style>
.top-buffer-50 {
	margin-top: 50px;
}
</style>

<script>
$(function(){	
	$('[data-toggle="tooltip"]').tooltip();
});

</script>

</head>

<body>
<div class="container">
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
  <div class="row top-buffer-50">
    <div class="col-sm-10">
      <h3>Datos del Usuario</h3>
      <table class="table table-bordered table-condensed table-hover sortable bootstrap-table" data-toggle="table" data-locale="es-SP">
        <thead>
          <tr>
            <th>Accion</th>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Email</th>
            <th>Telefono</th>
            <th>Usuario</th>
            <th>Clave</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="text-center"><a title="Cambiar Clave" class=" btn btn-primary glyphicon glyphicon-edit" href="<?php echo $_SERVER['PHP_SELF']."?pswd=true" ?>"  data-toggle="tooltip" data-placement="bottom"></a></td>
            <td><?php echo $viewUser->Filas['nombre']; ?></td>
            <td><?php echo $viewUser->Filas['apellido']; ?></td>
            <td><?php echo $viewUser->Filas['email']; ?></td>
            <td><?php echo $viewUser->Filas['telefono']; ?></td>
            <td><?php echo $viewUser->Filas['usuario']; ?></td>
            <td>*********</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
  <?php if(isset($_GET['pswd'])) { if($_GET['pswd'] == true) { ?>
  <div class="row">
    <div class="col-sm-6">
      <form action="<?php echo $_SERVER['PHP_SELF']; ?>" role="form" method="post">
        <div class="form-group">
          <label for="clave" class="control-label">Nueva Clave</label>
          <input name="pswd" type="password" required class="form-control" id="pswd" pattern="/^([\w]{8,12})$/" autocomplete="off">    
        </div>
        <button type="submit" class="btn btn-primary" id="submit">Actualizar</button>
        <a class="btn btn-warning" href="<?php echo $_SERVER['PHP_SELF']; ?>">Cancelar</a>
      </form>
    </div>
  </div>
  <?php } } ?>
</div>
</body>
</html>