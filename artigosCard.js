async function carregarArtigos() {

  try {

    const response = await fetch("http://localhost:8000/api/posts");

    if (!response.ok) {
      throw new Error("Erro ao acessar API");
    }

    const json = await response.json();
    const artigos = json.data || [];

    const container = document.getElementById("articlesContainer");

    if (!container) {
      console.error("Container articlesContainer não encontrado");
      return;
    }

    container.innerHTML = "";

    if (artigos.length === 0) {
      container.innerHTML = `
        <p class="text-gray-500 text-center col-span-2">
          Nenhum artigo encontrado.
        </p>
      `;
      return;
    }

    artigos.forEach((artigo) => {

      let texto = "";

      if (artigo.content) {

        try {

          const parsed = JSON.parse(artigo.content);

          if (parsed.blocks) {

            texto = parsed.blocks
              .map(bloco => bloco.data?.text || "")
              .join(" ");

          }

        } catch {
          texto = artigo.content;
        }

      }

      const resumo = texto.length > 150
        ? texto.substring(0, 150) + "..."
        : texto;

      const card = document.createElement("div");

      card.className = "bg-white rounded-lg shadow-md overflow-hidden";

      card.innerHTML = `
        <div class="p-6">

          <h2 class="text-xl font-bold mt-2">
            ${artigo.title}
          </h2>

          <p class="text-gray-600 mt-2">
            ${resumo}
          </p>

          <a href="artigos.html?id=${artigo.id}"
             class="mt-4 inline-block bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 transition">
            Saiba Mais
          </a>

        </div>
      `;

      container.appendChild(card);

    });

  } catch (error) {

    console.error("Erro ao carregar artigos:", error);

  }

}

document.addEventListener("DOMContentLoaded", carregarArtigos);