<?php
session_start();
session_name($_SESSION['variables']['usuario']);
require_once('../config.php');
#Seguridad
$seguridad = new Seguridad();
$seguridad->ValidarUsuario();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Importar</title>
<!--Script-->
<script type="text/javascript" src="../js/jquery-1.11.3.min.js"></script>
<script type="text/javascript" src="../bootstrap/js/bootstrap.min.js"></script>

<!--Css-->
<link rel="stylesheet" type="text/css" href="../bootstrap/css/bootstrap.min.css"/>
<link rel="stylesheet" type="text/css" href="../bootstrap/css/bootstrap-responsive.min.css"/>
</head>

<body>
<div class="container">
 <div class="row">
  <div class="col-sm-12">
   <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
    <div class="navbar-header">
     <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1"> <span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span> </button>
     <a class="navbar-brand" href="#"><span class="text-primary">Ayaguna</span></a>
    </div>
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
     <ul class="nav navbar-nav">
      <li class="active"><a href="../inicio.php">Regresar</a></li>
      <p class="navbar-text navbar-right"> <small class="text-info"><?php echo $_SESSION['variables']['nomdb']; ?></small></p>
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
 <!--cuerpo html-->
 <div class="row">
  <div class="col-sm-6">
   <form class="form-inline" action="upload.php" method="post" enctype="multipart/form-data" role="form">
    <fieldset>
     <legend>Seleccionar/Archivo</legend>
     <input class="form-control" type="hidden" name="MAX_FILE_SIZE" value="5242880">
     Subir este archivo: <br>
     <input class="form-control" name="userfile" type="file">
     <button type="submit" class="btn btn-primary">Importar</button>
    </fieldset>
   </form>
  </div>
 </div>
</div>
</body>
</html>