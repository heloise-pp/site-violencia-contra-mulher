document.addEventListener("DOMContentLoaded", function () {

  const token = localStorage.getItem("token");

  if (!token) {
    alert("Usuário não autenticado");
    window.location.href = "login.html";
    return;
  }

  fetch("http://127.0.0.1:8000/api/posts", {
    method: "GET",
    headers: {
      "Authorization": "Bearer " + token,
      "Accept": "application/json"
    }
  })
    .then(response => {
      if (!response.ok) {
        throw new Error("Erro na API");
      }
      return response.json();
    })
    .then(posts => {
      const container = document.getElementById("posts");
      container.innerHTML = "";

      posts.forEach(post => {
        const div = document.createElement("div");
        div.innerHTML = `
          <h
          