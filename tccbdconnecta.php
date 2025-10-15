<?php
// Dependendo de onde estiver seu código:
//$conn = mysqli_connect("localhost","23395", "EtK193@", "23395");
//$conn = mysqli_connect("172.16.0.8","23395", "EtK193@", "23395");
//$conn = mysqli_connect("localhost","seuRMlogin", "senhaAqui", "seuRM_BD");
//$conn = mysqli_connect("ipDo000webhost","seuRMlogin", "senhaAqui", "seulogin_BD");

$conn = mysqli_connect("localhost","23395", "EtK193@", "23395");
if(!$conn) {
	die("Não foi possível conectar ao Banco de Dados!");

}
else { 
	echo(""); /*Conseguiu conexão!*/
}

// Ajustar TimeZone
date_default_timezone_set('Brazil/East');
// Ajustar caracteres globais
mysqli_query($conn, "SET NAMES 'utf8'");
?>