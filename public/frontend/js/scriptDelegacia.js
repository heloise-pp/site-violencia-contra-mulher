document.addEventListener("DOMContentLoaded", () => {
  const lista = document.getElementById("lista-delegacias");
  const loading = document.getElementById("loading");
  const erro = document.getElementById("erro");

  fetch("http://127.0.0.1:8000/api/delegacias")
    .then(response => response.json())
    .then(data => {
      loading.style.display = "none";

      data.forEach(item => {
        const div = document.createElement("div");

        div.innerHTML = `
          <h3>${item.nome}</h3>
          <p><strong>Cidade:</strong> ${item.cidade}</p>
          <p><strong>Estado:</strong> ${item.estado}</p>
          <p><strong>Telefone:</strong> ${item.telefone}</p>
        `;

        lista.appendChild(div);
      });
    })
    .catch(error => {
      loading.style.display = "none";
      erro.style.display = "block";
      erro.innerText = "Erro ao carregar delegacias";
      console.error(error);
    });
}); 