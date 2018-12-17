<?php 
session_start();

	if(!empty($_SESSION['dannos'])){
		$result = array_unique($_SESSION['dannos']);
		echo "<ul>";
		foreach ($result as $valor){
			echo "<li>Daño: $valor</li>"; 
		}
		echo "</ul>";
	} 
//unset($_SESSION['dannos']);
//header('location:../index_cont.php');
?>