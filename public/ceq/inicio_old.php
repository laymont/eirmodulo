<?php
session_start();
session_name($_SESSION['variables']['usuario']);
require_once('config.php');
require_once('clases/class_Conexion.php');
require_once('funciones/funciones.php');
$seguridad = new Seguridad();
$seguridad->ValidarUsuario();

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
		$sql = sprintf("SELECT inventario.id, lineas.nombre AS linea,buques.nombre AS buque,viajes.viaje,tequipos.tipo,inventario.contenedor,inventario.fdb,inventario.fdm,inventario.frd,inventario.eir_r,inventario.`status`,inventario.condicion,patios.patio, inventario.c FROM inventario, lineas, buques, viajes, tequipos, patios WHERE inventario.contenedor = '%s' AND inventario.linea = lineas.id AND inventario.buque = buques.id AND inventario.viaje = viajes.id AND inventario.tcont = tequipos.id AND inventario.patio = patios.id AND inventario.`delete` = 0 order by inventario.frd DESC;",$_POST['buscar']);
		$track = new DBMySQL();
		$track->Datosconexion(UDB,PDB,USERDB);
		$track->Consulta($sql);
		$mostrar = $track->Num_resultados;
	}else {
		$idLinea = $_SESSION['variables']['linea'];
		
		$sql = sprintf("SELECT inventario.id, lineas.nombre AS linea,buques.nombre AS buque,viajes.viaje,tequipos.tipo,inventario.contenedor,inventario.fdb,inventario.fdm,inventario.frd,inventario.eir_r,inventario.`status`,inventario.condicion,patios.patio, inventario.c FROM inventario, lineas, buques, viajes, tequipos, patios WHERE inventario.contenedor = '%s' AND inventario.linea = lineas.id AND inventario.buque = buques.id AND inventario.viaje = viajes.id AND inventario.tcont = tequipos.id AND inventario.patio = patios.id AND inventario.`delete` = 0 AND inventario.linea = %d order by inventario.frd DESC;",$_POST['buscar'], $idLinea );
		$track = new DBMySQL();
		$track->Datosconexion(UDB,PDB,USERDB);
		$track->Consulta($sql);
		$mostrar = $track->Num_resultados;
		
		
	}
}
#Tracking
#Info
if($_SESSION['variables']['nivel'] != 6){
	
	#Lineas
	$resumenL = new DBMySQL();
	$resumenL->Datosconexion(UDB,PDB,USERDB);
	$resumenL->Consulta("select linea, count(*) AS cantidad from existenciaNew group by linea order by linea ASC;");
	
	#Resumen linea, tipos
	$resumenLT = new DBMySQL();
	$resumenLT->Datosconexion(UDB,PDB,USERDB);
	$sql = "SELECT existenciaNew.linea, existenciaNew.tipo, COUNT(*) as cantidad FROM existenciaNew GROUP BY existenciaNew.linea, existenciaNew.tipo ORDER BY existenciaNew.linea ASC, existenciaNew.tipo ASC;";
	$resumenLT->Consulta($sql);
	
	#Resumen tipos
	$resumenT = new DBMySQL();
	$resumenT->Datosconexion(UDB,PDB,USERDB);
	$sql = "SELECT tipo, COUNT(*) AS cantidad FROM existenciaNew GROUP BY tipo ORDER BY tipo ASC;";
	$resumenT->Consulta($sql);
} else {
	$idLinea = $_SESSION['variables']['linea'];
	$linea = new DBMySQL();
	$linea->DatosConexion(UDB,PDB,USERDB);
	$sql = sprintf("SELECT nombre FROM lineas WHERE id = %d", $idLinea);
	$linea->Consulta($sql);
	
	#Lineas
	$resumenL = new DBMySQL();
	$resumenL->Datosconexion(UDB,PDB,USERDB);
	$sql = sprintf("SELECT linea, count(*) AS cantidad from existenciaNew WHERE linea = '%s' group by linea order by linea ASC;", $linea->Filas['nombre']);
	$resumenL->Consulta($sql);
	
	#Resumen linea, tipos
	$resumenLT = new DBMySQL();
	$resumenLT->Datosconexion(UDB,PDB,USERDB);
	$sql = sprintf("SELECT existenciaNew.linea, existenciaNew.tipo, COUNT(*) as cantidad FROM existenciaNew WHERE linea = '%s' GROUP BY existenciaNew.linea, existenciaNew.tipo ORDER BY existenciaNew.linea ASC, existenciaNew.tipo ASC;", $linea->Filas['nombre']);
	$resumenLT->Consulta($sql);
	
	#Resumen tipos
	$resumenT = new DBMySQL();
	$resumenT->Datosconexion(UDB,PDB,USERDB);
	$sql = sprintf("SELECT tipo, COUNT(*) AS cantidad FROM existenciaNew WHERE linea = '%s' GROUP BY tipo ORDER BY tipo ASC;", $linea->Filas['nombre']);
	$resumenT->Consulta($sql);
}
#Info
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title><?php echo VERSION; ?></title>
<style>
@import url("fontawesome/css/font-awesome.min.css");
body { margin: 0px !important; }
body{
	font: 13px 'trebuchet MS', Arial, Helvetica;
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
	}
