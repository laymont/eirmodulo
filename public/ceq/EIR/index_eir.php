<?php
session_start();
session_name($_SESSION['variables']['usuario']);
require_once('../config.php');
require_once('../clases/class_Conexion.php');
require_once('../funciones/funciones.php');
#Seguridad
$seguridad = new Seguridad();
$seguridad->ValidarUsuario();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo VERSION; ?></title>
<link href="../css/estilo_general.css" rel="stylesheet" type="text/css" />
<script src="../SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryCollapsiblePanel.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryMenuBarVertical.css" rel="stylesheet" type="text/css" />
<link href="../css/clases.css" rel="stylesheet" type="text/css" />
<link href="../ccs/by_id.css" rel="stylesheet" type="text/css" />
<link href="../SpryAssets/SpryCollapsiblePanel.css" rel="stylesheet" type="text/css" />
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
 <script type="text/javascript" src="../js/jquery.min.js"></script>
 <!-- PARA EL ACTA DE RECEPCION -->
    <script type="text/javascript">
      $(function(){

        $("input[name=idacta]").keyup(function(e){
          var idacta = $(this).val();
          var status=$("#status");

          status.removeClass("checked").removeClass("error")
          if(idacta.length > 0){
            $.ajax({
              type:"POST",
              url:"verificar.php",
              data:"idacta="+idacta,
              dataType:"json",
              beforeSend:function(){
                  status.html("<img src='../ajax-loader.gif' />");
              },
              success:function(response){
                  if(response.valid==true){
                    status.addClass("checked");
                  }else{
                    status.addClass("error");
                  }
                  status.html(response.msg);
              }
            })
          }else{
              status.html("Ingrese un Valor");
          }

        });

      })
    </script>
     <!-- PARA EL ACTA DE RECEPCION -->
      <!-- PARA EL PASE DE SALIDA -->
    <script type="text/javascript">
      $(function(){

        $("input[name=idpase]").keyup(function(e){
          var idpase = $(this).val();
          var status=$("#status");

          status.removeClass("checked").removeClass("error")
          if(idpase.length > 0){
            $.ajax({
              type:"POST",
              url:"verificar2.php",
              data:"idpase="+idpase,
              dataType:"json",
              beforeSend:function(){
                  status.html("<img src='../ajax-loader.gif' />");
              },
              success:function(response){
                  if(response.valid==true){
                    status.addClass("checked");
                  }else{
                    status.addClass("error");
                  }
                  status.html(response.msg);
              }
            })
          }else{
              status.html("Ingrese un Valor");
          }

        });

      })
    </script>
      <!-- PARA EL ACTA DE RECEPCION -->
<style>
 span{
        color:#555555;
        font-weight:bold;
        padding-bottom:2px;
        padding-left:16px;
      }

      span.checked{
        background:url("clean.png") no-repeat scroll 0 0 transparent;
        color:#090;

      }
      span.error{
        background:url("cancel.png") repeat scroll 0 0 transparent;
        color:#EA5200;
      }
</style>
<style type="text/css">
<!--
#fromacta {
	position:absolute;
	left:191px;
	top:131px;
	width:291px;
	height:34px;
	z-index:1;
}

#frompase {
	position:absolute;
	left:191px;
	top:131px;
	width:291px;
	height:34px;
	z-index:1;
}
-->
</style>
</head>
<body onload="KW_doClock()">
<?php if(!isset($_GET['fromacta'])) { } else { ?>
<div id="fromacta">
<fieldset>
<legend>EIR a partir de Acta de recepcion</legend>

<form id="form1" name="form1" method="post" action="">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td width="41%" valign="middle">Acta de recepcion #:</td>
      <td width="59%"><label>
        <input name="idacta" id="idacta" size="6" maxlength="6" autocomplete="off" />
        <input type="submit" name="button" id="button" value="Buscar" />
      </label></td>
    </tr>
    <tr>
      <td colspan="2" align="center"><span id="status"></span></td>
    </tr>
  </table>
</form>
</fieldset>
</div>
<?php } ?>
<?php if(!isset($_GET['frompase'])) { } else { ?>
<div id="frompase">
<fieldset>
<legend>EIR a partir de pase de salida</legend>

<form id="form1" name="form1" method="post" action="">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td width="41%" valign="middle">Pase de salida #:</td>
      <td width="59%"><label>
        <input name="idpase" id="idpase" size="6" maxlength="6" />
        <input type="submit" name="button" id="button" value="Buscar" />
      </label></td>
    </tr>
    <tr>
      <td colspan="2" align="center"><span id="status"></span></td>
    </tr>
  </table>
</form>
</fieldset>
</div>
<?php } ?>
<div id="wrapper">
  <div id="header">
    <div id="titulo"><span id="nombre"><?php echo VERSION; ?></span></div>
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
  <div id="nav">
    <ul id="MenuBar1" class="MenuBarVertical">
<li><a href="#" class="MenuBarItemSubmenu">Crear EIR</a>
  <ul>
    <li><a href="eir_nuevo.php">Nuevo</a></li>
    <li><a href="index_eir.php?fromacta=true">Desde acta de recepcion</a></li>
    <li><a href="index_eir.php?frompase=true">Desde pase de salida</a></li>
  </ul>
</li>
<li><a href="../index.php">Volver</a></li>
    </ul>
  </div>
</div>
<script type="text/javascript">
var MenuBar1 = new Spry.Widget.MenuBar("MenuBar1", {imgRight:"SpryAssets/SpryMenuBarRightHover.gif"});
</script>
</body>
</html>