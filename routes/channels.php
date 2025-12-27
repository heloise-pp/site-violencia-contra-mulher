<?php

use Illuminate\Support\Facades\Broadcast;

/*
 * |--------------------------------------------------------------------------
 * | Broadcast Channels
 * |--------------------------------------------------------------------------
 * |
 * | Aqui você pode registrar todos os canais de broadcast que sua aplicação suporta.
 * | O callback fornecido é usado para verificar se um usuário pode ouvir o canal.
 * |
 */

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});
