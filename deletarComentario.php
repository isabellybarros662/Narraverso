<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Armazena os dados do comentário na sessão para confirmar na obras.php
    $_SESSION['confirmar_delete_dados'] = [
        'idComentario' => $_POST['id-comentario'],
        'idUsuarioComentario' => $_POST['id-usuario-comentario'],
        'nomeObra' => $_POST['nomeObra'],
        'categoria' => $_POST['categoria'],
    ];

    header("Location: obras.php?nome=" . urlencode($_POST['nomeObra']) . "&categoria=" . urlencode($_POST['categoria']));
    exit;
}
?>
