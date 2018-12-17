<?php
session_start();
date_default_timezone_set('America/Caracas');
$ahora = date("Y-m-d");
require('../Connections/conexion.php');
require('../funciones/funciones.php');
////RECIBIMOS DATOS DE SESION Y VARIABLES POST CON VALORES
$booking = $_POST['booking'];
$puertoeir = $_POST['puertoeir'];
$cliente = $_POST['clienteeir'];
$dirfinaleir = $_POST['dirfinaleir'];
$agtaduntlf = $_POST['agtaduntlf'];
$pesoeir = $_POST['pesoeir'];
$gensethoras = $_POST['gensethoras'];
$agaduaneir = $_POST['agaduaneir'];
$ag_navieroeir = $_POST['ag_navieroeir'];

//CHECKS DEL FORMULARIO
$est_chasis = $_POST['est_chasis'];
$sobrepeso = $_POST['sobrepeso'];
$sobrealto = $_POST['sobrealto'];
$sobrelargo = $_POST['sobrelargo'];
$sobreancho = $_POST['sobreancho'];
$cargadanger = $_POST['cargadanger'];
$calcomania = $_POST['calcomania'];
$func_genset = $_POST['func_genset'];
$bateria= $_POST['bateria'];
$condicion = $_POST['condiciones'];

//////RESERVADO PARA VARIABLES DMG///////
$daños = $_SESSION['dannos'];
$damaged = implode(",",$daños);
/////////////////////////////////////////
//////VARIABLES DE SESION NECESARIAS
$EIR_ACTUAL = $_SESSION['eir_actual'];
$ACTA = $_SESSION['eir_x_acta'];


//CODIGO DE BARRAS PARA EL EIR
$cod1 = mt_rand(3,999);
$cod2 = mt_rand(2,777);
$cod3 = $_SESSION['codbareir'] = (int)$EIR_ACTUAL.$cod2.$cod1;

/////////GUARDAR DATOS EN TABLA//////////
$upd_eir = "UPDATE eir SET eir_numchasis = '$numchasis', eir_chasis_estado = '$est_chasis', eir_booking = '$booking', eir_puerto = '$puertoeir', eir_cliente = '$cliente', eir_dir_final = '$dirfinaleir', eir_peso_cont = '$pesoeir', eir_sobrepeso = '$sobrepeso', eir_sobrealto = '$sobrealto', eir_sobrelargo = '$sobrelargo', eir_sobreancho = '$sobreancho', eir_cargadanger = '$cargadanger', eir_calcomania = '$calcomania', eir_func_genset = '$func_genset', eir_bateria = '$bateria', eir_genset_horas = '$gensethoras', eir_condiciones = '$condicion', eir_ag_naviero = '$ag_navieroeir', eir_agente_ad = '$agaduaneir', eir_observ_entrega = '$damaged', codigo_b_eir = '$cod3' WHERE ideir = '$EIR_ACTUAL' and eir_acta = '$ACTA'";
$exe_upd = mysql_query($upd_eir, $conexion) or die(mysql_error());

header("location:../actas_cont/index_cont.php");

?>