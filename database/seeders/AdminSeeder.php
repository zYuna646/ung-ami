<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $dataExists = User::where('email', 'admin@amiung.com')->exists();

        if ($dataExists) {
            return;
        }

        $user = User::create([
            'name' => 'Admin',
            'email' => 'admin@amiung.com',
            'password' => 'admin'
        ]);

        Admin::create([
            'user_id' => $user->id
        ]);
    }
}
