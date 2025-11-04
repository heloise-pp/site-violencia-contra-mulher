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
