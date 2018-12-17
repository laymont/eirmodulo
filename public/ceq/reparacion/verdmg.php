<?php
session_start();
session_name($_SESSION['variables']['usuario']);
require('../config.php');
require('../clases/class_Conexion.php');

$id = $_GET['id'];
$ver = new DBMySQL();
$ver->Datosconexion(UDB,PDB,USERDB);
$sql = sprintf("SELECT * FROM imagephp WHERE idcontenedor = %d;",$id);
$ver->Consulta($sql);

$ruta = "imgs/";

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Documento sin título</title>
</head>

<body>
<?php do{ ?>
<img src="<?php echo $ruta.$ver->Filas['nombrefoto'];?>"></br>
<?php }while($ver->Filas = mysqli_fetch_assoc($ver->Consulta)); ?>
</body>
</html>