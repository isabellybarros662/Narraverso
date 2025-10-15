<?php
session_start();
require("tccbdconnecta.php");

$idComentario = $_POST['id-comentario'] ?? null;
$idUsuarioComentario = $_POST['id-usuario-comentario'] ?? null;
$idUsuarioLogado = $_SESSION['id'] ?? null;
$nomeObra = $_POST['nomeObra'] ?? null;
$categoria = $_POST['categoria'] ?? null;
$selectDenunciar = $_POST['selectDenunciar'] ?? null;
$textoDenuncia = $_POST['textoDenuncia'] ?? null;


if (!isset($_SESSION['$errosObrigatorios'])) {
    $_SESSION['errosObrigatorios'] = [];
}

if(!$idComentario || !$idUsuarioComentario || !$idUsuarioLogado || !$selectDenunciar || !$textoDenuncia) {
    $_SESSION['errosObrigatorios'][] = "Todos os campos, devem estar preenchidos obrigatoriamente.";
}

// Conexão
if(!$conn) {
    die("Erro de conexão com o banco de dados: " . mysqli_connect_error());
}


// Verifica se há erros e redireciona
if (!empty($_SESSION['errosObrigatorios'])) {
    header("Location: obras.php?erro=1&nome=" . urlencode($nomeObra) . "&categoria=" . urlencode($categoria));
    exit;
}

// SQL corrigido
$sql = "INSERT INTO tcc_denunciar_comentario 
        (idComentario, idUsuarioComentario, idUsuarioLogado, nome, categoria, tipoDenuncia, justificativa) 
        VALUES (?, ?, ?, ?, ?, ?, ?)";

$stmt = mysqli_prepare($conn, $sql);

if(!$stmt) {
    die("Erro ao preparar a consulta: " . mysqli_error($conn));
}


if(!mysqli_stmt_bind_param($stmt, "iiissss", $idComentario, $idUsuarioComentario, $idUsuarioLogado, $nomeObra, $categoria, $selectDenunciar, $textoDenuncia)) {
    die("Erro ao vincular dados: " . mysqli_error($conn));
}

// Executa
if(!mysqli_stmt_execute($stmt)) {
    die("Erro ao executar: " . mysqli_error($conn));
} else {
    header("Content-Type: text/html; charset=UTF-8");
	$_SESSION['sucessoDenuncia'] = true;
    header("Location: obras.php?nome=" . urlencode($nomeObra) . "&categoria=" . urlencode($categoria));
    exit;
}

mysqli_stmt_close($stmt);
mysqli_close($conn);
?>
