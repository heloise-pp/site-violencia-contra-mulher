<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class PostController extends Controller
{
    use AuthorizesRequests;

    /**
     * Listar todos os posts
     * GET /api/posts
     */
    public function index()
    {
        $posts = Post::latest()->get();

        return response()->json([
            "data" => $posts
        ]);
    }

    /**
     * Mostrar post específico
     * GET /api/posts/{post}
     */
    public function show(Post $post)
    {
        return response()->json([
            "data" => $post
        ]);
    }

    /**
     * Criar novo post
     * POST /api/posts
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            "title" => "required|string|max:255",
            "content" => "required|string"
        ]);

        $post = Post::create([
            "user_id" => $request->user()->id,
            "title" => $validated["title"],
            "content" => $validated["content"],
            "slug" => Str::slug($validated["title"])
        ]);

        return response()->json([
            "message" => "Post criado com sucesso",
            "post" => $post
        ], 201);
    }

    /**
     * Atualizar post
     * PATCH /api/posts/{post}
     */
    public function update(Request $request, Post $post): JsonResponse
    {
        $this->authorize("update", $post);

        $validated = $request->validate([
            "title" => "required|string|max:255",
            "content" => "required|string"
        ]);

        $post->update([
            "title" => $validated["title"],
            "content" => $validated["content"],
            "slug" => Str::slug($validated["title"])
        ]);

        return response()->json([
            "message" => "Post atualizado com sucesso",
            "post" => $post
        ]);
    }

    /**
     * Excluir post
     * DELETE /api/posts/{post}
     */
    public function destroy(Post $post): JsonResponse
    {
        $this->authorize("delete", $post);

        $post->delete();

        return response()->json([
            "message" => "Post excluído com sucesso"
        ]);
    }

    /**
     * Upload de imagem do EditorJS
     * POST /api/upload-image
     */
    public function uploadImage(Request $request)
    {
        if (!$request->hasFile("image")) {
            return response()->json([
                "success" => 0,
                "message" => "Nenhuma imagem enviada"
            ]);
        }

        $file = $request->file("image");

        $path = $file->store("posts", "public");

        return response()->json([
            "success" => 1,
            "file" => [
                "url" => asset("storage/" . $path)
            ]
        ]);
    }
}