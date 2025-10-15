<?php
session_start();
require('tccbdconnecta.php');

if (!isset($_SESSION['id']) || !isset($_POST['seguido_id'])) {
    die("Erro transferência de id!");
}

$seguidor_id = $_SESSION['id'];
$seguido_id = intval($_POST['seguido_id']);

if ($seguidor_id == $seguido_id) {
    echo "Não pode seguir a si mesmo.";
    exit;
}

// Verifica se já está seguindo
$sql = "SELECT * FROM tcc_seguidores WHERE seguidor_id = ? AND seguido_id = ?";
$stmt = mysqli_prepare($conn, $sql);

if (!$stmt) {
	die("erro ao preparar a consulta");
}


if(!mysqli_stmt_bind_param($stmt, "ii", $seguidor_id, $seguido_id)){
	die("Erro ao véncular parâmetros!");
}

if(!mysqli_stmt_execute($stmt)) {
	die("Erro ao executar a consulta!");
}
mysqli_stmt_store_result($stmt);

if (mysqli_stmt_num_rows($stmt) > 0) {
    echo "Já está seguindo.";
    exit;
}

// Insere seguidor
$sql2 = "INSERT INTO tcc_seguidores (seguidor_id, seguido_id) VALUES (?, ?)";
$stmt2 = mysqli_prepare($conn, $sql2);

if (!$stmt2) {
	die("Erro ao preparar a consulta");
}

if (!mysqli_stmt_bind_param($stmt2, "ii", $seguidor_id, $seguido_id)){
 	die("Erro ao vincular parâmetros!");
}

if (!mysqli_stmt_execute($stmt2)){
	die("Erro ao executar!");
}

$sql3 = "UPDATE tcc_pessoa SET seguidores = IFNULL(seguidores, 0) + 1 WHERE id = ?";
$stmt3 = mysqli_prepare($conn, $sql3);

if (!$stmt3) {
	die("erro ao preparar a consulta");
}

if (!mysqli_stmt_bind_param($stmt3, "i", $seguido_id)) {
	die ("Erro ao vicular parâmetros!");
}

if (!mysqli_stmt_execute($stmt3)){
	die("Erro ao executar!");
}


$sql4 = "UPDATE tcc_pessoa SET seguindo = IFNULL(seguindo, 0) + 1 WHERE id = ?";
$stmt4 = mysqli_prepare($conn, $sql4);

if (!$stmt4) {
	die("Erro ao preparar a consulta!");
}

if (!mysqli_stmt_bind_param($stmt4, "i", $seguidor_id)) {
	die ("Erro ao vincular parâmetros");
}

if (!mysqli_stmt_execute($stmt4)){
	die("Erro ao executar");
}

echo "ok";
exit;
