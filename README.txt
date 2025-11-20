Blog sobre violência doméstica - Backend API

Este é o repositório do backend para o blog quebre o silêncio, desenvolvido em PHP utilizando o framework Laravel e o banco de dados MySQL.

A API segue a arquitetura RESTful e é responsável por gerenciar usuários, posts, autenticação (via Laravel Sanctum) e armazenamento de conteúdo (imagens).

Pré-Requisitos

Para rodar este projeto localmente, você precisa ter o seguinte software instalado:

    PHP: Versão 8.1 ou superior (verifique composer.json para requisitos específicos).

    Composer: Gerenciador de dependências do PHP.

    MySQL: Servidor de banco de dados.

    Extensões PHP: pdo_mysql, bcmath, curl, mbstring.

 Instalação e Configuração

Siga os passos abaixo para colocar o backend da API em funcionamento.

1. Clonar o Repositório

Bash

git clone https://www.youtube.com/watch?v=RqfwLeY952s
cd site-violencia

2. Instalar Dependências

Instale todos os pacotes PHP necessários definidos no composer.json:
Bash

composer install

3. Configuração do Ambiente (.env)

Crie o arquivo de ambiente copiando o arquivo de exemplo:
Bash

cp .env.example .env

Abra o arquivo recém-criado (.env) e configure as seguintes variáveis:
Variável	Descrição	Exemplo
APP_NAME	Nome da Aplicação	"[Nome do Projeto] API"
APP_URL	URL do Servidor	http://localhost:8000
DB_DATABASE	Nome do seu banco de dados MySQL	blog_db
DB_USERNAME	Usuário do MySQL	root
DB_PASSWORD	Senha do MySQL	[sua_senha]

4. Gerar a Chave da Aplicação

O Laravel exige uma chave única para segurança (sessões, criptografia, etc.):
Bash

php artisan key:generate

5. Migrações e Seeding (Banco de Dados)

Rode as migrações para criar as tabelas (users, posts, personal_access_tokens, etc.) no seu MySQL e preencha com o usuário de teste:
Bash

php artisan migrate --seed

    Nota: O comando --seed executa o UserSeeder que criamos, adicionando o usuário:

        Email: projetoextensaouniaselvi@gmail.com

        Senha: ProjetoExtensao123

6. Configurar Armazenamento Público

Crie o link simbólico para que as imagens carregadas no storage fiquem acessíveis publicamente:
Bash

php artisan storage:link

7. Iniciar o Servidor

Inicie o servidor de desenvolvimento local:
Bash

php artisan serve

O backend estará acessível em http://127.0.0.1:8000.

Endpoints da API

A API segue o padrão RESTful. Todos os endpoints estão sob o prefixo /api/.

Autenticação

Método	Endpoint	Descrição	Proteção
POST	/api/login	Gera o access_token para o usuário.	Pública
POST	/api/logout	Invalida o token atual do usuário.	Requer Token

Posts

Método	Endpoint	Descrição	Proteção
GET	/api/posts	Retorna a lista de todos os posts.	Pública
GET	/api/posts/{id}	Retorna um post específico.	Pública
POST	/api/posts	Cria um novo post (requer campos title, content).	Requer Token
PUT/PATCH	/api/posts/{id}	Atualiza um post existente.	Requer Token
DELETE	/api/posts/{id}	Deleta um post.	Requer Token




A base da API é: http://127.0.0.1:8000/api

1. Módulos Implementados

Módulo

Escopo

Status

Blog (Posts)

CRUD completo para gerenciar posts. Leitura é pública, Escrita/Edição é protegida.

✅ Completo

Autenticação

Registro, Login, Logout e validação via Token (Sanctum).

✅ Completo

Delegacias/Centros

Não implementado no backend. A listagem é feita integralmente no frontend via JavaScript.

⚠️ Pulo no Backend

2. Autenticação e Usuários

Todas as rotas de escrita (POST, PATCH, DELETE) em /api/posts exigem um token no header: Authorization: Bearer <token>.

Endpoint

Método

Descrição

Requer Token?

/auth/register

POST

Cria uma nova conta de usuário.

Não

/auth/login

POST

Autentica e retorna o access_token.

Não

/auth/logout

POST

Invalida o token do usuário logado.

Sim

/user

GET

Retorna os dados do usuário logado (teste de token).

Sim

Payload de Login:

{
    "email": "email@example.com",
    "password": "senha"
}


3. Rotas do Blog (Posts)

As rotas de Posts retornam dados padronizados através do PostResource.

3.1. Leitura (Público)

Endpoint

Método

Descrição

/posts

GET

Lista todos os posts do blog, ordenados pelo mais recente.

/posts/{post}

GET

Retorna um post específico pelo ID.

Exemplo de Retorno (/posts):

{
  "data": [
    {
      "id": 1,
      "title": "Os Sinais de Alerta no Início de um Relacionamento",
      "content": "...",
      "created_at": "19/11/2025 22:00",
      "updated_at": "19/11/2025 22:00",
      "author": "Admin de Teste",
      "user_id": 1
    }
  ]
}


3.2. Escrita (Protegido por Token e Policy)

Endpoint

Método

Descrição

/posts

POST

Cria um novo post. (Requer Autenticação).

/posts/{post}

PATCH

Atualiza um post. (Requer Autenticação e Política: Só o autor pode editar - 403 Forbidden se não for o autor).

/posts/{post}

DELETE

Exclui um post. (Requer Autenticação e Política: Só o autor pode excluir - 403 Forbidden se não for o autor).

Payload de Criação/Atualização:

{
    "title": "Novo Título",
    "content": "Conteúdo completo do post."
}
