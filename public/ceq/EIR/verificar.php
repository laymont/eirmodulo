<?php
$host = 'localhost';
$usr = 'imssisc';
$pas = '%analema.';
$db = 'imssisc_overseas';
$conexion = mysql_connect($host, $usr, $pas);
mysql_select_db($db, $conexion);
if (isset($_POST['idacta'])) {
  sleep(2);
  $query="SELECT idacta FROM acta_recepcion_cg WHERE anulado = '0' and idacta = '".$_POST['idacta']."'";
  $rs_User = mysql_query($query, $conexion) or die(mysql_error());
  $num_rows=mysql_num_rows($rs_User);
 
  $checking=false;
  $msg="El acta seleccionada esta anulada o no existe";
  if($num_rows<>0){
    $checking=true;
    $msg="El valor es valido, presione buscar para continuar";
  }
 
  $json=array("valid"=>$checking, "msg" => $msg);
 
  echo json_encode($json);
 
}
 
?>