<?php 
session_start();
session_name($_SESSION['variables']['usuario']);
require_once(RAIZ . 'config.php');
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title></title>
<style>
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
<footer class="define">
  <p><strong>Empresa:</strong> <?php echo EMPRE; ?></p>
  <p>True Connections 2010 &#8482;</p>
</footer>
</body>
</html>