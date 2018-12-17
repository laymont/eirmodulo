<?php
#Clase Usuarios
include('class_Conexion.php');

class Usuarios extends DBMySQL {
	public $Usuario;
	public $Clave;
	public $Nombre;
	public $Correo;
	public $Telefono;
	public $Nivel;
	public $Tipo;
	public $Linea;
	public $Basedatos;

	public static $Dbs;
	public static $Usersdb;
	public static $NDBs;

	function __construct(){
		//Bases de datos
   self::$Dbs = array(
    1 =>"appstc_ayaguna_jmp",
    2 =>"appstc_ayaguna_menfel",
    3 =>"appstc_ayaguna_conslg",
    4 =>"appstc_ayaguna_gonavi",
    5 =>"appstc_ayaguna_multimenfel",
    6 =>"appstc_ayaguna_multiorion",
    7 =>"appstc_ayaguna_daqui",
    8 =>"appstc_ayaguna_venemar",
    9 =>"appstc_ayaguna_intercon",
    10 =>"appstc_ayaguna_interconpbl"
  );
   self::$Usersdb = array(
    1 =>"appstc_jmp",
    2 =>"appstc_menfel",
    3 =>"appstc_conslg",
    4 =>"appstc_gonavi",
    5 =>"appstc_multimen",
    6 =>"appstc_multio",
    7 =>"appstc_daqui",
    8 =>"appstc_venemar",
    9 =>"appstc_intercon",
    10 =>"appstc_intercon"
  );
   self::$NDBs = array(
    1 =>"CORPORACION JMP C.A.",
    2 =>"Almacenadora MENFEL Almenfelca C.A.",
    3 =>"Consolidados La Guaira 2011, C.A.",
    4 =>"IMPORTADORA Y TRANSPORTE GONAVI, C.A.",
    5 =>"MULTISERVICIOS MENFEL C.A.",
    6 =>"MULTISERVICIOS ORION 3000 C.A.",
    7 =>"Corporación Daqui, C.A.",
    8 =>"Inversiones Pegasus 2021, C.A.",
    9 =>"Intercontainers La Guaira C.A.",
    10 =>"Intercontainers Puerto Cabello C.A."
  );
 }

 public function VerUsuario($usuario_id){
  $viewUser = new DBMySQL();
  $viewUser->Datosconexion('appstc','5G4eSBA~AEJ7','appstc_ayaguna_mastertable');
  $sql = sprintf("SELECT * FROM usuarios WHERE habilitado = 0 AND id = %d",$usuario_id);
  $viewUser->Consulta($sql);
  return $viewUser->Filas;
}

public function CrearUsuario(){
}

public function EditarUsuario(){
}

public function EliminarUsuario(){
}

public function AccesoUsuario($usuario,$clave){
  $acceso = new DBMySQL();
  $acceso->Datosconexion('appstc','5G4eSBA~AEJ7','appstc_ayaguna_mastertable');
  $sql = sprintf("SELECT id,nombre,apellido,email,usuario,clave,nivel,tipo,linea,datos FROM usuarios WHERE habilitado = 0 and usuario = '%s' and clave = md5('%s');",$usuario,$clave);
  $acceso->Consulta($sql);

  // echo "<<pre>";
  //   die(var_dump($acceso));
  // echo "</pre>";

  if($acceso->Num_resultados > 0){
   session_name($acceso->Filas['usuario']);
   session_start([ 'cookie_lifetime' => 86400, ]);
   $_SESSION['mark'] = true;
   $_SESSION['variables'] = NULL;
   $_SESSION['variables'] = $acceso->Filas;
   $_SESSION['variables']['ndb'] = self::$Dbs[$_SESSION['variables']['datos']];
   $_SESSION['variables']['udb'] = self::$Usersdb[$_SESSION['variables']['datos']];
   $_SESSION['variables']['nomdb'] = self::$NDBs[$_SESSION['variables']['datos']];
   $_SESSION['variables']['hraccess'] = date("Y-m-d H:i:s");
   $_SESSION['variables']['valido'] = true;
   unset($_SESSION['variables']['clave']);
			#2016->
   $acceso->Liberar();
   $acceso->Cerrar();

   // echo "<<pre>";
   // die(var_dump($_SESSION));
   // echo "</pre>";

   header('Location: inicio.php');
 }else {
   die('ERROR: Master Table');
 }
}

public function SalirUsuario(){
		session_unset(); // Borrar las variables de sesión
		unset($_SESSION);
		setcookie(session_name(), 0, 1 , ini_get("session.cookie_path"));    // Eliminar la cookie
		session_destroy(); // Destruir la sesión
		header('Location: acceso.php');
	}

	public function ValidarUsuario(){
		if(!isset($_SESSION['variables'])){
			header('HTTP/1.0 401 Unauthorized');
			die ("<h1>No Autorizado</h1>"."<p><a href=" . ACCESO . ">Accesar</a></p>");
		}
	}
}
?>