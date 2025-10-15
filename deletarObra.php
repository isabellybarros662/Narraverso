<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Armazena os dados do comentário na sessão para confirmar na obras.php
    $_SESSION['confirmar_delete_dados'] = [
        'idObra' => $_POST['id-obra'],
        'idUsuario' => $_POST['id-usuario-logado'],
        'nomeObra' => $_POST['nomeObra'],
        'categoria' => $_POST['categoria'],
    ];

   header("Location: perfil_pessoal.php?login=" . urlencode($loginUsu) . "&categoria=" . urlencode($categoria));
    exit;
}
?>
