<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Narraverso</title>
    <link rel="stylesheet" href="css/estiloperfil.css">
    <script src="menu.js"></script>
</head>
<body>
   <?php
session_start();
if (!isset($_SESSION['id'])) {
    die("Sessão não iniciada. Faça login primeiro.");
}

require("tccbdconnecta.php");

$id = $_SESSION['id'];

if (!$conn) {
    die("Erro na conexão com o banco de dados: " . mysqli_error($conn));
}

$usuarioLogado = isset($_SESSION['id']);

$sql = "SELECT fotoPerfil, login, seguidores, seguindo, publicacoes, descricao FROM tcc_pessoa WHERE id = $id";
$resultado = mysqli_query($conn, $sql);

if (!$resultado) {
    die("Erro na consulta SQL: " . mysqli_error($conn));
}

if (mysqli_num_rows($resultado) > 0) {
    $dados = mysqli_fetch_assoc($resultado);
    $fotoPerfil = !empty($dados['fotoPerfil']) ? $dados['fotoPerfil'] : 'imagens/login-bege.png';
    $login = $dados['login'];
    $seguidores = $dados['seguidores'];
    $seguindo = $dados['seguindo'];
    $publicacoes = $dados['publicacoes'];
    $descricao = $dados['descricao'];
} else {
    die("Usuário não encontrado.");
}

if ($seguidores == 0) $seguidores = 0;
if ($seguindo == 0) $seguindo = 0;
if ($publicacoes == 0) $publicacoes = 0;



//Verificação se há obras
if (!$conn) {
    die("Erro com a conexão com o banco de dados: " .mysqli_connect_error());
}

$categoria = isset($_GET['categoria']) ? mysqli_real_escape_string($conn, $_GET['categoria']) : '';

if (empty($categoria)) {
//verifica qual categoria tem as obras
$categorias = ['filme', 'serie', 'livro'];

foreach ($categorias as $cat) {
$sqlCheck = "SELECT 1 FROM tcc_obra WHERE categoria = '$cat' LIMIT 1";
$resultadoCheck = mysqli_query($conn, $sqlCheck);

    if ($resultadoCheck && mysqli_num_rows($resultadoCheck) > 0) {
        header("Location: ?categoria=$cat");
        exit;
    }
}

//Se nenhuma categoria tiver obras
$categoria = 'filme'; 
}


