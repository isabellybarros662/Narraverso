/*-----------------filtragem-------------------------*/
    //parte para abrir a filtragem
    document.addEventListener("DOMContentLoaded", function () {
    const filtroOverlay = document.querySelector(".filtro-overlay");
    const filtrarBtn = document.getElementById("filtrar-btn");
    const voltarBtn = document.querySelector(".fechar-filtro");
    const botaoConfirmarFiltro = document.getElementById("getSelecionar");

    if (filtrarBtn && filtroOverlay && voltarBtn) {
        filtrarBtn.addEventListener("click", function (event) {
            event.preventDefault();
            filtroOverlay.classList.add("filtro-overlay-open");
        });

        voltarBtn.addEventListener("click", function () {
            filtroOverlay.classList.remove("filtro-overlay-open");

            //Remove todo o filtro
            spans.forEach(span => {
                span.classList.remove("selecionar"); //tira toda a seleção
                span.style.pointerEvents = "auto"; //restaura para voltar ao normal, e conseguir fazer uma proxima filtragem
                span.style.opacity = "1";//esse também
            });
        });
    }

    const spans = document.querySelectorAll("#filtroModal span");

    spans.forEach(span => {
        span.addEventListener("click", function () {
            const isTipo = this.hasAttribute("data-tipo");
            const isGenero = this.hasAttribute("data-genero");

            const selecionadosTipo = document.querySelectorAll(".selecionar[data-tipo]").length;
            const selecionadosGenero = document.querySelectorAll(".selecionar[data-genero]").length;

            if (this.classList.contains("selecionar")) {
                this.classList.remove("selecionar");
            } else {
                if (isTipo && selecionadosTipo < 2) {
                    this.classList.add("selecionar");
                } else if (isGenero && selecionadosGenero < 3) {
                    this.classList.add("selecionar");
                }
            }

            bloquearExcesso();
        });
    });

    function bloquearExcesso() {
        const selecionadosTipo = document.querySelectorAll(".selecionar[data-tipo]").length;
        const selecionadosGenero = document.querySelectorAll(".selecionar[data-genero]").length;

        spans.forEach(span => {
            if (span.hasAttribute("data-tipo")) {
                const bloquear = selecionadosTipo >= 2 && !span.classList.contains("selecionar");
                span.style.pointerEvents = bloquear ? "none" : "auto";
                span.style.opacity = bloquear ? "0.5" : "1";
            }
            if (span.hasAttribute("data-genero")) {
                const bloquear = selecionadosGenero >= 3 && !span.classList.contains("selecionar");
                span.style.pointerEvents = bloquear ? "none" : "auto";
                span.style.opacity = bloquear ? "0.5" : "1";
            }
        });
    }

    if (botaoConfirmarFiltro) {
        botaoConfirmarFiltro.addEventListener("click", function () {
            const selecionados = [];

            document.querySelectorAll(".selecionar").forEach(item => {
                if (item.hasAttribute("data-tipo")) {
                    selecionados.push({ tipo: item.getAttribute("data-tipo") });
                } else if (item.hasAttribute("data-genero")) {
                    selecionados.push({ genero: item.getAttribute("data-genero") });
                }
            });

            const containerGrid = document.getElementById("container-obras");
            const obras = document.querySelectorAll('.container-obras .obras');
            let encontrouResultado = false;

            const tiposSelecionados = selecionados.filter(f => f.tipo).map(f => f.tipo);
            const generosSelecionados = selecionados.filter(f => f.genero).map(f => f.genero);

            obras.forEach(obra => {
                const tipo = obra.getAttribute("data-tipo");
                const genero = obra.getAttribute("data-genero");

                const tipoValido = tiposSelecionados.length === 0 || tiposSelecionados.includes(tipo);
                const generoValido = generosSelecionados.length === 0 || generosSelecionados.includes(genero);

                if (tipoValido && generoValido) {
                    obra.style.display = "flex";
                    encontrouResultado = true;
                } else {
                    obra.style.display = "none";
                }
            });

            // Esconde carrosséis
            const containerPrincipal = document.getElementById("container-principal-obras");
            if (containerPrincipal) containerPrincipal.style.display = "none";

            const containerFilme = document.getElementById("container-filme");
            if (containerFilme) containerFilme.style.display = "none";

            const containerSerie = document.getElementById("container-serie");
            if (containerSerie) containerSerie.style.display = "none";

            const containerLivro = document.getElementById("container-livro");
            if (containerLivro) containerLivro.style.display = "none";

            const tituloFilme = document.getElementById("titulo-filme");
            if (tituloFilme) tituloFilme.style.display = "none";

            const tituloSerie = document.getElementById("titulo-serie");
            if (tituloSerie) tituloSerie.style.display = "none";

            const tituloLivro = document.getElementById("titulo-livro");
            if (tituloLivro) tituloLivro.style.display = "none";



        if (containerGrid) {
            containerGrid.style.display = encontrouResultado ? "grid" : "block";

            if (!encontrouResultado) {
                containerGrid.innerHTML = '<li id="sem_resultado"><p>Nenhuma obra encontrada com esse filtro!</p></li>';
            }
        }


            filtroOverlay.classList.remove("filtro-overlay-open");
        });
    }
});
