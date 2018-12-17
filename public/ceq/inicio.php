<?php
session_start();
session_name($_SESSION['variables']['usuario']);

require_once('config.php');
require_once("clases/class_Seguridad.php");

require_once('clases/class_DbPoo.php');
require_once('funciones/funciones.php');
require_once('alertas/alertas-error.php');


//var_dump($seguridad);
$seguridad = new Seguridad();
$seguridad->ValidarUsuario();

#unset coordenadas
unset($_SESSION['tablacoord']);
unset($_SESSION['variables']['coortrue']);

#Tracking
function SitInv($data){
  switch ($data) {
    case "0":
    echo "In.";
    break;
    case "1":
    echo "Out";
    break;
    return;
  }
}

if(isset($_POST['buscar'])){
  if($_SESSION['variables']['nivel'] != 6){
    $sql = sprintf("SELECT inventario.id, lineas.nombre AS linea,buques.nombre AS buque,viajes.viaje,tequipos.tipo,inventario.contenedor,inventario.fdb,inventario.fdm,inventario.frd,inventario.eir_r,inventario.`status`,inventario.condicion,patios.patio, inventario.fdespims, inventario.c FROM inventario, lineas, buques, viajes, tequipos, patios WHERE inventario.contenedor = '%s' AND inventario.linea = lineas.id AND inventario.buque = buques.id AND inventario.viaje = viajes.id AND inventario.tcont = tequipos.id AND inventario.patio = patios.id AND inventario.`delete` = 0 order by inventario.frd DESC;",$_POST['buscar']);
    $track = new DBsPOO(); //new DBMySQL();
    $track->Conectar(UDB,PDB); //Datosconexion(UDB,PDB,USERDB);
    $track->SelectDB(USERDB);
    $track->Consultar($sql); //Consulta($sql);

    $mostrar = $track->TotalResultados;
  }else {
    $idLinea = $_SESSION['variables']['linea'];

    $sql = sprintf("SELECT inventario.id, lineas.nombre AS linea,buques.nombre AS buque,viajes.viaje,tequipos.tipo,inventario.contenedor,inventario.fdb,inventario.fdm,inventario.frd,inventario.eir_r,inventario.`status`,inventario.condicion,patios.patio, inventario.fdespims, inventario.c FROM inventario, lineas, buques, viajes, tequipos, patios WHERE inventario.contenedor = '%s' AND inventario.linea = lineas.id AND inventario.buque = buques.id AND inventario.viaje = viajes.id AND inventario.tcont = tequipos.id AND inventario.patio = patios.id AND inventario.`delete` = 0 AND inventario.linea = %d order by inventario.frd DESC;",$_POST['buscar'], $idLinea );
    $track = new DBsPOO(); //new DBMySQL();
    $track->Conectar(UDB,PDB); //Datosconexion(UDB,PDB,USERDB);
    $track->SelectDB(USERDB);
    $track->Consultar($sql); //Consulta($sql);

    $mostrar = $track->TotalResultados;
  }
}
#Tracking
#Info
if($_SESSION['variables']['nivel'] != 6){

  #Lineas
  $resumenL = new DBsPOO();
  $resumenL->Conectar(UDB,PDB);
  $resumenL->SelectDB(USERDB);
  $resumenL->Consultar("select linea, count(*) AS cantidad from existenciaNew group by linea order by linea ASC;");
  #Resumen linea, tipos
  $resumenLT = new DBsPOO();
  $resumenLT->Conectar(UDB,PDB);
  $resumenLT->SelectDB(USERDB);
  $sql = "SELECT existenciaNew.linea, existenciaNew.tipo, COUNT(*) as cantidad FROM existenciaNew GROUP BY existenciaNew.linea, existenciaNew.tipo ORDER BY existenciaNew.linea ASC, existenciaNew.tipo ASC;";
  $resumenLT->Consultar($sql);
  #Resumen tipos
  $resumenT = new DBsPOO();
  $resumenT->Conectar(UDB,PDB);
  $resumenT->SelectDB(USERDB);
  $sql = "SELECT tipo, COUNT(*) AS cantidad FROM existenciaNew GROUP BY tipo ORDER BY tipo ASC;";
  $resumenT->Consultar($sql);
}else {
  $idLinea = $_SESSION['variables']['linea'];
  $linea = new DBsPOO();
  $linea->Conectar(UDB,PDB);
  $linea->SelectDB(USERDB);
  $sql = sprintf("SELECT nombre FROM lineas WHERE id = %d", $idLinea);
  $linea->Consultar($sql);
  $linea->Resultados();
  #Lineas
  $resumenL = new DBsPOO();
  $resumenL->Conectar(UDB,PDB);
  $resumenL->SelectDB(USERDB);
  $sql = sprintf("SELECT linea, count(*) AS cantidad from existenciaNew WHERE linea = '%s' group by linea order by linea ASC;", $linea->Resultados['nombre']);
  $resumenL->Consultar($sql);
  #Resumen linea, tipos
  $resumenLT = new DBsPOO();
  $resumenLT->Conectar(UDB,PDB);
  $resumenLT->SelectDB(USERDB);
  $sql = sprintf("SELECT existenciaNew.linea, existenciaNew.tipo, COUNT(*) as cantidad FROM existenciaNew WHERE linea = '%s' GROUP BY existenciaNew.linea, existenciaNew.tipo ORDER BY existenciaNew.linea ASC, existenciaNew.tipo ASC;", $linea->Resultados['nombre']);
  $resumenLT->Consultar($sql);
  #Resumen tipos
  $resumenT = new DBsPOO();
  $resumenT->Conectar(UDB,PDB);
  $resumenT->SelectDB(USERDB);
  $sql = sprintf("SELECT tipo, COUNT(*) AS cantidad FROM existenciaNew WHERE linea = '%s' GROUP BY tipo ORDER BY tipo ASC;", $linea->Resultados['nombre']);
  $resumenT->Consultar($sql);
}
#Info
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="Ayaguna, Control de Equipos">
  <meta name="author" content="Laymont Arratia">
  <title><?php echo VERSION; ?></title>
  <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="bootstrap/dialog/css/bootstrap-dialog.min.css">
  <!-- SmartMenus jQuery Bootstrap Addon CSS -->
  <link href="bootstrap/css/jquery.smartmenus.bootstrap.css" rel="stylesheet">
  <link href="bootstrap/css/styleBootstrap.css" rel="stylesheet">
  <link rel="shortcut icon" type="image/x-icon" href="img/fav.ico" />
  <link rel="icon" type="image/ico" href="img/fav.ico">
