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

if(isset($_GET['id'])){
	$id = $_GET['id'];
	$datos = new DBMySQL();
	$datos->Datosconexion(UDB,PDB,USERDB);
	$sql = sprintf("SELECT inventario.id, UPPER(inventario.contenedor) as contenedor, tequipos.tipo, inventario.frd, inventario.eir_r, inventario.`status`, inventario.condicion FROM inventario, tequipos WHERE inventario.id = %d and inventario.tcont = tequipos.id;",$id);
	$datos->Consulta($sql);
	$contenedor = $datos->Filas['contenedor'];
}

#Eliminar
if(isset($_POST['id'])){
	$eliminar = new DBMySQL();
	$eliminar->Datosconexion(UDB,PDB,USERDB);
	$sql = sprintf("DELETE FROM inventario WHERE id = %d;",$_POST['id']);
  $eliminar->Insertar($sql);
	//$eliminar->Afectados = 1;
	
  if($eliminar->Afectados > 0){
		header("Location: datos_contenedor_eliminar2.php?id=".$_POST['id']);
	}else {
		die("<h1>Error</h1><p>No se puedo eliminar el registro</p>");
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
<script src="../bootstrap/js/bootstrap.min.js"></script>
<!--Css-->
<link rel="stylesheet" type="text/css" href="../bootstrap/css/bootstrap.min.css">
<script>

</script>
</head>

<body>
<div class="container">
	<div class="row">&nbsp;</div>
  <div class="row">
    <div class="col-sm-6 col-xs-offset-2">
    <div class="panel panel-danger">
        <div class="panel-heading"><h2>Eliminar</h2></div>
        <div class="panel-body">
        	<p>Id: <?php echo $datos->Filas['id']; ?></p>
          <p>Contenedor: <?php echo $contenedor;?></p>
          <p>Tipo: <?php echo $datos->Filas['tipo'];?></p>
          <p>Frd: <?php echo $datos->Filas['frd'];?></p>
          <p>EIR: <?php echo $datos->Filas['eir_r'];?></p>
          <p>Estatus:
        <?php Estatus($datos->Filas['status']);?>
      </p>
      <p>Condición:
        <?php Condiciones($datos->Filas['condicion']);?>
      </p>
      <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" name="eliminaContenedor" id="eliminaContenedor">
        <p class="text-danger">Se va a proceder a eliminar el contenedor, este procedimiento no es reversible. Confirmar el borrado del registro!
          <input name="id" type="hidden" id="id" form="eliminaContenedor" value="<?php echo $_GET['id']; ?>">
          <!-- cambio $id por $_GET['id']; 14-9-2016 -->
          <input type="hidden" value="<?php echo $contenedor;?>" name="contenedor" id="contenedor">
        </p>
        <p align="center">
        <button class="btn btn-danger" type="submit" name="submit" id="submit" value="Aceptar">Eliminar</button>
        <button class="btn btn-primary" name="cancelar" id="cancelar" value="Cancelar" onClick="window.close();">Cancelar</button>
        </p>
      </form>
        </div>
    </div>
    </div>
  </div>
</div>
</body>
</html>