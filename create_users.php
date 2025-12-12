<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;

// Create Admin User
$admin = User::updateOrCreate(
    ['email' => 'admin@rainbow.com'],
    [
        'name' => 'Admin User',
        'password' => Hash::make('password'),
        'role' => 'admin'
    ]
);

echo "✓ Admin created: {$admin->email} (password: password)\n";

// Create Staff Users
$staff1 = User::updateOrCreate(
    ['email' => 'staff@rainbow.com'],
    [
        'name' => 'Staff User',
        'password' => Hash::make('password'),
        'role' => 'staff'
    ]
);

echo "✓ Staff created: {$staff1->email} (password: password)\n";

$staff2 = User::updateOrCreate(
    ['email' => 'john@rainbow.com'],
    [
        'name' => 'John Doe',
        'password' => Hash::make('password'),
        'role' => 'staff'
    ]
);

echo "✓ Staff created: {$staff2->email} (password: password)\n";

echo "\n=== LOGIN CREDENTIALS ===\n";
echo "\nADMIN LOGIN:\n";
echo "Email: admin@rainbow.com\n";
echo "Password: password\n";
echo "Role: Admin\n";

echo "\nSTAFF LOGIN:\n";
echo "Email: staff@rainbow.com\n";
echo "Password: password\n";
echo "Role: Staff\n";

echo "\nSTAFF LOGIN 2:\n";
echo "Email: john@rainbow.com\n";
echo "Password: password\n";
echo "Role: Staff\n";

echo "\n";
