//códigos: index, login, quem somos, cadastrar pessoas e obras
    // Visibilidade do menu ao clicar no ícone
    document.addEventListener("DOMContentLoaded", function () {
        const menu = document.querySelector(".nav-list-menu"); // Menu
        const menuButton = document.querySelector("#menu-toggle"); // Botão que abre o menu

        if (menu && menuButton) {
            // Toggle da classe 'active' no menu ao clicar no ícone
            menuButton.addEventListener("click", function () {
                if (menu.classList.toggle("active")) {
                    document.querySelector('.nav-link img[alt="menu"]').src = "imagens/menu-verde.png";
                } else {
                    document.querySelector('.nav-link img[alt="menu"]').src = "imagens/menu-bege.png";
                }
            });
        }
    });



    /*abre o login e troca de cor*/
    function loginShow() {
        let loginCad = document.querySelector('.logar-cad');
        if (loginCad) {
            // Verifica se a tela de login está visível
            if (loginCad.classList.contains('open')) {
                loginCad.classList.remove('open');
                loginCad.style.display = "none"; // Esconde a tela
                document.querySelector('.nav-item img[alt="Usuario"]').src = "imagens/usuario-bege.png";
            } else {
                loginCad.classList.add('open');
                loginCad.style.display = "block"; // Garante que a tela apareça
                document.querySelector('.nav-item img[alt="Usuario"]').src = "imagens/usuario-verde.png";
                document.querySelector('.nav-link-casa img[alt="casa"]').src = "imagens/casa-bege.png";
            }
        }
    }



    /*-------------------------------parte para logar-----------------------------------------------*/
    function logar() {
        let loginCad = document.querySelector('.logar-cad');
        let logarElement = document.querySelector('.logar');

        if (logarElement) {
            if (logarElement.classList.contains('open')) {
                logarElement.classList.remove('open');
                logarElement.style.display = "none"; // Esconde a tela de login
            } else {
                logarElement.classList.add('open');
                logarElement.style.display = "block"; // Exibe a tela de login
                if (loginCad) loginCad.classList.remove('open'); // Esconde a tela de cadastro

                // Mantém o ícone do usuário verde ao clicar em "Entrar"
                document.querySelector('.nav-item img[alt="Usuario"]').src = "imagens/usuario-verde.png";
                document.querySelector('.nav-link-casa img[alt="casa"]').src = "imagens/casa-bege.png";
            }
        }
    }


    function fecharLogin() {
        let loginCad = document.querySelector('.logar-cad'); // Tela inicial do login/cadastro
        let logarElement = document.querySelector('.logar'); // Tela de login
        let esqueciSenhaElement = document.querySelector('.esqueciSenha'); // Tela de recuperação de senha

        // Esconder todas as telas de login/cadastro/esqueci senha
        if (logarElement) logarElement.style.display = "none";
        if (esqueciSenhaElement) esqueciSenhaElement.style.display = "none";

        // Voltar para a tela inicial de login/cadastro
        if (loginCad) loginCad.style.display = "block";
    }


    function fecharLogarCad() {
        let loginCad = document.querySelector('.logar-cad'); // Seleciona a tela inicial de login/cadastro

        if (loginCad) {
            loginCad.style.display = "none"; // Esconde a tela de login/cadastro

            // Alterar imagem do ícone para estado original
            let usuarioIcon = document.querySelector('.nav-link-login img[alt="Usuario"]');
            if (usuarioIcon) usuarioIcon.src = "imagens/usuario-bege.png";
        }
    }


    /*----------------------------parte esqueci senha----------------------------------*/

    function esqueciSenha() {
        document.querySelector(".logar").style.display = "none";  // Esconde o login
        document.querySelector(".esqueciSenha").style.display = "block";  // Mostra a recuperação de senha
    }

    function voltarLogin() {
        document.querySelector(".esqueciSenha").style.display = "none"; // Esconde recuperação de senha
        document.querySelector(".logar").style.display = "block"; // Mostra o login novamente
    }




    /*Mostrar/esconder senha*/
    function mostrarSenha() {
       const senhaInput = document.getElementById('senhaUsu');
       const olhoImg = document.querySelector('.olho-mostra');

       if (senhaInput.type === 'password') {
        senhaInput.type = 'text';
        olhoImg.src = 'imagens/olho-aberto.png';
       } else {
        senhaInput.type = 'password';
        olhoImg.src = 'imagens/olho-fechado.png';
       }
    }




     /*Quando clica no favorito e cadastrar obra*/
    function facaCadastro() {
        const menu = document.querySelector(".nav-list-menu"); // Menu

        if (menu) {
            menu.classList.remove("active");//não quero que esteja mais ativo

            //Trocar cor do icone do menu
            const icon = document.querySelector('.nav-link img[alt="menu"]'); 
            if(icon){
                icon.src = "imagens/menu-bege.png";
            }

            let loginCad = document.querySelector('.logar-cad');
            if (loginCad) {
                //Abre a tela de login está visível
                loginCad.classList.add('open');
                loginCad.style.display = "block"; // Garante que a tela apareça
                document.querySelector('.nav-item img[alt="Usuario"]').src = "imagens/usuario-verde.png";
                document.querySelector('.nav-link-casa img[alt="casa"]').src = "imagens/casa-bege.png";
            }
        }   
    }






    /*-------------------------------parte cadastro de pessoas--------------*/
    function cadastrar() {
        window.location.href = "cadastro01.php";
    }

    function previewImage(event) {
        const reader = new FileReader();
        reader.onload = function () {
            const preview = document.getElementById('preview');
            if (preview) {
                preview.src = reader.result; // Exibe a imagem escolhida pelo usuário
            }
        }
        if (event.target.files.length > 0) {
            reader.readAsDataURL(event.target.files[0]);
        }
    }

    function resetImage() {
        const preview = document.getElementById('preview');
        if (preview) {
            preview.src = 'imagens/login-bege.png'; // Define a imagem padrão
        }
        const inputFile = document.querySelector('.fotoPerfil-input');
        if (inputFile) {
            inputFile.value = ''; // Limpa o input de arquivo
        }
    }

    function fixaArroba() {
        const input = document.getElementById("login");
        if (input && !input.value.startsWith("@")) {
            input.value = "@" + input.value.replace(/^@+/, "");
        }
    }

    function salvarDados() {
        window.location.href = "cadastro02.html";
    }

    // Botão voltar
    function voltar() {
        window.history.back();
    }

    // Botão sair da conta
    function sair() {
        window.location.href = "logout.php";
    }

    function confirmarSaida() {
        window.location.href = "confirmarSaida.php";
    }


    // Botão voltar
    function voltarSaida() {
        const modal = document.querySelector('.modal-overlay');

        if(modal) {
            modal.style.display = "none";
        } 
    }




    /*------------Configurações-------------------*/
    window.onload = function() {
   // tudo que tem dentro do menu.js para rodar tudo mesmo ele estando emcima do html 
        let trilho = document.getElementById('trilho');
        let body = document.body; 

        if (trilho) { //verifica se trilho existe
            // Carregar preferência ao abrir a página
            if (localStorage.getItem('modo') === 'dark') {
                body.classList.add('dark');
                trilho.classList.add('dark');
            }

            // Clicar no trilho
            trilho.addEventListener('click', () => {
                body.classList.toggle('dark');
                trilho.classList.toggle('dark');

                // Salvar a preferência
                if (body.classList.contains('dark')) {
                    localStorage.setItem('modo', 'dark');
                } else {
                    localStorage.setItem('modo', 'light');
                }
            });
        }
        
    };






    /*-------------------------------------Carrossel-------------------------------------*/ 
    document.addEventListener("DOMContentLoaded", function () {
        const track = document.querySelector('.carrossel-track');
        const items = document.querySelectorAll('.carrossel-item');
        let currentIndex = 0;

        if (track && items.length > 0) {
            // Função para atualizar a posição do carrossel
            function updateCarrossel() {
                const width = items[0].getBoundingClientRect().width;
                track.style.transform = `translateX(-${currentIndex * width}px)`;
            }

            // Função para avançar automaticamente
            function autoAdvance() {
                currentIndex = (currentIndex + 1) % items.length;
                updateCarrossel();
            }

            // Inicia o carrossel automático a cada 3 segundos
            setInterval(autoAdvance, 3000);
        }

        
        
    });




    //cadObra

    /*parte para chekbox do gêneros*/
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


 





