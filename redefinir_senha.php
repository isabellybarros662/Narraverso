<!DOCTYPE html>
<html>
<head>
    <title>Redefinir Senha</title>
</head>
<body>

    <form name="form1" action="" method="POST">

        Senha Nova:<br>
        <input type="password" name="senha" id="senha" value ="" maxlength="50"><br>

        <input type="submit" value="Recuperar Senha">
    </form>
</body>
</html>

<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['senha']) && !empty($_POST['senha'])) {
        $senha = $_POST['senha'];
        $CPF = isset($_POST['CPF']) ? $_POST['CPF'] : '';
        
        // Incluir conexões e funções necessárias
        require("tccbdconnecta.php");
        require("funcoes.php"); // Para obter os parâmetros
        require("cryp2graph2.php"); // Para a função de criptografia
        
        // Obter parâmetros
        $qtdeMinCaracEspeciais = getParametro("qtdeMinCaracEspeciais", 1);
        $qtdeMinMaiuscula = getParametro("qtdeMinMaiuscula", 1);
        $qtdeMinMinuscula = getParametro("qtdeMinMinuscula", 1);
        $qtdeMinNumero = getParametro("qtdeMinNumero", 1);
        $tamanhoMaxSenha = getParametro("tamanhoMaxSenha", 24);
        $tamanhoMinSenha = getParametro("tamanhoMinSenha", 9);
        
        // Validar a senha com os parâmetros
        $erros = [];
        
        // Verifica o comprimento da senha
        if (strlen($senha) < $tamanhoMinSenha || strlen($senha) > $tamanhoMaxSenha) {
            $erros[] = "A senha deve ter entre $tamanhoMinSenha e $tamanhoMaxSenha caracteres.";
        }
        
        // Verifica o número mínimo de caracteres especiais
        if (preg_match_all('/[^\w]/', $senha) < $qtdeMinCaracEspeciais) {
            $erros[] = "A senha deve conter pelo menos $qtdeMinCaracEspeciais caracteres especiais.";
        }
        
        // Verifica o número mínimo de letras maiúsculas
        if (preg_match_all('/[A-Z]/', $senha) < $qtdeMinMaiuscula) {
            $erros[] = "A senha deve conter pelo menos $qtdeMinMaiuscula letras maiúsculas.";
        }
        
        // Verifica o número mínimo de letras minúsculas
        if (preg_match_all('/[a-z]/', $senha) < $qtdeMinMinuscula) {
            $erros[] = "A senha deve conter pelo menos $qtdeMinMinuscula letras minúsculas.";
        }
        
        // Verifica o número mínimo de números
        if (preg_match_all('/[0-9]/', $senha) < $qtdeMinNumero) {
            $erros[] = "A senha deve conter pelo menos $qtdeMinNumero números.";
        }
        
        // Verifica se há erros de validação
        if (count($erros) > 0) {
            // Exibe erros encontrados
            echo "Erros na senha:<br>";
            foreach ($erros as $erro) {
                echo "- $erro<br>";
            }
        } else {
            // Senha válida; prossegue com a criptografia e atualização no banco
            $senhaCriptografada = FazSenha($CPF, $senha);
            $sql2 = "UPDATE tcc_pessoa SET senha='$senhaCriptografada', tipoSenha='S' WHERE CPF='$CPF'";
            $resultado = mysqli_query($conn, $sql2);
            if (!$resultado) {
                die("Não foi possível registrar senha nova no BD!");
            }
            echo "Senha redefinida com sucesso! Volte para <a href='newmenu.php'>Menu</a><br>";
        }
        
    } else {
        echo "Por favor, preencha a nova senha!";
    }
}
?>

