<?php

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
            // Chave estrangeira para o autor, com exclusão em cascata
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); 
            $table->string('title');
            $table->text('content');
            // Para URL amigável, garantindo que seja único
            $table->string('slug')->unique(); 
            // Adiciona colunas created_at e updated_at
            $table->timestamps(); 
        });
    } // <-- O método up() deve terminar aqui

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};