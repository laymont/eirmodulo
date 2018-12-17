<?php
#Clase acopio
#29MARFRET, después de 21 días 12 y 18 $ por 20’ y 40’ respectivamente.
#16HAPAG LLOYD, después de 21 días 12 y 18 $ por 20’ y 40’ respectivamente.
#20MAERSK, después de 30 días 12 y 18 $ por 20’ y 40’ respectivamente.
#3CMA CGM, después de 90 días 2 y 4 $ por 20’ y 40’ respectivamente.

class Acopio {
	
	public $Tarifa;
	public $Linea;
	public $DiasAcopio;
	public $Cobra;
	public $Dolar = 11;
	
	public function DefineLinea($id){
		$this->Linea = $id;
		$this->Tarifas();
	}
	
	public function Tarifas(){
		#Tarifas
		switch($this->Linea){
			case 29:
			$this->Tarifa = array(2=>12,4=>18);
			break;
			case 16:
			$this->Tarifa = array(2=>12,4=>18);
			break;
			case 20:
			$this->Tarifa = array(2=>12,4=>18);
			break;
			case 3:
			$this->Tarifa = array(2=>2,4=>4);
			break;
		}
		return $this->Tarifa;	
	}
	
	public function DimeDias($resta){
		if($resta <= 0){
			$this->DiasAcopio = 0;
		}else {
			$this->DiasAcopio = $resta;
		}
		return $this->DiasAcopio;
	}
	
	public function aCobrar($tipoContenedor){
		if($this->DiasAcopio > 0){
			$this->Cobra = $this->Tarifa[$tipoContenedor[0]] * $this->Dolar;
		}else {
			$this->Cobra = NULL;
		}
		return $this->Cobra;
	}
}
?>