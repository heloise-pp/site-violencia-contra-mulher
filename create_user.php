<?php

use App\Models\User;

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

User::create([
    'name' => 'Admin Teste',
    'email' => 'projetoextensaouniaselvi@gmail.com',
    'password' => bcrypt('ProjetoExtensao123'),
]);

echo "✅ Usuário criado com sucesso!\n";
