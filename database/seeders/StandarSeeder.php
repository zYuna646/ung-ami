<?php

namespace Database\Seeders;

use App\Models\Standar;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StandarSeeder extends Seeder
{
    public function run(): void
    {
        $standars = [
            'Visi Misi Tujuan dan Sasaran',
            'Kepatuhan terhadap Regulasi Keuangan',
            'Keamanan dan Kepatuhan TI'
        ];

        foreach ($standars as $standar) {
            $dataExists = Standar::where('name', $standar)->exists();

            if (!$dataExists) {
                Standar::create([
                    'name' => $standar
                ]);
            }
        }
    }
}
