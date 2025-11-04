<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PostController extends Controller
{


    /**
     * GET /api/posts/{post}
     * exibe um post específico
     */
    public function show(Post $post)
    {
        // O $post já contém o modelo carregado do banco de dados

        return response()->json($post);
    }

    /**
     * PUT/PATCH /api/posts/{post}
     * atualiza um post existent
     */
    public function update(Request $request, Post $post)
    {
        // validação dos dados
        $validated = $request->validate([
            'title'   => 'required|string|max:255',
            'content' => 'required',
            'is_published' => 'boolean',
            'slug'    => 'unique:posts,slug,' . $post->id,
        ]);

        // preparação dos dados
        if ($request->has('title')) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        // atualiza o post no banco de dados
        $post->update($validated);

        // retorna o post atualizado
        return response()->json($post);
    }

    /**
     * DELETE /api/posts/{post}
     * remove um post do banco de dados
     */
    public function destroy(Post $post)
    {
        // apaga o registro do banco de dados
        $post->delete();

        // retorna uma resposta de sucesso sem conteúdo (No Content)
        return response()->json(null, 204);
    }
}
