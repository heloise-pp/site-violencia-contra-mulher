<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostStoreRequest;
use App\Http\Requests\PostUpdateRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * GET /api/posts
     * Exibe uma listagem de posts.
     */
    public function index(): AnonymousResourceCollection
    {
        // Paginando 15 posts por página.
        $posts = Post::latest()->paginate(15);

        // Usa PostResource::collection para transformar a coleção/paginador.
        return PostResource::collection($posts);
    }

    /**
     * POST /api/posts
     * Cria e armazena um novo post.
     */
    public function store(PostStoreRequest $request): JsonResponse
    {
        $validated = $request->validated();

        // Gera o slug antes de criar o post
        $validated['slug'] = Str::slug($validated['title']);

        $post = auth()->user()->posts()->create($validated);

        // Retorna a resposta formatada usando o Resource (HTTP 201 Created)
        return response()->json([
            'message' => 'Post criado com sucesso!',
            'post' => new PostResource($post)
        ], 201);
    }

    /**
     * GET /api/posts/{post}
     * Exibe um post específico (usando Route Model Binding).
     */
    public function show(Post $post): PostResource
    {
        return new PostResource($post);
    }

    /**
     * PUT/PATCH /api/posts/{post}
     * Atualiza um post existente.
     */
    public function update(PostUpdateRequest $request, Post $post): JsonResponse
    {
        // 1. Autorização: Verifica se o usuário logado é o dono do post
        if ($request->user()->id !== $post->user_id) {
            return response()->json([
                'message' => 'Acesso negado. Você não pode atualizar posts de outros usuários.'
            ], 403); // HTTP 403 Forbidden
        }

        // 2. Validação: Obtém apenas os dados validados (mais seguro)
        $validated = $request->validated();

        // Lógica do Slug
        if ($request->has('title')) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        // 3. Atualiza o Post (Usando apenas dados validados)
        $post->update($validated);

        // 4. Retorna o Post Resource
        return response()->json([
            'message' => 'Post atualizado com sucesso!',
            'post' => new PostResource($post)
        ], 200);
    }

    /**
     * DELETE /api/posts/{post}
     * Remove um post do banco de dados.
     */
    public function destroy(Request $request, Post $post): JsonResponse
    {
        // 1. Autorização: Verifica se o usuário logado é o dono do post
        if ($request->user()->id !== $post->user_id) {
            return response()->json([
                'message' => 'Acesso negado. Você não pode deletar posts de outros usuários.'
            ], 403); // HTTP 403 Forbidden
        }

        // 2. Deleta o Post
        $post->delete();

        // 3. Retorna a resposta (HTTP 204 No Content)
        return response()->json(null, 204);
    }
}
