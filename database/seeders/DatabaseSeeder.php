<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Trademark;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Factory as Faker;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $roleSuperAdmin = Role::create(['name' => 'super admin']);
        $roleAdmin = Role::create(['name' => 'admin']);
        $roleTester = Role::create(['name' => 'tester']);
        $roleUser = Role::create(['name' => 'user']);
        $user = \App\Models\User::create([
            'name' => 'System Admin',
            'email' => 'admin@takip.marka.legal',
            'password' => bcrypt('Zp0v^R69^x87'),
        ]);
        
        $user->assignRole($roleSuperAdmin);
    }
}
