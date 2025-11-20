<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Http\Resources\PostResource;
use App\Http\Requests\PostStoreRequest;
use App\Http\Requests\PostUpdateRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class PostController extends Controller
{
    /**
     * GET /api/posts
     * Exibe a listagem de todos os posts (PÚBLICO).
     */
    public function index(): AnonymousResourceCollection
    {
        // Pega todos os posts e os ordena pelo mais recente
        $posts = Post::latest()->get();
        return PostResource::collection($posts);
    }


    public function store(PostStoreRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $post = Post::create([
            'user_id' => $request->user()->id,
                             'title' => $validated['title'],
                             'content' => $validated['content'],
        ]);

        return response()->json([
            'message' => 'Post criado com sucesso!',
            'post' => new PostResource($post)
        ], 201);
    }

    /**
     * GET /api/posts/{post}
     * Exibe um post específico (PÚBLICO).
     */
    public function show(Post $post): PostResource
    {
        return new PostResource($post);
    }

    /**
     * PATCH /api/posts/{post}
     * Atualiza um post específico (PROTEGIDO por Policy - só o autor).
     */
    public function update(PostUpdateRequest $request, Post $post): JsonResponse
    {
        // Autorização: Verifica se o usuário é o autor do Post
        // Se falhar, a Policy retorna 403 Forbidden
        $this->authorize('update', $post);

        // Atualiza o Post com os dados validados
        $post->update($request->validated());

        return response()->json([
            'message' => 'Post atualizado com sucesso!',
            'post' => new PostResource($post)
        ]);
    }

    /**
     * DELETE /api/posts/{post}
     * Remove um post específico (PROTEGIDO por Policy - só o autor).
     */
    public function destroy(Post $post): JsonResponse
    {
        // Autorização: Verifica se o usuário é o autor do Post
        $this->authorize('delete', $post);

        $post->delete();

        return response()->json(['message' => 'Post excluído com sucesso!']);
    }
}
