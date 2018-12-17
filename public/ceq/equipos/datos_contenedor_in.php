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
	$idContenedor = $_POST['id'];
	$arrayPost = $_POST;
	extract($arrayPost,EXTR_PREFIX_SAME,"wddx");
	$sql = sprintf("UPDATE inventario SET viaje = %d, tcont = %d,fdb = '%s',fdm = '%s',frd = '%s',eir_r = %d,fact = %d,pase = %d,`status` = %d,condicion = %d,precinto = '%s',bl = '%s',patio = %d,`consignatario` = %d,obs = '%s' WHERE id = %d;",$viaje,$tcont,$fdb,$fdm,$frd,$eir_r,$fact,$paset,$status,$condicion,$precinto,$bl,$patio,$consignatario,$obs,$idContenedor);
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
<link href="../css/estilo.css" rel="stylesheet" type="text/css">
<meta http-equiv="refresh" content="3,url=../inicio.php"> 
</head>

<body>
<pre>
<?php
if($actualiza->Afectados > 0) { echo "<h1>Registro modificado</h1><p>Espere un momento sera redireccionado</p>"; }else { echo "No se realizo ninguna modificacion"; }
?>
</pre>
</body>
</html>