<?php
class Seguridad {
	private $Valido;
	
	function __construct(){
		if(isset($_SESSION['variables']['valido']) && $_SESSION['variables']['valido'] == true){
			$this->Valido = true;
		}
		
		#Para Vinculos
		$servidor = $_SERVER['HTTP_HOST'];
		$nombreArchivo = $_SERVER['SCRIPT_NAME'];
		$srt = explode('/',$nombreArchivo);
		$dir = '/'.$srt[1].'/';
		return $dir;
	}
	
	public function ValidarUsuario(){
		if(isset($_SESSION['variables']['valido']) && $_SESSION['variables']['valido'] == true){
			return true;
		}else {
			if($this->Valido != true){
				echo "NO";
			}
			header('Location: acceso.php');
			die();
		}
	}
}
?>