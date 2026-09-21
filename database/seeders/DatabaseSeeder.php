<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::firstOrCreate([
            'email' => 'admin@helpdesk.local',
        ], [
            'name' => 'Administrador',
            'password' => 'helpdesk',
            'role' => 'admin',
        ]);

        $categories = [
            ['name' => 'Hardware', 'icon' => '🖥️'],
            ['name' => 'Software', 'icon' => '◫'],
            ['name' => 'Rede e Internet', 'icon' => '🌐'],
            ['name' => 'Acessos e Senhas', 'icon' => '🔐'],
            ['name' => 'Impressoras', 'icon' => '▣'],
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate(['name' => $category['name']], $category);
        }
    }
}
