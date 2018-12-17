<?php
session_start();
session_name($_SESSION['variables']['usuario']);
require_once('../config.php');
require_once('../clases/class_Conexion.php');
require_once('../funciones/funciones.php');
#Seguridad
$seguridad = new Seguridad();
$seguridad->ValidarUsuario();

#Precarga
if(isset($_GET['id'])){
	$id = $_GET['id'];
	$sql = sprintf("SELECT lista.id, lineas.nombre AS linea, buques.nombre AS buque, viajes.viaje, lista.equipo, lista.tipo, lista.precinto, bl, consignatario.nombre AS `consignatario` FROM lista, lineas, buques, viajes, consignatario WHERE lista.linea = lineas.id AND lista.buque = buques.id AND lista.viaje = viajes.id AND lista.consig = consignatario.id AND lista.id = %d;",$id);
	$ingreso = new DBMySQL();
	$ingreso->Datosconexion(UDB,PDB,USERDB);
	$ingreso->Consulta($sql);
}

$patios = new DBMySQL();
$patios->Datosconexion(UDB,PDB,USERDB);
$patios->Consulta("SELECT id, codigo FROM ubicacion ORDER BY codigo ASC;");

$tipos = new DBMySQL();
$tipos->Datosconexion(UDB,PDB,USERDB);
$tipos->Consulta(sprintf("SELECT id, tipo FROM tequipos WHERE id NOT IN(13,14,16,17) AND id = %d ORDER BY tipo ASC;",$ingreso->Filas['tipo']));

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="Ayaguna, Control de Equipos">
<meta name="author" content="Laymont Arratia">
<title><?php echo VERSION; ?></title>
<!--Script-->
<script src="../js/jquery-1.11.3.min.js"></script>
<script src="../bootstrap/js/bootstrap.min.js"></script>
<script src="../bootstrap/validators/validator.min.js"></script>
<script src="../bootstrap/dialog/js/bootstrap-dialog.min.js"></script>
<script src="../js/moment.js"></script>
<script src="../bootstrap/js/jquery.bootstrap-autohidingnavbar.min.js"></script>
<script src="../js/jquery-ui.min.js"></script>
<script src="../js/funciones.js"></script>
<!--Css-->
<link rel="stylesheet" type="text/css" href="../bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="../bootstrap/css/bootstrap-responsive.min.css">
<link rel="stylesheet" type="text/css" href="../bootstrap/dialog/css/bootstrap-dialog.min.css">
<link rel="stylesheet" type="text/css" href="../js/jquery-ui.min.css">
<!--Estilo para carga lenta-->
<style>
html { position: relative; }

#slow-notice
{
	width: 300px;
	position: absolute;
	top: 0;
	left: 50%;
	margin-left: -160px;
	background-color: #F0DE7D;
	text-align: center;
	z-index: 100;
	padding: 10px;
	font-family: sans-serif;
	font-size: 12px;
}

#slow-notice a, #slow-notice .dismiss
{
	color: #000;
	text-decoration: underline;
	cursor: pointer;
}

#slow-notice .dismiss-container
{
	text-align: right;
	padding-top: 10px;
	font-size: 10px;
}
</style>
<!--Detectar carga lenta-->
<script>

    function setCookie(cname,cvalue,exdays) {
        var d = new Date();
        d.setTime(d.getTime()+(exdays*24*60*60*1000));
        var expires = "expires="+d.toGMTString();
        document.cookie = cname + "=" + cvalue + ";path=/;" + expires;
    }

    function getCookie(cname) {
        var name = cname + "=";
        var ca = document.cookie.split(';');
        for(var i=0; i<ca.length; i++) {
            var c = ca[i].trim();
            if (c.indexOf(name)==0) return c.substring(name.length,c.length);
        }
        return "";
    } 

    if (getCookie('dismissed') != '1') {
        var html_node = document.getElementsByTagName('html')[0];
        var div = document.createElement('div');
        div.setAttribute('id', 'slow-notice');

        var slowLoad = window.setTimeout( function() {
            var t1 = document.createTextNode("The website is taking a long time to load.");
            var br = document.createElement('br');
            var t2 = document.createTextNode("You can switch to the ");
            var a = document.createElement('a');
            a.setAttribute('href', 'http://light-version.mysite.com');
            a.innerHTML = 'Light Weight Site';

            var dismiss = document.createElement('span');
            dismiss.innerHTML = '[x] dismiss';
            dismiss.setAttribute('class', 'dismiss');
            dismiss.onclick = function() {
                setCookie('dismissed', '1', 1);
                html_node.removeChild(div);
            }

            var dismiss_container = document.createElement('div');
            dismiss_container.appendChild(dismiss);
            dismiss_container.setAttribute('class', 'dismiss-container');

            div.appendChild(t1);
            div.appendChild(br);
            div.appendChild(t2);
            div.appendChild(a);
            div.appendChild(dismiss_container);

            html_node.appendChild(div);


        }, 1000 );

        window.addEventListener( 'load', function() {
            try {
                window.clearTimeout( slowLoad );
                html_node.removeChild(div);
            } catch (e){
                // that's okay.
            }

        });
    }

</script>
</head>