#menu, #menu ul {
	margin-top: 0px !important;
	margin-left: 0px !important;
    margin: 0;
    padding: 0;
    list-style: none;
}
	
	h2, p {
	text-align: center;
	color: #FFFFFF;
	text-shadow: 0 1px 0 #fff;
	}
	
	a { color: #0080C0; }
	
	/* You don't need the above styles, they are demo-specific ----------- */
	
	#menu, #menu ul {
		margin: 0;
		padding: 0;
		list-style: none;
	}
	
	#menu {
	width: 960px;
	margin: 60px auto;
	border: 1px solid #87CEEB;
	background-color: #87CEEB;
	-moz-border-radius: 6px;
	-webkit-border-radius: 6px;
	-moz-box-shadow: 0 1px 1px #777, 0 1px 0 #666 inset;
	-webkit-box-shadow: 0 1px 1px #87CEEB,0 1px 0 #666 inset;
	box-shadow: 0 1px 1px #87CEEB,0 1px 0 #666 inset;
	}
	
	#menu:before,
	#menu:after {
	content: "";
	display: inline;
	}
	
	#menu:after {
		clear: both;
	}
	
	#menu {
		zoom:1;
	}
	
	#menu li {
	float: left;
	border-right: 1px solid #fff;
	-moz-box-shadow: 1px 0 0 #D8D8D8;
	-webkit-box-shadow: 1px 0 0 #FFFFFF;
	box-shadow: 1px 0 0 #FFFFFF;
	position: relative;
	}
	
	#menu a {
	float: left;
	padding: 12px 30px;
	color: #FFFFFF;
	text-transform: uppercase;
	font: bold 12px Arial, Helvetica;
	text-decoration: none;
	text-shadow: 0 1px 0 #838487;
	}
	
	#menu li:hover > a { color: #FFFFFF; }
	
	*html #menu li a:hover { /* IE6 only */ color: #F3F3F3; }
	
	#menu ul {
	margin: 20px 0 0 0;
	_margin: 0; /*IE6 only*/
	opacity: 0;
	visibility: hidden;
	position: absolute;
	top: 38px;
	left: 0;
	z-index: 1;
	background: #87CEEB;
	-moz-box-shadow: 0 -1px #FFFFFF;
	-webkit-box-shadow: 0 -1px 0 #FFFFFF;
	box-shadow: 0 -1px 0 #FFFFFF;
	-moz-border-radius: 3px;
	-webkit-border-radius: 3px;
	-webkit-transition: all .2s ease-in-out;
	-moz-transition: all .2s ease-in-out;
	-ms-transition: all .2s ease-in-out;
	-o-transition: all .2s ease-in-out;
	transition: all .2s ease-in-out;
	}

	#menu li:hover > ul {
		opacity: 1;
		visibility: visible;
		margin: 0;
	}
	
	#menu ul ul {
	top: 0;
	left: 150px;
	margin: 0 0 0 20px;
	_margin: 0; /*IE6 only*/
	-moz-box-shadow: -1px 0 0 #FFFFFF;
	-webkit-box-shadow: -1px 0 0 #FFFFFF;
	box-shadow: -1px 0 0 #FFFFFF;
	}
	
	#menu ul li {
	float: none;
	display: block;
	border: 0;
	_line-height: 0; /*IE6 only*/
	-moz-box-shadow: 0 1px 0 #111, 0 2px 0 #D8D8D8;
	-webkit-box-shadow: 0 1px 0 #FFFFFF,0 2px 0 #D8D8D8;
	box-shadow: 0 1px 0 #FFFFFF,0 2px 0 #D8D8D8;
	}
	
	#menu ul li:last-child {   
		-moz-box-shadow: none;
		-webkit-box-shadow: none;
		box-shadow: none;    
	}
	
	#menu ul a {    
		padding: 10px;
		width: 130px;
		_height: 10px; /*IE6 only*/
		display: block;
		white-space: nowrap;
		float: none;
		text-transform: none;
	}
	
	#menu ul a:hover { background-color: #2BB8FF; }
	
	#menu ul li:first-child > a {
	-moz-border-radius: 3px 3px 0 0;
	-webkit-border-radius: 3px 3px 0 0;
	border-radius: 3px 3px 0 0;
	}
	
	#menu ul li:first-child > a:after {
		content: '';
		position: absolute;
		left: 40px;
		top: -6px;
		border-left: 6px solid transparent;
		border-right: 6px solid transparent;
		border-bottom: 6px solid #FFFFFF;
	}
	
	#menu ul ul li:first-child a:after {
		left: -6px;
		top: 50%;
		margin-top: -6px;
		border-left: 0;	
		border-bottom: 6px solid transparent;
		border-top: 6px solid transparent;
		border-right: 6px solid #FFFFFF;
	}
	
	#menu ul li:first-child a:hover:after {
		border-bottom-color: #04acec; 
	}
	
	#menu ul ul li:first-child a:hover:after {
		border-right-color: #0299d3; 
		border-bottom-color: transparent; 	
	}
	
	#menu ul li:last-child > a {
		-moz-border-radius: 0 0 3px 3px;
		-webkit-border-radius: 0 0 3px 3px;
		border-radius: 0 0 3px 3px;
	}
	
	/* Mobile */
	#menu-trigger {
		display: none;
	}

	@media screen and (max-width: 600px) {

		/* nav-wrap */
		#menu-wrap { position: relative; }

		#menu-wrap * {
	-moz-box-sizing: border-box;
	-webkit-box-sizing: border-box;
	box-sizing: border-box;
		}

		/* menu icon */
		#menu-trigger {
	display: block; /* show menu icon */
	height: 40px;
	line-height: 40px;
	cursor: pointer;
	padding: 0 0 0 35px;
	border: 1px solid #222;
	color: #FFFFFF;
	font-weight: bold;
	background-color: #63CBFF;
	background-repeat: no-repeat;
	background-position: 10px center, linear-gradient(#444, #111);
	-moz-border-radius: 6px;
	-webkit-border-radius: 6px;
	-moz-box-shadow: 0 1px 1px #777, 0 1px 0 #666 inset;
	-webkit-box-shadow: 0 1px 1px #777, 0 1px 0 #666 inset;
	box-shadow: 0 1px 1px #777, 0 1px 0 #666 inset;
		}
		
		/* main nav */
		#menu {
			margin: 0; padding: 10px;
			position: absolute;
			top: 40px;
			width: 100%;
			z-index: 1;
			background-color: #444;
			display: none;
			-moz-box-shadow: none;
			-webkit-box-shadow: none;
			box-shadow: none;		
		}

		#menu:after {
			content: '';
			position: absolute;
			left: 25px;
			top: -8px;
			border-left: 8px solid transparent;
			border-right: 8px solid transparent;
			border-bottom: 8px solid #444;
		}	

		#menu ul {
			position: static;
			visibility: visible;
			opacity: 1;
			margin: 0;
			background: none;
			-moz-box-shadow: none;
			-webkit-box-shadow: none;
			box-shadow: none;				
		}

		#menu ul ul {
			margin: 0 0 0 20px !important;
			-moz-box-shadow: none;
			-webkit-box-shadow: none;
			box-shadow: none;		
		}

		#menu li {
			position: static;
			display: block;
			float: none;
			border: 0;
			margin: 5px;
			-moz-box-shadow: none;
			-webkit-box-shadow: none;
			box-shadow: none;			
		}

		#menu ul li{
			margin-left: 20px;
			-moz-box-shadow: none;
			-webkit-box-shadow: none;
			box-shadow: none;		
		}

		#menu a{
	display: block;
	float: none;
	padding: 0;
	color: #FFFFFF;
		}

		#menu a:hover{ color: #FFFFFF; 		}	

		#menu ul a{
			padding: 0;
			width: auto;		
		}

		#menu ul a:hover{
			background: none;	
		}

		#menu ul li:first-child a:after,
		#menu ul ul li:first-child a:after {
			border: 0;
		}		

	}

	@media screen and (min-width: 600px) {
		#menu {
			display: block !important;
		}
	}	

	/* iPad */
	.no-transition {
		-webkit-transition: none;
		-moz-transition: none;
		-ms-transition: none;
		-o-transition: none;
		transition: none;
		opacity: 1;
		visibility: visible;
		display: none;  		
	}

	#menu li:hover > .no-transition {
		display: block;
	}