</link>
</head>
<body>
  <div class="container-fluid">
   <div class="row">
    <div class="col-md-12">
     <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
      <div class="navbar-header">
       <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1"> <span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span> </button>
       <a class="navbar-brand" href="#"><span class="text-primary"><img src="img/icon48.png" class="img-responsive" width="32" alt="<?php echo VERSION; ?>" title="<?php echo VERSION; ?>"/></a>
       </div>
       <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
         <ul class="nav navbar-nav">
          <?php if($_SESSION['variables']['nivel'] != 6){ ?>
          <li><a href="#">Movimientos <span class="caret"></span></a>
           <ul class="dropdown-menu">
            <li><a href="#">Ingresos <span class="caret"></span></a>
             <ul class="dropdown-menu">
              <li><a href="#">Full </a></li>
              <li><a href="<?php echo Vacios; ?>">Vacios </a></li>
              <li class="divider"></li>
              <li><a href="<?php echo eir; ?>">EIR </a></li>
              <li class="divider"></li>
              <li><a href="<?php echo PreListado; ?>">Precargado </a></li>
              <li class="divider"></li>
              <li><a href="<?php echo DEVASIG; ?>">Dev-Asignación</a></li>
            </ul>
          </li>
          <li class="divider"></li>
          <li><a href="#">Egresos <span class="caret"></span></a>
           <ul class="dropdown-menu">
            <li><a href="#">Despacho </a></li>
            <li><a href="<?php echo Devolucion; ?>">Devolución</a></li>
            <li><a href="<?php echo Asignar; ?>">Asignación</a></li>
          </ul>
        </li>
      </ul>
      <?php } ?>
      <li><a href="#">Reportes <span class="caret"></span></a>
       <ul class="dropdown-menu">
        <li><a href="#">Inventario <span class="caret"></span></a>
         <ul class="dropdown-menu">
          <?php if($_SESSION['variables']['nivel'] != 6){ ?>
          <li><a href="<?php echo Inventario; ?>">General</a></li>
          <?php } ?>
          <li><a href="<?php echo InventarioLinea; ?>">Lineas </a></li>
          <li><a href="<?php echo InventarioCondicion; ?>">Condición </a></li>
          <li><a href="<?php echo InventarioTipos; ?>">Tipos </a></li>
          <li><a href="<?php echo InventarioPatio; ?>">Patios </a></li>
          <li><a href="<?php echo InventarioViaje; ?>">Alertas </a></li>
        </ul>
      </li>
      <li class="divider"></li>
      <li><a href="#">Ingresos <span class="caret"></span></a>
       <ul class="dropdown-menu">
        <?php if($_SESSION['variables']['nivel'] != 6){ ?>
        <li><a href="<?php echo IngresosTotal; ?>">Total </a></li>
        <?php } ?>
        <li><a href="<?php echo IngresosLineas; ?>">Lineas </a></li>
      </ul>
    </li>
    <li><a href="#">Egresos <span class="caret"></span></a>
     <ul class="dropdown-menu">
      <?php if($_SESSION['variables']['nivel'] != 6){ ?>
      <li><a href="<?php echo EgresosTotal; ?>">Total</a></li>
      <?php } ?>
      <li><a href="<?php echo EgresosLineas; ?>">Lineas </a></li>
      <li><a href="<?php echo EgresosAsignacion; ?>">Asignación </a></li>
    </ul>
  </li>
  <li class="divider"></li>
  <li><a href="<?php echo Acopio; ?>">Acopio</a></li>
  <li><a href="<?php echo Mensual; ?>"><abbr title="En desarrollo">Estadisticas</abbr></a></li>
