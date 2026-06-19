<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserRootSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'cb@bankir.academy'], // Unik parameter agar tidak duplikat jika dijalankan ulang
            [
                'name' => 'CB Root',
                'role' => 4,
                'password' => Hash::make('rootBankAcademy123!'),
            ]
        );
    }
}