// Botão para obras
    function obras() {
        window.location.href = "obras.php";
    }

     //-----------------------Favoritar-------------------------
    function favoritar(idObra) {
        fetch('favorito02.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: 'idObra=' + encodeURIComponent(idObra)
        })
        .then(response => response.json())
        .then(data => {
            if (data.favorito) {
                // Atualiza imagem para favoritado
                document.getElementById('favorito-' + idObra).src = 'imagens/favorito-vermelho.png';
            } else {
                // Atualiza imagem para não favoritado
                document.getElementById('favorito-' + idObra).src = 'imagens/favorito-bege.png';
            }
        })
        .catch(error => {
            console.error('Erro ao favoritar:', error);
        });
    }



     // -----------------------Com comentários-------------------------
     window.addEventListener('DOMContentLoaded', () => {
        const chat = document.getElementById('chat');
        const imagem = document.getElementById('sem-comentario');

        if (!imagem) {
            console.warn('Elemento com id="sem-comentario" não encontrado.');
            return;
        }

        if (chat && chat.children.length > 0) {
            imagem.style.display = "none";
        } else {
            imagem.style.display = "flex";
        }
    });

     



    //-----------------------Pesquisa--------------------------

    window.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.getElementById('barra-pesquisa');

    if (searchInput) {
        searchInput.addEventListener('input', (event) => {
            const valor = event.target.value.trim();
            const valorFormatacao = formaString(valor);

            const listaObras = document.querySelectorAll('.container-obras .obras');
            const listaPessoas = document.querySelectorAll('.container-obras .pessoas');
            const semResultado = document.getElementById('sem_resultado');
            const conteudoContas = document.getElementById('contas-titulo');
            const conteudoObras = document.getElementById('obras-titulo'); // Supondo que seja o id do título das obras

            if (valor === ''){
                // Mostrar todas as obras
                listaObras.forEach(obras => obras.style.display = 'flex');

                // Esconder todas as pessoas
                listaPessoas.forEach(pessoa => pessoa.style.display = 'none');

                // Mostrar título das obras
                if (conteudoObras) conteudoObras.style.display = 'flex';

                // Esconder título das pessoas
                if (conteudoContas) conteudoContas.style.display = 'none';

                // Esconder mensagem de "Nenhum resultado"
                if (semResultado) semResultado.style.display = 'none';

                return;
            }

            if (listaObras && semResultado) {

                let algumVisivel = false;

                listaObras.forEach(item => {
                    item.style.display = '';
                    algumVisivel = true;
                });

                if (!listaObras.length) {
                    semResultado.style.display = 'block';
                }
            }

            let hasResultado = false;
            let pessoasComResultado = false;
            let obrasComResultado = false;

            listaObras.forEach(obras => {
                const obrasTitle = obras.querySelector('.conteudo-nome').textContent;
                if (formaString(obrasTitle).startsWith(valorFormatacao)) {
                    obras.style.display = 'flex';
                    hasResultado = true;
                    obrasComResultado = true;
                } else {
                    obras.style.display = 'none';
                }
            });

            listaPessoas.forEach(pessoa => {
                const pessoasTitle = pessoa.querySelector('.conteudo-nome').textContent;
                if (formaString(pessoasTitle).indexOf(valorFormatacao) !== -1)  {
                    pessoa.style.display = 'flex';
                    hasResultado = true;
                    pessoasComResultado = true;
                } else {
                    pessoa.style.display = 'none';
                }
            });

            // Mostrar ou esconder título das obras
            
            if (obrasComResultado && searchInput.value.trim() !== '') {
                if (conteudoObras) conteudoObras.style.display = 'flex';
            } else {
                if (conteudoObras) conteudoObras.style.display = 'none';
            }

            // Mostrar ou esconder título das contas (pessoas)
            
            if (pessoasComResultado && searchInput.value.trim() !== '') {
                if (conteudoContas) conteudoContas.style.display = 'flex';
            } else {
                if (conteudoContas) conteudoContas.style.display = 'none';
            }

            // Mostrar mensagem "Nenhum resultado"
            if (semResultado) {
                if (hasResultado) {
                    semResultado.style.display = 'none';
                } else {
                    semResultado.style.display = 'block';
                }
            }
            
        });
    }

    function formaString(valorFormatacao) {
        return valorFormatacao.toLowerCase().trim().normalize('NFD').replace(/[\u0300-\u036f]/g, '');
    }
});


