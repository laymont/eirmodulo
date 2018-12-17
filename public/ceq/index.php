<?php
session_start();
require_once('config.php');
require_once('clases/class_Conexion.php');

#Seguridad
$seguridad = new Seguridad();
if(!$seguridad->ValidarUsuario()){
	header('Location: acceso.php');
}else if($seguridad->ValidarUsuario()){
	header('Location: inicio.php');
}
?>