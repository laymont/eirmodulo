 <!doctype html>
<html>
<head>
<meta charset="utf-8">
<style>
@import url("css/font-awesome/css/font-awesome.min.css");

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
body,td,th {
	font-family: "trebuchet MS", Arial, Helvetica;
}
#fondo {
	background-color: #87CEEB;
	height: 45px;
	margin-bottom: 5px;
}
</style>
</head>
<body>
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
</body>
</html>