</ul>
</li>
<li><a href="#">Reparación <span class="caret"></span></a>
 <ul class="dropdown-menu">
  <?php if($_SESSION['variables']['nivel'] != 6){ ?>
  <li><a href="<?php echo Reparar; ?>">Reparacion</a></li>
  <?php } ?>
  <li><a href="<?php echo ReporteRep; ?>">Reporte</a></li>
</ul>
</li>
<?php if($_SESSION['variables']['nivel'] != 6){ ?>
<li><a href="#">Administración <span class="caret"></span></a>
 <ul class="dropdown-menu">
  <li><a href="#">Lineas <span class="caret"></span></a>
   <ul class="dropdown-menu">
    <li><a href="#">Nueva </a></li>
    <li><a href="<?php echo Lineas; ?>">Listado </a></li>
  </ul>
</li>
<li><a href="#">Buques <span class="caret"></span></a>
 <ul class="dropdown-menu">
  <li><a href="<?php echo NuevoBuque; ?>">Nuevo </a></li>
  <li><a href="<?php echo Buques; ?>">Listado </a></li>
</ul>
</li>
<li><a href="#">Viajes <span class="caret"></span></a>
 <ul class="dropdown-menu">
  <li><a href="<?php echo ViajesNuevo; ?>">Nuevo </a></li>
  <li><a href="<?php echo Viajes; ?>">Listado </a></li>
</ul>
</li>
<li class="divider"></li>
<li><a href="#">Consignatarios <span class="caret"></span></a>
 <ul class="dropdown-menu">
  <li><a href="<?php echo NuevoConsignatario; ?>">Nuevo </a></li>
  <li><a href="<?php echo Consignatarios; ?>">Listado </a></li>
</ul>
</li>
<li><a href="#">Precarga <span class="caret"></span></a>
 <ul class="dropdown-menu">
  <li><a href="<?php echo PreCargar; ?>">Importar </a></li>
  <li><a href="<?php echo PreListado; ?>">Lista </a></li>
</ul>
</li>
<li><a href="<?php echo EDITAR_SERIAL; ?>">Edición</a></li>
<li class="divider"></li>
<?php if($_SESSION['variables']['nivel'] == -1){ ?>
<li><a href="<?php echo NuevaTarjeta; ?>">Crear CardPass</a></li>
<?php } ?>
</ul>
</li>
<?php } ?>
</li>
</ul>
<form class="navbar-form navbar-left" role="search" id="track" name="track" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
  <div class="form-group">
   <input type="text" class="form-control" id="buscar" name="buscar" />
 </div>
 <button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-search"></span></button>