#fondo {
	background-color: #87CEEB;
	height: 45px;
	margin-bottom: 5px;
}
#track {
	margin-top: 20px;
	margin-left: 20px;
	width: 400px;
}

#trackLista {
	border-width: 1px;
	border-collapse: collapse;
	border-style: solid;
	text-align: center;
}

#trackLista tr {
	border-collapse: collapse;
	border-width: 1px;
	border-style: solid;
}
input[type="search"] {
	text-transform:uppercase;
}

.contenedor {
	width: 100%;
	display: inherit;
	height: auto;
	min-height: 100%;
	float: left;
	padding-top: px;
	margin-bottom: 50px;
}
h1, h2, h3, h4, h5, h6{
	color: #58B1FF;
	text-indent: 10px;
}
.recuento {
	width: 20% !important;
	margin-right: 5px;
	float: left;
	border-width: 1px;
	border-style: solid;
	margin-left: 5px;
}
.recuento caption {
	font-size: medium;
	text-align: left;
	text-indent: 20px;
	font-style: oblique;
	color: #58B1FF;
}
.recuento tr th{
	background-color: #F0F8FF;
	font-style: oblique;
}
.recuento, tr th, tr td {
	border-width: 1px;
	border-style: solid;
	border-collapse: collapse;
	padding-top: 2px;
	padding-right: 2px;
	padding-bottom: 2px;
	padding-left: 2px;
	font-size: x-small;
}
.recuento td[scope="num"]{ text-align: center; 
}
.recuento td[scope="float"]{ text-align: right; }
.recuento td[scope="strn"]{
	text-align: left;
	text-indent: 2px;
}
.recuento td[scope="strd"]{ text-align: center; 
}
.recuento td[scope="btxt"]{ text-align: left; 
}
.recuento td[scope="obs"] {
	cursor: pointer;
	width: 3%;
	color: #0900EE;
	text-align: center;
}
footer, p {
	position: relative;
	/* Altura total del footer en px con valor negativo */
	margin-top: -50px;
	/* Altura del footer en px. Se han restado los 5px del margen
	superior mas los 5px del margen inferior
	*/
	height: 40px;
	padding: 5px 0px;
	clear: both;
	text-align: center;
	color: #4682B4;
}

