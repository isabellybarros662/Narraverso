<!DOCTYPE html>
<html>
<head>
    <title>Verificação de Código</title>
</head>
<body>
    <form method="POST" action="">
        Código de recuperação:<br>
        <input type="text" name="codigo"><br><br>
        <input type="submit" value="Verificar Código">
    </form>
</body>
</html>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['codigo'])) {
    $CPF = $_SESSION['CPF'];
    $codigo = $_POST['codigo'];

    // Verifica o código no banco de dados
    $result = $conn->query("SELECT id FROM tcc_pessoa WHERE CPF = '$CPF' AND codigo_recuperacao = '$codigo' LIMIT 1");
    if ($result->num_rows === 1) {
        header("Location: redefinir_senha.php"); // Redireciona para redefinir senha
        exit();
    } else {
        echo "Código inválido!";
    }
}
?>


