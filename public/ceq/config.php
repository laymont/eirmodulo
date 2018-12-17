<?php
#Mostrar todo los errores
error_reporting(E_ALL ^ E_NOTICE); //Entorno de Produccion
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE); //Entorno Local
ini_set("display_errors", 1);


/* For xDebug */
//ini_set('xdebug.var_display_max_depth', 4);
/*
ini_set('xdebug.collect_vars', 'on');
ini_set('xdebug.collect_params', '4');
ini_set('xdebug.dump_globals', 'on');
ini_set('xdebug.dump.SERVER', 'REQUEST_URI');
ini_set('xdebug.show_local_vars', 'on');
/* For xDebug */

//Configuracion de la fecha
date_default_timezone_set('America/Caracas');
#Datos de fecha y hora
#Defino Constantes de Fecha y hora
define('AHORAC',date("Y-m-d"));
define('AHORAL',date("Y-m-d H:i:s"));
define('AHORAM',date("d-m-Y"));
#Datos de Usuarios del Sistema
#Datos de Usuarios
define('MASTERTABLE','appstc_ayaguna_mastertable');
if(isset($_SESSION['variables'])){
	define('USERDB',$_SESSION['variables']['ndb']);
	define('UDB',$_SESSION['variables']['udb']);
	define('PDB',12215358);
	define('UNOMBRE',$_SESSION['variables']['nombre'] . ' ' . $_SESSION['variables']['apellido']);
	define('EMPRE',$_SESSION['variables']['nomdb']);
	define('IDUSER',$_SESSION['variables']['id']);
}
//Datos de la Aplicacion
define('VERSION','Ayaguna 2.0.1'); //Version.
define('ROOT_PATH','./'); //Directorio Raiz
define('RAIZ',str_replace('\\\\', '/', realpath(dirname(__FILE__))).'/');
#Define Directorios
#Includes
define('Includes','includes/');
#Ayuda
//define('INCLUDES',RAIZ.'includes/'); //Directorio de Includes.
set_include_path(Includes);
#Includes
#Clases
define('CLASES',RAIZ.'clases/'); // Directorio de clases
#Funciones PHP
define('FUNCIONES_PHP',RAIZ.'funciones/');
#Cache
define('CACHE',RAIZ.'cache/');
#Javascript
define('JS',RAIZ.'js/'); //Directorio Javascripts
#Estilos
define('ESTILOS',RAIZ.'css/'); //Directorio de Includes.
#Inicio de la Aplicacion
define('INICIO',RAIZ.'inicio.php'); //Pagina de Inicio
define('ACCESO',RAIZ.'acceso.php');//Pagina Acceso
#Directorios
#Ingresos
define('INGRESOS',RAIZ.'ingresos/');
#Salidas
//define('SALIDAS',RAIZ.'salidas/');
#Reportes
//define('REPORTES',RAIZ.'reportes/');
include_once(Includes . 'vinculos.php');
#Variables PHP
#Totales Recaps
$mostrar = false;
$contador = 0;
$suma20 = 0;
$suma40 = 0;
//Cache
include ("clases/class_Cache.php");
$cache = new cache();
$cache->iniciar(CACHE,60,true);
#Seguridad
require_once("clases/class_Seguridad.php");
#Mensajes
#Consignatario
define("MSJCONSIG","Escriba el nombre del Consignatario, si el mismo existe en el sistema; este le hara la sugerencia del nombre. En caso contrario creara el Consignatario con el nombre que esta indicando.");

/*
$tiempo_transcurrido = (strtotime(AHORAL) - strtotime($_SESSION['variables']['hraccess']));
if($tiempo_transcurrido >= 600){
	//600 milisegundos = 600/60 = 10 Minutos...
	header("salir.php");
	return false;
}else {
	$_SESSION['variables']['hraccess'] = AHORAL;
}
*/
?>