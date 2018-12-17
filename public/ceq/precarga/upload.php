<?php
ini_set('display_errors', '1');
$tipoXLSX = "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet";
$tipoXLS = "application/vnd.ms-excel";

if(isset($_FILES['userfile'])){
	
	if($_FILES['userfile']['type'] == $tipoXLSX and $_FILES['userfile']['type'] <= 5242880){
		
		//XLSX
		$archivo =  $_FILES['userfile']['name'];			
		$tipo =  $_FILES['userfile']['type'];			
		$tamano = $_FILES['userfile']['size'];			
		$error = $_FILES['userfile']['error'];			
		$nombre_temporal = $_FILES['userfile']['tmp_name'];
		$prefijo = substr(md5(uniqid(rand())),0,3);
		$fecha = $prefijo.date("YmdHis");
		
		if ($archivo != ""){
			// guardamos el archivo a la carpeta files
			$nombre_final = $prefijo.$fecha.$archivo;
			$destino =  "archivos/".$prefijo.$fecha.$archivo;
			
			if (move_uploaded_file($_FILES['userfile']['tmp_name'],$destino)){
				
				header("Location: archivos/datos_ini.php?id=".$nombre_final);
				
			}else{
				die("Error al subir el archivo:-1");
			}
		}else{
			die("Error al subir archivo:-2");
		}
		
	}else if($_FILES['userfile']['type'] == $tipoXLS and $_FILES['userfile']['type'] <= 5242880){
		
		//XLS
		$archivo =  $_FILES['userfile']['name'];			
		$tipo =  $_FILES['userfile']['type'];			
		$tamano = $_FILES['userfile']['size'];			
		$error = $_FILES['userfile']['error'];			
		$nombre_temporal = $_FILES['userfile']['tmp_name'];
		$prefijo = substr(md5(uniqid(rand())),0,3);
		$fecha = $prefijo.date("YmdHis");
		
		if ($archivo != ""){
			// guardamos el archivo a la carpeta files
			$nombre_final = $prefijo.$fecha.$archivo;
			$destino =  "archivos/".$prefijo.$fecha.$archivo;
			if (move_uploaded_file($_FILES['userfile']['tmp_name'],$destino)){
				
				header("Location: archivos/datos_ini.php?id=".$nombre_final);
				
			}else{
				die("Error al subir el archivo:-3");
			}
		}else{
			die("Error al subir archivo:-4");
		}
	}
}
?>