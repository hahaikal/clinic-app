<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::where('name', 'Admin')->first();

        if ($adminRole) {
            User::firstOrCreate(
                ['email' => 'admin@klinik.com'],
                [
                    'name' => 'Admin Utama',
                    'password' => Hash::make('admin123'),
                    'role_id' => $adminRole->id,
                    'email_verified_at' => now() 
                ]
            );
        } else {
            $this->command->warn('Role Admin tidak ditemukan. Pastikan RoleSeeder sudah dijalankan.');
        }
    }
}
