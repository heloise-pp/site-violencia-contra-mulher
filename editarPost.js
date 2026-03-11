let editor;

// pegar ID do artigo na URL
const params = new URLSearchParams(window.location.search);
const postId = params.get("id");

if (!postId) {
  alert("ID do post não encontrado");
  window.location.href = "gerenciarPosts.html";
}

// inicializa editor
editor = new EditorJS({
  holder: "editorjs",

  placeholder: "Edite o conteúdo do artigo...",

  tools: {

    header: {
      class: Header,
      inlineToolbar: true
    },

    list: {
      class: List,
      inlineToolbar: true
    },

    image: {
      class: ImageTool,
      config: {
        endpoints: {
          byFile: "http://localhost:8000/api/upload-image"
        },
        additionalRequestHeaders: {
          Authorization: "Bearer " + localStorage.getItem("token")
        }
      }
    }

  }
});


// carregar post existente
async function carregarPost() {

  try {

    const response = await fetch(`http://localhost:8000/api/posts/${postId}`);

    const json = await response.json();

    const post = json.data;

    // preencher título
    document.getElementById("titulo").value = post.title;

    // carregar conteúdo no editor
    let conteudo;

    try {
      conteudo = JSON.parse(post.content);
    } catch {
      conteudo = {
        blocks: [
          {
            type: "paragraph",
            data: {
              text: post.content
            }
          }
        ]
      };
    }

    await editor.isReady;
    editor.render(conteudo);

  } catch (error) {

    console.error("Erro ao carregar post:", error);
    alert("Erro ao carregar o artigo");

  }

}

carregarPost();


// salvar edição
async function atualizarPost() {

  const titulo = document.getElementById("titulo").value;

  const conteudo = await editor.save();

  const token = localStorage.getItem("token");

  try {

    const response = await fetch(`http://localhost:8000/api/posts/${postId}`, {

      method: "PATCH",

      headers: {
        "Content-Type": "application/json",
        "Authorization": "Bearer " + token
      },

      body: JSON.stringify({
        title: titulo,
        content: JSON.stringify(conteudo)
      })

    });

    if (!response.ok) {
      throw new Error("Erro ao atualizar post");
    }

    alert("Post atualizado com sucesso!");

    window.location.href = "gerenciarPosts.html";

  } catch (error) {

    console.error(error);

    alert("Erro ao atualizar post");

  }

}