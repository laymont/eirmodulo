<?php 
include('../Connections/conexion.php');
mysql_select_db($database_conexion, $conexion);
?>
<?php 
session_start();
require_once('../funciones/funciones.php');
//mostrar datos
$elacta = $_SESSION['eir_x_acta'] = $_GET['acta'];
//$elacta = 000009;
$qry1 = "select inventario.acta, lineas.nombre as linea, buques.nombre as buque, viajes.viaje from inventario,lineas,buques, viajes where inventario.acta = '$elacta' and inventario.linea = lineas.id and inventario.buque = buques.id and inventario.viaje = viajes.id";
$exe1 = mysql_query($qry1, $conexion) or die(mysql_error());
$row1 = mysql_fetch_assoc($exe1);

$qry2 = "select inventario.acta,tequipos.tipo from inventario, tequipos where inventario.acta = '$elacta' and inventario.tcont = tequipos.id";
$exe2 = mysql_query($qry2, $conexion) or die(mysql_error());
$row2 = mysql_fetch_assoc($exe2);

//arreglos
$tiempo = $_SESSION['time'];
$tiempo1 = explode(" ",$tiempo);
$_SESSION['horaeir'] = $tiempo[1];
$_SESSION['fechaeir'] = $tiempo[0];

$cont_type = $row2['tipo'];
$cont_type2 = explode(" ",$cont_type);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>IMSSis v.1.0.1</title>
<link href="../css/estilo_general.css" rel="stylesheet" type="text/css" />
<script src="../SpryAssets/SpryCollapsiblePanel.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="../css/clases.css" rel="stylesheet" type="text/css" />
<link href="../ccs/by_id.css" rel="stylesheet" type="text/css" />
<link href="../SpryAssets/SpryCollapsiblePanel.css" rel="stylesheet" type="text/css" />
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
</head>
<body onload="KW_doClock()">
<div id="wrapper">
  <div id="header">
    <div id="titulo"><span id="nombre">IMSSis</span> <span id="version">v.1.0.1</span></div>
    <div id="clock"><script language='JavaScript'>
// Kaosweaver Live Clock Start
function class_clock(f,s,c,b,w,h,d,m,g,z) { // Copyright 2002 by Kaosweaver, All rights reserved
	this.b=b;this.w=w;this.h=h;this.d=d;this.g=g;this.z=z
	this.o='<font style="color:'+c+'; font-family:'+f+'; font-size:'+s+'pt;">';
if (m==1) this.o+=0
}
var clock=new class_clock("Verdana, Geneva, sans-serif","12","#000000","#FFFFFF","84",1,1,0,0,0)
// If the clock's size needs adjusting, change the 84 above.
d=document
if (d.all || d.getElementById) {d.write('<span id="activeClock" style="width:'+clock.w+'px; "></span>'); }
else if (d.layers) {d.write('<ilayer  id="wrapClock"><layer width="'+clock.w+'" id="activeClock"></layer></ilayer>'); }
else {KW_doClock(1);}
function KW_doClock(a) { // Copyright 2003 by Kaosweaver, All rights reserved
	d=document;t=new Date();p="";dClock="";	if (d.layers) d.wrapClock.visibility="show";
	tD=(t.getTimezoneOffset()-(clock.z*60))*clock.g;t.setMinutes(tD+t.getMinutes())
	h=t.getHours();m=t.getMinutes();s=t.getSeconds();if (clock.h)
	 {p=(h>11)?"PM":"AM";h=(h>12)?h-12:h;h=(h==0)?12:h;}if (clock.d)
	 {m=(m<=9)?"0"+m:m; s=(s<=9)?"0"+s:s;} dClock = clock.o+h+':'+m+':'+s+' '+p+'</font>';
	if (a) {d.write(dClock);}if (d.layers) {wc = document.wrapClock;lc = wc.document.activeClock;
		lc.document.write(dClock);lc.document.close();
	} else if (d.all) {	activeClock.innerHTML = dClock;
	} else if (d.getElementById) {d.getElementById("activeClock").innerHTML = dClock;}
	if (!a) setTimeout("KW_doClock()",1000);
}

