
<?php

use Illuminate\Support\Facades\Route;

Route::get('/delegacias', function () {
    return response()->json([
        [
            'id' => 1,
            'nome' => 'Delegacia da Mulher – Centro',
            'cidade' => 'Sua cidade'
        ],
        [
            'id' => 2,
            'nome' => 'Delegacia da Mulher – Zona Norte',
            'cidade' => 'Sua cidade'
        ]
    ]);
});