<?php
session_start();
session_name($_SESSION['variables']['usuario']);
require_once('../config.php');
require_once('../clases/class_Conexion.php');
require_once('../clases/class_Acopio.php');


?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title><?php echo VERSION; ?></title>

<?php if(!isset($_GET['exp'])){ ?>
<link href="../css/estiloGeneral.css" rel="stylesheet" type="text/css">
<?php }else { ?>
<style type="text/css">
@media print{	
	.mostrar {
	visibility: hidden;
}
}

body {
	font-family: "Lucida Grande", "Lucida Sans Unicode", "Lucida Sans", "DejaVu Sans", Verdana, sans-serif;
	font-size: small;
}

table {
	width: 100%;
	border-collapse: collapse;
	border-width: 1px;
	border-style: solid;
}

body table thead tr {
	background-color: #6ED1FB;
}
</style>
<?php } ?>
</head>

<body>
<p class="mostrar"><a href="../inicio_old.php">Regresar</a> | <a href="">Exportar</a></p>
<h1>Acopio</h1>
<hr>
<table width="600" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center" valign="top" scope="col">
	
      </td>
    <td align="center" valign="top" scope="col">
	
      </td>
  </tr>
</table>

<p>&nbsp;</p>
</body>
</html>