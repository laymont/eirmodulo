<?php
#Clase Equipo
class Contenedor {
	public $Contenedor;
	public $Datos;
	public $Tipo;
	public $Estatus;
	public $Condicion;
	public $Observacion;
	public $Ubicacion;
	
	public $EirI; #EIR de ingreso
	public $EirO; #EIR de salida
	public $BL;
	public $Consignatario; #ID consignatario
	public $Linea;
	public $Buque;
	public $Viaje; #Fecha de viaje
	public $Fdm; #Fecha de despacho (puerto)
	public $Frd; #Fecha de recepcion almacen
	
	public $Pase;
	public $Factura;
	
	public $Resultado; #Resultado de la operacion
	
	
	public function IngresoEquipo($linea,$buque,$viaje,$fdb,$equipo,$tipo,$condicion,$eir,$bl,$factura,$pase,$fdm,$frd,$consig,$ubicacion,$observacion){
		$in = new DBMySQL();
		$in->Datosconexion(UDB,PDB,USERDB);
		$sql = sprintf("INSERT INTO inventario(linea,buque,viaje,fdb,contenedor,tcont,`status`,condicion,eir_r,bl,fact,paset,fdm,frd,consignatario,patio,obs,c)
		 VALUES(%d,%d,%d,'%s','%s',%d,%d,%d,%d,'%s',%d,%d,'%s','%s','%s',%d,'%s',0);",
		$linea,$buque,$viaje,$fdb,$equipo,$tipo,0,$condicion,$eir,$factura,$pase,$fdm,$frd,$consig,$ubicacion,$observacion,0);
		if($in->Insertar($sql)){
			$this->Resultado = true;
		}else {
			$this->Resultado = false;
		}
		
		return $this->Resultado;
	}
	
	public function EditarEquipo($id){

		$equipo = new DBMySQL();
		$equipo->Datosconexion(UDB,PDB,USERDB);
		$sql = sprintf("SELECT inventario.c FROM inventario WHERE inventario.id = %d AND inventario.`delete` = 0;",$id);
		$equipo->Consulta($sql);
		if($equipo->Num_resultados > 0){
			if($equipo->Filas['c'] == 0){
				//En inventario
				$inventario = new DBMySQL();
				$inventario->Datosconexion(UDB,PDB,USERDB);
				$sql = sprintf("SELECT inventario.linea, inventario.buque, inventario.viaje, inventario.tcont, inventario.contenedor, inventario.fdb, inventario.fdm, inventario.frd, inventario.eir_r, inventario.fact, inventario.paset, inventario.`status`, inventario.condicion, inventario.precinto, inventario.bl, inventario.patio, inventario.consignatario, inventario.obs, inventario.c FROM inventario WHERE inventario.id = %d AND inventario.`delete` = 0;",$id);
				$inventario->Consulta($sql);
				$this->Datos = $inventario->Filas;
			}else if($equipo->Filas['c'] == 1){
				$inventario = new DBMySQL();
				$inventario->Datosconexion(UDB,PDB,USERDB);
				$sql = sprintf("SELECT inventario.id, inventario.tcont, inventario.contenedor, inventario.fdb, inventario.fdm, inventario.frd, inventario.eir_r, inventario.`status`, inventario.condicion, inventario.precinto, inventario.bl, inventario.obs, inventario.fdespims, inventario.eir_d, inventario.status_d, inventario.buqued, inventario.viajed, inventario.expo, inventario.booking, inventario.c FROM inventario WHERE inventario.id = %d AND inventario.`delete` = 0;",$id);
				$inventario->Consulta($sql);
				$this->Datos = $inventario->Filas;
			}else {
				//Nada
			}
		}
		return $this->Datos;
	}
	
	public function InhabilitarEquipo($serial){
	}
	
	public function EliminarEquipo($serial){
	}
	
	public function MostrarEquipo($serial){
	}
}
?>