/*-----------------------------------Obras Index-----------------------------*/


document.addEventListener("DOMContentLoaded", function () {


        const listaObras = document.querySelectorAll('.container-obras-index .obras');
        const semResultado = document.getElementById('sem_resultado');

        listaObras.forEach(obras => { //todas as obras que recebe

            const obrasTitle = obras.querySelector('.conteudo-nome').textContent; //pega o texto apenas do nome da obras

            if (obrasTitle) { 
                obras.style.display = 'flex'; //se for de 0 para cima, existe a obra
                hasResultado = true; //não aparece mensagem de não tem obras
            } else{
                obras.style.display = 'none'; //se for de 0 para baixo, não existe obra
            } 

        });


    // Função para ativar o scroll com as setas
    function configurarSetas(setaEsquerdaId, setaDireitaId, containerId) {
        const setaEsquerda = document.getElementById(setaEsquerdaId);
        const setaDireita = document.getElementById(setaDireitaId);
        const container = document.getElementById(containerId);

        if (setaEsquerda && setaDireita && container) {
            setaEsquerda.addEventListener("click", function () {
                container.scrollBy({
                    left: -300,
                    behavior: "smooth"
                });
            });

            setaDireita.addEventListener("click", function () {
                container.scrollBy({
                    left: 300,
                    behavior: "smooth"
                });
            });
        }
    }

    // Configurar para cada tipo
    configurarSetas("setaEsquerdaFilme", "setaDireitaFilme", "container-filme");
    configurarSetas("setaEsquerdaSerie", "setaDireitaSerie", "container-serie");
    configurarSetas("setaEsquerdaLivro", "setaDireitaLivro", "container-livro");

});

