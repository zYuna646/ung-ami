<?php

namespace Database\Seeders;

use App\Models\Unit;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UnitSeeder extends Seeder
{
    public function run(): void
    {
        $units = [
            (object) [
                'unit_name' => 'Universitas',
                'is_deletable' => false
            ],
            (object) [
                'unit_name' => 'Fakultas',
                'is_deletable' => false
            ],
            // (object) [
            //     'unit_name' => 'Jurusan',
            //     'is_deletable' => false
            // ],
            (object) [
                'unit_name' => 'Program Studi',
                'is_deletable' => false
            ],
            (object) [
                'unit_name' => 'LP2M',
                'user_name' => 'Ketua LP2M'
            ],
            (object) [
                'unit_name' => 'BAKP',
                'user_name' => 'Kepala BAKP'
            ],
            (object) [
                'unit_name' => 'UPT PKM',
                'user_name' => 'Kepala UPT PKM'
            ]
        ];

        foreach ($units as $unit) {
            try {
                DB::beginTransaction();

                $dataExists = Unit::where('unit_name', $unit->unit_name)->exists();

                if (!$dataExists) {
                    if (isset($unit->user_name)) {
                        $user = User::firstOrCreate(
                            ['name' => $unit->user_name],
                            [
                                'email' => strtolower(str_replace(' ', '.', $unit->user_name)) . '@amiung.com',
                            ]
                        );
                    }

                    Unit::create([
                        'unit_name' => $unit->unit_name,
                        'is_deletable' => $unit->is_deletable ?? true,
                        'user_id' => $user->id ?? null
                    ]);
                }

                DB::commit();
            } catch (\Throwable $th) {
                DB::rollBack();

                throw $th;
            }
        }
    }
}
