<?php
session_start();

require("tccbdconnecta.php");

if(!isset($_SESSION['id'])){
	header("Location: obras.php?erro=loginnecessario");
	exit;
}

$usuarioLogado = isset($_SESSION['id']);
$comentario = isset($_POST['comentario']) ? $_POST['comentario'] : '';
$idUsuario = isset($_SESSION['id']) ? $_SESSION['id'] : '';
$nomeObra = isset($_POST['nomeObra']) ? $_POST['nomeObra'] : '';
$categoria = isset($_POST['categoria']) ? $_POST['categoria'] : '';

if (!empty($comentario)){
	$sql = "INSERT INTO tcc_comentario (idUsuario, nomeObra, categoria, comentario) VALUES (?, ?, ?, ?)";
	$stmt = mysqli_prepare($conn, $sql);
	if(!mysqli_stmt_bind_param($stmt, "isss", $idUsuario, $nomeObra, $categoria, $comentario)){
		die("Problema ao víncular dados");
	}
	if(!mysqli_stmt_execute($stmt)){
		die("Problema ao fazer a execução");
	}

	mysqli_stmt_close($stmt);
	mysqli_close($conn);

	header("Location: obras.php?nome=" . urlencode($nomeObra) . "&categoria=" . urlencode($categoria));
	exit;
} else {
	$_SESSION['errosObrigatorios'] = "É necessário comentar antes!";
	header("Location: obras.php?erro=1");
	exit;
}
?>