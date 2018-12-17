<?php
session_start();
session_name($_SESSION['variables']['usuario']);
require_once('../config.php');
require_once('../clases/class_Conexion.php');
require_once('../funciones/funciones.php');
#Seguridad
$seguridad = new Seguridad();
$seguridad->ValidarUsuario();

#Asignacion
if(isset($_POST)){
    $contenedor = $_POST['equipo'];
	$verExist = new DBMySQL();
	$verExist->Datosconexion(UDB,PDB,USERDB);
	$sql = sprintf("SELECT * FROM inventario WHERE c = 0 AND contenedor = '%s';",$contenedor);
	$verExist->Consulta($sql);
	
	if(isset($_POST['consignatario']) and $_POST['consignatario'] == -1 and !isset($NewConsig)){
		#El consignatario no existe
		$NewConsig = new DBMySQL();
		$NewConsig->Datosconexion(UDB,PDB,USERDB);
		$sql = sprintf("INSERT INTO `consignatario`(rif,nombre) VALUES('J-00000000-0','%s');",$_POST['strcon']);
		$NewConsig->Insertar($sql);
		$_POST['consignatario'] = $NewConsig->IdMysql;
	}
	
	if($verExist->Num_resultados == 1){
		$id = $verExist->Filas['id'];
		$fecha = $_POST['fecha'];
		$booking = $_POST['booking'];
		$eir = $_POST['eir'];
		$consignatario = $_POST['consignatario'];
		#Registra asignacion
		$asigna = new DBMySQL();
		$asigna->Datosconexion(UDB,PDB,USERDB);
		$sql = sprintf("INSERT INTO asignaciones(equinv,booking,fecha,cliente) VALUES(%d,'%s','%s',%d);",$id,$booking,$fecha,$consignatario);
		$asigna->Insertar($sql);
		$idmysql = $asigna->IdMysql;
		
		#Actualiza inventario
		$actualiza = new DBMySQL();
		$actualiza->Datosconexion(UDB,PDB,USERDB);
		$sql = sprintf("UPDATE inventario SET fdespims = '%s', eir_d = %d, booking = '%s', expo = %d, c = 1 WHERE id = %d;",$fecha,$eir,$booking,$idmysql,$id);
		$actualiza->Insertar($sql);
		
	}else {
		echo "<link href='../css/estiloGeneral.css' rel='stylesheet' type='text/css'>";
		die("<h1>ERROR</h1><p>El contenedor no esta en inventario</p><p><a href='asignacion.php'>Regresar </a></p>");
	}
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title><?php echo VERSION; ?></title>
<meta http-equiv="refresh" content="5; URL=asignacion.php">
<link href="../css/estilo.css" rel="stylesheet" type="text/css">
</head>

<body>
<?php //include('../includes/precargador.html'); ?>
<p><a href="../inicio.php">Regresar </a></p>
<h1>Asignacion</h1>
<hr>
<h2>Registro efectuado</h2>
</body>
</html>