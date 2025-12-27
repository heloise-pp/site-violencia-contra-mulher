document.getElementById("postForm").addEventListener("submit", function (e) {
  e.preventDefault();

  const title = document.getElementById("title").value;
  const content = document.getElementById("content").value;

  request("/posts", {
    method: "POST",
    body: JSON.stringify({
      title: title,
      content: content
    })
  })
    .then(() => {
      alert("Post criado com sucesso!");
      document.getElementById("postForm").reset();
    })
    .catch(() => {
      alert("Erro ao criar post");
    });
});