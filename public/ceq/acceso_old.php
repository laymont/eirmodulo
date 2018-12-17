<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Acceso</title>
<style>
body {
	background-repeat: no-repeat;
	background-color: #87CEEB;
	background-image: -webkit-linear-gradient(270deg,rgba(80,155,225,1.00) 0%,rgba(135,206,235,1.00) 100%);
	background-image: -moz-linear-gradient(270deg,rgba(80,155,225,1.00) 0%,rgba(135,206,235,1.00) 100%);
	background-image: linear-gradient(180deg,rgba(80,155,225,1.00) 0%,rgba(135,206,235,1.00) 100%);
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
	margin-left: 0px;
	font-family: "Lucida Grande", "Lucida Sans Unicode", "Lucida Sans", "DejaVu Sans", Verdana, sans-serif, fontawesome;
	color: #BBBBBB;
}


form {
	margin-right: auto;
	margin-left: auto;
	width: 400px;
	margin-top: 120px;
}

fieldset {
	border-radius: 10px;
	padding-top: 10px;
	padding-right: 10px;
	padding-bottom: 10px;
	padding-left: 10px;
	background-color: #FFFFFF;
	border-collapse: collapse;
	border-color: #87CEEB;
	border-width: 1px;
	margin-right: auto;
	margin-left: auto;
	height: 300px;
}
fieldset p {
	font-size: small;
	text-align: center;
}
ul { list-style: none; }
ul li {
	display: block;
	margin-top: 4px;
	margin-bottom: 4px;
	padding-top: 8px;
	padding-bottom: 8px;
}

form label {
	width: 40px;
	display: block;
	float: left;
	text-align: center;
	background-color: #87CEEB;
	padding-top: 4px;
	padding-right: 4px;
	padding-bottom: 4px;
	padding-left: 4px;
	border-top-left-radius: 5px;
	border-bottom-left-radius: 5px;
	margin-left: 30px;
	color: #FFFFFF;
}
form input {
	padding-top: 4px;
	padding-right: 4px;
	padding-bottom: 4px;
	padding-left: 4px;
	border-top-right-radius: 5px;
	border-bottom-right-radius: 5px;
	border: 1px solid #C4BFBF;
	height: 20px;
}
form input[type="submit"]{
	padding-top: 4px;
	padding-right: 10px;
	padding-bottom: 4px;
	padding-left: 10px;
	border-radius: 4px;
	height: 30px;
	margin-left: 30px;
	font-family: fontawesome, "Gill Sans", "Gill Sans MT", "Myriad Pro", "DejaVu Sans Condensed", Helvetica, Arial, sans-serif;
	background-color: #08DB4E;
	color: #FFFFFF;
	font-size: large;
	background-image: -webkit-linear-gradient(0deg,rgba(5,144,29,1.00) 0%,rgba(8,219,78,1.00) 100%);
	background-image: -moz-linear-gradient(0deg,rgba(5,144,29,1.00) 0%,rgba(8,219,78,1.00) 100%);
	background-image: -o-linear-gradient(0deg,rgba(5,144,29,1.00) 0%,rgba(8,219,78,1.00) 100%);
	background-image: linear-gradient(90deg,rgba(5,144,29,1.00) 0%,rgba(8,219,78,1.00) 100%);
}
form input[type="submit"]:hover {
	cursor: pointer;
}
</style>
<link rel="stylesheet" type="text/css" href="fontawesome/css/font-awesome.min.css" />
</head>

<body>
<form action="acceso_s1.php" method="post" name="login" id="login">
<fieldset>
<p align="center"><img src="img/logopeq.fw.png" width="120" height="40" alt=""/></p>
<ul>
  <li>
    <label for="usuario"><i class="fa fa-user"></i></label>
    <input name="usuario" type="text" id="usuario" form="login" placeholder="Usuario">
  </li>
  <li>
    <label for="clave"><i class="fa fa-key"></i></label>
    <input name="clave" type="password" id="clave" form="login" placeholder="Clave">
  </li>
  <li>
    <input name="submit" type="submit" id="submit" form="login" value="Entrar &#xf090;">
  </li>
</ul>  
  <hr>
<p>Introduzca su nombre de Usuario y Clave.</p>  
  </fieldset>
</form>
</body>
</html>