<?php
session_start();
session_name($_SESSION['variables']['usuario']);
require_once('../config.php');
require_once('../clases/class_Conexion.php');
require_once('../funciones/funciones.php');
#Seguridad
$seguridad = new Seguridad();
$seguridad->ValidarUsuario();

#Linea
$linea = new DBMySQL();
$linea->Datosconexion(UDB,PDB,USERDB);
$linea->Consulta("SELECT id, nombre FROM lineas WHERE activo = 0;");
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title><?php echo VERSION; ?></title>
<script src="../js/jquery-1.11.1.js"></script>
<script src="../js/jquery-ui.js"></script>

<script>
$(document).ready(function(){
     $("#linea").change(function () {
        $("#linea option:selected").each(function () {
           elegido=$(this).val();
           $.post("buques.php", { elegido: elegido }, function(data){
              $("#buque").html(data);
              $("#viaje").html("");
           });
        });
     })
  });

  
$(document).ready(function(){
	$('#contenedores').css('text-transform','uppercase');
	$('[data-toggle="popover"]').popover();
});  
</script>
<link rel="stylesheet" type="text/css" href="../bootstrap/css/bootstrap.css">
<link rel="stylesheet" type="text/css" href="../bootstrap/css/bootstrap-responsive.css" />
<script type="text/javascript" src="../bootstrap/js/bootstrap.js"></script>
</head>

<body>
<div class="container">

<div class="row">
    <div class="col-sm-12">
      <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1"> <span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span> </button>
          <a class="navbar-brand" href="#"><span class="text-primary">Ayaguna</span></a> </div>
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
          <ul class="nav navbar-nav">
            <li class="active"><a href="../inicio.php">Regresar</a></li>
            <!--<li><a href="inventarioExp.php" id="exportar">Exportar</a></li>-->
          </ul>
        </div>
      </nav>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <h3>&nbsp; </h3>
    </div>
  </div>

  <div class="row">
    <div class="col-sm-6 col-xs-offset-1">
      <form action="devolucion2.php" method="post" name="formAsig" class="form-horizontal" id="formAsig">
        <h3>Devolucion</h3>
        <div class="row">
            <div class="form-group col-sm-4">
            <label class="control-label" for="linea">Linea:</label>
            <select class="form-control" name="linea" id="linea" required tabindex="1">
              <option value="">Seleccion</option>
              <?php do{ ?>
              <option value="<?php echo $linea->Filas['id'];?>"><?php echo $linea->Filas['nombre'];?></option>
              <?php }while ($linea->Filas = mysqli_fetch_assoc($linea->Consulta)); ?>
            </select>
            </div>
            <div class="form-group col-sm-4">
            <label class="control-label" for="buque">Buque:</label>
            <select class="form-control" name="buque" id="buque" required tabindex="2">
            	<option>Seleccion</option>
            </select>
            </div>
            <div class="form-group col-sm-4">
            <label class="control-label" for="viaje">Viaje:</label>
            <input class="form-control" name="viaje" type="text" required id="viaje" placeholder="Numero de Viaje" tabindex="3">
            </div>
        </div>
        <div class="row">
            <div class="form-group col-sm-4">
            <label class="control-label" for="fecha">Fecha:</label>
            <input class="form-control" name="fecha" type="date" required id="fecha" max="<?php echo AHORAC ?>" tabindex="4">
            </div>
        </div>
        <div class="row">
            <div class="form-group col-sm-7">
            <label class="control-label" for="contenedores">Contenedores:</label>
            <textarea class="form-control" name="contenedores" cols="40" rows="4" required id="contenedores" placeholder="numeros separados por coma (,)" data-toggle="popover" data-placement="auto" title="Contenedores" data-content="Ingrese los numeros de contenedores separados por coma (,) no deje espacios en blanco." data-bv-notempty data-bv-notempty-message="Indique/Contenedor(es)." tabindex="5"></textarea>
            </div>
        </div>
        <div class="row">
            <div class="form-group  col-sm-7">
            <label class="control-label" for="eir_d">EIR's/Salida:</label>
            <textarea class="form-control" name="eir_d" cols="40" rows="4" id="eir_d" placeholder="numeros separados por coma (,)" data-toggle="popover" data-placement="auto" title="EIR" data-content="Ingrese los numeros de EIR de cada contenedor separado por coma(,). Si no indica EIR se usaran los numeros de EIR de entrada no deje espacios en blanco." tabindex="6"></textarea>
            </div>
        </div>
        
        <div class="form-group">
        <button class="btn btn-success" type="submit" name="submit" id="submit" value="Enviar" tabindex="7">Guardar </button>
        </div>
      </form>
    </div>
  </div>
</div>
<?php $cache->cerrar(); ?>
</body>
</html>