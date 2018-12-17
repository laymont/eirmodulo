<?php
session_start();
session_name($_SESSION['variables']['usuario']);
require_once('../config.php');
require_once('../clases/class_Conexion.php');
require_once('../funciones/funciones.php');
#Seguridad
$seguridad = new Seguridad();
$seguridad->ValidarUsuario();

#Recibe POST y Valida
if(isset($_POST)){
	#Verificar linea y contenedores
	$linea = new DBMySQL();
	$linea->Datosconexion(UDB,PDB,USERDB);
	$linea->Consulta(sprintf("SELECT id, nombre FROM lineas WHERE activo = 0 AND id = %d;",$_POST['linea']));
	
	#Numero de contenedores
	$postCont = explode(",",trim($_POST['contenedores']));
	$strCont = "'" . implode("','",$postCont) . "'";
	#Numeros de EIR
	$postEir = explode(",",trim($_POST['eir_d']));
	$postEirFilter = array_filter($postEir);
	$eirs = implode(",",$postEirFilter);
	if(count($postEirFilter) == 0){
		#No registra nuevo EIR
		//Buscar id Contenedores
		$ids = new DBMySQL();
		$ids->Datosconexion(UDB,PDB,USERDB);
		$sql = sprintf("SELECT id, linea FROM existenciaNew WHERE contenedor IN(%s);",$strCont);
		$ids->Consulta($sql);
		#Comprobar que los contenedores pertenecen a la linea
		if($linea->Filas['nombre'] != $ids->Filas['linea']){
			echo '<link href="../css/estilo.css" rel="stylesheet" type="text/css">';
			die("<h1>Error</h1><p>Esta intentanto hacer una devolucion errada.</p><p>Los Contenedores no pertenecen a la linea o no estan en Inventario.</p>
			<p><a href='devolucion.php'>Regresar</a></p>");
		}
		do {
			$idDev[] = $ids->Filas['id'];
		}while ($ids->Filas = mysqli_fetch_assoc($ids->Consulta));
		
		#Devolucion
		$contenedores = implode(",",$idDev);
		$devolucion = new DBMySQL();
		$devolucion->Datosconexion(UDB,PDB,USERDB);
		$sql = sprintf("UPDATE inventario SET fdespims = '%s', buqued = %d , viajed = '%s', eir_d = eir_r, c = 1 WHERE id IN(%s);",$_POST['fecha'],$_POST['buque'],$_POST['viaje'],$contenedores);
		$devolucion->Insertar($sql);
		
	}else if(count($postEirFilter) > 0){
		#Registra EIR
		$CantEir = count($postEirFilter);
		$CantCont = count($postCont);
		if($CantCont > $CantEir){
			#Mas Contenedores que EIR
			die("<h1>Error</h1><p>Esta intentanto registrar una cantidad mayor de Contenedores que EIR's</p>");
		}else if($CantEir > $CantCont){
			#Mas EIR's que Contenedores
			die("<h1>Error</h1><p>Esta intentanto registrar una cantidad mayor de EIR's que Contenedores</p>");
		}else if($CantCont == $CantEir){
			#Contenedores = EIR's
			//Buscar id Contenedores
			$ids = new DBMySQL();
			$ids->Datosconexion(UDB,PDB,USERDB);
			$sql = sprintf("SELECT id, linea FROM existenciaNew WHERE contenedor IN(%s);",$strCont);
			$ids->Consulta($sql);
			#Comprobar que los contenedores pertenecen a la linea
			if($linea->Filas['nombre'] != $ids->Filas['linea']){
				echo '<link href="../css/estilo.css" rel="stylesheet" type="text/css">';
			die("<h1>Error</h1><p>Esta intentanto hacer una devolucion errada.</p><p>Los Contenedores no pertenecen a la linea o no estan en Inventario.</p>
			<p><a href='devolucion.php'>Regresar</a></p>");
			}
			do {
				$idDev[] = $ids->Filas['id'];
			}while ($ids->Filas = mysqli_fetch_assoc($ids->Consulta));
			#Devolucion
			$devolucion = new DBMySQL();
			$devolucion->Datosconexion(UDB,PDB,USERDB);
			for($i=0; $i<=$CantCont-1; $i++){
				$sql = sprintf("UPDATE inventario SET fdespims = '%s', buqued = %d , viajed = '%s', eir_d = %d, c = 1 WHERE id = %d;",$_POST['fecha'],$_POST['buque'],$_POST['viaje'],$postEirFilter[$i],$idDev[$i]);
				$devolucion->Insertar($sql);
			}
		}
	}
}		
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title><?php echo VERSION; ?></title>
<script type="text/javascript" language="javascript" src="../js/funciones.js"></script>
<link href="../css/estilo.css" rel="stylesheet" type="text/css">
<link href="../css/style.css" rel="stylesheet" type="text/css">
</head>

<body>
<p><a href="../inicio.php">Regresar </a></p>
<h1>Devolucion</h1>
<hr>
<?php if(isset($devolucion) and $devolucion->Afectados > 0){ ?>
<h2>Registro existoso</h2>
<?php } ?>
</body>
</html>