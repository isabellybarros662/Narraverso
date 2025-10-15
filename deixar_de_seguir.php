<?php
session_start();
require('tccbdconnecta.php');

if (!isset($_SESSION['id']) || !isset($_POST['seguido_id'])) {
    http_response_code(400);
    echo "Dados inválidos.";
    exit;
}

$seguidor_id = $_SESSION['id'];
$seguido_id = intval($_POST['seguido_id']);

// Remove seguidor
$sql = "DELETE FROM tcc_seguidores WHERE seguidor_id = ? AND seguido_id = ?";
$stmt = mysqli_prepare($conn, $sql);

if (!$stmt) {
	die("Erro ao preparar a consulta");
}

if (!mysqli_stmt_bind_param($stmt, "ii", $seguidor_id, $seguido_id)){
	die ("Erro ao vincular parâmetros!");
}

if (!mysqli_stmt_execute($stmt)) {
    die("Erro ao executar");
}



$sql2 = "UPDATE tcc_pessoa SET seguidores = seguidores - 1 WHERE id = ?";
$stmt2 = mysqli_prepare($conn, $sql2);

if (!$stmt2) {
	die("erro ao preparar a consulta");
}

if (!mysqli_stmt_bind_param($stmt2, "i", $seguido_id)) {
	die ("Erro ao vicular parâmetros!");
}

if (!mysqli_stmt_execute($stmt2)){
	die("Erro ao executar!");
}


$sql3 = "UPDATE tcc_pessoa SET seguindo = seguindo - 1 WHERE id = ?";
$stmt3 = mysqli_prepare($conn, $sql3);

if (!$stmt3) {
	die("Erro ao preparar a consulta!");
}

if (!mysqli_stmt_bind_param($stmt3, "i", $seguidor_id)) {
	die ("Erro ao vincular parâmetros");
}

if (!mysqli_stmt_execute($stmt3)){
	die("Erro ao executar");
}
