
    const form = document.getElementById("loginForm");
    const message = document.getElementById("message");

    form.addEventListener("submit", function(event) {
        event.preventDefault();

        const username = document.getElementById("username").value;
        const password = document.getElementById("password").value;

        if(username === "admin" && password === "1234") {
            message.textContent = "Login realizado com sucesso!";
            message.className = "text-green-400 text-center text-sm mt-4";
        } else {
            message.textContent = "Usuário ou senha inválidos.";
            message.className = "text-red-400 text-center text-sm mt-4";
        }
    });
