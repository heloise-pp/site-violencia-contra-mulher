async function carregarArtigos() {
    try {
        const response = await fetch("http://localhost:3000/api/v1/posts");
        const artigos = await response.json();

        const container = document.getElementById("articlesContainer");
        container.innerHTML = "";

        artigos.forEach((artigo, index) => {

            // Limitar texto (resumo)
            const resumo = artigo.conteudo.length > 150
                ? artigo.conteudo.substring(0, 150) + "..."
                : artigo.conteudo;
            const layoutClasse = index % 2 === 0
                ? "grid grid-cols-1 md:grid-cols-2 gap-4 p-4 bg-white rounded-lg shadow-lg"
                : "bg-white rounded-lg shadow-md overflow-hidden";

            const card = document.createElement("div");
            card.className = layoutClasse;

            if (index % 2 === 0) {
                card.innerHTML = `
                    <div class="flex items-center justify-center bg-gray-100 rounded-lg p-2">
                        <img src="${artigo.imagem}" 
                             alt="${artigo.titulo}"
                             class="max-w-full max-h-64 object-contain rounded-lg">
                    </div>

                    <div class="flex flex-col justify-center p-4">
                        <h2 class="text-xl font-bold mb-2">
                            ${artigo.titulo}
                        </h2>

                        <p class="text-gray-700">
                            ${resumo}
                        </p>

                        <a href="artigo.html?id=${artigo.id}"
                           class="mt-4 inline-block bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 transition">
                           Saiba Mais
                        </a>
                    </div>
                `;
            } else {
                card.innerHTML = `
                    <img src="${artigo.imagem}" 
                         alt="${artigo.titulo}"
                         class="w-full h-56 object-cover">

                    <div class="p-6">
                        <h2 class="text-xl font-bold mt-2">
                            ${artigo.titulo}
                        </h2>

                        <p class="text-gray-600 mt-2">
                            ${resumo}
                        </p>

                        <a href="artigo.html?id=${artigo.id}"
                           class="mt-4 inline-block bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 transition">
                           Saiba Mais
                        </a>
                    </div>
                `;
            }

            container.appendChild(card);
        });

    } catch (error) {
        console.error("Erro ao carregar artigos:", error);
    }
}

carregarArtigos();

