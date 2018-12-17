<?php
#Objeto a string
class aCadena{
	public $objeto;
	
	public function __toString(){
		echo $this->objeto;
    }
	
	public function aCadena($str){
		$this->objeto = $str;
		$this->__toString();
	}
}
?>