/*-------------------------Perfil do Usuário------------------------*/
document.addEventListener("DOMContentLoaded", function() {
    const buttonSeguir = document.getElementById('edit-button');
    const buttonSeguindo = document.getElementById('edit-button-two');
    const seguidores = document.getElementById('numero-seguidores');
    const perfil = document.getElementById('perfil-seguir');

    if (buttonSeguir && buttonSeguindo && seguidores && perfil) {
        const usuarioId = perfil.getAttribute('data-usuario-id');

        buttonSeguir.addEventListener("click", function() {
            fetch('seguir.php', {
                method: 'POST',
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                body: 'seguido_id=' + encodeURIComponent(usuarioId)
            })
            .then(response => response.text())
            .then(data => {
                if (data === "ok") {
                    buttonSeguir.style.display = "none";
                    buttonSeguindo.style.display = "block";
                    seguidores.textContent = parseInt(seguidores.textContent) + 1;
                    localStorage.setItem(`estadoSeguimento_${usuarioId}`, 'seguindo'); //_${usuarioId} esecifica o usuario
                }
            })
            .catch(err => alert("Erro na requisição: " + err));
        });

        buttonSeguindo.addEventListener("click", function() {
            fetch('deixar_de_seguir.php', {
                method: 'POST',
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                body: 'seguido_id=' + encodeURIComponent(usuarioId)
            })
            .then(response => response.text())
            .then(data => {
                if (data === "ok") {
                    buttonSeguindo.style.display = "none";
                    buttonSeguir.style.display = "block";
                    seguidores.textContent = Math.max(0, parseInt(seguidores.textContent) - 1); //Mínimo 0
                    localStorage.setItem(`estadoSeguimento_${usuarioId}`, 'seguir');
                }
            })
            .catch(err => alert("Erro na requisição: " + err));
        });


        // Salvar a preferência
        const estado = localStorage.getItem(`estadoSeguimento_${usuarioId}`);
        if (estado == 'seguindo') {
            buttonSeguir.style.display = "none";
            buttonSeguindo.style.display = "block"; 
        } else {
            buttonSeguir.style.display = "block";
            buttonSeguindo.style.display = "none"; 
        }
    }

});



