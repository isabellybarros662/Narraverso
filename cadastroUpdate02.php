<?php
session_start();
// Conectar ao banco de dados
require("tccbdconnecta.php"); // Inclua seu arquivo de conexão ao banco

//Vendo qual é o id
$id = isset($_SESSION['id']) ? $_SESSION['id'] : null;
// Captura os dados do formulário
$nome = isset($_POST['nome']) ? $_POST['nome'] : '';
$email = isset($_POST['email']) ? $_POST['email'] : '';
$senha = isset($_POST['senhaUsu']) ? $_POST['senhaUsu'] : '';
$login = isset($_POST['login']) ? $_POST['login'] : '';
$descricao = isset($_POST['descricao']) ? $_POST['descricao'] : '';
$fotoPerfil = $_FILES['fotoPerfil']['name'];
$fotoTemp = $_FILES['fotoPerfil']['tmp_name'];

//Vendo se id existe
if (!$id) {
    die("Id do usuário não informado");
}


if (!isset($_SESSION['errosSenha'])) {
    $_SESSION['errosSenha'] = [];
}  // Erros relacionados à senha

if (!isset($_SESSION['erroFoto'])) {
    $_SESSION['erroFoto'] = [];
}   //erro foto de perfil
if (!isset($_SESSION['erroRepeticao'])) {
    $_SESSION['erroRepeticao'] = []; // Mensagem de erro de login
}
if (!isset($_SESSION['erroEmail'])) {
    $_SESSION['erroEmail'] = []; // Mensagem de erro de email
}


//Validação de e-mail
if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['erroEmail'][] = "Informe um e-mail válido";
}


// Verifica se mandou alguma senha
$senhaCriptografada = null;
if(!empty($senha)) {
    // Armazena os erros de senha
    if (strlen($senha) < 8) {
        $_SESSION['errosSenha'][] = "A senha deve ter pelo menos 8 caracteres.";
    }
    if (!preg_match('/[A-Z]/', $senha)) {
        $_SESSION['errosSenha'][] = "A senha deve conter pelo menos uma letra maiúscula.";
    }
    if (preg_match_all('/[a-z]/', $senha) < 4) {
        $_SESSION['errosSenha'][] = "A senha deve conter pelo menos 4 letras minúsculas.";
    }
    if (!preg_match('/[0-9]/', $senha)) {
        $_SESSION['errosSenha'][] = "A senha deve conter pelo menos um número.";
    }
    if (!preg_match('/[\W_]/', $senha)) {
    $_SESSION['errosSenha'][] = "A senha deve conter pelo menos um caractere especial.";
    }
}


// Armazena os erros de campos obrigatórios
if (empty($nome) || empty($email) || empty($login) || empty($descricao)) {
    $_SESSION['errosObrigatorios'][] = "Todos os campos devem estar preenchidos corretamente.";
}




// Recupera a imagem atual no banco de dados, caso o usuário não mude
$sqlFotoAtual = "SELECT fotoPerfil FROM tcc_pessoa WHERE id = ?";
$stmtFoto = mysqli_prepare($conn, $sqlFotoAtual);
mysqli_stmt_bind_param($stmtFoto, "i", $id);
mysqli_stmt_execute($stmtFoto);
mysqli_stmt_bind_result($stmtFoto, $fotoAtual);
mysqli_stmt_fetch($stmtFoto);
mysqli_stmt_close($stmtFoto);


// Verifica se há uma foto e valida o arquivo
if (!empty($fotoPerfil)) {
    $pastaDestino = 'imagens/fotos_perfil/'; // Caminho para a pasta de fotos
    $caminhoFoto = $pastaDestino . basename($fotoPerfil);

    // Obter a extensão do arquivo
    $extensao = strtolower(pathinfo($fotoPerfil, PATHINFO_EXTENSION));

    // Definir as extensões permitidas
    $extensoesPermitidas = ['jpeg', 'jpg', 'png', 'gif'];

    // Verificar se a extensão é permitida
    if (!in_array($extensao, $extensoesPermitidas)) {
        $_SESSION['erroFoto'][] = "Apenas arquivos JPEG, PNG e GIF são aceitos.";
    }

    $tamanhoMaximo = 2 * 1024 * 1024; // 2 MB
    if ($_FILES['fotoPerfil']['size'] > $tamanhoMaximo) {
        $_SESSION['erroFoto'][] = "Arquivo muito grande! O tamanho máximo permitido é 2MB.";
    }

    // Verifica se a foto é válida antes de movê-la
    if (empty($_SESSION['erroFoto'])) {
        move_uploaded_file($fotoTemp, $caminhoFoto);
    }

} else {
    // Caso não tenha sido enviada nenhuma foto, usa a imagem atual do banco
    $caminhoFoto = $fotoAtual ?: 'imagens/login-bege.png';
}

// Consulta única para verificar email ou login já usados
$sql = "SELECT id, email, login FROM tcc_pessoa WHERE email = ? OR login = ?";
$stmtVerifica = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmtVerifica, "ss", $email, $login);
mysqli_stmt_execute($stmtVerifica);
$result = mysqli_stmt_get_result($stmtVerifica);

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        if ($row['email'] === $email && $row['id'] != $id) {
            $_SESSION['erroRepeticao'][] = "O email '$email' já está em uso. Cadastre outro.";
        }
        if ($row['login'] === $login && $row['id'] != $id) {
            $_SESSION['erroRepeticao'][] = "O login '$login' já está em uso. Escolha outro.";
        }
    }
}


// Verifica se há erros e redireciona
if (!empty($_SESSION['errosSenha']) || !empty($_SESSION['erroEmail']) || !empty($_SESSION['errosObrigatorios']) || !empty($_SESSION['erroFoto']) || !empty($_SESSION['erroRepeticao'])) {
    header("Location: cadastroUpdate01.php?erro=1");
    exit;
}

//Verifica se senha foi atualizada

if(!empty($senha)){
    // Criptografa a senha
    require("cryp2graph2.php");
    $senhaCriptografada = FazSenha($email, $senha);

    // Prepara a consulta SQL com placeholders
    $sql2 = "UPDATE tcc_pessoa SET email = ?, nome = ?, senha = ?, login = ?, descricao = ?, fotoPerfil = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql2);

    // Verifica se a preparação foi bem-sucedida
    if (!$stmt) {
        die("Erro na preparação da query: " . mysqli_error($conn));
    }

    // Liga os parâmetros aos placeholders
    mysqli_stmt_bind_param($stmt, "ssssssi", $email, $nome, $senhaCriptografada, $login, $descricao, $caminhoFoto, $id);
} else{

    // Prepara a consulta SQL com placeholders
    $sql2 = "UPDATE tcc_pessoa SET email = ?, nome = ?, login = ?, descricao = ?, fotoPerfil = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql2);

    // Verifica se a preparação foi bem-sucedida
    if (!$stmt) {
        die("Erro na preparação da query: " . mysqli_error($conn));
    }

    // Liga os parâmetros aos placeholders
    mysqli_stmt_bind_param($stmt, "sssssi", $email, $nome, $login, $descricao, $caminhoFoto, $id);
}

// Executa o statement
if (mysqli_stmt_execute($stmt)) {
    header("Content-Type: text/html; charset=UTF-8");

    $_SESSION['sucessoUpdate'] = true; // ← Flag para exibir modal
    header("Location: cadastroUpdate01.php");
    exit;
} else {
    die("Erro ao inserir em tcc_pessoa: " . mysqli_stmt_error($stmt));
}

// Fecha o statement e a conexão
mysqli_stmt_close($stmt);
mysqli_close($conn);
?>