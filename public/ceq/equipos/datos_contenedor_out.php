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

if(isset($_POST)){
	unset($_POST['submit']);
	extract($_POST);
	$sql = sprintf("UPDATE inventario SET status_d = %d, condicion = %d, obs = '%s', fdespims = '%s', eir_d = %d, buqued = %d, viajed = '%s' WHERE id = %d;",$estatus,$condicion,$obs,$fdespims,$eir_d,$buque_d,$viajed,$id);
	$actualiza = new DBMySQL();
	$actualiza->Datosconexion(UDB,PDB,USERDB);
	$actualiza->Insertar($sql);
	
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title></title>
<meta http-equiv="refresh" content="3,url=../inicio.php"> 
<link href="../css/estilo.css" rel="stylesheet" type="text/css">
</head>

<body>
<pre>
<?php if($actualiza->Afectados > 0){ ?>
<h1>Registro modificado</h1>
<p>Espere un momento sera redireccionado</p>
<?php } ?>
</pre>
</body>
</html>