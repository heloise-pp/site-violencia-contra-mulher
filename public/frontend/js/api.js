const API_URL = "http://127.0.0.1:8000/api";

async function request(endpoint, options = {}) {
    const token = localStorage.getItem("token");

    const headers = options.headers || {};

    // Só adiciona JSON se tiver body
    if (options.body) {
        headers["Content-Type"] = "application/json";
    }

    if (token) {
        headers["Authorization"] = "Bearer " + token;
    }

    const response = await fetch(API_URL + endpoint, {
        ...options,
        headers
    });

    const text = await response.text();

    // Se backend devolveu erro
    if (!response.ok) {
        console.error("Erro da API:", text);
        throw new Error(text || "Erro na requisição");
    }

    // Se resposta vazia
    if (!text) {
        return {};
    }

    try {
        return JSON.parse(text);
    } catch (e) {
        console.error("Resposta não é JSON:", text);
        throw new Error("Resposta inválida do servidor");
    }
}