<?php

namespace Database\Seeders;

use App\Models\Auditor;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AuditorSeeder extends Seeder
{
    public function run(): void
    {
        $rows = [
            (object) [
                'name' => 'Dr. Akhmad, SE., M.Si',
                'email' => 'akhmad.msi@gmail.com',
            ],
            (object) [
                'name' => 'Ir. Rahmat, MT',
                'email' => 'rahmat.mt@gmail.com',
            ],
            (object) [
                'name' => 'Siti Nurhaliza, S.T.',
                'email' => 'siti.nurhaliza@gmail.com',
            ],
            (object) [
                'name' => 'Hadi Wijaya, M.Sc.',
                'email' => 'hadi.wijaya@gmail.com',
            ],
            (object) [
                'name' => 'Rina Fitria, Ph.D.',
                'email' => 'rina.fitria@gmail.com',
            ],
            (object) [
                'name' => 'Budi Santoso, S.Kom.',
                'email' => 'budi.santoso@gmail.com',
            ],
            (object) [
                'name' => 'Ani Nurhayati, M.M.',
                'email' => 'ani.nurhayati@gmail.com',
            ],
            (object) [
                'name' => 'Taufik Hidayat, S.Si.',
                'email' => 'taufik.hidayat@gmail.com',
            ],
            (object) [
                'name' => 'Dewi Sartika, S.E.',
                'email' => 'dewi.sartika@gmail.com',
            ],
            (object) [
                'name' => 'Joko Susanto, M.T.',
                'email' => 'joko.susanto@gmail.com',
            ],
        ];

        foreach ($rows as $row) {
            $dataExists = User::where('email', $row->email)->exists();

            if ($dataExists) {
                return;
            }

            $user = User::create([
                'name' => $row->name,
                'email' => $row->email,
                'password' => explode('@', $row->email)[0]
            ]);

            Auditor::create([
                'user_id' => $user->id
            ]);
        }
    }
}
