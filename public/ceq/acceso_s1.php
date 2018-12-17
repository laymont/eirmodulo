<?php
session_start();

if(isset($_POST)){
		$usuario = $_POST['usuario'];
		$clave = $_POST['clave'];

		$accesar = new Usuarios();
		$accesar->AccesoUsuario($usuario,$clave);
	}

if( isset($_POST['g-recaptcha-response']) && $_POST['g-recaptcha-response'] != 0 && $_SERVER['SERVER_NAME'] != 'localhost' ){
	require('clases/class_Usuarios.php');
	if(isset($_POST)){
		$usuario = $_POST['usuario'];
		$clave = $_POST['clave'];

		$accesar = new Usuarios();
		$accesar->AccesoUsuario($usuario,$clave);
	}

}else  if( $_SERVER['SERVER_NAME'] == 'localhost'){
	require('clases/class_Usuarios.php');
	if(isset($_POST)){
		$usuario = $_POST['usuario'];
		$clave = $_POST['clave'];

		$accesar = new Usuarios();
		$accesar->AccesoUsuario($usuario,$clave);
	}
}else {
	header("Location: acceso.php?error=captcha");
}

?>