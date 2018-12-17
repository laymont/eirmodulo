<?php 
require_once("../config.php");

class POODB {
	/* Consulta para Coneción y Manipulación de Datos MySQL 2016-07-04 */
	public $DATABASE;
	public $CONEXION;
	public $CONSULTA;
	public $RESULTADOS;
	public $FILAS;
	public $ULT_ID;
	public $AFECTADOS;
	public $TOTALRESULT;
	
	static $INSTANCIA;
	
	public function __CONSTRUCT(){
		$conn = new MySQLi('localhost',UDB,PDB);
		if($conn->connect_errno){
			echo "<h3>Error</h3>";
			echo "Error: Fallo al conectarse a MySQL debido a: <br>";
			echo "Errno: " . $conn->connect_errno . "<br>";
			echo "Error: " . $conn->connect_error . "<br>";
		}else {
			$conn->set_charset('utf8');
			/* deshabilitar autocommit */
			$conn->autocommit(FALSE);
			$this->CONEXION = $conn;
		}
	}
		
	public function SELECTDB($strdb){
		/* Seleccionar Base de datos */
		if(!$this->CONEXION->select_db($strdb)){
			echo "<h3>ERROR</h3><p>No se pudo seleccionar la Db</p>";
		}else {
			$this->DATABASE = $strdb;
		}
	}
	
	public function ERRORS(){
		return $this->CONEXION->error;
	}
	
	public function CONSULTAR($SQLstr){
		/* $SQLstr = consulta SQL. $array = Parametros de la consulta */
		$this->CONSULTA = $this->CONEXION->query($SQLstr);
		if(!$this->CONEXION->connect_errno){
			$this->TOTALRESULT = $this->CONSULTA->num_rows;
		}else {
			die('Error: ' . $this->CONEXION->connect_error);
		}
	}
	
	public function INSERTAR($SQLstr){
		/* Insertar registro */
		$this->CONSULTA = $this->CONEXION->query($SQLstr);
		/* insertar commit */
		$this->CONSULTA->commit();
		if(!$this->CONEXION->connect_errno){
			$this->AFECTADOS = $this->CONEXION->affected_rows;				
		}else {
			die('Error: ' . $this->CONEXION->connect_error);
		}
	}
	
	public function ACTUALIZAR($SQLstr){
		/* Consulta para actualizar registros o editar registros*/
		$this->CONSULTA = $this->CONEXION->query($SQLstr);
		if(!$this->CONEXION->connect_errno){
			$this->AFECTADOS = $this->CONEXION->affected_rows;
		}else {
			die('Error: ' . $this->CONEXION->connect_error);
		}
	}
	
	public function BORRAR($SQLstr){
		/* Borrar registro */
		$this->CONSULTA = $this->CONEXION->query($SQLstr);
		if(!$this->CONEXION->connect_errno){
			$this->AFECTADOS = $this->CONEXION->affected_rows;
		}else {
			die('Error: ' . $this->CONEXION->connect_error);
		}
	}
	
	public function RESULTADOS(){
		/* Resultados de la consulta */
		$this->RESULTADOS = $this->CONSULTA->fetch_assoc();
	}
	
	public function MULTICONSULTA($SQLstr){
		/* Multi consulta */
		$conn = $this->CONEXION;
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
		$this->RESULTADOS = $resultados;
		$this->TOROLLBACK = $conn;
	}
	
	public function ULTIMOID(){
		/* Mostrar ID del ultimo registro */
		$id = $this->CONEXION;
		$this->ULT_ID = $id->insert_id;
	}
	
	public function INFO(){
		/* Devuelve la informacion relativa a la ultima consulta */
		return $this->CONEXION->info; 		
	}
	
	public function LISTAERRORS(){
		return $this->CONEXION->error_list;
	}
	
	public function LIBERAR(){
		/* Liberar Memoria*/
		$this->CONSULTA->free();
	}
	
	public function CERRAR(){
		/* Cerrar conecion */
		mysqli_close($this->CONEXION);
	}
}
?>