/* Esta clase define la anchura del contenido y la posicion centrada
El contenido queda centrado y limitado, pero la cabecera y el pie
llegan hasta los limites del navegador.
*/

.define {
	width: 100%;
	margin-top: 0;
	margin-right: auto;
	margin-left: auto;
	margin-bottom: 0;
}
</style>
</head>

<body>
<header></header>
<div id="fondo">
<nav id="menu-wrap">  
<ul id="menu">
  <?php if($_SESSION['variables']['nivel'] != 6){ ?>
  <li><a href="#">Movimientos</a>
    <ul>
      <li><a href="#">Ingresos</a>
        <ul>
          <li><a href="#">Full</a></li>
          <li><a href="<?php echo Vacios; ?>">Vacios</a></li>
          <li><a href="<?php echo Precargar; ?>">Precargado</a></li>
        </ul>
      </li>
      <li><a href="#">Salidas</a>
        <ul>
          <li><a href="#">Despacho</a></li>
          <li><a href="<?php echo Devolucion; ?>">Devolucion</a></li>
          <li><a href="<?php echo Asignar; ?>">Asignacion</a></li>
        </ul>
      </li>
    </ul>
  </li>
  <?php } ?>
  <li><a href="#">Reportes</a>
    <ul>
      <li><a href="#">Inventario</a>
        <ul>
          <?php if($_SESSION['variables']['nivel'] != 6){ ?>
          <li><a href="<?php echo Inventario; ?>">General</a></li>
          <?php } ?>
          <li><a href="<?php echo InventarioLinea; ?>">Linea</a></li>
          <li><a href="<?php echo InventarioCondicion; ?>">Condicion</a></li>
          <li><a href="<?php echo InventarioPatio; ?>">Patio</a></li>
          <li><a href="<?php echo InventarioViaje; ?>">Alertas</a></li>
        </ul>
      </li>
      <li><a href="#">Ingresos</a>
        <ul>
          <?php if($_SESSION['variables']['nivel'] != 6){ ?>
          <li><a href="<?php echo IngresosTotal; ?>">Ingresos Total</a></li>
          <?php } ?>
          <li><a href="<?php echo IngresosLineas; ?>">Ingresos Lineas</a></li>
        </ul>
      </li>
      <li><a href="#">Egresos</a>
        <ul>
          <?php if($_SESSION['variables']['nivel'] != 6){ ?>
          <li><a href="<?php echo EgresosTotal; ?>">Egresos Total</a></li>
          <?php } ?>
          <li><a href="<?php echo EgresosLineas; ?>">Egresos Lineas</a></li>
          <li><a href="<?php echo EgresosAsignacion; ?>">Egresos Asignacion</a>      </li>
        </ul>
      </li>
    </ul>
  </li>
  <li><a href="#">Reparacion</a>
    <ul>
      <?php if($_SESSION['variables']['nivel'] != 6){ ?>
      <li><a href="<?php echo Reparar; ?>">Reparacion</a></li>
      <?php } ?>
      <li><a href="<?php echo ReporteRep; ?>">Reportes</a></li>
    </ul>
  </li>
  <?php if($_SESSION['variables']['nivel'] != 6){ ?>
  <li><a href="#">Administracion</a>
      <ul>
      	<li><a href="<?php echo Usuario; ?>">Usuario</a></li>
        <li><a href="#">Lineas</a>
        	<ul>
            	<li><a href="#">Nueva</a></li>
                <li><a href="<?php echo Lineas; ?>">Lista</a></li>
            </ul>
        </li>
        <li><a href="#">Buques</a>
        	<ul>
            	<li><a href="<?php echo NuevoBuque; ?>">Nuevo</a></li>
                <li><a href="<?php echo Buques; ?>">Lista</a></li>
            </ul>
        </li>
        <li><a href="#">Viajes</a>
        	<ul>
            	<li><a href="<?php echo ViajesNuevo; ?>">Nuevo</a></li>
                <li><a href="<?php echo Viajes; ?>">Lista</a></li>
            </ul>
        </li>
        <li><a href="#">Consignatario</a>
        	<ul>
            	<li><a href="<?php echo NuevoConsignatario; ?>">Nuevo</a></li>
                <li><a href="<?php echo Consignatarios; ?>">Listado</a></li>
            </ul>
        </li>
        <li><a href="#">Precargar</a>
        	<ul>
            	<li><a href="<?php echo PreCargar; ?>">Importar</a></li>
                <li><a href="<?php echo PreListado; ?>">Listado</a></li>
            </ul>
        </li>
        <li><a href="#">Asignacion</a>
        	<ul>
            	<li><a href="#">Editar</a></li>
            </ul>
        </li>
        <li><a href="#">Acopio</a>
        	<ul>
            	<li><a href="<?php echo Acopio; ?>">Reporte</a></li>
            </ul>
        </li>
        <li><a href="#">Estadistica</a>
        	<ul>
            	<li><a href="<?php echo Mensual; ?>" target="_blank">Mensual / Grafico</a></li>
            </ul>
        </li>
      </ul>
  </li>
  <?php } ?>
  <li><a href="#">Ayuda</a>
  	<ul>
    	<li><a href="<?php echo Ayuda; ?>" target="new">Documentacion</a></li>
        <li><a href="#">Errores Comunes</a></li>
        <li><a href="#">Enviar mensaje</a></li>
   	</ul>
  </li>
  <li><a href="salir.php?salir=true"><i class="fa fa-power-off"></i>&nbsp;Salir</a></li>
