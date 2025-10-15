<?php
session_start();
error_log(print_r($_SESSION, true)); // DEPURAÇÃO nos logs

require("tccbdconnecta.php");

header('Content-Type: application/json; charset=utf-8');

// Função auxiliar para pegar o ID do usuário na sessão
function pegarIdUsuarioSessao() {
    $chavesPossiveis = ['idUsuario', 'id', 'user_id'];
    foreach ($chavesPossiveis as $chave) {
        if (isset($_SESSION[$chave]) && !empty($_SESSION[$chave])) {
            return $_SESSION[$chave];
        }
    }
    return null;
}

$idUsuario = pegarIdUsuarioSessao();
if (!$idUsuario) {
    echo json_encode(['favorito' => false, 'erro' => 'Usuário não logado']);
    exit; // Certifique-se de que o script para aqui
}

// Pega o id da obra enviado pelo JS
$idObra = isset($_POST['idObra']) ? intval($_POST['idObra']) : 0;
if ($idObra <= 0) {
    echo json_encode(['favorito' => false, 'erro' => 'ID da obra inválido']);
    exit; // Certifique-se de que o script para aqui
}

// Ajuste o nome da tabela conforme seu DB: tcc_obra ou tcc_obras
$sql = "SELECT * FROM tcc_obra WHERE idObra = ?";
$stmt = mysqli_prepare($conn, $sql);
if (!$stmt) {
    echo json_encode(['favorito' => false, 'erro' => 'Erro interno (prepare)']);
    exit; // Certifique-se de que o script para aqui
}
mysqli_stmt_bind_param($stmt, "i", $idObra);
mysqli_stmt_execute($stmt);
$resultado = mysqli_stmt_get_result($stmt);
$obra = mysqli_fetch_assoc($resultado);
mysqli_stmt_close($stmt);

if (!$obra) {
    echo json_encode(['favorito' => false, 'erro' => 'Obra não encontrada']);
    exit; // Certifique-se de que o script para aqui
}

// Checa se já existe favorito
$sql2 = "SELECT 1 FROM tcc_favorito WHERE idUsuario = ? AND idObra = ?";
$stmt2 = mysqli_prepare($conn, $sql2);
mysqli_stmt_bind_param($stmt2, "ii", $idUsuario, $idObra);
mysqli_stmt_execute($stmt2);
$result2 = mysqli_stmt_get_result($stmt2);

if (mysqli_num_rows($result2) == 0) {
    // Inserir favorito
    $nome = isset($obra['nome']) ? $obra['nome'] : '';
    $categoria = isset($obra['categoria']) ? $obra['categoria'] : '';
    $genero = isset($obra['genero']) ? $obra['genero'] : '';
    $fotoPerfil = isset($obra['fotoPerfil']) ? $obra['fotoPerfil'] : '';

    $sql3 = "INSERT INTO tcc_favorito (idUsuario, idObra, nome, categoria, genero, fotoPerfil) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt3 = mysqli_prepare($conn, $sql3);

    if (!$stmt3) {
        error_log("Erro ao preparar inserção: " . mysqli_error($conn));
        echo json_encode(['favorito' => false, 'erro' => 'Erro interno (prepare insert)']);
        exit;
    }

    mysqli_stmt_bind_param($stmt3, "iissss", $idUsuario, $idObra, $nome, $categoria, $genero, $fotoPerfil);

    if (!mysqli_stmt_execute($stmt3)) {
        error_log("Erro ao inserir favorito: " . mysqli_stmt_error($stmt3));
        echo json_encode(['favorito' => false, 'erro' => 'Erro ao inserir no banco']);
        exit;
    }

    mysqli_stmt_close($stmt3);

    echo json_encode(['favorito' => true]);
} else {
    // Remover favorito
    $sqlDel = "DELETE FROM tcc_favorito WHERE idUsuario = ? AND idObra = ?";
    $stmtDel = mysqli_prepare($conn, $sqlDel);
    mysqli_stmt_bind_param($stmtDel, "ii", $idUsuario, $idObra);
    mysqli_stmt_execute($stmtDel);
    mysqli_stmt_close($stmtDel);
    echo json_encode(['favorito' => false]);
}

mysqli_stmt_close($stmt2);
mysqli_close($conn);
exit;
?>
