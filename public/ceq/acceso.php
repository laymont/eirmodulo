<?php
// require_once "clases/recaptchalib.php";
// if($_SERVER["HTTPS"] != "on")
// {
//   header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
//   exit();
// }
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Acceso</title>
  <meta name="description" content="Ayaguna, Control de Equipos">
  <meta name="author" content="Laymont Arratia">
  <link href="bootstrap/css/bootstrap.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap-social.css">
  <link href="bootstrap/css/style.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap-responsive.css" />
  <link rel="stylesheet" type="text/css" href="css/font-awesome.min.css">
  <style>
  body {
   font-family: Segoe, "Segoe UI", "DejaVu Sans", "Trebuchet MS", Verdana, sans-serif;
   background: #c3cfdd;
 }
 .buffer {
   margin-top: 120px;
 }
 legend small {
   font-size: 0.6em;
   font-style: italic;
 }
</style>
<script type="text/javascript" src="js/jquery-1.11.3.min.js"></script>
<script type="text/javascript" src="bootstrap/js/bootstrap.js"></script>
<script src="bootstrap/validators/validator.min.js"></script>
<script src="https://www.google.com/recaptcha/api.js?hl=es-419"></script>
<script src="js/jquery.browser.min.js"></script>
<script src='https://www.google.com/recaptcha/api.js'></script>
</head>
<body class="fondo">
  <script>
   $(document).ready(function() {
    if ( !$.browser.webkit ) {
     $('#msjChrome').removeClass('hidden');

   }
 });
</script>
<div class="container-fluid">
  <div class="row  buffer" id="firtsRow">
    <div class="col-sm-12">
      <p class="text-center text-primary lead hidden" id="msjChrome">Optimizado para Google Chrome <a href="https://www.google.es/chrome/" target="_blank" class="btn btn-social-icon btn-dropbox"><span class="fa fa-chrome"></span></a></p>
    </div>
  </div>
  <div class="row">
    <div class="col-sm-4 col-sm-offset-4">
      <form action="acceso_s1.php" role="form" method="post">
        <legend class="text-info">Acceso <br><small>Sistema de Control de Equipo Ayaguna</small></legend>
        <div class="form-group form-group-lg">
          <div class="input-group">
            <div class="input-group-addon"><span class="glyphicon glyphicon-user"></span></div>
            <input name="usuario" type="text" required="required" class="form-control" id="usuario" placeholder="Usuario">
          </div>
        </div>
        <div class="form-group form-group-lg">
          <div class="input-group">
            <div class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></div>
            <input name="clave" type="password" required="required" class="form-control" id="clave" placeholder="Clave">
          </div>
        </div>
        <!-- <div class="g-recaptcha" data-sitekey="6Leo5iMTAAAAAEc73g7zIbC47E3fjggscrLR27n0"></div> -->
        <button class="btn btn-primary btn-lg" type="submit" id="submit" name="submit" value="true"> Ingresar </button>
      </form>
    </div>
  </div>
</div>
</body>
</html>