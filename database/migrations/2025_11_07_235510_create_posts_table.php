<?php

// Arquivo: database/migrations/YYYY_MM_DD_xxxxxx_create_posts_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            // Coluna para o autor (chave estrangeira para a tabela users)
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('content');
            
            // Coluna para o upload da imagem (pode ser nula)
            $table->string('featured_image_path')->nullable(); 
            
            // Coluna que estava faltando, usada para filtrar posts públicos
            $table->boolean('is_published')->default(false); 
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