</form>
<ul class="nav navbar-nav navbar-right">
  <li class="dropdown"> <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="glyphicon glyphicon-wrench" aria-hidden="true"></i> Mantenimiento <strong class="caret"></strong></a>
   <ul class="dropdown-menu">
    <li><a href="#" id="fixbuque"><abbr title="Normalizar Buques" class="initialism">Buques</abbr></a></li>
    <li><a href="#" id="fixinv"><abbr title="Normalizar Inventario" class="initialism">Inventario</abbr></a></li>
    <li><a href="#" id="fixconsig"><abbr title="Normalizar Consignatarios" class="initialism">Consignatarios</abbr></a></li>
    <li><a href="alertas/mantto.php"><abbr title="Informe de errores" class="initialism">Informes</abbr></a></li>
  </ul>
</li>
<li class="dropdown"> <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-user text-info"></span> <?php echo UNOMBRE; ?><strong class="caret"></strong></a>
 <ul class="dropdown-menu">
  <li> <a href="<?php echo Ayuda; ?>" target="_blank">Documentación</a> </li>
  <li> <a href="#">Errores comunes</a> </li>
  <li class="divider"> </li>
  <li><a href="admin/tcoordusuario.php">Imprimir TCoord </a></li>
  <li>
   <!--HelpOnline-->
   <!-- mibew text link -->
   <a id="mibew-agent-button" href="http://appstc.net.ve/msson/chat?locale=es&amp;group=1" target="_blank" onclick="Mibew.Objects.ChatPopups['5783ba3c8f2422f4'].open();return false;"> <i class="fa fa-comments" aria-hidden="true"></i> Soporte en Linea </a>
   <script type="text/javascript" src="http://appstc.net.ve/msson/js/compiled/chat_popup.js"></script><script type="text/javascript">Mibew.ChatPopup.init({"id":"5783ba3c8f2422f4","url":"http:\/\/appstc.net.ve\/msson\/chat?locale=es&group=1","preferIFrame":true,"modSecurity":false,"width":640,"height":480,"resizable":true,"styleLoader":"http:\/\/appstc.net.ve\/msson\/chat\/style\/popup"});</script>
   <!-- / mibew text link -->
   <!--HelpOnline-->
 </li>
</ul>
</li>
<li> <a href="salir.php?salir=true" title="Salir"><i class="glyphicon glyphicon-off text-danger"></i>&nbsp;</a> </li>
<li class="divider">&nbsp;</li>
</ul>
</div>
</nav>
<div class="modal fade" role="dialog" id="mymodal">
  <div class="modal-dialog modal-lg">
   <div class="modal-content">
    <div class="modal-header">
     <button type="button" class="close" data-dismiss="modal">&times;</button>
     <h4 class="modal-title">Tracking</h4>
   </div>
   <!--track-->
   <div class="modal-body">
     <?php if($mostrar > 0){ ?>
     <table id="trackLista" class="table table-bordered table-condensed table-striped">
      <caption>
        Movimientos
      </caption>
      <thead>
        <tr>
         <th scope="col">#</th>
         <?php if($_SESSION['variables']['nivel'] != 6){?>
         <th scope="col">Eliminar</th>
         <?php } ?>
         <th scope="col">Contenedor</th>
         <th scope="col">Tipo</th>
         <th scope="col">Estatus</th>
         <th scope="col">Cond.</th>
         <th scope="col">EIR</th>
         <th scope="col">FDB</th>
         <th scope="col">FDM</th>
         <th scope="col">FRD</th>
         <th scope="col">Patio</th>
         <th scope="col">FDESP</th>
         <th scope="col">IN/OUT</th>
       </tr>
     </thead>
     <?php while( $track->Resultados() ) { ?>
     <tbody>
      <tr>
       <td><?php echo ++$contador; ?></td>
       <?php if($_SESSION['variables']['nivel'] != 6){?>
       <td class="text-center"><a id="eliminar" href="<?php echo ELIMINAR_CONTENEDOR.'?id='.$track->Resultados['id']; ?>" target="_blank"><i class="glyphicon glyphicon-trash"></i> </a></td>
       <?php }?>
       <td><?php if($_SESSION['variables']['nivel'] != 6){?>
        <a href="<?php echo Contenedor .'?id='.$track->Resultados['id'];?>"><?php echo $track->Resultados['contenedor']; ?></a>
        <?php }else { echo $track->Resultados['contenedor']; } ?></td>
        <td><?php echo $track->Resultados['tipo']; ?></td>
        <td><?php Estatus($track->Resultados['status']); ?></td>
        <td><?php Condiciones($track->Resultados['condicion']); ?></td>
        <td><?php echo $track->Resultados['eir_r']; ?></td>
        <td><?php echo $track->Resultados['fdb']; ?></td>
        <td><?php echo $track->Resultados['fdm']; ?></td>
        <td><?php echo $track->Resultados['frd']; ?></td>
        <td><?php echo $track->Resultados['patio']; ?></td>
        <td><?php echo $track->Resultados['fdespims']; ?></td>
        <td><?php SitInv($track->Resultados['c']); ?></td>
      </tr>
      <?php $linea = $track->Resultados['linea']; ?>
    </tbody>
    <?php }; ?>
    <tfoot>
      <tr>
        <td colspan="13"><small class="text-primary">Linea: <?php echo $linea;  ?></small></td>
      </tr>
    </tfoot>
  </table>
  <?php } ?>