// -------------------------------------Aparecer obras perfil pessoal-------------------------
document.addEventListener("DOMContentLoaded", function () {
    const obrasPerfil = document.querySelector(".obras-perfil");
    const semResultado = document.getElementById('sem_resultado');

    if (obrasPerfil && semResultado) {
        if (obrasPerfil) {
            obrasPerfil.style.display = 'grid';

            // Mostra todas as contas de 'seguidores'
            const listaObras = obrasPerfil.querySelectorAll(".obras");

            let algumVisivel = false;

            listaObras.forEach(item => {
                item.style.display = '';
                algumVisivel = true;
            });

            if (!listaObras.length) {
                semResultado.style.display = 'block';
            }
        }
    }
});




/*-----------------------------------------------Visualizando seguidores ou seguindo--------------------------*/
    // parte para abrir 
document.addEventListener("DOMContentLoaded", function () {
    const searchInput = document.getElementById('barra-pesquisa');
    const filtroOverlay = document.querySelector(".seguidores-overlay");
    const voltarBtns = document.querySelectorAll(".fechar-seguidores");
    const containerSeguidores = document.querySelector(".container-seguidores");
    const containerSeguindo = document.querySelector(".container-seguindo");
    const numberSeguidores = document.getElementById("numero-seguidores");
    const numberSeguindo = document.getElementById("numero-seguindo");
    const semResultado = document.getElementById('sem-obra');
    const semResultado2 = document.getElementById('sem-obra2');

    if (numberSeguidores && numberSeguindo && filtroOverlay && voltarBtns) {
        numberSeguidores.addEventListener("click", function (event) {
            event.preventDefault();
            filtroOverlay.classList.add("seguidores-overlay-open");


            if (containerSeguidores) {
                containerSeguidores.style.display = 'grid';

                // Mostra todas as contas de 'seguidores'
                const listaSeguidores = containerSeguidores.querySelectorAll(".pessoas");

                let algumVisivel = false;

                listaSeguidores.forEach(item => {
                    item.style.display = '';
                    algumVisivel = true;
                });

                if (!listaSeguidores.length) {
                    semResultado.style.display = 'block';
                }
            } 
            

            if (containerSeguindo) containerSeguindo.style.display = 'none';
            if (searchInput) searchInput.value = ''; // limpa busca ao abrir
        });

        numberSeguindo.addEventListener("click", function (event) {
            event.preventDefault();
            filtroOverlay.classList.add("seguidores-overlay-open");

            if (containerSeguindo) {
                containerSeguindo.style.display = 'grid';

                // Mostra todas as contas de 'seguindo'
                const listaSeguindo = containerSeguindo.querySelectorAll(".pessoas");

                let algumVisivel = false;

                listaSeguindo.forEach(item => {
                    item.style.display = '';
                    algumVisivel = true;
                });
                
                if (!listaSeguindo.length) {
                    semResultado2.style.display = 'block';
                }
            } 
            

            if (containerSeguidores) containerSeguidores.style.display = 'none';
            if (searchInput) searchInput.value = ''; // limpa busca ao abrir
        });

        // Adiciona evento para todos os botões "Voltar"
        voltarBtns.forEach(function (btn) {
            btn.addEventListener("click", function () {
                filtroOverlay.classList.remove("seguidores-overlay-open");
                containerSeguidores.style.display = 'none';
                containerSeguindo.style.display = 'none';
            });
        });
    }

    filtroOverlay.classList.remove("seguidores-overlay-open");

    semResultado.style.display = 'none';
    semResultado2.style.display = 'none';

    /* Parte de pesquisar */
    if (searchInput) {
        searchInput.addEventListener('input', (event) => {
            const valorFormatacao = formaString(event.target.value);

            const listaSeguidores = document.querySelectorAll('.container-seguidores .pessoas');
            const listaSeguindo = document.querySelectorAll('.container-seguindo .pessoas');
            

            listaSeguidores.forEach(seguidores => {
                const seguidoresTitle = seguidores.querySelector('.conteudo-nome').textContent;
                if (formaString(seguidoresTitle).indexOf(valorFormatacao) !== -1) {
                    seguidores.style.display = '';
                    semResultado.style.display = 'none';
                } else {
                    seguidores.style.display = 'none';
                    semResultado.style.display = 'block';
                }
            });

            listaSeguindo.forEach(seguindo => {
                const seguindoTitle = seguindo.querySelector('.conteudo-nome').textContent;
                if (formaString(seguindoTitle).indexOf(valorFormatacao) !== -1) {
                    seguindo.style.display = '';
                    semResultado2.style.display = 'none';
                } else {
                    seguindo.style.display = 'none';
                    semResultado2.style.display = 'block';
                }
            });
        });
    }

    function formaString(valorFormatacao) {
        return valorFormatacao.toLowerCase().trim().normalize('NFD').replace(/[\u0300-\u036f]/g, '');
    }
});


