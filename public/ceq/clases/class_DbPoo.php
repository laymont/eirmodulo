<?php
/* CLASE POO DB */
/* Nueva clase de Orientada a Objeto
Desarrollada por Laymont Arratia 04-03-2016 */

class DBsPOO {

	public $Conexion;
	public $Consulta;
	public $Registro;
	public $Columnas;
	public $Resultados;
	public $ResArray;
	public $TotalResultados;
	public $Afectados;
	public $UltID;
	public $TimeExec;
	public $Torollback;

	public function Conectar ($usuario,$clave) {
		$conectar = new mysqli('localhost',$usuario,$clave);
		$conectar->set_charset('utf8');
		if($conectar->error){
			die("Error de conexion (".$conectar->errno .") ".$conectar->error);
		}else {
			$this->Conexion = $conectar;
			return true;
			//Obtener nombre de las DB
		}
	}

	public function Informacion(){
		return $this->Conexion->info;
	}

	public function SelectDB($db){
		$this->Conexion->select_db($db);
		return true;
	}

	public function Consultar($strSQL){
		if(is_object($this->Conexion)){
			$msc = microtime(true);
			$this->Consulta = $this->Conexion->query($strSQL) or die($this->Conexion->error);
			$this->TotalResultados = $this->Consulta->num_rows;
		}
	}

	public function MultiConsulta($strSQL){
		if(is_object($this->Conexion)){
			/* Multi consulta */
			$conn = $this->Conexion;
			$conn->multi_query($SQLstr);
			/* Insertar commit*/
			$conn->commit();
			if(mysqli_more_results($conn)){
				while(mysqli_more_results($conn)){
					$conn->next_result();
					//Resultados de la primera consulta
					$result = $conn->store_result();
					$resultados[] = $result->fetch_all();
				}
			}
			$this->Resultados = $resultados;
			$this->$Torollback = $conn;
			$conn->free();
		}
	}

	public function MultiConsultaUPDATE($strSQL){
		/* ejecutar multi consulta */
		if(!$this->Conexion->multi_query($strSQL)){
			die("Error: (" . $this->Conexion->errno . ") " . $this->Conexion->error);
		}
		$this->Conexion->store_result();
			do{
				/*Accion*/
				$this->Afectados[] = $this->Conexion->affected_rows;
			}while($this->Conexion->more_results() && $this->Conexion->next_result());
	}

	public function TiempoEjecucion(){
		return $this->TimeExec;
	}

	public function Registrar($strSQL){
		if(is_object($this->Conexion)){
			$msc = microtime(true);
			$this->Consulta = $this->Conexion->query($strSQL) or die($this->Conexion->error);
			$this->UltID = $this->Conexion->insert_id;
			$this->Afectados();
			$this->TimeExec = $msc = microtime(true)-$msc;
			return true;
		}
	}

	public function Actualizar($strSQL){
		if(is_object($this->Conexion)){
			$msc = microtime(true);
			$this->Consulta = $this->Conexion->query($strSQL) or die ($this->Conexion->error);
			$this->Afectados();
			$this->TimeExec = $msc = microtime(true)-$msc;
			return true;
		}
	}

	public function Afectados(){
		if(is_object($this->Conexion)){
			$this->Afectados = $this->Conexion->affected_rows;
			return $this->Afectados;
		}
	}

	public function UltimoID(){
		$this->UltID = $this->Conexion->insert_id;
		return $this->UltID;
	}

	public function Campos(){
	$this->Columnas =	$this->Consulta->fetch_fields();
	return $this->Columnas;
	}

	public function Resultados(){
		$this->Resultados = $this->Consulta->fetch_assoc();
		return $this->Resultados;
	}

	public function ResultArray(){
		$this->ResArray = $this->Consulta->fetch_array();
		return $this->ResArray;
	}

	public function Thead(){
		/* Adaptado Bootstrap Table */
		$this->Campos();
		$cabecera = '<thead><tr>';
		foreach($this->Columnas as $campo){
			if($campo->name == 'buque' or $campo->name == 'viaje' or $campo->name == 'tipo' or $campo->name == 'status' or $campo->name == 'condicion'){
				$cabecera .= '<th data-field="'.$campo->name.'" data-sortable="true" data-filter-control="select">'.ucfirst($campo->name).'</th>';
			}else {
				$cabecera .= '<th data-field="'.$campo->name.'" data-sortable="true">'.ucfirst($campo->name).'</th>';
			}
		}
		$cabecera .= '</tr></thead>';
		return $cabecera;
	}

	public function Liberar(){
		if(is_object($this->Consulta)){
			$this->Consulta->free();
		}
	}

	public function Cerrar(){
		$this->Conexion->close();
	}

}
?>