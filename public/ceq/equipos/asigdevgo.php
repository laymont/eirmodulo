<?php
session_start();
session_name($_SESSION['variables']['usuario']);
require_once('../config.php');
require_once('../clases/class_DbPoo.php');
require_once('../funciones/funciones.php');

#Seguridad
$seguridad = new Seguridad();
$seguridad->ValidarUsuario();

// echo "<pre>";
// var_dump($_POST);
// echo $_POST['obs'] . ' |Reintegro: ' . $_POST['razon'];
// echo "</pre>";
// die();
if(isset($_POST['id'])){
	$id = $_POST['id']; //Id del contenedor
	$razon = $_POST['obs'] . ' |Reintegro: ' . $_POST['razon'];
	$devAsig = new DBsPOO();
	$devAsig->Conectar(UDB,PDB);
	$devAsig->SelectDB(USERDB);
	$SQLstr = sprintf("DELETE FROM asignaciones WHERE equinv = %d", $id);
	if($devAsig->Registrar($SQLstr)){
		//$devAsig->Liberar();
		$SQLstr = sprintf("UPDATE inventario SET fdespims = NULL, eir_d = NULL, obs = '%s' , c = 0 WHERE id = %d",$razon,$id);
		if($devAsig->Registrar($SQLstr)){
			header("Location: asigdev.php?dev=true");
		}

	}else {
		echo "Aqui->".$SQLstr;
	}

}
?>