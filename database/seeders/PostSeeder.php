<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Str;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('posts')->delete();

        $firstUserId = User::first()?->id;

        if (!$firstUserId) {
            // evita erro silencioso
            $firstUserId = User::create([
                'name' => 'Teste',
                'email' => 'teste@example.com',
                'password' => bcrypt('123456')
            ])->id;
        }

        $posts = [
            [
                'user_id' => $firstUserId,
                'title' => 'Os Sinais de Alerta no Início de um Relacionamento',
                'slug' => Str::slug('Os Sinais de Alerta no Início de um Relacionamento'),
                'content' => 'É fundamental reconhecer os primeiros sinais...',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => $firstUserId,
                'title' => 'Direitos da Mulher Vítima de Violência',
                'slug' => Str::slug('Direitos da Mulher Vítima de Violência'),
                'content' => 'Toda mulher tem direito...',
                'created_at' => now()->subDays(5),
                'updated_at' => now()->subDays(5),
            ],
            [
                'user_id' => $firstUserId,
                'title' => 'Onde Buscar Ajuda Imediata?',
                'slug' => Str::slug('Onde Buscar Ajuda Imediata?'),
                'content' => 'Se você está em perigo...',
                'created_at' => now()->subDays(10),
                'updated_at' => now()->subDays(10),
            ],
        ];

        DB::table('posts')->insert($posts);
    }
}
