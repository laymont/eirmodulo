<?php
session_start();
session_name($_SESSION['variables']['usuario']);
require_once('../config.php');
require_once('../clases/class_Conexion.php');
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title><?php echo VERSION; ?></title>
<style type="text/css">
@import url("../css/stylesheet.css");

body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
	height: 0px;
	font-family: "Gill Sans", "Gill Sans MT", "Myriad Pro", "DejaVu Sans Condensed", Helvetica, Arial, sans-serif, fontawesome;
}
header {
	background-image: -webkit-linear-gradient(270deg,rgba(188,204,255,1.00) 0%,rgba(0,128,192,1.00) 100%);
	background-image: -moz-linear-gradient(270deg,rgba(188,204,255,1.00) 0%,rgba(0,128,192,1.00) 100%);
	background-image: -o-linear-gradient(270deg,rgba(188,204,255,1.00) 0%,rgba(0,128,192,1.00) 100%);
	background-image: linear-gradient(180deg,rgba(188,204,255,1.00) 0%,rgba(0,128,192,1.00) 100%);
	height: 40px;
	text-indent: 10px;
	color: #FFFFFF;
	padding-top: 2px;
	padding-right: 2px;
	padding-bottom: 2px;
	padding-left: 2px;
}
header span {
	margin-left: 20px;
	color: #050D9B;
}
nav {
	width: 100%;
	float: left;
	margin-bottom: 10px;
	font-family: fontawesome;
}
.menu {
	margin-right: auto;
	margin-left: auto;
}
.menu ul { list-style: none; }
.menu ul li {
	float: left;
	position: relative;
	width: auto;
	display: inline;
	margin-left: 5px;
	margin-right: 5px;
}
.menu ul li a {
	text-decoration: none;
	color: #1C2442;
	padding-top: 4px;
	padding-right: 4px;
	padding-bottom: 4px;
	padding-left: 4px;
}
.menu ul li a::before {
	margin-left: 5px;
	margin-right: 2px;
	content: "\f114";
}
.menu ul li #salir::before, ul li #salir:hover::before{
	margin-left: 5px;
	margin-right: 2px;
	content: "\f08b";
}
.menu ul li a:hover {
	background-color: #0080C0;
	color: #FFFFFF;
}
.menu ul li a:hover::before {
	margin-left: 5px;
	margin-right: 2px;
	content: "\f115";
}
section {
	width: 100%;
	margin-right: auto;
	margin-left: auto;
	margin-top: 10px;
}

</style>
<link rel="stylesheet" type="text/css" href="../fontawesome/css/font-awesome.min.css" />
</head>

<body>
<header><?php echo VERSION; ?><span><?php echo AHORAC; ?></span></header>
<nav class="menu">
<ul>
    <li><a href="#">General</a></li>
    <li><a href="#">Estatus</a></li>
    <li><a href="#">Condicion</a></li>
    <li><a href="#">Patio</a></li>
    <li><a href="#">Ingresos</a></li>
    <li><a href="#">Egresos</a></li>
    <li><a id="salir" href="../salir.php">Salir</a></li>
</ul>
</nav>
<section><?php include('../includes/info.php');?></section>
<footer><?php include('../includes/pie.php');?></footer>
</body>
</html>