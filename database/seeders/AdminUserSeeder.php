<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
        'name' => 'Administrador',
        'email' => 'admin@admin.com',
        'password' => Hash::make('senhasenha123'),
        'usertype' => '1',
        'phone' => '000000000',
        'address' => 'Sistema',
        ]);
    }
}
