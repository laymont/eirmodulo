<?php 
include('../Connections/conexion.php');
mysql_select_db($database_conexion, $conexion);
?>
<?php 
session_start();
require_once('../funciones/funciones.php');
//mostrar datos
$elacta = $_GET['acta'];

$qry1 = "select inventario.acta, lineas.nombre as linea, buques.nombre as buque, viajes.viaje from inventario,lineas,buques, viajes where inventario.acta = '$elacta' and inventario.linea = lineas.id and inventario.buque = buques.id and inventario.viaje = viajes.id";
$exe1 = mysql_query($qry1, $conexion) or die(mysql_error());
$row1 = mysql_fetch_assoc($exe1);

$qry2 = "select inventario.acta,tequipos.tipo from inventario, tequipos where inventario.acta = '$elacta' and inventario.tcont = tequipos.id";
$exe2 = mysql_query($qry2, $conexion) or die(mysql_error());
$row2 = mysql_fetch_assoc($exe2);

//arreglos
//HORA Y FECHA
$tiempo = $_SESSION['time'];
$tiempo1 = explode(" ",$tiempo);
$_SESSION['horaeir'] = $tiempo[1];
$_SESSION['fechaeir'] = $tiempo[0];
//TIPO DE CONTENEDOR
$cont_type = $row2['tipo'];
$cont_type2 = explode(" ",$cont_type);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
<link rel="stylesheet" type="text/css" href="../css/estilo_general.css"/>
</head>