</ul>
</nav>
</div>
<section>
<article>
<form id="track" name="track" method="post">
  <input name="buscar" type="search" id="buscar" placeholder="#Contenedor">
  <input type="submit" name="submit" id="submit" value="Buscar">
</form>
<?php if($mostrar > 0){ ?>
<table width="800" id="trackLista">
  <caption>
    Movimientos
  </caption>
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
    <th scope="col">IN/OUT</th>
  </tr>
  <?php do{ ?>
  <tr>
    <td><?php echo ++$contador; ?></td>
    <?php if($_SESSION['variables']['nivel'] != 6){?><td><a href="<?php echo ELIMINAR_CONTENEDOR.'?id='.$track->Filas['id']; ?>" target="_blank"><i class="fa fa-trash-o"></i></a></td><?php }?>
    <td><?php if($_SESSION['variables']['nivel'] != 6){?><a href="<?php echo Contenedor .'?id='.$track->Filas['id'];?>"><?php echo $track->Filas['contenedor']; ?></a><?php }else { echo $track->Filas['contenedor']; } ?></td>
    <td><?php echo $track->Filas['tipo']; ?></td>
    <td><?php Estatus($track->Filas['status']); ?></td>
    <td><?php Condiciones($track->Filas['condicion']); ?></td>
    <td><?php echo $track->Filas['eir_r']; ?></td>
    <td><?php echo $track->Filas['fdb']; ?></td>
    <td><?php echo $track->Filas['fdm']; ?></td>
    <td><?php echo $track->Filas['frd']; ?></td>
    <td><?php echo $track->Filas['patio']; ?></td>
    <td><?php SitInv($track->Filas['c']); ?></td>
  </tr>
  <?php }while ($track->Filas = mysqli_fetch_assoc($track->Consulta)); ?>
</table>
<?php } ?>
</article>
<article>
<h2>Informacion General</h2>
<hr>
<div class="contenedor">



</div>
</article>
</section>
<footer class="define">

</footer>
</body>
</html>