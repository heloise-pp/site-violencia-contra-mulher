<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Post;
use Illuminate\Auth\Access\Response;

class PostPolicy
{

    public function update(User $user, Post $post): bool
    {
        // Apenas o dono do post pode atualizá-lo.
        return $user->id === $post->user_id;
    }


    public function delete(User $user, Post $post): bool
    {
        // Apenas o dono do post pode deletá-lo.
        return $user->id === $post->user_id;
    }
}
