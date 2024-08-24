<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Program;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProgramSeeder extends Seeder
{
    public function run(): void
    {
        $programs = [
            (object) [
                'department_name' => 'Teknik Informatika',
                'program_name' => 'Sistem Informasi'
            ],
            (object) [
                'department_name' => 'Teknik Informatika',
                'program_name' => 'Pendidikan Teknologi Informasi'
            ],
        ];

        foreach ($programs as $program) {
            try {
                DB::beginTransaction();

                $dataExists = Program::where('program_name', $program->program_name)->exists();

                if (!$dataExists) {
                    $user = User::firstOrCreate(
                        ['name' => "Ketua Program Studi {$program->program_name}"],
                        [
                            'email' => strtolower(str_replace(' ', '.', $program->program_name)) . '@amiung.com',
                        ]
                    );

                    $department = Department::where('department_name', $program->department_name)->first();

                    Program::create([
                        'program_name' => $program->program_name,
                        'is_deletable' => $program->is_deletable ?? true,
                        'user_id' => $user->id ?? null,
                        'department_id' => $department->id ?? null,
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