<body>
<div class="container">
 <div class="row">
  <div class="col-sm-12">
   <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
    <div class="navbar-header">
     <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1"> <span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span> </button>
     <a class="navbar-brand" href="#"><span class="text-primary">Ayaguna</span></a>
    </div>
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
     <ul class="nav navbar-nav">
      <li class="active"><a href="../inicio.php">Regresar</a></li>
      <!--<li><a href="inventarioExp.php" id="exportar">Exportar</a></li>-->
     </ul>
    </div>
   </nav>
  </div>
 </div>
 <div class="row">
  <div class="col-md-12">
   <h3>&nbsp; </h3>
  </div>
 </div>
 <div class="row">
  <div class="col-sm-6">
   <h3>Ingreso Vacio | Precarga</h3>
   <form role="form" action="ingresos_vacios_pre2.php" method="post" name="ingresoVacio" id="ingresoVacio" onKeyPress="Noenter();">
    <input name="id" type="hidden" id="id" value="<?php echo $_GET['id']; ?>">
    <div class="row">
     <div class="form-group col-sm-4">
      <span class="control-label">EIR</span>
      <input class="form-control" name="eir" type="text" required="required" id="eir" placeholder="000000" pattern="[0-9]{4,6}">
     </div>
     <div class="form-group col-sm-4">
      <span class="control-label">Factura</span>
      <input class="form-control" name="factura" type="text" id="factura" placeholder="000000" pattern="[0-9]{4,6}">
     </div>
     <div class="form-group col-sm-4">
      <span class="control-label">Pase</span>
      <input class="form-control" name="pase" type="text" id="pase" placeholder="000000"">
     </div>
    </div>
    <div class="row">
     <div class="form-group col-sm-4">
      <span class="control-label">Linea</span>
      <input class="form-control" name="linea" disabled id="linea" value="<?php echo $ingreso->Filas['linea']; ?>">
     </div>
     <div class="form-group col-sm-4">
      <span class="control-label">Buque</span>
      <input class="form-control" name="buque" disabled id="buque" value="<?php echo $ingreso->Filas['buque']; ?>">
     </div>
     <div class="form-group col-sm-4">
      <span class="control-label">Viaje</span>
      <input class="form-control" name="viaje" disabled id="viaje" value="<?php echo $ingreso->Filas['viaje']; ?>">
     </div>
    </div>
    <div class="row">
     <div class="form-group col-sm-4">
      <span class="control-label">Contenedor</span>
      <input class="form-control" name="equipo" type="text" disabled id="equipo" pattern="[A-Za-z]{3}[Uu]{1}[\d]{7}" onBlur="DigitoChequeo(this.id);" onKeyUp="caracterU(this.id);" value="<?php echo $ingreso->Filas['equipo']; ?>" maxlength="11" >
     </div>
     <div class="form-group col-sm-4">
      <span class="control-label">Tipo</span>
      <input class="form-control" name="Stipo" disabled id="Stipo" value="<?php echo $tipos->Filas['tipo']; ?>">
      <input type="hidden" name="tipo" id="tipo" value="<?php echo $tipos->Filas['id']; ?>">
     </div>
     <div class="form-group col-sm-4">
      <span class="control-label">Condicion</span>
      <select class="form-control" name="condicion" required id="condicion">
       <option value="-1">Seleccion</option>
       <option value="0">DMG</option>
       <option value="1">OPR1</option>
       <option value="2">OPR2</option>
       <option value="3">OPR3</option>
      </select>
     </div>
    </div>
    <div class="row">
     <div class="form-group col-sm-4">
      <span class="control-label">FDM</span>
      <input class="form-control" name="fdm" type="date" max="<?php echo AHORAC; ?>" required="required" id="fdm" title="FDM">
     </div>
     <div class="form-group col-sm-4">
      <span class="control-label">FDR</span>
      <input class="form-control" name="frd" type="date" id="frd" max="<?php echo AHORAC; ?>" value="<?php echo AHORAC; ?>" title="FRD">
     </div>
     <div class="form-group col-sm-4">
      <span class="control-label">Ubicacion</span>
      <select class="form-control" name="ubicacion" required id="ubicacion">
       <option value="-1">Seleccion</option>
       <?php do{ ?>
       <option value="<?php echo $patios->Filas['id']; ?>"><?php echo $patios->Filas['codigo']; ?></option>
       <?php }while ($patios->Filas = mysqli_fetch_assoc($patios->Consulta)); ?>
      </select>
     </div>
    </div>
    <div class="row">
     <div class="form-group col-sm-12">
      <span class="control-label">Consignatario</span>
      <input class="form-control" name="consignatario" disabled id="consignatario" value="<?php echo $ingreso->Filas['consignatario']; ?>" size="50">
     </div>
    </div>
    <div class="row">
     <div class="form-group col-sm-8">
      <span class="control-label">B/L</span>
      <input class="form-control" name="bl" type="text" id="bl" value="<?php echo $ingreso->Filas['bl']; ?>" maxlength="12">
     </div>
    </div>
    <div class="row">
     <div class="form-group col-sm-8">
      <span class="control-label">Observacion</span>
      <textarea class="form-control" name="observacion" id="observacion"></textarea>
     </div>
    </div>
    <button class="btn btn-primary" name="submit" id="submit" value="Enviar">Guardar</button>
   </form>
  </div>
 </div>
</div>
<!--container-->
</body>
<script>
function buscarBuques(){
    $("#viaje").html("<option value=''>- primero seleccione un buque -</option>");
 
    $linea = $("#linea").val();
 
    if($linea == ""){
            $("#buque").html("<option value=''>- primero seleccione un linea -</option>");
    }
    else {
        $.ajax({
            dataType: "json",
            data: {"linea": $linea},
            url:   'buscar.php',
            type:  'post',
            beforeSend: function(){
                //Lo que se hace antes de enviar el formulario
                },
            success: function(respuesta){
                //lo que se si el destino devuelve algo
                $("#buque").html(respuesta.html);
            },
            error:    function(xhr,err){ 
                alert("readyState: "+xhr.readyState+"\nstatus: "+xhr.status+"\n \n responseText: "+xhr.responseText);
            }
        });
    }
}
</script>
</html>