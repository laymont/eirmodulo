<?php
require_once(RAIZ . "config.php");
require_once(CLASES . 'class_Conexion.php');

#Funciones
#Menu Linea
function MenuLinea(){
	$lineas = new DBMySQL();
	$lineas->Datosconexion(UDB,PDB,USERDB);
	$sql = "SELECT id, nombre FROM lineas WHERE activo = 0;";
	$lineas->Consulta($sql);
	if($lineas->Num_resultados > 0){
		//Select->Lineas
			echo '<label for="select">Lineas:</label>
					<select name="lineas" id="lineas">';
			echo '<option value="">Seleccion</option>';
			do {
				if($_POST['lineas'] == $lineas->Filas['id']){
					echo '<option value="'. $lineas->Filas['id'] . '" selected="selected">' . $lineas->Filas['nombre'] . '</option>';
				}else {
					echo '<option value="'. $lineas->Filas['id'] . '">' . $lineas->Filas['nombre'] . '</option>';
				}
			}while ($lineas->Filas = mysqli_fetch_assoc($lineas->Consulta)); 
			echo '</select>';
	}
	$lineas->Liberar();			
}

function MenuLineaStr(){
	$lineas = new DBMySQL();
	$lineas->Datosconexion(UDB,PDB,USERDB);
	$sql = "SELECT id, nombre FROM lineas WHERE activo = 0;";
	$lineas->Consulta($sql);
	if($lineas->Num_resultados > 0){
		//Select->Lineas
			echo '<label class="control-label" for="lineas">Lineas:</label>
					<select class="form-control" name="lineas" required id="lineas">';
			echo '<option value="'. NULL .'">Seleccion</option>';
			do {
				if($_POST['lineas'] == $lineas->Filas['nombre']){
					echo '<option value="'. $lineas->Filas['nombre'] . '" selected="selected">' . $lineas->Filas['nombre'] . '</option>';
				}else {
					echo '<option value="'. $lineas->Filas['nombre'] . '">' . $lineas->Filas['nombre'] . '</option>';
				}
			}while ($lineas->Filas = mysqli_fetch_assoc($lineas->Consulta)); 
			echo '</select>';
	}
	$lineas->Liberar();			
}

function MenuPatiosStr(){
	$patios = new DBMySQL();
	$patios->Datosconexion(UDB,PDB,USERDB);
	$sql = "SELECT patio FROM existenciaNew GROUP BY patio ORDER BY patio;";
	$patios->Consulta($sql);
	if($patios->Num_resultados > 0){
		//Select->Lineas
			echo '<select class="form-control" name="patios" required id="patios" required>';
			echo '<option value="">Seleccion/Patios</option>';
			do {
				if($_POST['patios'] == $patios->Filas['patio']){
					echo '<option value="'. $patios->Filas['patio'] . '" selected="selected">' . $patios->Filas['patio'] . '</option>';
				}else {
					echo '<option value="'. $patios->Filas['patio'] . '">' . $patios->Filas['patio'] . '</option>';
				}
			}while ($patios->Filas = mysqli_fetch_assoc($patios->Consulta)); 
			echo '</select>';
	}
	$patios->Liberar();			
}

function MenuConsignatario(){
	$consignatarios = new DBMySQL();
	$consignatarios->Datosconexion(UDB,PDB,USERDB);
	$sql = "SELECT id, nombre FROM consignatario WHERE nombre REGEXP '[[:alnum:]_[:digit:]]{1,50}' ORDER BY nombre;";
	$consignatarios->Consulta($sql);
	echo '<label for="consignatario">Patios:</label>
			<select name="consignatario" required id="consignatario">';
	echo '<option value="-1">Seleccion</option>';
	do {
		echo '<option value="'.$consignatarios->Filas['id'].'">'.$consignatarios->Filas['nombre'].'</option>';
	} while($consignatarios->Filas = mysqli_fetch_assoc($consignatarios->Consulta));
	echo '</select>';
	
}

function MenuTipos(){
	$tipos = new DBMySQL();
	$tipos->Datosconexion(UDB,PDB,USERDB);
	$sql = "SELECT id, tipo FROM tequipos WHERE id NOT IN(13,14,16,17) ORDER BY tipo ASC;";
	$tipos->Consulta($sql);
	echo '<select class="form-control" name="tipo" id="tipo" required data-error="Seleccione el Tipo/Contenedor">';
	echo '<option value="">Tipo</option>';
	do {
		echo '<option value="'.$tipos->Filas['id'].'">'.$tipos->Filas['tipo'].'</option>';
	} while($tipos->Filas = mysqli_fetch_assoc($tipos->Consulta));
	echo '</select>';
}

#Condiciones
function Condiciones($con){
	$tipos[0] = 'DMG';
	$tipos[1] = 'OPR1';
	$tipos[2] = 'OPR2';
	$tipos[3] = 'OPR3';
	$tipos[4] = 'DMG';
	if($con == 0 or $con == 4){
		echo "<span style='color:#DC143C;'>" . $tipos[$con] . "</span>";
	}else {
		echo "<span style='color:#008B00;'>" . $tipos[$con] . "</span>";
	}
}

function Condiciones2($con){
	$tipos[0] = 'DMG';
	$tipos[1] = 'OPR1';
	$tipos[2] = 'OPR2';
	$tipos[3] = 'OPR3';
	$tipos[4] = 'DMG';
	if($con == 0 or $con == 4){
		return "<span style='color:#DC143C;'>" . $tipos[$con] . "</span>";
	}else {
		return "<span style='color:#008B00;'>" . $tipos[$con] . "</span>";
	}
}

#Estatus
function Estatus($sts){
	if(isset($sts)){
		$estatus[0] = 'EMPTY';
		$estatus[1] = 'FULL';
		echo $estatus[$sts];
	}
}

#Estatus
function Estatus2($sts){
	if(isset($sts)){
		$estatus[0] = 'EMPTY';
		$estatus[1] = 'FULL';
		return $estatus[$sts];
	}
}

#Formato monto
function Monto($mnt){
	$cifra = number_format($mnt,'2',',','.');
	echo $cifra;
}

#Restar fechas
function FechaDif($f1,$f2){
	$fecha1 = date_create($f1);
	$fecha2 = date_create($f2);
	$diferencia = date_diff($fecha1, $fecha2);
	echo $diferencia->format('%a');
}
?>