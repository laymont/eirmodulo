<?php
#Para Vinculos
$servidor = $_SERVER['HTTP_HOST'];
$nombreArchivo = $_SERVER['SCRIPT_NAME'];
$srt = explode('/',$nombreArchivo);
$dir = '/'.$srt[1].'/';

$direccionequ = 'equipos/';
$direccionrep = 'reportes/';
$direccioning = 'ingresos/';
$direccionegr = 'egresos/';
$direccionadm = 'admin/';
$direccionrepa = 'reparacion/';
$direccionayu = 'ayuda/';
$direccionpre = 'precarga/';
$direccionaco = 'acopio/';
$direccionest = 'graficos/';
$direccioneir = 'EIR/';

#Estilos
define('estilosCSS','css/');
#Estilos

#Graficos
define('NAV_ESTADISTICAS',$direccionest);
define('Mensual',NAV_ESTADISTICAS . 'estadistica_mes.php');
#Graficos

#Ayuda
define('NAV_AYUDA',$direccionayu);
define('Ayuda',NAV_AYUDA . 'ayuda.html');
#Ayuda

#Equipos
define('NAV_EQUIPO',$direccionequ);
define('Contenedor',NAV_EQUIPO .'datos_contenedor.php');
define('ELIMINAR_CONTENEDOR',NAV_EQUIPO . 'datos_contenedor_eliminar.php');
define('DEVASIG',NAV_EQUIPO . 'asigdev.php');
define('EDITAR_SERIAL',NAV_EQUIPO . 'serial.php');
#Equipos

#EIR
define('NAV_EIR',$direccioneir);
define('eir', NAV_EIR . 'index.php');
#EIR

#Vinculos Reportes
define('NAV_REPORTES',$direccionrep);
define('Inventario',NAV_REPORTES .  'inventario.php');
define('InventarioLinea',NAV_REPORTES . 'inventario_lineas.php');
define('InventarioViaje',NAV_REPORTES . 'inventario_alertas.php');
define('InventarioCondicion',NAV_REPORTES . 'inventario_condicion.php');
define('InventarioTipos',NAV_REPORTES . 'inventario_tipos.php');
define('InventarioPatio',NAV_REPORTES . 'inventario_patios.php');
define('IngresosTotal',NAV_REPORTES . 'ingresos.php');
define('IngresosLineas',NAV_REPORTES . 'ingresos_lineas.php');
define('IngresosViaje',NAV_REPORTES . 'ingresos_viajes.php');
define('EgresosTotal',NAV_REPORTES . 'egresos.php');
define('EgresosLineas',NAV_REPORTES . 'egresos_lineas.php');
define('EgresosViajes',NAV_REPORTES . 'egresos_viajes.php');
define('EgresosAsignacion',NAV_REPORTES . 'egresos_asignacion.php');
#Vinculos Reportes

#Vinculos Ingreso
define('NAV_INGRESOS',$direccioning);
define('Vacios',$direccioning . 'ingresos_vacios.php');
define('Precargar',$direccioning . 'lista_precarga.php');
define('Precargado','ingresos_vacios_pre.php');
#Vinculos Ingreso

#Vinculos Egresos
define('NAV_EGRESOS',$direccionegr);
define('Devolucion',$direccionegr . 'devolucion.php');
define('Asignar',$direccionegr . 'asignacion.php');

#Vinculos Egresos

#Vinculos Admin
define('NAV_ADMIN',$direccionadm);
define('Usuario', NAV_ADMIN . "usuario.php");
define('Lineas', NAV_ADMIN . 'lineas_lista.php');
define('Buques',NAV_ADMIN . 'buques_lista.php');
define('NuevoBuque', NAV_ADMIN . 'buques_nuevo.php');
define('Viajes', NAV_ADMIN . 'viajes_lista.php');
define('ViajesNuevo', NAV_ADMIN . "viajes_nuevo.php");
define('Consignatarios', NAV_ADMIN . "consignatarios.php");
define('NuevoConsignatario',NAV_ADMIN . 'consignatario_nuevo.php');
define('NuevaTarjeta', NAV_ADMIN . 'cardpass.php');
#Vinculos Admin

#Precarga
define('NAV_PRECARGA','precarga/');
define('PreCargar',NAV_PRECARGA . 'index.php');
define('PreListado',NAV_PRECARGA . 'listado.php');
#Precarga

#Reparaciones
define('NAV_REPA',$direccionrepa);
define('ReporteRep', NAV_REPA . 'reporte.php');
define('Reparar', NAV_REPA . 'reparar.php');
#Reparaciones

#Acopio
define('NAV_ACOPIO',$direccionaco);
define('Acopio',NAV_ACOPIO . 'index.php');
#Acopio
?>