async function carregarPosts() {

  const container = document.getElementById("postsTable");

  try {

    const response = await fetch("http://localhost:8000/api/posts");

    if (!response.ok) {
      throw new Error("Erro ao buscar posts");
    }

    const json = await response.json();

    const posts = json.data || [];

    container.innerHTML = "";

    if (posts.length === 0) {

      container.innerHTML = `
        <tr>
          <td colspan="3" class="text-center py-4 text-gray-500">
            Nenhum post encontrado
          </td>
        </tr>
      `;

      return;
    }

    posts.forEach(post => {

      const row = document.createElement("tr");

      row.className = "border-b";

      row.innerHTML = `
        <td class="py-3 px-4">${post.title}</td>

        <td class="py-3 px-4 flex gap-2">

          <button 
            onclick="editarPost(${post.id})"
            class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600">
            Editar
          </button>

          <button 
            onclick="deletarPost(${post.id})"
            class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">
            Excluir
          </button>

        </td>
      `;

      container.appendChild(row);

    });

  } catch (error) {

    console.error("Erro ao carregar posts:", error);

    container.innerHTML = `
      <tr>
        <td colspan="3" class="text-center py-4 text-red-500">
          Erro ao carregar posts
        </td>
      </tr>
    `;

  }

}

carregarPosts();


// editar post
function editarPost(id) {

  window.location.href = `editarPost.html?id=${id}`;

}


// deletar post
async function deletarPost(id) {

  const confirmar = confirm("Tem certeza que deseja excluir este post?");

  if (!confirmar) return;

  const token = localStorage.getItem("token");

  try {

    const response = await fetch(`http://localhost:8000/api/posts/${id}`, {

      method: "DELETE",

      headers: {
        "Authorization": "Bearer " + token
      }

    });

    if (!response.ok) {
      throw new Error("Erro ao deletar post");
    }

    alert("Post deletado com sucesso");

    carregarPosts();

  } catch (error) {

    console.error(error);

    alert("Erro ao excluir post");

  }

}