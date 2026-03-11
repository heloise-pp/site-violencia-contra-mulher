console.log("JS carregado");

window.fazerLogin = async function () {

    const email = document.getElementById("email").value;
    const password = document.getElementById("password").value;

    try {

        const response = await fetch("http://127.0.0.1:8000/api/auth/login", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({
                email: email,
                password: password
            })
        });

        const data = await response.json();

        console.log("Resposta API:", data);

        // se login falhar
        if (!response.ok) {

            alert("Email ou senha incorretos.");

            return;
        }

        // salva token
        localStorage.setItem("token", data.token);

        alert("Login realizado com sucesso!");

        window.location.href = "paginaAdm.html";

    } catch (error) {

        console.error("Erro:", error);

        alert("Erro ao conectar com o servidor.");

    }

};
