<?php
session_start();
session_name($_SESSION['variables']['usuario']);
require_once(RAIZ . "config.php");
require_once(CLASES . "class_Conexion.php");
require_once(FUNCIONES_PHP . "funciones.php");

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
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title></title>
<style type="text/css">
body {
	margin-left: 10px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
body,td,th {
	font-family: "Lucida Grande", "Lucida Sans Unicode", "Lucida Sans", "DejaVu Sans", Verdana, sans-serif;
	font-size: small;
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
</style>
</head>

<body>
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
<p></p>
</body>
</html>