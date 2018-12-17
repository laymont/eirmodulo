<?php
session_start();
session_name($_SESSION['variables']['usuario']);
require_once('../config.php');
require_once('../clases/class_Conexion.php');
require_once('../funciones/funciones.php');
#Seguridad
$seguridad = new Seguridad();
$seguridad->ValidarUsuario();

$codPuertos = new DBMySQL();
$codPuertos->Datosconexion(UDB,PDB,USERDB);
$codPuertos->Consulta("SELECT id, codigo, nombre FROM cod_puertos where activo = 0;");

$codPuertosD = new DBMySQL();
$codPuertosD->Datosconexion(UDB,PDB,USERDB);
$codPuertosD->Consulta("SELECT id, codigo, nombre FROM cod_puertos where activo = 1;");
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Documento sin título</title>
<link href="../css/estilo.css" rel="stylesheet" type="text/css">
</head>

<body>
<div class="logo"><img src="../img/logopeq.fw.png" width="120" height="40" alt=""/></div>
<p><a href="../inicio_old.php">Regresar</a><span class="mostrar"> | <a href="<?php echo $_SERVER['PHP_SELF']."?exp=true"; ?>">Exportar</a></span></p>
<h1>Puertos Codigos</h1>
<hr>
<table class="listado">
  <caption>
    Listado
Activos  
  </caption>
  <tr>
    <th scope="col">ID</th>
    <th scope="col">Codigo</th>
    <th scope="col">Nombre</th>
  </tr><?php do{ ?>
  <tr>
    <td scope="num"><?php echo $codPuertos->Filas['id']; ?></td>
    <td scope="strd"><?php echo $codPuertos->Filas['codigo']; ?></td>
    <td scope="strn"><?php echo $codPuertos->Filas['nombre']; ?></td>
  </tr><?php }while ($codPuertos->Filas = mysqli_fetch_assoc($codPuertos->Consulta));?>
</table>
<table class="listado">
  <caption>
    Listado
Activos  
  </caption>
  <tr>
    <th scope="col">ID</th>
    <th scope="col">Codigo</th>
    <th scope="col">Nombre</th>
  </tr><?php do{ ?>
  <tr>
    <td scope="num"><?php echo $codPuertosD->Filas['id']; ?></td>
    <td scope="strd"><?php echo $codPuertosD->Filas['codigo']; ?></td>
    <td scope="strn"><?php echo $codPuertosD->Filas['nombre']; ?></td>
  </tr><?php }while ($codPuertosD->Filas = mysqli_fetch_assoc($codPuertosD->Consulta));?>
</table>
<p>&nbsp;</p>
</body>
</html>