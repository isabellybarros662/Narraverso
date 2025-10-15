<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cadastro Obras - Narraverso</title>
    <link rel="stylesheet" href="css/estiloCadObra.css">
    <script src="menu.js"></script>
</head>
<body>
    <?php
        session_start();
        $usuarioLogado = isset($_SESSION['id']);
        $erroCadObra = isset($_GET['erro']) && (
            !empty($_SESSION['errosObrigatorios']) ||
            !empty($_SESSION['errosFoto']) ||
            !empty($_SESSION['erroCadastro'])
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
                    <li class="nav-item"><a href="#" class="nav-link"><img src="imagens/mais-verde.png" alt="mais">  Cadastrar novas obras</a></li>
                    <li class="nav-item"><a href="configuracoes.php" class="nav-link"><img src="imagens/configuracoes-bege.png" alt="configuracao">  Configurações</a></li>
                </ul>
            </div>
        </nav>

         <nav class="nav-bar-logo">
        <div class="nav-list-logo">
                <ul>
                    <!-- Ícone 6: text-narraverso -->
                    <li class="nav-item">
                        <a href="#" class="nav-link-text-narraverso">
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
                        <a href="<?= $usuarioLogado ? 'perfil_pessoal.php' : '#' ?>" class="nav-link-login"
                           <?php if (!$usuarioLogado) echo 'onclick="loginShow()"'; ?>>
                           
                            <img src="imagens/usuario-bege.png" alt="Usuario"/>
                        </a>
                    </li>
                </ul>
            </div>
            </nav>





        <!-- parte do login e cadastrar pessoa -->
        <div class="logar-cad">
            <h3 class="texto-logar-cad" style="margin-top: 20px;">Você não possui uma <br> conta conectada!</h3>
        <div class="login-button">
            <button onclick="logar()">Entrar</button>
            <button onclick="cadastrar()">Cadastrar</button>
            <br>
             <a class="aVoltar" href="#" onclick="fecharLogarCad()">Voltar</a>
        </div>
        </div>

        
        <div class="logar">
            <h3 class="texto-logar-cad">Login</h3>
            <div class="google-button">
                <button type="button"><img src="imagens/icon-google.jpeg">Logar com o Google</button>
            </div>
            <form name="login" action="login02.php" method="POST">  

            <h5 class="texto-logar-cad" style="margin-top: 20px;">Email: <br></h5> 
            <input type="text" name="email" id="email" value="" maxlength="150">
            <h5 class="texto-logar-cad">Senha: <br></h5> 
            <div class="senha-container">
                <input type="password" name="senhaUsu" id="senhaUsu" value="" maxlength="50">
                <span class="olho-span" onclick="mostrarSenha()">
                    <img class="olho-mostra" src="imagens/olho-fechado.png" alt="mostrar/esconder senha">
                </span>
            </div>
            <br>
            <a class="aVoltar" href="#" onclick="fecharLogin()">Voltar</a>
            <br>
            <div class="login-button">
            <input type="submit" name="btEnviar" value="Enviar Dados">
            <br>
        </form>
        <!-- Botão separado do form para evitar envio -->
    <button type="button" onclick="esqueciSenha()">Esqueci a senha</button>
    </div>
    </div>

    <div class="esqueciSenha" style="display: none;">
    <h3 class="texto-logar-cad">Recuperar senha</h3>
    <form name="login" action="esqueciSenha02.php" method="POST"> 

        <h5 class="texto-logar-cad" style="margin-top: 20px;">Email: <br></h5> 
        <input type="text" name="email" id="email" value="" maxlength="150">
        <br>
        <a class="aVoltar" href="#" onclick="voltarLogin()">Voltar</a>
        <br>
        <div class="login-button">
        <input type="submit" name="btEnviar" value="Enviar">
        <br>
    </form>
</div>
        
    </header>



    <!-- formulário para cadastrar obra -->
     <div class="cadastrar-container">

        <form name="cadastrando" method="POST" action="cadObra02.php" enctype="multipart/form-data">

            <div class="perfil-container">      
            <h1 class="titulo-principal">CADASTRE NOVAS OBRAS!</h1>
            <br>
            <br>
            <label class="fotoPerfil" tabindex="0">
                <span class="fotoPerfil-image">
                    <img id="preview" src="imagens/imagem-obras.png" alt="Foto de Perfil">
                </span>
                <input type="file" name="fotoPerfil-name" accept="image/*" class="fotoPerfil-input" onchange="previewImage(event)" />
                <span class="camera">
                    <img src="imagens/camera.png" alt="Camera">
                </span>
            </label>
            </div>

            <div class="cadastrar">

            <h2 class="texto-logar-cad" style="margin-top: 20px;">Categoria: <br></h2>
            <select name="categoria" id="categoria">
                <option value="" disabled selected>Selecione uma categoria</option>
                <option value="filme">Filme</option>
                <option value="serie">Serie</option>
                <option value="livro">Livro</option>
            </select>

            <h2 class="texto-logar-cad" style="margin-top: 20px;">Nome: <br></h2> 
            <input type="text" name="nome" id="nome" value="" maxlength="100">

            <h2 class="texto-logar-cad" style="margin-top: 20px;">Autor/Diretor: <br></h2> 
            <input type="text" name="autor_diretor" id="autor_diretor" value="" maxlength="100">



            <h2 class="texto-logar-cad" style="margin-top: 20px;">Classificação etária: <br></h2>
            <select name="classificacao_num" id="classificacao_num">
                <option value="" disabled selected>Selecione uma classificação</option>
                <option value="Livre">Livre</option>
                <option value="10">10</option>
                <option value="12">12</option>
                <option value="14">14</option>
                <option value="16">16</option>
                <option value="18">18</option>
            </select>
            <textarea type="text" name="classificacao_text" id="classificacao_text" value="" maxlength="130" rows="4" placeholder="Temas sensíveis..."></textarea>

            <h2 class="texto-logar-cad" style="margin-top: 20px;">Ano de laçamento: <br></h2> 
            <input type="text" name="ano_lancamento" id="ano_lancamento" value="" maxlength="4">


            <h2 class="texto-logar-cad" style="margin-top: 20px;">Gênero:</h2>
            <p style="color: red; font-size: 12px;">Você pode selecionar até 3 opções.</p>
            <div id="genero-container">
                <label><input type="checkbox" name="genero[]" value="ação"> Ação</label><br>
                <label><input type="checkbox" name="genero[]" value="adolescencia"> Adolescência</label><br>
                <label><input type="checkbox" name="genero[]" value="animação"> Animação</label><br>
                <label><input type="checkbox" name="genero[]" value="anime"> Anime</label><br>
                <label><input type="checkbox" name="genero[]" value="aventura"> Aventura</label><br>
                <label><input type="checkbox" name="genero[]" value="biografia"> Biografia</label><br>
                <label><input type="checkbox" name="genero[]" value="classico"> Clássico</label><br>
                <label><input type="checkbox" name="genero[]" value="comédia"> Comédia</label><br>
                <label><input type="checkbox" name="genero[]" value="crime"> Crime</label><br>
                <label><input type="checkbox" name="genero[]" value="distopia"> Distopia</label><br>
                <label><input type="checkbox" name="genero[]" value="documentário"> Documentário</label><br>
                <label><input type="checkbox" name="genero[]" value="drama"> Drama</label><br>
                <label><input type="checkbox" name="genero[]" value="drama"> Drama Asiático<label><br>
                <label><input type="checkbox" name="genero[]" value="esporte"> Esporte</label><br>
                <label><input type="checkbox" name="genero[]" value="fábula"> Fábula</label><br>
                <label><input type="checkbox" name="genero[]" value="família"> Família</label><br>
                <label><input type="checkbox" name="genero[]" value="fantasia"> Fantasia</label><br>
                <label><input type="checkbox" name="genero[]" value="ficção"> Ficção</label><br>
                <label><input type="checkbox" name="genero[]" value="ficção-científica"> Ficção Científica</label><br>
                <label><input type="checkbox" name="genero[]" value="filosofia"> Filosofia</label><br>
                <label><input type="checkbox" name="genero[]" value="historico"> Histórico</label><br>
                <label><input type="checkbox" name="genero[]" value="lgbtqia+"> LGBTQIA+</label><br>
                <label><input type="checkbox" name="genero[]" value="mistério"> Mistério</label><br>
                <label><input type="checkbox" name="genero[]" value="musical"> Musical</label><br>
                <label><input type="checkbox" name="genero[]" value="novela"> Novela</label><br>
                <label><input type="checkbox" name="genero[]" value="policial"> Policial</label><br>
                <label><input type="checkbox" name="genero[]" value="política"> Política</label><br>
                <label><input type="checkbox" name="genero[]" value="romance"> Romance</label><br>
                <label><input type="checkbox" name="genero[]" value="suspense"> Suspense</label><br>
                <label><input type="checkbox" name="genero[]" value="terror"> Terror</label><br>
            </div><br><br>

            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    const checkboxes = document.querySelectorAll('input[name="genero[]"]');

                    checkboxes.forEach(checkbox => {
                        checkbox.addEventListener("change", function() {
                            let selecionados = document.querySelectorAll('input[name="genero[]"]:checked');

                            if (selecionados.length >= 3) {
                                checkboxes.forEach(cb => {
                                    if (!cb.checked) {
                                        cb.disabled = true; // Bloqueia os não selecionados
                                    }
                                });
                            } else {
                                checkboxes.forEach(cb => {
                                    cb.disabled = false; // Libera os checkboxes quando há menos de 3 selecionados
                                });
                            }
                        });
                    });
                });
            </script>


            <h2 class="texto-logar-cad">Sinopse: <br></h2> 
            <textarea type="text" name="sinopse" id="sinopse" value="" maxlength="450" rows="12" style="width: 80%; max-width: 400px; min-width: 300px;"></textarea> <!-- rows num de linhas, width quanto vai ocupar a tela, taxtarea para espaço maior -->
            <br>
    

            <h2 class="texto-logar-cad" style="margin-top: 25px;">Onde encontrar: <br></h2> 
            <textarea type="text" name="onde_assistir" id="onde_assistir" value="" maxlength="120" rows="3"></textarea>
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

    <?php if ($erroCadObra): ?>
    <?php include 'erro_modal.php'; ?>
    <?php endif; ?>

    <?php 
        if (isset($_SESSION['sucessoCadObra'])) {
            include 'sucesso_cadastro.html';
            unset($_SESSION['sucessoCadObra']); //para exibir apenas uma vez
        }
    ?>

    <div id="trilho"></div> <!--Para funcionar modo escuro-->
   
</body>
</html>
