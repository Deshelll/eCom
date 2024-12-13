<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    public function run()
    {
        Role::create(['name' => 'admin']); // Добавляем роль "Администратор"
        Role::create(['name' => 'user']);  // Добавляем роль "Пользователь"
    }
}
