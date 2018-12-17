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
// $linea = new DBMySQL();
// $linea->Datosconexion(UDB,PDB,USERDB);
// $linea->Consulta("SELECT id, nombre FROM lineas WHERE activo = 0;");
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="Ayaguna, Control de Equipos">
  <meta name="author" content="Laymont Arratia">
  <title><?php echo VERSION; ?></title>
  <!--Script-->
  <script src="../js/jquery-1.11.3.min.js"></script>
  <script src="../bootstrap/js/bootstrap.min.js"></script>
  <script src="../bootstrap/validators/validator.min.js"></script>
  <script src="../bootstrap/dialog/js/bootstrap-dialog.min.js"></script>
  <script src="../js/moment.js"></script>
  <script src="../bootstrap/js/jquery.bootstrap-autohidingnavbar.min.js"></script>
  <script src="../js/jquery-ui.min.js"></script>
  <script src="../js/funciones.js"></script>
  <!--Css-->
  <link rel="stylesheet" type="text/css" href="../bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="../bootstrap/css/bootstrap-responsive.min.css">
  <link rel="stylesheet" type="text/css" href="../bootstrap/dialog/css/bootstrap-dialog.min.css">
  <link rel="stylesheet" type="text/css" href="../js/jquery-ui.min.css">
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
                <li class="active"><a href="../inicio.php">Regresar </a></li>
              </ul>
            </div>
          </nav>
        </div>
      </div>

      <div class="row">
        <div class="col-sm-6">
          <h3>Asignacion</h3>
          <form action="#" method="post" name="newEIR" class="form-horizontal" id="formNewEIR" role="form">
            <div class="row">

              <div class="col-sm-4">
                <div class="form-group">
                  <label class="control-label" for="eir">EIR:</label>
                  <input class="form-control" name="eir" type="number" required id="eir" form="formNewEIR">
                </div>
              </div>

              <div class="col-sm-4">
                <div class="form-group">
                  <label class="control-label" for="fecha">Fecha:</label>
                  <input class="form-control" name="fecha" type="date" id="fecha" form="formNewEIR" value="<?php echo AHORAC; ?>" max="<?php echo AHORAC; ?>">
                </div>
              </div>

              <div class="col-sm-4">
                <div class="form-group">
                  <label class="control-label" for="hora">Hora:</label>
                  <input name="hora" type="text" required class="form-control" id="hora" form="formNewEIR">
                </div>
              </div>

            </div>
            <div class="row">
              <div class="col-sm-8">
                <div class="form-group">
                  <label class="control-label" for="consignatario">Consignatario:</label>
                  <input class="form-control" name="strcon" type="text" id="strcon" form="formNewEIR" data-toggle="tooltip" data-placement="auto" title="<?php echo MSJCONSIG; ?>" required>
                  <input name="consignatario" type="hidden" id="consignatario" value="-1">
                </div>
              </div>
              <div class="col-sm-4">
                <div class="form-group">
                  <label class="control-label" for="equipo">Contenedor:</label>
                  <input class="form-control" name="equipo" type="text" required id="equipo" form="formNewEIR" pattern="^([a-zA-Z]{3})([ujz|UJZ]{1})([0-9]{7})$">
                </div>
              </div>

            </div>

            <button name="submit" id="submit" type="submit" form="formNewEIR" class="btn btn-primary" value="Enviar">Enviar</button>

          </form>
        </div>
      </div>

    </div>
  </body>
  <?php $cache->cerrar(); ?>
  </html>