<body>
<form id="form1" name="form1" method="post" action="../eir/procesar_eir_actas.php" target="_blank">
  <table width="100%" border="1" cellpadding="0" cellspacing="1">
    <tr>
      <td width="39%" bgcolor="#6699CC" class="eir_fonts">NUMERO DE CHASIS</td>
      <td width="21%" align="center" bgcolor="#6699CC" class="eir_fonts">ESTADO</td>
      <td width="19%" align="center" class="eir_fonts" bgcolor="#6699CC">PUERTO</td>
      <td width="21%" align="center" bgcolor="#6699CC" class="eir_fonts">BOOKING</td>
    </tr>
    <tr>
      <td><label>
        <input name="numchasis" type="text" id="numchasis" size="50" />
      </label></td>
      <td align="center" valign="middle"><select name="est_chasis" id="est_chasis">
        <option value="3">Seleccione un valor</option>
        <option value="1">Lleno</option>
        <option value="0">Vacio</option>
        <option value="3">Dejar en blanco</option>
      </select></td>
      <td align="center"><select name="puertoeir" id="puertoeir">
        <option>Seleccione un puerto</option>
        <option value="LAG">La Guaira</option>
        <option value="PCB">Puerto Cabello</option>
        <option value="MBO">Maracaibo</option>
        <option value="MTA">Guamache</option>
        <option value="GTA">Guanta</option>
      </select></td>
      <td align="center"><label>
        <input name="booking" type="text" id="booking" />
      </label></td>
    </tr>
  </table>
  <table width="100%" border="1" cellpadding="1" cellspacing="1">
    <tr>
      <td width="35%" class="eir_fonts" bgcolor="#6699CC">CLIENTE</td>
      <td width="65%" class="eir_fonts" bgcolor="#6699CC">DIRECCION FINAL (DESTINO U ORIGEN EQUIPO)</td>
    </tr>
    <tr>
      <td align="center"><label>
        <input name="clienteeir" type="text" id="clienteeir" size="35" />
      </label></td>
      <td><label>
        <input name="dirfinaleir" type="text" id="dirfinaleir" size="80" />
      </label></td>
    </tr>
  </table>
  <table width="100%" border="1" cellpadding="1" cellspacing="1">
    <tr>
      <td width="83%" class="eir_fonts" bgcolor="#6699CC">AGENTE ADUANAL Y TELEFONO</td>
    </tr>
    <tr>
      <td><input name="agtaduntlf" type="text" id="agtaduntlf" size="120" /></td>
    </tr>
  </table>
  <table width="100%" border="1" cellpadding="1" cellspacing="1">
    <tr>
      <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td class="eir_fonts" bgcolor="#6699CC">PESO</td>
        </tr>
        <tr>
          <td><label>
            <input name="pesoeir" type="text" id="pesoeir" size="12" />
          </label></td>
        </tr>
      </table></td>
      <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td class="eir_fonts" bgcolor="#6699CC">SOBRE PESO</td>
        </tr>
        <tr>
          <td valign="middle" align="center"><label>
            <select name="sobrepeso" id="sobrepeso">
              <option value="3">Seleccione un valor</option>
              <option value="1">Si</option>
              <option value="0">No</option>
              <option value="3">Dejar en blanco</option>
            </select>
          </label></td>
        </tr>
      </table></td>
      <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td class="eir_fonts" bgcolor="#6699CC">SOBRE ALTO</td>
        </tr>
        <tr>
          <td align="center" valign="middle"><label>
            <select name="sobrealto" id="sobrealto">
              <option value="3">Seleccione un valor</option>
              <option value="1">Si</option>
              <option value="0">No</option>
              <option value="3">Dejar en blanco</option>
            </select>
          </label></td>
        </tr>
      </table></td>
      <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td class="eir_fonts" bgcolor="#6699CC">SOBRE LARGO</td>
        </tr>
        <tr>
          <td align="center" valign="middle"><select name="sobrelargo" id="sobrelargo">
            <option value="3">Seleccione un valor</option>
            <option value="1">Si</option>
            <option value="0">No</option>
            <option value="3">Dejar en blanco</option>
          </select></td>
        </tr>
      </table></td>
      <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td class="eir_fonts" bgcolor="#6699CC">SOBRE ANCHO</td>
        </tr>
        <tr>
          <td align="center" valign="middle"><select name="sobreancho" id="sobreancho">
            <option value="3">Seleccione un valor</option>
            <option value="1">Si</option>
            <option value="0">No</option>
            <option value="3">Dejar en blanco</option>
          </select></td>
        </tr>
      </table></td>
    </tr>
    <tr>
      <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td class="eir_fonts" bgcolor="#6699CC">CARGA PELIGROSA</td>
        </tr>
        <tr>
          <td align="center" valign="middle"><select name="cargadanger" id="cargadanger">
            <option value="3">Seleccione un valor</option>
            <option value="1">Si</option>
            <option value="0">No</option>
            <option value="3">Dejar en blanco</option>
          </select></td>
        </tr>
      </table></td>
      <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td class="eir_fonts" bgcolor="#6699CC">CALCOMANIA DE IDENTIFICACION</td>
        </tr>
        <tr>
          <td align="center" valign="middle"><select name="calcomania" id="calcomania">
            <option value="3">Seleccione un valor</option>
            <option value="1">Si</option>
            <option value="0">No</option>
            <option value="3">Dejar en blanco</option>
          </select></td>
        </tr>
      </table></td>
      <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td class="eir_fonts" bgcolor="#6699CC">FUNCIONAMIENTO GENSET</td>
        </tr>
        <tr>
          <td align="center" valign="middle"><select name="func_genset" id="func_genset">
            <option value="3">Seleccione un valor</option>
            <option value="1">Si</option>
            <option value="0">No</option>
            <option value="3">Dejar en blanco</option>
          </select></td>
        </tr>
      </table></td>
      <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td class="eir_fonts" bgcolor="#6699CC">BATERIA</td>
        </tr>
        <tr>
          <td align="center" valign="middle"><select name="bateria" id="bateria">
            <option value="3">Seleccione un valor</option>
            <option value="1">Si</option>
            <option value="0">No</option>
            <option value="3">Dejar en blanco</option>
          </select></td>
        </tr>
      </table></td>
      <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td class="eir_fonts" bgcolor="#6699CC">GENSET HORAS</td>
        </tr>
        <tr>
          <td align="center"><input name="gensethoras" type="text" id="gensethoras" size="7" /></td>
        </tr>
      </table></td>
    </tr>
  </table>
  <table width="100%" border="1" cellpadding="1" cellspacing="1">
    <tr>
      <td>CONDICIONES&nbsp;&nbsp;&nbsp;
        <select name="condiciones" id="condiciones">
          <option value="3">Seleccione un valor</option>
          <option value="1">Limpio</option>
          <option value="0">Sucio</option>
          <option value="3">Dejar en blanco</option>
      </select></td>
    </tr>
  </table>
  <table width="100%" border="1" cellspacing="1" cellpadding="1">
    <tr>
      <td width="50%"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td class="eir_fonts">VºBº</td>
        </tr>
        <tr>
          <td align="center"><label>
            <input name="agaduaneir" type="text" id="agaduaneir" size="55" />
          </label></td>
        </tr>
        <tr>
          <td align="center" class="eir_fonts">AGENTE ADUANERO</td>
        </tr>
      </table></td>
      <td width="50%"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td align="center" class="eir_fonts">RECUADRO DEL EQUIPO ARRIBA ESPECIFICADO</td>
        </tr>
        <tr>
          <td align="center"><input name="ag_navieroeir" type="text" id="ag_navieroeir" size="55" /></td>
        </tr>
        <tr>
          <td align="center" class="eir_fonts">AGENTE NAVIERO</td>
        </tr>
      </table></td>
    </tr>
  </table>
  <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
  <tr>
  	<td>&nbsp;</td>
  </tr>
  <tr>
    <td align="right"><label>
      <input type="submit" name="button" id="button" value="Guardar e imprimir" />
    </label></td>
  </tr>
  <tr>
    <td align="center"><a href="../actas_cont/index_cont.php?actas=true" class="lbAction" rel="deactivate">CERARA VENTANA</a></td>
  </tr>
  </table>
</form>
</body>
</html>