</div>
<div class="modal-footer">
 <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
</div>
<!--track-->
</div>
</div>
</div>
<h3 id="infogral" class="text-center text-primary"> Información General. </h3>
<?php if ( $resumenL->TotalResultados > 0 ) { ?>
<div class="row">
  <div class="col-md-3">
   <table class="table table-bordered table-hover table-striped" id="l">
    <caption>
      Lineas
    </caption>
    <thead>
     <tr>
      <th scope="col">Linea</th>
      <th scope="col">Cantidad</th>
    </tr>
  </thead>
  <tbody>
   <?php while($resumenL->Resultados()) { ?>
   <tr>
    <td scope="strd"><?php echo $resumenL->Resultados['linea']; ?></td>
    <td scope="float"><?php $sumaL[] = $resumenL->Resultados['cantidad']; echo $resumenL->Resultados['cantidad']; ?></td>
  </tr>
  <?php } ?>
</tbody>
<tr>
 <td scope="strd">Subtotal:</td>
 <td scope="float"><?php echo array_sum($sumaL); ?></td>
</tr>
</table>
</div>
<div class="col-md-3">
 <table class="table table-bordered table-hover table-striped" id="lt">
  <caption>
    Lineas->Tipos
  </caption>
  <thead>
   <tr>
    <th scope="col">Lineas</th>
    <th scope="col">Tipos</th>
    <th scope="col">Cantidad</th>
  </tr>
</thead>
<tbody>
 <?php while( $resumenLT->Resultados() ){ ?>
 <tr>
  <td scope="strd"><?php echo $resumenLT->Resultados['linea']; ?></td>
  <td scope="strn"><?php echo $resumenLT->Resultados['tipo']; ?></td>
  <td scope="float"><?php $suma[] = $resumenLT->Resultados['cantidad']; echo $resumenLT->Resultados['cantidad']; ?></td>
</tr>
<?php } ?>
<tr>
  <td colspan="2" scope="strd">Subtotal:</td>
  <td scope="float"><?php echo array_sum($suma); ?></td>
</tr>
</tbody>
</table>
</div>
<div class="col-md-3">
 <table class="table table-bordered table-hover table-striped" id="t">
  <caption>
    Tipos
  </caption>
  <thead>
   <tr>
    <th scope="col">Tipos</th>
    <th scope="col">Cantidad</th>
  </tr>
</thead>
<tbody>
 <?php while( $resumenT->Resultados() ){ ?>
 <tr>
  <td scope="strd"><?php echo $resumenT->Resultados['tipo']; ?></td>
  <td scope="float"><?php $sumat[] = $resumenT->Resultados['cantidad']; echo $resumenT->Resultados['cantidad']; ?></td>
</tr>
<?php } ?>
<tr>
  <td scope="strd">Subtotal:</td>
  <td scope="float"><?php echo array_sum($sumat); ?></td>
</tr>
</tbody>
</table>
</div>
<div class="col-md-3">
 <div id="barPro" class="progress progress-striped active hide">
  <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width:0%">
   <span class="sr-only">100% completado</span>
 </div>
</div>
<h4 class="text-warning">
  <?php if($alerta == true){ ?>
  Alertas <small> <a href="#" id="mostrar" data-toggle="tooltip" data-placement="top" title="Ver Alertas"><i class="glyphicon glyphicon-eye-open"></i></a> <a href="#" id="ocultar"  data-toggle="tooltip" data-placement="top" title="Ocultar Alertas"><i class="glyphicon glyphicon-eye-close"></i></a> </small>
  <?php } ?>
</h4>
<div id="alertas">
  <?php if($viajes->TotalResultados > 0){ ?>
  <div class="alert alert-danger" role="alert">
   <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span> <span class="sr-only"><strong>Error: </strong></span>Registros Viajes. <span class="badge text-danger"><?php echo $viajes->TotalResultados; ?></span>
 </div>
 <?php } ?>
 <?php if($invViaje->TotalResultados > 0){ ?>
 <div class="alert alert-danger" role="alert">
   <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span> <span class="sr-only"><strong>Error: </strong></span>Registros Inventario. <span class="badge"><?php echo $invViaje->TotalResultados; ?></span>
 </div>
 <?php } ?>
</div>
</div>
</div>
<?php } else { ?>
<div class="col-sm-4 col-xs-offset-4 alert alert-info"><i class="glyphicon glyphicon-alert"></i> No hay información para mostrar</div>
<?php } ?>
<div class="row">
  <div class="col-md-12">
   <div class="modal-footer">
    <p><span id="liveclock"></span></p>
    <script language="JavaScript" type="text/javascript">
      function show5(){
        if (!document.layers&&!document.all&&!document.getElementById)
          return

        var Digital=new Date()
        var hours=Digital.getHours()
        var minutes=Digital.getMinutes()
        var seconds=Digital.getSeconds()

        var dn="PM"
        if (hours<12)
          dn="AM"
        if (hours>12)
          hours=hours-12
        if (hours==0)
          hours=12

        if (minutes<=9)
         minutes="0"+minutes
       if (seconds<=9)
         seconds="0"+seconds
        //change font size here to your desire
        myclock="<font size='2' face='Arial' ><b><font size='1'>Hora actual:</font></br>"+hours+":"+minutes+":"
        +seconds+" "+dn+"</b></font>"
        if (document.layers){
          document.layers.liveclock.document.write(myclock)
          document.layers.liveclock.document.close()
        }
        else if (document.all)
          liveclock.innerHTML=myclock
        else if (document.getElementById)
          document.getElementById("liveclock").innerHTML=myclock
        setTimeout("show5()",1000)
      }


      window.onload=show5
         //-->
       </script>
       <p><strong>Empresa:</strong> <?php echo EMPRE; ?></p>
       <h4><a id="achat" class="label label-success" href="http://appstc.net.ve/msson/chat?locale=es&amp;group=1" target="_blank" onclick="Mibew.Objects.ChatPopups['5783ba3c8f2422f4'].open();return false;"> <i class="glyphicon glyphicon-gift"></i> Soporte en linea</a></h4>
       <span class="label label-primary">True Connections 2010 &#8482;</span> <span class="label label-success"><span class="glyphicon glyphicon-thumbs-up"></span> Powered by bootstrap</span></p>
     </div>
   </div>
 </div>
