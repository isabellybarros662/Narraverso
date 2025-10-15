

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Erro no Cadastro</title>
    <style>
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6); /* Fundo escuro semi-transparente */
            backdrop-filter: blur(5px); /* Efeito de desfoque no fundo */
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }
        .modal {
            background: #F9F7EF;
            padding: 35px;
            border-radius: 8px;
            text-align: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 80%;
        }
        .modal h2 {
            color: #910910;
            margin-bottom: 10px;
        }
        .modal h4 {
            color: #910910;
            margin-bottom: 10px;
        }
        .modal p {
            color: #333;
            margin-bottom: 20px;
        }
        .modal button {
            background: #910910;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        .modal button:hover {
            background: #FF1744;
        }
    </style>
</head>
<body>
    <div class="modal-overlay">
        <div class="modal">
            <h2>Erro!</h2>
            <p>

                <?php if (!empty($_SESSION['errosSenha'])): ?>
                    <h4>Erro na senha:</h4>
                    <ul>
                        <?php foreach ($_SESSION['errosSenha'] as $erro): ?>
                            <li><?= htmlspecialchars($erro, ENT_QUOTES, 'UTF-8') ?></li>
                        <?php endforeach; ?>
                    </ul>
                    <br>
                <?php endif; ?>

               
                <?php if (!empty($_SESSION['errosObrigatorios'])): ?>
                    <h4>Campos obrigatórios não preenchidos:</h4>
                    <ul>
                        <?php foreach ($_SESSION['errosObrigatorios'] as $erro): ?>
                            <li><?= htmlspecialchars($erro, ENT_QUOTES, 'UTF-8') ?></li>
                        <?php endforeach; ?>
                    </ul>
                    <br>
                <?php endif; ?>

                
                <?php if (!empty($_SESSION['erroFoto'])): ?>
                    <h4>Erro no upload da foto:</h4>
                    <ul>
                        <?php foreach ($_SESSION['erroFoto'] as $erro): ?>
                            <li><?=htmlspecialchars($erro, ENT_QUOTES, 'UTF-8') ?></li>
                        <?php endforeach; ?>
                    </ul>
                    <br>
                <?php endif; ?>

                
                <?php if (!empty($_SESSION['erroRepeticao'])): ?>
                    <h4>Erro de duplicação:</h4>
                    <ul>
                        <?php foreach ($_SESSION['erroRepeticao'] as $erro): ?>
                            <li><?= htmlspecialchars($erro, ENT_QUOTES, 'UTF-8') ?></li>
                        <?php endforeach; ?>
                    </ul>
                    <br>
                <?php endif; ?>

                
                <?php if (!empty($_SESSION['erroCadastro'])): ?>
                <h4>Erro no login:</h4>
                <ul>
                    <li><?= htmlspecialchars($_SESSION['erroCadastro'], ENT_QUOTES, 'UTF-8') ?></li>
                </ul>
                <br>
                <?php endif; ?>

                
                <?php if (!empty($_SESSION['erroEmail'])): ?>
                    <h4>Erro ao encontrar o e-mail:</h4>
                    <ul>
                        <?php foreach ($_SESSION['erroEmail'] as $erro): ?>
                            <li><?= htmlspecialchars($erro, ENT_QUOTES, 'UTF-8') ?></li>
                        <?php endforeach; ?>
                    </ul>
                    <br>
                <?php endif; ?>



            </p>
            <button onclick="volta()">Voltar</button>
        </div>
    </div>
    <script>
        function volta() {
            window.history.back();
        }
    </script>
</body>
</html>

<?php
// Limpa os erros na sessão após exibi-los
unset($_SESSION['errosSenha']);
unset($_SESSION['erroEmail']);
unset($_SESSION['errosObrigatorios']);
unset($_SESSION['erroFoto']);
unset($_SESSION['erroRepeticao']);
unset($_SESSION['erroCadastro']);
?>
