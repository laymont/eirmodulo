<?php
#Clase para conectar a MySQL orientada a Objetos

class DBMySQL {
	private $Host = 'localhost';
	private $Usuario;
	private $Clave;
	public $Basedatos;
	public $Conexion;
	public $Consulta;
	public $Num_resultados;
	public $Filas = array();
	public $Afectados;
	public $Eliminar;
	public $IdMysql;

  public $Error;

  public function Datosconexion($user,$pass,$db){
      $this->Usuario = $user;
      $this->Clave = $pass;
      $this->Basedatos = $db;
  }

  private function Conectar(){
      date_default_timezone_set('America/Caracas');
      $this->Conexion = mysqli_connect($this->Host,$this->Usuario,$this->Clave,$this->Basedatos);
      if(mysqli_connect_errno()){
        echo "<pre>";
        var_dump($this->Conexion);
        echo "</pre>";
         die('Error de conexion a la base de datos');
     }else {
         mysqli_set_charset($this->Conexion, "utf8");
     }
     return $this->Conexion;
 }

 public function Consulta($sql){
    try {
        self::Conectar();
        $this->Consulta = mysqli_query($this->Conexion,$sql);
        $this->Num_resultados = mysqli_num_rows($this->Consulta);
        $this->Filas = mysqli_fetch_assoc($this->Consulta);
        return $this->Filas;

    }catch (Exception $e){
        echo "Error Fatal - ".$e->getMessage();
    }
}

public function Errors(){
    $this->Error = $this->Conexion->error;
}

public function ConsultaObj($sql){
  self::Conectar();
  $this->Consulta = mysqli_query($this->Conexion,$sql);
  $this->Num_resultados = mysqli_num_rows($this->Consulta);
  $this->Filas = mysqli_fetch_object($this->Consulta);
}

public function Insertar($sql){
  if(isset($this->Conexion)){
     mysqli_real_escape_string($this->Conexion,$sql);
     $this->Consulta = mysqli_query($this->Conexion,$sql);
     $this->Afectados = mysqli_affected_rows($this->Conexion);
     if($this->Afectados == 0){
        die('ErrorClass1: No se pudo ejecutar la consulta. ' .mysqli_errno($this->Conexion));
    }else {
        $this->IdMysql = mysqli_insert_id($this->Conexion);
    }
}else {
 self::Conectar();
 mysqli_real_escape_string($this->Conexion,$sql);
 $this->Consulta = mysqli_query($this->Conexion,$sql);
 $this->Afectados = mysqli_affected_rows($this->Conexion);
 if($this->Afectados == 0){
    die('ErrorClass2: No se pudo ejecutar la consulta. ' .mysqli_errno($this->Conexion));
}else {
    $this->IdMysql = mysqli_insert_id($this->Conexion);
}
}
return $this->IdMysql;
}

public function Elimina($sql){
  if(isset($this->Conexion)){
     mysqli_real_escape_string($this->Conexion,$sql);
     $this->Eliminar = mysqli_query($this->Conexion,$sql);
     $this->Afectados = mysqli_affected_rows($this->Conexion);
     if($this->Afectados == 0){
        die('ErrorClass2: No se pudo ejecutar la consulta. ' .mysqli_errno($this->Conexion));
    }

}
}

public function Vaciar($tabla){
  $sql = sprintf("TRUNCATE %s;",$tabla);

  if(isset($this->Conexion)){
     $this->Consulta = mysqli_query($this->Conexion,$sql);
     if($this->Consulta != true){
        die("ErrorClass1: No se pudo ejecutar la consulta. " .mysqli_errno($this->Conexion));
    }
}else {
 self::Conectar();
 $this->Consulta = mysqli_query($this->Conexion,$sql);
 if($this->Consulta != true){
    die("ErrorClass2: No se pudo ejecutar la consulta. " .mysqli_errno($this->Conexion));
}
}
}

public function Procedimiento($procedimiento){
  if(isset($this->Conexion)){

     $this->Consulta = mysqli_real_query($this->Conexion,$procedimiento);
 }else if(!isset($this->Conexion)){

     self::Conectar();
     $this->Consulta = mysqli_real_query($this->Conexion,$procedimiento);
     if($this->Consulta != true){
        die("ErrorClass3: No se pudo ejecutar la consulta. " .mysqli_errno($this->Conexion));
    }
}else {
 die("ErrorClass2: No se pudo ejecutar la consulta. " .mysqli_errno($this->Conexion));
}
}

public function Ping(){
  if( mysqli_ping($this->Conexion) ){
     printf ("¡La conexión está bien!\n");
 }else {
     printf ("Conexión cerrada");
 }
}

public function Liberar(){
  mysqli_free_result($this->Consulta);
}

public function Cerrar(){
  mysqli_close($this->Conexion);
}

}
?>