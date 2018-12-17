<?php
#Coordenadas
class Coordenadas {
	public $Filas = 0;
	public $TFC;
	public $Fila;
	public $Tarjeta;
	public $Numero;
	public $StrDB;
	static $TH = array(0=>"V",1=>"A",2=>"L",3=>"I",4=>"D",5=>"E",6=>"N");
	public $TC;

	static private $DBU = 'appstc';
	static private $DBP = '5G4eSBA~AEJ7';
	static private $DB = 'appstc_ayaguna_mastertable';

	public function __construct(){
		for($i=0;$i<=4;$i++){
			$fila[$i] = array(rand(10,99),rand(10,99),rand(10,99),rand(10,99),rand(10,99),rand(10,99),rand(10,99));
		}
		$this->Fila = $fila;
		$this->Numero = time();
	}

	private function Notc(){
		unset($this->Fila);
		unset($this->Numero);
	}

	public function NumTar(){
		return $this->Numero;
	}

	public function DataStr(){
		self::__construct();
		for($i=0;$i<=4;$i++){
			$str[$i]= implode(",",$this->Fila[$i]);
		}
		$this->StrDB = implode(";",$str);
		return $this->StrDB;
	}

	public function Tarjetas(){
		self::DataStr();
		$this->Tarjeta = $this->Fila;
		return $this->Tarjeta;
	}

	public function Filas(){
		return $this->Filas++;
	}

	public function get_Coord(){
		if(class_exists('DBsPOO')){
			$this->Notc();
			$getcoord = new DBsPOO();
			$getcoord->Conectar(self::$DBU,self::$DBP);
			$getcoord->SelectDB(self::$DB);
			$SQLstr = sprintf("SELECT id, filas, activa FROM coordenadas WHERE usuario = %d AND activa = 'Y';",$_SESSION['variables']['id']);
			$getcoord->Consultar($SQLstr);
			$getcoord->Resultados();
			if($getcoord->TotalResultados > 0){
				#Crear Tabla
				if(!isset($_SESSION['tablacoord'])){
					#Crear Tabla con los datos almacenados de la tarjeta de coordenadas
					$filas = explode(";",$getcoord->Resultados['filas']);
					#Seleccion de la fila
					$Sel1 = rand(0,4); #Numero fila 1
					$Sel2 = rand(0,4); #Numero fila 2
					$fila1 = $filas[$Sel1];
					$fila2 = $filas[$Sel2];
					#Seleccionar columna
					$selc1 = rand(0,6);
					$selc2 = rand(0,6);
					$_SESSION['tablacoord']['columna1'] = self::$TH[$selc1].$Sel1;
					$_SESSION['tablacoord']['columna2'] = self::$TH[$selc2].$Sel2;
					#Descomponer las filas
					$celdas1 = explode(",",$fila1);
					$celdas2 = explode(",",$fila2);
					$_SESSION['tablacoord']['celda1'] = $celdas1[$selc1];
					$_SESSION['tablacoord']['celda2'] = $celdas2[$selc2];
					$this->TC = 1;
					return true;
				}
			}else if($getcoord->TotalResultados == 0){
				#No tiene tarjeta de coordenadas
				unset($_SESSION['tablacoord']);
				$this->TC = -1;
				return $this->TC;
			}
		}else {
			require_once('class_DbPoo.php');
			$getcoord = new DBsPOO();
			$getcoord->Conectar(self::$DBU,self::$DBP);
			$getcoord->SelectDB(self::$DB);
			$SQLstr = sprintf("SELECT id, filas, activa FROM coordenadas WHERE usuario = %d AND activa = 'Y';",$_SESSION['variables']['id']);
			$getcoord->Consultar($SQLstr);
			$getcoord->Resultados();
			if($getcoord->TotalResultados > 0){
				#Crear Tabla
				if(!isset($_SESSION['tablacoord'])){
					#Crear Tabla con los datos almacenados de la tarjeta de coordenadas
					$filas = explode(";",$getcoord->Resultados['filas']);
					#Seleccion de la fila
					$Sel1 = rand(0,4); #Numero fila 1
					$Sel2 = rand(0,4); #Numero fila 2
					$fila1 = $filas[$Sel1];
					$fila2 = $filas[$Sel2];
					//$_SESSION['tablacoord']['fila'.$Sel1] = $fila1;
					//$_SESSION['tablacoord']['fila'.$Sel2] = $fila2;
					#Seleccionar columna
					$selc1 = rand(0,6);
					$selc2 = rand(0,6);
					$_SESSION['tablacoord']['columna1'] = self::$TH[$selc1].$Sel1;
					$_SESSION['tablacoord']['columna2'] = self::$TH[$selc2].$Sel2;
					#Descomponer las filas
					$celdas1 = explode(",",$fila1);
					$celdas2 = explode(",",$fila2);
					$_SESSION['tablacoord']['celda1'] = $celdas1[$selc1];
					$_SESSION['tablacoord']['celda2'] = $celdas2[$selc2];
					$this->TC = 1;
					return true;
				}
			}else if($getcoord->TotalResultados == 0){
				#No tiene tarjeta de coordenadas
				$this->TC = -1;
				return $this->TC;
			}
		}
	}


	public function show_Coord(){
		#Si conexion DB esta definida
		if(class_exists('DBsPOO')){
			$shCoord = new DBsPOO();
			$shCoord->Conectar(self::$DBU,self::$DBP);
			$shCoord->SelectDB(self::$DB);
			$SQLstr = sprintf("SELECT id, filas, activa FROM coordenadas WHERE usuario = %d AND activa = 'Y';",$_SESSION['variables']['id']);
			$shCoord->Consultar($SQLstr);
			if($shCoord->TotalResultados > 0){
				$shCoord->Resultados();
				$this->Numero = $shCoord->Resultados['id'];
				$filas = explode(";",$shCoord->Resultados['filas']); #Filas de la tarjeta
				for($f=0;$f<=count($filas)-1;$f++){
					$celdas[$f] = explode(",",$filas[$f]);
				}
				$this->TFC = $celdas;
				return $this->TFC;
			}else if($shCoord->TotalResultados == 0){
				return false;
			}
		}else {
			require_once("class_DbPoo.php");
		}

	}
}

?>