<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Role;
class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create a System Administrator role if not exists
        $systemAdministratorRole = Role::firstOrCreate(['name' => 'administrator']);

        // Create a user with the System Administrator role
        $user = User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@argon.com',
            'password' => 'password123',
        ]);
        
        // Assign the System Administrator role to the user
        $user->roles()->attach($systemAdministratorRole);
    }
}
