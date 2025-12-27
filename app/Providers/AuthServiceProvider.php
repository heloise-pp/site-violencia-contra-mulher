<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // Adicionando o mapeamento: Modelo Post usa a PostPolicy
        \App\Models\Post::class => \App\Policies\PostPolicy::class,
    ];


    public function boot(): void
    {
        //
    }
}
