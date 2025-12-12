<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$users = App\Models\User::all(['name', 'email', 'role']);

echo "\n=== USERS IN DATABASE ===\n\n";
foreach ($users as $user) {
    echo "Name: " . $user->name . "\n";
    echo "Email: " . $user->email . "\n";
    echo "Role: " . $user->role . "\n";
    echo "Password: password (default for all test users)\n";
    echo "-------------------\n";
}
echo "\nTotal Users: " . $users->count() . "\n\n";
