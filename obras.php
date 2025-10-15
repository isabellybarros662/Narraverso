<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Obra - Narraverso</title>
    <link rel="stylesheet" href="css/estiloObras.css">
    <script src="menu.js"></script>
</head>
<body>
<?php
     session_start();
    $usuarioLogado = isset($_SESSION['id']) && !empty($_SESSION['id']);
    $usuarioLogin = isset($_SESSION['login']);
    $loginSessao = $usuarioLogin ? $_SESSION['login'] : null;

    require("tccbdconnecta.php");
    $categoria = isset($_GET['categoria']) ? $_GET['categoria'] : '';
    $nome = isset($_GET['nome']) ? $_GET['nome'] : '';
    if (!$conn) {
        die("Erro na conexão com o banco de dados: " . mysqli_error($conn));
    }

    $erroDenObra = isset($_GET['erro']) && (
        !empty($_SESSION['errosObrigatorios'])
    );

    $sql = "SELECT idObra, idUsuario, nome, categoria, autor_diretor, classificacao_num, classificacao_text, ano_lancamento, genero, onde_assistir, sinopse, fotoPerfil FROM tcc_obra WHERE categoria = ? AND nome = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ss", $categoria, $nome);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);

    if (!$resultado) {
        die("Erro na consulta SQL: " . mysqli_error($conn));
    }

    if (mysqli_num_rows($resultado) > 0) {
        $dados = mysqli_fetch_assoc($resultado);
        $fotoPerfil = !empty($dados['fotoPerfil']) ? $dados['fotoPerfil'] : 'imagens/imagem-obras.png';
        $idUsuario = $dados['idUsuario'];
        $nome = $dados['nome'];
        $categoria = $dados['categoria'];
        $autor_diretor = $dados['autor_diretor'];
        $classificacao_num = $dados['classificacao_num'];
        $classificacao_text = $dados['classificacao_text'];
        $ano_lancamento = $dados['ano_lancamento'];
        $genero = $dados['genero'];
        $onde_assistir = $dados['onde_assistir'];
        $sinopse = $dados['sinopse'];

    } else {
        die("Usuário não encontrado.");
    }


    $sql2 = "SELECT id, login, fotoPerfil FROM tcc_pessoa WHERE id = ?";
    $stmt2 = mysqli_prepare($conn, $sql2);
    mysqli_stmt_bind_param($stmt2, "i", $idUsuario);
    mysqli_stmt_execute($stmt2);
    $resultado2 = mysqli_stmt_get_result($stmt2);

    if (!$resultado2) {
        die("Erro na consulta SQL: " . mysqli_error($conn));
    }

    if (mysqli_num_rows($resultado2) > 0) {
        $dados2 = mysqli_fetch_assoc($resultado2);
        $idObra = isset($dados['idObra']) ? $dados['idObra'] : 0;
        $fotoLogin = !empty($dados2['fotoPerfil']) ? $dados2['fotoPerfil'] : 'imagens/imagem-obras.png';
        $id = $dados2['id'];
        $login = $dados2['login'];

    } else {
        die("Usuário não encontrado.");
    }

    $erroComentario = isset($_GET['erro']) && (!empty($_SESSION['errosObrigatorios']));


    //--------------modal delete----------------------------------------
    if (isset($_SESSION['confirmar_delete_dados'])) {
        $deleteData = $_SESSION['confirmar_delete_dados'];
        unset($_SESSION['confirmar_delete_dados']); // Evita repetir a modal após reload

        echo '
        <div class="modal-overlay">
            <div class="modal">
                <h2>Atenção!</h2>
                <p>Você tem certeza que<br> deseja deletar este comentário?</p>
                <div class="modal-buttons">
                    <form action="deletarComentarioConfirmado.php" method="POST">
                        <input type="hidden" name="id-comentario" value="' . htmlspecialchars($deleteData['idComentario']) . '">
                        <input type="hidden" name="id-usuario-comentario" value="' . htmlspecialchars($deleteData['idUsuarioComentario']) . '">
                        <input type="hidden" name="nomeObra" value="' . htmlspecialchars($deleteData['nomeObra']) . '">
                        <input type="hidden" name="categoria" value="' . htmlspecialchars($deleteData['categoria']) . '">
                        <input type="hidden" name="confirmar_delete" value="sim">
                        <button type="submit">Deletar</button>
                    </form>
                    <button onclick="window.location.href=\'obras.php?nome=' . urlencode($deleteData['nomeObra']) . '&categoria=' . urlencode($deleteData['categoria']) . '\'">Voltar</button>
                </div>
            </div>
        </div>
        
        <style>
            .modal-overlay {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0, 0, 0, 0.5);
                display: flex;
                justify-content: center;
                align-items: center;
                z-index: 10000;
            }
            .modal {
                background: #F9F7EF;
                padding: 20px;
                border-radius: 8px;
                text-align: center;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                max-width: 400px;
                width: 80%;
            }
            .modal h2 {
                color: #910910;
                margin-bottom: 10px;
                font-size: 22px;
            }
            .modal p {
                color: #333;
                margin-bottom: 20px;
                font-size: 15px;
            }
            .modal button {
                background: #910910;
                color: #fff;
                border: none;
                padding: 10px 20px;
                border-radius: 4px;
                cursor: pointer;
                font-size: 16px;
                margin: 0.5rem;
            }
            .modal button:hover {
                background: #FF1744;
            }
            .modal-buttons {
                display: flex;
                justify-content: center;
                gap: 10px;
                flex-wrap: wrap;
            }
        </style>
        ';
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




    

        
        <div class="cadastrar-container">

            <div class="perfil-container">
                    
                    <div class="nav-titulo-obra">
                        <a class="coracao-favorito">
                            <?php echo $nome;
                                $estaFavoritada = false;
                                if ($usuarioLogado && isset($_SESSION['id'])) {
                                    $idUsuarioLogado = $_SESSION['id'];

                                    $sqlFav = "SELECT 1 FROM tcc_favorito WHERE idUsuario = ? AND idObra = ? LIMIT 1";
                                    $stmtFav = mysqli_prepare($conn, $sqlFav);
                                    mysqli_stmt_bind_param($stmtFav, "ii", $idUsuarioLogado, $idObra);
                                    mysqli_stmt_execute($stmtFav);
                                    $resultFav = mysqli_stmt_get_result($stmtFav);
                                    $estaFavoritada = (mysqli_num_rows($resultFav) > 0);
                                    mysqli_stmt_close($stmtFav);
                                }
                                ?>
                                <!-- Na parte do HTML que imprime o coração: -->
                                <img id="favorito-<?php echo $idObra; ?>"
                                     src="imagens/<?php echo $estaFavoritada ? 'favorito-vermelho.png' : 'favorito-bege.png'; ?>"
                                     alt="Favoritar"
                                     <?php if ($usuarioLogado): ?>
                                         onclick="favoritar(<?php echo $idObra; ?>)"
                                     <?php else: ?>
                                         onclick="loginShow()"
                                     <?php endif; ?>
                                >

                        </a>

                    </div>
                    <div class="fotoPerfil" tabindex="0">
                        <span class="fotoPerfil-image">
                            <img id="preview" src="<?php echo empty($fotoPerfil) ? 'imagens/login-bege.png' : $fotoPerfil; ?>" alt="Foto de Perfil">
                        </span>
                        <input type="file" name="fotoPerfil-name" value="<?php echo $fotoPerfil; ?>" accept="image/*" class="fotoPerfil-input" onchange="previewImage(event)" disabled /> 
                    </div>
                    <div class="nav-list-usuario">
                        <a class="login-usuario" <?php echo $usuarioLogado ? 'href="perfil_usuario.php?login=' . urlencode($login) . '"' : 'onclick="loginShow()"'?>>
                            <img src="<?php echo empty($fotoLogin) ? 'imagens/usuario-bege.png' : $fotoLogin; ?>" alt="Usuário"><?php echo $login; ?>
                        </a>
                    </div>
            </div>
            

                    <div class="nav-list-biografia">
                        <h2 class="informacoes-obra">Biografia:</h2>

                    <div class="nav-list-informacoes">
                         <div class="nav-list-dados">
                            <a href="#" class="texto-logar-cad"><strong>Categoria:</strong> <?php echo $categoria; ?></a>
                            <a href="#" class="texto-logar-cad"><strong>Autor/Diretor:</strong> <?php echo $autor_diretor; ?></a>
                            <a href="#" class="texto-logar-cad"><strong>Classificação etária:</strong> <?php echo $classificacao_num; ?> anos. <?php echo $classificacao_text; ?></a>
                            <a href="#" class="texto-logar-cad"><strong>Sinopse:</strong> <?php echo $sinopse; ?></a>
                        </div>
                        <div class="nav-list-dados-two">
                            <a href="#" class="texto-logar-cad"><strong>Ano de lançamento:</strong> <?php echo $ano_lancamento; ?></a>
                            <a href="#" class="texto-logar-cad" ><strong>Gênero:</strong> <?php echo $genero; ?></a>
                            <a href="#" class="texto-logar-cad"><strong>Onde encontrar:</strong> <?php echo $onde_assistir; ?></a>
                        </div>
                    </div>   
                        

                    <form class="form-comentario" method="POST" action="obras02.php" onsubmit="return checarLogin();">
                        <input type="hidden" name="nomeObra" value="<?php echo htmlspecialchars($nome); ?>">
                        <input type="hidden" name="categoria" value="<?php echo htmlspecialchars($categoria); ?>">
                        <div class="container-comentario">
                            <textarea type="text" class="comentario" id="comentario" name="comentario" placeholder="Comente o que você achou da obra..."></textarea>
                            <div class="comentario-imagem">
                                <button type="submit" name="enviarComentario" >
                                    <img src="imagens/enviar-mensagem.png" alt="Ícone enviar">
                                </button>    
                            </div>
                        </div>
                    </form>
                    <?php if ($erroComentario) { include 'erro_comentario.php'; } ?>

                     <div class="container-principal-chat">
                       <ul class="nav-list-chat" id="chat">
                        <?php  
                            $sql3 = "SELECT c.id AS idComentario, c.idUsuario AS idUsuarioComentario, c.comentario, c.data_comentario, p.login, p.fotoPerfil
                                 FROM tcc_comentario c
                                 JOIN tcc_pessoa p ON c.idUsuario = p.id
                                 WHERE c.nomeObra = ? AND c.categoria = ?
                                 ORDER BY c.data_comentario DESC";

                            $stmt3 = mysqli_prepare($conn, $sql3);
                            if (!$stmt3) {
                                die("Erro ao preparar a consulta SQL3: " . mysqli_error($conn));
                            }
                            if (!mysqli_stmt_bind_param($stmt3, "ss", $nome, $categoria)) {
                                die("Erro ao víncular parâmentros");
                            }
                            if(!mysqli_stmt_execute($stmt3)) {
                                die("Erro ao executar!");
                            }
                            $resultado3 = mysqli_stmt_get_result($stmt3);
                        
                            while ($comentario = mysqli_fetch_assoc($resultado3)){
                                $idComentario = $comentario['idComentario'];
                                $coment = htmlspecialchars($comentario['comentario'], ENT_QUOTES, 'UTF-8');
                                $loginComentario = $comentario['login'];
                                $fotoUsuarioComentario = !empty($comentario['fotoPerfil']) ? $comentario['fotoPerfil'] : 'imagens/usuario-bege.png';

                                echo '<li class="container-chat">';
                                   echo '<div class="container-organizador">';
                                        echo '<div class="container-usuario-chat">';
                                            echo '<a class="usuario-chat"' . ($usuarioLogado ? 'href="perfil_usuario.php?login=' . urlencode($loginComentario) . '"' : '" onclick="loginShow()"') . '>
                                            <img src="'. $fotoUsuarioComentario . '" alt="Usuário"> '. $loginComentario .
                                        '</a>';
                                        echo '<p class="tempo-chat">' . date('d/m/Y H:i', strtotime($comentario['data_comentario'])) . '</p>';
                                        echo '</div>';
                                       
                                       echo '<div class="container-likes">';
                                       if($usuarioLogado) {
                                            echo '<a class="like-chat" href="#" id="like-chat-' . $id . '" data-like-id="' . $id . '">
                                                <img class="like" src="imagens/like.png" alt="like">
                                                <img class="like-verde" src="imagens/like-verde.png" alt="Like-verde">
                                                <label class="numeros-like-label"></label>
                                            </a>';
                                       } else {
                                            echo '<a class="like-chat" onclick="facaCadastro()">
                                                <img class="like" src="imagens/like.png" alt="like">
                                            </a>';
                                       }

                                       if($usuarioLogado) {
                                            echo '<a class="deslike-chat" href="#"  id="deslike-chat-' . $id . '" data-deslike-id="' . $id . '">
                                                <img class="deslike" src="imagens/deslike.png" alt="deslike">
                                                <img class="deslike-verde" src="imagens/deslike-verde.png" alt="deslike-verde">
                                                <label class="numeros-deslike-label"></label>
                                            </a>';
                                       } else {
                                            echo '<a class="deslike-chat" onclick="facaCadastro()">
                                            <img class="deslike" src="imagens/deslike.png" alt="deslike">
                                            </a>';
                                       }
                                           
                                        if ($usuarioLogado) {
                                            echo '<a class="responder-chat" href="#">
                                                <label class="responder">Responder</label>
                                            </a>';
                                        } else {
                                            echo '<a class="responder-chat" onclick="facaCadastro()">
                                                <label class="responder">Responder</label>
                                            </a>';
                                        }
                                            echo '<a class="tres-pontos" id="tres-pontos-'. $idComentario .'" href="#" onclick="deleteComentarioShow(' . $idComentario . '); return false;">
                                                <img src="imagens/tres-pontos.png" alt="três pontos">
                                            </a>';

                                            echo '<div class="container-delete" id="container-delete-'. $idComentario .'">';
                                            if ($usuarioLogado && $_SESSION['id'] == $comentario['idUsuarioComentario']) {
                                                echo '<form action="deletarComentario.php" method="POST">';
                                                echo '<input type="hidden" name="id-comentario" value="' . $comentario['idComentario'] . '">';
                                                echo '<input type="hidden" name="id-usuario-comentario" value="' . $comentario['idUsuarioComentario'] . '">';
                                                echo '<input type="hidden" name="id-usuario-logado" value="' . $_SESSION['id'] . '">';
                                                echo '<input type="hidden" name="nomeObra" value="' . htmlspecialchars($nome) . '">';
                                                echo '<input type="hidden" name="categoria" value="' . htmlspecialchars($categoria) . '">';
                                                echo '<button type="submit" class="delete-chat">Deletar</button>';
                                                echo '</form>';
                                            }

                                            if($usuarioLogado) {
                                                echo '<button type="button" class="denunciar-chat"
                                                        data-id-comentario="' . $comentario['idComentario'] . '"
                                                        data-id-usuario-comentario="' . $comentario['idUsuarioComentario'] . '"
                                                        onclick="denunciarComentario(this)">Denunciar</button>';
                                            } else {
                                                echo '<button type="button" class="denunciar-chat" onclick="facaCadastro()">Denunciar</button>';
                                            }
                                            echo '</div>';
                                       echo '</div>';
                                    echo '</div>'; 
                                        
                                        
                                        echo '<p class="comentario-usuario">' . $coment . '</p>';
                                   echo '</li>';
                               
                            }
                        ?>
                        </ul>

                        <div class="sem-comentario" id="sem-comentario">
                            <img src="imagens/sem-comentario.png">
                        </div>
                    </div>

                
            </div>

        </div>




        <div class="denunciarComentario" style="display: none;">
            <h3 class="texto-logar-cad">Denunciar comentário:</h3>
            <form name="form denunciar" action="denunciar02.php" method="POST"> 
                <br>     
                <input type="hidden" name="id-comentario" value="<?php echo $comentario['idComentario'] ?>">
                <input type="hidden" name="id-usuario-comentario" value="<?php echo $comentario['idUsuarioComentario'] ?>">
                <input type="hidden" name="id-usuario-logado" value="<?php echo (isset($_SESSION['id']) ? $_SESSION['id'] : '') ?>">
                <input type="hidden" name="nomeObra" value="<?php echo htmlspecialchars($nome) ?>">
                <input type="hidden" name="categoria" value="<?php echo htmlspecialchars($categoria) ?>">
                <select name="selectDenunciar">
                    <option disabled selected>Tipo de denuncia</option>
                    <option value="ofensivo">Conteúdo Ofensivo/Ódio</option>
                    <option value="assedio">Assédio/Bullying</option>
                    <option value="perigoso">Conteúdo Ilícito/Perigoso</option>
                    <option value="span">Spam/Propaganda</option>
                    <option value="fake">Informação Falsa</option>
                    <option value="sexual">Conteúdo Sexual/Explícito</option>
                </select>
                <textarea type="text" name="textoDenuncia" id="textoDenuncia" value="" maxlength="110" placeholder="Justifique..."></textarea> 
                <a class="aVoltar" href="#" onclick="voltarDenunciar()">Voltar</a>
                <br>
                <div class="login-button">
                <input type="submit" name="btEnviar" value="Enviar">
                <br>
            </form>
        </div>


        <?php if ($erroDenObra): ?>
        <?php include 'erro_modal.php'; ?>
        <?php endif; ?>

        <?php 
            if (isset($_SESSION['confirmarDelete'])) {
                include 'sucesso_deletar.html';
                unset($_SESSION['confirmarDelete']); //para exibir apenas uma vez
            }
            if (isset($_SESSION['sucessoDenuncia'])) {
                include 'sucesso_denuncia.html';
                unset($_SESSION['sucessoDenuncia']); //para exibir apenas uma vez
            }
        ?>

      
        

        <div id="trilho"></div> <!--Para funcionar modo escuro-->



   <script>
       function checarLogin() {
            var usuarioLogado = <?php echo $usuarioLogado ? 'true' : 'false'; ?>;
            if (!usuarioLogado) {
                loginShow();
                return false;
            }
            return true;
        }
   </script>
</body>
</html>
