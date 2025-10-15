<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Favorito - Narraverso</title>
    <link rel="stylesheet" href="css/estilopesquisa.css">
    <script src="menu.js"></script>
    <script src="filtroPesquisa.js"></script>
</head>
<body>
    <?php
        session_start();
        $usuarioLogado = isset($_SESSION['id']);
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
                    <li class="nav-item"><a href="favorito.php" class="nav-link"><img src="imagens/coracao-verde.png" alt="Favoritos">  Favoritos</a></li>
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
                        <a href="<?= $usuarioLogado ? 'perfil_pessoal.php' : '#' ?>" class="nav-link-login"
                           <?php if (!$usuarioLogado) echo 'onclick="loginShow()"'; ?>>
                           
                            <img src="imagens/usuario-bege.png" alt="Usuario"/>
                        </a>
                    </li>
                </ul>
            </div>
            </nav>


            <nav class="nav-bar-filtro">
            <div class="nav-list-filtro">
                <ul>
                    <!-- Ícone 8: Filtro -->
                    <li class="nav-item">
                        <a href="" class="nav-link-filtro" id="filtrar-btn">
                            <img src="imagens/filtro-vermelho.png" alt="filtro" id="filtro-img" />
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
            <input type="text" name="email" id="emailSenha" value="" maxlength="150">
            <br>
            <a class="aVoltar" href="#" onclick="voltarLogin()">Voltar</a>
            <br>
            <div class="login-button">
            <input type="submit" name="btEnviar" value="Enviar">
            <br>
        </form>
    </div>

    </header>


    <form method="POST">
        <div class="container-pesquisa">
            <div class="pesquisa-imagem">
                <img src="imagens/pesquisa-container.png" alt="Ícone de pesquisa">
            </div>
            <input type="text" class="barra-pesquisa" id="barra-pesquisa" name="pesquisa" placeholder="Pesquise as obras favoritas...">
        </div>
    </form>

    <!--Mostrar as obras-->
        <div class="container-principal-obras">
            <ul class="container-obras">
            <?php 
                require("tccbdconnecta.php");

                $pesquisa = isset($_POST['pesquisa']) ? $_POST['pesquisa'] : '';

                if (!$conn) {
                    die("Erro com a conexão com o banco de dados: " .mysqli_connect_error());
                }

                $sql = "SELECT nome, fotoPerfil, categoria, genero FROM tcc_favorito WHERE nome AND idUsuario = $usuarioLogado LIKE '%$pesquisa%'"; //like verifica se pesquisa é igual nome da obra. % por antes (qualquer letras antes de pesquisa) e depois (qualquer letras depois de pesquisa)

                $resultado = mysqli_query($conn, $sql);

                if (!$resultado) {
                    die("Erro ao fazer a consulta SQL: " .mysqli_connect_error($conn));
                }

                echo '<h2 class="obras-titulo">OBRAS:</h2>';
                if (mysqli_num_rows($resultado) > 0) { //quatas linhas retornou da nossa pesquisa
                    while ($dados = mysqli_fetch_assoc($resultado)){ //mostra resultado da pesquisa 
                        $fotoObra = !empty($dados['fotoPerfil']) ? $dados['fotoPerfil'] : 'imagens/imagem-obras.png';
                        $nome = $dados['nome'];
                        $categoria = $dados['categoria'];
                        $genero = $dados['genero'];

                        echo '<li class="obras" data-tipo="' . $categoria .'"  data-genero="' . $genero . '">
                        <a href="obras.php?nome=' . urlencode($nome) . '&categoria=' . urlencode($categoria) . '" style="text-decoration: none; color: inherit;">
                        <div class="obras-image">
                            <img id="preview-obra" src="' . $fotoObra . '" alt="Imagem da obra">
                            <img class="favorito-icone" src="imagens/favorito-vermelho.png" alt="Usuário">
                        </div>
                        <div class="conteudo-obras">
                            <h2 class="conteudo-nome">
                                '. $nome .'
                            </h2>
                        </div>
                        </a>
                    </li>';
                    } //enquanto houver resultado aparece
                }
                    echo '<li class= "sem_resultado" id="sem_resultado">
                        <img src="imagens/sem-obra.png">
                    </li>';


                    mysqli_close($conn);
            ?>
        </ul>
    </div>
        


    <!-- Tela de Filtro -->
    <div id="filtroModal" class="filtro-overlay">
        <div class="filtro-container">
            <h2>Filtrar por:</h2>
            <br>

            <h3>Tipo:</h3>
            <span data-tipo="filme">Filme &nbsp;</span>
            <span data-tipo="serie">Série &nbsp;</span>
            <span data-tipo="livro">Livro</span>
            <br>
            <br>

            <h3>Gênero:</h3>
            <div class="genero-lista">
                <span data-genero="acao">Ação</span>
                <span data-genero="adolescencia">Adolescência</span>
                <span data-genero="animacao">Animação</span>
                <span data-genero="anime">Anime</span>
                <span data-genero="aventura">Aventura</span>
                <span data-genero="biografia">Biografia</span>
                <span data-genero="classico">Clássico</span>
                <span data-genero="comedia">Comédia</span>
                <span data-genero="crime">Crime</span>
                <span data-genero="distopia">Distopia</span>
                <span data-genero="documentario">Documentário</span>
                <span data-genero="drama">Drama</span>
                <span data-genero="drama-asiatico">Drama Asiático</span>
                <span data-genero="esporte">Esporte</span>
                <span data-genero="familia">Família</span>
                <span data-genero="fantasia">Fantasia</span>
                <span data-genero="fabula">Fábula</span>
                <span data-genero="ficcao">Ficção</span>
                <span data-genero="ficcao-cientifica">Ficção Científica</span>
                <span data-genero="filosofia">Filosofia</span>
                <span data-genero="historico">Histórico</span>
                <span data-genero="lgbtqia">LGBTQIA+</span>
                <span data-genero="mistério">Mistério</span>
                <span data-genero="musical">Musical</span>
                <span data-genero="novela">Novela</span>
                <span data-genero="policial">Policial</span>
                <span data-genero="politica">Política</span>
                <span data-genero="romance">Romance</span>
                <span data-genero="suspense">Suspense</span>
                <span data-genero="terror">Terror</span>
            </div>
            <br>

            <a class="fechar-filtro" onclick="fecharFiltro()">Voltar</a>

            <button id="getSelecionar" onclick="confirmarFiltro()">Confirmar</button>
        </div>
    </div>

    <div id="trilho"></div> <!--Para funcionar modo escuro-->


</body>
</html>
