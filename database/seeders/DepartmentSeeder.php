<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Faculty;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartmentSeeder extends Seeder
{
    public function run(): void
    {
        $departments = [
            (object) [
                'faculty_name' => 'Teknik',
                'department_name' => 'Teknik Informatika'
            ],
            (object) [
                'faculty_name' => 'Teknik',
                'department_name' => 'Teknik Elektro'
            ],
            (object) [
                'faculty_name' => 'Teknik',
                'department_name' => 'Teknik Industri'
            ],
            (object) [
                'faculty_name' => 'Teknik',
                'department_name' => 'Teknik Mesin'
            ]
        ];

        foreach ($departments as $department) {
            try {
                DB::beginTransaction();

                $dataExists = Department::where('department_name', $department->department_name)->exists();

                if (!$dataExists) {
                    // $user = User::firstOrCreate(
                    //     ['name' => "Ketua Jurusan {$department->department_name}"],
                    //     [
                    //         'email' => strtolower(str_replace(' ', '.', $department->department_name)) . '@amiung.com',
                    //     ]
                    // );

                    $faculty = Faculty::where('faculty_name', $department->faculty_name)->first();

                    Department::create([
                        'department_name' => $department->department_name,
                        'is_deletable' => $department->is_deletable ?? true,
                        // 'user_id' => $user->id ?? null,
                        'faculty_id' => $faculty->id ?? null,
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
