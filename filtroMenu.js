document.addEventListener("DOMContentLoaded", function () {
    const filtroOverlay = document.querySelector(".filtro-overlay");
    const filtrarBtn = document.getElementById("filtrar-btn");
    const voltarBtn = document.querySelector(".fechar-filtro");
    const botaoConfirmarFiltro = document.getElementById("getSelecionar");

    // Salvar HTML original dos containers/carrosséis
    const containerPrincipal = document.getElementById("container-principal-obras");
    const containerFilme = document.getElementById("container-filme");
    const containerSerie = document.getElementById("container-serie");
    const containerLivro = document.getElementById("container-livro");

    const htmlOriginalPrincipal = containerPrincipal ? containerPrincipal.innerHTML : "";
    const htmlOriginalFilme = containerFilme ? containerFilme.innerHTML : "";
    const htmlOriginalSerie = containerSerie ? containerSerie.innerHTML : "";
    const htmlOriginalLivro = containerLivro ? containerLivro.innerHTML : "";

    if (filtrarBtn && filtroOverlay && voltarBtn) {
        filtrarBtn.addEventListener("click", function (event) {
            event.preventDefault();
            filtroOverlay.classList.add("filtro-overlay-open");
        });

        voltarBtn.addEventListener("click", function () {
            filtroOverlay.classList.remove("filtro-overlay-open");

            spans.forEach(span => {
                span.classList.remove("selecionar");
                span.style.pointerEvents = "auto";
                span.style.opacity = "1";
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

            const tiposSelecionados = selecionados.filter(f => f.tipo).map(f => f.tipo);
            const generosSelecionados = selecionados.filter(f => f.genero).map(f => f.genero);

            // Caso não haja filtro selecionado, restaurar os carrosséis originais
            if (tiposSelecionados.length === 0 && generosSelecionados.length === 0) {
                if (containerPrincipal) {
                    containerPrincipal.innerHTML = htmlOriginalPrincipal;
                    containerPrincipal.style.display = "block";
                }
                if (containerFilme) {
                    containerFilme.innerHTML = htmlOriginalFilme;
                    containerFilme.style.display = "grid";
                }
                if (containerSerie) {
                    containerSerie.innerHTML = htmlOriginalSerie;
                    containerSerie.style.display = "grid";
                }
                if (containerLivro) {
                    containerLivro.innerHTML = htmlOriginalLivro;
                    containerLivro.style.display = "grid";
                }

                const containerGrid = document.getElementById("container-obras");
                if (containerGrid) containerGrid.style.display = "none";

                filtroOverlay.classList.remove("filtro-overlay-open");
                return; // interrompe o restante do código de filtragem
            }

            // Se houver filtro, exibe os resultados filtrados
            const containerGrid = document.getElementById("container-obras");
            const obras = document.querySelectorAll('.container-obras .obras');
            let encontrouResultado = false;

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

            // Esconder carrosséis originais quando filtro ativo
            if (containerPrincipal) containerPrincipal.style.display = "none";
            if (containerFilme) containerFilme.style.display = "none";
            if (containerSerie) containerSerie.style.display = "none";
            if (containerLivro) containerLivro.style.display = "none";

            // Esconder títulos
            const tituloFilme = document.getElementById("titulo-filme");
            const tituloSerie = document.getElementById("titulo-serie");
            const tituloLivro = document.getElementById("titulo-livro");

            if (tituloFilme) tituloFilme.style.display = "none";
            if (tituloSerie) tituloSerie.style.display = "none";
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
