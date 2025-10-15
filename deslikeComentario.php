<?php
session_start();
require('tccbdconnecta.php');

if (!isset($_SESSION['id']) || !isset($_POST['deslike_id'])) {
    http_response_code(400);
    echo "Dados inválidos.";
    exit;
}

$usuarioId = $_SESSION['id'];
$comentarioId = intval($_POST['deslike_id']);

$sql = "SELECT tipo FROM tcc_votos_comentario WHERE idUsuario = ? AND idComentario = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "ii", $usuarioId, $comentarioId);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $tipoExistente);
mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt);

if ($tipoExistente === 'deslike') {
    echo "ok";
    exit;
}

mysqli_begin_transaction($conn);

try {
    if ($tipoExistente === 'like') {
        // Remove like
        $sql1 = "UPDATE tcc_comentario SET curtida_positiva = GREATEST(curtida_positiva - 1, 0) WHERE idPrimária = ?";
        $stmt1 = mysqli_prepare($conn, $sql1);
        mysqli_stmt_bind_param($stmt1, "i", $comentarioId);
        mysqli_stmt_execute($stmt1);
        mysqli_stmt_close($stmt1);

        // Atualiza tipo para deslike
        $sql2 = "UPDATE tcc_votos_comentario SET tipo = 'deslike' WHERE idUsuario = ? AND idComentario = ?";
        $stmt2 = mysqli_prepare($conn, $sql2);
        mysqli_stmt_bind_param($stmt2, "ii", $usuarioId, $comentarioId);
        mysqli_stmt_execute($stmt2);
        mysqli_stmt_close($stmt2);
    } else {
        // Inserir novo voto
        $sql3 = "INSERT INTO tcc_votos_comentario (idUsuario, idComentario, tipo) VALUES (?, ?, 'deslike')";
        $stmt3 = mysqli_prepare($conn, $sql3);
        mysqli_stmt_bind_param($stmt3, "ii", $usuarioId, $comentarioId);
        mysqli_stmt_execute($stmt3);
        mysqli_stmt_close($stmt3);
    }

    // Incrementa curtida_negativa
    $sql4 = "UPDATE tcc_comentario SET curtida_negativa = IFNULL(curtida_negativa, 0) + 1 WHERE idPrimária = ?";
    $stmt4 = mysqli_prepare($conn, $sql4);
    mysqli_stmt_bind_param($stmt4, "i", $comentarioId);
    mysqli_stmt_execute($stmt4);
    mysqli_stmt_close($stmt4);

    mysqli_commit($conn);
    echo "ok";
} catch (Exception $e) {
    mysqli_rollback($conn);
    http_response_code(500);
    echo "Erro: " . $e->getMessage();
}

mysqli_close($conn);
