<?php
session_start();
// Conectar ao banco de dados
require("tccbdconnecta.php"); // Inclua seu arquivo de conexão ao banco

// Captura os dados do formulário
if (!isset($_SESSION['id'])){
    die("Erro transferência de id!");
}
$idUsuario = $_SESSION['id'];
$categoria = isset($_POST['categoria']) ? $_POST['categoria'] : '';
$nome = isset($_POST['nome']) ? $_POST['nome'] : '';
$autor_diretor = isset($_POST['autor_diretor']) ? $_POST['autor_diretor'] : '';
$classificacao_num = isset($_POST['classificacao_num']) ? $_POST['classificacao_num'] : '';
$classificacao_text = isset($_POST['classificacao_text']) ? $_POST['classificacao_text'] : '';
$ano_lancamento = isset($_POST['ano_lancamento']) ? $_POST['ano_lancamento'] : '';
$genero = isset($_POST['genero']) ? implode(', ', $_POST['genero']) : '';
$sinopse = isset($_POST['sinopse']) ? $_POST['sinopse'] : '';
$onde_assistir = isset($_POST['onde_assistir']) ? $_POST['onde_assistir'] : '';
// Captura o arquivo de foto
$fotoPerfil = $_FILES['fotoPerfil-name']['name'];
$fotoTemp = $_FILES['fotoPerfil-name']['tmp_name'];


if (!isset($_SESSION['$errosObrigatorios'])) {
    $_SESSION['errosObrigatorios'] = [];
}  // Erros relacionados aos campos obrigatórios
if (!isset($_SESSION['$erroFoto'])) {
    $_SESSION['erroFoto'] = [];
}   //erro foto de perfil
if (!isset($_SESSION['$erroCadastro'])) {
    $_SESSION['erroCadastro'] = ""; // Mensagem de erro de login
}


if (!preg_match('/^\d{4}$/', $ano_lancamento)) {
    $_SESSION['errosObrigatorios'][] = "Informe um ano de lançamento válido com 4 dígitos.";
}


if (empty($nome) || empty($categoria) || empty($autor_diretor) || empty($classificacao_num) || 
    empty($classificacao_text) || empty($ano_lancamento) || empty($genero) || empty($onde_assistir) || empty($_FILES['fotoPerfil-name']['name'])) {
    $_SESSION['errosObrigatorios'][] = "Todos os campos, incluindo a foto de perfil, devem estar preenchidos obrigatoriamente.";
}


// Verifica se há uma foto e valida o arquivo
if (!empty($fotoPerfil)) {
    $pastaDestino = 'imagens/fotos_obras/'; // Caminho para a pasta de fotos
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
    if ($_FILES['fotoPerfil-name']['size'] > $tamanhoMaximo) {
        $_SESSION['erroFoto'][] = "Arquivo muito grande! O tamanho máximo permitido é 2MB.";
    }

    // Verifica se a foto é válida antes de movê-la
    if (empty($_SESSION['erroFoto'])) {
        move_uploaded_file($fotoTemp, $caminhoFoto);
    }

} else {
    // Caso não tenha sido enviada nenhuma foto, usa a foto padrão
    $caminhoFoto = 'imagens/login-bege.png';
}

// Verificar se a obra com o mesmo nome e categoria já existe no banco de dados
$sql = "SELECT COUNT(*) AS total FROM tcc_obra WHERE nome = '$nome' AND categoria = '$categoria'";
$result = mysqli_query($conn, $sql);

if ($result) {
    $row = mysqli_fetch_assoc($result);

    // Verificar se a obra já foi cadastrada
    if ($row['total'] > 0) {
        $_SESSION['erroCadastro'] = "A obra '$nome' na categoria '$categoria' já está cadastrada. Escolha outro nome ou categoria.";
    }
}

// Verifica se há erros e redireciona
if (!empty($_SESSION['errosObrigatorios']) || !empty($_SESSION['erroFoto']) || !empty($_SESSION['erroCadastro'])) {
    header("Location: cadObra01.php?erro=1");
    exit;
}


// Prepara a consulta SQL com placeholders
$sql2 = "INSERT INTO tcc_obra (idUsuario, nome, categoria, autor_diretor, classificacao_num, classificacao_text, ano_lancamento, genero, sinopse, onde_assistir, fotoPerfil) 
         VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = mysqli_prepare($conn, $sql2);

// Verifica se a preparação foi bem-sucedida
if (!$stmt) {
    die("Erro na preparação da query: " . mysqli_error($conn));
}

// Liga os parâmetros aos placeholders
mysqli_stmt_bind_param($stmt, "isssssissss", $idUsuario, $nome, $categoria, $autor_diretor, $classificacao_num, $classificacao_text, $ano_lancamento, $genero, $sinopse, $onde_assistir, $caminhoFoto);

// Executa o statement
if (mysqli_stmt_execute($stmt)) {
    $sql3 = "UPDATE tcc_pessoa SET publicacoes = IFNULL(publicacoes, 0) + 1 WHERE id = ?";
    $stmt2 = mysqli_prepare($conn, $sql3);
    if (!$stmt2) {
        die("Erro na preparação do query: " . mysqli_error($conn));
    }
    if (!mysqli_stmt_bind_param($stmt2, "i", $idUsuario)) {
        die("Erro ao víncular parâmetros!");
    }
    if(!mysqli_stmt_execute($stmt2)) {
        die("Erro ao executar!");
    }
    header("Content-Type: text/html; charset=UTF-8");
    $_SESSION['sucessoCadObra'] = true; // ← Flag para exibir modal
    header("Location: cadObra01.php");
    exit;
} else {
    die("Erro ao inserir em tcc_obra: " . mysqli_stmt_error($stmt));
}

// Fecha o statement e a conexão
mysqli_stmt_close($stmt);
mysqli_close($conn);
?>