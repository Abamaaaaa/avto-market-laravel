<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Category;
use App\Models\User;

class DatabaseSeeder extends Seeder {
    public function run(): void {
        $admin = Role::create(['name' => 'admin']);
        $journalist = Role::create(['name' => 'journalist']);
        Role::create(['name' => 'user']);
        Category::create(['name' => 'Наука']);
        Category::create(['name' => 'Технологии']);
        User::create(['login' => 'reporter', 'password' => bcrypt('password'), 'role_id' => $journalist->id]);
    }
}
