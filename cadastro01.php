<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Narraverso</title>
    <link rel="stylesheet" href="css/estilocadastro.css">
    <script src="menu.js"></script>
</head>
<body>
    <?php
        session_start();
        $usuarioLogado = isset($_SESSION['id']);
        $erroCad = isset($_GET['erro']) && (
            !empty($_SESSION['errosObrigatorios']) ||
            !empty($_SESSION['errosSenha']) ||
            !empty($_SESSION['erroFoto']) ||
            !empty($_SESSION['erroRepeticao'])
        );
    ?>


    <header>

        <nav class="nav-bar-principal">
            <div class="nav-list-icone-menu">
                <ul>
                    <li class="nav-item">
                        <a href="#" id="menu-toggle" class="nav-link">
                            <img src="imagens/menu-bege.png" alt="menu" />
                        </a>
                    </li>
                </ul>
            </div>

            <div id="menu" class="nav-list-menu">
                <ul>
                    <li class="nav-item"><a href="index.php" class="nav-link-casa"><img src="imagens/casa-bege.png" alt="casa">      Página Inicial</a></li>
                    <li class="nav-item"><a href="quemSomos.php" class="nav-link"><img src="imagens/quem-somos-bege.png" alt="quem-somos">  Quem Somos</a></li>
                    <li class="nav-item"><a href="pesquisa.php" class="nav-link"><img src="imagens/pesquisa-bege.png" alt="pesquisa">  Pesquisar</a></li>
                    <li class="nav-item"><a href="favorito.php" class="nav-link"><img src="imagens/coracao-bege.png" alt="Favoritos">  Favoritos</a></li>
                    <li class="nav-item"><a href="cadObra01.php" class="nav-link"><img src="imagens/mais-bege.png" alt="mais">  Cadastrar novas obras</a></li>
                    <li class="nav-item"><a href="configuracoes.php" class="nav-link"><img src="imagens/configuracoes-bege.png" alt="configuracao">  Configurações</a></li>
                </ul>
            </div>
        </nav>

        <nav class="nav-bar-logo">
        <div class="nav-list-logo">
                <ul>
                    <!-- Ícone 6: text-narraverso -->
                    <li class="nav-item">
                        <a  class="nav-link-text-narraverso">
                            <img src="imagens/text-narraverso.png" alt="text-narraverso"/>
                        </a>
                    </li>
                </ul>
            </div>
            </nav>


            <nav class="nav-bar-sino">
            <div class="nav-list-sino">
                <ul>
                    <!-- Ícone 7: Sino -->
                    <li class="nav-item">
                        <a href="#" class="nav-link-sino">
                            <img src="imagens/sino-bege.png" alt="Sino"/>
                        </a>
                    </li>
                </ul>
            </div>
            </nav>

            <nav class="nav-bar-login">
            <div class="nav-list-login">
                <ul>
                    <!-- Ícone 7: Contato -->
                    <li class="nav-item">
                        <a href="#" class="nav-link-login">
                            <img src="imagens/usuario-verde.png" alt="Usuario"/>
                        </a>
                    </li>
                </ul>
            </div>
            </nav>


    

        
        <div class="cadastrar-container">

        <form name="cadastrando" method="POST" action="cadastro02.php" enctype="multipart/form-data">

            <div class="perfil-container">  
            <h1 class="titulo-principal">CADASTRE-SE!</h1>
            <br>
            <br>
            <label class="fotoPerfil" tabindex="0">
                <span class="fotoPerfil-image">
                    <img id="preview" src="imagens/login-bege.png" alt="Foto de Perfil">
                </span>
                <input type="file" name="fotoPerfil" accept="image/*" class="fotoPerfil-input" onchange="previewImage(event)" />
                <span class="camera">
                    <img src="imagens/camera.png" alt="Camera">
                </span>
            </label>
            <button type="button" class="reset-button" onclick="resetImage()">Deixar sem foto</button>
            </div>

            <div class="cadastrar">

            <h2 class="texto-logar-cad" style="margin-top: 20px;">Nome: <br></h2> 
            <input type="text" name="nome" id="nome" value="" maxlength="150">

            <h2 class="texto-logar-cad" style="margin-top: 20px;">Email: <br></h2> 
            <input type="text" name="email" id="email" value="" maxlength="150">

            <h2 class="texto-logar-cad">Senha: <br></h2> 
            <div class="senha-container">
                <input type="password" name="senhaUsu" id="senhaUsu" value="" maxlength="50">
                <span class="olho-span" onclick="mostrarSenha()">
                    <img class="olho-mostra" src="imagens/olho-fechado.png" alt="mostrar/esconder senha">
                </span>
            </div>

            <h2 class="texto-logar-cad" style="margin-top: 20px;">O nome do seu login será: <br></h2> 
            <input type="text" name="login" id="login" value="@" maxlength="50" oninput="fixaArroba()">

            <h2 class="texto-logar-cad">Fale um pouco sobre suas preferências e gostos entre filmes, séries e livros: <br></h2> 
            <textarea type="text" name="descricao" id="descricao" value="" maxlength="300" rows="8" style="width: 100%";></textarea> <!-- rows num de linhas, width quanto vai ocupar a tela, taxtarea para espaço maior -->
            <br>
            <br>
            <br>
            <a class="aVoltarInicial" href="index.php">Voltar</a>

            <div class="enviar-button">
            <button type="submit" onclick="salvarDados()">Mandar dados</button>
            </div>
            
            </div>
        </form>
    </div>

    <?php if ($erroCad): ?>
    <?php include 'erro_modal.php'; ?>
    <?php endif; ?>

    <?php 
        if (isset($_SESSION['sucessoCad'])) {
            include 'sucesso_cadastro.html';
            unset($_SESSION['sucessoCad']); //para exibir apenas uma vez
        }
    ?>

    <div id="trilho"></div> <!--Para funcionar modo escuro-->
                    
    </header>


   
</body>
</html>
