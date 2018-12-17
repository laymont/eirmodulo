<?php
session_start();
session_name($_SESSION['variables']['usuario']);
require('config.php');
require('clases/class_Usuarios.php');

if(isset($_GET['salir']) and $_GET['salir'] == true){
	$salir = new Usuarios();
	$salir->SalirUsuario();
}
?>