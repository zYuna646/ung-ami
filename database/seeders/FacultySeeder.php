<?php

namespace Database\Seeders;

use App\Models\Faculty;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FacultySeeder extends Seeder
{
    public function run(): void
    {
        $faculties = [
            (object) [
                'faculty_name' => 'Teknik',
            ],
        ];

        foreach ($faculties as $faculty) {
            try {
                DB::beginTransaction();

                $dataExists = Faculty::where('faculty_name', $faculty->faculty_name)->exists();

                if (!$dataExists) {
                    $user = User::firstOrCreate(
                        ['name' => "Dekan {$faculty->faculty_name}"],
                        [
                            'email' => strtolower(str_replace(' ', '.', $faculty->faculty_name)) . '@amiung.com',
                        ]
                    );

                    Faculty::create([
                        'faculty_name' => $faculty->faculty_name,
                        'is_deletable' => $faculty->is_deletable ?? true,
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
