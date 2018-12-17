<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Documento sin título</title>
<style>
body { font: 14px/21px "Lucida Sans", "Lucida Grande", "Lucida Sans Unicode", sans-serif; }
.ingreso_form h2, .ingreso_form label { font-family:Georgia, Times, "Times New Roman", serif; }
.ingreso_form ul {
    width:750px;
    list-style-type:none;
    list-style-position:outside;
    margin:0px;
    padding:0px;
}
.ingreso_form li{
    padding:12px; 
    border-bottom:1px solid #eee;
    position:relative;
}
.ingreso_form li:first-child, .contact_form li:last-child {
    border-bottom:1px solid #777;
}
.ingresp_form h2 {
    margin:0;
    display: inline;
}
.ingreso_notification {
    color:#d45252; 
    margin:5px 0 0 0; 
    display:inline;
    float:right;
}
.ingreso_form label {
    width:150px;
    margin-top: 3px;
    display:inline-block;
    float:left;
    padding:3px;
}
.ingreso_form input {
    height:20px; 
    width:220px; 
    padding:5px 8px;
}
.ingreso_form textarea {padding:8px; width:300px;}
.ingreso_form button {margin-left:156px;}

.ingreso_form input, .contact_form textarea { 
    border:1px solid #aaa;
    box-shadow: 0px 0px 3px #ccc, 0 10px 15px #eee inset;
    border-radius:2px;
}
.ingreso_form input:focus, .contact_form textarea:focus {
    background: #fff; 
    border:1px solid #555; 
    box-shadow: 0 0 3px #aaa; 
}
/* Button Style */
input[type="submit"] {
	background-color: #68b12f;
	background: -webkit-gradient(linear, left top, left bottom, from(#68b12f), to(#50911e));
	background: -webkit-linear-gradient(top, #68b12f, #50911e);
	background: -moz-linear-gradient(top, #68b12f, #50911e);
	background: -ms-linear-gradient(top, #68b12f, #50911e);
	background: -o-linear-gradient(top, #68b12f, #50911e);
	background: linear-gradient(top, #68b12f, #50911e);
	border: 1px solid #509111;
	border-bottom: 1px solid #5b992b;
	border-radius: 3px;
	-webkit-border-radius: 3px;
	-moz-border-radius: 3px;
	-ms-border-radius: 3px;
	-o-border-radius: 3px;
	box-shadow: inset 0 1px 0 0 #9fd574;
	-webkit-box-shadow: 0 1px 0 0 #9fd574 inset;
	-moz-box-shadow: 0 1px 0 0 #9fd574 inset;
	-ms-box-shadow: 0 1px 0 0 #9fd574 inset;
	-o-box-shadow: 0 1px 0 0 #9fd574 inset;
	color: white;
	font-weight: bold;
	padding: 6px 20px;
	text-align: center;
	text-shadow: 0 -1px 0 #396715;
	height: 20px;
}
input[type="submit"]:hover {
    opacity:.85;
    cursor: pointer; 
}
input[type="submit"]:active {
    border: 1px solid #20911e;
    box-shadow: 0 0 10px 5px #356b0b inset; 
    -webkit-box-shadow:0 0 10px 5px #356b0b inset ;
    -moz-box-shadow: 0 0 10px 5px #356b0b inset;
    -ms-box-shadow: 0 0 10px 5px #356b0b inset;
    -o-box-shadow: 0 0 10px 5px #356b0b inset;
}

.ingreso_form input:focus, .ingreso_form textarea:focus { /* add this to the already existing style */
    padding-right:70px;
}
.ingreso_form input, .ingreso_form textarea { /* add this to the already existing style */
    -moz-transition: padding .25s; 
    -webkit-transition: padding .25s; 
    -o-transition: padding .25s;
    transition: padding .25s;
}
.ingreso_form input, .ingreso_form textarea {
    padding-right:30px;
}
input:required, textarea:required {
    background: #fff url(images/red_asterisk.png) no-repeat 98% center;
}
.form_hint, .required_notification { font-size: 11px; }
*:focus {outline: none;}
:-moz-placeholder { color: blue; }
::-webkit-input-placeholder { color: blue; }
</style>
</head>

<body>
<div class="logo"><img title="Control de Contenedores" src="img/logopeq.fw.png" width="120" height="40" alt=""/></div>
<p><a href="#">Regresar</a></p>
<h1>Formulario</h1>
<h2>Ingreso</h2>
<hr>

<table class="recuento">
	<tr>
    	<th>tipo</th>
        <th>cantidad</th>
    </tr>
    <tr>
    	<td scope="strn">20'DC</td>
        <td scope="float">1</td>
    </tr>
    <tr>
    	<td scope="strd">Total:</td>
        <td scope="float">1</td>
    </tr>
</table>
<table class="recuento">
  <tr>
    <th>tipo</th>
    <th>cantidad</th>
  </tr>
  <tr>
    <td scope="strn">20'DC</td>
    <td scope="float">1</td>
  </tr>
  <tr>
    <td scope="strd">Total:</td>
    <td scope="float">1</td>
  </tr>
</table>

<table class="listado">
  <caption>
    Titulo
  </caption>
  <tr>
    <th scope="col">Id</th>
    <th scope="col">Linea</th>
    <th scope="col">Buque</th>
    <th scope="col">Viaje</th>
    <th scope="col">Tipo</th>
    <th scope="col">Contenedor</th>
    <th scope="col">Estatus</th>
    <th scope="col">Condicion</th>
    <th scope="col">EIR</th>
    <th scope="col">Fecha</th>
  </tr>
  <tr>
    <td scope="num">1</td>
    <td scope="strn">ZIM LINE</td>
    <td scope="strn">ZIM KINGSTON</td>
    <td scope="strd">45/W</td>
    <td scope="strd">40'DC</td>
    <td scope="strn">MSKU1234565</td>
    <td scope="strd">EMPTY</td>
    <td scope="strd">OPR2</td>
    <td scope="num">235461</td>
    <td scope="strd">2015-06-10</td>
  </tr>
  <tr>
    <td scope="num">2</td>
    <td scope="strn">ZIM LINE</td>
    <td scope="strn">ZIM KINGSTON</td>
    <td scope="strd">45/W</td>
    <td scope="strd">40'DC</td>
    <td scope="strn">MSKU1234565</td>
    <td scope="strd">EMPTY</td>
    <td scope="strd">OPR2</td>
    <td scope="num">235462</td>
    <td scope="strd">2015-06-10</td>
  </tr>
  <tr>
    <td scope="num">3</td>
    <td scope="strn">ZIM LINE</td>
    <td scope="strn">ZIM KINGSTON</td>
    <td scope="strd">45/W</td>
    <td scope="strd">40'DC</td>
    <td scope="strn">MSKU1234565</td>
    <td scope="strd">EMPTY</td>
    <td scope="strd">OPR2</td>
    <td scope="num">235463</td>
    <td scope="strd">2015-06-10</td>
  </tr>
  <tr>
    <td scope="num">4</td>
    <td scope="strn">ZIM LINE</td>
    <td scope="strn">ZIM KINGSTON</td>
    <td scope="strd">45/W</td>
    <td scope="strd">40'DC</td>
    <td scope="strn">MSKU1234565</td>
    <td scope="strd">EMPTY</td>
    <td scope="strd">OPR2</td>
    <td scope="num">235464</td>
    <td scope="strd">2015-06-10</td>
  </tr>
</table>
<p><span class="alerta">Alerta</span></p>
<form method="post" enctype="multipart/form-data" name="form1" class="ingreso_form" id="form1">
  <fieldset>
    <legend>Nombre Form</legend>
	<ul>
      <li><label for="textfield">Text Field:</label>
      <input type="text" name="textfield" id="textfield"></li>

      <li><label for="password">Password:</label>
      <input type="password" name="password" id="password"></li>

      <li><label for="email">Email:</label>
      <input type="email" name="email" id="email"></li>


      <li><label for="number">Number:</label>
      <input type="number" name="number" id="number"></li>

      <li><label for="date">Date:</label>
      <input type="date" name="date" id="date"></li>

      <li><label for="select2">Select:</label>
      <select name="select2" id="select2">
        <option value="1">Seleccion</option>
      </select></li>

      <li><label for="textarea">Text Area:</label>
      <textarea name="textarea" id="textarea"></textarea><li>

      <li><label for="fileField">File:</label>
      <input type="file" name="fileField" id="fileField"><li>

      <li><input type="submit" name="submit" id="submit" value="Enviar &#xf019;"></li>
</ul>
  </fieldset>
</form>
<p>&nbsp;</p>
<form method="post" name="form2" class="formConsulta" id="form2">
<fieldset>
	<legend>Titulo</legend>
    <label for="select">Etiqueta:</label>
    <select id="select" name="select">
    <option>Seleccion</option>
    </select>
    <input type="checkbox" id="check" name="check">
    <label for="check">Etiqueta</label>
    <input type="checkbox" id="check1" name="check1">
    <label for="check1">Etiqueta</label>
    <input type="submit" name="submit2" id="submit2" value="Ver &#xf002;">
</fieldset>
</form>
<p>&nbsp;</p>
<table class="expor1">
	<tr>
    	<th>Id</th>
    	<th>Linea</th>
    	<th>Buque</th>
    	<th>Viaje</th>
    	<th>Contenedor</th>
    </tr>
    <tr>
    	<td>&nbsp;</td>
    	<td>&nbsp;</td>
    	<td>&nbsp;</td>
    	<td>&nbsp;</td>
    	<td>&nbsp;</td>
    </tr>
</table>
<table class="expor1">
	<tr>
    	<th>Id</th>
    	<th>Linea</th>
    	<th>Buque</th>
    	<th>Viaje</th>
    	<th>Contenedor</th>
    </tr>
    <tr>
    	<td>&nbsp;</td>
    	<td>&nbsp;</td>
    	<td>&nbsp;</td>
    	<td>&nbsp;</td>
    	<td>&nbsp;</td>
    </tr>
</table>
<table class="expor">
  <caption>
    Listado
  </caption>
  <tr>
    <th scope="col">Id</th>
    <th scope="col">Linea</th>
    <th scope="col">Buque</th>
    <th scope="col">Viaje</th>
    <th scope="col">Contenedor</th>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<p>&nbsp;</p>
</body>
</html>