//--------------modal delete----------------------------------------
    if (isset($_SESSION['confirmar_delete_dados'])) {
    $deleteData = $_SESSION['confirmar_delete_dados'];
    unset($_SESSION['confirmar_delete_dados']); // Evita repetir a modal após reload

    // **CORREÇÃO:**
    // Define as variáveis localmente, usando '' (string vazia) como default 
    // caso a chave não exista no array $deleteData.
    $idObra  = $deleteData['idObra'] ?? '';
    $idUsuario = $deleteData['id'] ?? ''; // O ID do usuário logado já está em $id, mas é bom pegar da sessão se for o caso
    $nomeObra = $deleteData['nome'] ?? '';
    $categoria = $deleteData['categoria'] ?? '';
    $login   = $deleteData['login'] ?? $login; // Usa o $login já definido no topo do arquivo se o login não vier na sessão

    echo '
    <div class="modal-overlay">
        <div class="modal">
            <h2>Atenção!</h2>
            <p>Você tem certeza que<br> deseja deletar esta Obra?</p>
            <div class="modal-buttons">
                <form action="deletarObraConfirmado.php" method="POST">
                    <input type="hidden" name="id-obra" value="' . htmlspecialchars($idObra) . '">
                    <input type="hidden" name="id-usuario-logado" value="' . htmlspecialchars($idUsuario) . '">
                    <input type="hidden" name="nomeObra" value="' . htmlspecialchars($nomeObra) . '">
                    <input type="hidden" name="categoria" value="' . htmlspecialchars($categoria) . '">
                    <input type="hidden" name="confirmar_delete" value="sim">
                    <button type="submit">Deletar</button>
                </form>
                <button onclick="window.location.href=\'perfil_pessoal.php?login=' . urlencode($login) . '&categoria=' . urlencode($categoria) . '\'">Voltar</button>
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
            
                <div class="nav-informacoes">
                    <div class="obras-informacao">
                        <div class="perfil-container">
                                <div class="perfil-foto">
                                    <label class="fotoPerfil" tabindex="0">
                                        <span class="fotoPerfil-image">
                                            <img id="preview" src="<?php echo empty($fotoPerfil) ? 'imagens/login-bege.png' : $fotoPerfil; ?>" alt="Foto de Perfil">
                                        </span>
                                        <input type="file" name="fotoPerfil-name" value="<?php echo $fotoPerfil; ?>" accept="image/*" class="fotoPerfil-input" onchange="previewImage(event)" disabled /> 
                                    </label>
                                <button type="button" class="edit-button" onclick="window.location.href='cadastroUpdate01.php?id=<?php echo $id; ?>'" >Editar perfil</button>
                            </div>
                        </div>

                        <div class="nav-list-informacoes">
                        <div class="nav-list-usuario">
                            <label class="login-usuario"><?php echo $login; ?></label>
                        </div>

                        <div class="nav-list-dados">
                            <a href="#" class="numero-seguidores" id="numero-seguidores">Seguidores:<br> <?php echo $seguidores; ?></a>
                            <a href="#" class="numero-seguindo" id="numero-seguindo">Seguindo:<br> <?php echo $seguindo; ?></a>
                            <a href="#" class="numero-publicacao">Publicações:<br> <?php echo $publicacoes; ?></a>
                        </div>

                        <div class="nav-list-descricao">
                            <label class="texto-descricao"><?php echo $descricao; ?></label>
                        </div>
                    </div>
                    </div>
                        

                    

                    <!--Mostrar as obras-->
                    <div class="container-principal-perfil" id="container-principal-perfil">
                        <div class="icone-container">
                            <?php
                                function getIcon($cat, $categoriaAtual) {
                                    $cor = $cat === $categoriaAtual ? 'verde' : 'vermelho';
                                    return "imagens/{$cat}-{$cor}.png";
                            }
                            ?>
                            <a href="?login=<?= urlencode($login) ?>&categoria=filme" class="icone-filme"><img src="<?php echo getIcon('filme', $categoria);?>" alt="filme" title="Filmes"></a>
                            <a href="?login=<?= urlencode($login) ?>&categoria=serie" class="icone-serie"><img src="<?php echo getIcon('serie', $categoria);?>" alt="serie" title="Séries"></a>
                            <a href="?login=<?= urlencode($login) ?>&categoria=livro" class="icone-livro"><img src="<?php echo getIcon('livro', $categoria);?>" alt="livro" title="Livros"></a>
                        </div>
                        <ul class="obras-perfil" id="obras-perfil">
                            <?php

                                $sql = "SELECT idObra, nome, fotoPerfil, categoria, genero FROM tcc_obra WHERE categoria = '$categoria' AND idUsuario = $id";

                                $resultado = mysqli_query($conn, $sql);

                                if (!$resultado) {
                                    die("Erro ao fazer a consulta SQL: " .mysqli_error($conn));
                                }

                                if (mysqli_num_rows($resultado) > 0) { //quatas linhas retornou da nossa pesquisa
                                    while ($dados = mysqli_fetch_assoc($resultado)){ //mostra resultado da pesquisa 
                                        $fotoObra = !empty($dados['fotoPerfil']) ? $dados['fotoPerfil'] : 'imagens/imagem-obras.png';
                                        $idObra = $dados['idObra'];
                                        $nome = $dados['nome'];
                                        $categoria = $dados['categoria'];
                                        $genero = $dados['genero'];

                                        echo '<li class="obras" data-tipo="' . $categoria .'"  data-genero="' . $genero . '">
                                            <a href="obras.php?nome=' . urlencode($nome) . '&categoria=' . urlencode($categoria) . '" style="text-decoration: none; color: inherit;">
                                                <div class="obras-image">
                                                    <img id="preview-obra" src="' . $fotoObra . '" alt="Imagem da obra">
                                                    <div class="tres-pontos" id="tres-pontos-' . $idObra . '" onclick="deleteComentarioShow(' . $idObra . '); return false;">
                                                        <img src="imagens/tres-pontos1.png" alt="três pontos">
                                                    </div>
                                                </div>
                                                <div class="conteudo-obras">
                                                    <h2 class="conteudo-nome">
                                                        '. $nome .'
                                                    </h2>
                                                </div>
                                            </a>';
                                        echo '<div class="container-delete" id="container-delete-' . $idObra . '">';
                                        echo '<form action="deletarObra.php" method="POST">';
                                        echo '<input type="hidden" name="id-obra" value="' . $idObra . '">';
                                        echo '<input type="hidden" name="id-usuario-logado" value="' . $id . '">';
                                        echo '<input type="hidden" name="nomeObra" value="' . htmlspecialchars($nome) . '">';
                                        echo '<input type="hidden" name="categoria" value="' . htmlspecialchars($categoria) . '">';
                                        echo '<button type="submit" class="delete-chat">Deletar</button>';
                                        echo '</form>
                                        </li>
                                        ';
                                    } //enquanto houver resultado aparece
                                } else {
                                    echo '<li class="sem_resultado" id="sem_resultado">
                                        <img src="imagens/sem-obra.png" alt="sem obra">
                                    </li>';
                                }
                            ?>
                        </ul>    
                    </div>
                </div>

        </div>



        <div class="seguidores-overlay">
            <div class="container-principal-seguidores">
                <form class="form-seguidor" method="POST">
                    <div class="container-pesquisa">
                        <div class="pesquisa-imagem">
                            <img src="imagens/pesquisa-container.png" alt="Ícone de pesquisa">
                        </div>
                        <input type="text" class="barra-pesquisa" id="barra-pesquisa" name="pesquisa" placeholder="Pesquise obras, usuários (obrigatório @ antes)...">
                    </div>
                </form>
                <?php echo '<h2 class="contas-titulo" id="titulo-seguidores"><br>Seguidores:</h2>'; ?>
                    <ul class="container-seguidores">
                        <?php

                        $pesquisa = isset($_POST['pesquisa']) ? $_POST['pesquisa'] : '';

                        $pesquisa = mysqli_real_escape_string($conn, $pesquisa);

                        $sql2 = "SELECT p.fotoPerfil, p.login
                        FROM tcc_seguidores s
                        JOIN tcc_pessoa p ON p.id = s.seguidor_id
                        WHERE s.seguido_id = $id AND p.login LIKE '$pesquisa%'";

                        $stmt2 = mysqli_query($conn, $sql2);

                        if (!$stmt2) {
                            die("Erro ao fazer a consulta SQL: " .mysqli_error($conn));
                        }



                        if (mysqli_num_rows($stmt2) > 0) { //quatas linhas retornou da nossa pesquisa
                            while ($dados = mysqli_fetch_assoc($stmt2)){ //mostra resultado da pesquisa 
                                $fotoPessoa = !empty($dados['fotoPerfil']) ? $dados['fotoPerfil'] : 'imagens/imagem-obras.png';
                                $login = $dados['login'];


                                    echo '<li class="pessoas">';

                                        echo'<a href="perfil_usuario.php?login=' . urlencode($login) . '">';


                                        echo '<div class="pessoas-image">
                                            <img id="pessoa-preview" src="' . $fotoPessoa . '" alt="Imagem da Usuario">
                                        </div>
                                    </a>
                                        <div class="conteudo-obras">
                                            <h2 class="conteudo-nome">
                                                '. $login .'
                                            </h2>
                                        </div>
                                </li>';

                            } //enquanto houver resultado aparece
                        }
                        
                        echo '<li class="sem-obra" id="sem-obra">
                                <img src="imagens/sem-conta.png">
                            </li>';
                        
                    ?>
                </ul>


                <?php echo '<h2 class="contas-titulo" id="titulo-seguindo"><br>Seguindo:</h2>'; ?>
                    <ul class="container-seguindo">
                        <?php

                        $pesquisa = isset($_POST['pesquisa']) ? $_POST['pesquisa'] : '';


                        $pesquisa = mysqli_real_escape_string($conn, $pesquisa);

                        $sql3 = "SELECT p.fotoPerfil, p.login
                        FROM tcc_seguidores s
                        JOIN tcc_pessoa p ON p.id = s.seguido_id
                        WHERE s.seguidor_id = $id AND p.login LIKE '$pesquisa%'";

                        $stmt3 = mysqli_query($conn, $sql3);

                        if (!$stmt3) {
                            die("Erro ao fazer a consulta SQL: " .mysqli_error($conn));
                        }



                        if (mysqli_num_rows($stmt3) > 0) { //quatas linhas retornou da nossa pesquisa
                            while ($dados = mysqli_fetch_assoc($stmt3)){ //mostra resultado da pesquisa 
                                $fotoPessoa = !empty($dados['fotoPerfil']) ? $dados['fotoPerfil'] : 'imagens/imagem-obras.png';
                                $login = $dados['login'];


                                    echo '<li class="pessoas">';

                                        echo'<a href="perfil_usuario.php?login=' . urlencode($login) . '">';


                                        echo '<div class="pessoas-image">
                                            <img id="pessoa-preview" src="' . $fotoPessoa . '" alt="Imagem da Usuario">
                                        </div>
                                    </a>
                                        <div class="conteudo-obras">
                                            <h2 class="conteudo-nome">
                                                '. $login .'
                                            </h2>
                                        </div>
                                </li>';

                            } //enquanto houver resultado aparece
                        }

                        echo '<li class="sem-obra" id="sem-obra2">
                                <img src="imagens/sem-conta.png">
                            </li>';

                        mysqli_close($conn);
                        
                    ?>
                </ul>
                
                <br>
                    <a class="fechar-seguidores">Voltar</a>

            </div>
        </div>
        
        

        <div id="trilho"></div> <!--Para funcionar modo escuro-->

                    
    </header>


   
</body>
</html>
