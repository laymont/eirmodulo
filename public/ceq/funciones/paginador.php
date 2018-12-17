<?php
function Paginador($strSql){
	if(!class_exists('DBMySQL')){
		require_once('../clases/class_Conexion.php');
	}else {
		$tamanoPagina = 50;
		$paginar = new DBMySQL();
		$paginar->Datosconexion(UDB,PDB,USERDB);
		$paginar->Consulta($strSql);
		$totalRegistros = $paginar->Num_resultados;
		
		$paginas = ceil($totalRegistros,$tamanoPagina);
	}
}
?>