<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="utf-8">
	<meta name='viewport' content='width=device-width, initial-scale=1'>
	<title>Recuperação de Senha</title>
</head>
<body>
	<?php
	session_start();
	$email = $_POST['emailSenha'] ?? ''; // Garante que a variável existe

	// Verifica se a variável de erros obrigatórios existe, se não, cria o array
	if (!isset($_SESSION['errosObrigatorios'])) {
    	$_SESSION['errosObrigatorios'] = [];
	}

	// Verifica se a variável de erros email existe, se não, cria o array
	if (!isset($_SESSION['erroEmail'])) {
    	$_SESSION['erroEmail'] = [];
	}

	// Verifica se o email está vazio e adiciona o erro à sessão
	if (empty($email)) {
    	$_SESSION['errosObrigatorios'][] = "O campo e-mail é obrigatório."; // Adiciona o erro à sessão
    	header("Location: index.php?erro=1");
    	exit;
	}

	require("tccbdconnecta.php");

	$sql = "SELECT nome, senha, email FROM tcc_pessoa WHERE email=?";
	$stmt = mysqli_prepare($conn, $sql);
	if (!$stmt) {
		die("Não foi possível preparar a consulta!");
	}
	mysqli_stmt_bind_param($stmt, "s", $email);
	if (!mysqli_stmt_execute($stmt)) {
		die("Erro ao executar consulta: " . mysqli_error($conn));
	}

	mysqli_stmt_bind_result($stmt, $nome, $senha, $email);
	if (!mysqli_stmt_fetch($stmt)) {
    	// Se o e-mail não for encontrado, adiciona o erro à sessão e redireciona
    	$_SESSION['erroEmail'][] = "E-mail não encontrado!";
    	header("Location: index.php?erro=1");
    	exit;
	}


	mysqli_stmt_free_result($stmt);

	require("cryp2graph2.php");
	require("email.php");
	
	$novaSenha = CriaAlgo(8);
	$mensagem = "Sua nova senha é: $novaSenha";
	$senhaCriptografada = FazSenha($email, $novaSenha);

	// Preparando a consulta de atualização
	$sql2 = "UPDATE tcc_pessoa SET senha=? WHERE email=?";
	$stmt2 = mysqli_prepare($conn, $sql2);
	if (!$stmt2) {
		die("Erro ao preparar a atualização de senha: " . mysqli_error($conn));
	}

	mysqli_stmt_bind_param($stmt2, "ss", $senhaCriptografada, $email);
	if (!mysqli_stmt_execute($stmt2)) {
		die("Não foi possível registrar senha nova no BD: " . mysqli_error($conn));
	}
	
	$resultadoEmail = mandarEmail($nome, $email, "Recuperação de Senha", $mensagem);
	if (!$resultadoEmail) {
    	$sqlReverter = "UPDATE tcc_pessoa SET senha=? WHERE email=?";
    	$stmtReverter = mysqli_prepare($conn, $sqlReverter);
    	mysqli_stmt_bind_param($stmtReverter, "ss", $senha, $email);
    	mysqli_stmt_execute($stmtReverter);
    	mysqli_stmt_close($stmtReverter);
    	die("Não foi possível enviar e-mail com nova senha!");
	}

	

	mysqli_stmt_close($stmt);
	mysqli_stmt_close($stmt2);
	mysqli_close($conn);
	?>
</body>
</html>
