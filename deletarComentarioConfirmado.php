<?php
session_start();
require("tccbdconnecta.php");

$idComentario = $_POST['id-comentario'] ?? null;
$nomeObra = $_POST['nomeObra'] ?? null;
$categoria = $_POST['categoria'] ?? null;

if (!$conn) {
    die("Erro de conexão com o banco de dados: " . mysqli_error($conn));
}

$sql = "DELETE FROM tcc_comentario WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);

if (!$stmt) {
    die("Erro ao preparar a consulta: " . mysqli_error($conn));
}

mysqli_stmt_bind_param($stmt, "i", $idComentario);
mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);
mysqli_close($conn);

$_SESSION['confirmarDelete'] = true;

header("Location: obras.php?nome=" . urlencode($nomeObra) . "&categoria=" . urlencode($categoria));
exit;
?>