// Kaosweaver Live Clock End
      </script>
      <!-- KW Live Clock -->
    </div>
  </div>
  <div id="showUser">Usuario: <?php echo $_SESSION['nombreusuario']; ?></div>
  <div id="nav">&nbsp;&nbsp;&nbsp;</div>
  <p>&nbsp;</p>
  <form id="form1" name="form1" method="post" action="">
    <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><table width="100%" border="1" cellspacing="1" cellpadding="0">
          <tr>
            <td width="42%" class="eir_fonts" bgcolor="#6699CC">NUMERO DE CONTAINER</td>
            <td width="16%" align="center" class="eir_fonts" bgcolor="#6699CC">ESTADO</td>
            <td width="21%" align="center" class="eir_fonts" bgcolor="#6699CC">PASE DE SALIDA</td>
            <td width="21%" align="center" class="eir_fonts" bgcolor="#6699CC">Nº PRESCINTO</td>
          </tr>
          <tr>
            <td class="mayuscula"><b><?php echo $_SESSION['equipo']; ?></b></td>
            <td align="center" class="mayuscula"><b><?php if($_SESSION['estatus'] = 1) { echo "LLENO"; } else { echo "VACIO"; } ?></b></td>
            <td align="center" class="mayuscula">-</td>
            <td align="center" class="mayuscula"><b><?php echo $_SESSION['precinto']; ?></b></td>
          </tr>
          <tr>
            <td class="eir_fonts" bgcolor="#6699CC">NUMERO DE CHASIS</td>
            <td align="center" class="eir_fonts" bgcolor="#6699CC">ESTADO</td>
            <td align="center" class="eir_fonts" bgcolor="#6699CC">B/L</td>
            <td align="center" class="eir_fonts" bgcolor="#6699CC">BOOKING</td>
          </tr>
          <tr>
            <td><input name="numchasis" type="text" id="numchasis" size="50" /></td>
            <td align="center" valign="middle"><select name="est_chasis" id="est_chasis">
              <option value="3">Seleccione un valor</option>
              <option value="1">Lleno</option>
              <option value="0">Vacio</option>
              <option value="3">Dejar en blanco</option>
            </select></td>
            <td align="center" class="mayuscula"><b><?php echo $_SESSION['bl']; ?></b></td>
            <td><label>
              <input name="booking" type="text" id="booking" />
            </label></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><table width="100%" border="1" cellspacing="1" cellpadding="0">
          <tr>
            <td width="32%" class="eir_fonts" bgcolor="#6699CC">BUQUE</td>
            <td width="14%" align="center" class="eir_fonts" bgcolor="#6699CC">VIAJE Nº</td>
            <td width="28%" align="center" class="eir_fonts" bgcolor="#6699CC">PUERTO</td>
            <td width="14%" align="center" class="eir_fonts" bgcolor="#6699CC">HORA</td>
            <td width="12%" align="center" class="eir_fonts" bgcolor="#6699CC">FECHA</td>
          </tr>
          <tr>
            <td align="center" class="mayuscula"><b><?php echo $row1['buque']; ?>
              <input name="buqueeir" type="hidden" id="buqueeir" value="<?php echo $row1['buque']; ?>" />
            </b></td>
            <td align="center" class="mayuscula"><b><?php echo $row1['viaje']; ?>
              <input name="viajeeir" type="hidden" id="viajeeir" value="<?php echo $row1['viaje']; ?>" />
            </b></td>
            <td><select name="puertoeir" id="puertoeir">
              <option>Seleccione un puerto</option>
              <option value="LAG">La Guaira</option>
              <option value="PCB">Puerto Cabello</option>
              <option value="MBO">Maracaibo</option>
              <option value="MTA">Guamache</option>
              <option value="GTA">Guanta</option>
            </select></td>
            <td align="center" class="mayuscula"><b><?php echo $tiempo1[1]; ?>
              <input name="horaeir" type="hidden" id="horaeir" value="<?php echo $tiempo1[1]; ?>" />
            </b></td>
            <td align="center" class="mayuscula"><b><?php echo $tiempo1[0]; ?>
              <input name="fechaeir" type="hidden" id="fechaeir" value="<?php echo $tiempo1[0]; ?>" />
            </b></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><table width="100%" border="1" cellspacing="1" cellpadding="1">
          <tr>
            <td width="35%" class="eir_fonts" bgcolor="#6699CC">CLIENTE</td>
            <td width="65%" class="eir_fonts" bgcolor="#6699CC">DIRECCION FINAL (DESTINO U ORIGEN EQUIPO)</td>
          </tr>
          <tr>
            <td><label>
              <input name="clienteeir" type="text" id="clienteeir" size="35" />
            </label></td>
            <td><label>
              <input name="dirfinaleir" type="text" id="dirfinaleir" size="80" />
            </label></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><table width="100%" border="1" cellspacing="1" cellpadding="1">
          <tr>
            <td width="17%" class="eir_fonts" bgcolor="#6699CC">TAMAÑO Y TIPO</td>
            <td width="83%" class="eir_fonts" bgcolor="#6699CC">AGENTE ADUANAL Y TELEFONO</td>
          </tr>
          <tr>
            <td rowspan="3" align="center" valign="middle" class="mayuscula"><?php echo $cont_type2[0]." ".$cont_type2[1]; ?>
              <input name="tamtipoeir" type="hidden" id="tamtipoeir" value="<?php echo $cont_type2[0]." ".$cont_type2[1]; ?>" /></td>
            <td><input name="agtaduntlf" type="text" id="agtaduntlf" size="90" /></td>
          </tr>
          <tr>
            <td class="eir_fonts" bgcolor="#6699CC">TRANSPORTISTA</td>
          </tr>
          <tr>
            <td class="mayuscula"><b><?php echo $row1['linea']; ?>
              <input name="transpeir" type="hidden" id="transpeir" value="<?php echo $row1['linea']; ?>" />
            </b></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><table width="100%" border="1" cellspacing="1" cellpadding="1">
          <tr>
            <td width="18%"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td class="eir_fonts" bgcolor="#6699CC">PESO</td>
              </tr>
              <tr>
                <td><label>
                  <input name="pesoeir" type="text" id="pesoeir" size="12" />
                </label></td>
              </tr>
            </table></td>
            <td width="24%"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td class="eir_fonts" bgcolor="#6699CC">SOBRE PESO</td>
              </tr>
              <tr>
                <td valign="middle" align="center"><select name="sobrepeso" id="sobrepeso">
                  <option value="3">Seleccione un valor</option>
                  <option value="1">Si</option>
                  <option value="0">No</option>
                  <option value="3">Dejar en blanco</option>
                </select></td>
              </tr>
            </table></td>
            <td width="20%"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td class="eir_fonts" bgcolor="#6699CC">SOBRE ALTO</td>
              </tr>
              <tr>
                <td align="center" valign="middle"><select name="sobrealto" id="sobrealto">
                  <option value="3">Seleccione un valor</option>
                  <option value="1">Si</option>
                  <option value="0">No</option>
                  <option value="3">Dejar en blanco</option>
                </select></td>
              </tr>
            </table></td>
            <td width="19%"><table width="100%" border="0" cellspacing="0" cellpadding="0">
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
            <td width="19%"><table width="100%" border="0" cellspacing="0" cellpadding="0">
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
        </table></td>
      </tr>
      <tr>
        <td><table width="100%" border="1" cellspacing="1" cellpadding="1">
          <tr>
            <td>CONDICIONES&nbsp;&nbsp;
              <select name="condiciones" id="condiciones">
                <option value="3">Seleccione un valor</option>
                <option value="1">Limpio</option>
                <option value="0">Sucio</option>
                <option value="3">Dejar en blanco</option>
              </select></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><table width="100%" border="1" cellspacing="1" cellpadding="1">
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
          <tr>
            <td align="center" bgcolor="#6699CC"><b>E N T R E G A</b></td>
            <td align="center" bgcolor="#6699CC"><b>D E V O L U C I O N</b></td>
          </tr>
          <tr>
            <td align="center" class="eir_fonts"><img src="../IMAGEN_EIR.jpg" alt="" width="340" height="378" /></td>
            <td align="center" class="eir_fonts"><img src="../IMAGEN_EIR.jpg" alt="" width="340" height="378" /></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><table width="100%" border="1" cellspacing="1" cellpadding="1">
          <tr>
            <td class="eir_fonts">Utilice el código siguiente:&nbsp;D Golpe&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;H Agujero&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;C Rotura&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;B Rozadura&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;M Falla&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;BR Quebradura&nbsp;&nbsp;&nbsp;&nbsp;BAT Bateria&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;REF Refrigeración</td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><table width="100%" border="1" cellspacing="1" cellpadding="1">
          <tr>
            <td width="50%"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td bgcolor="#6699CC">Observaciones</td>
              </tr>
              <tr>
                <td><?php echo $_SESSION['obs']; ?>
                  <input type="hidden" name="obs_entrada" id="obs_entrada" /></td>
              </tr>
            </table></td>
            <td width="50%"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td bgcolor="#6699CC">Observaciones</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td>Fecha de entrega:&nbsp;&nbsp;<b class="mayuscula"><?php echo $tiempo1[0]; ?>
                  <input name="fecha_entrega" type="hidden" id="fecha_entrega" value="<?php echo $tiempo1[0]; ?>" />
                </b></td>
              </tr>
              <tr>
                <td>Placa de Camión:&nbsp;&nbsp;<b class="mayuscula"><?php echo $_SESSION['placa']; ?>
                  <input name="placa_entrega" type="hidden" id="placa_entrega" value="<?php echo $_SESSION['placa']; ?>" />
                </b></td>
              </tr>
              <tr>
                <td>representante del cliente o<br />
                  Transportadora:&nbsp;&nbsp;<b class="mayuscula"><?php echo $_SESSION['chofer']; ?>
                  <input name="chofer_entrega" type="hidden" id="chofer_entrega" value="<?php echo $_SESSION['chofer']; ?>" />
                  </b></td>
              </tr>
              <tr>
                <td>Cedula N°:&nbsp;&nbsp;<b class="mayuscula"><?php echo $_SESSION['cedula']; ?>
                  <input name="cedula_entrega" type="hidden" id="cedula_entrega" value="<?php echo $_SESSION['cedula']; ?>" />
                </b></td>
              </tr>
            </table></td>
            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td>Fecha de entrega:</td>
              </tr>
              <tr>
                <td>Placa de Camión:</td>
              </tr>
              <tr>
                <td>representante del cliente o<br />
                  Transportadora:</td>
              </tr>
              <tr>
                <td>Cedula N°</td>
              </tr>
            </table></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table>
  </form>
  <p>&nbsp;</p>
</div>
</body>
</html>