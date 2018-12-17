<?php
session_start();
session_name($_SESSION['variables']['usuario']);
ini_set('display_errors', '1');
require('../config.php');
require_once ('../clases/class_Conexion.php');

#Resultados
$buque = $_GET['b'];
$viaje = $_GET['v'];

$importados = new DBMySQL();
$importados->Datosconexion(UDB,PDB,USERDB);
$consulta = sprintf("SELECT lineas.nombre AS linea, buques.nombre AS buque, viajes.viaje, viajes.eta, lista.equipo, tequipos.tipo
FROM lista, lineas, buques, viajes, tequipos
WHERE lista.buque = %d AND lista.viaje = %d AND lista.linea = lineas.id AND lista.buque = buques.id AND lista.viaje = viajes.id AND lista.tipo = tequipos.id;",$buque,$viaje);
$importados->Consulta($consulta);
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Viajes</title>
<script src="../js/jquery-1.11.3.min.js"></script>
<script src="../bootstrap/js/bootstrap.min.js"></script>
<script src="../bootstrap/dialog/js/bootstrap-dialog.min.js"></script>
<link rel="stylesheet" type="text/css" href="../bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="../bootstrap/css/bootstrap-responsive.min.css">
<style>
.btn a {
	color: #FFF;
}
</style>
</head>

<body>
<div class="container">
	<div class="row">
		<h1>Datos Importados</h1>
        <button class="btn btn-success"><a href="listado.php">Ir a listado </a></button>
        <button class="btn btn-success"><a href="index.php">Regresar</a></button>
    </div>
    <?php if(isset($_SESSION['up']) and $_SESSION['up'] == true){ ?>
    <div class="row">
    	<div class="col-sm-8">
            <table class="table table-condensed table-striped table-bordered">
          <caption>
            Registros <?php echo $importados->Num_resultados; ?>
            </caption>
          <thead>
          <tr>
            <th width="76" scope="col">Linea</th>
            <th width="149" scope="col">Buque</th>
            <th width="86" scope="col">Viaje</th>
            <th width="90" scope="col">Fecha/Arribo</th>
            <th width="187" scope="col">Equipo</th>
            <th width="80" scope="col">Tipo</th>
            </tr>
            </thead>
            <?php do { ?>
            <tr>
            <td align="center"><?php echo $importados->Filas['linea']; ?></td>
            <td align="center"><?php echo $importados->Filas['buque']; ?></td>
            <td align="center"><?php echo $importados->Filas['viaje']; ?></td>
            <td align="center"><?php echo $importados->Filas['eta']; ?></td>
            <td align="center"><?php echo $importados->Filas['equipo']; ?></td>
            <td align="center"><?php echo $importados->Filas['tipo']; ?></td>
            </tr><?php }while($importados->Filas = mysqli_fetch_assoc($importados->Consulta)) ;?>
        </table>
        </div>
        
    </div>
    <?php }else { ?>
    <div class="row">
        <h1>Error!</h1>
        <p>No se importo la data</p>
        <p><a href="/ayaguna/import/index.php">Regresar</a></p>
    </div>
	<?php } ?>
    
</div>

</body>
</html>