//-----------------------------------Delete Obra-------------------------------------
function deleteComentarioShow(idObra){
    const container = document.getElementById('container-delete-' + idObra); //não aceita ponto .container
    if (container.classList.contains('open')) {
        container.classList.remove('open');
        container.style.display = 'none';
    } else {
        container.classList.add('open');
        container.style.display = 'flex';
    }
}

function deletarObra() {
    window.location.href="deletarObra.php"
}

//-----------------------------------Delete comentário-------------------------------------
function deleteComentarioShow(idComentario){
    const container = document.getElementById('container-delete-' + idComentario); //não aceita ponto .container
    if (container.classList.contains('open')) {
        container.classList.remove('open');
        container.style.display = 'none';
    } else {
        container.classList.add('open');
        container.style.display = 'flex';
    }
}

function deletarComentario() {
    window.location.href = "deletarComentario.php";
}

// -----------------------------------Denunciar Comentário-------------------------------------
    // Função para lidar com o clique no botão "Denunciar"
function denunciarComentario(button) {
    // Exibe o pop-up de denúncia
    const popupDenuncia = document.querySelector('.denunciarComentario');
    popupDenuncia.style.display = 'block';

    // Pega os dados do botão
    const idComentario = button.getAttribute('data-id-comentario');
    const idUsuarioComentario = button.getAttribute('data-id-usuario-comentario');

    // Preenche os campos do formulário de denúncia
    const form = popupDenuncia.querySelector('form');
    form.querySelector('input[name="id-comentario"]').value = idComentario;
    form.querySelector('input[name="id-usuario-comentario"]').value = idUsuarioComentario;
}

// Função para esconder o pop-up de denúncia
function voltarDenunciar() {
    const popupDenuncia = document.querySelector('.denunciarComentario');
    popupDenuncia.style.display = 'none';
}





