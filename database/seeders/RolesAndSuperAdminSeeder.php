<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class RolesAndSuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        $superAdmin = Role::firstOrCreate(['name' => 'super-admin']);
        $admin      = Role::firstOrCreate(['name' => 'admin']);
        $supervisor = Role::firstOrCreate(['name' => 'supervisor']);

        // Buat superadmin developer (ubah email/password sesuai kebutuhan)
        $user = User::firstOrCreate(
            ['email' => 'dev@postra.test'],
            [
                'name' => 'Developer Super Admin',
                'password' => Hash::make('password12345'),
            ]
        );

        if (! $user->hasRole('super-admin')) {
            $user->assignRole($superAdmin);
        }
    }
}
