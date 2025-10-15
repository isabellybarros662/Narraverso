<?php
ob_start(); // ← Impede saída antes do header
session_start(); // Inicia a sessão antes de qualquer saída.

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtendo valores do POST
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $senhaUsu = isset($_POST['senhaUsu']) ? trim($_POST['senhaUsu']) : '';

    // Verifica se os campos estão vazios e adiciona erros à sessão
    if (empty($email) || empty($senhaUsu)) {
        // Inicializa a sessão de erros obrigatórios se não existir
        if (!isset($_SESSION['errosObrigatorios'])) {
            $_SESSION['errosObrigatorios'] = [];
        }

        // Adiciona mensagem de erro à sessão
        if (empty($email)) {
            $_SESSION['errosObrigatorios'][] = "O campo e-mail é obrigatório.";
        }
        if (empty($senhaUsu)) {
            $_SESSION['errosObrigatorios'][] = "O campo senha é obrigatório.";
        }

        // Redireciona para o modal de erro
        header("Location: index.php?erro=1");
        exit;
    }

    // Aqui vai o restante do seu código para o processamento dos dados (ex: autenticação)
    require("tccbdconnecta.php");

    $sql = "SELECT id, nome, senha FROM tcc_pessoa WHERE email = ?";
    $stmt = mysqli_prepare($conn, $sql);

    if (!$stmt) {
        //die("Erro ao preparar a consulta!");
    }

    if (!mysqli_stmt_bind_param($stmt, "s", $email)) {
        //die("Erro ao vincular parâmetros!");
    }

    if (!mysqli_stmt_execute($stmt)) {
        //die("Erro ao executar a consulta!");
    }

    if (!mysqli_stmt_bind_result($stmt, $id, $nome, $senha)) {
        //die("Erro ao vincular os resultados!");
    }

    if (!mysqli_stmt_fetch($stmt)) {
        if(!isset($_SESSION['errosObrigatorios'])) {
            $_SESSION['errosObrigatorios'] = [];
        } // Usuário não encontrado.
        $_SESSION['errosObrigatorios'] [] = "E-mail não encontrado!";
        header("Location: index.php?erro=1"); //se não encontra email no BD
        exit;
    }

    require("cryp2graph2.php");
    if (ChecaSenha($senhaUsu, $senha)) {
        $_SESSION['id'] = $id;
        $_SESSION['email'] = $email;
        $_SESSION['nome'] = $nome;
        
        $_SESSION['sucessoLogin'] = true; // ← Flag para exibir modal
        header("Location: index.php");
        exit;
    } else {
            $_SESSION['errosObrigatorios'][] = "Senha inválida!";
            header("Location: index.php?erro=1");
            exit;
        }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);

} else {
    //die("Método de requisição inválido!");
}
?>