/*-------------------------Curtidas comentário------------------------*/
document.addEventListener("DOMContentLoaded", function () {
    const likeButtons = document.querySelectorAll('.like-chat');
    const deslikeButtons = document.querySelectorAll('.deslike-chat');

    // 1. Configurar eventos para LIKES
    likeButtons.forEach(function (likeBtn) {
        const likeId = likeBtn.getAttribute('data-like-id');
        
        // Elementos internos do LIKE
        const likeVerde = likeBtn.querySelector('.like-verde');
        const likeContorno = likeBtn.querySelector('.like');
        const numerosLike = likeBtn.querySelector('.numeros-like-label');
        
        // Busca o DESLIKE correspondente
        const deslikeBtn = document.querySelector(`.deslike-chat[data-deslike-id="${likeId}"]`);

        likeBtn.addEventListener('click', function (e) {
            e.preventDefault();

            fetch('likeComentario.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: 'like_id=' + encodeURIComponent(likeId)
            })
            .then(response => response.text())
            .then(data => {
                if (data === "ok") {
                    
                    // >> INÍCIO DA LÓGICA DE VISUALIZAÇÃO DO LIKE (TOGGLE)
                    const isLiked = likeVerde.style.display === "block";

                    if (!isLiked) {
                        // Ação de CURTIR: Ativa o visual e incrementa
                        likeVerde.style.display = "block";
                        likeContorno.style.display = "none";
                        numerosLike.textContent = parseInt(numerosLike.textContent || 0) + 1;
                        localStorage.setItem(`like_${likeId}`, '1');
                    } else {
                        // Ação de REMOVER CURTIDA: Desativa o visual e decrementa
                        likeVerde.style.display = "none";
                        likeContorno.style.display = "block";
                        numerosLike.textContent = Math.max(0, parseInt(numerosLike.textContent || 0) - 1);
                        localStorage.removeItem(`like_${likeId}`);
                    }
                    // << FIM DA LÓGICA DE VISUALIZAÇÃO DO LIKE

                    // Lógica para DESFAZER DESLIKE (Exclusão Mútua)
                    if (deslikeBtn) {
                        const deslikeVerde = deslikeBtn.querySelector('.deslike-verde');
                        const deslikeContorno = deslikeBtn.querySelector('.deslike');
                        const numerosDeslike = deslikeBtn.querySelector('.numeros-deslike-label');
                        
                        if (deslikeVerde && deslikeVerde.style.display === "block") {
                            // Desfaz o deslike:
                            deslikeVerde.style.display = "none";
                            deslikeContorno.style.display = "block";
                            numerosDeslike.textContent = Math.max(0, parseInt(numerosDeslike.textContent || 0) - 1);
                            localStorage.removeItem(`deslike_${likeId}`);
                        }
                    }
                }
            })
            .catch(err => console.error("Erro na requisição LIKE: ", err)); // Adicionei o log de erro
        });
    });

    // 2. Configurar eventos para DISLIKES
    deslikeButtons.forEach(function (deslikeBtn) {
        const deslikeId = deslikeBtn.getAttribute('data-deslike-id');

        // Elementos internos do DESLIKE
        const deslikeVerde = deslikeBtn.querySelector('.deslike-verde');
        const deslikeContorno = deslikeBtn.querySelector('.deslike');
        const numerosDeslike = deslikeBtn.querySelector('.numeros-deslike-label');

        // Busca o LIKE correspondente
        const likeBtn = document.querySelector(`.like-chat[data-like-id="${deslikeId}"]`);

        deslikeBtn.addEventListener('click', function (e) {
            e.preventDefault();

            fetch('deslikeComentario.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: 'deslike_id=' + encodeURIComponent(deslikeId)
            })
            .then(response => response.text())
            .then(data => {
                if (data === "ok") {
                    
                    // >> INÍCIO DA LÓGICA DE VISUALIZAÇÃO DO DESLIKE (TOGGLE)
                    const isDisliked = deslikeVerde.style.display === "block";

                    if (!isDisliked) {
                        // Ação de DESCURTIR: Ativa o visual e incrementa
                        deslikeVerde.style.display = "block";
                        deslikeContorno.style.display = "none";
                        numerosDeslike.textContent = parseInt(numerosDeslike.textContent || 0) + 1;
                        localStorage.setItem(`deslike_${deslikeId}`, '1');
                    } else {
                        // Ação de REMOVER DESCURTIDA: Desativa o visual e decrementa
                        deslikeVerde.style.display = "none";
                        deslikeContorno.style.display = "block";
                        numerosDeslike.textContent = Math.max(0, parseInt(numerosDeslike.textContent || 0) - 1);
                        localStorage.removeItem(`deslike_${deslikeId}`);
                    }
                    // << FIM DA LÓGICA DE VISUALIZAÇÃO DO DESLIKE

                    // Lógica para DESFAZER LIKE (Exclusão Mútua)
                    if (likeBtn) {
                        const likeVerde = likeBtn.querySelector('.like-verde');
                        const likeContorno = likeBtn.querySelector('.like');
                        const numerosLike = likeBtn.querySelector('.numeros-like-label');
                        
                        if (likeVerde && likeVerde.style.display === "block") {
                            // Desfaz o like:
                            likeVerde.style.display = "none";
                            likeContorno.style.display = "block";
                            numerosLike.textContent = Math.max(0, parseInt(numerosLike.textContent || 0) - 1);
                            localStorage.removeItem(`like_${deslikeId}`);
                        }
                    }
                }
            })
            .catch(err => console.error("Erro na requisição DESLIKE: ", err)); // Adicionei o log de erro
        });
    });
});