</div>
</div>
</div>
<script src="bootstrap/js/jquery.min.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>
<script src="bootstrap/dialog/js/bootstrap-dialog.min.js"></script>
<script src="bootstrap/js/scripts.js"></script>
<!-- SmartMenus jQuery plugin -->
<script type="text/javascript" src="bootstrap/js/jquery.smartmenus.js"></script>
<!-- SmartMenus jQuery Bootstrap Addon -->
<script type="text/javascript" src="bootstrap/js/jquery.smartmenus.bootstrap.js"></script>
<script src="js/jquery.cookie.js"></script>
<script>
  $(function () {
    $('[data-toggle="tooltip"]').tooltip()
  })


  $(function(){
    $('#buscar').css('text-transform','uppercase');
    var $verTrack = "<?php echo $mostrar; ?>";
    if($verTrack > 0){
      $('#mymodal').modal();
    }
  });

  $(function(){
    $("#fixbuque").click(function(){
      $.post("admin/fix-buque.php").done(function(resultado){
        if( resultado == 0 ){
          BootstrapDialog.show({
           title: 'INFO',
           message: 'Sin Correciones<br>' ,
           type: 'type-warning',
           size : BootstrapDialog.SIZE_SMALL
         });
        }else {
          BootstrapDialog.show({
           title: 'INFO',
           message: '<strong>Resultados: </strong><br>' + resultado ,
           type: 'type-info',
           size : BootstrapDialog.SIZE_SMALL
         });
        }
      });
    });
  });

  $("#fixconsig").click(function(){
    $.post("admin/fix-consig.php",function(respuesta){
      $("#barPro").removeClass('hide');
      var progreso = 0;
      var IdIterval = setInterval(function(){
          //Aumento en 10 el progreso
          progreso += 5;
          $(".progress-bar").css('width', progreso + '%');
          //Si llega a 100 el Interval
          if(progreso == 100){
            clearInterval(IdIterval);
            $("#barPro").delay(3000).fadeOut();
            $("#barPro").addClass('hide');
            $(".progress-bar").css('width', 0 + '%');
            if(respuesta == 0){
              BootstrapDialog.show({
                title: 'Info',
                message: 'Sin Correciones',
                type: 'type-warning',
                size : BootstrapDialog.SIZE_SMALL
              });
            }else {
              BootstrapDialog.show({
                title: 'Info',
                message: 'Registros reparados: ' + respuesta + '.',
                type: BootstrapDialog.TYPE_SUCCESS,
                size : BootstrapDialog.SIZE_NORMAL
              });
            }
          }
        },100);
    });
  });

  $(function(){
    $('#fixinv').click(function(e) {
      $.post( "admin/fix.php").done(function(respuesta){
        if(respuesta == 0){
          BootstrapDialog.show({
           title: 'Inventario',
           message: 'Sin Correciones',
           type: 'type-warning',
           size : BootstrapDialog.SIZE_SMALL
         });
        }else if(respuesta > 0){
          BootstrapDialog.show({
           title: 'Inventario',
           message: 'Registros reparados: ' + respuesta + '.',
           type: BootstrapDialog.TYPE_SUCCESS,
           size : BootstrapDialog.SIZE_SMALL
         });
        }else if(respuesta == -1){
          BootstrapDialog.show({
           title: 'Inventario',
           message: 'Error: No se puedo actualizar la tabla.',
           type: BootstrapDialog.TYPE_DANGER,
           size : BootstrapDialog.SIZE_SMALL
         });
        }else if(respuesta == -2){
          BootstrapDialog.show({
           title: 'Inventario',
           message: 'Error: Viajes.',
           type: 'type-warning',
           size : BootstrapDialog.SIZE_SMALL
         });
        }
      });
    });
  });

  $(function(){
    $("#mostrar").click(function(){
      $("#alertas").show("slow");
      $.cookie('alertas','show');
      $("#mostrar").hide();
      $("#ocultar").show();
    });
    $("#ocultar").click(function(){
      $("#alertas").hide("slow");
      $.cookie('alertas','hide');
      $("#mostrar").show();
      $("#ocultar").hide();
    });

    if(!$.cookie('alertas')){
      $.cookie('alertas', 'show', { expires: 365, path: '/' });
    }

    var alertas = $.cookie('alertas');
    if (alertas=='hide'){
      $("#alertas").hide();
      $("#mostrar").show();
      $("#ocultar").hide();
    }else if(alertas =='show'){
      $("#alertas").show();
      $("#mostrar").hide();
      $("#ocultar").show();
    }
  });

</script>
<?php $cache->cerrar(); ?>
</body>
<?php

//Liberar memoria
$resumenL->Liberar();
$resumenT->Liberar();
$resumenLT->Liberar();

//Cerrar Conexion
$resumenL->Cerrar();
$resumenT->Cerrar();
$resumenLT->Cerrar();

if(isset($_POST['buscar'])){
  $track->Liberar();
  $track->Cerrar();
}

?>
</html>