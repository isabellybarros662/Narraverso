<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Configurações - Narraverso</title>
    <link rel="stylesheet" href="css/estiloConfiguracoes.css">
    <script src="menu.js"></script>
</head>
<body>
    <?php
        session_start();
        $usuarioLogado = isset($_SESSION['id']);

        if($usuarioLogado) {
            $id = $_SESSION['id']; //para bt editar funcionar
        }
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
                    <li class="nav-item"><a class="nav-link" <?php echo $usuarioLogado ? 'href="favorito.php"' : 'onclick="facaCadastro()"'; ?>><img src="imagens/coracao-bege.png" alt="Favoritos">  Favoritos</a></li>
                    <li class="nav-item"><a class="nav-link" <?php echo $usuarioLogado ? 'href="cadObra01.php"' : 'onclick="facaCadastro()"'; ?>><img src="imagens/mais-bege.png" alt="mais">  Cadastrar novas obras</a></li>
                    <li class="nav-item"><a href="configuracoes.php" class="nav-link"><img src="imagens/configuracoes-verde.png" alt="configuracao">  Configurações</a></li>
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
            <input type="text" name="emailSenha" id="emailSenha" value="" maxlength="150">
            <br>
            <a class="aVoltar" href="#" onclick="voltarLogin()">Voltar</a>
            <br>
            <div class="login-button">
            <input type="submit" name="btEnviar" value="Enviar">
            <br>
        </form>
    </div>

    </header>

    <div class="conteudo-quem-somos">
        <h1>Configurações</h1>
        <br>
        <div class="container-trilho">
            <div class="trilho" id="trilho">
                <div class="indicador" id="indicador"></div>
            </div>
            <strong>Modo escuro/claro</strong>
        </div>
        <br>
        <?php if(isset($_SESSION['id'])): ?>
        <div class="sair-conta">
            <button type="submit"  onclick="window.location.href='cadastroUpdate01.php?id=<?php echo $id; ?>'">Editar</button>
            <strong>Editar Perfil</strong>
        </div>
        <?php else: ?>
        <div class="sair-conta">
            <button type="submit" onclick="loginShow()">Editar</button>
            <strong>Editar Perfil</strong>
        </div>
        <?php endif; ?>
        <br>
        <div class="sair-conta">
            <button type="submit" <?php echo $usuarioLogado ? 'onclick="confirmarSaida()"' : 'onclick="loginShow()"'  ?>>Sair</button>
            <strong>Sair da conta</strong> 
        </div>
        <br>
        <br>
        <br>
        <div class="voltar-quem-somos">
            <button type="submit" onclick="voltar()">Voltar</button>
        </div>
    </div>

    <?php 
        if (isset($_SESSION['confirmarSaida'])) {
            include 'sucesso_sair.html';
            unset($_SESSION['confirmarSaida']); //para exibir apenas uma vez
        }
    ?>


</body>
</html>
