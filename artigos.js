async function carregarArtigo() {

  const params = new URLSearchParams(window.location.search);
  const id = params.get("id");

  if (!id) {
    console.error("ID do artigo não encontrado");
    return;
  }

  try {

    const response = await fetch(`http://localhost:8000/api/posts/${id}`);

    if (!response.ok) {
      throw new Error("Erro ao carregar artigo");
    }

    const json = await response.json();
    const artigo = json.data;

    document.getElementById("tituloArtigo").innerText = artigo.title;

    let html = "";

    if (artigo.content) {

      try {

        const parsed = JSON.parse(artigo.content);

        parsed.blocks.forEach(bloco => {

          if (bloco.type === "paragraph") {
            html += `<p class="mb-4">${bloco.data.text}</p>`;
          }

          if (bloco.type === "header") {
            html += `<h2 class="text-2xl font-bold mt-6 mb-3">${bloco.data.text}</h2>`;
          }

          if (bloco.type === "image") {
            html += `<img src="${bloco.data.file.url}" class="my-6 rounded shadow">`;
          }

          if (bloco.type === "list") {

            html += "<ul class='list-disc ml-6 mb-4'>";

            bloco.data.items.forEach(item => {
              html += `<li>${item}</li>`;
            });

            html += "</ul>";

          }

        });

      } catch {
        html = artigo.content;
      }

    }

    document.getElementById("conteudoArtigo").innerHTML = html;

  } catch (error) {

    console.error("Erro ao carregar artigo:", error);

  }

}

document.addEventListener("DOMContentLoaded", carregarArtigo);