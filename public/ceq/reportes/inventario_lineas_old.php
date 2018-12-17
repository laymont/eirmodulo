<?php
session_start();
session_name($_SESSION['variables']['usuario']);
require_once('../config.php');
require_once('../clases/class_Conexion.php');
require_once('../funciones/funciones.php');
#Seguridad
$seguridad = new Seguridad();
$seguridad->ValidarUsuario();

#Lineas
$lineas = new DBMySQL();
$lineas->Datosconexion(UDB,PDB,USERDB);
if($_SESSION['variables']['nivel'] != 6){
	$lineas->Consulta("SELECT nombre AS linea FROM lineas WHERE activo = 0;");
}else {
	$idLinea = $_SESSION['variables']['linea'];
	$sql = sprintf("SELECT nombre AS linea FROM lineas WHERE id = %d AND activo = 0;", $idLinea);
	$lineas->Consulta($sql);
}

if(isset($_POST['linea']) and isset($_POST['estatus'])){
	$linea = $_POST['linea'];
	$estatus = implode(",",$_POST['estatus']);
	$sql = sprintf("SELECT * FROM existenciaNew WHERE linea LIKE '%s' AND `status` IN(%s);",$linea, $estatus);
	$inventario = new DBMySQL();
	$inventario->Datosconexion(UDB,PDB,USERDB);
	$inventario->Consulta($sql);
	
	$recaps20 = new DBMySQL();
	$recaps20->Datosconexion(UDB,PDB,USERDB);
	$sql = sprintf("SELECT tipo, count(tipo) AS cantidad FROM existenciaNew WHERE tipo LIKE '2%%' AND linea LIKE '%s' AND `status` IN(%s) GROUP BY tipo ORDER BY tipo;",$linea, $estatus);
	$recaps20->Consulta($sql);
	
	$recaps40 = new DBMySQL();
	$recaps40->Datosconexion(UDB,PDB,USERDB);
	$sql = sprintf("SELECT tipo, count(tipo) AS cantidad FROM existenciaNew WHERE tipo LIKE '4%%' AND linea LIKE '%s' AND `status` IN(%s) GROUP BY tipo ORDER BY tipo;",$linea, $estatus);
	$recaps40->Consulta($sql);
}

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Inventario Lineas</title>
<script type="text/javascript" language="javascript" src="../js/jquery.js"></script>
<script type="text/javascript" language="javascript" src="../js/funciones.js"></script>
<script src="../js/jquery.tablesorter.js"></script>
<script>
$(document).ready(function() {
    $("#lista").tablesorter();
});
</script>
<link href="../css/estilo.css" rel="stylesheet" type="text/css">
<link href="../css/style.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" href="../fontawesome/css/font-awesome.min.css" />
<link href="../css/busqueda.css" rel="stylesheet" type="text/css">
</head>
<body>
<div class="logo"><img src="../img/logopeq.fw.png" width="120" height="40" alt=""/></div>
<p><i class="fa fa-home"></i>&nbsp;<a href="../inicio_old.php">Regresar</a><span class="mostrar"> | <i class="fa fa-file-excel-o"></i>&nbsp;

<a href="inventario_lineasExp.php?linea=<?php echo $_POST['linea'];?>&estatus=<?php echo implode(",",$_POST['estatus']);?>">Exportar</a>

</span></p>
<h1>Inventario Lineas</h1>
<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" name="lineas" class="busqueda_form" id="lineas" onKeyPress="Noenter();">
  <fieldset>
    <legend>Indique Linea y Estatus</legend>
    <ul>
      <li>
        <label for="select">Linea:</label>
        <select name="linea" required id="linea">
          <option value="">Seleccion</option>
          <?php do{ ?>
          <?php if($lineas->Filas['linea'] == $_POST['linea']){ ?>
          <option value="<?php echo $lineas->Filas['linea']; ?>" selected><?php echo $lineas->Filas['linea']; ?></option>
          <?php }else { ?>
          <option value="<?php echo $lineas->Filas['linea']; ?>"><?php echo $lineas->Filas['linea']; ?></option>
          <?php } ?>
          <?php } while($lineas->Filas = mysqli_fetch_assoc($lineas->Consulta));?>
        </select>
        <label for="estatus[]">Empty
          <input name="estatus[]" type="checkbox" id="estatus[]" form="lineas" value="0"
  <?php
  if(isset($_POST['estatus'][0])){
	  echo "checked";
  }else if(isset($_POST['lineas']) and !isset($_POST['estatus'][0])){
  }else {
	  echo "checked";
  }
  ?>>
        </label>
        <label for="estatus[]">Full
          <input name="estatus[]" type="checkbox" id="estatus[]" form="lineas" value="1"
  <?php
  if(isset($_POST['estatus'][1])){
	  echo "checked";
  }else if(isset($_POST['lineas']) and !isset($_POST['estatus'][1])){
  }else {
	  echo "checked";
  }
  ?>>
        </label>
        <input name="submit" type="submit" id="submit" onClick="ValidarBox()" value="Enviar">
      </li>
    </ul>
  </fieldset>
