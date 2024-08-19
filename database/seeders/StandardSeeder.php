<?php

namespace Database\Seeders;

use App\Models\Standard;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StandardSeeder extends Seeder
{
    public function run(): void
    {
        $standards = [
            'Visi Misi Tujuan dan Sasaran',
            'Kepatuhan terhadap Regulasi Keuangan',
            'Keamanan dan Kepatuhan TI'
        ];

        foreach ($standards as $standard) {
            $dataExists = Standard::where('name', $standard)->exists();

            if (!$dataExists) {
                Standard::create([
                    'name' => $standard
                ]);
            }
        }
    }
}
