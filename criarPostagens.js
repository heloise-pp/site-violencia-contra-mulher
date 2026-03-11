
const editor = new EditorJS({

  holder: "editorjs",

  placeholder: "Comece a escrever seu artigo...",

  tools: {

    header: {
      class: Header,
      inlineToolbar: true
    },

    list: {
      class: List,
      inlineToolbar: true
    },

    quote: {
      class: Quote,
      inlineToolbar: true
    },

    checklist: {
      class: Checklist,
      inlineToolbar: true
    },

    delimiter: Delimiter,

    embed: {
      class: Embed,
      config: {
        services: {
          youtube: true,
          twitter: true
        }
      }
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


async function criarPost() {

  const titulo = document.getElementById("titulo").value;

  const conteudo = await editor.save();

  const token = localStorage.getItem("token");

  try {

    const response = await fetch("http://localhost:8000/api/posts", {

      method: "POST",

      headers: {
        "Content-Type": "application/json",
        "Authorization": "Bearer " + token
      },

      body: JSON.stringify({
        title: titulo,
        content: JSON.stringify(conteudo)
      })

    });

    const data = await response.json();

    console.log(data);

    if (!response.ok) {

      alert("Erro ao publicar o post");
      return;

    }

    alert("Post publicado com sucesso!");

    window.location.href = "paginaAdm.html";

  } catch (error) {

    console.error(error);

    alert("Erro no servidor");

  }

}




async function previewPost() {

  const conteudo = await editor.save();

  console.log("Preview do artigo:", conteudo);

  alert("Preview gerado! Veja no console.");

}
