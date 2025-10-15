<?php
session_start();
require("tccbdconnecta.php");

$idObra = $_POST['id-obra'] ?? null;
$idUsuario = $_POST['id-usuario-logado'] ?? null;
$nomeObra = $_POST['nomeObra'] ?? null;
$categoria = $_POST['categoria'] ?? null;

if (!$conn) {
    die("Erro de conexão com o banco de dados: " . mysqli_error($conn));
}

$sql = "DELETE FROM tcc_obra WHERE idObra = ?";
$stmt = mysqli_prepare($conn, $sql);

if (!$stmt) {
    die("Erro ao preparar a consulta: " . mysqli_error($conn));
}

mysqli_stmt_bind_param($stmt, "i", $idObra);
mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);
mysqli_close($conn);

$_SESSION['confirmarDelete'] = true;

header("Location: perfil_pessoal.php?login=" . urlencode($loginUsu) . "&categoria=" . urlencode($categoria));
exit;
?>
