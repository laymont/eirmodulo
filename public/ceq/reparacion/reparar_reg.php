<?php
session_start();
session_name($_SESSION['variables']['usuario']);
require_once('../config.php');
require_once('../clases/class_Conexion.php');

if(isset($_POST['incluir']) and $_POST['incluir'] == 1){
	#Carga de Imagene
	$ruta = "imgs/";
	$max = 1000000;
	$tipo = "image/jpeg";
	$nombres = array();
	$registros = array();
	
	if(isset($_POST['id']) and !empty($_FILES['img']['name'][0])){
		if(count($_FILES['img']['name']) > 5){
			die("<h1>Error</h1><p>Solo esta permitido cargar cinco (5) imagenes</p>");
		}
		#Si se recibieron los datos
		//Validar el tamaño
		for($i=0;$i<=count($_FILES['img']['name'])-1;$i++){
			if($_FILES['img']['size'][$i] > $max){
				die("<h1>Error</h1><p>El o los archivos exceden el limite del tamaño (1MB). <a href='index.php'>Regresar</a></p>");
			}else {
				//Si no excede el tamaño
				if($_FILES['img']['type'][$i] != $tipo){
					//Si no es JPG
					die("<h1>Error</h1><p>Solo se permiten archivos JPEG/JPG. <a href='index.php'>Regresar</a></p>");
				}else {
					$prefijo = $_POST['id'];
					$num = mt_rand(000000,999999);
					$fin = $i;
					array_push($nombres,$prefijo.$num.$fin);
					$extension = substr($_FILES['img']['name'][$i],-4);
					
					$subida = move_uploaded_file($_FILES['img']['tmp_name'][$i],$ruta.$nombres[$i].$extension);
					if(!$subida){
						die("<h1>Error</h1>");
					}
					array_push($registros,$nombres[$i].$extension);
				}
			}
		}
		$registrar = new DBMySQL();  //new DBs;
		$registrar->Datosconexion(UDB,PDB,USERDB);
		
		for($i=0;$i<=count($registros)-1;$i++){
			$sql = sprintf("INSERT INTO imagephp(idcontenedor,nombrefoto) VALUES(%d,'%s');",$_POST['id'],$registros[$i]);
			$registrar->Insertar($sql);
		}
	}else {
		#Si se no recibieron los datos
		die("<h1>Error</h1><p>No se recibieron los datos del formulario (Imagenes). <a href='reparar.php'>Regresar</a></p>");
	}
	#Carga de Imagenes
}

if(isset($_POST)){
	$id = $_POST['id'];
	$idcontenedor = $id;
	$condicion = $_POST['condicion'];
	$obs = $_POST['obs'];
	$frep = $_POST['frep'];
	$accion = "Reparado: ".$_POST['accion']; //Descripcion de la accion para actualizar inventario
	$accion2 = $_POST['accion2']; //Condicion final para actualizar inventario
	$monto = $_POST['monto']; 
	
	//Registro en la tabla reparaciones
	$reparar = new DBMySQL();
	$reparar->Datosconexion(UDB,PDB,USERDB);
	$qtxt = sprintf("INSERT INTO reparaciones(idcontenedor,fecha,condicion,antobs,monto,auditoria) VALUES(%d,'%s',%d,'%s',%d,%d)",$id,$frep,$accion2,$obs,$monto,IDUSER);
	$reparar->Insertar($qtxt);
	
	//Actualizacion en la tabla inventario
	$actualiza = new DBMySQL();
	$actualiza->Datosconexion(UDB,PDB,USERDB);
	$q2txt = sprintf("UPDATE inventario SET condicion = %d, rep_dano = %d, obs = '%s' WHERE id = %d",$accion2,$ultid,$accion,$id);
	$actualiza->Insertar($q2txt);
	if($actualiza->Afectados > 0){
		header("Location: reparar.php");
	}else {
		die("<h1>Error</h1><p>No se pudo actualizar el Registro</p>");
	}
}

?>