</form>
<?php if($inventario->Num_resultados > 0) { ?>


<table class="tablesorter">
  <caption>
  Listado de Equipos: <?php echo $inventario->Num_resultados; ?> | Linea: <?php echo $inventario->Filas['linea']; ?>
  </caption>
  <thead>
    <tr>
      <th class="header" scope="col">#</th>
      <th class="header" scope="col">Buque</th>
      <th class="header" scope="col">Viaje</th>
      <th class="header" scope="col">Contenedor</th>
      <th class="header" scope="col">Tipo</th>
      <th class="header" scope="col">Fdb</th>
      <th class="header" scope="col">Fdm</th>
      <th class="header" scope="col">Fdr</th>
      <th class="header" scope="col">Fact.</th>
      <th class="header" scope="col">EIR</th>
      <th class="header" scope="col">Est.</th>
      <th class="header" scope="col">Cond.</th>
      <th class="header" scope="col">Pre.</th>
      <th class="header" scope="col">B/L</th>
      <th class="header" scope="col">Patio</th>
      <th class="header" scope="col">Consig.</th>
      <th class="header" scope="col">Obs.</th>
      <th class="header" scope="col">DA</th>
      <th class="header" scope="col">DP</th>
    </tr>
  </thead>
  <tfoot>
    <tr>
      <th scope="col">&nbsp;</th>
      <th scope="col">&nbsp;</th>
      <th scope="col">&nbsp;</th>
      <th scope="col">&nbsp;</th>
      <th scope="col">&nbsp;</th>
      <th scope="col">&nbsp;</th>
      <th scope="col">&nbsp;</th>
      <th scope="col">&nbsp;</th>
      <th scope="col">&nbsp;</th>
      <th scope="col">&nbsp;</th>
      <th scope="col">&nbsp;</th>
      <th scope="col">&nbsp;</th>
      <th scope="col">&nbsp;</th>
      <th scope="col">&nbsp;</th>
      <th scope="col">&nbsp;</th>
      <th scope="col">&nbsp;</th>
      <th scope="col">&nbsp;</th>
      <th scope="col">&nbsp;</th>
      <th scope="col">&nbsp;</th>
    </tr>
  </tfoot>
  <?php do { ?>
  <tr>
    <td scope="num"><?php echo ++$contador; ?></td>
    <td scope="strn"><?php echo $inventario->Filas['buque']; ?></td>
    <td scope="strn"><?php echo $inventario->Filas['viaje']; ?></td>
    <td scope="strn"><?php echo $inventario->Filas['contenedor']; ?></td>
    <td scope="strd"><?php echo $inventario->Filas['tipo']; ?></td>
    <td scope="strd"><?php echo $inventario->Filas['fdb']; ?></td>
    <td scope="strd"><?php echo $inventario->Filas['fdm']; ?></td>
    <td scope="strd"><?php echo $inventario->Filas['frd']; ?></td>
    <td scope="num"><?php echo $inventario->Filas['fact']; ?></td>
    <td scope="num"><?php echo $inventario->Filas['eir_r']; ?></td>
    <td scope="strd"><?php Estatus($inventario->Filas['status']); ?></td>
    <td scope="strd"><?php Condiciones($inventario->Filas['condicion']); ?></td>
    <td scope="num"><?php echo $inventario->Filas['precinto']; ?></td>
    <td scope="strn"><?php echo $inventario->Filas['bl']; ?></td>
    <td scope="strn"><?php echo $inventario->Filas['patio']; ?></td>
    <td scope="strn"><?php echo $inventario->Filas['consig']; ?></td>
    <td scope="obs"><a href="#" class="Ntooltip">Ver<span><?php echo $inventario->Filas['obs']; ?></span></a></td>
    <td scope="num"><script>DiffDias("<?php echo $inventario->Filas['frd']; ?>","<?php echo AHORAC;?>")</script></td>
    <td scope="num"><script>DiffDias("<?php echo $inventario->Filas['fdb']; ?>","<?php echo AHORAC;?>")</script></td>
  </tr>
  <?php } while ($inventario->Filas = mysqli_fetch_assoc($inventario->Consulta)); ?>
</table>
<?php } ?>
</body>
</html>
<?php
if(isset($inventario)){
	$inventario->Liberar();
	$recaps20->Liberar();
	$recaps40->Liberar();
}
?>