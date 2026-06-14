<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $types =
            [
                'name' => 'John Doe',
                'email' => 'john@gmail.com',
                'role' => 'admin',
                'password' => (env('ADMINPASS', '123456789@K'))
            ];
        User::create($types);
    }
}
